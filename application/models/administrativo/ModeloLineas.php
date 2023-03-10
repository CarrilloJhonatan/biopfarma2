<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloLineas extends CI_Model
{
    function gettodo()
    {
        $select = "SELECT ts.*,"."tc.nomgru as categoria";
        $from =  "FROM tbl_subcategorias ts, tbl_categorias tc";
        $where = "WHERE ts.codgru = tc.codgru";
        $rest=$this->db->query($select." ".$from." ".$where);
        
        return $rest->result();
    }

    function getguardar()
    {
        $id         =   $this->input->post('id');
        $categoria  =   $this->input->post('categoria');
        $codsubcate =   $this->input->post('codsubcate');
        $nomsubcate =   $this->input->post('nomsubcate');

        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
            $this->db->select(' codgru ');
            $this->db->from('tbl_subcategorias');
            $this->db->where('codsubcate',$codsubcate);
            $rest=$this->db->get();
        
            if($rest->num_rows()==1)
            {
                return 1;
            }
            else if($rest->num_rows()==0)
            {

                $data=array(
                    'codsubcate'=>$codsubcate,
                    'nomsubcate'=>$nomsubcate,
                    'codgru'=>$categoria,
                );
            
                $sql_query=$this->db->insert('tbl_subcategorias',$data);

                return 0;
            }
        }else{

            $data=array(
                //'codsubcate'=>$codsubcate,
                'nomsubcate'=>$nomsubcate,
                //'codgru'=>$categoria,
            );
        
            $sql_query=$this->db->where('codsubcate', $codsubcate)->update('tbl_subcategorias', $data);

            return 0;
        }
       
    }

    function geteliminar()
    {
        $codsubcate =   $this->input->post('codsubcate');
        $usuario    =   $this->session->userdata('id_usuario');
        $fecha      =   date("Y-m-d h:i:s");

        $this->db->where('codsubcate', $codsubcate);
        $this->db->delete('tbl_subcategorias');
    }

    function sincroSubcategorias(){

        $subcategorias= ApiRest::getSubcategorias();
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        foreach ($subcategorias as $key => $value) {
            $codsubcate = $value['codsubcate'];
            $data = array(
                'codsubcate'=>$value['codsubcate'],
                'nomsubcate'=>$value['nomsubcate'],
                'codgru'    =>$value['codgru'],
                'sincroestado'=>1
            );

            $dataupdate = array(
                'codsubcate'=>$value['codsubcate'],
                'nomsubcate'=>$value['nomsubcate'],
                'codgru'    =>$value['codgru'],
                'sincroestado'=>1
            );

            $this->db->select(' codsubcate ');
            $this->db->from('tbl_subcategorias');
            $this->db->where('codsubcate',$codsubcate);
            $rest=$this->db->get();

            $rows = $rest->num_rows();
            
            if($rows === 0){
                $sql_query=$this->db->insert('tbl_subcategorias',$data);
               if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                $sql_query=$this->db->where('codsubcate',$codsubcate)->update('tbl_subcategorias', $dataupdate);
                if($sql_query){
                    $cont++;
                }
            }
            

            if(count($subcategorias) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
                return $result;
            }
             
        }

        return $result;

    }
}