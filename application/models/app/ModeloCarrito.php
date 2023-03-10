<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloCarrito extends CI_Model
{
    function getguardar()
    {
        $id         =   $this->input->post('id');
        $und        =   $this->input->post('und');
        $precio     =   $this->input->post('precio');
        $fechaAct   =  $this->input->post('fechaAct');
        $total      =   $precio * $und;

        $usuario    =   $this->session->userdata('id_usuario');
        $nit        =  $this->session->userdata('nit_tusuario');
        $codpedido  =  $this->input->post('codpedido');
        $fecha      =   date("Y-m-d h:i:s");

       if($usuario !== ''){
        $data=array(
            'c_cliente'=>$usuario,
            'c_producto'=>$id,
            'c_und'=>$und,
            'c_undvalor'=>$precio,
            'c_totalvalor'=>$total,
            'c_fecha'=>$fechaAct,
            'c_pedido'     => $codpedido
        );
       }
       else{
        $data=array(
            
            'c_producto'=>$id,
            'c_und'=>$und,
            'c_undvalor'=>$precio,
            'c_totalvalor'=>$total,
            'c_fecha'=>$fechaAct,
            'c_comentario' => $comentario,
            'c_pedido'     => $codpedido
        );
       }
    
        $sql_query=$this->db->insert('tbl_carrito',$data);
    }

    function gettotal()
    {
        $usuario    =   $this->session->userdata('id_usuario');

        $codpedido =    $this->input->post('codpedido');

        $this->db->select('SUM(c_und) AS total,SUM(c_totalvalor) AS totalsum');
        $this->db->from('tbl_carrito');

        if($usuario !== null){
            $this->db->where('c_cliente',$usuario);
        }else{
            $this->db->where('c_pedido',$codpedido);
        }
        
        $rest=$this->db->get();
        return $rest->result();
    }

    function gettodo()
    {
        $usuario    =   $this->session->userdata('id_usuario');

        
        $this->db->select('c.*,
                            a.imageurl,
                            a.valart,
                            a.nomart
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
        $articulo  =   $this->input->post('articulo');
        $total     =   $this->input->post('total');
        $usuario   =   $this->session->userdata('id_usuario');

        $this->db->where('c_fecha', $fecha)->where('c_producto', $articulo)->where('c_totalvalor', $total)->where('c_cliente', $usuario);
        $this->db->delete('tbl_carrito');

        $this->db->where('dv_fecha', $fecha)->where('dv_articulo', $articulo)->where('dv_cliente', $usuario);
        $this->db->delete('detallevariantecarrito');
    }

    function getguardarvariante()
    {
        /**DECLARACION DE VARIABLES */
        $dv_articulo =  $this->input->post('id');
        $dv_variante =  $this->input->post('variante');
        $nit         =  $this->session->userdata('nit_tusuario');
        $usuario     =   $this->session->userdata('id_usuario');
        $fechaAct    =  $this->input->post('fechaAct');
        $codpedido    =  $this->input->post('codpedido');
        $fecha       =  date("Y-m-d h:i:s");

        
        /**SE LLAMA LA TABLA LA TABLA DETALLE VARIANTE EL ULTIMO ITEM REGISTRADO DE CARRITO DE COMPRA */
        $this->db->select(' dv_item , dv_fecha');
        $this->db->from('detallevariantecarrito');
        $this->db->where('dv_cliente',$usuario);
        $this->db->order_by('dv_item','DESC');
        $this->db->limit(1);
        $rest1=$this->db->get();

        if($rest1->num_rows()==0)
        {
            /**SI NO HAY REGISTRO COMIENZA ITEM CON 1 */
            if($usuario !== ''){
                $data1=array(
                    'dv_item'=>1,
                    'dv_fact'=>'',
                    'dv_articulo'=>$dv_articulo,
                    'dv_variante'=>$dv_variante,
                    'dv_cliente'=>$usuario,
                    'dv_fecha'=>$fechaAct,
                    'dv_estado'=>1,
                    'dv_pedido' => $codpedido
                );
            }else{
                $data1=array(
                    'dv_item'=>1,
                    'dv_fact'=>'',
                    'dv_articulo'=>$dv_articulo,
                    'dv_variante'=>$dv_variante,
                    'dv_fecha'=>$fechaAct,
                    'dv_estado'=>1,
                    'dv_pedido' => $codpedido
                );
            }
        
            $sql_query=$this->db->insert('detallevariantecarrito',$data1);
        }
        else
        {   
            /**SI HAY REGISTRO */
            foreach ($rest1->result() as $row1) 
            {
                /**SE TOMA LA FECHA DE GUARDADO DE EL ULTIMO REGISTRO Y SE GUADARA EN UNA VARIABLE */
                $fecha_row1 = $row1->dv_fecha;

                if($fecha_row1 === $fechaAct)
                {
                    /**SI LAS FECHAS SON IGUALES NO INCREMENTA EL ITEM */
                    $item = $row1->dv_item;
                }

                if($fecha_row1 != $fechaAct)
                {
                    /**SI LAS FECHAS SON DIFERENTES SI INCREMENTA EL ITEM */
                    $item = $row1->dv_item + 1;
                }
               
            }
                /**SE GUARDA TODO EN LA TABLA DETALLE VARIANTE CON ESTADO UNO Q SIGNIFICA EN CARRITO DE COMPRA
                 * Y SIN EL NUMERO DE FACTURA 
                 */
                if($usuario !== ''){
                    $data1=array(
                        'dv_item'=>$item,
                        'dv_fact'=>'',
                        'dv_articulo'=>$dv_articulo,
                        'dv_variante'=>$dv_variante,
                        'dv_cliente'=>$usuario,
                        'dv_fecha'=>$fechaAct,
                        'dv_estado'=>1,
                        'dv_pedido' => $codpedido
                    );
                }else{
                    $data1=array(
                        'dv_item'=>$item,
                        'dv_fact'=>'',
                        'dv_articulo'=>$dv_articulo,
                        'dv_variante'=>$dv_variante,
                        'dv_fecha'=>$fechaAct,
                        'dv_estado'=>1,
                        'dv_pedido' => $codpedido
                    );
                }
            
                $sql_query=$this->db->insert('detallevariantecarrito',$data1);
            
        }
        
    }
}