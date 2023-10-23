<?php
class tabelafretefuncionario_model extends CI_Model {

	private $tabelaBD = "funcionario_frete";
	
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
	
	public function carregar($idFuncionarioFrete) {
		
		$this->db->select('a.nome, b.*');
		$this->db->from('funcionario a');
		$this->db->join('funcionario_frete b', 'a.idFuncionario = b.idFuncionario', 'right');
		$this->db->where('a.situacao', 1);
		$this->db->where('b.idFuncionarioFrete', $idFuncionarioFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}
	
	public function existeOutraVigenciaAberta($idFuncionarioFrete) {
		
		$this->db->from('funcionario_frete');
		$this->db->where('idFuncionario = (SELECT idFuncionario from funcionario_frete where idFuncionarioFrete = ' . $idFuncionarioFrete . ')');
		$this->db->where('vigencia_final', null);
		$this->db->where('idFuncionarioFrete != ' . $idFuncionarioFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return FALSE;
	}
	
	public function getfuncionariosSemTabela() {
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select('a.nome, a.idFuncionario');
		$this->db->from('funcionario a');
		$this->db->where('a.situacao', 1);
		$this->db->where('a.idFuncionario NOT IN (select idFuncionario from funcionario_frete)');
		$this->db->where('a.idEmpresa', $idEmpresa);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}

	public function carregarHistoricoTodos() {

		$idEmpresa = $this->session->userdata('idEmpresa');
		
		$sql = 'select a.nome, b.*
				from funcionario_frete b
				right join funcionario a on (a.idFuncionario = b.idFuncionario)
				
				where a.situacao = 1
				AND a.idEmpresa = '. $idEmpresa .'
				
				and (
				    b.idFuncionarioFrete = (select idFuncionarioFrete from funcionario_frete where idFuncionarioFrete = b.idFuncionarioFrete and vigencia_final is null)
				    or ((select idFuncionarioFrete from funcionario_frete where idFuncionario = b.idFuncionario and vigencia_final is null) is null
				        and b.idFuncionarioFrete = (select max(idFuncionarioFrete) from funcionario_frete where idFuncionario = b.idFuncionario)
				    )
				)
				
				group by (b.idFuncionario)
				
				order by a.nome';
		
		
		$result = $this->db->query($sql);
		
		//die($this->db->last_query());
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return FALSE;
	}
	
	public function carregarHistorico($idFuncionarioFrete) {
		
		$this->db->select('a.nome, b.*');
		$this->db->from('funcionario a');
		$this->db->join('funcionario_frete b', 'a.idFuncionario = b.idFuncionario', 'right');
		
		$this->db->where('a.situacao', 1);
		$this->db->where('a.idFuncionario = (SELECT idFuncionario from funcionario_frete where idFuncionarioFrete = ' . $idFuncionarioFrete . ')');
		
		$this->db->order_by('b.idFuncionarioFrete desc');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}

	public function inserirDados($dados) {
	
		$this->db->insert($this->tabelaBD, $dados);
	
		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	
		return FALSE;
	
	}
	
	public function getIdFuncionarioDoIdFuncionarioFrete($idFuncionarioFrete) {

		$this->db->select('idFuncionario');
		$this->db->from('funcionario_frete');
		$this->db->where('idFuncionarioFrete', $idFuncionarioFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			$result = array_shift($result);
			return $result->idFuncionario;
		}
		
		return FALSE;
	}
	
	public function atualizarDados($dados, $where) {
		
		$this->db->where($where);
		
		$this->db->update($this->tabelaBD, $dados);
		
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function removerRegistro($where) {
		
		$this->db->where($where[0], $where[1]);
		
		$this->db->delete($this->tabelaBD);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}
}