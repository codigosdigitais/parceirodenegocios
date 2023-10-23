<?php
	
	# Criando classe para manipular funções de Estrutura
	class MYController {
		
		# Iniciando / Construindo Classe
		public function  __construct() {
			log_message('debug', "Permission Class Initialized");
			$this->CI =& get_instance();
			$this->CI->load->database();
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