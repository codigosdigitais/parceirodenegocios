<?php
class descontos_model extends CI_Model {

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
	


	public function getListaCedentesBase() { //$id
		$idEmpresa = $this->session->userdata['idEmpresa'];
			
		$tabela = "cedente";
			
		$this->db->where('idEmpresa', $idEmpresa);
	
		/*if (is_numeric($id)) {
			$this->db->where('(situacao = 1 OR idCedente = (select idCedente from folhapagamento_parametro where idFolhaParametro = '.$id.') )');
		}
		else {*/
			$this->db->where('situacao', 1);
		//}
	
		$this->db->order_by('razaosocial');
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
	function getPesquisar(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
	
		$this->db->select("desconto.*, funcionario.idFuncionario, funcionario.nome as nomeFuncionario, parametro.parametro as nomeParametro,
					(CASE desconto.referencia 
						when 1 then 'Janeiro'
						when 2 then 'Fevereiro'
						when 3 then 'Março'
						when 4 then 'Abril'
						when 5 then 'Maio'
						when 6 then 'Junho'
						when 7 then 'Julho'
						when 8 then 'Agosto'
						when 9 then 'Setembro'
						when 10 then 'Outubro'
						when 11 then 'Novembro'
						when 12 then 'Dezembro'
					END) AS referencia
		");

		if($this->input->post('idFuncionario')){ $this->db->where('desconto.idFuncionario', $this->input->post('idFuncionario')); }
		if($this->input->post('idTipo')){ $this->db->where('desconto.tipo', $this->input->post('idTipo')); }
		if($this->input->post('periodo')){ $this->db->where('desconto.referencia', $this->input->post('periodo')); }
		if($this->input->post('data_inicial') and $this->input->post('data_final')){ $this->db->where("desconto.data BETWEEN '".$this->input->post('data_inicial')."' AND '".$this->input->post('data_final')."'"); }
		
		$this->db->where('funcionario.idEmpresa', $idEmpresa);
		
		$this->db->join("funcionario", "funcionario.idFuncionario=desconto.idFuncionario", "LEFT");		
		$this->db->join("parametro", "parametro.idParametro=desconto.tipo", "LEFT");
		
		$consulta = $this->db->get('desconto')->result();
		return $consulta;
	}
	
	
	  
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
		if(empty($start) || !is_numeric($start)) $start = 0;
		if (!is_numeric($perpage)) $perpage = 0;
		
		$sql = "
				SELECT 
					p.*, 
					f.idFuncionario, 
					f.nome AS nomeFuncionario, 
					pa.parametro AS nomeParametro,
					(CASE p.referencia 
						when 1 then 'Janeiro'
						when 2 then 'Fevereiro'
						when 3 then 'Março'
						when 4 then 'Abril'
						when 5 then 'Maio'
						when 6 then 'Junho'
						when 7 then 'Julho'
						when 8 then 'Agosto'
						when 9 then 'Setembro'
						when 10 then 'Outubro'
						when 11 then 'Novembro'
						when 12 then 'Dezembro'
					END) AS referencia
				FROM
					desconto AS p, 
					funcionario AS f, 
					parametro AS pa 
				WHERE 
					p.idFuncionario = f.idFuncionario 
				AND
					f.idEmpresa = ".$idEmpresa."
				AND 
					pa.idParametro = p.tipo
				ORDER BY p.idDesconto DESC	
				LIMIT $start, $perpage  
		";
		
		$consulta = $this->db->query($sql)->result();
		
		return $consulta;
    }
	
	
	function tipo_parametro($idParametro){
		$this->db->where('idParametro', $idParametro);
		$this->db->order_by('parametro', 'DESC');
		return $this->db->get('parametro')->row();			
	}
	
	function lista_funcionario($funcionario){

			if($funcionario=='all'){
				$sql = "
					SELECT 
						c1.*, 
						c2.idFuncionario, 
						c2.nome,
						c3.idFuncionario,
						c3.salario,
						c4.idCedente,
						c4.razaosocial
					FROM 
						funcionario_dadosregistro AS c1
					JOIN funcionario AS c2 ON (c2.idFuncionario=c1.idFuncionario)
					LEFT JOIN funcionario_remuneracao AS c3 ON(c3.idFuncionario=c2.idFuncionario)
					JOIN cedente AS c4 ON (c4.idCedente=c1.empresaregistro)
					WHERE 
						c1.empresaregistro = '".$this->input->post('empresaRegistro')."' 
					GROUP BY c2.idFuncionario 
				";
				$consulta = $this->db->query($sql)->result();

			} else { 
			
				$sql = "
					SELECT 
						c1.*, 
						c2.idFuncionario, 
						c2.nome,
						c3.idFuncionario,
						c3.salario,
						c4.idCedente,
						c4.razaosocial
					FROM 
						funcionario_dadosregistro AS c1
					JOIN funcionario AS c2 ON (c2.idFuncionario='".$funcionario."')
					LEFT JOIN funcionario_remuneracao AS c3 ON(c3.idFuncionario=c2.idFuncionario)
					JOIN cedente AS c4 ON (c4.idCedente=c1.empresaregistro)
					WHERE 
						c1.empresaregistro = '".$this->input->post('empresaRegistro')."' 
					GROUP BY c2.idFuncionario 
				";
				$consulta = $this->db->query($sql)->result();
		
			}
			
			return $consulta;

	}
	
	
	function getCedente($idEmpresa){
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by('razaosocial', 'DESC');
		return $this->db->get('cedente')->result();	
	}


    function getById($id){
		
        $this->db->where('idDesconto',$id);
        $this->db->limit(1);
        return $this->db->get('desconto')->row();
		
		
    }
    
    function add($table,$data){

        $this->db->insert_batch($table, $data);   
        if ($this->db->affected_rows() == '1'){
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

	public function GetEstado($id)
	{
        $sql = "SELECT * FROM estados WHERE id = '".$id."' ORDER BY estado ASC";
        return $this->db->query($sql)->row();
	}

	public function getBase($tabela, $cod, $order, $idAtual = null)
	{
		if (!is_numeric($idAtual)) $idAtual = null;
	
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by($cod, $order);
	
		if ($tabela == 'cliente') {
			$this->db->where('situacao', 1);
		}
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFuncionario IN (select idFuncionario from desconto where idDesconto = '.$idAtual.')');
			}
		}
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
    function getByIdView($id){

        $sql = "
				SELECT 
					d.*,
					f.idFuncionario,
					f.nome as nomeFuncionario,
					pa.*
				FROM
					desconto AS d, 
					funcionario AS f,
					parametro as pa
				WHERE
					d.idDesconto = '".$id."'
				AND
					d.idFuncionario = f.idFuncionario
				AND
					d.tipo = pa.idParametro
		";
		 $consulta = $this->db->query($sql)->result();
		 
		foreach($consulta as &$valor)
		{
			$sql = "
					SELECT 
						d.*,
						f.*,
						p.*,
						p.parametro as nomeParametro
					FROM 
						desconto AS d
					INNER JOIN 
						funcionario AS f ON d.idFuncionario = f.idFuncionario
					INNER JOIN 
						parametro AS p ON d.tipo = p.idParametro
					WHERE d.idFuncionario = '".$valor->idFuncionario."'					
			
			";	


			 $valor->listaProventosView = $this->db->query($sql)->result();		 
		}
		
		return $consulta;
    }

}