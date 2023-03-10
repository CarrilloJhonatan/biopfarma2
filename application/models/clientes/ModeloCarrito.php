<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloCarrito extends CI_Model
{
    function getguardar()
    {
        
        $id         =   $this->input->post('id');
        $und        =   $this->input->post('und');
        $precio     =   $this->input->post('precio');
        $descuento =    $this->input->post('descuento');
        $resta  =       $this->input->post('resta');
        $preciobase = $this->input->post('preciobase');

        $fechaAct   =   date("Y-m-d h:i:s");;
        $total      =   $precio * $und;

        $usuario    =   $this->session->userdata('id_usuario');
        $nit        =  $this->session->userdata('nit_tusuario');
        $codpedido  =  $this->input->post('codpedido');

        $fecha      =   date("Y-m-d h:i:s");

        $listado = array();


        if($descuento == null){
            $descuento = "0";
        }
        if($resta == null){
            $resta = "0";
        }

       if($usuario !== ''){
        $data=array(
            'c_cliente'=>$usuario,
            'c_producto'=>$id,
            'c_und'=>$und,
            'c_undvalor'=>$precio,
            'c_descuento'=>$descuento,
            'c_precioDescuento'=>$resta,
            'c_totalvalor'=>$total,
            'c_fecha'=>$fechaAct,
            'c_pedido'     => $codpedido,
            'c_valorbase' => $preciobase
        );
       }
       else{
        $data=array(
            
            'c_producto'=>$id,
            'c_und'=>$und,
            'c_undvalor'=>$precio,
            'c_descuento'=>$descuento,
            'c_precioDescuento'=>$resta,
            'c_totalvalor'=>$total,
            'c_fecha'=>$fechaAct,
            'c_comentario' => $comentario,
            'c_pedido'     => $codpedido,
            'c_valorbase' => $preciobase
        );
       }
    
        $sql_query=$this->db->insert('tbl_carrito',$data);
    }

    function gettotal()
    {
        $usuario    =   $this->session->userdata('id_usuario');

        $this->db->select('SUM(c_und) AS total,SUM(c_totalvalor) AS totalsum, c_pedido');
        $this->db->from('tbl_carrito');
        $this->db->where('c_cliente',$usuario);
        $rest=$this->db->get();
        return $rest->result();
    }

    function gettodo()
    {

        $usuario    =   $this->session->userdata('id_usuario');

        
        $this->db->select('c.*,
                            a.imageurl,
                            a.valart,
                            a.nomart,
                           
                            ');
        $this->db->from('tbl_carrito c');
        $this->db->join('tbl_articulos a', 'a.codart  = c.c_producto');
        $this->db->where('c.c_cliente',$usuario);
        $this->db->order_by('c.c_fecha', 'DESC');
        $rest=$this->db->get();
        return $rest->result();
    }

    function geteliminar()
    {
        $fecha     =   $this->input->post('fecha');
        $articulo     =   $this->input->post('articulo');
        $total     =   $this->input->post('total');
        $usuario    =   $this->session->userdata('id_usuario');

        $this->db->where('c_fecha', $fecha)->where('c_producto', $articulo)->where('c_totalvalor', $total)->where('c_cliente', $usuario);
        $this->db->delete('tbl_carrito');
    }

   
}