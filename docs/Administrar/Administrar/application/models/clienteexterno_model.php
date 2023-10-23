<?php

include_once (dirname(__FILE__) . "/classes/ModelInterface.php");

class clienteexterno_model extends CI_Model implements ModelInterface {

	const TABELA_CLIENTE = "cliente";
	
	private $db_error_number;
	private $db_error_message;
	
    function __construct() {
        parent::__construct();
		$this->load->helper('codegen');
		
		$this->resetErrorNumberAndMessage();
    }
    
    function inserirCliente($dados) {
    	$this->resetErrorNumberAndMessage();
    	
    	$this->db->insert(self::TABELA_CLIENTE, $dados);
    	
    	if ($this->db->affected_rows() == 1)
    		return $this->db->insert_id();
    	
    	else {
    		$this->db_error_number  = $this->db->_error_number();
    		$this->db_error_message = $this->db->_error_message();
    	}
    	
    	return FALSE;
    }
    
    private function resetErrorNumberAndMessage() {
		$this->db_error_message = "";
		$this->db_error_number = "";
    }
    
    public function getDb_error_number() {
    	return $this->db_error_number;
    }
    
    public function getDb_error_message() {
    	return $this->db_error_message;
    }
    
    /**
     * verifica chave do cliente e retorna idCliente
     * utilizado na integração com chamada externa do sistema
     */
    public function verifyClientKeyGetIdParaChamadaExterna($clientKey) {
    	
    	if ($clientKey == 'a5sj5Iu8f6SA')
    		return "148";
    	
    	else return false;
    }


}
