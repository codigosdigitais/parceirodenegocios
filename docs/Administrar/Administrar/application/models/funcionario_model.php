<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funcionario_model extends CI_Model {
	
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
	
	function getImagemPerfilFuncionario($idFuncionario) {
		$this->db->select('imagem_perfil');
		$this->db->from('funcionario');
		$this->db->where('idFuncionario', $idFuncionario);
		
		$result = $this->db->get();
		
		if ($this->db->affected_rows() > 0) {
			$result = $result->result();
			if ($result[0]->imagem_perfil != "")
				return $result[0]->imagem_perfil;
		}
		
		return false;
	}
    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
    	$idEmpresa = $this->session->userdata['idEmpresa'];
		$sql = "SELECT * FROM funcionario as f, estados as e WHERE situacao = 1 AND idEmpresa = ".$idEmpresa." AND f.enderecoestado = e.idEstado ORDER BY f.status DESC, f.nome ASC";
		return $this->db->query($sql)->result();
    }

    function getListaFuncionario($status=null){
    	$idEmpresa = $this->session->userdata['idEmpresa'];

		$sql = "
				SELECT * FROM 
					funcionario as f, 
					estados as e 
					WHERE situacao = '".$status."'
					AND idEmpresa = ".$idEmpresa." 
					AND f.enderecoestado = e.idEstado 
					ORDER BY f.status DESC, f.nome ASC";
		
		return $this->db->query($sql)->result();
    }    

    public function getListaCedentesBase($id) {
    		
    	$tabela = "cedente";
    		
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	$this->db->where('idEmpresa', $idEmpresa);
    
    	if (is_numeric($id)) {
    		$this->db->where('(situacao = 1 OR idCedente IN (select empresaregistro from funcionario_dadosregistro where idFuncionario = '.$id.') )');
    	}
    	else {
    		$this->db->where('situacao', 1);
    	}
    
    	$this->db->order_by('razaosocial');
    
    	$result = $this->db->get($tabela);
    	//die($this->db->last_query());
    	if ($this->db->affected_rows() > 0) {
    		return  $result->result();
    	}
    
    	return false;
    
    }

    function getById($id){

		/* 					LEFT JOIN funcionario_dadosregistro AS fdr ON fdr.idFuncionario = '".$id."'
*/
		
		$sql = "
					SELECT * FROM 
						funcionario as f
					LEFT JOIN funcionario_dadoscontrato AS fdc ON fdc.idFuncionario = '".$id."'
					LEFT JOIN funcionario_documentos AS fdoc ON fdoc.idFuncionario = '".$id."'
					LEFT JOIN funcionario_remuneracao AS frem ON frem.idFuncionario = '".$id."'
					LEFT JOIN funcionario_dadosregistro AS fdr ON fdr.idFuncionario = '".$id."'
					WHERE f.idFuncionario = '{$id}'
		";

		$consulta = $this->db->query($sql)->result();
		
			foreach($consulta as &$valor){
				$sql = "SELECT * FROM funcionario_veiculo WHERE idFuncionario = '".$valor->idFuncionario."'";
				$valor->veiculosLista = $this->db->query($sql)->result();
			}
			
			foreach($consulta as &$valor){
				$sql_dc = "SELECT * FROM funcionario_dadoscontrato WHERE idFuncionario = '{$id}'";
				$valor->dadosContrato = $this->db->query($sql_dc)->result();
			}
			
			foreach($consulta as &$valor){
				$sql_doc = "SELECT * FROM documento WHERE idAdministrador = '{$id}' AND modulo = 'funcionario' OR modulo = 'atestado'";
				$valor->documentacao = $this->db->query($sql_doc)->result();
			}
			
			
			
		return $consulta;

    }
	
    function getByIdVisualizar($id){
		
		$sql = "
					SELECT * FROM 
						funcionario as f
					LEFT JOIN funcionario_dadoscontrato AS fdc ON fdc.idFuncionario = '{$id}'
					LEFT JOIN funcionario_documentos AS fdoc ON fdoc.idFuncionario = '{$id}'
					LEFT JOIN funcionario_remuneracao AS frem ON frem.idFuncionario = '{$id}'
					WHERE f.idFuncionario = '{$id}'
		";
		$consulta = $this->db->query($sql)->result();
		
			foreach($consulta as &$valor){
				$sql = "SELECT * FROM funcionario_veiculo WHERE idFuncionario = '".$valor->idFuncionario."'";
				$valor->veiculosLista = $this->db->query($sql)->result();
			}
			
			foreach($consulta as &$valor){
				$sql_dc = "SELECT * FROM funcionario_dadoscontrato WHERE idFuncionario = '".$valor->idFuncionario."'";
				$valor->dadosContrato = $this->db->query($sql_dc)->result();
			}
			
			foreach($consulta as &$valor){
				$sql_doc = "SELECT * FROM documento WHERE idAdministrador = '".$valor->idFuncionario."' AND (modulo = 'funcionario' OR modulo = 'atestado')";
				$valor->documentacao = $this->db->query($sql_doc)->result();
			}
		
		return $consulta;

    }
	
    function getByIdModify($id, $campo, $tabela){
        $this->db->where($campo,$id);
        $this->db->limit(1);
        return $this->db->get($tabela)->row();
    }
	
	public function getMateriais($idFuncionario, $idMaterial){
		$sql = "SELECT * FROM funcionario_materiais WHERE idFuncionario = '".$idFuncionario."' AND material = '".$idMaterial."'";
		return $this->db->query($sql)->row();
	}

    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
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

    function count($table) {
        return $this->db->count_all($table);
    }
	
	function cadastrando($tabela, $dados){
		$this->db->insert($tabela, $dados);
		
		if ($this->db->affected_rows() == '1')
			return $this->db->insert_id();
		
		return false;
	}
	
	public function ListaEstados()
	{
        $sql = "SELECT * FROM estados ORDER BY estado ASC";
        return $this->db->query($sql)->result();
	}
	
	public function getParametroById($id)
	{
        $this->db->where('idParametroCategoria',$id);
        $this->db->order_by('parametro','ASC');
        return $this->db->get('parametro')->result();		
	}

	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idCliente'];
		$this->db->where('idEmpresa', $idEmpresa);
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
		
	}
	
	public function add_batch($tabela, $dados)
	{
		$ids = array();
    	foreach ($dados as $dado) {
    		$this->db->insert($tabela, $dado);
    		
    		if ($this->db->affected_rows() == '1') {
    			array_push($ids, $this->db->insert_id());
    		}
    	}
		if (count($ids) > 0) return $ids;
		return false;
	}
	
	/**
	 * Condensado tudo em add_batch
	/*
    public function addDadosVeiculo($tabela, $dados)
    {
		$this->db->insert_batch($tabela, $dados); 
        return true;
    }
	
    public function addDadosMateriais($tabela, $dados)
    {
		$this->db->insert_batch($tabela, $dados);
        return true;
    }
	
    public function addDadosContrato($tabela, $dados)
    {
		$this->db->insert_batch($tabela, $dados); 
		return true;
    }
	*/
    public function limpa_dados_anteriores($id, $tabela)
    {
		$this->db->where('idFuncionario', $id);
		$this->db->delete($tabela);
		
        if ($this->db->affected_rows() > 0)
			return true;
		
		return false;
    }
}

