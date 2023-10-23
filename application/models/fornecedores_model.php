<?php
class fornecedores_model extends CI_Model {

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
        $this->db->select($fields);
        $this->db->from($table);
		$this->db->where("idEmpresa", $idEmpresa);
        $this->db->order_by('idFornecedor','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
		

    }

    function getById($id){
		$sql = "SELECT * FROM fornecedor as f, estados as e WHERE f.endereco_estado = e.idEstado OR f.idFornecedor = '{$id}' GROUP BY f.idFornecedor";
		$consulta = $this->db->query($sql)->result();
		
		foreach($consulta as &$valor){
			$sql = "select c.*, p.idParametro, p.parametro as setor from fornecedor_responsaveis as c, parametro as p where p.idParametro = c.setor and c.idFornecedor = '{$id}' ORDER BY c.idFornecedorResponsavel";
			$valor->clienteResponsaveis = $this->db->query($sql)->result();

			$sql_novo = "SELECT * FROM documento WHERE idAdministrador = '{$id}' AND modulo = 'fornecedor'";
			$valor->documentacao = $this->db->query($sql_novo)->result();
		}
		
		return $consulta;
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
        
        if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    public function deleteWhereNotIn($table, $attrToIgnore, $arrValToIgnore, $where)
    {
    	$this->db->where($where);
    	 
    	if ($attrToIgnore != null)
    		$this->db->where_not_in($attrToIgnore, $arrValToIgnore);
    		 
    	$this->db->delete($table);
    	
    	return true;
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
		
		if ($this->db->affected_rows() == '1')
			return $this->db->insert_id();
		
			else return false;
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
        return true;
    }	


	public function GetEstado($id)
	{
        $sql = "SELECT * FROM estados WHERE id = '".$id."' ORDER BY estado ASC";
        return $this->db->query($sql)->row();
	}
	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
		
	}

}