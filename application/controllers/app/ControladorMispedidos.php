<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorMispedidos extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('app/ModeloMispedidos');
	
    }

    function todo()
    {
        $data = $this->ModeloMispedidos->gettodo();

        echo json_encode($data);
    }

    function articulos()
    {
        $data = $this->ModeloMispedidos->getarticulos();

        echo json_encode($data);
    }

}

?>