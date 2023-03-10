<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorRegistrar extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('ModeloRegistrar');
	}
	
	public function index()
	{
		$this->load->view('registrar');
	}

	public function guardar()
	{
		$data=$this->ModeloRegistrar->getguardar();
		echo json_encode($data);
    }

	public function getCiudad()
	{
		$data=$this->ModeloRegistrar->getCiudad();
		echo json_encode($data);
    }
}
