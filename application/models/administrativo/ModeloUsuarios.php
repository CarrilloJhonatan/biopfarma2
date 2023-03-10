<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloUsuarios extends CI_Model
{
    function gettodo()
    {
        $this->db->select(' *,
                            (SELECT t_nombre FROM tbl_tipousuarios WHERE t_id = u_tipo) AS tipo,
                            DATE(u_fechamod) AS fecha ');
        $this->db->from('tbl_usuarios');
        $this->db->where('u_estado',1);
        $rest=$this->db->get();
        return $rest->result();
    }

    function gettipo()
    {
        $searchTerm = $this->input->post('searchTerm');

        // Fetch users
        $this->db->select('t_id,t_nombre');
        $this->db->where("t_nombre like '%".$searchTerm."%' ");
        $this->db->where('t_id !=',2);
        $fetched_records = $this->db->get('tbl_tipousuarios');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['t_id'], "text"=>$user['t_nombre']);
        }
        return $data;
      
    }

    function getguardar()
    {
        $id             =   $this->input->post('id');
        $username       =   $this->input->post('username');
        $tipo           =   $this->input->post('tipo');
        $nitter         =   $this->input->post('nitter');
        $usuarioUser    =   $this->input->post('usuarioUser');
        $email          =   $this->input->post('email');
        $password       =   $this->input->post('password');
        $passwordR      =   $this->input->post('passwordR');
        $telefono       =   $this->input->post('telefono');
        $direccion      =   $this->input->post('direccion');

        $usuario = $this->session->userdata('id_usuario');
        
        $fecha = date("Y-m-d h:i:s");

        if($id==0)
        {
            $this->db->select(' u_usuario ');
            $this->db->from('tbl_usuarios');
            $this->db->where('u_usuario',$usuarioUser);
            $rest=$this->db->get();

        
        
            if($rest->num_rows()==1)
            {
                return $rest->num_rows();
            }
            else if($rest->num_rows()==0)
            {

                $data=array(
                    'u_nitter'=>$nitter,
                    'u_usuario'=>$usuarioUser,
                    'u_username'=>$username,
                    'u_tipo'=>$tipo,
                    'u_email'=>$email,
                    'u_password'=>md5($password),
                    'u_telefono'=>$telefono,
                    'u_direccion'=>$direccion,
                    'u_fechacrea'=>$fecha,
                    'u_fechamod'=>$fecha,
                    'u_usuariocrea'=>$usuario,
                    'u_usuariomod'=>$usuario,
                    'u_estado'=>1,
                );
            
                $sql_query=$this->db->insert('tbl_usuarios',$data);

                return $rest->num_rows();
            }
        }else{

            $data=array(
                //'u_nitter'=>$nitter,
                //'u_usuario'=>$usuarioUser,
                'u_username'=>$username,
                //'u_tipo'=>$tipo,
                'u_email'=>$email,
                //'u_password'=>md5($password),
                'u_telefono'=>$telefono,
                'u_direccion'=>$direccion,
                //'u_fechacrea'=>$fecha,
                'u_fechamod'=>$fecha,
                'u_usuariomod'=>$usuario,
                //'u_estado'=>1,
            );
        
            $sql_query=$this->db->where('u_id', $id)->update('tbl_usuarios', $data);

            return 0;
        }
       
    }

    function geteliminar()
    {
        $id =   $this->input->post('id');
        $usuario =$this->session->userdata('id_usuario');
        $fecha = date("Y-m-d h:i:s");

        
        $data=array(
            //'u_nitter'=>$nitter,
            //'u_usuario'=>$usuarioUser,
            // 'u_username'=>$username,
            //'u_tipo'=>$tipo,
            //'u_email'=>$email,
            //'u_password'=>md5($password),
            //'u_telefono'=>$telefono,
            //'u_direccion'=>$direccion,
            //'u_fechacrea'=>$fecha,
            'u_fechamod'=>$fecha,
            'u_usuariomod'=>$usuario,
            'u_estado'=>2,
        );
    
        $sql_query=$this->db->where('u_id', $id)->update('tbl_usuarios', $data);
    }

    function getpassguardar()
    {
        $id             =   $this->input->post('id');
        $password       =   $this->input->post('password');
        $passwordR      =   $this->input->post('passwordR');
        $usuario        =   $this->session->userdata('id_usuario');
        $fecha          =   date("Y-m-d h:i:s");

        
        $data=array(
            //'u_nitter'=>$nitter,
            //'u_usuario'=>$usuarioUser,
            // 'u_username'=>$username,
            //'u_tipo'=>$tipo,
            //'u_email'=>$email,
            'u_password'=>md5($password),
            //'u_telefono'=>$telefono,
            //'u_direccion'=>$direccion,
            //'u_fechacrea'=>$fecha,
            'u_fechamod'=>$fecha,
            'u_usuariomod'=>$usuario,
            //'u_estado'=>1,
        );
    
        $sql_query=$this->db->where('u_id', $id)->update('tbl_usuarios', $data);
    }

    
    function gethorarioguardar(){
        $horainicio       =   $this->input->post('horainicio');
        $horafin      =   $this->input->post('horafin');

        $data = array(
            'horainicio' => $horainicio,
            'horafin'    => $horafin,
            'id'         => 1
        );

        $query = $this->db->query('select * from control_horario where id = 1');
        if($query->num_rows() == 1){
            $sql_query=$this->db->where('id', 1)->update('control_horario', $data);
            return 1;
        }elseif($query->num_rows() == 0){
            $sql_query=$this->db->insert('control_horario',$data);
            return 0;
        }  

    }

    function gethorario(){
        $query = $this->db->query('select * from control_horario where id = 1');

        if($query->num_rows() == 1){
           
            return $query->result();
        }elseif($query->num_rows() == 0){
            
            return false;
        }  
    }

}