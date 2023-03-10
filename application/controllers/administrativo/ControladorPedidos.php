<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorPedidos extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloPedidos');
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/pedidos/vista_pedidos');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloPedidos->gettodo();
		echo json_encode($data);
	}

	public function detalle()
	{
		$data=$this->ModeloPedidos->getDetalle();
		echo json_encode($data);
	}

	public function articulo()
	{
		$data=$this->ModeloPedidos->getArticulo();
		echo json_encode($data);
	}

	public function detalleResumen()
	{
		$data=$this->ModeloPedidos->getDetalleResumen();
		
		echo json_encode($data);
	}

	public function cancelar()
	{
		$data=$this->ModeloPedidos->cancelpedido();
		
		echo json_encode($data);
	}
}
?>