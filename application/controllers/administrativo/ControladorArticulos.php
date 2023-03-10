<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorArticulos extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('administrativo/ModeloArticulos');
	
    }
    
	public function index()
	{
		$this->load->view('administrativo/componentes2/header');
		$this->load->view('administrativo/componentes2/menu');
		$this->load->view('administrativo/articulos/vista_articulos');
		$this->load->view('administrativo/componentes2/footer');
	}

	public function todo()
	{
		$data=$this->ModeloArticulos->gettodo();
		echo json_encode($data);
	}
	public function todopromo()
	{
		$data=$this->ModeloArticulos->gettodopromo();
		echo json_encode($data);
	}

	public function categoria()
	{
		$data=$this->ModeloArticulos->getcategoria();
		echo json_encode($data);
	}

	public function subcategoria()
	{
		$data=$this->ModeloArticulos->getsubcategoria();
		
		echo json_encode($data);
	}

	public function guardar()
	{
		$data=$this->ModeloArticulos->getguardar();
		echo json_encode($data);
	}

	public function eliminar()
	{
		$data=$this->ModeloArticulos->geteliminar();
		echo json_encode($data);
	}

	public function sincroArticulos()
	{
		$data=$this->ModeloArticulos->sincroArticulos();
		echo json_encode($data);
	}

	public function sincroVariantes()
	{
		$data=$this->ModeloArticulos->sincroVariantes();
		echo json_encode($data);
	}
	public function sincroOtros()
	{
		$fp=$this->ModeloArticulos->sincroFormapago();
		$dc=$this->ModeloArticulos->sincroDptoCiudades();
		$db=$this->ModeloArticulos->sincroDomBarrios();

		$data = $fp + $dc + $db;
		//$data = $fp + $dc;
		echo json_encode($data);
	}

	public function menu()
	{
		$data = $this->ModeloArticulos->cargarMenu();
		echo json_encode($data);
	}

	public function getmenu()
	{
		$data = $this->ModeloArticulos->getMenu();
		echo json_encode($data);
	}

	public function sincropromos(){
		$data = $this->ModeloArticulos->sincroPromociones();
		echo json_encode($data);
	}

	public function sincrodetPromo(){
		$data = $this->ModeloArticulos->sincrodetPromo();
		echo json_encode($data);
	}


}
?>