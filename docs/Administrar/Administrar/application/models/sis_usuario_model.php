<?php
class sis_usuario_model extends CI_Model {

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

	public function carregarPerfisFuncoesVinculados($idUsuario) {

		$this->db->select('a.idUsuarioPerfil');
		$this->db->select('b.idPerfil, b.nome nomePerfil, b.situacao sitPerfil');
		$this->db->select('c.idModuloClienteFuncao, c.situacao sitFuncaoNoPerfil');
		$this->db->select('d.nome nomeFuncao, d.ordem ordemFuncao, d.situacao sitFuncaoNoModulo');
		$this->db->select('e.nome nomeModulo, e.ordem ordemModulo, e.situacao sitModulo');
		$this->db->select('f.nome nomeFuncaoSistema, f.situacao sitFuncaoSistema');
		$this->db->from('sis_usuario_perfil a');
		$this->db->join('sis_perfil b', 'a.idPerfil = b.idPerfil', 'right');
		$this->db->join('sis_perfil_funcao c', 'a.idPerfil = c.idPerfil', 'left');
		$this->db->join('sis_modulo_cliente_funcao d', 'c.idModuloClienteFuncao = d.idModuloClienteFuncao', 'left');
		$this->db->join('sis_modulo_cliente e', 'd.idModuloCliente = e.idModuloCliente', 'left');
		$this->db->join('sis_funcao f', 'd.idFuncao = f.idFuncao', 'left');
		
		$this->db->order_by('b.nome asc');
	
		$this->db->where('a.idUsuario', $idUsuario);
	
		$result = $this->db->get();
		/*
		echo $this->db->last_query() . "<br><br>";
		echo $this->db->_error_message() . "<hr>";
		var_dump($result->result()); die();
		*/
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return false;
	}
	
	public function carregarPerfisDisponiveis($idEmpresa, $idUsuario) {
	
		$this->db->select('a.idPerfil, a.nome');
		$this->db->from('sis_perfil a');
		
		$this->db->order_by('a.nome asc');
		$this->db->where('a.idEmpresa = '.$idEmpresa.' AND a.situacao = 1');
	
		if ($idUsuario) {
			$this->db->where('a.idPerfil NOT IN (select idPerfil from sis_usuario_perfil where idUsuario = '.$idUsuario.')');
		}
	
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}

		return false;
	}
	
	public function carregarTodosFuncionario($idEmpresa, $idFuncionario) {
	
		$this->db->select('a.idFuncionario, a.nome');
		$this->db->from('funcionario a');
		
		if ($idFuncionario)
			$this->db->where('a.idEmpresa = '.$idEmpresa.' AND (a.situacao = 1 OR a.idFuncionario = ' . $idFuncionario .')');
		
		else
			$this->db->where('a.idEmpresa = '.$idEmpresa.' AND a.situacao = 1');
	
		$result = $this->db->get();
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return false;
	}
	
	public function carregarTodosClientes($idEmpresa, $idCliente) {

		$this->db->select('a.idCliente, a.nomefantasia');
		$this->db->from('cliente a');
		
		if ($idCliente)
			$this->db->where('a.idEmpresa = '.$idEmpresa.' AND (a.situacao = 1 OR a.idCliente = ' . $idCliente.')');
		
		else
			$this->db->where('a.idEmpresa = '.$idEmpresa.' AND a.situacao = 1');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}

	public function carregarUsuario($idEmpresa, $idUsuario) {
	
		$this->db->select('a.idUsuario, a.idCliente, a.idFuncionario, a.nome, a.tipo, a.login, a.situacao');
		$this->db->select('IF (a.idCliente IS NOT NULL, b.nomefantasia, c.nome) vinculoNome', false);
		$this->db->select('IF (a.idCliente IS NOT NULL, b.idCliente, c.idFuncionario) vinculoId', false);
		
		$this->db->from('sis_usuario a');
		$this->db->join('cliente b', 'a.idCliente = b.idCliente', 'left');
		$this->db->join('funcionario c', 'a.idFuncionario = c.idFuncionario', 'left');
		
		$this->db->where('a.idEmpresa', $idEmpresa);
		$this->db->where('a.idUsuario', $idUsuario);
		
		$this->db->order_by('a.nome');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}
	
	public function carregarTodosUsuarios($where) {
		
		$this->db->select('a.*');
		$this->db->select('IF (a.idCliente IS NOT NULL, b.nomefantasia, c.nome) vinculo', false);
		$this->db->from('sis_usuario a');
		$this->db->join('cliente b', 'a.idCliente = b.idCliente', 'left');
		$this->db->join('funcionario c', 'a.idFuncionario = c.idFuncionario', 'left');
		
		$this->db->where($where);
		$this->db->order_by('a.nome');
		
		$result = $this->db->get();
		//die($this->db->last_query());
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