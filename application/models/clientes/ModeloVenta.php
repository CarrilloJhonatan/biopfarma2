<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloVenta extends CI_Model
{
    function getguardar()
    {
        $formapago  =   $this->input->post('formapago');
        $reftrans  =   $this->input->post('reftrans');
        $codtranferencia = $this->input->post('codtranferencia');
        $direccion  =   $this->input->post('direccion');
        $telefono   =   $this->input->post('telefono');
        $codpedido  =   $this->input->post('codpedido');
        $codprom    =   $this->input->post('codprom');
        $comentario =   $this->input->post('comentario');
        $tipoformapago =   $this->input->post('tipoformapago');
        $usuario    =   $this->session->userdata('id_usuario');
        $username   =   $this->session->userdata('nombre_usuario');
        $nit        =   $this->session->userdata('nit_tusuario');
        $correo     =   $this->session->userdata('correo');
		$codalmm    =   $this->input->post('codalmm');
        // $descuentos =    $this->input->post('descuento');
        // $preciodescuento =    $this->input->post('resta');
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
            'codcto'=>$codalmm,
            'tipfac'=>'TV',
            'numfac'=>'',
            'fecfac'=>$fecha,
            'mediopago'=>$formapago,
            'tipomediopago'=>$tipoformapago,
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
            'codtranferencia'=>$codtranferencia,
            'reftrans'=>$reftrans,
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
            $valart = $row->c_valorbase;
            $qtyart = $row->c_und;
            $descuentos = $row-> c_descuento;
            $row_c_fecha = $row->c_fecha;
            $comentario  = $row->c_comentario;
            $codpedido   = $row->c_pedido;

            $data1=array(
                'tipofactura'=>'TV',
                'numfactura'=>$ultimoId,
                'item'=>$numitem,
                'codcto'=>$codalmm,
                'codart'=>$codart,
                'valart'=>$valart,
                'qtyart'=>$qtyart,
                'totart'=>$valart * $qtyart,
                'descart'=>$descuentos,
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
     

        /**AGREGAR NUMFACT AUTOINCREMENTABLE */
        $data3=array(
            'numfac'=>$ultimoId,
            'valfac'=>$vtotal,
        );
    
        $sql_query=$this->db->where('id',$ultimoId)->update('factura', $data3);
		$send = self::send($ultimoId,$nit);
        /** ELIMINAR CARRITO DE COMPRA */
        $this->db->where('c_cliente', $usuario);
        $this->db->delete('tbl_carrito');

        /** ELIMINAR detallevariantecarrito */
        $this->db->where('dv_cliente', $usuario);
        $this->db->delete('detallevariantecarrito');


        /**SALVAR VENTA EN GLOBALSOFT BD */
        $comprador = self::GetDetComprador($nit);
        $pago = self::GetPago($formapago, $ultimoId);
        $direccionEnvio = self::GetEntrega($ultimoId);
        $lineas = self::getLineasVenta($ultimoId);
        $entrega = array(
            'tipo' => $direccion == "RETIRO"? $direccion : "ENVIO", 
            'local' => $codalmm,
            'direccionEnvio' => $direccionEnvio
        );
        $arraySave = array(
			'codcto' => $codalmm,
            'idOrden' => $ultimoId,
            'estado' => 'APROBADO', //Establecido asi para pruebas, cambiar estado
            'fechaInicio' => $fecha,
            'comprador' => $comprador,
            'moneda' => 'COP',
            'pago' => $pago,
            'entrega' => $entrega,
            'importeTotal' => $vtotal,
            'lineas' => $lineas
        );

        //echo json_encode($arraySave);
        $result = self::salvarVenta($arraySave);
       //var_dump($result);
        $data4=array(
            'reftrans'=>$result['data']['referencia']
        );
        $sql_query=$this->db->where('id',$ultimoId)->update('factura', $data4);
        //echo json_encode($resultado);
       // var_dump($data4);

        return $result;
       // return $apirest;
    }

    function getLineasVenta($numfac){
        $descuentos =    $this->input->post('descuento');
        $preciodescuento =    $this->input->post('preciodescuento');

        $this->db->select(' * ');
        $this->db->from('detallefactura');
        $this->db->where('numfactura',$numfac);
        $rest2=$this->db->get();
        $arrayresult = array();
        $arraydescuento = array();
        $arraydescuento1 = array();
        
        foreach ($rest2->result() as $row2) {
            
            $this->db->select('*');
            $this->db->from('tbl_articulos');
            $this->db->where('codart',$row2->codart);
            $art=$this->db->get();
            $price = $art->Result();

            $promocionporcentaje = new stdClass();
            $arraydescuento = array();
            $promocionporcentaje->nombre=null;
            $promocionporcentaje->codigo=$row2->descart;
            $promocionporcentaje->origen=null;
            $promocionporcentaje->monto=$price[0]->valart * ($row2->descart / 100);
            array_push($arraydescuento,$promocionporcentaje);

            
            


            $this->db->select('*');
            $this->db->from('detpromo');
            $this->db->where('codart',$row2->codart);
            $this->db->where('codcto',$row2->codcto);
            $prom= $this->db->get();
                
                if(sizeof($prom->result()) > 0){
                    foreach ($prom->result() as $item) {
                        $this->db->select('*');
                        $this->db->from('headpromo');
                        $this->db->where('codcto',$item->codcto);
                        $this->db->where('numero',$item->numero);
                        $head= $this->db->get();
    
                        $fecha = new DateTime();
                        $formateo = $fecha->format("Y-m-d");
                        $hora = new DateTime();
                        $formateoHora = $hora->format("H:i:s");
    
    
                        foreach( $head->result() as $item1){
                         if($item1->dcto != 0 && $item1->dcto != null && $item1->fecha1 <= $formateo && $item1->fecha2 >= $formateo  ){
                                
                            foreach ($art->result() as $key) {
                            
                                $data=array(
                                    'nombre'=>$key->nomart,
                                    'sku'=>$row2->codart,
                                    'cantidad'=>$row2->qtyart, 
                                    'precio'=>$price[0]->valart,
                                    'descuentos'=>$arraydescuento,
                                    'atributos'=>null
                                );  
                            }
                         array_push($arrayresult,$data);
                         
    
    
                }else if( $item->artPaga == 1 && $item1->dcto == 0 && trim($item->numero) == $item1->numero && $item1->fecha1 <= $formateo  && $item1->fecha2 >= $formateo){
    
                   
                    foreach ($art->result() as $key) {
                            
                        $data=array(
                            'nombre'=>$key->nomart,
                            'sku'=>$row2->codart,
                            'cantidad'=>$row2->qtyart, 
                            'precio'=>$row2->valart,
                            'descuentos'=>null,
                            'atributos'=>null
                        );  
                    }
                 array_push($arrayresult,$data);
                
    
                    $this->db->select('*');
                    $this->db->from('detpromo');
                    $this->db->where('numero',$item1->numero);
                    $this->db->where('codcto',$item1->codcto);
                    $this->db->where('artlleva',1);
                    $prom1= $this->db->get();
                    $cont = 1;
                        foreach($prom1->result() as $item2){
                        if($cont < $item1->lleva){
                            $data = array();
                            $this->db->select('*');
                            $this->db->from('tbl_articulos');
                            $this->db->where('codart',$item2->codart);
                            $art1=$this->db->get();
    
                               foreach ($art1->result() as $key1) {
                                $promocionporcentaje1 = new stdClass();
                
                                $promocionporcentaje1->nombre=null;
                                $promocionporcentaje1->codigo="100";
                                $promocionporcentaje1->origen=null;
                                $promocionporcentaje1->monto=$key1->valart;
                                array_push($arraydescuento1,$promocionporcentaje1);
                    
                    
                                    $data=array(
                                        'nombre'=>$key1->nomart,
                                        'sku'=>$item2->codart,
                                        'cantidad'=>$row2->qtyart, 
                                        'precio'=>$key1->valart,
                                        'descuentos'=>$arraydescuento1,
                                        'atributos'=>null
                                    );  
                                    
                                }
                array_push($arrayresult,$data);
                
                        }
                $cont++;
            }
          
                       
    
                    }else{
    
                        foreach ($art->result() as $key) {
                            
                            $data=array(
                                'nombre'=>$key->nomart,
                                'sku'=>$row2->codart,
                                'cantidad'=>$row2->qtyart, 
                                'precio'=>$row2->valart,
                                'descuentos'=>null,
                                'atributos'=>null
                            );  
                        }
                     array_push($arrayresult,$data);
                     
    
                    }
               }
            }
                }else{
                    foreach ($art->result() as $key) {
                        
                        $data=array(
                            'nombre'=>$key->nomart,
                            'sku'=>$row2->codart,
                            'cantidad'=>$row2->qtyart, 
                            'precio'=>$row2->valart,
                            'descuentos'=>null,
                            'atributos'=>null
                        );  
                    }
                    array_push($arrayresult,$data);
                
                }
        
    

        }

        return $arrayresult;
    }

    function GetDetComprador($usuario){
        $this->db->select(' * ');
        $this->db->from('tbl_usuarios');
        $this->db->where('u_nitter',$usuario);
        $rest2=$this->db->get();
        $arrayresult = array();
        foreach ($rest2->result() as $key) {
            $documento['numero'] = $key->u_nitter;
            $documento['pais'] = "CO";
            $documento['tipo'] = "DOCUMENTO_IDENTIDAD"; 
           $arrayresult = array(
                'id' => $key->u_id,
                'codigo' => $key->u_nitter,
                'email' => $key->u_email,
                'nombre' => $key->u_username,
                'apellido' => $key->u_username,
                'telefono' => $key->u_telefono,
                'genero' => $key->u_genero == 1? "M" : "F",
                "documento"=> $documento,
           );
        }

        return $arrayresult;
    }

    function GetPago($codfor, $numfac){
        $this->db->select(' * ');
        $this->db->from('forma_pago');
        $this->db->where('codformapago',$codfor);
        $rest2=$this->db->get();
        $this->db->select(' * ');
        $this->db->from('factura');
        $this->db->where('numfac',$numfac);
        $rest3=$this->db->get();
        $importe = $rest3->result();
        $arrayresult = array();
        foreach ($rest2->result() as $key) {
            $arrayresult = array(
                'codigo' => $key->nombre,
                'conector' => "",
                'importe' => $importe[0]->valfac,
                'moneda' => "COP",
           );
        }

        return $arrayresult;
    }

    function GetEntrega($numfac){
        $this->db->select(' * ');
        $this->db->from('factura');
        $this->db->where('numfac',$numfac);
        $rest2=$this->db->get();
        $arrayresult = array();


        foreach ($rest2->result() as $key) {
           
            $this->db->select(' * ');
            $this->db->from('dom_barrios');
            $this->db->where('codbarr',$key->codbarr);
            $rest3=$this->db->get();
            $arrayresult = array();
            $resultado = $rest3->result();
            $localidad = sizeof($resultado) == 0? "N/A" : $resultado[0]->nombarr;
           $arrayresult = array(
                'pais' => "Colombia",
                'estado' => $key->ciudad != null? $key->ciudad : "N/A",
                'localidad' => $localidad,
                'calle' => $key->direccion,
                'numeroPuerta' => "-",
           );
        }

        return $arrayresult;
    }

    function salvarVenta($array){
        $apirest=ApiRest::requestAPISaveInvoices($array);
       // var_dump($apirest);
       
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
	
	 //ENVIAR CORREO ELECTRONICO
    function detalleticket($numfac){
        $query = $this->db->query('select d.item, ta.nomart, d.qtyart, d.totart  from detallefactura d, tbl_articulos ta where numfactura ='.$numfac.' and ta.codart = d.codart 
         ');
         
         
         $table ="";
 
         foreach ($query->result() as $key => $value) {
             $table .='<tr>
             <td style="border: 1px dashed black; padding-left: 2px; padding-right: 2px; "><small>'.$value->item.'</small></td>
             <td style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; "><small>'.$value->nomart.'</small></td>
             <td style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; align-items:right;"><small>'.$value->qtyart.'</small></td>
             <td style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; "><small>'.$value->totart.'</small></td>   
         </tr>';
         }
 
         return $table;
     }

    function send($numfac, $nit){
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        $detalle = self::detalleticket($numfac);
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $query = $this->db->query('select tu.u_username, tu.u_nitter, f.codpedido, f.numfac, f.fecfac, f.valfac, f.descfac, f.val_dom, tu.u_email 
        from tbl_usuarios tu, factura f where f.numfac = '.$numfac.' and tu.u_nitter = f.nitcli and tu.u_nitter = '.$nit);
        $nombre="";
        $codpedido="";
        $fecha="";
        $valor="";
        $descuento="";
        $domicilio="";
        $email="";
        $result = $query->result();
        // SMTP configuration
        foreach ($result as $key => $value) {
        $nombre=$value->u_username;
        $codpedido = $value->codpedido;
        $fecha = $value->fecfac;
        $valor = $value->valfac;
        $descuento = $value->descfac;
        $domicilio = $value->val_dom;
        $email = $value->u_email;
        }

        $query2 = $this->db->query('select * from par_personal');
        $empresa="";
        $logo="";
        $result2 = $query2->result();
        foreach ($result2 as $key => $value) {
        $empresa = $value->nom_empresa;
        $logo    = $value->url_logo;
        }


        $total = (floatval ($valor) - floatval ($descuento)) +floatval ($domicilio); 
        
        $mail->isSMTP();
        $mail->Host     = 'relay-hosting.secureserver.net';
        
        $mail->Mailer = "smtp";
        $mail->SMTPAuth =false;
        $mail->Username = 'gerencia@biopharma.com.co';
        $mail->Password = 'ismael1964';
        $mail->SMTPSecure = false;
        $mail->Port     = 25;
        
        $mail->setFrom('gerencia@biopharma.com.co', $empresa);
        $mail->addAddress($email);
        
        
        
        
        // Email subject
        $mail->Subject = 'e-TICKET '.$empresa;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = '<html>

        <head>
            <title>Ticket</title>
        </head>
        
        <body>
            <div style=" width: 250px; padding-left: 2px; align-content: center; margin-left: 20px; border: 1px black solid;">
                <center>
                    <h2>Detalle de pago</h2>
        
                    <h3>Informacion del servicio</h3>
                    <h5><small><strong>Numero de identificacion:</strong></small> '.$nit.'</h5>
                    <h5><small><strong>Nombre:</strong></small> '.$nombre.'</h5>
                    <hr>
                    <h3>Informacion del pedido</h3>
                    <h5><strong>Cod. pedido:</strong> '.$codpedido.'</h5>
                    <h5><strong># Pedido:</strong> '.$numfac.'</h5>
                    <h5><strong>Detalle pedido:</strong></h5>
                </center>
                <table style="border-collapse: collapse; margin-left: 10px;">
                    <tr>
                    <th style="border: 1px dashed black; padding-left: 2px; padding-right: 2px; "> # </th>
                        <th style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; "> Nombre </th>
                        <th style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; "> Cantidad </th>
                        <th style="border: 1px dashed black; padding-left: 8px; padding-right: 8px; "> valor </th>
                    </tr>
                    '.$detalle.'
                </table>
                <br>
                <small style="margin-left: 12px;"><strong>Fecha:</strong>'.$fecha.'</small>
        
                <hr>
        
                <h4 style=" margin-left: 12px;">Valor transaccion:</h4>
                <h4 style=" margin-left: 12px;"><strong>Subtotal:</strong> $'.$valor.'</h4>
                <h4 style=" margin-left: 12px;"><strong>Desc:</strong> $'.$descuento.'</h4>
                <h4 style=" margin-left: 12px;"><strong>Domicilio:</strong> $'.$domicilio.'</h4>
                <h3 style=" margin-left: 12px;"><strong>Total:</strong> $'.$total.'</h3>
                <hr style=" margin-left: 12px;">
                <h4 style=" margin-left: 12px;">Farmacia:</h4>
                <a style=" margin-left: 12px; margin-bottom:12px" href="https://biopharmaciavirtual.com.co/"> <img src="'.$logo.'" width="80px" height="40px"> </a>
            </div>

            <p> 
            <strong>NOTA:</strong> Favor no responder este mensaje que ha sido emitido autom谩ticamente por el sistema.
            </p>
        </body>
        
        </html>';
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        }else{
            return true;
        }
    }
}