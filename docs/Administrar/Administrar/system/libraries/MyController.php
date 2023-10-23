<?php
	
	# Criando classe para manipular funções de Estrutura
	class MYController extends CI_Controller {
		
		# Iniciando / Construindo Classe
		public function  __construct() {
			parent::__construct ();
			$this->load->config('mycontroller');
			$this->load->library('MyControllerLibrary');
	
		}		
		
		# Função para busca dos módulos em ação
		public function getModulosCategoria(){
			$sql = "SELECT * FROM modulos WHERE idModuloBase = '0'";
			$consulta = $this->db->query($sql)->result();	
			
				foreach($consulta as &$valor){
					$sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}'";
					$valor->subModulo = $this->db->query($sql_model)->result();		
				}
			
			return $consulta;
		}
	
	
	}

?>