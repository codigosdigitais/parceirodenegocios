<?php
class sis_perfil_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function getModulosCategoria(){
		$sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
		$consulta = $this->db->query($sql)->result();	
		
			foreach($consulta as &$valor){
				$sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
				$valor->subModulo = $this->db->query($sql_model)->result();		
			}
		
		return $consulta;
	}

	public function carregarTodosPerfis($idEmpresa) {
	
		$this->db->select('a.*');
		$this->db->from('sis_perfil a');
		$this->db->where('a.idEmpresa', $idEmpresa);
		$this->db->order_by('a.nome');
	
		$result = $this->db->get();
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return FALSE;
	
	}
	
	public function getDadosFuncao($idEmpresa, $idPerfilFuncao) {
		$this->db->select('b.idPerfilFuncao, b.idModuloClienteFuncao, b.situacao situacaoFuncao, a.nome nomePerfil, c.nome nomeFuncao, d.nome nomeModulo');
		$this->db->from('sis_perfil a');
		$this->db->join('sis_perfil_funcao b', 'a.idPerfil = b.idPerfil', 'left');
		$this->db->join('sis_modulo_cliente_funcao c', 'c.idModuloClienteFuncao = b.idModuloClienteFuncao', 'left');
		$this->db->join('sis_modulo_cliente d', 'c.idModuloCliente = d.idModuloCliente', 'left');
		
		$this->db->where('b.idPerfilFuncao', $idPerfilFuncao);
		$this->db->where('a.idEmpresa', $idEmpresa);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}

	public function getDadosFuncaoPermissoes($idPerfilFuncao) {
		$this->db->select('a.*');
		$this->db->from('sis_perfil_funcao a');
	
		$this->db->where('a.idPerfilFuncao', $idPerfilFuncao);
		$this->db->where('a.idUsuario IS NULL');
	
		$result = $this->db->get();
	
		//die($this->db->last_query());
		//var_dump($result->result()); die();
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return false;
	}

	public function getDadosFuncaoParametros($idPerfilFuncao) {
		$this->db->select('c.*, d.idPerfilFuncaoParametro, d.valor valorPerfil');
		$this->db->from('sis_perfil_funcao a');
		$this->db->join('sis_modulo_cliente_funcao b', 'a.idModuloClienteFuncao = b.idModuloClienteFuncao', 'left');
		$this->db->join('sis_funcao_param c', 'c.idFuncao = b.idFuncao', 'left');
		$this->db->join('sis_perfil_funcao_parametro d', 'd.idPerfilFuncao = a.idPerfilFuncao AND d.idFuncaoParam = c.idFuncaoParam', 'left');

		$this->db->where('a.idPerfilFuncao', $idPerfilFuncao);
		$this->db->order_by('c.nome asc');

		$result = $this->db->get();
		
		//die($this->db->last_query());
		//var_dump($result->result()); die();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}
	
	public function carregarFuncoesDisponiveis($idModuloCliente) {
	
		$this->db->select('a.*');
		$this->db->from('sis_modulo_cliente_funcao a');
		$this->db->where('a.idModuloCliente', $idModuloCliente);
	
		$result = $this->db->get();
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return false;
	}

	public function carregarModulosFuncoesVinculados($idEmpresa, $idPerfil) {

		$this->db->select('a.*, b.nome nomeFuncao, c.nome nomeModulo');
		$this->db->from('sis_perfil p');
		$this->db->where('p.idPerfil', $idPerfil);
		$this->db->where('p.idEmpresa', $idEmpresa);
		
		$this->db->join('sis_perfil_funcao a', 'a.idPerfil = p.idPerfil', 'right');
		$this->db->join('sis_modulo_cliente_funcao b', 'a.idModuloClienteFuncao = b.idModuloClienteFuncao', 'left');
		$this->db->join('sis_modulo_cliente c', 'c.idModuloCliente = b.idModuloCliente', 'left');
		$this->db->order_by('c.ordem asc, b.ordem asc');
		
		$result = $this->db->get();
		
		//die($this->db->last_query());
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}
	
	public function carregarModulosFuncoesDisponiveis($idEmpresa, $idPerfil) {

		$this->db->select('a.idModuloCliente, a.nome nomeModulo, a.ordem ordemModulo, a.situacao situacaoModulo');
		$this->db->select('b.idModuloClienteFuncao, b.nome nomeFuncao, b.ordem ordemFuncao, b.situacao situacaoFuncao');
		$this->db->from('sis_modulo_cliente a');
		$this->db->where('a.situacao', 1);
		$this->db->where('b.situacao', 1);
		$this->db->where('a.idCliente', $idEmpresa);
		$this->db->where('b.idModuloClienteFuncao IS NOT NULL');
		$this->db->join('sis_modulo_cliente_funcao b', 'a.idModuloCliente = b.idModuloCliente', 'left');
		$this->db->where('b.idModuloClienteFuncao NOT IN (
							SELECT IFNULL(c.idModuloClienteFuncao, 0) FROM sis_perfil_funcao c
							WHERE c.idPerfil= '.$idPerfil.'
							)');
		
		$this->db->order_by('a.ordem asc, b.ordem asc');
				
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}
	
	public function carregarPerfil($idEmpresa, $idPerfil) {
	
		$this->db->select('a.*');
		$this->db->from('sis_perfil a');
		$this->db->where('a.idPerfil', $idPerfil);
		$this->db->where('a.idEmpresa', $idEmpresa);
	
		$result = $this->db->get();
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return FALSE;
	}
	

	public function inserirDados($table, $dados) {
	
		$this->db->insert($table, $dados);
	
		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	
		return FALSE;
	
	}
	
	public function atualizarDados($table, $dados, $where) {
		
		$this->db->where($where);
		
		$this->db->update($table, $dados);
		
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function removerRegistro($table, $where) {
		
		$this->db->where($where);
		
		$this->db->delete($table);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}
	
}