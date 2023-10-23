<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission{

	/*
	| Para facilitar a utilização as permissões se baseiam no controller utilizado em sis_unidades
	| que por sua vez é unico na base
	 */
    var $controller;
    /*
    | quando alterado controller manualmente utilizando: controllerManual
    | sistema redefine para o padrão após verificar a permissão
     */
    var $controller_default;
    
    /* Perfil atual do usúario (1o param da URL) */
    var $idPerfil   = "";
    var $nomePerfil = "";
    var $nomeFuncao = "";
    
    
    /* Nome das permissões */
    const CAN_SELECT = 'canSelect';
    const CAN_INSERT = 'canInsert';
    const CAN_UPDATE = 'canUpdate';
    const CAN_DELETE = 'canDelete';
    
    

    public function  __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
	
    /**
     * @param string $controller
     * 
     * Para facilitar o uso é definido o controller padrão ao construir o controller
     * assim é possível utilizar nos controllers a sintaxe:
     *//* 
     	| $this->permission->canSelect()	//TRUE se usuário pode Visualizar
     	| $this->permission->canInsert()	//TRUE se usuário pode Inserir
     	| $this->permission->canUpdate()	//TRUE se usuário pode Atualizar
     	| $this->permission->canDelete		//TRUE se usuário pode Remover
     *//**
     *	para verificar se o usuário tem permissão a cada operação no controller atual
     */
    public function setController($controller) {
    	$this->controller 		  = $controller;
    	$this->controller_default = $controller;

    	$permissoes = $this->CI->session->userdata('permissoes');
    	
		if ($permissoes)
	    	foreach ($permissoes as $p) {
	    		if ($this->controller == $p->controller) {
	    			$this->nomeFuncao = $p->nomeFuncao;
	    			break;
	    		}
	    	}
    }
    
    public function setIdPerfil($idPerfil) {
    	$this->idPerfil 		  = $idPerfil;
    	
    	$permissoes = $this->CI->session->userdata('permissoes');
    	
    	foreach ($permissoes as $p) {
    		if ($this->idPerfil == $p->idPerfil) {
    			$this->nomePerfil = $p->nomePerfil;
    			break;
    		}
    	}
    }

    /**
     * PERMISSÃO PARA VISUALIZAR
     */
    public function canSelect() {
    	$retorno = false;
    	 
    	$retorno = $this->checkPermission(self::CAN_SELECT);
    	 
    	//Redefine o controller para o padrão, caso tenha sido alterado por: controllerManual
    	$this->controller = $this->controller_default;
    	 
    	return $retorno;
    }

    /**
     * PERMISSÃO PARA INSERIR
     */
    public function canInsert() {
    	$retorno = false;
    	 
    	$retorno = $this->checkPermission(self::CAN_INSERT);
    	 
    	//Redefine o controller para o padrão, caso tenha sido alterado por: controllerManual
    	$this->controller = $this->controller_default;
    	 
    	return $retorno;
    }

    /**
     * PERMISSÃO PARA ATUALIZAR
     */
    public function canUpdate() {
    	$retorno = false;
    	
    	$retorno = $this->checkPermission(self::CAN_UPDATE);
    	 
    	//Redefine o controller para o padrão, caso tenha sido alterado por: controllerManual
    	$this->controller = $this->controller_default;
    	 
    	return $retorno;
    }
    
    /**
     * PERMISSÃO PARA REMOVER
     */
    public function canDelete() {
    	$retorno = false;
    	
    	$retorno = $this->checkPermission(self::CAN_DELETE);
    	
    	//Redefine o controller para o padrão, caso tenha sido alterado por: controllerManual
    	$this->controller = $this->controller_default;
    	
    	return $retorno;
    }
    
    /**
     * RETORNA PERFIL ATUAL
     */
    public function getIdPerfilAtual() {
    	return $this->idPerfil;
    }
    public function getNomePerfilAtual() {
    	return $this->nomePerfil;
    }
    public function getNomeFuncaoAtual() {
    	return $this->nomeFuncao;
    }
    
    /**
     * Utilizado internamente para verificar permissão pelo nome
     * @param self $nomePermissao
     */
    private function checkPermission($nomePermissao) {

    	$permissoes = $this->CI->session->userdata('permissoes');
    	
    	if ($permissoes) {
	    	foreach ($permissoes as $p) {
	    	
	    		if ($this->idPerfil == $p->idPerfil) {
	    			if ($this->controller == $p->controller) {
	    				/*
	    				if ($this->controller == 'clientes') {
	    					echo $this->idPerfil . "<br>";
	    					var_dump($p); die();
	    				}
	    				*/
	    				return $p->$nomePermissao;
	    			}
	    		}
	    	}
    	}
    	else {
    		redirect(base_url());
    	}
    	
    	return false;
    }

    /**
     * Verifica se usuário pode acessar função pelo tipo da função
     * tipos de usuário x função: *//*
     | SISAdmin - usuários administradores do sistema
     | Interno  - usuários normais, do cliente (parceiro de negócios)
     | Externo  - usuários externos (clientes do cliente /parceiro de negócios
     */
    public function userCanAccesFunctionByType($controller) {
    		
	    	$permissoes = $this->CI->session->userdata('permissoes');
	    	
		    if ($permissoes) {
		    
		    	foreach ($permissoes as $p) {
		   			if ($p->controller == $controller) {

		   				$retorno = $p->tipo == $this->CI->session->userdata('tipo')
		   						|| $this->CI->session->userdata('tipo') == 'SISAdmin'
		   						|| $this->CI->session->userdata('tipo') == 'Interno';
		   				
		   				/*
		   				if ($this->controller == 'clientes') {
			   				var_dump($p);
			   				echo "<hr>";
			   				echo '$p->tipo: ' . $p->tipo;
			   				echo "<br>";
			   				echo '$this->CI->session->userdata(tipo): ' . $this->CI->session->userdata('tipo');
			   				echo "<br>";
			   				echo ($retorno) ? "true" : "false";
			   				die('<hr>');
		   				}*/
		   				
		   				return $retorno;
		   			}
		    	}
	    	}
    		//die('<hr>2');
    		return true;
    }
    
    /**
     * DEFINE CONTROLLER DIFERENTE DO PADRÃO
     *//*
    | Utilizado quando necessita verificar permissão de um controller diferente do atual
    | ou quando o controller possui formato: controller/metodo
    |
    | utiliza-se então: $this->permission->controllerManual('controller/metodo')->canSelect()
    */
    public function controllerManual($controller) {
    	$this->controller = $controller;
    	return $this;
    }
    
    /**
     * Utilizado ao realizar login para que sistema crie as permissões na sessão
     */
    public function autoSetSessionPermissions($idUsuario) {
    	$data = $this->CI->permission_model->getPermissoesUsuario($idUsuario);		
    	$this->CI->session->set_userdata('permissoes', $data);    	
    	return true;
    }

    /**
     * Utilizado por SISAdmin para simular acesso via empresa/parceiro/cliente
     */
    public function autoSetSessionPermissionsSimulacao($idPerfil) {
    	$data = $this->CI->permission_model->getPermissoesPerfilSimulacao($idPerfil);    
    	$this->CI->session->set_userdata('permissoes', $data);    	
    	$data = array_shift($data);
    	
    	$this->CI->session->set_userdata('idPerfilSimular', $data->idPerfil);
    	$this->CI->session->set_userdata('nomePerfilSimular', $data->nomePerfil);

    	return true;
    }
}