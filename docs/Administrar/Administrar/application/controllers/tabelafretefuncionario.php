<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class TabelaFreteFuncionario extends MY_Controller {
    
	private $flashData;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('tabelafretefuncionario_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		if(!$this->permission->canSelect()){
			$this->flashData = 'Você não tem permissão para visualizar a tabela de frete de funcionarios.';
			 redirect(base_url());
		}
		
		$this->data['historico'] = $this->tabelafretefuncionario_model->carregarHistoricoTodos();
		$this->data['funcionarioSemTabela'] = $this->tabelafretefuncionario_model->getfuncionariosSemTabela();
		
		//var_dump($this->data['historico']); die();
		
		$this->data['view'] = 'tabelafrete/tabelafretefuncionario_todos';
		$this->load->view('tema/topo',$this->data);
		
    }
    
    function editar() {

    	if(!$this->permission->canSelect()){
    		$this->flashData = 'Você não tem permissão para visualizar a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}
    	
    	$idFuncionarioFrete = $this->uri->segment(3);
    	
    	if ($idFuncionarioFrete != "") {
    		
    		if (!$this->tabelafretefuncionario_model->existeOutraVigenciaAberta($idFuncionarioFrete)) {
    			
	    		$this->data['result'] = $this->tabelafretefuncionario_model->carregar($idFuncionarioFrete);
	    		
	    		if (count($this->data['result']) > 0) {
	    			$this->data['historico'] = $this->tabelafretefuncionario_model->carregarHistorico($idFuncionarioFrete);
	    		
	    			$this->data['view'] = 'tabelafrete/tabelafretefuncionario_view';
	    			$this->load->view('tema/topo',$this->data);
	    		}
	    		else {
		    		$this->session->set_flashdata('error', 'Tabela /funcionario inativo ou não localizado!');
	    			redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
	    		}
    		}
    		else {
	    		$this->session->set_flashdata('error', 'Existe uma tabela com vigência em aberto para este funcionario!');
    			redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
    		}
    	}
    	else {
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
    	}
    }
    
    function gravartabela() {

    	if(!$this->permission->canUpdate()){
    		$this->flashData = 'Você não tem permissão para atualizar a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}

    	if ($this->validarDadosFormulario()) {

    		$dados = $this->getDadosFormulario();
    		$idFuncionarioFrete = $this->input->post('idFuncionarioFrete');
    		
    		$where = array('idFuncionarioFrete' => $idFuncionarioFrete);

    		$this->logs_modelclass->registrar_log_antes_update ( 'funcionario_frete', 'idFuncionarioFrete', $this->input->post ( 'idFuncionarioFrete' ), 'Tabela Frete funcionario' );
    		$resultado = $this->tabelafretefuncionario_model->atualizarDados($dados, $where);
    		
    		if ($resultado) $this->logs_modelclass->registrar_log_depois ();

    		if (!$resultado) $this->flashData = "Não foi possível salvar o registro!";
    	}
    	
    	if ($resultado && $this->input->post('novaCompetencia') && $this->input->post('vigencia_final') != "" ) {
    		$this->novaCompetencia($idFuncionarioFrete);
    	}

    	$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
    	if ($this->flashData == "") $this->flashData = "Parâmetros registrados com sucesso!";
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/editar/' . $this->input->post('idFuncionarioFrete'));
    }
    
    function criarNovaTabela() {

    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}
    	
    	$idFuncionarioFrete = $this->input->post('idFuncionarioFrete');
    	$idFuncionario = $this->input->post('idFuncionario');
    	
    	if ($idFuncionario != "") {
    		$this->novaCompetenciaNovofuncionario($idFuncionarioFrete, $idFuncionario);
    	}
    	else {
    		$this->session->set_flashdata('error', 'Você deve informar um funcionario que ainda não possui tabela de frete!');
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
    	}
    }
    
    function removertabela() {

    	if(!$this->permission->canDelete()){
    		$this->flashData = 'Você não tem permissão para remover a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}
    	
    	$idFuncionarioFrete = $this->input->post('idFuncionarioFrete');
    	
    	if ($idFuncionarioFrete != "") {
    		$where = array('idFuncionarioFrete', $idFuncionarioFrete);
    		
    		$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_frete', 'idFuncionarioFrete', $idFuncionarioFrete, 'Tabela Frete funcionario' );
    		$result = $this->tabelafretefuncionario_model->removerRegistro($where);
	   		
	    	$flashDataType = ($result) ? "success" : "error";
	    	
	    	if ($result) {
	    		$this->logs_modelclass->registrar_log_depois ();
	    		$this->flashData = "Registro removido!";
	    	}
	    	else {
	    		$this->flashData = "Ocorreu um erro!";
	    		$id = $idFuncionarioFreteCopiar;
	    	}
	    	 
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
    	}
    	else {
    		$this->session->set_flashdata('error', 'Você deve informar um funcionario para remover a tabela de fretes!');
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/');
    	}
    }
    
    function novaCompetenciaNovofuncionario($idFuncionarioFreteCopiar, $idFuncionarioNovo = null) {
    	if ($idFuncionarioFreteCopiar != "") {
    		$this->novaCompetencia($idFuncionarioFreteCopiar, $idFuncionarioNovo);
    	}
    	else {
    		$hoje = date_create();
    		$hoje = date_format($hoje,"Y-m-d");
    		$novoRegistro = array('idFuncionario' => $idFuncionarioNovo, 'vigencia_inicial' => $hoje);
    		
    		$id = $this->tabelafretefuncionario_model->inserirDados($novoRegistro);
    		if ($id) $this->logs_modelclass->registrar_log_insert ( 'funcionario_frete', 'idFuncionarioFrete', $id, 'Tabela Frete funcionario' );
    		 
    		$flashDataType = ($id) ? "success" : "error";
    		 
    		if ($id) {
    			$this->flashData = "Novo registro gerado com sucesso!";
    		}
    		else {
    			$this->flashData = "Ocorreu um erro!";
    			$id = $idFuncionarioFreteCopiar;
    		}
    		
    		$this->session->set_flashdata($flashDataType, $this->flashData);
    		redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/editar/' . $id);
    	}
    	
    }
    
    function copiarEmSelecionados() {
    	
    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir/copiar a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}
    	
    	if ($this->input->post('tabFreteCheck') 
    			&& $this->input->post('idFuncionarioFrete') 
    			&& $this->input->post('vigencia_final')) {

    		$tabFreteCheck = $_POST['tabFreteCheck'];
    				
	    	for($i=0; $i < count($tabFreteCheck); $i++)
	    	{
	    		$dados = array('vigencia_final' => conv_data_DMY_para_YMD($this->input->post('vigencia_final')));
	    		$where = array('idFuncionarioFrete' => $tabFreteCheck[$i]);
	    		
	    		$this->logs_modelclass->registrar_log_antes_update ( 'funcionario_frete', 'idFuncionarioFrete', $tabFreteCheck[$i], 'Tabela Frete funcionario' );
	    		if ($this->tabelafretefuncionario_model->atualizarDados($dados, $where)) {
	    			$this->logs_modelclass->registrar_log_depois ();
	    			
	    			$this->novaCompetenciaViaCopia($this->input->post('idFuncionarioFrete'), $tabFreteCheck[$i]);
	    		}
	    		else {
	    			$link = "<a href='".base_url().'tabelafretefuncionario/editar/'. $tabFreteCheck[$i] ."'>".$tabFreteCheck[$i]."</a>";
	    			$this->flashData.= "Não foi possível atualizar vigência final de: " . $link;
	    		}
	    	}

	    	$flashDataType = ($this->flashData == "") ? "success" : "error";
	    	 
	    	if ($this->flashData == "") {
	    		$this->flashData = "Tabelas atualizadas com sucesso!";
	    	}
	    	
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario');
    	}
    }
    
    function novaCompetenciaViaCopia($idFuncionarioFreteParaCopiar, $idFuncionarioFreteParaPegaridFuncionario) {
    	
    	$registroAntigo = $this->tabelafretefuncionario_model->carregar($idFuncionarioFreteParaCopiar);
    	$idFuncionario =  $this->tabelafretefuncionario_model->getIdFuncionarioDoIdFuncionarioFrete($idFuncionarioFreteParaPegaridFuncionario);
    	
    	$novoRegistro = array();
    	foreach ($registroAntigo[0] as $key => $value) {
    		if ($key != 'nome' && $key != 'idFuncionarioFrete') {
    				
    			//pode ser copiada a tabela de um funcionario para outro
    			if ($key == 'idFuncionario') {
    				$novoRegistro = array_merge($novoRegistro, array('idFuncionario' => $idFuncionario));
    			}
    			else if ($key == 'vigencia_final') {
    				$novoRegistro = array_merge($novoRegistro, array('vigencia_final' => null));
    			}
    			else {
    				$novoRegistro = array_merge($novoRegistro, array($key => $value));
    			}
    		}
    	}
    	
    	$id = $this->tabelafretefuncionario_model->inserirDados($novoRegistro);
    	
    	if ($id) if ($id) $this->logs_modelclass->registrar_log_insert ( 'funcionario_frete', 'idFuncionarioFrete', $id, 'Tabela Frete funcionario' );
    	 
    	if (!$id) {
    		$this->flashData.= "Não foi possível inserir uma nova tabela (funcionario: " . $idFuncionario .")";
    	}
    	
    }
    
    /**
     * Cria nova competencia, podendo ser copiada de uma antiga
     * @param unknown $idFuncionarioFreteCopiar
     * @param unknown $idFuncionarioNovo
     */
    function novaCompetencia($idFuncionarioFreteCopiar, $idFuncionarioNovo = null) {

    	if(!$this->permission->canInsert()){
    		$this->flashData = 'Você não tem permissão para inserir/copiar a tabela de frete de funcionarios.';
    		redirect(base_url());
    	}
    	
   		$registroAntigo = $this->tabelafretefuncionario_model->carregar($idFuncionarioFreteCopiar);
   		
   		$novoRegistro = array();
   		foreach ($registroAntigo[0] as $key => $value) {
   			if ($key != 'nome' && $key != 'idFuncionarioFrete') {
   				
   				//pode ser copiada a tabela de um funcionario para outro
   				if ($key == 'idFuncionario' && $idFuncionarioNovo != null) {
   					$novoRegistro = array_merge($novoRegistro, array('idFuncionario' => $idFuncionarioNovo));
   				}
   				else if ($key == 'vigencia_inicial' && $idFuncionarioNovo == null) {
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
   		
   		$id = $this->tabelafretefuncionario_model->inserirDados($novoRegistro);
   		
   		if ($id) if ($id) $this->logs_modelclass->registrar_log_insert ( 'funcionario_frete', 'idFuncionarioFrete', $id, 'Tabela Frete funcionario' );
   		
    	$flashDataType = ($id) ? "success" : "error";
    	
    	if ($id) {
    		$this->flashData = "Novo registro gerado com sucesso!";
    	}
    	else {
    		$this->flashData = "Ocorreu um erro!";
    		$id = $idFuncionarioFreteCopiar;
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafretefuncionario/editar/' . $id);
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
    
    
}