<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloCategorias extends CI_Model
{
    function gettodo()
    {
        $this->db->select(' *,
                            (SELECT u_username FROM tbl_usuarios WHERE u_id = usuariomod) AS usuario,
                            DATE(fechamod) AS fecha ');
        $this->db->from('tbl_categorias');
        $this->db->where('estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    function getguardar()
    {
        $id             =   $this->input->post('id');
        $nomgru         =   $this->input->post('nomgru');
        $urlimg         =   $this->input->post('urlimg');

        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
            $this->db->select(' nomgru ');
            $this->db->from('tbl_categorias');
            $this->db->where('nomgru',$nomgru);
            $rest=$this->db->get();
        
            if($rest->num_rows()==1)
            {
                return 1;
            }
            else if($rest->num_rows()==0)
            {

                $data=array(
                    'codgru'=>'',
                    'nomgru'=>$nomgru,
                    'fechacrea'=>$fecha,
                    'fechamod'=>$fecha,
                    'usuariocrea'=>$usuario,
                    'usuariomod'=>$usuario,
                    'estado'=>1,
                );
            
                $sql_query=$this->db->insert('tbl_categorias',$data);

                $ultimoId = $this->db->insert_id();

                //insertar el codgru
                if($ultimoId < 10)
                {
                    $codgru = '00'.$ultimoId;
                }
                else if($ultimoId >= 10 && $ultimoId < 100)
                {
                    $codgru = '0'.$ultimoId;
                } 
                else if($ultimoId >= 100)
                {
                    $codgru = $ultimoId;
                }

                $data=array(
                    'codgru'=>$codgru,
                );
            
                $sql_query=$this->db->where('id', $ultimoId)->update('tbl_categorias', $data);

                //GUARDAR IMAGEN

                if(isset($_FILES["file"]['name'])){

                    $ruta = "asset/administrativo/imgcategoria/"; // la ruta
                    $nombreimagen = $_FILES["file"]['name'];

                    $info = new SplFileInfo($nombreimagen);
                    $valores = $info->getExtension();

                    $mi_archivo ='file';
                    $config['upload_path'] = $ruta;
                    $config['file_name'] =$ultimoId;
                    $config['allowed_types'] = "jpg|png|jpeg";
                    $config['max_size'] = 0;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload($mi_archivo)) {}

                    $imagen = $ruta.$ultimoId.".".$valores;
                    $imagennombre = $ultimoId.".".$valores;

                    $data1=array(
                        'img'=>$imagen,
                        'nombreimg'=>$imagennombre,
                    );
                
                    $sql_query=$this->db->where('id',$ultimoId)->update('tbl_categorias', $data1);
                }

                return 0;
            }
        }else{

            $data=array(
                'nomgru'=>$nomgru,
                'fechamod'=>$fecha,
                'usuariomod'=>$usuario,
            );
        
            $sql_query=$this->db->where('id', $id)->update('tbl_categorias', $data);

            if(isset($_FILES["file"]['name'])){

                $ruta = "asset/administrativo/imgcategoria/"; // la ruta
                $nombreimagen = $_FILES["file"]['name'];
                $rutavieja = $urlimg;
            
                $info = new SplFileInfo($nombreimagen);
                $valores = $info->getExtension();

                $mi_archivo ='file';
                $config['upload_path'] = $ruta;
                $config['file_name'] =$id;
                $config['allowed_types'] = "jpg|png|jpeg";
                $config['max_size'] = 0;
                $config['max_width'] = 0;
                $config['max_height'] = 0;

                $this->load->library('upload', $config);

                $exists = is_file( $rutavieja);//verifica si existe la imagen manda un 1 si existe

                if($exists == 1){

                    unlink($rutavieja);//borra la imagen si existe
        
                }
              
                if ($this->upload->do_upload($mi_archivo)) {}

                $imagen = $ruta.$id.".".$valores;
                $imagennombre = $id.".".$valores;

                $data1=array(
                    'img'=>$imagen,
                    'nombreimg'=>$imagennombre,
                );
            
                $sql_query=$this->db->where('id',$id)->update('tbl_categorias', $data1);
            }

            return 0;
        }
       
    }

    function geteliminar()
    {
        $id         =   $this->input->post('id');
        $nomgru     =   $this->input->post('nomgru');
        $usuario    =   $this->session->userdata('id_usuario');
        $fecha      =   date("Y-m-d h:i:s");

        
        $data=array(
            'fechamod'=>$fecha,
            'usuariomod'=>$usuario,
            'estado'=>2,
        );
    
        $sql_query=$this->db->where('id', $id)->update('tbl_categorias', $data);
    }

    function sincroCategorias(){
        $usuario = $this->session->userdata('id_usuario');  
        $cantidadArticuloss = $this->input->post('cantidadArticulos');
        $categorias = ApiRest::getCategorias($cantidadArticuloss);
        $sincroestado = 1;
        $fecha      =   date("Y-m-d h:i:s");
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        foreach ($categorias as $key => $value) {
            $codgru = $value['codgru'];
            $data=array(
                'codgru'=>$value['codgru'],
                'nomgru'=>$value['nomgru'],
               // 'img'=>$value['img'],
                //'nombreimg'=>$value['nombreimg'],
                'fechacrea'=>$fecha,
                'fechamod'=>$fecha,
                'usuariocrea'=>$usuario,
                'usuariomod'=>$usuario,
                'sincroestado'=>1,
                'estado'=>1,
            );

            $dataupdate=array(
                'codgru'=>$value['codgru'],
                'nomgru'=>$value['nomgru'],
               // 'img'=>$value['img'],
                //'nombreimg'=>$value['nombreimg'],
                'fechacrea'=>$fecha,
                'fechamod'=>$fecha,
                'usuariocrea'=>$usuario,
                'usuariomod'=>$usuario,
                'sincroestado'=>1,
                'estado'=>1,
            );

            $this->db->select(' codgru ');
            $this->db->from('tbl_categorias');
            $this->db->where('codgru',$codgru);
            $rest=$this->db->get();

            $rows = $rest->num_rows();
            
            if($rows === 0){
                $sql_query=$this->db->insert('tbl_categorias',$data);
                if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                $sql_query=$this->db->where('codgru',$codgru)->update('tbl_categorias', $dataupdate);
                if($sql_query){
                    $cont++;
                }
            }

            if(count($categorias) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
                return $result;
            }
             
        }

        return $result;

    }
}