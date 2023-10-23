<?php
class Contratos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

public function getContratos()
{
	$resultado = $this->db
							->select('
										c1.idContrato,
										c1.dataativo, 
										c1.renovacao,
										c2.razaosocial, 
										c2.responsavel,
										(
										SELECT 
											count(c3.idContratoFuncionario) 
										FROM 
											contrato_funcionario as c3
										WHERE c3.idContrato=c1.idContrato
										) as total_funcionarios										
									')
							->join("cliente as c2", "c2.idCliente=c1.idCliente")
							->order_by('c2.razaosocial', 'ASC')
							->where('c1.situacao', 1)
							->get('contrato as c1')
							->result();

	return $resultado;

	#echo "<pre>";
	#print_r($resultado);
	#die();

}    
	
	/*
	public function getModulosCategoria(){
		$sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
		$consulta = $this->db->query($sql)->result();	
		
			foreach($consulta as &$valor){
				$sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
				$valor->subModulo = $this->db->query($sql_model)->result();		
			}
		
		return $consulta;
	}
	*/

	
	public function getListaCedentesBase($idContrato) {
		 
		$tabela = "cedente";
		 
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
	
		if (is_numeric($idContrato)) {
			$this->db->where('(situacao = 1 OR idCedente = (select idCedente from contrato where idContrato = '.$idContrato.') )');
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
	
    
    /*
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
		
		if(empty($start)) $start = 0;
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select('c.*, cl.*');
		$this->db->select('sum(con.valor) as valorContrato, count(con.idContrato) as quantidadeFuncionario');
		$this->db->from('contrato as c, cliente as cl');
		$this->db->where('c.idCliente = cl.idCliente AND c.idEmpresa = ' . $idEmpresa);
		$this->db->join('contrato_funcionario con', 'con.idContrato = c.idContrato', 'LEFT');
		$this->db->group_by('c.idContrato');
		$this->db->limit($perpage,$start);
		
		$consulta = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			$consulta = $consulta->result();
			//var_dump($consulta); die();
			return $consulta;
		}
		return false;
    }
	*/

    public function getById($id){

		
        $this->db->where('idContrato',$id);
        $this->db->limit(1);
        $consulta = $this->db->get('contrato')->result();
		

		foreach($consulta as &$valor){
			$this->db->where('idCliente', $valor->idCliente);
			$valor->cliente = $this->db->get('cliente')->result();

			$sql = "SELECT 
						cf.*, 
						f.idFuncionario, 
						f.nome as nomeFuncionario
					FROM 
						contrato_funcionario as cf, 
						funcionario as f 
					WHERE 
						cf.idContrato = '".$valor->idContrato."'
					AND
						cf.idFuncionario = f.idFuncionario 
					GROUP BY 
						f.idFuncionario";
			$valor->funcionarioLista = $this->db->query($sql)->result();
		}
		
		return $consulta;
		
    }
	
   
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		FALSE;       
    }
	
	function cadastrando($tabela, $dados){
		$this->db->insert($tabela, $dados);
		return $this->db->insert_id();	
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
    
	public function getParametroById($id)
	{
        $this->db->where('idParametroCategoria',$id);
        $this->db->order_by('parametro','ASC');
        return $this->db->get('parametro')->result();		
	}

    public function addContratoFuncionario($dados)
    {


    	$tabela = 'contrato_funcionario';
        $ids = array();
    	foreach ($dados as $dado) {
    		$this->db->insert($tabela, $dado);
			echo $this->db->last_query();
    		
    		if ($this->db->affected_rows() == '1') {
    			array_push($ids, $this->db->insert_id());
    		}
    	}				
		if (count($ids) > 0) return $ids;
		return false;
    }



	public function getBase($tabela, $cod, $order, $idAtual = null)
	{
		if (!is_numeric($idAtual)) $idAtual = null;
		
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
        $this->db->order_by($cod, $order);
        
        if ($tabela == 'cliente') {
        	$this->db->where('situacao', 1);
        	if ($idAtual != null) {
        		$this->db->or_where('idCliente = (select idCliente from contrato where idContrato = '.$idAtual.')');
        	}
        }

        if ($tabela == 'funcionario') {
        	$this->db->where('situacao', 1);
        	if ($idAtual != null) {
        		$this->db->or_where('idFuncionario IN (select idFuncionario from contrato_funcionario where idContrato = '.$idAtual.')');
        	}
        }

        $result = $this->db->get($tabela);
        //die($this->db->last_query());
        if ($this->db->affected_rows() > 0) {
        	return  $result->result();
        }
        
        return false;
		
	}
	
	
    public function limpa_dados_anteriores($id, $tabela)
    {
		$this->db->where('idContrato', $id);
		$this->db->delete($tabela);
		
        if ($this->db->affected_rows() > 0)
			return true;
		
        return false;
    }	


}