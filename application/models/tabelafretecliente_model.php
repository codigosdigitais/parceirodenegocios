<?php
class tabelafretecliente_model extends CI_Model {

	private $tabelaBD = "cliente_frete";
	
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
	
	public function getIdClienteFreteAtual($idCliente) {

		$this->db->select('idClienteFrete');
		$this->db->from('cliente_frete');
		$this->db->where('idCliente', $idCliente);
		$this->db->where('vigencia_final is null');
		$this->db->order_by('vigencia_inicial desc');
		$this->db->limit(1);
		
		$result = $this->db->get();
// 		die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result[0]->idClienteFrete;
		}
		
		return FALSE;
	}

	public function getBaseCadastro($tabela, $cod, $order) {
		$this->db->order_by($cod, $order);
		return $this->db->get($tabela)->result();
	}
	
	public function carregar($idClienteFrete) {
		
		$this->db->select('a.nomefantasia, b.*');
		$this->db->from('cliente a');
		$this->db->join('cliente_frete b', 'a.idCliente = b.idCliente', 'right');
		$this->db->where('a.situacao', 1);
		$this->db->where('b.idClienteFrete', $idClienteFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}
	
	public function existeOutraVigenciaAberta($idClienteFrete) {
		
		$this->db->from('cliente_frete');
		$this->db->where('idCliente = (SELECT idCliente from cliente_frete where idClienteFrete = ' . $idClienteFrete . ')');
		$this->db->where('vigencia_final', null);
		$this->db->where('idClienteFrete != ' . $idClienteFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return FALSE;
	}
	
	public function getClientesSemTabela() {
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select('a.nomefantasia, a.idCliente');
		$this->db->from('cliente a');
		$this->db->where('a.situacao', 1);
		$this->db->where('a.idCliente NOT IN (select idCliente from cliente_frete)');
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
		
		$sql = 'select a.nomefantasia, b.*
				from cliente_frete b
				right join cliente a on (a.idCliente = b.idCliente)
				
				where a.situacao = 1
				AND a.idEmpresa = '. $idEmpresa .'
				
				and (
				    b.idClienteFrete = (select idClienteFrete from cliente_frete where idClienteFrete = b.idClienteFrete and vigencia_final is null order by vigencia_inicial desc limit 1)
				    or ((select idClienteFrete from cliente_frete where idCliente = b.idCliente and vigencia_final is null order by vigencia_inicial desc limit 1) is null
				        and b.idClienteFrete = (select max(idClienteFrete) from cliente_frete where idCliente = b.idCliente)
				    )
				)
				
				group by (b.idCliente)
				
				order by a.nomefantasia';
		
		
		$result = $this->db->query($sql);
		
// 		die($this->db->last_query());
	
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
	
		return FALSE;
	}
	
	public function carregarHistorico($idClienteFrete) {
		
		$this->db->select('a.nomefantasia, b.*');
		$this->db->from('cliente a');
		$this->db->join('cliente_frete b', 'a.idCliente = b.idCliente', 'right');
		
		$this->db->where('a.situacao', 1);
		$this->db->where('a.idCliente = (SELECT idCliente from cliente_frete where idClienteFrete = ' . $idClienteFrete . ')');
		
		$this->db->order_by('b.idClienteFrete desc');
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			return $result->result();
		}
		
		return FALSE;
	}

	public function inserirDadosTabela($tabela, $dados) {
		
		$this->db->insert($tabela, $dados);
		
// 		if ($tabela == 'cliente_frete_itinerario') die($this->db->last_query());
		
		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
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

	public function getItinerarioServicosParaCopia($idClienteFreteItinerarioAntigo, $idClienteFreteItinerario) {
	
		$this->db->select($idClienteFreteItinerario.' idClienteFreteItinerario, a.tiposervico, a.endereco, a.numero, a.bairro, a.cidade, a.falarcom', false);
		$this->db->from('cliente_frete_itinerario b, cliente_frete_itinerario_servicos a');
		$this->db->where('b.idClienteFreteItinerario', $idClienteFreteItinerarioAntigo);
		$this->db->where('b.idClienteFreteItinerario = a.idClienteFreteItinerario');
	
		$result = $this->db->get();
// 		die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	
		return FALSE;
	}
	
	public function getItinerariosParaCopia($idClienteFreteVelha, $idClienteFreteNova) {

		$this->db->select('a.idClienteFreteItinerario, '.$idClienteFreteNova.' idClienteFrete, a.nome, a.valor_empresa, a.valor_funcionario, a.tipo_veiculo, a.tarifa', false);
		$this->db->from('cliente_frete_itinerario a');
		$this->db->where('idClienteFrete', $idClienteFreteVelha);
		
		$result = $this->db->get();
// 		die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
		
		return FALSE;
	}
	
	public function getItinerarios($idClienteFrete) {

		$this->db->select('a.*, b.idClienteFreteItinerarioServico, b.tiposervico, b.endereco, b.numero, b.bairro, b.cidade, b.falarcom');
		$this->db->select("ELT(FIELD(a.tipo_veiculo, 1,2,3,4), 'Moto', 'Carro', 'Van', 'Caminhão') nomeTipoVeiculo", false);
		$this->db->select("ELT(FIELD(a.retorno, 0,1), 'Não', 'Sim') nomeRetorno", false);
		$this->db->from('cliente_frete_itinerario a');
		$this->db->join('cliente_frete_itinerario_servicos b', 'a.idClienteFreteItinerario = b.idClienteFreteItinerario', 'left');
		$this->db->where('idClienteFrete', $idClienteFrete);
		$this->db->order_by('a.nome');
		
		$result = $this->db->get();
// 		die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
		
		return FALSE;		
	}
	
	public function getIdClienteDoIdClienteFrete($idClienteFrete) {

		$this->db->select('idCliente');
		$this->db->from('cliente_frete');
		$this->db->where('idClienteFrete', $idClienteFrete);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			$result = array_shift($result);
			return $result->idCliente;
		}
		
		return FALSE;
	}

	public function atualizarDadosTabela($tabela, $dados, $where) {
		
		$this->db->where($where);
		
		$this->db->update($tabela, $dados);
		
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
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

	public function removerServicosNotIn($where, $ids) {
	
		$this->db->where($where);
		$this->db->where('idClienteFreteItinerarioServico NOT IN ('. implode(",", $ids). ')');
	
		$this->db->delete('cliente_frete_itinerario_servicos');
// 		die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
	
		return FALSE;
	}

	public function removerRegistroTabela($tabela, $where) {
	
		$this->db->where($where);
	
		$this->db->delete($tabela);
	
		if ($this->db->affected_rows() > 0)
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