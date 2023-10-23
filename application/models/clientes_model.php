<?php
class Clientes_model extends CI_Model {

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
    	# Get Clientes - Modificada em 16-10-2016	# Ordenação de listagem de clientes - primeiro os cadastros que vieram externos	# Situacao DESC - 10 x	
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
		if(!empty($_GET['cnpj']) || !empty($_GET['razaosocial'])){			$razaosocial = $_GET['razaosocial'];			$cnpj = $_GET['cnpj'];		} else { 			$razaosocial = NULL;			$cnpj = NULL;		}
        $idEmpresa = $this->session->userdata['idEmpresa'];        $this->db->select($fields);        $this->db->from($table);		$this->db->where("idEmpresa", $idEmpresa);
		if($razaosocial==TRUE){ 			$this->db->like('razaosocial', $_GET['razaosocial']); 		}
		if($cnpj==TRUE){ 			$this->db->where('cnpj', $_GET['cnpj']); 		}
        $this->db->order_by('situacao','DESC');        $this->db->order_by('razaosocial','ASC');        $this->db->limit($perpage,$start);
        if($where){            $this->db->where($where);        }
        $query = $this->db->get();         $result =  !$one  ? $query->result() : $query->row();        return $result;    }
	


    function getById($id){
		$sql = "
				SELECT
					c.*, 
					e.*,
					e.estado as nomeEstado
				FROM
					cliente as c
				LEFT JOIN estados as e ON (c.endereco_estado = e.idEstado)
				
					
				WHERE
					c.idCliente = '".$id."'
		";
        $consulta = $this->db->query($sql)->result();
		///echo $this->db->last_query(); die();
		foreach($consulta as &$valor){
			$sql = "select c.*, p.idParametro, p.parametro as setor from cliente_responsaveis as c, parametro as p where p.idParametro = c.setor and c.idCliente = '".$valor->idCliente."'";
			$valor->clienteResponsaveis = $this->db->query($sql)->result();
			
			$sql_novo = "SELECT * FROM documento WHERE idAdministrador = {$valor->idCliente} AND modulo = 'cliente'";
			$valor->documentacao = $this->db->query($sql_novo)->result();
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

    function count($table) {
        return $this->db->count_all($table);
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
	
	function cadastrando($tabela, $dados){
		$this->db->insert($tabela, $dados);
		return $this->db->insert_id();
	}
	
    public function addBatch($tabela, $dados)
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
    public function limpa_dados_anteriores($id, $tabela)
    {
		$this->db->where('idCliente', $id);
		$this->db->delete($tabela);
		
        if ($this->db->affected_rows() > 0)
			return true;
		
        return false;
    }	

    public function getListaCedentesBase($idCliente) {
    	
    	$tabela = "cedente";
    	
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	$this->db->where('idEmpresa', $idEmpresa);

    	if (is_numeric($idCliente)) {
    		$this->db->where('(situacao = 1 OR idCedente = (select codCedente from cliente where idCliente = '.$idCliente.') )');
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
    
	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
		
		if ($where != null)
			$this->db->where($where);
		
        $this->db->order_by($cod, $order);
        
        $result = $this->db->get($tabela);
        
        if ($this->db->affected_rows() > 0)
        	return  $result->result();
        
        return false;
		
	}
	
	public function getRegistro($tipo, $campo, $id, $retorno){

		/*
		echo "<pre>";
		print_r("tipo::".$tipo);
		print_r("<br>campo::".$campo);
		print_r("<br>id::".$id);
		print_r("<br>retorno::".$retorno);
		die();
		*/
		
		switch($tipo){
			case 'cidade':
			$this->db->where($campo, $id);	
			return $this->db->get('cidade')->result();
			break;
			
			case 'bairro':
			$this->db->where($campo, $id);	
			return $this->db->get('bairro')->result();
			break;
			
			case 'cliente':
			$this->db->where($campo, $id);	
			return $this->db->get('cliente')->row($retorno);
			break;
		}
	}
}