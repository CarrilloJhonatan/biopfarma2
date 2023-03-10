<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloRegistrar extends CI_Model
{
    function getguardar()
    {
        $username   =   $this->input->post('username');
        $nitter     =   $this->input->post('nitter');
        $email      =   $this->input->post('email');
        $password   =   $this->input->post('password');
        $telefono   =   $this->input->post('telefono');
        $direccion  =   $this->input->post('direccion');
        $dpto       =   $this->input->post('dpto');
        $ciudad     =   $this->input->post('ciudad');
        $genero     =   $this->input->post('genero');

        $fecha = date("Y-m-d h:i:s");

        $this->db->select(' u_usuario ');
        $this->db->from('tbl_usuarios');
        $this->db->where('u_usuario',$email);
        $rest=$this->db->get();

        if($rest->num_rows()==1)
        {
            return $rest->num_rows();
        }
        else if($rest->num_rows()==0)
        {

            $data=array(
                'u_nitter'=>$nitter,
                'u_usuario'=>$email,
                'u_username'=>$username,
                'u_tipo'=>2,
                'u_email'=>$email,
                'u_password'=>md5($password),
                'u_telefono'=>$telefono,
                'u_direccion'=>$direccion,
                'u_fechacrea'=>$fecha,
                'u_fechamod'=>$fecha,
                'u_usuariocrea'=>0,
                'u_usuariomod'=>0,
                'u_estado'=>1,
                'u_genero' => $genero,
                'u_ciudad' => $ciudad
            );
        
            $sql_query=$this->db->insert('tbl_usuarios',$data);

            return $rest->num_rows();
        }
    }

    function getCiudad(){
        $coddpto   =   $this->input->post('coddpto');
        $select ='SELECT * ';
        $from = 'FROM tbl_ciudad ';
        $where= 'WHERE coddpto = "'.$coddpto.'"';
        $rest=$this->db->query($select.$from.$where);
        return $rest->result();
        
    }
}