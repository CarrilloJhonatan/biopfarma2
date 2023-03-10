<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorPromo extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloPromo');
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/promociones/vista_promo');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloPromo->gettodo();
		echo json_encode($data);
	}

	public function detalle()
	{
		$data=$this->ModeloPromo->getDetalle();
		echo json_encode($data);
	}

	public function articulo()
	{
		$data=$this->ModeloPromo->getArticulo();
		echo json_encode($data);
	}

	public function detalleResumen()
	{
		$data=$this->ModeloPromo->getDetalleResumen();
		
		echo json_encode($data);
	}

	public function cancelar()
	{
		$data=$this->ModeloPromo->cancelpedido();
		
		echo json_encode($data);
	}
}
?>