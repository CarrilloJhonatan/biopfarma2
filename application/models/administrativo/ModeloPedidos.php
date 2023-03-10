<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloPedidos extends CI_Model
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
        if($codcto != ""){
            $select ='SELECT factura.*, u.u_username  ';
            $from = ' FROM factura, tbl_usuarios u, tbl_usuarios tu  ';
            $where= " WHERE nitcli = u.u_nitter and factura.codcto = tu.codcto and tu.codcto = ".$codcto." and tu.u_tipo = 1 and pedidoestado between 0 and 2";
            $rest=$this->db->query($select.$from.$where);
            return $rest->result();
        }else{
            $select ='SELECT factura.*, u.u_username  ';
            $from = ' FROM factura, tbl_usuarios u, tbl_usuarios tu  ';
            $where= " WHERE nitcli = u.u_nitter  and  tu.u_tipo = 1 and pedidoestado between 0 and 2";
            $rest=$this->db->query($select.$from.$where);
            return $rest->result();
        }
       
       
    }

    function cancelpedido(){
        $numfac =  $this->input->post('numfac');
       
        $update = 'update factura SET pedidoestado = 3 WHERE numfac = '.$numfac;
        
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
        $numfac =  $this->input->post('numfac');
        $fecfac =  $this->input->post('fecfac');

        $select = "select tf.numfactura, tf.item, tf.valart, tf.totart, tf.qtyart, ta.codart, ta.nomart, f.mediopago, f.tipomediopago, f.reftrans, f.codtranferencia,tf.comentario, tu.u_username, f.direccion ";
        $from = 'FROM detallefactura tf, tbl_articulos ta, factura f, tbl_usuarios tu ';
        $where = "WHERE tf.codart = ta.codart and tf.numfactura = ".$numfac." and tf.numfactura = f.numfac and f.numfac = ".$numfac." and tu.u_nitter = f.nitcli and tf.fecha = '".$fecfac."'";
      
        $rest=$this->db->query($select.$from.$where);
        $result = $rest->result_array();

        return $result;


    }

   

   
}