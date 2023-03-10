<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloPromociones extends CI_Model
{
    function gettodo()
    {
        $this->db->select(' p.*,
                            t.t_nombre,
                            IF(p.p_tbl=2,(SELECT nomart FROM tbl_articulos WHERE id = p.p_elegido),(SELECT nomgru FROM tbl_categorias WHERE id = p.p_elegido)) AS descripcion,
                            DATE(p_fechamod) AS fecha
                             ');
        $this->db->from('tbl_promociones p');
        $this->db->join('tbl_tabla t', 't.t_id  = p.p_tbl');
        $this->db->where('p.p_estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    function gettbl()
    {
        $searchTerm = $this->input->post('searchTerm');

        // Fetch users
        $this->db->select('t_id ,t_nombre');
        $this->db->where("t_nombre like '%".$searchTerm."%' and t_id != 3 ");
        $fetched_records = $this->db->get('tbl_tabla');
        $users = $fetched_records->result_array();
 
        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['t_id'], "text"=>$user['t_nombre']);
        }
        return $data;
    }

    function gettblCod()
    {
        $searchTerm = $this->input->post('searchTerm');

        // Fetch users
        $this->db->select('t_id ,t_nombre');
        $this->db->where("t_nombre like '%".$searchTerm."%' and t_id = 2 ");
        $fetched_records = $this->db->get('tbl_tabla');
        $users = $fetched_records->result_array();
 
        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['t_id'], "text"=>$user['t_nombre']);
        }
        return $data;
    }

    function getelegidoCod()
    {
        $searchTerm = $this->input->post('searchTerm');
        $elegido = $this->input->post('elegido');

        if($elegido == 1){
             // Fetch users
            $this->db->select('id ,nomgru');
            $this->db->where("nomgru like '%".$searchTerm."%' ");
            $this->db->where("estado",1);
            $fetched_records = $this->db->get('tbl_categorias');
            $users = $fetched_records->result_array();
    
            // Initialize Array with fetched data
            $data = array();
            foreach($users as $user){
                $data[] = array("id"=>$user['id'], "text"=>$user['nomgru']);
            }
            return $data;

        }else if($elegido == 2){
            // Fetch users
           $this->db->select('id ,nomart');
           $this->db->where("nomart like '%".$searchTerm."%' ");
           $this->db->where("estado",1);
           $this->db->limit(4);
           $fetched_records = $this->db->get('tbl_articulos');
           $users = $fetched_records->result_array();
   
           // Initialize Array with fetched data
           $data = array();
           foreach($users as $user){
               $data[] = array("id"=>$user['id'], "text"=>$user['nomart']);
           }
           return $data;
       }else if($elegido == 3){
        // Fetch users
       $this->db->select('codsubcate ,nomsubcate');
       $this->db->where("nomsubcate like '%".$searchTerm."%' ");
       $this->db->limit(4);
       $fetched_records = $this->db->get('tbl_subcategorias');
       $users = $fetched_records->result_array();

       // Initialize Array with fetched data
       $data = array();
       foreach($users as $user){
           $data[] = array("id"=>$user['codsubcate'], "text"=>$user['nomsubcate']);
       }
       return $data;
   }
       
    }

    function getelegido()
    {
        $searchTerm = $this->input->post('searchTerm');
        $elegido = $this->input->post('elegido');

        if($elegido == 1){
             // Fetch users
            $this->db->select('id ,nomgru');
            $this->db->where("nomgru like '%".$searchTerm."%' ");
            $this->db->where("estado",1);
            $fetched_records = $this->db->get('tbl_categorias');
            $users = $fetched_records->result_array();
    
            // Initialize Array with fetched data
            $data = array();
            foreach($users as $user){
                $data[] = array("id"=>$user['id'], "text"=>$user['nomgru']);
            }
            return $data;

        }else if($elegido == 2){
            // Fetch users
           $this->db->select('id ,nomart');
           $this->db->where("nomart like '%".$searchTerm."%' ");
           $this->db->where("estado",1);
           $this->db->limit(4);
           $fetched_records = $this->db->get('tbl_articulos');
           $users = $fetched_records->result_array();
   
           // Initialize Array with fetched data
           $data = array();
           foreach($users as $user){
               $data[] = array("id"=>$user['id'], "text"=>$user['nomart']);
           }
           return $data;
       }else if ($elegido == 4){
        
       $data = array();
       $data[] = array("id"=>1, "text"=>"Default");
        return $data;
    }
else if($elegido == 5){
    $data = array();
    $data[] = array("id"=>1, "text"=>"Default");
     return $data;
}else if($elegido ==6){
    
    $data = array();
    $data[] = array("id"=>1, "text"=>"Default");
     return $data;
}
   
       
    }

    function getguardar()
    {
        $id             =   $this->input->post('id');
        $urlimg         =   $this->input->post('urlimg');
        $tbl            =   $this->input->post('tbl');
        $elegido        =   $this->input->post('elegido');
       
      
        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
          
            $data=array(
                'p_img'=>'',
                'p_nomimg'=>'',
                'p_tbl'=>$tbl,
                'p_elegido'=>$elegido,
                
                'p_usuariocrea'=>$usuario,
                'p_usuariomod'=>$usuario,
                'p_fechacrea'=>$fecha,
                'p_fechamod'=>$fecha,
                'p_estado'=>1,
                   
            );
            
            $sql_query=$this->db->insert('tbl_promociones',$data);

            $ultimoId = $this->db->insert_id();

            if($_FILES["file"]['name']!= "" ){

                $ruta = "asset/administrativo/imgpromociones/"; // la ruta
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
                    'p_img'=>$imagen,
                    'p_nomimg'=>$imagennombre,
                );
                
                $sql_query=$this->db->where('p_id',$ultimoId)->update('tbl_promociones', $data1);
            }

            return 0;
            
        }else{

            $data=array(

                'p_img'=>'',
                'p_nomimg'=>'',
                'p_tbl'=>$tbl,
                'p_elegido'=>$elegido,
               
                'p_usuariomod'=>$usuario,
                'p_fechamod'=>$fecha,
            );
        
            $sql_query=$this->db->where('p_id',$id)->update('tbl_promociones', $data);

            if($_FILES["file"]['name']!= "" ){

                $ruta = "asset/administrativo/imgpromociones/"; // la ruta
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
                    'p_img'=>$imagen,
                    'p_nomimg'=>$imagennombre,
                );
            
                $sql_query=$this->db->where('p_id',$id)->update('tbl_promociones', $data1);
            }

            return 0;
        }
       
    }

    function geteliminar()
    {
        $id         =   $this->input->post('id');
        $usuario    =   $this->session->userdata('id_usuario');
        $fecha      =   date("Y-m-d h:i:s");

        
        $data=array(
            'p_fechamod'=>$fecha,
            'p_usuariomod'=>$usuario,
            'p_estado'=>2,
        );
    
        $sql_query=$this->db->where('p_id',$id)->update('tbl_promociones', $data);
    }

    function geteliminarCod()
    {
        $id         =   $this->input->post('id');
        $usuario    =   $this->session->userdata('id_usuario');
        $fecha      =   date("Y-m-d h:i:s");

        
        $data=array(
            'estado'=>1,
        );
    
        $sql_query=$this->db->where('id',$id)->update('cod_promocion', $data);
    }

    function getcodigo(){
        
        $this->db->select(' c.*, t.t_nombre, IF(c.t_id=2,
        (SELECT nomart FROM tbl_articulos WHERE id = c.elegido), 
        IF(c.t_id = 1, (SELECT nomgru FROM tbl_categorias WHERE id = c.elegido),
        (SELECT nomsubcate FROM tbl_subcategorias WHERE codsubcate = c.elegidosub))) 
        AS descripcion
                             ');
        $this->db->from('cod_promocion c');
        $this->db->join('tbl_tabla t', 't.t_id  = c.t_id');
        $this->db->where('c.estado',0);
        $rest=$this->db->get();
        return $rest->result();
    
    }

    function getguardarCod()
    {
        $id             =   $this->input->post('id');
        $tbl            =   $this->input->post('tbl');
        $elegido        =   $this->input->post('elegido');
        $valor          =   $this->input->post('valor');
        $fechainicio    =   $this->input->post('fechainicio');
        $fechafinal     =   $this->input->post('fechafinal');
        $horainicio     =   $this->input->post('horainicio');
        $horafinal      =   $this->input->post('horafinal');
        $codigo         =   $this->input->post('codigo');
      
        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
          
            $data=array(
               
                't_id'=>$tbl,
                'elegido'=>$elegido,
                'elegidosub'=>$elegido,
                'valor'=>$valor,
                'fecha_inicio'=>$fechainicio,
                'fecha_final'=>$fechafinal,
                'hora_inicio'=>$horainicio,
                'hora_final'=>$horafinal,
                'codigo'=>$codigo,
               
                   
            );
            
            $sql_query=$this->db->insert('cod_promocion',$data);

            $ultimoId = $this->db->insert_id();

            

            return 0;
            
        }else{

            $data=array(
               
                't_id'=>$tbl,
                'elegido'=>$elegido,
                'elegidosub'=>$elegido,
                'valor'=>$valor,
                'fecha_inicio'=>$fechainicio,
                'fecha_final'=>$fechafinal,
                'hora_inicio'=>$horainicio,
                'hora_final'=>$horafinal,
                'codigo'=>$codigo,
               
                   
            );
        
            $sql_query=$this->db->where('id',$id)->update('cod_promocion', $data);

            

            return 0;
        }
       
    }
}