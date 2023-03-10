<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiRest{

    //URL para la conexion con la API
    private static $api_url = "http://biopharmanatural.tplinkdns.com:51818/";
    //private static $api_url = "";
    private static $initialized = false; 
    private static $codgru = array(); 
    private static $codlin = array(); 
     
    private static function initialize()
    {
        if (self::$initialized)
            return;
        self::$api_url = "http://biopharmanatural.tplinkdns.com:51818/";
        //self::$api_url = "";
        self::$initialized = true;
        self::$codgru = array();

     

    }
    
    public static function requestResetApi(){
        $conection = curl_init();
        $extension = "Home/ReiniciarImportacion";
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 0);
       // curl_setopt($conection, CURLOPT_TIMEOUT, 1000); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        //Cierre de session
        //echo $respuesta;
        curl_close($conection); 

    }
    
    public static function requestAPIproductos($cantidad){
       // set_time_limit(8000);
        self::requestResetApi();
        
        $conection = curl_init();
        $extension = "Home/listarProductos?nroInvocacion=".$cantidad;
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($conection, CURLOPT_TIMEOUT, 1000); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        //Cierre de session
        //return json_encode($respuesta);
        curl_close($conection); 

       // $file = '\jsonproductos.json';
       $file = 'jsonproductos.json';
       // $directorio ="C:\Users\CARLOS MARTINEZ\sources\GlobalsoftNet\GlobalsoftNet\AppRestaurantes\web\pansantana\globalsoft\web\appecommerce\asset\json";
        $directorio = './asset/json/';
        //creacion y asignacion de directorio para el JSON
            if(file_exists($directorio)){

                if(file_exists($directorio.$file)){
                    $borrado = self::borrarJson();
                }
                $json_string = $respuesta;
                
                $fh = fopen($directorio.$file, 'w');
                $re = chmod($directorio.$file,0777);
                fwrite($fh,$json_string);
                return 'Json almacenado en Directorio: '.base_url('asset/json/'.$file);

            }else{
                if(mkdir($directorio, 0777, TRUE)){
                    $json_string = $respuesta;
                    $fh = fopen($directorio.$file, 'w');
                    chmod($directorio.$file,0777);
                    fwrite($fh,$json_string);

                    return 'Json almacenado en Directorio: '.base_url('asset/json/'.$file);
                }
                else{
                    return 'Directorio: '.base_url('asset/json/'.$file).'no pudo ser creado';
                }
            }
        
        //return json_decode($respuesta,true);
       
        //return $respuesta;
    }
    
    public static function recorrerArchivo(){
        $directorio = ".\asset\json\jsonproductos.json";
        //$directorio ="E:".'\xa'."mpp\htdocs".'\e'."commerce\Ecommerce\asset\json\jsonproductos.json";
       // $directorio = './asset/json/jsonproductos.json';
        $datos_productos = file_get_contents($directorio);
        $json_productos = json_decode($datos_productos, true);
        return $json_productos;
    }

    public static function borrarJson(){
        $directorio = './asset/json/jsonproductos.json';
        //$directorio2 = 'ftp://u293118005.global:Global2020@45.89.204.178'.$directorio;

        $borrado = unlink($directorio);

        return $borrado;
    }

    public static function getCategorias($cantidadArticulos){
        // $cantidadArticulos = $_POST['cantidadArticulos'];        

        $r = self::requestAPIproductos($cantidadArticulos);
       
        $arrayProducts = self::recorrerArchivo();
            
        $array = array();
        $arrayResult = array();
        $cont = 0;
        $arraycodgru = array();
        foreach ($arrayProducts as $key => $value) {

            if(!in_array($value["categ"],$arraycodgru)){
                array_push($arraycodgru,$value["categ"]);
            }

        }
        self::$codgru = $arraycodgru;
        foreach ($arrayProducts as $key => $value) {
                $cod = array_search($value["categ"], self::$codgru) + 1; 
                $array['codgru'] = str_pad($cod."", 4, "0", STR_PAD_LEFT);
                $array['img']    = '-';
                $array['nombreimg'] = '-';
                $array['nomgru'] = $value['categ'];
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
        
        $arrayProducts = self::recorrerArchivo();
        $arrayResult = array();
        $array = array();
        $cont = 0;
        $arraycodgru = array();
        foreach ($arrayProducts as $key => $value) {

            if(!in_array($value["categ"],$arraycodgru)){
                array_push($arraycodgru,$value["categ"]);
            }

        }
        $arraycodlin = array();
        foreach ($arrayProducts as $key => $value) {

            if(!in_array($value["subcategoria"],$arraycodgru)){
                array_push($arraycodlin,$value["subcategoria"]);
            }

        }

        self::$codlin = $arraycodlin;
        self::$codgru = $arraycodgru;
        foreach ($arrayProducts as $key => $value) {

            if( $value['subcategoria'] !== ""){
                $cod = (array_search($value["categ"], self::$codgru) + 1); 
                $codsub = (array_search($value["subcategoria"], self::$codlin) + 1);
                $array['codgru'] = str_pad($cod."", 4, "0", STR_PAD_LEFT);
                //$array['nomgru'] = $value['nomgru']; 
                $array['codsubcate'] = str_pad($codsub."", 4, "0", STR_PAD_LEFT);
                $array['nomsubcate'] = $value['subcategoria'];
                $arrayResult[$cont] = $array;
                $cont++;
            }
                
        }

        $rest = array_values(array_unique($arrayResult,SORT_REGULAR));// Crea un Array sin duplicados.
        
        //echo json_encode($rest);
        return $rest;

    }

    public static function getArticulos(){
        
        $arrayProducts = self::recorrerArchivo();
        $arrayResult = array();
        $array = array();
        $cont = 0;
        
        $arraycodgru = array();
        foreach ($arrayProducts as $key => $value) {

            if(!in_array($value["categ"],$arraycodgru)){
                array_push($arraycodgru,$value["categ"]);
            }

        }
        $arraycodlin = array();
        foreach ($arrayProducts as $key => $value) {

            if(!in_array($value["subcategoria"],$arraycodgru)){
                array_push($arraycodlin,$value["subcategoria"]);
            }

        }

        self::$codlin = $arraycodlin;
        self::$codgru = $arraycodgru;
        foreach ($arrayProducts as $key => $value) {
                $cod = array_search($value["categ"], self::$codgru) + 1; 
                $codsub = array_search($value["subcategoria"], self::$codlin) + 1;
                $array['categoria'] = str_pad($cod."", 4, "0", STR_PAD_LEFT);
                $array['id'] = '';
                $array['imageurl'] = '';
               // $array['categoria'] = $value['nomgru']; 
                $array['codsubcate'] = str_pad($codsub."", 4, "0", STR_PAD_LEFT);
                //$array['nomsubcate'] = $value['nomsubcate']; 
                $array['codart'] = $value['variantes'][0]['presentaciones'][0]['sku'];
                $array['nomart'] = $value['nomPro'];
                // Corregir error de gramatica API
                $array['descripcion'] = $value['desc'];
                $array['referencia'] = $value['codPro'];
                $array['valart'] = $value['variantes'][0]['presentaciones'][0]['precioVtaM1'];
                //Falta unidad Articulo, estado, promo, id en el API
                $array['qtyart'] = $value['variantes'][0]['presentaciones'][0]['stock'];
                $array['ivaart'] = $value['variantes'][0]['presentaciones'][0]['ivaart'];
                $array['estado'] = 1;
                $array['promo'] = 0;
                $arrayResult[$cont] = $array;
                $cont++;
               
            }

        return $arrayResult;
    }

    public static function getVariantes(){
      
        $arrayVariantes = self::recorrerArchivo();
        $arrayResult = array();
        $array = array();
        $cont = 0;

        foreach ($arrayVariantes as $key => $variantes) {
            if(!empty($variantes['variantes'])){
                foreach ($variantes['variantes'] as $key => $value) {
                    
                    foreach($value['presentaciones'] as $key => $v){
                        $array['nomvar'] = $value['nomVar'];
                        $array['codartvar'] = $value['codVar'];
                        $array['nomartvar'] = $v['nomPre'];
                        $array['codart'] = $v['sku'];
                        $array['qtyart'] = $v['stock'];
                        
                        $arrayResult[$cont] = $array;

                        //imprimir para verificar si funciona
                        echo('<pre>');
                        var_dump($array);
                        echo('</pre>');
                    }
                    $cont++;
                }
            }
        }

        //json_encode($arrayResult);
        return $arrayResult;
    }

    public static function requestAPIReset(){

        $conection = curl_init();
        $extension = "ResetProducts";
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 8); 
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        //Cierre de session
        //echo $respuesta;
        return $respuesta;
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
        curl_close($conection);
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
        //$extension = "SaveInvoices";
        $extension = "Home/Orden";
        $data      = json_encode($array);
      
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 8);
        //curl_setopt($conection, CURLOPT_TIMEOUT, 360); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url.$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
        curl_setopt($conection,CURLOPT_HTTPGET,FALSE);
        curl_setopt($conection, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($conection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($conection, CURLOPT_POST, 1);
        curl_setopt($conection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($conection, CURLOPT_HEADER, FALSE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);
        //var_dump($result);
        
         return $result;
        // curl_setopt($conection, CURLOPT_POST, true);
        // curl_setopt($conection, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($conection, CURLOPT_HEADER, 0);
        // curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($conection, CURLINFO_HEADER_OUT, true);
        
                
     
        //$info = curl_getinfo($conection);
        //echo "INFO: ".json_encode($info);
        
        //echo "Resultado: ".json_encode($respuesta);
        //echo 'Error: '.json_encode($respuesta);
       
        //$rest = curl_getinfo($conection, CURLINFO_REDIRECT_TIME_T);
        //$file = $array['numfac'].'.json';
        //Windows prueba
        //$directorio = base_url('asset/json/');
        // Hosting produccion
        //$directorio = base_url('asset/json/');
        //if(!$respuesta){
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

           // return $respuesta;
       // }else{
            
            
        
           
        //}
    }

    public static function requestApiFormaPago(){
       // set_time_limit(8000);
        $conection = curl_init();
        $extension = "venta/GetFormasPago";
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($conection, CURLOPT_TIMEOUT, 360); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);

        return $result;
    }

    public static function requestApiPromociones(){
        // set_time_limit(8000);
         $conection = curl_init();
         $extension = "home/GetPromociones";
         curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
         curl_setopt($conection, CURLOPT_TIMEOUT, 360); 
         curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
         curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
         curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
         curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);
 
         $respuesta = curl_exec($conection);
         $result = json_decode($respuesta,true);
    
         return $result;
     }

    public static function requestApiDpto(){
       // set_time_limit(8000);
        $conection = curl_init();
        $extension = "venta/GetDpto";
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($conection, CURLOPT_TIMEOUT, 800); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);

        return $result;
    }

    public static function requestApiCiudades($Dpto){
       // set_time_limit(8000);
        $conection = curl_init();
        $extension = "venta/GetCiudades?coddpto=".$Dpto;
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($conection, CURLOPT_TIMEOUT, 1000); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);

        return $result;
    }

    public static function requestApiDomBarrios(){
       // set_time_limit(8000);
        $conection = curl_init();
        $extension = "GetBarrios";
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($conection, CURLOPT_TIMEOUT, 800); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);

        return $result;
    }
    
    public static function requestApiEstado($numfac){
        $conection = curl_init();
        $extension = "Home/GetStatusPedido?pedido=".$numfac;
        curl_setopt($conection, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($conection, CURLOPT_TIMEOUT, 800); 
        curl_setopt($conection,CURLOPT_URL,self::$api_url."".$extension);
        curl_setopt($conection,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($conection,CURLOPT_HTTPGET,TRUE);
        curl_setopt($conection, CURLOPT_RETURNTRANSFER, 1);

        $respuesta = curl_exec($conection);
        $result = json_decode($respuesta,true);

        return $result;


    }

}




    


?>