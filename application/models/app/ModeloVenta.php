<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloVenta extends CI_Model
{
    function getguardar()
    {
        $formapago  =   $this->input->post('formapago');
        $direccion  =   $this->input->post('direccion');
        $telefono   =   $this->input->post('telefono');
        $codpedido  =   $this->input->post('codpedido');
        $codprom    =   $this->input->post('codprom');
        $comentario =   $this->input->post('comentario');
        $usuario    =   $this->session->userdata('id_usuario');
        $username   =   $this->session->userdata('nombre_usuario');
        $nit        =   $this->session->userdata('nit_tusuario');
        $correo     =   $this->session->userdata('correo');

        $fecha      =   date("Y-m-d h:i:s");
        $vtotal     =   0;
        $descuento  =   0;
        if($codprom != ''){
            $this->db->select('valor');
        $this->db->from('cod_promocion');
        $this->db->where('codigo',$codprom);
        $this->db->where('estado',0);
        $desc = $this->db->get();
        
        foreach($desc->result() as $row){
            $descuento = $row->valor;
        }
        }

        if($formapago === 'EC'){
            $estado = 1;
        }
        else{
            $estado = 2;
        }

        /**GUARDAR FACTURA */
        $data2=array(
            'codcto'=>'001',
            'tipfac'=>'TV',
            'numfac'=>'',
            'fecfac'=>$fecha,
            'mediopago'=>$formapago,
            'valfac'=>$vtotal,
            'descfac'=>$descuento,
            'netfac'=>$vtotal-0,
            'Detalle'=>'',
            'nitcli'=>$nit,
            'estado'=>$estado,
            'direccion' =>$direccion,
            'codpedido'=>$codpedido,
            'comentario'=>$comentario,
            'codprom'=>$codprom,
        );
    
        $sql_query=$this->db->insert('factura',$data2);
        $ultimoId = $this->db->insert_id();


        /**GUARDAR ITEM DE FACTURAS */
        $numitem = 1;
        $this->db->select(' * ');
        $this->db->from('tbl_carrito');
        $this->db->where('c_cliente',$usuario);
        $rest=$this->db->get();

        foreach ($rest->result() as $row) {

            $vtotal = $vtotal + $row->c_totalvalor;

            $codart = $row->c_producto;
            $valart = $row->c_undvalor;
            $qtyart = $row->c_und;
            $row_c_fecha = $row->c_fecha;
            $comentario  = $row->c_comentario;
            $codpedido   = $row->c_pedido;

            $data1=array(
                'tipofactura'=>'TV',
                'numfactura'=>$ultimoId,
                'item'=>$numitem,
                'codcto'=>'001',
                'codart'=>$codart,
                'valart'=>$valart,
                'qtyart'=>$qtyart,
                'totart'=>$valart * $qtyart,
                'descart'=>0,
                'estado'=>$estado,
                'fecha'=>$fecha,
                'comentario'=>$comentario,
                
            );
        
            $sql_query=$this->db->insert('detallefactura',$data1);

             /**GUARDAR ITEM DE FACTURAS */
            $this->db->select(' * ');
            $this->db->from('detallevariantecarrito');
            $this->db->where('dv_cliente',$usuario);
            $this->db->where('dv_articulo',$codart);
            $this->db->where('dv_fecha',$row_c_fecha);
            $rest2=$this->db->get();
            
            foreach ($rest2->result() as $row2) {
               
                $row2_dv_variante = $row2->dv_variante;

                $data4=array(
                    'dv_item'=>$numitem,
                    'dv_fact'=>$ultimoId,
                    'dv_articulo'=>$codart,
                    'dv_variante'=>$row2_dv_variante,
                    'dv_cliente'=>$nit,
                    'dv_fecha'=>$fecha,
                    'dv_estado'=>1,
                );
            
                $sql_query=$this->db->insert('detallevariantefactura',$data4);
            }
            $numitem++;
        }

        /**SALVAR VENTA EN GLOBALSOFT BD */
        $select ="select codart, numfactura, valart, descart, qtyart";
        $from = " from detallefactura ";
        $where = "where codart = '".$codart."' and fecha = '".$fecha."'";
        
        $query = $this->db->query($select.$from.$where);

        $select2 ="select numfactura, codart, valart, descart, qtyart, dv_variante";
        $from2 = " from detallefactura, detallevariantefactura ";
        $where2 = "where codart = '".$codart."' and dv_fecha = '".$fecha."' and fecha = dv_fecha and codart = dv_articulo and numfactura = dv_fact";
        
        $query2 = $this->db->query($select2.$from2.$where2);
        
        

        $arrayDetalle = array();
        $numfactura = array();
        foreach($query->result() as $row){
             $codart = $row->codart;  
             $numfactura = $row->numfactura; 
            $arrayVariantes = array();

            foreach($query2->result() as $rows){
                $variantes['codins'] = $rows->dv_variante;
                $variantes['qtyart'] = 1;
                
                if($rows->codart == $codart){
                    array_push($arrayVariantes, $variantes);
                }    
                
            }
                
                    $data = array(
                        'codart' => $row->codart,
                        'valart' => $row->valart,
                        'descart'=> $row->descart,
                        'qtyart' => $row->qtyart,
                        'variante'=>$arrayVariantes
                    );

                array_push($arrayDetalle,$data);
        }
        

        
        $cont = 0;
      /*  foreach($query->result() as $row1){
            $codart = $row1->codart;

            if($codart === $arrayDetalle[$cont]['codart']){
                $arrayDetalle[$cont]['variante']=$arrayVariantes;
                $cont++;   
            }

        }
        */ 
        //codcto debe ser extraido de una variable session
        $ArraySaveInv= array(
            'codcto'=>'001',
            'numfac'=>$numfactura,
            'fecfac'=>$fecha,
            'valfac'=>$vtotal,
            'pago'=>[
                'codigo'=>$formapago,
                'valorpago'=>$vtotal,
                'autorizacion'=>'WERTDSWER', //valor provicional cambiar por valor verdadero
                'moneda'=>'COP'
            ],
            'clientes'=>[
                'u_nitter'=>$nit,
                'u_username'=>$usuario,
                'u_nombre1'=>$username,     //extraer valor de la base de datos
                'u_apellido1'=>'N/A',   // extraer valor de la base de datos
                'u_telefono'=>$telefono,
                'u_direccion'=>$direccion,
                'u_email'=>$correo, // extraer valor de la base de datos
                'u_provincia'=>'20',
                'u_ciudad'=>'001',          //provicional extraer de BD
                'u_pais'=>'169'
            ],
            'detalle'=>$arrayDetalle

        );
        
       // $json_string = json_encode($ArraySaveInv);
       // $file = 'saveinvoice.json';
       // file_put_contents($file,$json_string);
        
        $apirest  = self::salvarVenta($ArraySaveInv);
        
        if($apirest){   
            $update = 'update factura SET estadoenviar = 1 WHERE numfac = '.$ultimoId;
            $sql    = $this->db->query($update);

            //echo "resultado: ".$sql;

        }

        /**AGREGAR NUMFACT AUTOINCREMENTABLE */
        $data3=array(
            'numfac'=>$ultimoId,
            'valfac'=>$vtotal,
        );
    
        $sql_query=$this->db->where('id',$ultimoId)->update('factura', $data3);

        /** ELIMINAR CARRITO DE COMPRA */
        $this->db->where('c_cliente', $usuario);
        $this->db->delete('tbl_carrito');

        /** ELIMINAR detallevariantecarrito */
        $this->db->where('dv_cliente', $usuario);
        $this->db->delete('detallevariantecarrito');

       /**api de factura */
        /*
       $curl = curl_init();
       $auth_data =  array(
           "idemp"   => '001',
           "codcto"  => '001',
           "tipfac"  => 'TV',
           "numfac"  => $ultimoId,
           "valfac"  => $vtotal,
           "netfac"  => $vtotal,
           "nitcli"  => $nit,
       );
       curl_setopt($curl, CURLOPT_POST, 1);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
       curl_setopt($curl, CURLOPT_URL, 'http://3.18.34.105:8080/apiGlobal/public/api/saveFactura');
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       $result = curl_exec($curl);
       if(!$result){die("Connection Failure");}
       curl_close($curl);
     
      /**api de detalle factura */

        return $apirest;
    }

    function salvarVenta($array){
        $apirest=ApiRest::requestAPISaveInvoices($array);
        return $apirest;
    }

    function getapidetallefactura()
    {
        $numfac    =   $this->input->post('numfac');
        $tipfac    =   $this->input->post('tipfac');

        $this->db->select(' * ');
        $this->db->from('detallefactura');
        $this->db->where('tipofactura',$tipfac);
        $this->db->where('numfactura',$numfac);
        $rest=$this->db->get();
        return $rest->result();

    }

    function guardarComentario(){

        $comentario    =   $this->input->post('comentario');
        $codpedido    =   $this->input->post('codpedido');
        
        $this->db->where('c_pedido', $codpedido);
        $this->db->set('c_comentario', $comentario);

        return $this->db->update('tbl_carrito');

    }
   
}