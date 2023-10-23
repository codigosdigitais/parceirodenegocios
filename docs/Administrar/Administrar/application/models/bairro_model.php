<?php
class Bairro_model extends CI_Model {

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
        
		
//         $sql = "SELECT b.*, b.idTipo as idTipoBairro, c.* FROM bairro as b, cidade as c WHERE b.idCidade = c.idCidade ORDER BY b.idBairro DESC";
//         return $this->db->query($sql)->result();
		
		
        $this->db->select('b.*, b.idTipo as idTipoBairro, c.*');
        $this->db->from('bairro as b, cidade as c');
        $this->db->order_by('c.cidade, b.bairro','asc');
        $this->db->where('b.idCidade = c.idCidade');
        $this->db->limit($perpage,$start);
        
        $query = $this->db->get();
        
        if ($this->db->affected_rows() > 0)
        {
        	return $query->result();
        }
        
        return FALSE;

    }

    function getById($id){
        $this->db->where('idBairro',$id);
        $this->db->limit(1);
        return $this->db->get('bairro')->row();
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
    
	
	public function getCidades(){
		return $this->db->get('cidade')->result();	
	}
	
	public function getTipoBairro($id)
	{

		switch($id)
		{
			case 1:
				$id = "Centro";
				break;
			
			case 2:
				$id = "Bairro";
				break;
			
			case 3:
				$id = "Afastado";
				break;
		}
		return $id;
	}
	

}