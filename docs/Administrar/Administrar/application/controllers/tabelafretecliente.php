<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class TabelaFreteCliente extends MY_Controller {
    
	private $flashData;
	private $idClienteFreteItinerarioServicos;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('tabelafretecliente_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error', 'Você não tem permissão para visualizar a tabela de frete de clientes.');
			 redirect(base_url());
		}
		
		$this->data['historico'] = $this->tabelafretecliente_model->carregarHistoricoTodos();
		$this->data['clienteSemTabela'] = $this->tabelafretecliente_model->getClientesSemTabela();
		
		$this->data['view'] = 'tabelafrete/tabelafretecliente_todos';
		$this->load->view('tema/topo',$this->data);
		
    }
    
    function itinerariocliente() {
    	if(!$this->permission->controllerManual('tabelafretecliente/itinerariocliente')->canSelect()){
    		$this->session->set_flashdata('error', 'Você não tem permissão para visualizar a tabela de frete de clientes.');
    		redirect(base_url());
    	}
    	
    	$idCliente = $this->session->userdata('idAcessoExterno');
    	$idClienteFrete = $this->tabelafretecliente_model->getIdClienteFreteAtual($idCliente);
    	
    	if ($idClienteFrete) {
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/'.$idClienteFrete);
    	}
    	else {
    		$this->session->set_flashdata('error', 'Não existe vigência em aberto para tabela de preços e itinerários');
    		redirect(base_url());
    	}
    }
    
    function editar() {
    	if ($this->permission->controllerManual('tabelafretecliente/itinerariocliente')->canSelect()) {
    		$this->setControllerMenu('tabelafretecliente/itinerariocliente');
    	}
    	
    	if($this->permission->canSelect() || $this->permission->controllerManual('tabelafretecliente/itinerariocliente')->canSelect()){
	    	
	    	$idClienteFrete = $this->uri->segment(3);
	    	
	    	if ($idClienteFrete != "") {
	    		
	//     		if (!$this->tabelafretecliente_model->existeOutraVigenciaAberta($idClienteFrete)) {
	    			
		    		$this->data['result'] = $this->tabelafretecliente_model->carregar($idClienteFrete);
		    		
		    		if (count($this->data['result']) > 0) {
		    			$this->data['historico'] = $this->tabelafretecliente_model->carregarHistorico($idClienteFrete);
		    			$this->data['listaCidade'] = $this->tabelafretecliente_model->getBaseCadastro('cidade', 'cidade', 'ASC');
		    			$this->data['listaItinerarios'] = $this->tabelafretecliente_model->getItinerarios($idClienteFrete);
		    			
		    			$this->data['view'] = 'tabelafrete/tabelafretecliente_view';
		    			$this->load->view('tema/topo',$this->data);
		    		}
		    		else {
			    		$this->session->set_flashdata('error', 'Tabela /Cliente inativo ou não localizado!');
		    			redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
		    		}
	//     		}
	//     		else {
	// 	    		$this->session->set_flashdata('error', 'Existe uma tabela com vigência em aberto para este cliente!');
	//     			redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
	//     		}
	    	}
	    	else {
	    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
	    	}
    	}
    	else {
    		$this->flashData = 'Você não tem permissão para visualizar a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    }

    function gravaritinerario() {

    	if($this->permission->canUpdate() || $this->permission->controllerManual('tabelafretecliente/itinerariocliente')->canUpdate()){
	    
	    	if ($this->validarDadosItinerario()) {
	    
	    		$dados = $this->getDadosItinerario();
	    		$dadosServico = $this->getDadosItinerarioServicos();
	    		
	    		$tabela = 'cliente_frete_itinerario';
	    		$resultado = false;
	    		$idClienteFreteItinerario = $this->input->post('idClienteFreteItinerario');
	    
	    		if ($idClienteFreteItinerario == "") {
	    			$idClienteFreteItinerario = $this->tabelafretecliente_model->inserirDadosTabela($tabela, $dados);
	    			$resultado = $idClienteFreteItinerario;
	    		}
	    		else {
	    			$this->logs_modelclass->registrar_log_antes_update ( $tabela, 'idClienteFreteItinerario', $idClienteFreteItinerario, 'Tabela Frete Cliente Itinerário' );
	    			$where = array('idClienteFreteItinerario' => $idClienteFreteItinerario);
	    			$resultado = $this->tabelafretecliente_model->atualizarDadosTabela($tabela, $dados, $where);
	    			
		    		if ($resultado) $this->logs_modelclass->registrar_log_depois ();
	    		}
	    		
	
	    		if ($resultado) {
	    			$this->logs_modelclass->registrar_log_insert ( $tabela, 'idClienteFreteItinerario', $idClienteFreteItinerario, 'Tabela Frete Cliente Itinerário' );
	    			
	    			$tabela = 'cliente_frete_itinerario_servicos';
	    			
	    			for($i = 0; $i < count($dadosServico); $i++) {
	    				
		    			$dadosServico[$i]['idClienteFreteItinerario'] = $idClienteFreteItinerario;
	    				
	    				if ($this->idClienteFreteItinerarioServicos[$i] == "") {
		    				$idServico = $this->tabelafretecliente_model->inserirDadosTabela($tabela, $dadosServico[$i]);
		    				$this->logs_modelclass->registrar_log_insert ( $tabela, 'idClienteFreteItinerarioServico', $idServico, 'Tabela Frete Cliente Itinerário (serviço)' );
	    				}
	    				else {
	
	    					$this->logs_modelclass->registrar_log_antes_update ( $tabela, 'idClienteFreteItinerarioServico', $this->idClienteFreteItinerarioServicos[$i], 'Tabela Frete Cliente Itinerário' );
	    					$where = array('idClienteFreteItinerarioServico' => $this->idClienteFreteItinerarioServicos[$i]);
	    					
	    					$resultado = $this->tabelafretecliente_model->atualizarDadosTabela($tabela, $dadosServico[$i], $where);
	    					
	    					if ($resultado) $this->logs_modelclass->registrar_log_depois ();
	    				}
	    			}
	
	    			$where = array('idClienteFreteItinerario' => $idClienteFreteItinerario);
	    			$this->tabelafretecliente_model->removerServicosNotIn($where, $this->idClienteFreteItinerarioServicos);
	    		}
	    
	    		else $this->flashData = "Não foi possível salvar o registro!";
	    	}

	    	$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
	    	if ($this->flashData == "") $this->flashData = "Parâmetros registrados com sucesso!";
	    	 
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/' . $this->input->post('idClienteFrete'));
    	}
    	else {
    		$this->flashData = 'Você não tem permissão para atualizar a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    }
    
    function gravartabela() {

    	if(!$this->permission->canUpdate()){
    		$this->flashData = 'Você não tem permissão para atualizar a tabela de frete de clientes.';
    		redirect(base_url());
    	}

    	if ($this->validarDadosFormulario()) {

    		$dados = $this->getDadosFormulario();
    		$idClienteFrete = $this->input->post('idClienteFrete');
    		
    		$where = array('idClienteFrete' => $idClienteFrete);

    		$this->logs_modelclass->registrar_log_antes_update ( 'cliente_frete', 'idClienteFrete', $this->input->post ( 'idClienteFrete' ), 'Tabela Frete Cliente' );
    		$resultado = $this->tabelafretecliente_model->atualizarDados($dados, $where);
    		
    		if ($resultado) $this->logs_modelclass->registrar_log_depois ();

    		if (!$resultado) $this->flashData = "Não foi possível salvar o registro!";
    	}
    	
    	if ($resultado && $this->input->post('novaCompetencia') && $this->input->post('vigencia_final') != "" ) {
    		$this->novaCompetencia($idClienteFrete);
    	}

    	$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
    	if ($this->flashData == "") $this->flashData = "Parâmetros registrados com sucesso!";
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/' . $this->input->post('idClienteFrete'));
    }
    
    function criarNovaTabela() {

    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    	
    	$idClienteFrete = $this->input->post('idClienteFrete');
    	$idCliente = $this->input->post('idCliente');
    	
    	if ($idCliente != "") {
    		$this->novaCompetenciaNovoCliente($idClienteFrete, $idCliente);
    	}
    	else {
    		$this->session->set_flashdata('error', 'Você deve informar um cliente que ainda não possui tabela de frete!');
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
    	}
    }
    
    function remover_itinerario() {

    	if(!$this->permission->canDelete()){
    		$this->flashData = 'Você não tem permissão para remover a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    	
    	$idClienteFrete = $this->input->post('idClienteFrete');
    	$idClienteFreteItinerario = $this->input->post('idClienteFreteItinerario');
    	 
    	if ($idClienteFreteItinerario!= "") {
    		$tabela = 'cliente_frete_itinerario';
    		$where = array('idClienteFreteItinerario' => $idClienteFreteItinerario);
    	
    		$this->logs_modelclass->registrar_log_antes_delete ( $tabela, 'idClienteFreteItinerario', $idClienteFreteItinerario, 'Tabela Frete Cliente Itinerário' );
    		$result = $this->tabelafretecliente_model->removerRegistroTabela($tabela, $where);
    	
    		$flashDataType = ($result) ? "success" : "error";
    	
    		if ($result) {
    			$this->logs_modelclass->registrar_log_depois ();
    			$this->flashData = "Registro removido!";
    		}
    		else {
    			$this->flashData = "Ocorreu um erro!";
    		}
    		 
    		$this->session->set_flashdata($flashDataType, $this->flashData);
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/'.$idClienteFrete);
    	}
    	else {
    		$this->session->set_flashdata('error', 'Itinerário não encontrado!');
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/'.$idClienteFrete);
    	}
    }
    
    function removertabela() {

    	if(!$this->permission->canDelete()){
    		$this->flashData = 'Você não tem permissão para remover a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    	
    	$idClienteFrete = $this->input->post('idClienteFrete');
    	
    	if ($idClienteFrete != "") {
    		$where = array('idClienteFrete', $idClienteFrete);
    		
    		$this->logs_modelclass->registrar_log_antes_delete ( 'cliente_frete', 'idClienteFrete', $idClienteFrete, 'Tabela Frete Cliente' );
    		$result = $this->tabelafretecliente_model->removerRegistro($where);
	   		
	    	$flashDataType = ($result) ? "success" : "error";
	    	
	    	if ($result) {
	    		$this->logs_modelclass->registrar_log_depois ();
	    		$this->flashData = "Registro removido!";
	    	}
	    	else {
	    		$this->flashData = "Ocorreu um erro!";
//	    		$id = $idClienteFreteCopiar;
	    	}
	    	 
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
    	}
    	else {
    		$this->session->set_flashdata('error', 'Você deve informar um cliente para remover a tabela de fretes!');
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/');
    	}
    }
    
    function novaCompetenciaNovoCliente($idClienteFreteCopiar, $idClienteNovo = null) {
    	if ($idClienteFreteCopiar != "") {
    		$this->novaCompetencia($idClienteFreteCopiar, $idClienteNovo);
    	}
    	else {
    		$hoje = date_create();
    		$hoje = date_format($hoje,"Y-m-d");
    		$novoRegistro = array('idCliente' => $idClienteNovo, 'vigencia_inicial' => $hoje);
    		
    		$id = $this->tabelafretecliente_model->inserirDados($novoRegistro);
    		if ($id) $this->logs_modelclass->registrar_log_insert ( 'cliente_frete', 'idClienteFrete', $id, 'Tabela Frete Cliente' );
    		 
    		$flashDataType = ($id) ? "success" : "error";
    		 
    		if ($id) {
    			$this->flashData = "Novo registro gerado com sucesso!";
    		}
    		else {
    			$this->flashData = "Ocorreu um erro!";
    			$id = $idClienteFreteCopiar;
    		}
    		
    		$this->session->set_flashdata($flashDataType, $this->flashData);
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/' . $id);
    	}
    	
    }
    
    function copiarEmSelecionados() {

    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir/copiar a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    	
    	if ($this->input->post('tabFreteCheck') 
    			&& $this->input->post('idClienteFrete') 
    			&& $this->input->post('vigencia_final')) {

    		$tabFreteCheck = $_POST['tabFreteCheck'];
    				
	    	for($i=0; $i < count($tabFreteCheck); $i++)
	    	{
	    		$dados = array('vigencia_final' => conv_data_DMY_para_YMD($this->input->post('vigencia_final')));
	    		$where = array('idClienteFrete' => $tabFreteCheck[$i]);
	    		
	    		$this->logs_modelclass->registrar_log_antes_update ( 'cliente_frete', 'idClienteFrete', $tabFreteCheck[$i], 'Tabela Frete Cliente' );
	    		if ($this->tabelafretecliente_model->atualizarDados($dados, $where)) {
	    			$this->logs_modelclass->registrar_log_depois ();
	    			$this->novaCompetenciaViaCopia($this->input->post('idClienteFrete'), $tabFreteCheck[$i]);
	    		}
	    		else {
	    			$link = "<a href='".base_url().'tabelafretecliente/editar/'. $tabFreteCheck[$i] ."'>".$tabFreteCheck[$i]."</a>";
	    			$this->flashData.= "Não foi possível atualizar vigência final de: " . $link;
	    		}
	    	}

	    	$flashDataType = ($this->flashData == "") ? "success" : "error";
	    	 
	    	if ($this->flashData == "") {
	    		$this->flashData = "Tabelas atualizadas com sucesso!";
	    	}
	    	
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente');
    	}
    }
    
    function novaCompetenciaViaCopia($idClienteFreteParaCopiar, $idClienteFreteParaPegarIdCliente) {
    	
    	$registroAntigo = $this->tabelafretecliente_model->carregar($idClienteFreteParaCopiar);
    	$idCliente =  $this->tabelafretecliente_model->getIdClienteDoIdClienteFrete($idClienteFreteParaPegarIdCliente);
    	
    	$novoRegistro = array();
    	foreach ($registroAntigo[0] as $key => $value) {
    		if ($key != 'nomefantasia' && $key != 'idClienteFrete') {
    				
    			//pode ser copiada a tabela de um cliente para outro
    			if ($key == 'idCliente') {
    				$novoRegistro = array_merge($novoRegistro, array('idCliente' => $idCliente));
    			}
    			else if ($key == 'vigencia_final') {
    				$novoRegistro = array_merge($novoRegistro, array('vigencia_final' => null));
    			}
    			else {
    				$novoRegistro = array_merge($novoRegistro, array($key => $value));
    			}
    		}
    	}
    	//var_dump($novoRegistro);
    	$id = $this->tabelafretecliente_model->inserirDados($novoRegistro);
    	
    	if ($id) {
    		$this->logs_modelclass->registrar_log_insert ( 'cliente_frete', 'idClienteFrete', $id, 'Tabela Frete Cliente' );
    		
    		$this->copiarItinerariosAntigosParaNovaTabela($idClienteFreteParaPegarIdCliente, $id);
    	}
    	 
    	else {
    		$this->flashData.= "Não foi possível inserir uma nova tabela (cliente: " . $idCliente .")";
    	}
    	
    }
    
    /**
     * Cria nova competencia, podendo ser copiada de uma antiga
     * @param unknown $idClienteFreteCopiar
     * @param unknown $idClienteNovo
     */
    function novaCompetencia($idClienteFreteCopiar, $idClienteNovo = null) {

    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir/copiar a tabela de frete de clientes.';
    		redirect(base_url());
    	}
    	
   		$registroAntigo = $this->tabelafretecliente_model->carregar($idClienteFreteCopiar);
   		
   		$novoRegistro = array();
   		foreach ($registroAntigo[0] as $key => $value) {
   			if ($key != 'nomefantasia' && $key != 'idClienteFrete') {
   				
   				//pode ser copiada a tabela de um cliente para outro
   				if ($key == 'idCliente' && $idClienteNovo != null) {
   					$novoRegistro = array_merge($novoRegistro, array('idCliente' => $idClienteNovo));
   				}
   				else if ($key == 'vigencia_inicial' && $idClienteNovo == null) {
   					$novoRegistro = array_merge($novoRegistro, array('vigencia_inicial' => $registroAntigo[0]->vigencia_final));
   				}
   				else if ($key == 'vigencia_final') {
   					$novoRegistro = array_merge($novoRegistro, array('vigencia_final' => null));
   				}
   				else {
   					$novoRegistro = array_merge($novoRegistro, array($key => $value));
   				}
   			}
   		}
   		$id = $this->tabelafretecliente_model->inserirDados($novoRegistro);
   		
   		if ($id) if ($id) $this->logs_modelclass->registrar_log_insert ( 'cliente_frete', 'idClienteFrete', $id, 'Tabela Frete Cliente' );
   		
   		if ($idClienteNovo == null) {
   			$this->copiarItinerariosAntigosParaNovaTabela($idClienteFreteCopiar, $id);
   		}
   		
    	$flashDataType = ($id) ? "success" : "error";
    	
    	if ($id) {
    		$this->flashData = "Novo registro gerado com sucesso!";
    	}
    	else {
    		$this->flashData = "Ocorreu um erro!";
    		$id = $idClienteFreteCopiar;
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretecliente/editar/' . $id);
    }
    
    private function copiarItinerariosAntigosParaNovaTabela($idClienteFreteVelha, $idClienteFreteNova) {
    	$dadosItinerarios = $this->tabelafretecliente_model->getItinerariosParaCopia($idClienteFreteVelha, $idClienteFreteNova);
    	
//     	var_dump($dadosItinerarios); die();
    	
    	foreach ($dadosItinerarios as $itinerario) {
    		//armazena id antigo para copiar serviços posteriormente
    		$idClienteFreteItinerarioAntigo = $itinerario->idClienteFreteItinerario;
    		
	    	$dados = json_decode(json_encode($itinerario), true);
    		$dados = array_slice($dados, 1);
	
	    	$idClienteFreteItinerario = $this->tabelafretecliente_model->inserirDadosTabela('cliente_frete_itinerario', $dados);
	    	$this->logs_modelclass->registrar_log_insert ( 'cliente_frete_itinerario', 'idClienteFreteItinerario', $idClienteFreteItinerario, 'Tabela Frete Cliente Itinerário' );
	    	
	    	
	    	//agora insere os serviços do itinerário
	    	$dadosServicos = $this->tabelafretecliente_model->getItinerarioServicosParaCopia($idClienteFreteItinerarioAntigo, $idClienteFreteItinerario);
	    	
// 	    	var_dump($dadosServicos);
	    	
	    	foreach ($dadosServicos as $dados) {
	    		$dados = json_decode(json_encode($dados), true);
	    		
	    		$this->tabelafretecliente_model->inserirDadosTabela('cliente_frete_itinerario_servicos', $dados);
	    		$this->logs_modelclass->registrar_log_insert ( 'cliente_frete_itinerario_servicos', 'idClienteFreteItinerario', $idClienteFreteItinerario, 'Tabela Frete Cliente Itinerário' );
	    	}
    	}
//     	die('morra');
    }
    
    function getDadosFormulario() {

    	$vigencia_final = ($this->input->post('vigencia_final') != "") 
    		? conv_data_DMY_para_YMD($this->input->post('vigencia_final'))
    		: null;

    	$dados = array(
    		'vigencia_inicial' => conv_data_DMY_para_YMD($this->input->post('vigencia_inicial')),
    		'vigencia_final' => $vigencia_final,
    		'valor_moto_normal' => conv_num_para_base($this->input->post('valor_moto_normal')),
    		'valor_moto_metropolitano' => conv_num_para_base($this->input->post('valor_moto_metropolitano')),
    		'valor_moto_depois_18' => conv_num_para_base($this->input->post('valor_moto_depois_18')),
    		'valor_moto_km' => conv_num_para_base($this->input->post('valor_moto_km')),
    		'valor_moto_metropolitano_apos18' => conv_num_para_base($this->input->post('valor_moto_metropolitano_apos18')),
    		'valor_carro_normal' => conv_num_para_base($this->input->post('valor_carro_normal')),
    		'valor_carro_metropolitano' => conv_num_para_base($this->input->post('valor_carro_metropolitano')),
    		'valor_carro_depois_18' => conv_num_para_base($this->input->post('valor_carro_depois_18')),
    		'valor_carro_km' => conv_num_para_base($this->input->post('valor_carro_km')),
    		'valor_carro_metropolitano_apos18' => conv_num_para_base($this->input->post('valor_carro_metropolitano_apos18')),
    		'valor_van_normal' => conv_num_para_base($this->input->post('valor_van_normal')),
    		'valor_van_metropolitano' => conv_num_para_base($this->input->post('valor_van_metropolitano')),
    		'valor_van_depois_18' => conv_num_para_base($this->input->post('valor_van_depois_18')),
    		'valor_van_km' => conv_num_para_base($this->input->post('valor_van_km')),
    		'valor_van_metropolitano_apos18' => conv_num_para_base($this->input->post('valor_van_metropolitano_apos18')),
    		'valor_caminhao_normal' => conv_num_para_base($this->input->post('valor_caminhao_normal')),
    		'valor_caminhao_metropolitano' => conv_num_para_base($this->input->post('valor_caminhao_metropolitano')),
    		'valor_caminhao_depois_18' => conv_num_para_base($this->input->post('valor_caminhao_depois_18')),
    		'valor_caminhao_km' => conv_num_para_base($this->input->post('valor_caminhao_km')),
    		'valor_caminhao_metropolitano_apos18' => conv_num_para_base($this->input->post('valor_caminhao_metropolitano_apos18')),
    	);
    	
    	return $dados;
    }
    
    function getDadosItinerario() {
    	$dados = array(
    		'idClienteFrete' => $this->input->post('idClienteFrete'),
    		'nome' => $this->input->post('nome_itinerario'),
    		'valor_empresa' => conv_num_para_base($this->input->post('valor_empresa_itinerario')),
    		'valor_funcionario' => conv_num_para_base($this->input->post('valor_funcionario_itinerario')),
    		'tipo_veiculo' => $this->input->post('tipo_veiculo'),
    		'retorno' => ($this->input->post('retornar-origem')) ? true : false
    	);
    	
    	return $dados;
    }
    
    function getDadosItinerarioServicos() {

    	$chamadaCad = array();
    	
    	$i = 0;
    	foreach($_POST AS $key=>$val){
    		$tmp = explode("_",$key);
    		if($tmp[0]=="cham"){
    			$chamadaCad[$tmp[1]]=$val;
    			
    			if ($tmp[1] == 'idClienteFreteItinerarioServico') {
    				$this->idClienteFreteItinerarioServicos[$i] = $val;
    				$i++;
    			}
    			unset($_POST[$key]);
    		}
    	}
    	
    	$nova_chamada = array();
    	for($i=0;$i<count($chamadaCad['tiposervico']);$i++){
    		foreach($chamadaCad as $key=>$val){
    			$nova_chamada[$i][$key] = $chamadaCad[$key][$i];
    		}
    	}
    	$this->idClienteFreteItinerarioServicos = $this->idClienteFreteItinerarioServicos[0];
    	return $nova_chamada;
    }
    
    function validarDadosFormulario() {
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';

    	$this->form_validation->set_rules('vigencia_inicial', 				'vigencia_inicial', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('vigencia_final', 				'vigencia_final', 					'trim|xss_clean');
    	
    	$this->form_validation->set_rules('valor_moto_normal', 				'valor_moto_normal', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_moto_metropolitano', 		'valor_moto_metropolitano', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_moto_depois_18', 			'valor_moto_depois_18', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_moto_km', 					'valor_moto_km', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_moto_metropolitano_apos18','valor_moto_metropolitano_apos18', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_carro_normal', 			'valor_carro_normal', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_carro_metropolitano', 		'valor_carro_metropolitano', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_carro_depois_18', 			'valor_carro_depois_18', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_carro_km', 				'valor_carro_km', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_carro_metropolitano_apos18','valor_carro_metropolitano_apos18','trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_van_normal', 				'valor_van_normal', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_van_metropolitano', 		'valor_van_metropolitano', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_van_depois_18', 			'valor_van_depois_18', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_van_km', 					'valor_van_km', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_van_metropolitano_apos18', 'valor_van_metropolitano_apos18', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_caminhao_normal', 			'valor_caminhao_normal', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_caminhao_metropolitano', 	'valor_caminhao_metropolitano', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_caminhao_depois_18', 		'valor_caminhao_depois_18', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_caminhao_km', 				'valor_caminhao_km', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_caminhao_metropolitano_apos18', 'valor_caminhao_metropolitano_apos18', 'trim|required|xss_clean');
    	
		$vigencia_inicial =  new DateTime(conv_data_DMY_para_YMD($this->input->post('vigencia_inicial')));
		$vigencia_final =  new DateTime(conv_data_DMY_para_YMD($this->input->post('vigencia_final')));
    	$finalEhMaior = ($vigencia_final < $vigencia_inicial) ? true : false;
		
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas ao gravar alguns Parâmetros!</div>'.validation_errors();
    			
    		return false;
    	}
    	else if ($this->input->post('vigencia_final') != "" && $finalEhMaior) {
    		$this->flashData = '<div class="form_error">Vigência final deve ser maior que a inicial!</div>';
			
			return false;
    	}
    	else return true;
    }

    function validarDadosItinerario() {
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idClienteFrete', 				'idClienteFrete', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('id_itinerario', 					'id_itinerario', 					'trim|xss_clean');
    	$this->form_validation->set_rules('nome_itinerario', 				'nome_itinerario', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('valor_empresa_itinerario', 		'valor_empresa_itinerario', 		'trim|xss_clean');
    	$this->form_validation->set_rules('valor_funcionario_itinerario', 	'valor_funcionario_itinerario', 	'trim|xss_clean');
    	$this->form_validation->set_rules('tipo_veiculo', 					'tipo_veiculo', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('retornar-origem',				'retornar-origem', 					'trim|xss_clean');
    	
    	$this->form_validation->set_rules('id_servico[]', 					'id_servico[]', 					'trim|xss_clean');
    	$this->form_validation->set_rules('cham_tiposervico[]', 			'cham_tiposervico[]', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('cham_endereco[]', 				'cham_endereco[]', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('cham_numero[]', 					'cham_numero[]', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('cham_bairro[]', 					'cham_bairro[]', 					'trim|required|xss_clean');
    	$this->form_validation->set_rules('cham_falarcom[]',				'cham_falarcom[]',					'trim|xss_clean');
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas ao gravar alguns Parâmetros!</div>'.validation_errors();
    		 
    		return false;
    	}
    	
    	return true;
    }   
    
}