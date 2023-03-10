<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloInicio extends CI_Model
{
    function gettodo()
    {
        $minimo             =   $this->input->post('minimo');
        $maximo             =   $this->input->post('maximo');
        $busquedaGeneral    =   $this->input->post('busquedaGeneral');
        $categoria2         =   '';
        $minimo2            =   '';
        $maximo2            =   '';
        $busquedaGeneral2   =   '';
        $categoriaPost      =   $this->input->post('categoriaPost');
        $categoriaPost      =   $this->input->post('categoriaPost');
        $subcate      =   $this->input->post('subcate');
        $categoriaPost2     =    '';

        $input_tbl          =   $this->input->post('input_tbl');
        $input_elegido      =   $this->input->post('input_elegido');
        $input_elegido2     =   '';

        if($categoriaPost != ""){
            $categoriaPost2 = " AND categoria =".$categoriaPost;

            if($subcate != 0){
                $categoriaPost2 = $categoriaPost2." AND subcategoria = ".$subcate;
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
       
        $rest = $this->db->query("SELECT *, 
                                        IF((SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 1 AND p_elegido = categoria) != 'NULL',(SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 1 AND p_elegido = categoria),IF( (SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 2 AND p_elegido = id)!='NULL', (SELECT p_porcentaje FROM tbl_promociones WHERE p_tbl = 2 AND p_elegido = id),'')) AS promo
                                        FROM tbl_articulos 
                                            WHERE estado = 1 
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
        $id_usuario = $this->session->userdata('id_usuario');

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
    
}