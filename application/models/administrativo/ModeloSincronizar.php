<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloSincronizar extends CI_Model
{
    function getapi()
    {
        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");
        

        $this->db->from('sincro_categorias');
        $this->db->truncate();

        $statisticsJson = file_get_contents("http://3.18.34.105:8080/apiGlobal/public/api/getCategorias");
        //$statisticsObj = json_decode($statisticsJson);

     

        //$data_array = json_decode($_POST['array']);
        $data_array = json_decode($statisticsJson);
        
        foreach ($data_array as $data_row):
            // possible data modeling here...
            $this->db->insert('sincro_categorias', $data_row);
        endforeach;

        $rest = $this->db->query('SELECT * FROM sincro_categorias t
                                        WHERE !exists(select c.codgru from tbl_categorias c where c.codgru = t.codgru)');

        $this->db->query('INSERT INTO tbl_categorias 
											SELECT 	"",
                                                    t.codgru,
													"",
													"",
													t.nomgru,
                                                    "'.$fecha.'",
                                                    "'.$fecha.'",
                                                    '.$usuario.',
                                                    '.$usuario.',
													1
													FROM sincro_categorias t
                                                        WHERE !exists(select c.codgru from tbl_categorias c where c.codgru = t.codgru)');

        if($rest->num_rows() != 0){

            $und = $rest->num_rows();

            $data=array(
                's_nombre'=>'CATEGORIAS',
                's_und'=>$und,
                's_fecha'=>$fecha,
                's_usuario'=>$usuario,
            );
        
            $sql_query=$this->db->insert('tbl_sincronizacion',$data);

        }
        return $rest->num_rows();
      
    }

    function getapi2()
    {
        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        $this->db->from('sincro_productos');
        $this->db->truncate();

        $statisticsJson = file_get_contents("http://3.18.34.105:8080/apiGlobal/public/api/getProductos");
       // $data_array = json_decode($_POST['array2']);
        
       $data_array = json_decode($statisticsJson);
        foreach ($data_array as $data_row):
            //possible data modeling here...
            $this->db->insert('sincro_productos', $data_row);
        endforeach;

        $rest = $this->db->query('SELECT * FROM sincro_productos t
                                        WHERE !exists(select c.codart from tbl_articulos c where c.codart = t.codart)');

        $this->db->query('INSERT INTO tbl_articulos 
											SELECT 	"",
                                                    "",
                                                    "",
                                                    t.categoria,
                                                    t.codart,
                                                    t.nomart,
                                                    t.valart,
													t.qtyart,
													t.descripcion,
                                                    1,
                                                    "'.$fecha.'",
                                                    "'.$fecha.'",
                                                    '.$usuario.',
                                                    '.$usuario.',
													1
													FROM sincro_productos t
                                                        WHERE !exists(select c.codart from tbl_articulos c where c.codart = t.codart)');

        if($rest->num_rows() != 0){

            $und = $rest->num_rows();

            $data=array(
                's_nombre'=>'ARTICULOS',
                's_und'=>$und,
                's_fecha'=>$fecha,
                's_usuario'=>$usuario,
            );
        
            $sql_query=$this->db->insert('tbl_sincronizacion',$data);

        }
        return $rest->num_rows();
      
    }

    function gettabla()
    {
        $this->db->select(' *,
                            DATE(s_fecha) AS fecha,
                            TIME(s_fecha) AS time,
                            (SELECT u_username FROM tbl_usuarios WHERE u_id = s_usuario) AS usuario');
        $this->db->from('tbl_sincronizacion');
        //$this->db->join('tbl_categorias c', 'c.id  = a.categoria');
        //$this->db->where('a.estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    
}