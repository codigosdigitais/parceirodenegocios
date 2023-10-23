<?php
class adicionais_model extends CI_Model {

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
    	
		$sql = "
				SELECT 
					p.*, 
					f.idFuncionario, 
					f.nome AS nomeFuncionario, 
					pa.parametro AS nomeParametro 
				FROM
					adicional AS p, 
					funcionario AS f, 
					parametro AS pa 
				WHERE 
					p.idAdministrativo = f.idFuncionario 
				AND
					f.idEmpresa = ".$idEmpresa."
				AND 
					pa.idParametro = p.idParametro 
				AND p.modulo = 'funcionario'
				ORDER BY p.data DESC, tipoValor ASC  
		";
 		
		return $this->db->query($sql)->result();
    }

    function getById($id){
		
        $this->db->where('idAdicional',$id);
        $this->db->limit(1);
        return $this->db->get('adicional')->row();
		
		
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
	
		/*if ($tabela == 'cliente') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idCliente = (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}*/
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFuncionario IN (select idAdministrativo from adicional where idAdicional = '.$idAtual.')');
			}
		}
	
		/*if ($tabela == 'fornecedor') {
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


			 $valor->listaDescontosView = $this->db->query($sql)->result();		 
		}
		
		return $consulta;
    }

}