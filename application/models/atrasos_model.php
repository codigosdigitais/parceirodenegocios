<?php
class atrasos_model extends CI_Model {

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
		
		$sql = "
				SELECT 
					p.*, 
					f.idFuncionario, 
					f.nome AS nomeFuncionario, 
					pa.parametro AS nomeParametro 
				FROM
					atraso AS p, 
					funcionario AS f, 
					parametro AS pa 
				WHERE 
					p.idFuncionario = f.idFuncionario 
				AND 
					pa.idParametro = p.tipo 
		";
 		
		return $this->db->query($sql)->result();
    }

    function getById($id){
		
        $this->db->where('idAtraso',$id);
        $this->db->limit(1);
        return $this->db->get('atraso')->row();
		
		
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
	
	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idCliente'];
		$this->db->where('idEmpresa', $idEmpresa);
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
		
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
				$valor->listaatrasos = $this->db->query($sql)->result();
			}
		 
		
		return $consulta;
    }

}