<?php
/*
 * @autor: André Baill
 * @date: 16/10/2020
*/
include_once (dirname(__FILE__) . "/classes/ModelInterface.php");

class usuarioexterno_model extends CI_Model implements ModelInterface {

	const TABELA_USUARIO = "sis_usuario";
    const TABLEA_USUARIO_PERMISSAO = "sis_usuario_perfil";
	
	private $db_error_number;
	private $db_error_message;
	
    function __construct() {
        parent::__construct();
		$this->load->helper('codegen');		
		$this->resetErrorNumberAndMessage();
    }
    
    function inserirUsuario($dados) {
    	$this->resetErrorNumberAndMessage();
    	
    	$this->db->insert(self::TABELA_USUARIO, $dados);
    	
    	if ($this->db->affected_rows() == 1)
    		return $this->db->insert_id();
    	
    	else {
    		$this->db_error_number  = $this->db->_error_number();
    		$this->db_error_message = $this->db->_error_message();
    	}
   	
    	return FALSE;
    }

    function inserirUsuarioPermissao($dados) {
        $this->resetErrorNumberAndMessage();
        
        $this->db->insert(self::TABLEA_USUARIO_PERMISSAO, $dados);
        
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

}
