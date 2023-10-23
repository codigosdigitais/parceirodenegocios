<?php
# FECHAMENTO EXTENDS CONTROLLER #
class financeiro extends MY_Controller {
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('financeiro_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	# gerencia a pagina principal #
	function gerenciar(){

        if(!$this->permission->controllerManual('financeiro/chamada')->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar financeiro.');
           redirect(base_url());
        }
       	$this->data['view'] = 'financeiro/financeiro';
       	$this->load->view('tema/topo',$this->data);
    }
	
	# gerencia funcionario
	function funcionario(){
		$this->setControllerMenu($this->router->class.'/funcionario');
		
		if(!$this->permission->controllerManual('financeiro/funcionario')->canInsert()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar Funcionários.');
			redirect(base_url());
		}
		
		$this->data['listaFuncionario'] = $this->financeiro_model->getBase('funcionario', 'nome', 'ASC');
       	$this->data['view'] = 'financeiro/view/funcionario';
       	$this->load->view('tema/topo',$this->data);		
	}
	
	# gerencia folhadepagamento
	function folhadepagamento($metodo=NULL, $acao=NULL, $formulario=NULL){
		$this->setControllerMenu($this->router->class.'/folhadepagamento');
		
		/*if(!$this->permission->controllerManual('financeiro/folhadepagamento')->canInsert()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar Folha de Pagamento.');
			redirect(base_url());
		}
		*/
		if($metodo=='adicionar' and $acao==NULL){
			
			$this->data['lista_adicionais_desconto'] = $this->financeiro_model->getTiposDescontosAdicionais();
			$this->data['lista_adicionais_provento'] = $this->financeiro_model->getTiposProventosAdicionais();
			$this->data['lista_provento'] = $this->financeiro_model->getTiposProventos();
			$this->data['lista_cedente'] = $this->financeiro_model->getListaCedentesBase(null);
			$this->data['lista_atividade'] = $this->financeiro_model->getTiposAtividade();
			$this->data['view'] = 'financeiro/view/folhadepagamento';
			$this->load->view('tema/topo',$this->data);	
			
		} elseif($metodo=='adicionar' and $acao=='adicionando'){
			
			# Criando um novo Parâmetro Global #
			$dados_global['idCedente'] = $this->input->post('idCedente');
			$dados_global['idParametro'] = $this->input->post('idParametro');
			$dados_global['salario'] = $this->input->post('salario');
			$id_global = $this->financeiro_model->add('folhapagamento_parametro', $dados_global);
			
			if ($id_global) {
				$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_parametro', 'idFolhaPagamento', $id_global, 'Folha Pagamento: Parâmetro global' );
			}


			# Parametrizando INSS #
				# Iniciando loop
					for($i=1; $i<=count($_POST['inss']); $i++){
						$dados_inss[$i]['idFolhaParametro'] = $id_global;
						$dados_inss[$i]['valor_min'] = $_POST['inss'][$i]['valor_min'];
						$dados_inss[$i]['valor_max'] = $_POST['inss'][$i]['valor_max'];
						$dados_inss[$i]['faixa'] = $_POST['inss'][$i]['faixa'];
						$dados_inss[$i]['categoria'] = "inss";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_inss);
					
					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros INSS' );
					}
			
			# Parametrizando IRR #
				# Iniciando loop
					for($i=1; $i<=count($_POST['irr']); $i++){
						$dados_irr[$i]['idFolhaParametro'] = $id_global;
						$dados_irr[$i]['valor_min'] = $_POST['irr'][$i]['valor_min'];
						$dados_irr[$i]['valor_max'] = $_POST['irr'][$i]['valor_max'];
						$dados_irr[$i]['faixa'] = $_POST['irr'][$i]['faixa'];
						$dados_irr[$i]['categoria'] = "irr";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_irr);
					
					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros IRR' );
					}
					
			# Parametrizando FAMILIA #
				# Iniciando loop
					for($i=1; $i<=count($_POST['familia']); $i++){
						$dados_familia[$i]['idFolhaParametro'] = $id_global;
						$dados_familia[$i]['valor_min'] = $_POST['familia'][$i]['valor_min'];
						$dados_familia[$i]['valor_max'] = $_POST['familia'][$i]['valor_max'];
						$dados_familia[$i]['faixa'] = $_POST['familia'][$i]['faixa'];
						$dados_familia[$i]['categoria'] = "familia";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_familia);
					
					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros Família' );
					}
					
			# Parametrizando INSALUBRIDADE #
				# Iniciando loop
					for($i=1; $i<=count($_POST['insalubridade']); $i++){
						$dados_insalubridade[$i]['idFolhaParametro'] = $id_global;
						$dados_insalubridade[$i]['valor_min'] = $_POST['insalubridade'][$i]['valor_min'];
						$dados_insalubridade[$i]['faixa'] = $_POST['insalubridade'][$i]['faixa'];
						$dados_insalubridade[$i]['categoria'] = "insalubridade";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_insalubridade);

					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros Insalubridade' );
					}
						
					
			# Parametrizando Adicionais de Descontos
				$descontoPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="desconto"){
						$descontoPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$descontoArr = array();
				for($i=0;$i<count($descontoPost['tipo']);$i++){
					foreach($descontoPost as $key=>$val){
						$descontoArr[$i][$key] = $descontoPost[$key][$i];
						$descontoArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_desconto', $descontoArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_desconto', 'idFolhaDesconto', json_encode($ids), 'Folha Pagamento: Parâmetros Adicionais de Desconto' );
				}
					
			# Parametrizando Adicionais de Proventos
				$proventoPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="provento"){
						$proventoPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$proventoArr = array();
				for($i=0;$i<count($proventoPost['tipo']);$i++){
					foreach($proventoPost as $key=>$val){
						$proventoArr[$i][$key] = $proventoPost[$key][$i];
						$proventoArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_provento', $proventoArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_provento', 'idFolhaProvento', json_encode($ids), 'Folha Pagamento: Parâmetros Adicionais de Proventos' );
				}
					
			# Parametrizando Faltas Justificadas
				$faltaPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="faltajust"){
						$faltaPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$faltaArr = array();
				for($i=0;$i<count($faltaPost['tipo']);$i++){
					foreach($faltaPost as $key=>$val){
						$faltaArr[$i][$key] = $faltaPost[$key][$i];
						$faltaArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_faltajust', $faltaArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_faltajust', 'idFaltaJust', json_encode($ids), 'Folha Pagamento: Parâmetros Faltas Justificadas' );
				}
					
			# Parametrizando Faltas Injustificadas
				$faltainjustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="faltainjust"){
						$faltainjustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$faltainjustArr = array();
				for($i=0;$i<count($faltainjustPost['tipo']);$i++){
					foreach($faltainjustPost as $key=>$val){
						$faltainjustArr[$i][$key] = $faltainjustPost[$key][$i];
						$faltainjustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_faltainjust', $faltainjustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_faltainjust', 'idFaltainJust', json_encode($ids), 'Folha Pagamento: Parâmetros Faltas Injustificadas' );
				}
					
			# Parametrizando Atrasos Justificados
				$atrasojustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="atrasojust"){
						$atrasojustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$atrasojustArr = array();
				for($i=0;$i<count($atrasojustPost['tipo']);$i++){
					foreach($atrasojustPost as $key=>$val){
						$atrasojustArr[$i][$key] = $atrasojustPost[$key][$i];
						$atrasojustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_atrasojust', $atrasojustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_atrasojust', 'idAtrasoJust', json_encode($ids), 'Folha Pagamento: Parâmetros Atrasos Justificados' );
				}
					
			# Parametrizando Atrasos Injustificados
				$atrasoinjustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="atrasoinjust"){
						$atrasoinjustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$atrasoinjustArr = array();
				for($i=0;$i<count($atrasoinjustPost['tipo']);$i++){
					foreach($atrasoinjustPost as $key=>$val){
						$atrasoinjustArr[$i][$key] = $atrasoinjustPost[$key][$i];
						$atrasoinjustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_atrasoinjust', $atrasoinjustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_atrasoinjust', 'idAtrasoinJust', json_encode($ids), 'Folha Pagamento: Parâmetros Atrasos Injustificados' );
				}
					
			
				if($id_global!= NULL){
				   $this->session->set_flashdata('sucess','Parâmetro configurado com sucesso!');
				   redirect(base_url() . $this->permission->getIdPerfilAtual().'/financeiro/folhadepagamento');
				}

			
		}
		
		if($metodo==NULL and $acao==NULL){
			$this->data['results'] = $this->financeiro_model->getParametrosGlobais();
			$this->data['lista_adicionais_desconto'] = $this->financeiro_model->getTiposDescontosAdicionais();
			$this->data['lista_adicionais_provento'] = $this->financeiro_model->getTiposProventosAdicionais();
			$this->data['lista_provento'] = $this->financeiro_model->getTiposProventos();
			$this->data['lista_cedente'] = $this->financeiro_model->getListaCedentesBase(null);;
			$this->data['lista_atividade'] = $this->financeiro_model->getTiposAtividade();	
		
			$this->data['view'] = 'financeiro/view/folhadepagamentoLista';
			$this->load->view('tema/topo',$this->data);			
		}
		
		if($metodo=="editar" and $acao==TRUE){
			$this->data['results'] = $this->financeiro_model->getParametrosGlobaisByID($this->uri->segment(4));
			$this->data['lista_adicionais_desconto'] = $this->financeiro_model->getTiposDescontosAdicionais();
			$this->data['lista_adicionais_provento'] = $this->financeiro_model->getTiposProventosAdicionais();
			$this->data['lista_provento'] = $this->financeiro_model->getTiposProventos();
			$this->data['lista_cedente'] = $this->financeiro_model->getListaCedentesBase($this->uri->segment(4));
			$this->data['lista_atividade'] = $this->financeiro_model->getTiposAtividade();
			
			$this->data['view'] = 'financeiro/view/folhadepagamento';
			$this->load->view('tema/topo',$this->data);		
		}
		
		if($metodo=='editar' and $acao==TRUE and $formulario=='editando'){
		

			
			# Faz o update do Parâmetro Base
			$dados_global['idCedente'] = $this->input->post('idCedente');
			$dados_global['idParametro'] = $this->input->post('idParametro');
			$dados_global['salario'] = $this->input->post('salario');
			
			$this->logs_modelclass->registrar_log_antes_update ( 'folhapagamento_parametro', 'idFolhaParametro', $acao, 'Folha Pagamento: Parâmetro global' );
			
			if ($this->financeiro_model->edit('folhapagamento_parametro', $dados_global, 'idFolhaParametro', $acao)) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$id_global = $acao;

			# Remove todos os outros parametros
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_atrasoinjust', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Atrasos Injustificados (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_atrasoinjust', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_atrasojust', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Atrasos Justificados (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_atrasojust', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_desconto', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Adicionais de Descontos (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_desconto', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_faltainjust', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Faltas Injustificadas (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_faltainjust', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_faltajust', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Faltas Justificadas (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_faltajust', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_provento', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros Adicionais de Proventos (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_provento', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_storages', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros INSS/ISS/Família/Insalubridade (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_storages', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'folhapagamento_inss', 'idFolhaParametro', $id_global, 'Financeiro: Parâmetros INSS (on edit)' );
			if ($this->financeiro_model->limpa_dados_anteriores($id_global, 'folhapagamento_inss', 'idFolhaParametro')) {
				$this->logs_modelclass->registrar_log_depois ();
			}			
			
			# Adiciona todos eles novamente para atualizar
			# Parametrizando INSS #
				# Iniciando loop
					for($i=1; $i<=count($_POST['inss']); $i++){
						$dados_inss[$i]['idFolhaParametro'] = $id_global;
						$dados_inss[$i]['valor_min'] = $_POST['inss'][$i]['valor_min'];
						$dados_inss[$i]['valor_max'] = $_POST['inss'][$i]['valor_max'];
						$dados_inss[$i]['faixa'] = $_POST['inss'][$i]['faixa'];
						$dados_inss[$i]['categoria'] = "inss";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_inss);

					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros INSS (on editção)' );
					}
						
			# Parametrizando IRR #
				# Iniciando loop
					for($i=1; $i<=count($_POST['irr']); $i++){
						$dados_irr[$i]['idFolhaParametro'] = $id_global;
						$dados_irr[$i]['valor_min'] = $_POST['irr'][$i]['valor_min'];
						$dados_irr[$i]['valor_max'] = $_POST['irr'][$i]['valor_max'];
						$dados_irr[$i]['faixa'] = $_POST['irr'][$i]['faixa'];
						$dados_irr[$i]['categoria'] = "irr";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_irr);

					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros IRR (on edit)' );
					}
						
			# Parametrizando FAMILIA #
				# Iniciando loop
					for($i=1; $i<=count($_POST['familia']); $i++){
						$dados_familia[$i]['idFolhaParametro'] = $id_global;
						$dados_familia[$i]['valor_min'] = $_POST['familia'][$i]['valor_min'];
						$dados_familia[$i]['valor_max'] = $_POST['familia'][$i]['valor_max'];
						$dados_familia[$i]['faixa'] = $_POST['familia'][$i]['faixa'];
						$dados_familia[$i]['categoria'] = "familia";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_familia);

					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros Família (on edit)' );
					}
						
			# Parametrizando INSALUBRIDADE #
				# Iniciando loop
					for($i=1; $i<=count($_POST['insalubridade']); $i++){
						$dados_insalubridade[$i]['idFolhaParametro'] = $id_global;
						$dados_insalubridade[$i]['valor_min'] = $_POST['insalubridade'][$i]['valor_min'];
						$dados_insalubridade[$i]['faixa'] = $_POST['insalubridade'][$i]['faixa'];
						$dados_insalubridade[$i]['categoria'] = "insalubridade";
					} # Fechando Loop
					
					# Inserindo Registro
					$ids = $this->financeiro_model->add_batch('folhapagamento_storages', $dados_insalubridade);

					if ($ids) {
						$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_storages', 'idFolhaStorage', json_encode($ids), 'Folha Pagamento: Parâmetros Insalubridade (on edit)' );
					}
						
						
			# Modificado em 15 de Abril de 2016, incluido a partir daqui:
			# Parametrizando Adicionais de Descontos
				$inssPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="faixainss"){
						$inssPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$inssArr = array();
				for($i=0;$i<count($inssPost['formato']);$i++){
					foreach($inssPost as $key=>$val){
						$inssArr[$i][$key] = $inssPost[$key][$i];
						$inssArr[$i]['idFolhaParametro'] = $id_global;
					}
				}

				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_inss', $inssArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_inss', 'idFolhaInss', json_encode($ids), 'Folha Pagamento: Parâmetros de INSS (on edit)' );
				}

				


				# Fecha modificação de inclusão
					
			# Parametrizando Adicionais de Descontos
				$descontoPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="desconto"){
						$descontoPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$descontoArr = array();
				for($i=0;$i<count($descontoPost['tipo']);$i++){
					foreach($descontoPost as $key=>$val){
						$descontoArr[$i][$key] = $descontoPost[$key][$i];
						$descontoArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_desconto', $descontoArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_desconto', 'idFolhaDesconto', json_encode($ids), 'Folha Pagamento: Parâmetros Adicionais de Descontos (on edit)' );
				}
					
			# Parametrizando Adicionais de Proventos
				$proventoPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="provento"){
						$proventoPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$proventoArr = array();
				for($i=0;$i<count($proventoPost['tipo']);$i++){
					foreach($proventoPost as $key=>$val){
						$proventoArr[$i][$key] = $proventoPost[$key][$i];
						$proventoArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_provento', $proventoArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_provento', 'idFolhaProvento', json_encode($ids), 'Folha Pagamento: Parâmetros Adicionais de Proventos (on edit)' );
				}
					
			# Parametrizando Faltas Justificadas
				$faltaPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="faltajust"){
						$faltaPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$faltaArr = array();
				for($i=0;$i<count($faltaPost['tipo']);$i++){
					foreach($faltaPost as $key=>$val){
						$faltaArr[$i][$key] = $faltaPost[$key][$i];
						$faltaArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_faltajust', $faltaArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_faltajust', 'idFaltaJust', json_encode($ids), 'Folha Pagamento: Parâmetros Faltas Justificadas (on edit)' );
				}
					
			# Parametrizando Faltas Injustificadas
				$faltainjustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="faltainjust"){
						$faltainjustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$faltainjustArr = array();
				for($i=0;$i<count($faltainjustPost['tipo']);$i++){
					foreach($faltainjustPost as $key=>$val){
						$faltainjustArr[$i][$key] = $faltainjustPost[$key][$i];
						$faltainjustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_faltainjust', $faltainjustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_faltainjust', 'idFaltainJust', json_encode($ids), 'Folha Pagamento: Parâmetros Faltas Injustificadas (on edit)' );
				}
					
			# Parametrizando Atrasos Justificados
				$atrasojustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="atrasojust"){
						$atrasojustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$atrasojustArr = array();
				for($i=0;$i<count($atrasojustPost['tipo']);$i++){
					foreach($atrasojustPost as $key=>$val){
						$atrasojustArr[$i][$key] = $atrasojustPost[$key][$i];
						$atrasojustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_atrasojust', $atrasojustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_atrasojust', 'idAtrasoJust', json_encode($ids), 'Folha Pagamento: Parâmetros Atrasos Justificados (on edit)' );
				}
					
			# Parametrizando Atrasos Injustificados
				$atrasoinjustPost=array();
				foreach($_POST AS $key=>$val){
					$tmp = explode("_",$key);
					if($tmp[0]=="atrasoinjust"){
						$atrasoinjustPost[$tmp[1]]=$val;
						unset($_POST[$key]);
					}
				}	
				
				$atrasoinjustArr = array();
				for($i=0;$i<count($atrasoinjustPost['tipo']);$i++){
					foreach($atrasoinjustPost as $key=>$val){
						$atrasoinjustArr[$i][$key] = $atrasoinjustPost[$key][$i];
						$atrasoinjustArr[$i]['idFolhaParametro'] = $id_global;
					}
				}
				
				# Inserindo Registro
				$ids = $this->financeiro_model->add_batch('folhapagamento_atrasoinjust', $atrasoinjustArr);

				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'folhapagamento_atrasoinjust', 'idAtrasoinJust', json_encode($ids), 'Folha Pagamento: Parâmetros Atrasos Injustificados (on edit)' );
				}
					
			
				if($id_global!= NULL){
				   $this->session->set_flashdata('sucess','Parâmetro alterado com sucesso!');
				   redirect(base_url() . $this->permission->getIdPerfilAtual().'/financeiro/folhadepagamento/editar/'.$id_global);
				}
			
			
		}
		
	}
	
	
    public function fechamentoFuncionario(){
    	$this->setControllerMenu($this->router->class.'/funcionario');

		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->financeiro_model->fechamentoFuncionario($view, $idFuncionario, $data_inicial, $data_final);
		$this->data['view'] = 'financeiro/imprimir/funcionario';
		$this->load->view('tema/topo',$this->data);		
    
    }
	
	# gerencia chamada
	function chamada(){
		$this->setControllerMenu($this->router->class.'/chamada');
		
        if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->financeiro_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->financeiro_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'financeiro/view/chamada';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoChamada(){
    	$this->setControllerMenu($this->router->class.'/chamada');
    	
        if(!$this->permission->controllerManual('financeiro/chamada')->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para gerar fechamento.');
           redirect(base_url());
        }
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idCliente = $this->input->get('idCliente');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->financeiro_model->fechamentoChamada($data_inicial, $data_final, $idCliente, $idFuncionario, $view);
		$this->data['view'] = 'financeiro/imprimir/chamada';
		$this->load->view('tema/topo',$this->data);	
    
    }
	
	
	# gerencia particular
	function particular(){
        if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->financeiro_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->financeiro_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'financeiro/view/particular';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoParticular(){
        if(!$this->permission->controllerManual('financeiro/chamada')->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para gerar fechamento.');
           redirect(base_url());
        }
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->financeiro_model->fechamentoParticular($data_inicial, $data_final, $idFuncionario, $view);
		$this->data['view'] = 'financeiro/imprimir/particular';
		$this->load->view('tema/topo',$this->data);	
    
    }

	# gerencia empresa
	function empresa(){
        if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->financeiro_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->financeiro_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'financeiro/view/empresa';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoEmpresa(){
        if(!$this->permission->controllerManual('financeiro/chamada')->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para gerar fechamento.');
           redirect(base_url());
        }
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->financeiro_model->fechamentoEmpresa($data_inicial, $data_final, $idFuncionario, $view);
		$this->data['view'] = 'financeiro/imprimir/empresa';
		$this->load->view('tema/topo',$this->data);	
    
    }

	
	
	
}

