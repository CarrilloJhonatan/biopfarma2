<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('ModeloLogear');
    
  }

  function index(){
    
    $this->load->view('iniciarsesion');
  }

  function auth(){
    $email      = $this->input->post('email',TRUE);
    $password   = md5($this->input->post('password',TRUE));
    $validate   = $this->ModeloLogear->validate($email,$password);
   
    if($validate->num_rows() > 0)
    {
        $data  = $validate->row_array();

        $id_usuario         = $data['u_id'];
        $nit_tusuario       = $data['u_nitter'];
        $usuario            = $data['u_usuario'];
        $nombre_usuario     = $data['u_username'];
        $tipo_usuario       = $data['u_tipo'];
        $correo             = $data['u_email'];
        $direccion          = $data['u_direccion'];
        $telefono           = $data['u_telefono'];
        $genero             = $data['u_genero'];
        $ciudad             = $data['u_ciudad'];
        $tipo_cliente = 2; //Restaurante
        //$tipo_cliente = 1;  //Restaurante
      //$tipo_cliente = 2;  //Comercial
        
        $sesdata = array(
            'id_usuario'        => $id_usuario,
            'usuario'           => $usuario,
            'username'          => $nombre_usuario,
            'correo'            => $correo,
            'nit_tusuario'      => $nit_tusuario,
            'nombre_usuario'    => $nombre_usuario,
            'tipo_usuario'      => $tipo_usuario,
            'direccion'         => $direccion,
            'telefono'          => $telefono,
            'genero'            => $genero,
            'ciudad'            => $ciudad,
            'logged_in'         => TRUE,
            'tipo_cliente'      => $tipo_cliente,
        );

        
        $this->session->set_userdata($sesdata);
        
        // access login for admin
        if($tipo_usuario === '1'){
            redirect('page');

        // access login for staff
        }elseif($tipo_usuario === '2'){
            redirect('page');

        // access login for author
        }elseif($tipo_usuario === '3'){
          redirect('page');

      // access login for author
        }else{
            redirect('page');
        }
    }else{

       
            echo $this->session->set_flashdata('msg',' <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger"><strong>MENSAJE!</strong> <br><hr> <p>Algo salio mal revise el Usuario o contraseña  </p></div>
            </div>
        </div>');
    redirect('login');
        
        
       

        
    }
  }
  function cambiarPass(){

    $email      = $this->input->post('email',TRUE);
    $pass1   = md5($this->input->post('pass1',TRUE));
    $pass2   = md5($this->input->post('pass2',TRUE));

    $query  = $this->db->query('select * from tbl_usuarios where u_email = "'.$email.'"');



    if($query->num_rows() > 0){
      if($pass1 != $pass2){
        echo $this->session->set_flashdata('msg',' <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-danger"><strong>MENSAJE!</strong> <br><hr> <p>Las contraseñas no coinciden</p></div>
              </div>
          </div>');
      redirect('ControladorPassword');
      }
      else{
        $this->db->where('u_email', $email);
        $this->db->set('u_password', $pass1);
        $res = $this->db->update('tbl_usuarios');

        if($res){
          echo $this->session->set_flashdata('msg',' <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-success"><strong>MENSAJE!</strong> <br><hr> <p>Contraseña cambiada exitosamente!</p></div>
              </div>
          </div>');
          redirect('login');
        }else{
          echo $this->session->set_flashdata('msg',' <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-danger"><strong>MENSAJE!</strong> <br><hr> <p>Ocurrio un error, vuelva a intentarlo.
              </div>
          </div>');
      redirect('ControladorPassword');
        }
      }
    }else{
      echo $this->session->set_flashdata('msg',' <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger"><strong>MENSAJE!</strong> <br><hr> <p>El correo ingresado no esta asociado a ningun usuario.</p></div>
            </div>
        </div>');
    redirect('ControladorPassword');
    }
    

    
  }

  function login(){
    redirect('login');
  }

  function logout(){
      $this->session->sess_destroy();
      redirect('Page');
  }

}
