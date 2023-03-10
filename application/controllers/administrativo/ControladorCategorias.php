<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorCategorias extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloCategorias');
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/categorias/vista_categorias');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloCategorias->gettodo();
		echo json_encode($data);
	}

	public function guardar()
	{
		$data=$this->ModeloCategorias->getguardar();
		echo json_encode($data);
	}

	public function eliminar()
	{
		$data=$this->ModeloCategorias->geteliminar();
		echo json_encode($data);
	}

	public function sincroCategorias()
	{
		$data=$this->ModeloCategorias->sincroCategorias();
		echo json_encode($data);
	}


}
?>