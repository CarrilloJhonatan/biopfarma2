<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorVenta extends CI_Controller
{
    function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') !== TRUE)
        {
            redirect('login');
        }
		$this->load->model('clientes/ModeloVenta');
	
    }
    
	public function guardar()
	{
		$data=$this->ModeloVenta->getguardar();
		echo json_encode($data);
	}

	public function respuestaPago(){
		$objeto = new stdClass();
		$objeto->merchantId =$_GET['merchantId'] == null ? "" :$_GET['merchantId'];
		//$objeto->transaccionState =$_GET['transaccionState'] == null ? "" :$_GET['transaccionState'];
		$objeto->risk =$_GET['risk'] == null ? "" :$_GET['risk'] ;
		$objeto->polResponseCode =$_GET['polResponseCode'] == null ? "" :$_GET['polResponseCode'];
		$objeto->referenceCode =$_GET['referenceCode'] == null ? "" :$_GET['referenceCode'];
		$objeto->reference_pol =$_GET['reference_pol'] == null ? "" :$_GET['reference_pol'];
		$objeto->polPaymentMethod =$_GET['polPaymentMethod'] == null ? "" :$_GET['polPaymentMethod'];
		$objeto->polPaymentMethodType =$_GET['polPaymentMethodType'] == null ? "" :$_GET['polPaymentMethodType'];
		$objeto->signature =$_GET['signature'] == null ? "" :$_GET['signature'];
		$objeto->installmentsNumber =$_GET['installmentsNumber'] == null ? "" :$_GET['installmentsNumber'];
		$objeto->TX_VALUE =$_GET['TX_VALUE'] == null ? "" :$_GET['TX_VALUE'];
		$objeto->TX_TAX =$_GET['TX_TAX'] == null ? "" :$_GET['TX_TAX'];
		$objeto->buyerEmail =$_GET['buyerEmail'] == null ? "" :$_GET['buyerEmail']; 
		$objeto->processingDate =$_GET['processingDate'] == null ? "" :$_GET['processingDate']; 
		$objeto->currency =$_GET['currency'] == null ? "" :$_GET['currency']; 
		$objeto->cus =$_GET['cus'] == null ? "":$_GET['cus']; 
		$objeto->pseBank =$_GET['pseBank'] == null ? "" :$_GET['pseBank']; 
		//$objeto->Ing =$_GET['Ing'] == null ? "" :$_GET['Ing']; 
		$objeto->description =$_GET['description'] == null ? "" :$_GET['description']; 
		$objeto->lapResponseCode =$_GET['lapResponseCode'] == null ? "" :$_GET['lapResponseCode']; 
		$objeto->lapPaymentMethod =$_GET['lapPaymentMethod'] == null ? "" :$_GET['lapPaymentMethod']; 
		$objeto->lapPaymentMethodType =$_GET['lapPaymentMethodType'] == null ? "" :$_GET['lapPaymentMethodType']; 
		$objeto->message =$_GET['message'] == null ? "" :$_GET['message']; 
		$objeto->extra1 =$_GET['extra1'] == null ? "" :$_GET['extra1']; 
		$objeto->extra2 =$_GET['extra2'] == null ? "" :$_GET['extra2']; 
		$objeto->extra3 =$_GET['extra3'] == null ? "" :$_GET['extra3']; 
		$objeto->authorizationCode =$_GET['authorizationCode'] == null ? "" :$_GET['authorizationCode']; 
		$objeto->merchant_address =$_GET['merchant_address'] == null ? "" :$_GET['merchant_address']; 
		$objeto->merchant_name =$_GET['merchant_name'] == null ? "" :$_GET['merchant_name']; 
		$objeto->merchant_url =$_GET['merchant_url'] == null ? "" :$_GET['merchant_url']; 
		//$objeto->orderLenguage =$_GET['orderLenguage'] == null ? "" :$_GET['orderLenguage']; 
		$objeto->pseCycle =$_GET['pseCycle'] == null ? "" :$_GET['pseCycle']; 
		$objeto->pseReference1 =$_GET['pseReference1'] == null ? "" :$_GET['pseReference1']; 
		$objeto->pseReference2 =$_GET['pseReference2'] == null ? "" :$_GET['pseReference2']; 
		$objeto->pseReference3 =$_GET['pseReference3'] == null ? "" :$_GET['pseReference3']; 
		$objeto->telephone =$_GET['telephone'] == null ? "" :$_GET['telephone']; 
		$objeto->transactionId =$_GET['transactionId'] == null ? "" :$_GET['transactionId']; 
		$objeto->trazabilityCode =$_GET['trazabilityCode'] == null ? "" :$_GET['trazabilityCode']; 
		$objeto->TX_ADMINISTRATIVE_FEE =$_GET['TX_ADMINISTRATIVE_FEE'] == null ? "" :$_GET['TX_ADMINISTRATIVE_FEE']; 
		$objeto->TX_TAX_ADMINISTRATIVE_FEE =$_GET['TX_TAX_ADMINISTRATIVE_FEE'] == null ? "" :$_GET['TX_TAX_ADMINISTRATIVE_FEE']; 
		$objeto->TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE =$_GET['TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE'] == null ? "" :$_GET['TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE']; 
		//$objeto->action_code_description =$_GET['action_code_description'] == null ? "" :$_GET['action_code_description']; 
		//$objeto->cc_holder =$_GET['cc_holder'] == null ? "" :$_GET['cc_holder']; 
		//$objeto->cc_number =$_GET['cc_number'] == null ? "" :$_GET['cc_number']; 
		//$objeto->processing_date_time =$_GET['processing_date_time'] == null ? "" :$_GET['processing_date_time']; 
		//$objeto->request_number =$_GET['request_number'] == null ? "" :$_GET['request_number']; 
		
		//$data=$this->ModeloVenta->respuestaPago($objeto);
		//echo json_encode($data);

		$this->load->view('clientes/componentes/header');
		$this->load->view('clientes/componentes/menu');
		$this->load->view('clientes/modales');
		$this->load->view('clientes/welcome');
		
		$this->load->view('clientes/componentes/footer');
		
	
	}

	public function confirmacionPago(){

	}

}