<?php
class relatorios_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		if ($tabela == "funcionario" || $tabela == "cedente" || $tabela == "cliente" || $tabela == "contrato")
			$this->db->where('idEmpresa', $idEmpresa);
		
		
		
        $this->db->order_by($cod, $order);

        $result = $this->db->get($tabela);
        //die($this->db->last_query());
        if ($this->db->affected_rows() > 0) {
        	return  $result->result();
        }
        
        return false;
	}
	

	public function getListaCedentesBase($id) {
			
		$tabela = "cedente";
			
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
	
		/*if (is_numeric($id)) {
			$this->db->where('(situacao = 1 OR idCedente = (select idCedente from folhapagamento_parametro where idFolhaParametro = '.$id.') )');
		}
		else {*/
			$this->db->where('situacao', 1);
		//}
	
		$this->db->order_by('razaosocial');
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
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
	


	function getCedente($idEmpresa){
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by('razaosocial', 'DESC');
		return $this->db->get('cedente')->result();	
	}
	
	# Relatório de Clientes - Status
	function listar_clientes_status(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupa Cedentes
		$this->db->select("cedente.razaosocial as cedente, cedente.idCedente, cliente.razaosocial, cliente.cnpj, cliente.email, cliente.codCedente");
		$this->db->join("cedente", "cliente.codCedente=cedente.idCedente", "LEFT");
		
		# Se houver critérios para adicionar a consulta
		if(!empty($_POST['razaosocial_busca'])){ $this->db->like('cliente.razaosocial', $_POST['razaosocial_busca']); } 
		if(!empty($_POST['email_busca'])){ $this->db->where('cliente.email', $_POST['email_busca']); } 
		if(!empty($_POST['cnpj_busca'])){ $this->db->where('cliente.cnpj', $_POST['cnpj_busca']); } 
		if(!empty($_POST['codCedente'])){ $this->db->where('cliente.codCedente', $_POST['codCedente']); } 
		
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$this->db->where('cliente.codCedente !=', '');
		$this->db->group_by('codCedente');
		$consulta = $this->db->get('cliente')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
				$this->db->where('codCedente', $valor->idCedente);
				$this->db->order_by('razaosocial', 'ASC');
				$cliente_retorno = $this->db->get('cliente')->result();
				
					foreach($cliente_retorno as $cliente){
						
						### Retorno de Clientes ATIVOS
						$this->db->select('razaosocial, cnpj, email, data_ativo, situacao, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
						
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '1');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_ativos = $this->db->get('cliente')->result();

						
						### Retorno de Clientes INATIVOS
						$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
							
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '0');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_inativos = $this->db->get('cliente')->result();		
					}
			}

			return $consulta;
	}
	
	# RElatório de Crédito & Débito
	public function listar_creditodebito(){
		
//print_r($_POST);
		# Pesquisa por cliente ou funcionario (idAdministrativo)
		if($this->input->post('metodo')){
			if($this->input->post('metodo')=='1') $metodo = "cliente";
			if($this->input->post('metodo')=='2') $metodo = "funcionario";
			$this->db->where("modulo", $metodo);
		}	

		
		# Pesquisa por Tipo (credito ou debito)
		if($this->input->post('tipo_operacao')){
			if($this->input->post('tipo_operacao')=='812'){
				$this->db->where("adicional.tipoValor", 'C');
			}
			if($this->input->post('tipo_operacao')=='813'){
				$this->db->where("adicional.tipoValor", 'D');
			}			
		}
		
					# Pesquisa por Tipo (credito ou debito)
					if($this->input->post('tipo_operacao')){
						if($this->input->post('tipo_operacao')=='812'){
							$this->db->where("adicional.tipoValor", 'C');
						}
						if($this->input->post('tipo_operacao')=='813'){
							$this->db->where("adicional.tipoValor", 'D');
						}			
					}		
		
		if($this->input->post('idAdministrativo')) $this->db->where("adicional.idAdministrativo", $this->input->post('idAdministrativo'));
		
		$this->db->group_by('modulo');
		$consulta = $this->db->get('adicional')->result();
		
		foreach($consulta as &$valor){

			if($valor->modulo=='funcionario'){
				$this->db->select("adicional.*, funcionario.nome as nome_view");
			} else {
				$this->db->select("adicional.*, cliente.razaosocial as nome_view");	
			}
			
			# Pesquisa por cliente ou funcionario (idAdministrativo)
			$this->db->where("adicional.modulo", $valor->modulo);
			
			# Pesquisa por métodos (cliente ou funcionario)
			if($this->input->post('metodo')){
				if($this->input->post('metodo')=='1'){
					$this->db->where("adicional.modulo", "cliente");
				}
				if($this->input->post('metodo')=='2'){
					$this->db->where("adicional.modulo", "funcionario");
				}			
			}
			
			# Pesquisa por Tipo (credito ou debito)
			if($this->input->post('tipo_operacao')){
				if($this->input->post('tipo_operacao')=='812'){
					$this->db->where("adicional.tipoValor", 'C');
				}
				if($this->input->post('tipo_operacao')=='813'){
					$this->db->where("adicional.tipoValor", 'D');
				}			
			}			
			
			if($valor->modulo=='funcionario'){
				$this->db->join("funcionario", "funcionario.idFuncionario=adicional.idAdministrativo");
			} else {
				$this->db->join("cliente", "cliente.idCliente=adicional.idAdministrativo");				
			}
			if($this->input->post('idAdministrativo')) $this->db->where("adicional.idAdministrativo", $this->input->post('idAdministrativo'));
			$this->db->group_by('adicional.idAdministrativo');

					
			# Pega a listagem
			$valor->listagem = $this->db->get('adicional')->result();
			
				# listagem
				foreach($valor->listagem as &$valor_lista){
					
					
					$this->db->select("adicional.*, parametro.parametro as idParametro");
					
					# Pesquisa por métodos (cliente ou funcionario)
					if($this->input->post('metodo')){
						if($this->input->post('metodo')=='1'){
							$this->db->where("adicional.modulo", "cliente");
						}
						if($this->input->post('metodo')=='2'){
							$this->db->where("adicional.modulo", "funcionario");
						}			
					}
					
					# Pesquisa por Tipo (credito ou debito)
					if($this->input->post('tipo_operacao')){
						if($this->input->post('tipo_operacao')=='812'){
							$this->db->where("adicional.tipoValor", 'C');
						}
						if($this->input->post('tipo_operacao')=='813'){
							$this->db->where("adicional.tipoValor", 'D');
						}			
					}
					if($this->input->post('idAdministrativo')) $this->db->where("adicional.idAdministrativo", $this->input->post('idAdministrativo'));
					$this->db->join("parametro", "parametro.idParametro=adicional.idParametro");
					$this->db->where("modulo", $valor_lista->modulo);
					$this->db->where("idAdministrativo", $valor_lista->idAdministrativo);

					# Pesquisa por Data
					if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ 
						$this->db->where("adicional.data BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); 
					}
					
					$valor_lista->listagem_interna = $this->db->get('adicional')->result();
					
				}
			
		}
		
		
		
		return $consulta;
		
		echo $this->db->last_query();
		
		echo "<pre>";
		print_r($consulta);
		print_r($_POST);
		
		
		echo "Aqui";
		die();
	}
	
	# Relatório de Chamadas
	function listar_chamada(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupando registros por cliente, para exibir depois
		$this->db->select('a.idCliente, b.razaosocial nome_cliente');
		if(!empty($_POST['idCliente'])){ $this->db->where('a.idCliente', $_POST['idCliente']); }
		$this->db->group_by('a.idCliente');
		
		$this->db->join('cliente b', 'a.idCliente = b.idCliente', 'right');
		$this->db->where('b.idEmpresa', $idEmpresa);
		
		$consulta = $this->db->get('chamada a')->result();
		//die($this->db->last_query());
		
		
			foreach($consulta as &$valor){
				$this->db->select('idCliente, idFuncionario, (SELECT nome FROM funcionario WHERE idFuncionario=chamada.idFuncionario) as nome_funcionario');
				$this->db->where('idCliente', $valor->idCliente);
				if(!empty($_POST['idCliente'])){ $this->db->where('idCliente', $_POST['idCliente']); }
				if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("data BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
				$this->db->group_by('idFuncionario');
				$valor->cliente_lista = $this->db->get('chamada')->result();
				
					foreach($valor->cliente_lista as $valor_funcionario){
						$this->db->where('idCliente', $valor_funcionario->idCliente);
						if(!empty($_POST['idCliente'])){ $this->db->where('idCliente', $_POST['idCliente']); }
						if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("data BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
						$this->db->order_by('data', 'DESC');
						$this->db->where('idFuncionario', $valor_funcionario->idFuncionario);
						$valor_funcionario->cliente_lista_funcionario = $this->db->get('chamada')->result();	
					}
			}
		return $consulta;			
	}
	
	# Relatório de Faltas - Geral
	function listar_falta(){
		$idEmpresa = $this->session->userdata['idEmpresa'];

			# Agrupando cadastros de Faltas - By Cedente
			$this->db->select('falta.idCedente, cedente.razaosocial as cedente');
			$this->db->group_by('idCedente');
			if(!empty($_POST['idCedente'])){ $this->db->where('falta.idCedente', $_POST['idCedente']); }
			$this->db->join("cedente", "falta.idCedente=cedente.idCedente", "LEFT");
			
			$this->db->where('cedente.idEmpresa', $idEmpresa);
			
			$consulta = $this->db->get('falta')->result();
			
				# Listagem de funcionários agrupados 
				foreach($consulta as &$valor){
					
					$this->db->select('falta.*, funcionario.nome as nome_funcionario');
					$this->db->group_by('falta.idFuncionario');
					$this->db->join('funcionario', 'funcionario.idFuncionario=falta.idFuncionario', 'LEFT');
					if(!empty($_POST['idFuncionarioLista'])){ $this->db->where('falta.idFuncionario', $_POST['idFuncionarioLista']); }
					if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("falta.data_solicitado BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
					$this->db->where('falta.idCedente', $valor->idCedente);
					$valor->funcionarios = $this->db->get('falta')->result();
					
						# Listagem de Faltas
						foreach($valor->funcionarios as $valor_funcionario){
						
							# Tipos de Faltas
							if(!empty($_POST['idTipo'])){ 
								$tipos_de_faltas = $_POST['idTipo']; 
							} else { 
								$tipos_de_faltas = "896, 897";
							}
							$this->db->select('falta.*, parametro.parametro as idTipo');
							$this->db->where('falta.idCedente', $valor->idCedente);			
							$this->db->where('falta.idFuncionario', $valor_funcionario->idFuncionario);
							$this->db->where_in('falta.idTipo', array($tipos_de_faltas));
							if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("falta.data_solicitado BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
							$this->db->join('parametro', 'parametro.idParametro=falta.idTipo', 'LEFT');
							$valor_funcionario->funcionarios_falta = $this->db->get('falta')->result();


							# Tipos de Atrasos
							if(!empty($_POST['idTipo'])){ 
								$tipos_de_faltas = $_POST['idTipo']; 
							} else { 
								$tipos_de_faltas = "899, 898";
							}
							$this->db->select('falta.*, parametro.parametro as idTipo');
							$this->db->where('falta.idCedente', $valor->idCedente);			
							$this->db->where('falta.idFuncionario', $valor_funcionario->idFuncionario);
							$this->db->where_in('falta.idTipo', array($tipos_de_faltas));
							if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("falta.data_solicitado BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
							$this->db->join('parametro', 'parametro.idParametro=falta.idTipo', 'LEFT');
							$valor_funcionario->funcionarios_atraso = $this->db->get('falta')->result();


							# Tipos Outros
							if(!empty($_POST['idTipo'])){ 
								$tipos_de_faltas = $_POST['idTipo']; 
							} else { 
								$tipos_de_faltas = "939, 305";
							}
							$this->db->select('falta.*, parametro.parametro as idTipo');
							$this->db->where('falta.idCedente', $valor->idCedente);			
							$this->db->where('falta.idFuncionario', $valor_funcionario->idFuncionario);
							$this->db->where_in('falta.idTipo', array($tipos_de_faltas));
							if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("falta.data_solicitado BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
							$this->db->join('parametro', 'parametro.idParametro=falta.idTipo', 'LEFT');
							$valor_funcionario->funcionarios_outros = $this->db->get('falta')->result();

						}
						
				}
								
		return $consulta;		
	}


	# Relatório de Clientes - Status
	function listar_contratos(){

		$idEmpresa = $this->session->userdata['idEmpresa'];
	
		$this->db->select('contrato.idCliente, contrato.idCedente, contrato.idContrato, cedente.razaosocial as cedente');
		$this->db->group_by('idCedente');
		$this->db->join("cedente", "contrato.idCedente=cedente.idCedente", "LEFT");			
		$this->db->where('contrato.idEmpresa', $idEmpresa);			
		$consulta = $this->db->get('contrato')->result();
	
			foreach($consulta as &$valor){
				$this->db->select(
									'c1.*, 
										(SELECT 
											count(*) 
										FROM 
											contrato_funcionario 
										WHERE
											idContrato = c1.idContrato
										) as total_funcionarios'
									);
				$this->db->where('c1.idCedente', $valor->idCedente);
				$valor->contratos = $this->db->get('contrato as c1')->result();
			}
		return $consulta;
	}
	
	# Substituicoes
	function listar_substituicoes(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Listar todos os clientes que tem substituição
		$this->db->select('substituicao.idCliente, cliente.razaosocial');
		$this->db->group_by('substituicao.idCliente');
		if(!empty($_POST['idCliente'])){ $this->db->where('cliente.idCliente', $_POST['idCliente']); } 
		if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("substituicao.data BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
		$this->db->join('cliente', 'cliente.idCliente=substituicao.idCliente');
		$this->db->order_by('cliente.razaosocial', 'ASC');
		
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$consulta = $this->db->get('substituicao')->result();
		
			# Listar todas as substituicoes deste cliente
			foreach($consulta as &$valor){
				$this->db->select('substituicao.*, funcionario.nome as nome_funcionario_faltou, F2.nome as nome_funcionario_substituiu');
				$this->db->where('substituicao.idCliente', $valor->idCliente);
				if(!empty($_POST['data_inicial']) and !empty($_POST['data_final'])){ $this->db->where("substituicao.data BETWEEN '".$_POST['data_inicial']."' AND '".$_POST['data_final']."'"); }
				$this->db->join('funcionario', 'funcionario.idFuncionario=substituicao.idFuncionario');
				$this->db->join('funcionario AS F2', 'F2.idFuncionario=substituicao.idFuncionarioSubstituto');
				$valor->substituicao_cliente = $this->db->get('substituicao')->result();
			}
		
		return $consulta;
	}


	# Relatório de Clientes - Dados da Empresa
	function listar_clientes_dados_empresa(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupa Cedentes
		$this->db->select("cedente.razaosocial as cedente, cedente.idCedente, cliente.razaosocial, cliente.cnpj, cliente.email, cliente.codCedente");
		$this->db->join("cedente", "cliente.codCedente=cedente.idCedente", "LEFT");
		
		# Se houver critérios para adicionar a consulta
		if(!empty($_POST['razaosocial_busca'])){ $this->db->like('cliente.razaosocial', $_POST['razaosocial_busca']); } 
		if(!empty($_POST['email_busca'])){ $this->db->where('cliente.email', $_POST['email_busca']); } 
		if(!empty($_POST['cnpj_busca'])){ $this->db->where('cliente.cnpj', $_POST['cnpj_busca']); } 
		if(!empty($_POST['codCedente'])){ $this->db->where('cliente.codCedente', $_POST['codCedente']); } 
			
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$this->db->where('cliente.codCedente !=', '');
		$this->db->group_by('codCedente');
		$consulta = $this->db->get('cliente')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
				$this->db->where('codCedente', $valor->idCedente);
				$this->db->order_by('razaosocial', 'ASC');
				$cliente_retorno = $this->db->get('cliente')->result();
				
					foreach($cliente_retorno as $cliente){
						
						### Retorno de Clientes ATIVOS
						$this->db->select('razaosocial, cnpj, ie, im, endereco, endereco_numero, endereco_cep, endereco_bairro, endereco_cidade, (SELECT estado FROM estados WHERE idEstado = endereco_estado) as endereco_estado, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
						
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '1');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_ativos = $this->db->get('cliente')->result();

						
						### Retorno de Clientes INATIVOS
						$this->db->select('razaosocial, cnpj, ie, im, endereco, endereco_numero, endereco_cep, endereco_bairro, endereco_cidade, (SELECT estado FROM estados WHERE idEstado = endereco_estado) as endereco_estado, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
							
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '0');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_inativos = $this->db->get('cliente')->result();		
					}
			}
			
			return $consulta;
	}


	# Relatório de Clientes - Dados de Faturamento
	function listar_clientes_dados_faturamento(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupa Cedentes
		$this->db->select("cedente.razaosocial as cedente, cedente.idCedente, cliente.razaosocial, cliente.cnpj, cliente.email, cliente.codCedente");
		$this->db->join("cedente", "cliente.codCedente=cedente.idCedente", "LEFT");
		
		# Se houver critérios para adicionar a consulta
		if(!empty($_POST['razaosocial_busca'])){ $this->db->like('cliente.razaosocial', $_POST['razaosocial_busca']); } 
		if(!empty($_POST['email_busca'])){ $this->db->where('cliente.email', $_POST['email_busca']); } 
		if(!empty($_POST['cnpj_busca'])){ $this->db->where('cliente.cnpj', $_POST['cnpj_busca']); } 
		if(!empty($_POST['codCedente'])){ $this->db->where('cliente.codCedente', $_POST['codCedente']); } 
		
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$this->db->where('cliente.codCedente !=', '');
		$this->db->group_by('codCedente');
		$consulta = $this->db->get('cliente')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
				$this->db->where('codCedente', $valor->idCedente);
				$this->db->order_by('razaosocial', 'ASC');
				$cliente_retorno = $this->db->get('cliente')->result();
				
					foreach($cliente_retorno as $cliente){
						
						### Retorno de Clientes ATIVOS
						$this->db->select('razaosocial, cnpj, ie, im, fat_endereco, fat_endereco_numero, fat_endereco_cep, fat_endereco_bairro, fat_endereco_cidade, (SELECT estado FROM estados WHERE idEstado = fat_endereco_estado) as fat_endereco_estado, idCliente, vencimento, (SELECT parametro FROM parametro WHERE idParametro = forma_de_pagamento) as forma_de_pagamento, (SELECT parametro FROM parametro WHERE idParametro = nota) as nota, fechamento_de, fechamento_a, guias');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
						
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '1');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_ativos = $this->db->get('cliente')->result();

						
						### Retorno de Clientes INATIVOS
						$this->db->select('razaosocial, cnpj, ie, im, fat_endereco, fat_endereco_numero, fat_endereco_cep, fat_endereco_bairro, fat_endereco_cidade, (SELECT estado FROM estados WHERE idEstado = fat_endereco_estado) as fat_endereco_estado, idCliente, vencimento, (SELECT parametro FROM parametro WHERE idParametro = forma_de_pagamento) as forma_de_pagamento, (SELECT parametro FROM parametro WHERE idParametro = nota) as nota, fechamento_de, fechamento_a, guias');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
							
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '0');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_inativos = $this->db->get('cliente')->result();		
					}
			}
			
			return $consulta;
	}



	# Relatório de Clientes - Dados dos Responsaveis por setor
	function listar_clientes_responsaveis(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupa Cedentes
		$this->db->select("cedente.razaosocial as cedente, cedente.idCedente, cliente.razaosocial, cliente.cnpj, cliente.email, cliente.codCedente");
		$this->db->join("cedente", "cliente.codCedente=cedente.idCedente", "LEFT");
		
		# Se houver critérios para adicionar a consulta
		if(!empty($_POST['razaosocial_busca'])){ $this->db->like('cliente.razaosocial', $_POST['razaosocial_busca']); } 
		if(!empty($_POST['email_busca'])){ $this->db->where('cliente.email', $_POST['email_busca']); } 
		if(!empty($_POST['cnpj_busca'])){ $this->db->where('cliente.cnpj', $_POST['cnpj_busca']); } 
		if(!empty($_POST['codCedente'])){ $this->db->where('cliente.codCedente', $_POST['codCedente']); } 
			
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$this->db->where('cliente.codCedente !=', '');
		$this->db->group_by('codCedente');
		$consulta = $this->db->get('cliente')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
				$this->db->where('codCedente', $valor->idCedente);
				$this->db->order_by('razaosocial', 'ASC');
				$cliente_retorno = $this->db->get('cliente')->result();
				
					foreach($cliente_retorno as $cliente){
						
						
						### Retorno de Clientes ATIVOS
						$this->db->select('razaosocial, cnpj, email, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
						
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '1');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_ativos = $this->db->get('cliente')->result();
						
							foreach($valor->clientes_ativos as &$responsaveis_ativos){
								$this->db->select("nome, telefoneddd, telefone, telefoneddd2, telefone2, email, (SELECT parametro FROM parametro WHERE idParametro = setor) as setor, idCliente");
								$this->db->where('idCliente', $responsaveis_ativos->idCliente);
								$this->db->order_by('nome', 'ASC');
								$responsaveis_ativos->responsaveis_ativo = $this->db->get('cliente_responsaveis')->result();
							}
						
						
						### Retorno de Clientes INATIVOS
						$this->db->select('razaosocial, cnpj, email, idCliente');
						
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
							
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '0');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_inativos = $this->db->get('cliente')->result();	
						
							foreach($valor->clientes_inativos as &$responsaveis_inativos){
								$this->db->select("nome, telefoneddd, telefone, telefoneddd2, telefone2, email, (SELECT parametro FROM parametro WHERE idParametro = setor) as setor, idCliente");
								$this->db->where('idCliente', $responsaveis_inativos->idCliente);
								$this->db->order_by('nome', 'ASC');
								$responsaveis_inativos->responsaveis_inativo = $this->db->get('cliente_responsaveis')->result();
							}
							
							
						
					}
			}
		
			return $consulta;
	}

	# Relatório de Clientes - Dados de Frete
	function listar_clientes_frete(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		# Agrupa Cedentes
		$this->db->select("cedente.razaosocial as cedente, cedente.idCedente, cliente.razaosocial, cliente.cnpj, cliente.email, cliente.codCedente");
		$this->db->join("cedente", "cliente.codCedente=cedente.idCedente", "LEFT");
		
		# Se houver critérios para adicionar a consulta
		if(!empty($_POST['razaosocial_busca'])){ $this->db->like('cliente.razaosocial', $_POST['razaosocial_busca']); } 
		if(!empty($_POST['email_busca'])){ $this->db->where('cliente.email', $_POST['email_busca']); } 
		if(!empty($_POST['cnpj_busca'])){ $this->db->where('cliente.cnpj', $_POST['cnpj_busca']); } 
		if(!empty($_POST['codCedente'])){ $this->db->where('cliente.codCedente', $_POST['codCedente']); } 
			
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		$this->db->where('cliente.codCedente !=', '');
		$this->db->group_by('codCedente');
		$consulta = $this->db->get('cliente')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('razaosocial, cnpj, data_ativo, situacao, idCliente');
				$this->db->where('codCedente', $valor->idCedente);
				$this->db->order_by('razaosocial', 'ASC');
				$cliente_retorno = $this->db->get('cliente')->result();
				
					foreach($cliente_retorno as $cliente){
						
						
						### Retorno de Clientes ATIVOS
						$this->db->select('razaosocial, cnpj, email, cliente.idCliente, valor_moto_normal, valor_moto_metropolitano, valor_moto_depois_18, valor_moto_km, valor_carro_normal, valor_carro_metropolitano, valor_carro_depois_18, valor_carro_km, valor_van_normal, valor_van_metropolitano, valor_van_depois_18, valor_van_km, valor_caminhao_normal, valor_caminhao_metropolitano, valor_caminhao_depois_18, valor_caminhao_km, valor_moto_metropolitano_apos18, valor_carro_metropolitano_apos18, valor_van_metropolitano_apos18, valor_caminhao_metropolitano_apos18');
						$this->db->join("cliente_frete", "cliente_frete.idClienteFrete = getIdClienteFreteVigente(cliente.idCliente)", "LEFT");
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
						
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '1');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_ativos = $this->db->get('cliente')->result();
						
						
						### Retorno de Clientes INATIVOS
						$this->db->select('razaosocial, cnpj, email, cliente.idCliente, valor_moto_normal, valor_moto_metropolitano, valor_moto_depois_18, valor_moto_km, valor_carro_normal, valor_carro_metropolitano, valor_carro_depois_18, valor_carro_km, valor_van_normal, valor_van_metropolitano, valor_van_depois_18, valor_van_km, valor_caminhao_normal, valor_caminhao_metropolitano, valor_caminhao_depois_18, valor_caminhao_km, valor_moto_metropolitano_apos18, valor_carro_metropolitano_apos18, valor_van_metropolitano_apos18, valor_caminhao_metropolitano_apos18');
						$this->db->join("cliente_frete", "cliente_frete.idClienteFrete = getIdClienteFreteVigente(cliente.idCliente)", "LEFT");
						# Se houver critérios para adicionar a consulta
						if(!empty($_POST['razaosocial_busca'])){ $this->db->like('razaosocial', $_POST['razaosocial_busca']); } 
						if(!empty($_POST['email_busca'])){ $this->db->where('email', $_POST['email_busca']); } 
						if(!empty($_POST['cnpj_busca'])){ $this->db->where('cnpj', $_POST['cnpj_busca']); } 
						if(!empty($_POST['codCedente'])){ $this->db->where('codCedente', $_POST['codCedente']); }
							
						$this->db->where('codCedente', $valor->idCedente);
						$this->db->where('situacao', '0');
						$this->db->order_by('razaosocial', 'ASC');
						$valor->clientes_inativos = $this->db->get('cliente')->result();	
							
							
						
					}
			}
		
			return $consulta;
	}

	# Listagem de Clientes que estão no Contrato
	public function getClienteContrato(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select('contrato.*, cliente.razaosocial, cliente.idCliente');
		$this->db->join("cliente", "cliente.idCliente=contrato.idCliente", "LEFT");
		
		$this->db->where('contrato.idEmpresa', $idEmpresa);
		
		$consulta = $this->db->get('contrato')->result();
		return $consulta;
	}

}
?>