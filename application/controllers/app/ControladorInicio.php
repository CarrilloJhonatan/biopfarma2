<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorInicio extends CI_Controller
{
    function __construct(){
		parent::__construct();
		/*if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }*/
		$this->load->model('app/ModeloInicio');
		
	
	}
	
	function index()
    {
		
	
		$this->load->view('app/componentes/header');
		$this->load->view('app/componentes/menu');
		$this->load->view('app/welcome');
		
		$this->load->view('app/componentes/footer');
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
 
		$this->load->view('app/componentes/header');
		$this->load->view('app/componentes/menu');
		$this->load->view('app/categorias',['result'=>$categoria,'result2'=>$subcate,'result3'=>$input_tbl,'result4'=>$input_elegido, 'result5'=>$nomsubcate, 'result6'=>$numfila, 'result7'=>$codpedido]);
		$this->load->view('app/componentes/footer');
	}
	
	public function variante()
	{
		$data=$this->ModeloInicio->getvariante();
		echo json_encode($data);
	}

	public function subcategorias(){

		$categoria = $this->input->post('categoria');
		$subcate = $this->input->post('nombre');
		
		
		$this->load->view('app/componentes/header');
		$this->load->view('app/componentes/menu');
		$this->load->view('app/subcategorias',['result'=>$categoria,'result2'=>$subcate]);
		$this->load->view('app/componentes/footer');
	}

	public function cargarpedido(){
		$data=$this->ModeloInicio->getcargarpedido();
		echo json_encode($data);
	}

	public function verificarcodprom(){
		$data=$this->ModeloInicio->getverificarcodprom();
		echo json_encode($data);
	}
	

}