<?php
class sis_unidade_model extends CI_Model {

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
	
	public function carregar($idUnidade) {
		
		$this->db->select('a.*');
		$this->db->from('sis_unidade a');
		$this->db->where('a.idUnidade', $idUnidade);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();

			$this->db->select('a.*');
			$this->db->from('sis_funcao a');
			$this->db->where('a.idUnidade', $idUnidade);
			
			$funcoes = $this->db->get();
			if ($this->db->affected_rows() > 0)
			{
				$result['funcoes'] = $funcoes->result();
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
	
	/*public function removerRegistro($where) {
		
		$this->db->where($where[0], $where[1]);
		
		$this->db->delete($this->tabelaUnidade);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}*/
	
	public function carregarHistoricoTodos() {
		
		$this->db->select('a.*, (SELECT COUNT(*) FROM `sis_funcao` b WHERE b.idUnidade = a.idUnidade) totalFuncoes');
		$this->db->from('sis_unidade a');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
		
	}

	public function carregarFuncaoParam($idFuncao) {
		
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
		
		return FALSE;
	}
}