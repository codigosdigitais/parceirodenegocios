<?php
class documentos_model extends CI_Model {

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

	public function getListaCedentesBase($idDocumento) {
			
		$tabela = "cedente";
			
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
	
		if (is_numeric($idDocumento)) {
		 $this->db->where('(situacao = 1 OR idCedente = (select idAdministrador from documento where idDocumento = '.$idDocumento.') )');
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
	
    function get($table1, $tipoId, $table2, $modulo, $perpage=0, $start=0, $idTipoPropaganda=null){
    	if(empty($start)) $start = 0;
    	
    	$nomeCampoNome = 'razaosocial';
    	if ($table2 == 'funcionario') $nomeCampoNome = "nome";
    	
		$idEmpresa = $this->session->userdata['idEmpresa'];

		$this->db->select("t.*");
		$this->db->from($table1 .' as t');
		$this->db->where("t.modulo = '".$modulo."'");
		$this->db->where("t.idEmpresa = ".$idEmpresa);

		if ($idTipoPropaganda != null) {
			$this->db->where("t.idAdministrador = ".$idTipoPropaganda);
		}

		if ($table2 != null) {
			$this->db->select("c.$tipoId, c.$nomeCampoNome as nomePessoaJF");
			$this->db->where("t.idAdministrador = c.".$tipoId);
			$this->db->from($table2 .' as c');
		}

		$this->db->order_by('t.idDocumento desc');
		$this->db->limit($perpage,$start);
		
		$result = $this->db->get();
		
// 		die($this->db->last_query());

		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
    }
	
   /*function getContrato($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

		$sql = "
					SELECT 
						t.*,
						c.*,
						c.razaosocial as nomeCliente
					FROM 
						documento as t,
						cliente as c
					WHERE 
						t.modulo = 'contrato'
					AND
						t.idAdministrador = c.idCliente
		";
		
		return $this->db->query($sql)->result();
    }*/

   /*function getFuncionario($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

		$sql = "
					SELECT 
						d.*,
						f.*,
						f.nome as nomeFuncionario
					FROM 
						documento as d,
						funcionario as f
					WHERE 
						d.modulo = 'funcionario'
					AND
						d.idAdministrador = f.idFuncionario
		";
		
		return $this->db->query($sql)->result();
    }*/
		
   /*function getAtestado($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

		$sql = "
					SELECT 
						d.*,
						f.*,
						f.nome as nomeFuncionario
					FROM 
						documento as d,
						funcionario as f
					WHERE 
						d.modulo = 'atestado'
					AND
						d.idAdministrador = f.idFuncionario
		";
		
		return $this->db->query($sql)->result();
    }*/
		

    function getById($id){
		$sql = "SELECT * FROM documento WHERE idDocumento = '".$id."'";
		$consulta = $this->db->query($sql);
		

		if ($this->db->affected_rows() > 0)
		{
			return $consulta->result();
		}
		
		return FALSE;
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

    /*function count($table) {
        return $this->db->count_all($table);
    }*/


    function count($table1,$tipoId,$table2,$modulo){
    	
		$idEmpresa = $this->session->userdata['idEmpresa'];

		$this->db->select("t.*");
		$this->db->from($table1 .' as t, '.$table2 .' as c');
		$this->db->where("t.idAdministrador = c.".$tipoId);
		$this->db->where("t.modulo = '".$modulo."'");
		$this->db->where("t.idEmpresa = ".$idEmpresa);
		
		$result = $this->db->get();
		
// 		die($this->db->last_query());

		if ($this->db->affected_rows() > 0) {
			return  $result->num_rows();
		}
	
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
			if ($idAtual != null) {
				$this->db->or_where('idCliente = (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFuncionario IN (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}

		if ($tabela == 'fornecedor') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFornecedor IN (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
	public function getBaseContrato($tabela, $cod, $order)
	{
        $sql  = "
					select c.*, cl.*, cl.razaosocial as RazaoSocialContrato from contrato as c, cliente as cl where c.idCliente = cl.idCliente
		
		";
          return $this->db->query($sql)->result();
		
	}
	
    function getByIdView($id){

        $sql = "
				SELECT 
					f.*,
					fn.nome as nomeFuncionario,
					fn.idFuncionario
				FROM
					atraso AS f,
					funcionario AS fn
				WHERE
					f.idatraso = '".$id."'
				AND
					fn.idFuncionario = f.idFuncionario
		";
		 $consulta = $this->db->query($sql)->result();
		 
		 	foreach($consulta as &$valor)
			{
				$sql = "
							SELECT 
								f.*,
								p.parametro as nomeParametro,
								p.idParametro
							FROM
								atraso AS f,
								parametro AS p
							WHERE
								f.idFuncionario = '".$valor->idFuncionario."'
							AND 
								f.tipo = p.idParametro
				";	
				$valor->listadocumentos = $this->db->query($sql)->result();
			}
		 
		
		return $consulta;
    }
}