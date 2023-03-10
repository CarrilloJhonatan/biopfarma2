<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloArticulos extends CI_Model
{
    function gettodo()
    {
        $codalmm    =   $this->input->post('codalmm');
        $this->db->select(' *, 
        DATE(fechacrea) AS fecha,
        (SELECT nomgru FROM  tbl_categorias WHERE codgru = categoria) AS nomcat,
        IF(subcategoria = "null","Vacio",IF(subcategoria = " ","Vacio",(SELECT nomsubcate FROM  tbl_subcategorias WHERE codsubcate = subcategoria))) AS nomsubcate ') ;
        $this->db->from('tbl_articulos');
        //$this->db->join('tbl_categorias c', 'c.id  = a.categoria');
        $this->db->where('estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    function gettodopromo(){
        $codalmm    =   $this->input->post('codalmm');
       // $codalmm = '001';
        $this->db->select(' *, 
        DATE(fechacrea) AS fecha,
        (SELECT nomgru FROM  tbl_categorias WHERE codgru = categoria) AS nomcat,
        IF(subcategoria = "null","Vacio",IF(subcategoria = " ","Vacio",(SELECT nomsubcate FROM  tbl_subcategorias WHERE codsubcate = subcategoria))) AS nomsubcate
         ');
            $this->db->from(' headpromo h ');
            $this->db->join('detpromo p', 'h.numero  = p.numero');
            $this->db->join('tbl_articulos a', 'a.codart = p.codart');
            $this->db->where('a.estado',1);
            $this->db->where('p.codcto',$codalmm);
         
            $rest=$this->db->get();
            return $rest->result();
            /* $users = $rest->result_array();

            $data=array();
            foreach($users as $user){
                $data[] = array("idemp"=>$user['idemp'],
                "codcto"=>$user['codcto'],
                "numero"=>$user['numero'],
                "fecha1"=>$user['fecha1'],
                "fecha2"=>$user['fecha2'],
                "hor1"=>$user['hor1'],
                "min1"=>$user['min1'],
                "hor2"=>$user['hor2'],
                "min2"=>$user['min2'],
                "dcto"=>$user['dcto'],
                "estado"=>$user['estado'],
                "dia"=>$user['dia'],
                "tipo"=>$user['tipo'],
                "todo"=>$user['todo'],
                "paga"=>$user['paga'],
                "lleva"=>$user['lleva'],
                "dLun"=>$user['dLun'],
                "dMar"=>$user['dMar'],
                "dMie"=>$user['dMie'],
                "dJue"=>$user['dJue'],
                "dVie"=>$user['dVie'],
                "dSab"=>$user['dSab'],
                "dDom"=>$user['dDom'],
                "codart"=>$user['codart'],
                "nomart"=>$user['nomart'],
                "valart"=>$user['valart'],
                "vrdcto"=>$user['vrdcto'],
            
            );
            }

            return $data; */
    }

    function getcategoria()
    {
        $searchTerm = $this->input->post('searchTerm');

        // Fetch users
        $this->db->select('codgru,nomgru');
        $this->db->where("nomgru like '%".$searchTerm."%' ");
        $this->db->where("estado",1);
        $fetched_records = $this->db->get('tbl_categorias');
        $users = $fetched_records->result_array();
 
        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['codgru'], "text"=>$user['nomgru']);
        }
        return $data;
    }

    function getsubcategoria()
    {
        $searchTerm = $this->input->post('searchTerm');
        $categoria = $this->input->post('categoria');

        // Fetch users
        $this->db->select('codsubcate,nomsubcate');
        $this->db->where("nomsubcate like '%".$searchTerm."%' ");
        $this->db->where("codgru",$categoria);
        $fetched_records = $this->db->get('tbl_subcategorias');
        $users = $fetched_records->result_array();
 
        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['codsubcate'], "text"=>$user['nomsubcate']);
        }
        return $data;
    }

    function getguardar()
    {
        $id             =   $this->input->post('id');
        $urlimg         =   $this->input->post('urlimg');
        $categoria      =   $this->input->post('categoria');
        $subcategoria   =   $this->input->post('subcategoria');
        $codart         =   $this->input->post('codart');
        $nomart         =   $this->input->post('nomart');
        $valart         =   $this->input->post('valart');
        $qtyart         =   $this->input->post('qtyart');
        $descripcion    =   $this->input->post('descripcion');
        $tipopromo      =   $this->input->post('tipopromo');

        $usuario = $this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
            $this->db->select(' codart ');
            $this->db->from('tbl_articulos');
            $this->db->where('codart',$codart);
            $rest=$this->db->get();
        
            if($rest->num_rows()==1)
            {
                return 1;
            }
            else if($rest->num_rows()==0)
            {
                $data=array(
                    'imageurl'=>'',
                    'imagenombre'=>'',
                    'categoria'=>$categoria,
                    'subcategoria'=>$subcategoria,
                    'codart'=>$codart,
                    'nomart'=>$nomart,
                    'valart'=>$valart,
                    'qtyart'=>$qtyart,
                    'descripcion'=>$descripcion,
                    'tipopromo'=>$tipopromo,
                    'fechacrea'=>$fecha,
                    'fechamod'=>$fecha,
                    'usuariocrea'=>$usuario,
                    'usuariomod'=>$usuario,
                    'estado'=>1,
                );
            
                $sql_query=$this->db->insert('tbl_articulos',$data);

                $ultimoId = $this->db->insert_id();

                if(isset($_FILES["file"]['name'])){

                    $ruta = "asset/administrativo/imgarticulos/"; // la ruta
                    $nombreimagen = $_FILES["file"]['name'];

                    $info = new SplFileInfo($nombreimagen);
                    $valores = $info->getExtension();

                    $mi_archivo ='file';
                    $config['upload_path'] = $ruta;
                    $config['file_name'] =$ultimoId;
                    $config['allowed_types'] = "jpg|png|jpeg";
                    $config['max_size'] = 0;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;

                    $this->load->library('upload', $config);

                    //$mi_archivo = simpleresize($mi_archivo, 200, 85);

                    if ($this->upload->do_upload($mi_archivo)) {}

                    $imagen = $ruta.$ultimoId.".".$valores;
                    $imagennombre = $ultimoId.".".$valores;

                    $data1=array(
                        'imageurl'=>$imagen,
                        'imagenombre'=>$imagennombre,
                    );
                
                    $sql_query=$this->db->where('id',$ultimoId)->update('tbl_articulos', $data1);
                }

                return 0;
            }
        }else{  

            $data=array(
                'categoria'=>$categoria,
                'subcategoria'=>$subcategoria,
                'nomart'=>$nomart,
                'valart'=>$valart,
                'qtyart'=>$qtyart,
                'descripcion'=>$descripcion,
                'tipopromo'=>$tipopromo,
                'fechamod'=>$fecha,
                'usuariomod'=>$usuario,
            );
        
            $sql_query=$this->db->where('id', $id)->update('tbl_articulos', $data);

            if(isset($_FILES["file"]['name'])){

                $ruta = "asset/administrativo/imgarticulos/"; // la ruta
                $nombreimagen = $_FILES["file"]['name'];
                $rutavieja = $urlimg;
            
                $info = new SplFileInfo($nombreimagen);
                $valores = $info->getExtension();

                $mi_archivo ='file';
                $config['upload_path'] = $ruta;
                $config['file_name'] =$id;
                $config['allowed_types'] = "jpg|png|jpeg";
                $config['max_size'] = 0;
                $config['max_width'] = 0;
                $config['max_height'] = 0;

                $this->load->library('upload', $config);

                $exists = is_file( $rutavieja);//verifica si existe la imagen manda un 1 si existe

                if($exists == 1){

                    unlink($rutavieja);//borra la imagen si existe
        
                }
                

                if ($this->upload->do_upload($mi_archivo)) {}

                $imagen = $ruta.$id.".".$valores;
                $imagennombre = $id.".".$valores;

                $data1=array(
                    'imageurl'=>$imagen,
                    'imagenombre'=>$imagennombre,
                );
            
                $sql_query=$this->db->where('id',$id)->update('tbl_articulos', $data1);
            }

            return 0;
        }
       
    }

    function geteliminar()
    {
        $id         =   $this->input->post('id');
        $nomart     =   $this->input->post('nomart');
        $usuario    =   $this->session->userdata('id_usuario');
        $fecha      =   date("Y-m-d h:i:s");

        
        $data=array(
            'fechamod'=>$fecha,
            'usuariomod'=>$usuario,
            'estado'=>2,
        );
    
        $sql_query=$this->db->where('id', $id)->update('tbl_articulos', $data);
    }

    function simpleresize($filename, $width, $height) {
		$config['image_library'] = 'gd2';
		$config['source_image'] = FCPATH . 'upload/'.'/'.$filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['new_image'] = FCPATH . 'image/cache'.'/'.$width.'x'.$height.'-'.$filename;

		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config); 

		return $this->image_lib->resize();
    }
    
    function sincroArticulos(){
        $articulos = ApiRest::getArticulos();
        $usuario = $this->session->userdata('id_usuario');
        $sincroestado = 1;
        $fecha      =   date("Y-m-d h:i:s");
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        foreach ($articulos as $key => $value) {

            $codart = $value['codart'];
            $data = array(
                'categoria'     => $value['categoria'],
                'subcategoria'  => $value['codsubcate'],
                'codart'        => $value['codart'],
                'nomart'        => $value['nomart'],
                'valart'        => $value['valart'],
                'qtyart'       => $value['qtyart'],
                'iva'            => $value['ivaart'],
                'descripcion'   => $value['descripcion'],
                'referencia'   => $value['referencia'],
                'fechacrea'     => $fecha,
                'fechamod'      => $fecha,
                'usuariocrea'   => $usuario,
                'usuariomod'    => $usuario,
                'estado'        => 1,
                'sincroestado'  => 1

            );
            $dataupdate = array(
                'categoria'     => $value['categoria'],
                'subcategoria'  => $value['codsubcate'],
                'codart'        => $value['codart'],
                'nomart'        => $value['nomart'],
                'valart'        => $value['valart'],
                'qtyart'       => $value['qtyart'],
                'iva'            => $value['ivaart'],
                'referencia'   => $value['referencia'],
                'descripcion'   => $value['descripcion'],
                //'fechacrea'     => $fecha,
                'fechamod'      => $fecha,
               // 'usuariocrea'   => $usuario,
                'usuariomod'    => $usuario,
                //'estado'        => 1,
               // 'sincroestado'  => 1

            );


            
            $this->db->select(' codart ');
            $this->db->from('tbl_articulos');
            $this->db->where('codart',$codart);
            $rest=$this->db->get();

            $rows = $rest->num_rows();
            
            if($rows === 0){
                $sql_query=$this->db->insert('tbl_articulos',$data);
                if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                $sql_query=$this->db->where('codart',$codart)->update('tbl_articulos', $dataupdate);
                if($sql_query){
                    $cont++;
                }
            }
            

            

            if(count($articulos) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
                return $result;
            }
             
        }

        return $result;
    }

    function sincroVariantes(){
        $variantes = ApiRest::getVariantes();
        $sincroestado = 1;
        $fecha      =   date("Y-m-d h:i:s");
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        foreach ($variantes as $key => $value) {
            $codartvar =$value['codartvar'];
            $codart = $value['codart'];
                $data = array(
                    'nomvar'       => $value['nomvar'],
                    'codartvar'    => $value['codartvar'],
                    'nomartvar'    => $value['nomartvar'],
                    'codart'       => $value['codart'],
                    'qtyart'       => $value['stock'],

                    'fechacrea'    => $fecha,
                    'sincroestado' => $sincroestado
                );

                $dataupdate = array(
                    'nomvar'       => $value['nomvar'],
                    'codartvar'    => $value['codartvar'],
                    'nomartvar'    => $value['nomartvar'],
                    'codart'       => $value['codart'],
                    'qtyart'       => $value['stock'],
                    'fechacrea'    => $fecha,
                    'sincroestado' => $sincroestado
                );
                $comp = array( 'codartvar' => $codartvar, 'codart' =>$codart );
                $this->db->select(' codartvar ');
            $this->db->from('tbl_variante');
            $this->db->where($comp);
            
            $select = 'select * from tbl_variante';
            $where  = "where codart = '".$codart."'";
            $where2 = "and codartvar = '".$codartvar."'";

            $query= $this->db->query($select." ".$where." ".$where2);

            $rows = $query->num_rows();
            echo $rows;
            if($rows === 0){
                $sql_query=$this->db->insert('tbl_variante',$data);
                if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                
                $sql_query=$this->db->where($comp)->update('tbl_variante', $dataupdate);
                if($sql_query){
                    $cont++;
                }
            }
                
            if(count($variantes) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
                return $result;
            }
             
        }

        return $result;
    }

    function sincroFormapago(){
        $formapagos = ApiRest::requestApiFormaPago();
        $cont = 0;
        $comp = 0;
        if($formapagos != null && sizeof($formapagos) != 0){
            foreach($formapagos as $key => $value ){
                $codfp = $value['codfor'];
    
                $data = array(
                    'codformapago' => $value['codfor'],
                    'nombre'       => $value['nomfro']
                );
    
                $dataupdate = array(
                    'codformapago' => $value['codfor'],
                    'nombre'       => $value['nomfro']
                );
    
                $query = $this->db->query('select * from forma_pago where codformapago = "'.$codfp.'"');
    
                $rows = $query->num_rows();
    
                if($rows == 0){
                    $sql_query=$this->db->insert('forma_pago',$data);
                    if($sql_query){
                        $cont++;
                    }
                }elseif($rows > 0){
                    $sql_query=$this->db->where('codformapago', $codfp)->update('forma_pago', $dataupdate);
                   
                }
                $comp++;
            }
        }

        if($cont == $comp){
            return 1;
        }else{
            return 0;
        }
    }

    function sincroDptoCiudades(){

        $Dptos = ApiRest::requestApiDpto();
        $cont = 0;
        $comp = 0;
        if($Dptos != null && sizeof($Dptos) != 0){
            foreach($Dptos as $key => $value){
                $coddpto = $value['coddpto'];
    
                $data = array(
                    'coddpto' => $value['coddpto'],
                    'nomdpto' => $value['nomdpto']
                );
    
                $dataupdate = array(
                    'coddpto' => $value['coddpto'],
                    'nomdpto' => $value['nomdpto']
                );
    
                $query = $this->db->query('select * from tbl_dpto where coddpto = "'.$coddpto.'"');
    
                $rows = $query->num_rows();
    
                if($rows == 0){
                    $sql_query=$this->db->insert('tbl_dpto',$data);
                    if($sql_query){
                        $cont++;
                    }
                }elseif ($rows > 0) {
                    $sql_query=$this->db->where('coddpto', $coddpto)->update('tbl_dpto', $dataupdate);
                      
                }
                $comp++;
            }
        }

        self::sincroCiudades();
        if($cont == $comp){
            return 1;
        }else{
            return 0;
        }
    }

    function sincroCiudades(){
        
        $dpto = $this->db->query('select * from tbl_dpto');

        foreach ($dpto->result() as $key1 => $value1) {

            $coddpto = $value1->coddpto;
            $ciudades = ApiRest::requestApiCiudades($coddpto);
           
        foreach ($ciudades as $key => $value) {
            $codciud = $value['codciud'];
            $data = array(
                'codciud' => $value['codciud'],
                'nomciud' => $value['nomciud'],
                'coddpto'  => $coddpto
            );

            $dataupdate = array(
                'codciud' => $value['codciud'],
                'nomciud' => $value['nomciud'],
                'coddpto'  => $coddpto
            );

            $query2 = $this->db->query('select * from tbl_ciudad where codciud = "'.$codciud.'" and coddpto = "'.$coddpto.'"');

            $row2 = $query2->num_rows();

            if($row2 == 0){
                $sql_query=$this->db->insert('tbl_ciudad',$data);
                
            }elseif ($row2 > 0) {
                $sql_query=$this->db->where('codciud', $codciud)->update('tbl_ciudad', $dataupdate);
                  
            }

           
        }

        }

        
    }

    function sincroDomBarrios(){
        $barrios = ApiRest::requestApiDomBarrios();
        $cont = 0;
        $comp = 0;
       
        if($barrios != null && sizeof($barrios) != 0){

            foreach ($barrios as $key => $value) {
                $codbarr = $value['codbarr'];
                $data= array(
                    "codbarr" => $value['codbarr'],
                    "nombarr" => $value['nombarr'],
                    "nomzona1" => $value['nomzona1'],
                    "nomzona2" => $value['nomzona2'],
                    "horaini1" => $value['horaini1'],
                    "horafin1" => $value['horafin1'],
                    "horaini2" => $value['horaini2'],
                    "horafin2" => $value['horafin2'],
                    "valor1" => $value['valor1'],
                    "valor2" => $value['valor2']
                );
               // echo json_encode($data);
                $query = $this->db->query('select * from dom_barrios where codbarr = "'.$codbarr.'"');
                $rows = $query->num_rows();
                if($rows == 0){
                    $sql_query=$this->db->insert('dom_barrios',$data);
                    if($sql_query){
                        $cont++;
                    }    
                }elseif($rows > 0){
                    $sql_query=$this->db->where('codbarr', $codbarr)->update('dom_barrios', $data);  
                }
                $comp++;
            }

        }

        if($cont == $comp){
            return 1;
        }else{
            return 0;
        }

    }


    function cargarMenu()
    {

        $nombre     =   $this->input->post('nombre');
        

        if(isset($_FILES["file"]['name'])){

            $ruta         = "asset/administrativo/pdf/"; // la ruta
            $nombrearchivo = $_FILES["file"]['name'];

            $info = new SplFileInfo($nombrearchivo);
            $valores = $info->getExtension();

            $mi_archivo ='file';
            $config['upload_path'] = $ruta;
            $config['file_name'] ='menu';
            $config['allowed_types'] = "pdf|PDF";
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;

            $this->load->library('upload', $config);
            $directorio2 = $ruta."menu.".$valores;
            
            //$conn_id = ftp_connect('45.89.204.178');
            //$login_result = ftp_login($conn_id,'u293118005.global','Global2020');
            //$directorio2 = 'ftp://u293118005.global:Global2020@45.89.204.178'.$directorio;
            //creacion y asignacion de directorio para el JSON
            if(file_exists($directorio2)){
               
                    $borrado = ApiRest::borrarJson();   

            }

            if ($this->upload->do_upload($mi_archivo)) {}

            $imagen = $ruta."menu.".$valores;
            $imagennombre = "menu.".$valores;

            $data1=array(
                'id' => 1,
                'urlarchivo'=>$imagen,
                'nomarchivo'=>$imagennombre,
            );

            $sql = $this->db->query('select * from tbl_menu where id = 1');

            if($sql->num_rows() == 0){
                $sql_query=$this->db->insert('tbl_menu',$data1); 
                return 1;
            }elseif ($sql->num_rows() != 0) {
                $sql_query=$this->db->where('id', 1)->update('tbl_menu', $data1);
                return 1;
            }   
        }
    
    }


    function getMenu(){
        $sql = $this->db->query('select * from tbl_menu where id = 1');

        if($sql->num_rows() == 0){
            return 0;
        }elseif ($sql->num_rows() <= 1) {
            
            return $sql->result();
        }
    }

    function sincroPromociones(){
        $promociones = ApiRest::requestApiPromociones();
        $usuario = $this->session->userdata('id_usuario');
        $sincroestado = 1;
        $fecha      =   date("Y-m-d h:i:s");
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        foreach ($promociones as $key => $value) {

          
            $idemp = $value['headPromo']['idemp'];
            $codcto = $value['headPromo']['codcto'];
            $numero = $value['headPromo']['numero'];
            

            $data = array(
                'idemp'     => $value['headPromo']['idemp'],
                'codcto'  => $value['headPromo']['codcto'],
                'numero'        => $value['headPromo']['numero'],
                'fecha1'        => $value['headPromo']['fecha1'],
                'fecha2'        => $value['headPromo']['fecha2'],
                'hor1'       => $value['headPromo']['hor1'],
                'min1'   => $value['headPromo']['min1'],
                'jor1'   => $value['headPromo']['jor1'],
                'hor2'     => $value['headPromo']['hor2'],
                'min2'      => $value['headPromo']['min2'],
                'jor2'   => $value['headPromo']['jor2'],
                'dcto'    => $value['headPromo']['dcto'],
                'codusu'    => $value['headPromo']['codusu'],
                'fecsys'    => $value['headPromo']['fecsys'],
                'estado'    => $value['headPromo']['estado'],
                'dia'    => $value['headPromo']['dia'],
                'todo'    => $value['headPromo']['todo'],
                'paga'    => $value['headPromo']['paga'],
                'lleva'    => $value['headPromo']['lleva'],
                'nombre'    => $value['headPromo']['nombre'],
                'cupon'    => $value['headPromo']['cupon'],
                'dLun'    => $value['headPromo']['dLun'],
                'dMar'    => $value['headPromo']['dMar'],
                'dMie'    => $value['headPromo']['dMie'],
                'dJue'    => $value['headPromo']['dJue'],
                'dVie'    => $value['headPromo']['dVie'],
                'dSab'    => $value['headPromo']['dSab'],
                'dDom'    => $value['headPromo']['dDom'],
                'codTarjeta'    => $value['headPromo']['codTarjeta'],
                'topeVtamin'    => $value['headPromo']['topeVtamin'],
                'topeVtamax'    => $value['headPromo']['topeVtamax'],
                'vlrDcto'    => $value['headPromo']['vlrDcto'],
                'unavezxcli'    => $value['headPromo']['unavezxcli'],
                'servidor'    => $value['headPromo']['servidor'],
                'codusumod'    => $value['headPromo']['codusumod'],
                'docdelete'    => $value['headPromo']['docdelete'],
                'modificadoc'    => $value['headPromo']['modificadoc'],
                'codfor'    => $value['headPromo']['codfor']

                

            );
            $dataupdate = array(
                'idemp'     => $value['headPromo']['idemp'],
                'codcto'  => $value['headPromo']['codcto'],
                'numero'        => $value['headPromo']['numero'],
                'fecha1'        => $value['headPromo']['fecha1'],
                'fecha2'        => $value['headPromo']['fecha2'],
                'hor1'       => $value['headPromo']['hor1'],
                'min1'   => $value['headPromo']['min1'],
                'jor1'   => $value['headPromo']['jor1'],
                'hor2'     => $value['headPromo']['hor2'],
                'min2'      => $value['headPromo']['min2'],
                'jor2'   => $value['headPromo']['jor2'],
                'dcto'    => $value['headPromo']['dcto'],
                'codusu'    => $value['headPromo']['codusu'],
                'fecsys'    => $value['headPromo']['fecsys'],
                'estado'    => $value['headPromo']['estado'],
                'dia'    => $value['headPromo']['dia'],
                'todo'    => $value['headPromo']['todo'],
                'paga'    => $value['headPromo']['paga'],
                'lleva'    => $value['headPromo']['lleva'],
                'nombre'    => $value['headPromo']['nombre'],
                'cupon'    => $value['headPromo']['cupon'],
                'dLun'    => $value['headPromo']['dLun'],
                'dMar'    => $value['headPromo']['dMar'],
                'dMie'    => $value['headPromo']['dMie'],
                'dJue'    => $value['headPromo']['dJue'],
                'dVie'    => $value['headPromo']['dVie'],
                'dSab'    => $value['headPromo']['dSab'],
                'dDom'    => $value['headPromo']['dDom'],
                'codTarjeta'    => $value['headPromo']['codTarjeta'],
                'topeVtamin'    => $value['headPromo']['topeVtamin'],
                'topeVtamax'    => $value['headPromo']['topeVtamax'],
                'vlrDcto'    => $value['headPromo']['vlrDcto'],
                'unavezxcli'    => $value['headPromo']['unavezxcli'],
                'servidor'    => $value['headPromo']['servidor'],
                'codusumod'    => $value['headPromo']['codusumod'],
                'docdelete'    => $value['headPromo']['docdelete'],
                'modificadoc'    => $value['headPromo']['modificadoc'],
                'codfor'    => $value['headPromo']['codfor']

                

            );

          
            // $this->db->select(' idemp ');
            // $this->db->from('headpromo');
            // $this->db->where('idemp',$codart);
            // $rest=$this->db->get();
              
            $select = 'select * from headpromo';
           
            $where = "where idemp = '".$idemp."'";
            $where2 = "and codcto = '".$codcto."'";
            $where3 = "and numero = '".$numero."'";
            $query= $this->db->query($select." ".$where." ".$where2." ".$where3);


            $rows = $query->num_rows();
            
            if($rows === 0){
                $sql_query=$this->db->insert('headpromo',$data);
        
                if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                $sql_query=$this->db->where('numero',$numero)->update('headpromo', $dataupdate);
             
                if($sql_query){
                    $cont++;
                }
            }
            if(count($promociones) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
                
            }
            
        }
        return $result;   
    }

    function sincrodetPromo(){

        $promociones = ApiRest::requestApiPromociones();
        $usuario = $this->session->userdata('id_usuario');
        $sincroestado = 1;
        $fecha      =   date("Y-m-d h:i:s");
        $cont = 1;
        $result = array( 'respuesta' =>'false', 'contador' =>0);
        
        foreach ($promociones as $key => $value) {
            
            foreach($value['detPromo'] as $key1 => $value1){
                $idemp = $value1['idemp'];
                $codcto = $value1['codcto'];
                $numero = $value1['numero'];
                $codart = $value1['codart'];
                
                $data = array(
                    'idemp'     => $value1['idemp'],
                    'codcto'    => $value1['codcto'],
                    'numero'    => $value1['numero'],
                    'codart'    => $value1['codart'],
                    'vrdcto'    => $value1['vrdcto'],
                    'item'      => $value1['item'],
                    'artPaga'   => $value1['artPaga'],
                    'artlleva'  => $value1['artlleva'],
                    'fecsys'    => $value1['fecsys'],
                    'servidor'  => $value1['servidor'],
                    'codusumod' => $value1['codusumod'],
                    'codusu'    => $value1['codusu'],
                    'docdelete' => $value1['docdelete'],
                    'modificadoc' => $value1['modificadoc']
    
                );
                $dataupdate = array(
                   // 'idemp'     => $value1['idemp'],
                   // 'codcto'    => $value1['codcto'],
                    //'numero'    => $value1['numero'],
                    //'codart'    => $value1['codart'],
                    'vrdcto'    => $value1['vrdcto'],
                    'item'      => $value1['item'],
                    'artPaga'   => $value1['artPaga'],
                    'artlleva'  => $value1['artlleva'],
                    'fecsys'    => $value1['fecsys'],
                    'servidor'  => $value1['servidor'],
                    'codusumod' => $value1['codusumod'],
                    'codusu'    => $value1['codusu'],
                    'docdelete' => $value1['docdelete'],
                    'modificadoc' => $value1['modificadoc']
    
                );
                
            /* $this->db->select(' idemp ');
            $this->db->from('detpromo');
            $this->db->where('idemp',$idemp);
            $rest=$this->db->get(); */
             
            $select = 'select * from detpromo';
            $where  = "where codart = '".$codart."'";
            $where2 = " and idemp = '".$idemp."'";
            $where3 = " and codcto = '".$codcto."'";
            $where4 = " and numero = '".$numero."'";
            $query= $this->db->query($select." ".$where." ".$where2." ".$where3." ".$where4);

            $rows = $query->num_rows();
            
            if($rows === 0){
                $sql_query=$this->db->insert('detpromo',$data);
        
                if($sql_query){
                    $cont++;
                }
            } elseif($rows > 0){
                $sql_query=$this->db->where('codart',$codart)->where('numero',$numero)->where('codcto',$codcto)->where('idemp',$idemp)->update('detpromo', $dataupdate);
             
                if($sql_query){
                    $cont++;
                }
            }
            if(count($value['detPromo']) === $cont){
                $result['respuesta'] = $sql_query;
                $result['contador']  = $cont; 
              
            }
                
            }
        }
        return $result; 

    }
}