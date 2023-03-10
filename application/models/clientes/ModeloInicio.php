<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloInicio extends CI_Model
{
    function getCredencialesPayu(){
        $select = "select * from tbl_credencial";
        $rest = $this->db->query($select);

        $result = $rest->result();

        foreach ($result as $row) {
            PayU::$apiKey = $row->apiKey;
            PayU::$apiLogin = $row->apiLogin;
            PayU::$merchantId = $row->merchantId;
            PayU::$accountId = $row->accountId;
        }
    }

    function gettodo()
    {
        //$this::getCredencialesPayu();
        $minimo             =   $this->input->post('minimo');
        $maximo             =   $this->input->post('maximo');
        $busquedaGeneral    =   $this->input->post('busquedaGeneral');
        $categoria2         =   '';
        $minimo2            =   '';
        $maximo2            =   '';
        $busquedaGeneral2   =   '';
        $categoriaPost      =   $this->input->post('categoria');
        $categoriaPost      =   $this->input->post('categoria');
        $subcate            =   $this->input->post('subcategoria');
        $categoriaPost2     =    '';

        $input_tbl          =   $this->input->post('input_tbl');
        $input_elegido      =   $this->input->post('input_elegido');
        $input_elegido2     =   '';

        $codalmm    =   $this->input->post('codalmm');
            //$codalmm = '002';
        if($categoriaPost != ""){
            $categoriaPost2 = " AND categoria =".$categoriaPost;

            if($subcate != NULL){
                $categoriaPost2 = $categoriaPost2." AND subcategoria = '".$subcate."'";
            }
            
        }

        if($minimo != ""){
            $minimo2 = " AND valart >= ".$minimo;
        }

        if($maximo != ""){
            $maximo2 = " AND valart <= ".$maximo;
        }

        if($busquedaGeneral != ""){
            $busquedaGeneral2 = " AND nomart LIKE  '%".$busquedaGeneral."%' ";
        }

        if($input_tbl == 1){
          
           $categoriaPost2 = " AND categoria = '".$input_elegido."'";
          
        }

        if($input_tbl == 2){
            $categoriaPost2 = " AND id = ".$input_elegido;
         }


         $fecha = date('Y-m-d');
         

        $rest = $this->db->query(" SELECT *, IF((SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 1 AND p_elegido = categoria) != 'NULL',
        
        (SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 1 AND p_elegido = categoria),
        
        IF( (SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 2 AND p_elegido = id)!='NULL', 
        
        (SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 2 AND p_elegido = id),'')) AS promo,
        
        (SELECT dp.vrdcto from detpromo dp, headpromo hp 
        where dp.idemp = '001' and 
        (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and dp.codcto = hp.codcto and
        dp.numero = hp.numero and dp.codart = a.codart  and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as vrdcto, 
        
        (SELECT hp.dcto from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as dcto,

         (SELECT concat(hp.fecha1) from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as FechaIni,
         
          (SELECT concat(hp.fecha2) from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as FechaFin,

         (SELECT dp.artlleva from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='')and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as artlleva,
         
         (SELECT dp.artPaga from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as artPaga,
         
         (SELECT concat(hp.hor1,':',hp.min1) from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as HoraInicio,
         
          (SELECT concat(hp.hor2,':',hp.min2) from detpromo dp, headpromo hp 
         where dp.idemp = '001' and (dp.codcto = '$codalmm' or dp.codcto ='') and dp.idemp = hp.idemp and 
         dp.codcto = hp.codcto and dp.numero = hp.numero and dp.codart = a.codart and '$fecha' BETWEEN hp.fecha1 and hp.fecha2) as HoraFin
         
         from tbl_articulos a
         where estado =1
         $categoriaPost2 $minimo2 $maximo2  $busquedaGeneral2");
     
        return $rest->result();
       
    }

    function getslaider()
    {
        $this->db->select(' p.*,
                            IF(p.p_tbl=2,(SELECT nomart FROM tbl_articulos WHERE id = p.p_elegido),(SELECT nomgru FROM tbl_categorias WHERE id = p.p_elegido)) AS descripcion,');
        $this->db->from('tbl_promociones p');
        $this->db->where('p.p_estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    function getvariante()
    {
        $codart =  $this->input->post('id');
        $this->db->select(' * ');
        $this->db->from(' tbl_variante');
        $this->db->where('codart',$codart);
        $rest=$this->db->get();

       // echo "RESULTADO: ".json_encode($rest->result());
        return $rest->result();
    }

    function getcargarpedido(){
        $codpedido = $this->input->post('codpedido');
        $id_usuario = $this->input->post('id');
        //$id_usuario = $this->session->userdata('id_usuario');
        
        $sql = $this->db->query('select c_pedido from tbl_carrito where c_cliente ='.$id_usuario);

        $cod;
        foreach($sql->result() as $row){
            $cod = $row->c_pedido;
        }

        $dvcarrito;
        $carrito;
        $item = 1;
        if($sql->result()){
            
            $sql2 = $this->db->query('select max(dv_item ) as dv_item from detallevariantecarrito where dv_cliente ='.$id_usuario);
            
            foreach($sql2->result() as $row2){
                $item = $item + intval($row2->dv_item);
            }
            $this->db->where('dv_pedido', $codpedido);
            $this->db->set('dv_pedido', $cod);
            $this->db->set('dv_item', $item);
            $this->db->set('dv_cliente', $id_usuario);
            $dvcarrito =  $this->db->update('detallevariantecarrito');
            
            $this->db->where('c_pedido', $codpedido);
            $this->db->set('c_cliente', $id_usuario);
            $this->db->set('c_pedido', $cod);
            $carrito =  $this->db->update('tbl_carrito');
            
        }else{
            $this->db->where('c_pedido', $codpedido);
            $this->db->set('c_cliente', $id_usuario);
            $carrito =  $this->db->update('tbl_carrito');

            $this->db->where('dv_pedido', $codpedido);
            $this->db->set('dv_cliente', $id_usuario);
            $this->db->set('dv_item', $item);
            $dvcarrito =  $this->db->update('detallevariantecarrito');
        }

        

        if($carrito && $dvcarrito){
            return true;
        }else{
            return false;
        }
    }

        function getverificarcodprom(){
            $usuario    =   $this->session->userdata('nit_tusuario');
            $codigo = $this->input->post('codigo');

            //CONSULTA SI EXISTE EL CODIGO
            $this->db->select(' * ');
            $this->db->from('cod_promocion');
            $this->db->where('codigo',$codigo);
            $this->db->where('estado',0);
            $rest=$this->db->get();

            if(!$rest->result()){
                return false;
            } else {

                //CONSULTA SI NO HA SIDO USADO EL CODIGO
                $this->db->select(' * ');
                $this->db->from('factura');
                $this->db->where('codprom',$codigo);
                $this->db->where('nitcli',$usuario);
                $rest2=$this->db->get();
                
                
                if(!$rest2->result()){

                    //CONSULTA SI AL PRODUCTO SE LE APLICA EL DESCUENTO

                    $this->db->select(' c.*, t.t_nombre, IF(c.t_id=2,
                    (SELECT nomart FROM tbl_articulos WHERE id = c.elegido), 
                    IF(c.t_id = 1, (SELECT nomgru FROM tbl_categorias WHERE id = c.elegido),
                    (SELECT nomsubcate FROM tbl_subcategorias WHERE codsubcate = c.elegidosub))) 
                    AS descripcion, IF(c.t_id=2,
                    (SELECT codart FROM tbl_articulos WHERE id = c.elegido), 
                    IF(c.t_id = 1, (SELECT codgru FROM tbl_categorias WHERE id = c.elegido),
                    (SELECT codsubcate FROM tbl_subcategorias WHERE codsubcate = c.elegidosub))) 
                    AS codproducto ');
                    $this->db->from('cod_promocion c');
                    $this->db->join('tbl_tabla t', 't.t_id  = c.t_id');
                    $this->db->where('c.estado',0);
                    $this->db->where('c.codigo', $codigo);
                    $rest3=$this->db->get();
                    $id_usuario = $this->session->userdata('id_usuario');
                    foreach( $rest3->result() as $row){

                        //Consulta en articulos
                        if($row->t_id == 2){
                           
                            $this->db->select(' * ');
                            $this->db->from('tbl_carrito');
                            $this->db->where('c_producto',$row->codproducto);
                            $this->db->where('c_cliente',$id_usuario);
                            $articulo=$this->db->get();

                            if($articulo->result()){
                                return true;
                            }else{
                                return false;
                            } 
                            //Consulta en Categorias    
                        }/*elseif ($row->t_id == 1) {
                            $select = 'select c.* from tbl_carrito c, tbl_articulos ta ';
                            $where = 'where ta.categoria = '.$row->codproducto.' and c.c_producto  = ta.codart and c.c_cliente = '.$id_usuario;

                            $categoria = $this->db->query($select.$where);

                            if($categoria->result()){
                                return true;
                            }else{
                                return false;
                            } 
                            //Consulta en Subcategorias
                        }elseif ($row->t_id == 3) {
                            $select = 'select c.* from tbl_carrito c, tbl_articulos ta ';
                            $where = 'where ta.subcategoria = '.$row->codproducto.' and c.c_producto  = ta.codart and c.c_cliente = '.$id_usuario;

                            $categoria = $this->db->query($select.$where);

                            if($categoria->result()){
                                return true;
                            }else{
                                return false;
                            } 
                        }*/
                        

                    }

                }else{
                    return false;
                }

            }

        }
    
        function getmiscompras(){

            $nit        =  $this->session->userdata('nit_tusuario');
    
            $select     = 'select * ';
            $from       = 'from factura ';
            $where      = 'WHERE nitcli = '.$nit.' and pedidoestado between 0 and 2 ORDER BY fecfac DESC';
    
            $rest       = $this->db->query($select.$from.$where);
            $result     = $rest->result();
    
            return $result;
        }
    
        function getarticulos(){
            $nit        =  $this->session->userdata('nit_tusuario');
            $fecfac  =   $this->input->post('fecfac');
            $numfac     =   $this->input->post('numfac');
    
            $select = 'select ta.nomart, df.qtyart ';
            $from   = 'FROM tbl_articulos ta, detallefactura df, factura f ';
            $where  = 'where ta.codart = df.codart AND df.numfactura = f.numfac AND df.fecha = f.fecfac AND f.nitcli = '.$nit.' and f.numfac ='.$numfac.' and df.fecha = "'.$fecfac.'"';
    
            $rest       = $this->db->query($select.$from.$where);
            $result     = $rest->result();
    
            return $result;
    
        }

        function cargarvalores(){
            $nit        =  $this->session->userdata('id_usuario');
            $codpedido  =   $this->input->post('codpedido');
            
            $select = "select SUM(c_totalvalor ) as total from tbl_carrito where c_pedido = '" . $codpedido. "' and c_cliente = ".$nit;
            
            $rest = $this->db->query($select);

            $result = $rest->result();

            $query = "select * from tbl_credencial";

            $rest2 = $this->db->query($query);

            $result2 = $rest2->result();
            $amount = 0;

            foreach ($result as $row) {
                $amount = $row->total;
            }
            
            $firma = "";
            $apiKey = "";
            $apiLogin = "";
            $merchantId = "";
            $accountId = "";
           
            foreach($result2 as $rows){
                $apiKey = $rows->apiKey;
                $apiLogin = $rows->apiLogin;
                $merchantId = $rows->merchantId;
                $accountId = $rows->accountId;
            }
            $firma = md5($apiKey."~".$merchantId."~".$codpedido."~".$amount."~COP");
            
            $objeto = new stdClass();
            $objeto->merchantId = $merchantId;
            $objeto->accountId = $accountId;
            $objeto->description = "Pago a realizar para compra en tienda virtual.";
            $objeto->referenceCode = $codpedido;
            $objeto->amount = $amount;
            $objeto->tax = "0";
            $objeto->taxReturnBase = "0";
            $objeto->currency = "COP";
            $objeto->signature = $firma;
            $objeto->test = "1";
            $objeto->buyerEmail = $this->session->userdata('correo');
            $objeto->responseUrl = site_url('clientes/ControladorVenta/respuestaPago');
            $objeto->confirmationUrl = site_url('clientes/ControladorVenta/confirmacionPago');
            return $objeto;
        
        }

        
        
        
}