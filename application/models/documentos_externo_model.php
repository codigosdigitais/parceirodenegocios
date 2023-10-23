<?php
class documentos_externo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    function get($table1,$tipoId,$table2,$modulo,$perpage=0,$start=0){
    	if(empty($start)) $start = 0;
    	
    	$nomeCampoNome = 'razaosocial';
    	if ($table2 == 'funcionario') $nomeCampoNome = "nome";
    	
		$idEmpresa = $this->session->userdata['idEmpresa'];

		$this->db->select("t.*, c.$tipoId, c.$nomeCampoNome as nomePessoaJF");
		$this->db->from($table1 .' as t, '.$table2 .' as c');
		$this->db->where("t.idAdministrador = c.".$tipoId);
		$this->db->where("t.modulo = '".$modulo."'");
		$this->db->where("t.idEmpresa = ".$idEmpresa);
		$this->db->order_by('t.idDocumento desc');
		$this->db->limit($perpage,$start);
		
		
		if ($table1 == 'documento') {
			$idClienteExterno = $this->session->userdata['idAcessoExterno'];
			$this->db->from('cliente cli');
			$this->db->where('cli.idCliente', $idClienteExterno);
			$this->db->where('t.idAdministrador', 'cli.codCedente', false);
		}
		
		$result = $this->db->get();
		
// 		die($this->db->last_query());

		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
    }
	

    function getById($id){
		$sql = "SELECT * FROM documento WHERE idDocumento = '".$id."'";
		$consulta = $this->db->query($sql);
		

		if ($this->db->affected_rows() > 0)
		{
			return $consulta->result();
		}
		
		return FALSE;
    }
    
    function count($table1,$tipoId,$table2,$modulo){
    	
		$idEmpresa = $this->session->userdata['idEmpresa'];

		$this->db->select("t.*");
		$this->db->from($table1 .' as t, '.$table2 .' as c');
		$this->db->where("t.idAdministrador = c.".$tipoId);
		$this->db->where("t.modulo = '".$modulo."'");
		$this->db->where("t.idEmpresa = ".$idEmpresa);
		
		$result = $this->db->get();
		
// 		die($this->db->last_query());

		if ($this->db->affected_rows() > 0) {
			return  $result->num_rows();
		}
	
		return false;
    }
	
}