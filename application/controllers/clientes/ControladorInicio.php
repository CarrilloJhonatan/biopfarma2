<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorInicio extends CI_Controller
{
    function __construct(){
		parent::__construct();
		//$this::cargarCredenciales();
		/*if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }*/
		$this->load->model('clientes/ModeloInicio');
	
	}


	function index()
    {
		
	
		$this->load->view('clientes/componentes/header');
		$this->load->view('clientes/componentes/menu');
		$this->load->view('clientes/modales');
		$this->load->view('clientes/welcome');
		
		$this->load->view('clientes/componentes/footer');
    }
    
	public function todo()
	{
		$data=$this->ModeloInicio->gettodo();
		echo json_encode($data);
	}

	public function slaider()
	{
		$data=$this->ModeloInicio->getslaider();
		echo json_encode($data);
	}

	public function cargarpedido(){
		$data=$this->ModeloInicio->getcargarpedido();
		echo json_encode($data);
	}

	function productos()
    {	
	
		$categoria = $this->input->post('categoria');
		
		
		$subcate = $this->input->post('subcategoria');
		$nomsubcate = $this->input->post('nomsubcategoria');
		$input_tbl = $this->input->post('input_tbl');
		$input_elegido = $this->input->post('input_elegido');
		$numfila	= $this->input->post('numfila');

		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$codpedido = substr(str_shuffle($permitted_chars), 0, 13);
 
		$this->load->view('clientes/componentes/header');
		$this->load->view('clientes/modales');
		$this->load->view('clientes/componentes/menu');
		$this->load->view('clientes/categorias',['result'=>$categoria,'result2'=>$subcate,'result3'=>$input_tbl,'result4'=>$input_elegido, 'result5'=>$nomsubcate, 'result6'=>$numfila, 'result7'=>$codpedido]);
		$this->load->view('clientes/componentes/footer');
	}

	function miscompras(){
		$data=$this->ModeloInicio->getmiscompras();
		echo json_encode($data);
	}
	function articulosp(){
		$data=$this->ModeloInicio->getarticulos();
		echo json_encode($data);
	}

	public function verificarcodprom(){
		$data=$this->ModeloInicio->getverificarcodprom();
		echo json_encode($data);
	}

	public function cargarvalores(){
		$data=$this->ModeloInicio->cargarvalores();
		echo json_encode($data);
	}
}