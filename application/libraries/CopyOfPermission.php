<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Permission Class
 *
 * Biblioteca para controle de permissões
 *
 * @author		Ramon Silva
 * @copyright	        Copyright (c) 2013, Ramon Silva.
 * @since		Version 1.0
 * v... Visualizar
 * e... Editar
 * d... Deletar ou Desabilitar
 * c... Cadastrar
 * array de permissoes para o autosig.
 */



class Permission{

    var $Permission = array();
    var $table = 'permissoes';//Nome tabela onde ficam armazenadas as permissões
    var $pk = 'idPermissao';// Nome da chave primaria da tabela
    var $select = 'permissoes';// Campo onde fica o array de permissoes.

    public function  __construct() {
    	
        log_message('debug', "Permission Class Initialized");
        $this->CI =& get_instance();
        $this->CI->load->database();

    }

    public function checkPermission($idPermissao = null,$atividade = null){
		
        if($idPermissao == null || $atividade == null){
            return false;
        }
		
        // Se as permissões não estiverem carregadas, requisita o carregamento
        if($this->Permission == null){
            if(!$this->loadPermission($idPermissao)){
                return false;
            }
        }
		  
		$array = $this->Permission[0];
		if(in_array($atividade, $array)){
			return true;
		} else { 
			return false;
		}
    }
	
	
    private function loadPermission($id = null){

        if($id != null){
            $this->CI->db->select($this->table.'.'.$this->select);
            $this->CI->db->where($this->pk,$id);
            $this->CI->db->limit(1);
            $array = $this->CI->db->get($this->table)->row_array();
            
            if(count($array) > 0){

                $array = unserialize($array[$this->select]);
                //Atribui as permissoes ao atributo permission
                $this->Permission = array($array);
                return true;

                
            }
            else{
                return false;
            }
            
        }
        else{
            return false;
        }

    }
}