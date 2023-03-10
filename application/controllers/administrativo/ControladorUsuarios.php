<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorUsuarios extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloUsuarios');
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/usuarios/vista_usuarios');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloUsuarios->gettodo();
		echo json_encode($data);
	}

	public function tipo()
	{
		$data=$this->ModeloUsuarios->gettipo();
		echo json_encode($data);
	}

	public function guardar()
	{
		$data=$this->ModeloUsuarios->getguardar();
		echo json_encode($data);
	}

	public function eliminar()
	{
		$data=$this->ModeloUsuarios->geteliminar();
		echo json_encode($data);
	}

	public function pass()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/usuarios/vista_usuarios_pass');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function horario()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/usuarios/vista_horario');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function passguardar()
	{
		$data=$this->ModeloUsuarios->getpassguardar();
		echo json_encode($data);
	}

	public function horarioguardar()
	{
		$data=$this->ModeloUsuarios->gethorarioguardar();
		echo json_encode($data);
	}

	public function gethorario()
	{
		$data=$this->ModeloUsuarios->gethorario();
		echo json_encode($data);
	}


}
?>