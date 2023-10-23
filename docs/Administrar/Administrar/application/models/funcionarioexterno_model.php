<?php

include_once (dirname(__FILE__) . "/classes/ModelInterface.php");

class funcionarioexterno_model extends CI_Model implements ModelInterface {

	const TABELA_PADRAO = "funcionario_externo";
	
	private $db_error_number;
	private $db_error_message;
	
    public function __construct() {
        parent::__construct();
		$this->load->helper('codegen');
		
		$this->db_error_message = "";
		$this->db_error_number = "";
    }
    
    public function inserirPreCadastro($dados) {
    	$this->db->set('dataHora', 'now()', false);
    	$this->db->insert(self::TABELA_PADRAO, $dados);
    	
    	if ($this->db->affected_rows() > 0) {
    		return $this->db->insert_id();
    	}
    		
    	else {
    		$this->db_error_number  = $this->db->_error_number();
    		$this->db_error_message = $this->db->_error_message();
    	}
    	
    	return FALSE;
    }
    
    public function carregarCadFuncExterno($id) {
    	$this->db->where('id', $id);
    	$result = $this->db->get(self::TABELA_PADRAO);
    	
    	if ($this->db->affected_rows() > 0)
    		return $result->result();
    	else
    		return false;
    }
    
    public function insertTableData($table, $data) {
    	$this->db->insert($table, $data);
    	
    	if ($this->db->affected_rows() > 0)
    		return $this->db->insert_id();
    	else
    		return false;
    }
    
    public function getCodigoEstado($estado) {
    	$this->db->where('uf', $estado);
    	$result = $this->db->get('estados');
    	
    	if ($this->db->affected_rows() > 0) {
    		$result = array_shift( $result->result() );
    		$id = $result->idEstado;
    		
    		return $id;
    	}
    	else return false;
    }
    
    public function existeEmailFuncionarioCadastrado($email, $idEmpresa) {
    	$this->db->where('email', $email);
    	$this->db->where('idEmpresa', $idEmpresa);
    	$this->db->get('funcionario');
    	
    	if ($this->db->affected_rows() > 0)
    		return true;
    	else
    		return false;
    }
    
    public function getListaFuncionarios($idEmpresa) {
    	$this->db->select(self::TABELA_PADRAO . '.*, funcionario.email emailCadastrado, funcionario.idFuncionario');
    	$this->db->where(self::TABELA_PADRAO. '.idEmpresa', $idEmpresa);
    	$this->db->join('funcionario', 'funcionario.email = '.self::TABELA_PADRAO.'.email', 'left');
    	$this->db->order_by('dataHora');
    	$result = $this->db->get(self::TABELA_PADRAO);
    	
    	if ($this->db->affected_rows() > 0)
    		return $result->result();
    	
    	else 
    		return false;
    }
        
    public function getDb_error_number() {
    	return $this->db_error_number;
    }
    
    public function getDb_error_message() {
    	return $this->db_error_message;
    }
    	
}
