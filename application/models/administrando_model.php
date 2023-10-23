<?php
class administrando_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	public function get($tabela){
		$sql = "SELECT * FROM cliente WHERE tipo = 'parceiro' ORDER BY razaosocial ASC";
		return $this->db->query($sql)->result();
	}
	
    function getById($id){
        $this->db->where('idModulo',$id);
        $this->db->limit(1);
        return $this->db->get('modulos')->row();
    }
	
    function getByIdParametro($id){
        $this->db->where('idParametro',$id);
        $this->db->limit(1);
        return $this->db->get('parametro')->row();
    }
	
    function getByIdADMCliente($id){
		$sql = "SELECT * FROM cliente WHERE idCliente = '{$id}'";
		return $this->db->query($sql)->row();
    } 
	
	public function getModulos($cod=null){
		$sql = "
			SELECT
			   modulo.*, 
			   principal.idModulo AS idModuloBase,
			   principal.modulo AS moduloBase,
			   principal.pasta AS pastaBase
			FROM modulos AS modulo
			INNER JOIN modulos AS principal
			ON principal.idModulo = modulo.idModuloBase
		";
		return $this->db->query($sql)->result();	
	}
	
	public function getParametrosLista(){
		$sql = "			
			SELECT
				parametro AS base_parametro,
				idParametro as base_idParametro,
				idParametroCategoria
			FROM parametro WHERE idParametroCategoria = '0' ORDER BY parametro ASC
		";
		return $this->db->query($sql)->result();	
	}
	
	public function getParametros($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

		if(empty($start) || !is_numeric($start)) $start = 0;
		if(!empty($_GET['tipo_parametro'])) 
		{
			$tipo_parametro = $_GET['tipo_parametro']; 
			$paginador = "";
		} 
		else
		{
			$tipo_parametro = 0;
			$paginador = "LIMIT $start, $perpage";
		}

		
        $sql = 	"
			SELECT
				parametro AS base_parametro,
				idParametro as base_idParametro,
				idParametroCategoria,
				codigoeSocial,
				dsceSocial
			FROM parametro WHERE idParametroCategoria = '{$tipo_parametro}' ORDER BY parametro ASC
			{$paginador}
			";

		$consulta = $this->db->query($sql)->result();
		
			foreach($consulta as &$valor){
				$sql_sub = "
				SELECT
					parametro AS sub_parametro,
					idParametro AS sub_idParametro,
					idParametroCategoria,
					codigoeSocial,
					dsceSocial
				FROM parametro WHERE idParametroCategoria = '".$valor->base_idParametro."' ORDER BY parametro ASC";
				$valor->sub_parametros = $this->db->query($sql_sub)->result();	
			}
			
		return $consulta;
		
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

    function count($table) {
        return $this->db->query("SELECT * FROM $table WHERE idParametroCategoria = '0'")->num_rows();
    }	
	
	public function listaModulosBase(){
        $this->db->where('idModuloBase',"0");
        return $this->db->get('modulos')->result();	
	}
	
    function add($table,$data){
        $this->db->insert($table, $data);
		
        if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
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
		
        $this->db->where("idCliente",$ID);
        $this->db->delete("permissoes");
		
        $this->db->where("idCliente",$ID);
        $this->db->delete("usuario");
		
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    public function limpa_dados_anteriores($id, $tabela)
    {
		$this->db->where('idCliente', $id);
		$this->db->delete($tabela);  
        return true;
    }	
	public function ListaParametrosCategoria()
	{
        $sql = "SELECT * FROM parametro WHERE idParametroCategoria = '0' ORDER BY parametro ASC";
        return $this->db->query($sql)->result();
	}

}