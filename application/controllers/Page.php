<?php
class Page extends CI_Controller
{
  
  function __construct()
  {
    parent::__construct();
  /*  if($this->session->userdata('logged_in') !== TRUE)
    {
      redirect('login');
    }*/

    if($this->session->userdata('logged_in') !== TRUE	){
			$permitted_chars = '123456789';
      $tipo_cliente = 2; //Restaurante
      //$tipo_cliente = 1;  //Restaurante
      //$tipo_cliente = 2;  //Comercial
			$codtemp = substr(str_shuffle($permitted_chars), 0, 10);
			$sesdata = array(
				'id_usuario'        => $codtemp,
        'logged_in'         => TRUE,
        'tipo_cliente'      => $tipo_cliente,
			);
			  $this->session->set_userdata($sesdata);
		}
    
  }

  function index()
  {
    //Allowing akses to admin only
      if($this->session->userdata('tipo_usuario')==='1')
      {
       
          $this->load->view('administrativo/componentes2/header');
          $this->load->view('administrativo/componentes2/menu');
          $this->load->view('administrativo/pedidos/vista_pedidos');
          $this->load->view('administrativo/componentes2/footer');

          
         
      }
      elseif($this->session->userdata('tipo_usuario')==='2')
      {
        if($this->session->userdata('tipo_cliente') == '2' ){
          $this->load->view('clientes/componentes/header');
          $this->load->view('clientes/modales'); 
          $this->load->view('clientes/componentes/menu');
          $this->load->view('clientes/welcome');
          $this->load->view('clientes/componentes/footer');
        }
        
        if($this->session->userdata('tipo_cliente') == '1' ){
         /* $this->load->view('clientes/componentes/header');
          $this->load->view('clientes/componentes/menu');
          $this->load->view('clientes/modales'); 
          $this->load->view('clientes/welcome');
          $this->load->view('clientes/componentes/footer');
         */
        $this->load->view('app/componentes/header');
        $this->load->view('app/componentes/menu');
        $this->load->view('app/welcome');
        $this->load->view('app/componentes/footer');
        }

      }
      elseif($this->session->userdata('tipo_usuario')==='3')
      {
        $this->load->view('administrativo/componentes2/header');
        $this->load->view('administrativo/componentes2/menu');
        $this->load->view('administrativo/welcome');
        $this->load->view('administrativo/componentes2/footer');

      }
      elseif(empty($this->session->userdata('tipo_usuario')))
      { 
        if($this->session->userdata('tipo_cliente') == '2' ){
          
          $this->load->view('clientes/componentes/header');
          $this->load->view('clientes/modales'); 
          $this->load->view('clientes/componentes/menu');
          $this->load->view('clientes/welcome');
          $this->load->view('clientes/componentes/footer');
        }
        
        if($this->session->userdata('tipo_cliente') == '1' ){
          /* $this->load->view('administrativo/componentes2/header');
          $this->load->view('administrativo/componentes2/menu');
          $this->load->view('administrativo/pedidos/vista_pedidos');
          $this->load->view('administrativo/componentes2/footer');
         */
        $this->load->view('app/componentes/header');
        $this->load->view('app/componentes/menu');
        $this->load->view('app/welcome');
        $this->load->view('app/componentes/footer');
        }
      }
      else
      {
        echo "Access Denied";
      }
  }

  /*function staff(){
    //Allowing akses to staff only
    if($this->session->userdata('level')==='2'){
          $this->load->view('componentes/header');
          $this->load->view('componentes/menu');
          $this->load->view('dashboard_view');
          $this->load->view('componentes/footer');
    }else{
        echo "Access Denied";
    }
  }

  function author(){
    //Allowing akses to author only
    if($this->session->userdata('level')==='3'){
          $this->load->view('componentes/header');
          $this->load->view('componentes/menu');
          $this->load->view('dashboard_view');
          $this->load->view('componentes/footer');
    }else{
        echo "Access Denied";
    }
  }
*/
}
