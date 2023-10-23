<?php
date_default_timezone_set("America/Los_Angeles");

class Boleto extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('boleto_model','',TRUE);
           $this->data['menu'] = 'recursoshumanos';
			$this->data['modulosBase'] = $this->boleto_model->getModulosCategoria();
	}	
	
	function gerar($id_cliente=NULL, $data_inicial=NULL, $data_final=NULL){
		error_reporting(E_ALL ^ E_DEPRECATED);
		$this->load->helper('mpdf');
		$this->data['dadosboleto'] = $this->boleto_model->GerarBoletoCEF($id_cliente, $data_inicial, $data_final);
		$this->data['view'] = 'boleto/boleto';
		$html = $this->load->view('boleto/boleto_impressao', $this->data, true);
		echo $html;
		//pdf_create($html, 'boleto_'.$id_cliente."_". date('d-m-Y'), true);
	}
	
	function email($id_cliente=NULL, $data_inicial=NULL, $data_final=NULL){
		
		error_reporting(E_ALL ^ E_DEPRECATED);
		$this->load->helper('mpdf');
		$this->data['dadosboleto'] = $this->boleto_model->GerarBoletoCEF($id_cliente, $data_inicial, $data_final);
		$this->data['view'] = 'boleto/boleto';
		$html = $this->load->view('boleto/boleto_impressao', $this->data, true);
		$arquivo = pdf_create($html, $_SERVER['DOCUMENT_ROOT'].'Administrar/assets/boletos/boleto_'.$id_cliente."_". date('d-m-Y'), false);

		# envia notificação por email do cliente
		$this->email_model->enviar_email("email", "financeiro", $id_cliente, "adicionar", $_SERVER['DOCUMENT_ROOT'].'Administrar/assets/boletos/boleto_'.$id_cliente."_". date('d-m-Y'));		
	
	}
}

