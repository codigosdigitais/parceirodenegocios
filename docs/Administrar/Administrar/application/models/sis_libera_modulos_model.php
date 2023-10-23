<?php
class sis_libera_modulos_model extends CI_Model {

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
	
	public function carregarFuncoesDisponiveis($idModuloCliente) {
		
		$this->db->select('a.*, b.nome nomeUnidade');
		$this->db->from('sis_funcao a');
		$this->db->where('a.situacao', 1);
		$this->db->where('a.idFuncao not in (select idFuncao from sis_modulo_cliente_funcao where idModuloCliente = '.$idModuloCliente.')');
		$this->db->join('sis_unidade b', 'a.idUnidade = b.idUnidade', 'left');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return false;
	}
	
	public function carregarParceiros($idCliente) {
		$this->db->select("a.idCliente, a.nomefantasia");
		$this->db->where("a.tipo IN ('parceiro', 'SISAdmin') AND a.idCliente != " . $idCliente);
		$this->db->order_by("a.tipo desc, a.nomefantasia");
		 
		$result = $this->db->get('cliente a');
	
		if ($this->db->affected_rows() > 0) {
			return $result->result();
		}
		 
		return FALSE;
	}
	
	public function copiarModulo($idModulo, $idParceiroDestino) {
		$this->db->select($idParceiroDestino . ' idCliente, a.nome, a.ordem, a.situacao', false);
		$this->db->from('sis_modulo_cliente a');
		$this->db->where('a.idModuloCliente', $idModulo);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$dados = array_shift( $result->result() );
			
			$this->db->insert('sis_modulo_cliente', $dados);
			
			if ($this->db->affected_rows() > 0)
			{
				$idModuloNovo = $this->db->insert_id();
				
				return $this->copiarModuloFuncoes($idModulo, $idModuloNovo);
			}
		}
		return false;
	}
	
	private function copiarModuloFuncoes($idModulo, $idModuloNovo) {
		$this->db->select($idModuloNovo . ' idModuloCliente, a.idFuncao, a.nome, a.ordem, a.situacao', false);
		$this->db->from('sis_modulo_cliente_funcao a');
		$this->db->where('a.idModuloCliente', $idModulo);
		
		$result = $this->db->get();
		
		$retorno = true;
		
		if ($this->db->affected_rows() > 0) {
			$funcoes = $result->result();
			
			foreach ($funcoes as $f) {
				$dados = ($f);
				
				$this->db->insert('sis_modulo_cliente_funcao', $dados);
				
				if ($this->db->affected_rows() == 0) {
					$retorno = false;
				}
			}
		} else {
			$retorno = true;
		}
		
		return $retorno;
	}

	public function carregarModulo($idModuloCliente) {
	
		$this->db->select('a.*, b.nomefantasia');
		$this->db->from('sis_modulo_cliente a');
		$this->db->where('a.idModuloCliente', $idModuloCliente);
		$this->db->join('cliente b', 'a.idCliente = b.idCliente', 'right');
	
		$result = $this->db->get();
	
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
	
			$this->db->select('a.*, b.nome nomeFuncao, c.nome nomeUnidade');
			$this->db->from('sis_modulo_cliente_funcao a');
			$this->db->where('a.idModuloCliente', $idModuloCliente);
			$this->db->join('sis_funcao b', 'a.idFuncao = b.idFuncao', 'left');
			$this->db->join('sis_unidade c', 'b.idUnidade = c.idUnidade', 'right');
			$this->db->order_by('a.ordem');
				
			$funcoes = $this->db->get();
			
			if ($this->db->affected_rows() > 0)
			{
				$result['funcoes'] = $funcoes->result();
			}
				
			return $result;
		}
	
		return FALSE;
	}
	
	public function carregarModulosCliente($idCliente) {
		
		$this->db->select('a.*');
		$this->db->from('cliente a');
		$this->db->where('a.idCliente', $idCliente);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();

			$this->db->select('a.*');
			$this->db->from('sis_modulo_cliente a');
			$this->db->where('a.idCliente', $idCliente);
			$this->db->order_by('a.ordem');
			
			$funcoes = $this->db->get();
			if ($this->db->affected_rows() > 0)
			{
				$result['modulos'] = $funcoes->result();
			}
			
			return $result;
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

	public function removerModulo($idModulo) {
		
		$table = "sis_modulo_cliente";
	
		$this->db->where('idModuloCliente', $idModulo);
	
		$this->db->delete($table);
	
		if ($this->db->affected_rows() > 0)
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
	
	public function carregarTodosClientes() {
		
		$this->db->select('a.*');
		$this->db->from('cliente a');
		$this->db->where("tipo IN ('parceiro', 'SISAdmin')");
		$this->db->order_by('a.tipo desc, a.nomefantasia');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
		
	}

	public function carregarFuncaoParam($idFuncao) {
		/*
		$this->db->select('a.*, b.nome nomeUnidade');
		$this->db->from('sis_funcao a');
		$this->db->join('sis_unidade b', 'a.idUnidade = b.idUnidade', 'right');
		$this->db->where('a.idFuncao', $idFuncao);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();

			$this->db->select('a.*');
			$this->db->from('sis_funcao_param a');
			$this->db->where('a.idFuncao', $idFuncao);
			
			$funcoes = $this->db->get();
			
			if ($this->db->affected_rows() > 0)
			{
				$result['parametros'] = $funcoes->result();
			}
			
			return $result;
		}
		
		return FALSE;*/
	}
}