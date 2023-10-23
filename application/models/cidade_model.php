<?php
class Cidade_model extends CI_Model {

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
        
		
//         $sql = "SELECT c.*, e.* FROM cidade as c, estados as e WHERE c.idEstado = e.idEstado";
		$this->db->select('c.*, e.*');
		$this->db->from('cidade c, estados e');
		$this->db->where('c.idEstado = e.idEstado');
        $this->db->limit($perpage,$start);
        
//         return $this->db->query($sql)->result();
        $query = $this->db->get();

        if ($this->db->affected_rows() > 0)
        {
        	return $query->result();
        }
        
        return FALSE;

    }

    function getById($id){
        $this->db->where('idCidade',$id);
        $this->db->limit(1);
        return $this->db->get('cidade')->row();
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
	
	public function getTipoCidade($id)
	{

		switch($id)
		{
			case 1:
				$id = "Capital";
				break;
			
			case 2:
				$id = "Metropolitano";
				break;
			
			case 3:
				$id = "Interior";
				break;
		}
		return $id;
	}
	

}