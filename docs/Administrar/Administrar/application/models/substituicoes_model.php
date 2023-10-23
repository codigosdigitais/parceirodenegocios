<?php
class substituicoes_model extends CI_Model {

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

    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
		if($start==NULL) $start = 0;
 	
 		$sql = "
			SELECT 
				sub.*, 
				fPrincipal.nome AS nomeFalta, 
				fSubstituto.nome AS nomeSubstituto, 
				fCliente.razaosocial
			FROM 
				substituicao AS sub
			INNER JOIN funcionario fPrincipal ON fPrincipal .idFuncionario = sub.idFuncionario
			INNER JOIN funcionario fSubstituto ON fSubstituto.idFuncionario = sub.idFuncionarioSubstituto
			INNER JOIN cliente fCliente ON fCliente.idCliente = sub.idCliente
			WHERE fCliente.idEmpresa = ".$idEmpresa."
			ORDER BY 
				sub.idSubstituicao DESC, sub.data DESC
			LIMIT $start, $perpage
		";
		
		$consulta = $this->db->query($sql)->result();
		return $consulta;
    }

    function getById($id){
		$sql = "
					SELECT 
						sub.*,
						cli.idCliente,
						cli.razaosocial as nomeCliente
					FROM
						substituicao as sub,
						cliente as cli

					WHERE sub.idSubstituicao = '".$id."' 
					AND sub.idCliente = cli.idCliente
		";
        $consulta = $this->db->query($sql)->result();
		
			foreach($consulta as &$valor)
			{
				$sql = "
					SELECT 
						sub.*, 
						sub.idSubstituicao,
						fPrincipal.nome AS nomeFalta, 
						fSubstituto.nome AS nomeSubstituto, 
						fCliente.razaosocial,
						fClienteResponsaveis.nome as solicitante,
						fClienteResponsaveis.idClienteResponsavel as idClienteResponsavel
					FROM 
						substituicao AS sub
					JOIN funcionario fPrincipal ON fPrincipal .idFuncionario = sub.idFuncionario
					JOIN funcionario fSubstituto ON fSubstituto.idFuncionario = sub.idFuncionarioSubstituto
					JOIN cliente fCliente ON fCliente.idCliente = sub.idCliente
					JOIN cliente_responsaveis fClienteResponsaveis ON fClienteResponsaveis.idClienteResponsavel=sub.solicitante
					WHERE sub.idCliente = '".$valor->idCliente."'
					ORDER BY 
						sub.data 
					DESC
				";
				
				$valor->listaSubstCliente = $this->db->query($sql)->result();	
				

			}
			
			
		return $consulta;
    }

    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);
		
        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }


	function cadastrando($tabela, $dados){
		$this->db->insert($tabela, $dados);
		
		if ($this->db->affected_rows() == '1')
			return $this->db->insert_id();
		
		return false;
	}
	
    function count($table) {
        return $this->db->count_all($table);
    }
    
	public function getParametroById($id)
	{
        $this->db->where('idParametroCategoria',$id);
        $this->db->order_by('parametro','ASC');
        return $this->db->get('parametro')->result();		
	}

	public function getBase($tabela, $cod, $order, $idAtual = null)
	{
		if (!is_numeric($idAtual)) $idAtual = null;
	
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by($cod, $order);
	
		/*if ($tabela == 'cliente') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idCliente = (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}*/
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFuncionario IN (select idFuncionario from substituicao where idSubstituicao = '.$idAtual.')');
				$this->db->or_where('idFuncionario IN (select idFuncionarioSubstituto from substituicao where idSubstituicao = '.$idAtual.')');
			}
		}
	/*
		if ($tabela == 'fornecedor') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFornecedor IN (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}*/
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
    public function addsubstituicoeservico($dados)
    {
		$this->db->insert_batch('substituicao_servico', $dados); 
        return true;
    }
	
	# Listagem de Clientes que estão no Contrato
	public function getClienteContrato($idAtual){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$tabela = "contrato";
		
		if (!is_numeric($idAtual)) $idAtual = null;
		
		$this->db->select('contrato.*, cliente.razaosocial, cliente.idCliente');
		$this->db->join("cliente", "cliente.idCliente=contrato.idCliente", "LEFT");

		$this->db->where('contrato.idEmpresa', $idEmpresa);
		
		$this->db->group_by('contrato.idCliente');
		
		
		if ($idAtual != null) {
			$this->db->or_where('cliente.idCliente = (select idCliente from substituicao where idSubstituicao = '.$idAtual.')');
		}

		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
		
		return false;
	}


}