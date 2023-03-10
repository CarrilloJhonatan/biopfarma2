<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloPromo extends CI_Model
{
    function gettodo()
    {
		$usuario = $this->session->userdata('id_usuario');
        $select1 ='SELECT *';
        $from1 = ' FROM tbl_usuarios';
        $where1= " WHERE u_id = $usuario";
        $rest1=$this->db->query($select1.$from1.$where1);
        $data = $rest1->result_array();
        $codcto ='';
        foreach($data as $user){
            $codcto = $user['codcto'];
        }
        
        //$this->db->select(' * ');
        //$this->db->from('factura');
        //$this->db->where('estado',1);
        //$rest=$this->db->get();
        $select ='SELECT *';
        $from = ' FROM headpromo';
        $where= " WHERE codcto = ".$codcto."";
        $where1= " AND estado != 'A'";
        $rest=$this->db->query($select.$from.$where.$where1);
        return $rest->result();
    }

    function cancelpedido(){
        $numero =  $this->input->post('numfac');
       
        $update = 'update headpromo SET estado = "A" WHERE numero = '.$numero;
        
        $rest   = $this->db->query($update);
        
        return $rest;

    }

    function getDetalle(){
        
        $numfac =  $this->input->post('numfac');
        $fecfac =  $this->input->post('fecfac');
        $select = 'SELECT detallevariantefactura.*, detallefactura.* ';
        $from   = 'FROM detallevariantefactura, detallefactura ';
        $where  = "WHERE numfactura = ".$numfac."  AND fecha = '".$fecfac."' AND numfactura = dv_fact AND fecha = dv_fecha and codart = dv_articulo";
        
        $rest=$this->db->query($select.$from.$where);

        $select2 = 'select ta.codart, ta.nomart, tv.codartvar, tv.nomvar, tv.nomartvar ';
        $from2   = 'from tbl_variante tv, tbl_articulos ta ';
        $where2  = 'WHERE ta.codart COLLATE utf8_general_ci = tv.codart COLLATE utf8_general_ci';

        $rest2=$this->db->query($select2.$from2.$where2);
        $resultado = array(
            'detalle'=> $rest->result(),
            'variante'=> $rest2->result()
        );

        return $resultado;


    }

    function getDetalleResumen(){
        $usuario = $this->session->userdata('id_usuario');
        $select1 ='SELECT *';
        $from1 = ' FROM tbl_usuarios';
        $where1= " WHERE u_id = $usuario";
        $rest1=$this->db->query($select1.$from1.$where1);
        $data = $rest1->result_array();
        $codcto ='';
        foreach($data as $user){
            $codcto = $user['codcto'];
            
        }
        $numero =  $this->input->post('numero');
        

        $select = 'SELECT  * ';
        $from = 'FROM detpromo p ';
        $join= 'inner join tbl_articulos a on (a.codart = p.codart)';
        $where = "WHERE p.codcto = ".$codcto."";
        $where = "WHERE p.numero = ".$numero."";
        
      
        $rest=$this->db->query($select.$from.$join.$where);
        $result = $rest->result_array();

        return $result;


    }

   

   
}