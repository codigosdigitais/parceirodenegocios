<?php
class tabelafrete_model extends CI_Model {

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
		if($this->input->post('idCidade')==NULL) $idCidade = 1; else $idCidade = $this->input->post('idCidade');
		
		$sql = "SELECT * FROM bairro WHERE idCidade = '{$idCidade}' ORDER BY bairro ASC";
        return $this->db->query($sql)->result();
    }
	

    function getLista($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
		$sql = "SELECT * FROM bairro WHERE idCidade = '1' GROUP BY idCidade ORDER BY bairro ASC LIMIT {$start}, {$perpage}";
        return $this->db->query($sql)->result();
    }

    function getById($id){
		
		$sqlRegistros = "
			SELECT c1.*, c2.bairro as nomeBairro, c2.idBairro as idBairro, c3.idCidade, c3.cidade
			FROM tabelafrete c1
			LEFT JOIN bairro c2 ON(c2.idBairro=c1.idSaida)
			LEFT JOIN cidade c3 ON(c3.idCidade=c2.idCidade)
			WHERE idSaida = '".$id."'
		";
		$consultaRegistros = $this->db->query($sqlRegistros)->result();
		//print_r($consultaRegistros);
		$consulta = new stdClass;
		
		foreach($consultaRegistros as $valor){
			$sql = "SELECT * FROM bairro as b Left join tabelafrete as t on b.idBairro = t.idDestino and t.idSaida = '".$id."' WHERE b.idCidade = '".$valor->idCidade."' ORDER BY b.idBairro ASC";
			$consulta = $this->db->query($sql)->result();
		}
		//echo 
		return $consulta;
    }
	
    function getByIdMetropolitano($id){
		
		$sqlRegistros = "
			SELECT c1.*, c2.cidade as nomeCidade, c2.idCidade
			FROM tabelafretem AS c1
			LEFT JOIN cidade AS c2 ON(c1.idSaida=c2.idCidade)
			WHERE idSaida = '".$id."'
		";
		$consultaRegistros = $this->db->query($sqlRegistros)->result();
		
		//echo $sqlRegistros;
		
		//print_r($consultaRegistros); die();
		$consulta = new stdClass;
		
		foreach($consultaRegistros as $valor){
			$sql = "
				SELECT * FROM cidade AS c1 LEFT JOIN tabelafretem as c2 ON(c1.idCidade=c2.idSaida) WHERE c2.idSaida = '".$valor->idCidade."' ORDER BY c2.idSaida

				";
			$consulta = $this->db->query($sql)->result();
		} 
		
/*		echo "<pre>";
		print_r($consulta);
		echo "</pre>";
		echo $sql;
		die();*/
		
		
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
    
	
	function getCidades(){
		return $this->db->get('cidade')->result();	
	}
	
	function getBairros(){
		$this->db->where("idCidade", "1"); 
		return $this->db->get('bairro')->result();	
	}
	
	function getBairrosByIdCidade($idCidade){
		$this->db->where("idCidade", $idCidade); 
		return $this->db->get('bairro')->result();	
	}	
	
	function getBairrosById($id_bairro){
		$this->db->where("idBairro", $id_bairro);
		return $this->db->get('bairro')->row();	
	}	

	function getCidadesById($id_cidade){
		$this->db->where("idCidade", $id_cidade);
		return $this->db->get('cidade')->row();	
	}	
	
    function limpa_dados_anteriores($id, $tabela)
    {
		$this->db->where('idSaida', $id);
		$this->db->delete($tabela);  
        return true;
    }	
	

	
    function addTabelaFrete($dados)
    {
		$this->db->insert('tabelafrete', $dados);
		
    	if ($this->db->affected_rows() == '1')
			return $this->db->insert_id();
		
		return false;
    }
	
    function addTabelaFreteMetropolitano($dados)
    {
		$tabela = 'tabelafretem';
		
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
}