<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiRest{
    

    //URL para la conexion con la API
   
    private static $api_url = "http://webapidelyloco.hopto.org:51818/Venta/";
    //private static $api_url = "http://localhost:51818/Venta/";
    private static $initialized = false; 



    private static function initialize()
    {
        if (self::$initialized)
            return;
        self::$api_url = "http://webapidelyloco.hopto.org:51818/Venta/";
        //self::$api_url = "http://localhost:51818/Venta/";
        self::$initialized = true;
    }
    
    
    public static function requestAPIproductos($centroCostos){

        $conection = curl_init();
        $extension = "GetProducts?codcto=".$centroCostos;
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 8); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        //Cierre de session
        curl_close($conection); 
        return json_decode($respuesta,true);
        //echo $respuesta;
    }


    public static function getCategorias(){

      $arrayProducts = self::requestAPIproductos("001");
        $array = array();
        $arrayResult = array();
        $cont = 0;
        foreach ($arrayProducts as $key => $value) {

                $array['codgru'] = $value['codgru'];
                $array['img']    = '-';
                $array['nombreimg'] = '-';
                $array['nomgru'] = $value['nomgru'];
                $array['fechacrea'] = '';
                $array['fechamod'] = '';
                $array['usuariocrea'] = '';
                $arrayResult[$cont] = $array;
                $cont++;
        }


        $rest = array_values(array_unique($arrayResult,SORT_REGULAR));// Crea un Array sin duplicados.
        
        return $rest;
    }

    public static function getSubcategorias(){

        $arrayProducts = self::requestAPIproductos("001");
        $arrayResult = array();
        $array = array();
        $cont = 0;
        foreach ($arrayProducts as $key => $value) {

            if( $value['codsubcate'] !== "" && $value['nomsubcate'] !== ""){
                $array['codgru'] = $value['codgru'];
                //$array['nomgru'] = $value['nomgru']; 
                $array['codsubcate'] = $value['codsubcate'];
                $array['nomsubcate'] = $value['nomsubcate'];
                $arrayResult[$cont] = $array;
                $cont++;
            }
                
        }

        $rest = array_values(array_unique($arrayResult,SORT_REGULAR));// Crea un Array sin duplicados.
        
        //echo json_encode($rest);
        return $rest;

    }

    public static function getArticulos(){
        $arrayProducts = self::requestAPIproductos("001");
        $arrayResult = array();
        $array = array();
        $cont = 0;
        foreach ($arrayProducts as $key => $value) {
                $array['categoria'] = $value['codgru'];
                $array['id'] = '';
                $array['imageurl'] = '';
               // $array['categoria'] = $value['nomgru']; 
                $array['codsubcate'] = $value['codsubcate'];
                //$array['nomsubcate'] = $value['nomsubcate']; 
                $array['codart'] = $value['codart'];
                $array['nomart'] = $value['nomart'];
                // Corregir error de gramatica API
                $array['descripcion'] = $value['descripcin'];
                $array['valart'] = $value['valart'];
                //Falta unidad Articulo, estado, promo, id en el API
                $array['qtyart'] = 1;
                $array['estado'] = 1;
                $array['promo'] = 0;
                $arrayResult[$cont] = $array;
                $cont++;
               
            }

        return $arrayResult;
    }

    public static function getVariantes(){
        $arrayVariantes = self::requestAPIproductos("001");
        $arrayResult = array();
        $array = array();
        $cont = 0;

        foreach ($arrayVariantes as $key => $variantes) {
            if(!empty($variantes['variante'])){
                foreach ($variantes['variante'] as $key => $value) {
                    $array['nomvar'] = $value['nomvar'];
                    $array['codartvar'] = $value['codartvar'];
                    $array['nomartvar'] = $value['nomartvar'];
                    $array['codart'] = $value['codart'];

                    $arrayResult[$cont] = $array;
                    $cont++;
                }
            }
        }

        json_encode($arrayResult);
        return $arrayResult;
    }

  

// METODO PARA OBTENER EL STOCK DE UN PRODUCTO O LISTADO DE ELLOS
    public static function requestAPIgetStock($array){
        
        $conection = curl_init();
        $extension = "GetStockProducts";
        $data      = json_encode($array);
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 8); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
        curl_setopt($conection,CURLOPT_HTTPGET,FALSE);
        curl_setopt($conection, CURLOPT_POST, 1);
        curl_setopt($conection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($conection, CURLOPT_HEADER, FALSE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);
        curl_close();
        if($result['status'] === 1){
            $mensaje = $result['mensaje'];
           // echo "<script>alert('$mensaje')</script>";
            return $result;
        } else {
            echo "<script>alert('Error en solicitud')</script>";
        }


        
        //echo $respuesta;
    }

    public static function requestAPISaveInvoices($array){

        $conection = curl_init();
        $extension = "SaveInvoices";
        $data      = json_encode($array);
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 8); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
        curl_setopt($conection,CURLOPT_HTTPGET,FALSE);
        curl_setopt($conection, CURLOPT_POST, 1);
        curl_setopt($conection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($conection, CURLOPT_HEADER, FALSE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);
        
        //$rest = curl_getinfo($conection, CURLINFO_REDIRECT_TIME_T);
        $file = $array['numfac'].'.json';
        //Windows prueba
        $directorio = base_url('asset/json/');
        // Hosting produccion
        //$directorio = base_url('asset/json/');
        if(!$respuesta){
            //creacion y asignacion de directorio para el JSON
            /*if(file_exists($directorio)){
                $json_string = json_encode($array);
                $fh = fopen($directorio.'\venta_'.$file, 'w');
                fwrite($fh,$json_string);
                return 'Json almacenado en Directorio: '.base_url('asset/json/'.$file);

            }else{
                if(mkdir($directorio, 0777, TRUE)){
                    $json_string = json_encode($array);
                    $fh = fopen($directorio.'\venta_'.$file, 'w');
                    fwrite($fh,$json_string);

                    return 'Json almacenado en Directorio: '.base_url('asset/json/'.$file);
                }
                else{
                    return 'Directorio: '.base_url('asset/json/'.$file).'no pudo ser creado';
                }
            }*/

            return $respuesta;
        }else{
            
            
            //curl_close();
        if($result['status'] === 1){
            $mensaje = $result['mensaje'];
           // echo "<script>alert('$mensaje')</script>";
           // echo $respuesta;
            return $result;
        } else {
           // echo "<script>alert('Error: no se pudo guardar la factura.')</script>";
           // echo $respuesta;
           return $result;
        }
        }
        

        

    }

}

    


?>