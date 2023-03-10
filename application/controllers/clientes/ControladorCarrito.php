<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorCarrito extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('clientes/ModeloCarrito');
	
    }
    
	public function guardar()
	{
		$data=$this->ModeloCarrito->getguardar();
		echo json_encode($data);
	}

	public function total()
	{
		$data=$this->ModeloCarrito->gettotal();
		echo json_encode($data);
	}
	
	public function todo()
	{
		$data=$this->ModeloCarrito->gettodo();
		echo json_encode($data);
	}

	public function eliminar()
	{
		$data=$this->ModeloCarrito->geteliminar();
		echo json_encode($data);
	}

	
	

}