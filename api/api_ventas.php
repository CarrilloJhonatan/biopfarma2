<?php

//URL http://localhost/Globalsoft/AppRestaurantes/web/appecommerce/api/ventas (PRUEBA)
//URL https://delyloco.com/api/ventas (PRODUCCION)
header('content-type: application/json; charset=utf-8');
//colocar dominio que puede acceder cambiarlo por el *
header("Access-Control-Allow-Origin: *"); //===> acceso publico
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    if($_GET['accion'] === 'GetListaPedidos'){ //Generacion y Retorno de lista de Pedidos
        include_once 'conexion.php';
        $sql = "select numfac from factura where estadoenviar = 0 and pedidoestado != 4 and pedidoestado != 7";
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();  
        $datos = $sentencia->fetchAll();
        $pedidos = array();
        foreach ($datos as $key => $value) {
            array_push($pedidos, $value['numfac']);
        }
        echo json_encode($pedidos);

    }elseif($_GET['accion'] === 'GetPedido'){ //Generacion y Retorno de json pedido
        include_once 'conexion.php';

        $numfac;
        if(!isset($_GET['codped'])){
        $array['status'] = 'Error';
        $array['mensaje'] = 'Es necesario enviar codped con un valor valido.';
        echo json_encode($array);
        }else{
            
            $numfac = $_GET['codped'];  
            $sql = 'select * from factura where numfac = '.$numfac;

        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();  
        $datos = $sentencia->fetchAll();
        
        $arraysave;
        
        if(sizeof($datos) == 0){
            $arraysave['status'] = 'Error';
            $arraysave['mensaje'] = 'Codigo de pedido inexistente';
        }else{
            foreach ($datos as $key => $value) {
                $cliente = clientes($value['nitcli'], $numfac, $pdo);
                $comp = $value['numfac'];
                $pago = GetPago($value['mediopago'], $value['numfac'], $pdo);
                $direccionEnvio = GetEntrega($value['numfac'], $pdo);
                $entrega = array(
                    'tipo' => $value['direccion'] == "RETIRO"? $value['direccion'] : "ENVIO",
                    'local' => '001',
                    'direccionEnvio' => $direccionEnvio
                );
                $lineas= getLineasVenta($comp,$pdo);

                /*$valdomi = 0;
                $sqldomi = 'select * from dom_barrios where codbarr = '.$value['codbarr'];
                $rest = $pdo->prepare($sqldomi);
                $rest->execute();  
                $data = $rest->fetchAll();
                foreach ($data as $key => $val) {
                    
                    if($val['horaini1'] <= $value['fecfac'] && $val['horafin1'] >= $value['fecfac'] ){
                        $valdomi = $val['valor1'];
                       // echo 'entre if 1';
                    } elseif($val['horaini2'] <= $value['fecfac'] && $val['horafin2'] >= $value['fecfac'] ){
                        $valdomi = $val['valor2'];
                        //echo 'entre if 2';
                    }
                }*/
                $fact = array(
                    'idOrden'=>$value['numfac'],
                    'estado'=> 'APROBADO', //$value['estado'] == ""? $value['id'] : $value['numfac'],
                    'fechaInicio'=>$value['fecfac'],
                    'comprador'=> $cliente,
                    'moneda' => 'COP',
                    'pago'=> $pago,
                    'entrega'=> $entrega,
                    'lineas'=>  $lineas,
                    'importeTotal' => $value['valfac']
                );

                 

                $arraysave =$fact;
                
        }
        }
        
        
        echo json_encode($arraysave);
        }
        
    }elseif($_GET['accion'] === 'reset'){ //Reseteo de pedidos para volver a ser enviados
        include_once 'conexion.php';
        $sql2 = 'update factura set estadoenviar = 0 ';
                $sentencia2 = $pdo->prepare($sql2);
                $data = $sentencia2->execute();  
        $array;
        if($data){
            $array['status'] = 'OK';
            $array['mensaje'] = 'pedidos reseteados y listos para volver a enviarse';
        }else{
            $array['status'] = 'NULL';
            $array['mensaje'] = 'no se pudo realizar la peticion.';
        }
        
        echo json_encode($array);


    }elseif ($_GET['accion'] === 'SetEstado') {
        include_once 'conexion.php';

        if(!isset($_GET['codped'])){
            $array['status'] = 'Error';
            $array['mensaje'] = 'Es necesario enviar codped con un valor valido.';
            echo json_encode($array);
        }elseif(!isset($_GET['sincro'])){
            $array['status'] = 'Error';
            $array['mensaje'] = 'Es necesario enviar sincro con un valor valido sea 1 o 0.';
            echo json_encode($array);
        }elseif($_GET['sincro'] >= '0' && $_GET['sincro'] <= '1'){
            $array['status'] = 'Error';
            $array['mensaje'] = 'Es necesario enviar sincro con un valor valido sea 1 o 0.';
            echo json_encode($array);
        }else{
        $estado = $_GET['sincro'];
        $numfac = $_GET['codped'];
        $sql = 'select * from factura where numfac = '.$numfac;
        $consultar = $pdo->prepare($sql);
        $consultar->execute();
        $datos = $consultar->fetchAll();
        $cont = sizeof($datos);

        if($cont == 0){
        $array['status'] = 'Error';
        $array['mensaje'] = 'Pedido inexistente.';
        echo json_encode($array);
        }else{
        $sql2 = 'update factura set estadoenviar = '.$estado.' where numfac = '.$numfac;
        $sentencia2 = $pdo->prepare($sql2);
        $array['status'] = 'Ok';
        $array['mensaje'] = 'Estado de sincronizacion del pedido '.$numfac.' cambiado a '.$estado;
        $data = $sentencia2->execute(); 
        echo json_encode($array);
        }

        }
        
       
    }elseif ($_GET['accion'] === 'SetConfirm') {
        include_once 'conexion.php';
        $codped      = $_GET['codped'];
        $descripcion = $_GET['descripcion'];
          
         
               $ex = "select * from factura where numfac = ".$codped;
               $existe = $pdo->prepare($ex);
               $row = $existe->execute();
               $data = $existe->fetchAll();
              
               if(sizeof($data) != 0){
               $sql = "update factura set pedidoestado = 7, nomep = 'Rechazado', descripcion = '".$descripcion."' where numfac = ".$codped;
               $up  = $pdo->prepare($sql);
               $res = $up->execute();
               $verf = "select pedidoestado from factura where numfac = ".$codped;
               $ver  = $pdo->prepare($verf);
               $ver->execute();
               $datos = $ver->fetchAll();
               
               if($datos[0]['pedidoestado'] ==  7){
                $array['status'] = true;
                $array['descripcion'] = "Pedido rechazado con exito y notificado al usuario.";
                echo json_encode($array);

               }else{
                $array['status'] = false;
                $array['descripcion'] = "Pedido no fue marcado como rechazado.";
                echo json_encode($array);
               }
               }else{
                   $array['status'] = false;
                   $array['descripcion'] = "Pedido no encontrado por favor verifique que el codped: ".$codped." sea el correcto";
                   echo json_encode($array);
               }
      
    }
    else{
        $array['status'] = 'SyntaxError';
        $array['mensaje'] = 'peticion no identificada';
        echo json_encode($array);
    }



    function clientes($id, $numfac, $pdo){ 
       
        $sql = 'select tu.*, f.direccion as domicilio from tbl_usuarios tu, factura f where tu.u_nitter = '.$id.' and f.nitcli = tu.u_nitter  and f.numfac = '.$numfac;
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();  
        $datos = $sentencia->fetchAll();
        
        $arrayresult = array();
        foreach ($datos as $key => $value) {
            $documento = array(
                'tipo' => "DOCUMENTO_IDENTIDAD",
                'pais' => 'CO',
                'numero' => $value['u_nitter']
            );
            
            $arrayresult = array(
                'id' => $value['u_id'],
                'codigo' => $value['u_nitter'],
                'email' => $value['u_email'],
                'nombre' => $value['u_username'],
                'apellido' => $value['u_username'],
                'telefono' => $value['u_telefono'],
                'genero' => $value['u_genero'] == 1? "M" : "F",
                "documento"=> $documento,
           );
        }
            
        
            return $arrayresult;

    }

    function getLineasVenta($numfac, $pdo){

        
        $sql = 'select * from detallefactura where numfactura ='.$numfac;
        
        $sentencia = $pdo->prepare($sql); 
        $sentencia->execute();  
        $rest2 = $sentencia->fetchAll();
        $arrayresult = array();
        
        foreach ($rest2 as $value => $row2) {
            $sql1 = 'select * from tbl_articulos where codart ="'.$row2['codart'].'"';
            $sentencia1 = $pdo->prepare($sql1); 
            $sentencia1->execute();  
            $art = $sentencia1->fetchAll();
            
        $data = array();
            foreach ($art as $val => $key) {
                
                $data=array(
                    'nombre'=>$key['nomart'],
                    'sku'=>$row2['codart'],
                    'cantidad'=>$row2['qtyart'], 
                    'precio'=>$row2['valart'],
                    'descuentos'=>null,
                    'atributos'=>null
                );  
                
                
            }
            array_push($arrayresult,$data);
        }

        return $arrayresult;
    }

    function variante($codart,$numfactura,$qtyart,$pdo){
        $sql = 'select * from detallevariantefactura where dv_fact ='.$numfactura.' and dv_articulo = "'.$codart.'"';
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();  
        $datos = $sentencia->fetchAll();
        $arraydatos = array();
        foreach ($datos as $key => $value) {
            $array = array(
                'codins' => $value['dv_variante'],
                'qtyart' => $qtyart
            );

            array_push($arraydatos, $array);
        }

        return $arraydatos;

    }

   
    function GetPago($codfor, $numfac,$pdo){
        
        $sql = 'select * from forma_pago where codformapago ="'.$codfor.'"';
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();  
        $datos = $sentencia->fetchAll();
        $rest2=$datos;
    
        $sql1 = 'select * from factura where numfac ='.$numfac;
        $sentencia1 = $pdo->prepare($sql1);
        $sentencia1->execute();  
        $importe = $sentencia1->fetchAll();

        
        $arrayresult = array();
        foreach ($rest2 as $key => $value ) {
            $arrayresult = array(
                'codigo' => $value['nombre'],
                'conector' => "",
                'importe' => $importe[0]['valfac'],
                'moneda' => "COP",
           );
        }

        return $arrayresult;
    }

    function GetEntrega($numfac, $pdo){

        $sql1 = 'select * from factura where numfac ='.$numfac;
        $sentencia1 = $pdo->prepare($sql1);
        $sentencia1->execute();  
        $rest2 = $sentencia1->fetchAll();
        $arrayresult = array();

        foreach ($rest2 as $value => $key) {

            $sql2 = 'select * from dom_barrios where codbarr ='.$key['codbarr'];
            $sentencia2 = $pdo->prepare($sql2);
            $sentencia2->execute();  
            $rest3 = $sentencia2->fetchAll();
            $arrayresult = array();
            $resultado = $rest3;
           
            $localidad = sizeof($resultado) == 0? "N/A" : $resultado[0]['nombarr'];
           $arrayresult = array(
                'pais' => "Colombia",
                'estado' => $key['ciudad'] != null? $key['ciudad'] : "N/A",
                'localidad' => $localidad,
                'calle' => $key['direccion'],
                'numeroPuerta' => "-",
           );
        }

        return $arrayresult;
    }

    


?>