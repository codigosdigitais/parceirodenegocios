<?php
class Permission_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    public function getPermissoesUsuario($idUsuario) {
    	
    	$this->db->select('a.idUsuarioPerfil');
    	$this->db->select('b.idPerfil, b.nome nomePerfil');
    	$this->db->select('c.canSelect, c.canInsert, c.canUpdate, c.canDelete, c.visivel');
    	$this->db->select('d.nome nomeFuncao, d.ordem ordemFuncao');
    	$this->db->select('e.nome nomeModulo, e.ordem ordemModulo');
    	$this->db->select('f.idFuncao, f.controller, f.tipo');
    	
    	$this->db->from('sis_usuario_perfil a');
    	
    	$this->db->join('sis_perfil b', 'a.idPerfil = b.idPerfil', 'right');
    	$this->db->join('sis_perfil_funcao c', 'a.idPerfil = c.idPerfil', 'left');
    	$this->db->join('sis_modulo_cliente_funcao d', 'c.idModuloClienteFuncao = d.idModuloClienteFuncao', 'left');
    	$this->db->join('sis_modulo_cliente e', 'd.idModuloCliente = e.idModuloCliente', 'left');
    	$this->db->join('sis_funcao f', 'd.idFuncao = f.idFuncao', 'left');
    	
    	$this->db->where('a.idUsuario', $idUsuario);
    	$this->db->where('b.situacao', true);
    	$this->db->where('c.situacao', true);
    	$this->db->where('d.situacao', true);
    	$this->db->where('e.situacao', true);
    	$this->db->where('f.situacao', true);
    	
    	$this->db->order_by('b.nome asc, e.ordem asc, e.nome asc, d.ordem asc, d.nome asc');
    	
    	$result = $this->db->get();

    	if ($this->db->affected_rows() > 0)
    	{
    		return $result->result();
    	}
    	
    	return false;
    }

    public function getPermissoesPerfilSimulacao($idPerfil) {
    	 
    	//$this->db->select('a.idUsuarioPerfil');
    	$this->db->select('b.idPerfil, b.nome nomePerfil');
    	$this->db->select('c.canSelect, c.canInsert, c.canUpdate, c.canDelete, c.visivel');
    	$this->db->select('d.nome nomeFuncao, d.ordem ordemFuncao');
    	$this->db->select('e.nome nomeModulo, e.ordem ordemModulo');
    	$this->db->select('f.idFuncao, f.controller, f.tipo');
    	 
    	$this->db->from('sis_perfil b');
    	 
    	//$this->db->join('sis_perfil b', 'a.idPerfil = b.idPerfil', 'right');
    	$this->db->join('sis_perfil_funcao c', 'b.idPerfil = c.idPerfil', 'left');
    	$this->db->join('sis_modulo_cliente_funcao d', 'c.idModuloClienteFuncao = d.idModuloClienteFuncao', 'left');
    	$this->db->join('sis_modulo_cliente e', 'd.idModuloCliente = e.idModuloCliente', 'left');
    	$this->db->join('sis_funcao f', 'd.idFuncao = f.idFuncao', 'left');
    	 
    	$this->db->where('b.idPerfil', $idPerfil);
    	$this->db->where('b.situacao', true);
    	$this->db->where('c.situacao', true);
    	$this->db->where('d.situacao', true);
    	$this->db->where('e.situacao', true);
    	$this->db->where('f.situacao', true);
    	 
    	$this->db->order_by('b.nome asc, e.ordem asc, e.nome asc, d.ordem asc, d.nome asc');
    	 
    	$result = $this->db->get();
    	
    	if ($this->db->affected_rows() > 0)
    	{
    		return $result->result();
    	}
    	 
    	return false;
    }
    
}