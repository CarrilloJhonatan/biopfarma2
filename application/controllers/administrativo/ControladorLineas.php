<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorLineas extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloLineas');
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/lineas/vista_lineas');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloLineas->gettodo();
		echo json_encode($data);
	}

	public function guardar()
	{
		$data=$this->ModeloLineas->getguardar();
		echo json_encode($data);
	}

	public function eliminar()
	{
		$data=$this->ModeloLineas->geteliminar();
		echo json_encode($data);
	}

	public function sincroSubcategorias()
	{
		$data=$this->ModeloLineas->sincroSubcategorias();
		echo json_encode($data);
	}


}
?>