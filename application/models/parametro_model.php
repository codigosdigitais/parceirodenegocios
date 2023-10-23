<?php
class Parametro_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        $sql = "SELECT p.*, c.parametro as parametroCategoria, c.idParametro, c.idParametroCategoria FROM parametro as p, parametro as c WHERE p.idParametro = c.idParametroCategoria ORDER BY c.idParametroCategoria DESC, c.parametro ASC";
        return $this->db->query($sql)->result();
    }

    function getById($id){
        $this->db->where('idParametro',$id);
        $this->db->limit(1);
        return $this->db->get('parametro')->row();
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
    
	
	public function ListaParametrosCategoria()
	{
        $sql = "SELECT * FROM parametro WHERE idParametroCategoria = '0' ORDER BY parametro ASC";
        return $this->db->query($sql)->result();
	}
	

}