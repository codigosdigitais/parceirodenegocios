<?php
include_once (dirname(__FILE__) . "/global_functions_helper.php");
include_once (dirname(__FILE__) . "/classes/ChamadaExternaClass.php");
include_once (dirname(__FILE__) . "/classes/ChamadaServicoExternaClass.php");

class Chamadas extends MY_Controller {
    //cade o metodo funcionario

	private $url_gcm_notification = "http://parceirodenegocios.com/gcm_comunication/v1";

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
          		redirect('entrega/login');
            }

			$whitelist = array(
				'127.0.0.1',
				'::1',
				'localhost'
			);

			if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
				//$this->url_gcm_notification = "http://localhost/gcm_comunication/v1";
			}
			else {
				//$this->url_gcm_notification = "http://parceirodenegocios.com/gcm_comunication/v1";
			}

            $this->load->helper(array('codegen_helper'));
            $this->load->model('chamadas_model','',TRUE);
        	$this->load->model('chamadaexterna_model','',TRUE);
        	$this->load->model('email_model','',TRUE);

			$this->data['listaCliente'] = $this->chamadas_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(3));
			//$this->data['listaUsuario'] = $this->chamadas_model->getBaseCadastro('sis_usuario', 'nome', 'ASC');
			$this->data['listaFuncionario'] = $this->chamadas_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(3));
			$this->data['listaBairro'] = $this->chamadas_model->getBaseCadastro('bairro', 'bairro', 'ASC');
			$this->data['listaCidade'] = $this->chamadas_model->getBaseCadastro('cidade', 'cidade', 'ASC');
			$this->data['parametroBanco'] = $this->chamadas_model->getParametroById(2);
			$this->data['parametroSetor'] = $this->chamadas_model->getParametroById(70);
			
			$this->data['parametroSetorSolicitante'] = $this->chamadas_model->getParametroById(169);
	}	
	
	function index(){
		$this->gerenciar();
	}

/*
 * @author André Baill
 * @date 29/04/2021
*/
/*
| Nova estrutura para a Dash de Chamadas
| A ideia é construir tudo para que facilite, um design empolgante e envolvente
| também usar ajax para novos clientes, solicitações etc
 */

    function chamado($periodo=null, $idChamada=null)
    {

        switch($periodo)
        {

            /* Método para criar a chamada nova lado cliente */
            case 'criar':
                $this->load->view('chamadas/chamado/topo', $this->data);
                $this->load->view('chamadas/chamado/novochamado', $this->data);
                $this->load->view('chamadas/chamado/footer');
            break;

            /* Método para salvar a chamada nova lado servidor */
            case 'salvar':

                /*
                if(!$this->permission->canInsert()){
                   $this->session->set_flashdata('error','Você não tem permissão para adicionar chamadas.');
                   redirect(base_url());
                }
                */

                $this->load->library('form_validation');
                $this->data['custom_error'] = '';

                if ($this->form_validation->run('chamadas') == false) {
                    $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
                } else {
                    
                    $chamada = $this->popularCadastroChamada(false);
                    $id_resposta = $chamada->salvar();


                    if ($id_resposta == TRUE) {

                        # envia notificação por email do cliente
                        $this->email_model->enviar_email("chamada", "operacional", $id_resposta, "adicionar");


                        $this->session->set_flashdata('success','Chamada adicionada com sucesso!');
                        redirect(base_url() . $this->permission->getIdPerfilAtual().'/chamadas/chamado/editar/' . $id_resposta);

                    } else {
                        $this->session->set_flashdata('error','Ocorreu um erro ao inserir chamada!');
                        redirect(base_url($this->permission->getIdPerfilAtual().'/chamadas/chamado/adicionar'));
                    }

                }            

            break;

            /* Método para editar a chamada nova lado cliente */
            case 'editar':

                if($this->input->post()){

                    /*

                    if(!$this->permission->canUpdate()){
                       $this->session->set_flashdata('error','Você não tem permissão para editar chamadas.');
                       redirect(base_url());
                    }

                    */

                    $this->load->library('form_validation');
                    $this->data['custom_error'] = '';

                    if ($this->form_validation->run('chamadas') == false) {
                        $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
                    } else {

                        #echo "<pre>";
                        #print_r($this->input->post());
                        #die();

                        $chamada = $this->popularCadastroChamada(true);
                        $id_resposta = $chamada->salvar();

                        if ($id_resposta == TRUE) {

                            # envia notificação por email do cliente
                            $this->email_model->enviar_email("chamada", "operacional", $this->input->post('idChamada'), "editar");

                            $this->session->set_flashdata('success','Chamada modificada com sucesso!');
                            redirect(base_url() . $this->permission->getIdPerfilAtual().'/chamadas/chamado/editar/'.$chamada->getIdChamada());
                        } else {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                        }
                    }

                } else {
                    $this->data['chamadaById'] = $this->chamadas_model->getById($idChamada);
                    $this->load->view('chamadas/chamado/topo', $this->data);
                    $this->load->view('chamadas/chamado/novochamado', $this->data);
                    $this->load->view('chamadas/chamado/footer');
                }

            break;

            /* Método listagem completa na dash */
            case null:
                $this->data['chamadas_lista_finalizada']    = $this->chamadas_model->getChamadasLista('finalizada', $periodo);  
                $this->data['chamadas_lista_pendente']      = $this->chamadas_model->getChamadasLista('pendente', $periodo);  
                $this->load->view('chamadas/chamado/topo', $this->data);
                $this->load->view('chamadas/chamado/dashboard', $this->data);
                $this->load->view('chamadas/chamado/footer');
            break;

            /* Método listagem completa na dash */
            case is_numeric($periodo):
                $this->data['chamadas_lista_finalizada']    = $this->chamadas_model->getChamadasLista('finalizada', $periodo);  
                $this->data['chamadas_lista_pendente']      = $this->chamadas_model->getChamadasLista('pendente', $periodo);  
                $this->load->view('chamadas/chamado/topo', $this->data);
                $this->load->view('chamadas/chamado/dashboard', $this->data);
                $this->load->view('chamadas/chamado/footer');
            break;
        }


    }


    function getchamado()
    {

        $consulta = $this->db
                            ->limit(200)
                            ->get('v_chamada_lista')
                            ->result();

        echo json_encode($consulta);
    }








    
	function gerenciar(){
		
        /*
		if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar chamadas.');
           redirect(base_url());
        }
		*/




        /*$this->load->library('table');
        $this->load->library('pagination');
        $config['base_url'] = base_url().'chamadas/gerenciar/';
        $config['total_rows'] = $this->chamadas_model->count('chamada');
        $config['per_page'] = 30;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 	

        */
	    $this->data['results'] = $this->chamadas_model->get_lista_chamadas(500,$this->uri->segment(3));

       	$this->data['view'] = 'chamadas/chamadas';
       	$this->load->view('tema/topo',$this->data);

    }

	
	function funcionarios(){
	    $this->data['results'] = $this->chamadas_model->getFuncionarios();
       	$this->data['view'] = 'chamadas/funcionarios';
       	$this->load->view('tema/topo',$this->data);
    }
    

	
    function adicionar() {
        /*
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar chamadas.');
           redirect(base_url());
        }*/

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('chamadas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
        	$chamada = $this->popularCadastroChamada(false);
        	$id_resposta = $chamada->salvar();


            // Gravar Itinerário automático
            if($this->input->post('gravar-itinerario'))
            {
                //$itinerario = $this->popularCadastroItinerario($id_resposta);
                //$chamada->salvar_itinerarios();
            }


           	if ($id_resposta == TRUE) {
//				$this->notify_app($id_resposta);

				# envia notificação por email do cliente
				$this->email_model->enviar_email("chamada", "operacional", $id_resposta, "adicionar");

				if ($chamada->getStatus() == 0) {
					//$result = file_get_contents($this->url_gcm_notification . "/notify_call_everybody/" . $chamada->getIdChamada() . "/0");
				}

                $this->session->set_flashdata('success','Chamada adicionada com sucesso!');
                redirect(base_url() .'chamadas/editar/' . $id_resposta);
               // redirect(base_url() . $this->permission->getIdPerfilAtual().'/chamadas/editar/' . $id_resposta);
            } else {
				$this->session->set_flashdata('error','Ocorreu um erro ao inserir chamada!');
				redirect(base_url($this->permission->getIdPerfilAtual().'/chamadas/adicionar'));
            }
        }
		

		//$this->data['resposta_app'] = $this->chamadas_model->get_chamada_app();
        $this->data['view'] = 'chamadas/adicionarChamada';
        $this->load->view('tema/topo', $this->data);

    }

    /*
	private function notify_app($idChamada) {
		$host = "http://".$_SERVER['HTTP_ORIGIN'];
		$path = "/gcm_comunication/v1/notify_call_everybody/".$idChamada."/0";

		$address = $host . $path;

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, $address);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curlSession);
		curl_close($curlSession);

//		return $response;
	}
    */

    private function popularCadastroItinerario($idChamada)
    {

    }
    
    private function popularCadastroChamada($soDadosEdicao) {
    	$chamada = new ChamadaExternaClass();

    	if ($soDadosEdicao) {
    		$idChamada = $this->input->post('idChamada');
    		$chamada->carregar($idChamada);
    		
    		$idFuncionarioAntigo = $chamada->getIdFuncionario();
    	}
    	
    	$idFuncionario = $this->input->post('idFuncionario');
    	$idEmpresa = $this->session->userdata('idEmpresa');
    	
    	$data_post = explode("/", $this->input->post('data'));
    	$dia = $data_post[2]."-".$data_post[1]."-".$data_post[0];
        //$dia = $this->input->post('data_post');

        #echo "<pre>";
        #print_r($this->input->post());

        #echo $dia;
        #die();
    	
    	$hora_repasse = $this->input->post('hora_repasse');
    	$tempo_espera = $this->input->post('tempo_espera');
    	$observacoes = $this->input->post('observacoes');
    	$status	  = $this->input->post('status');
    	
    
    	$chamada->setIdFuncionario($idFuncionario);
    	$chamada->setIdEmpresa($idEmpresa);
    	$chamada->setData($dia);
    	$chamada->setStatus($status);
    	$chamada->setHora_repasse($hora_repasse);
    	$chamada->setTempo_espera($tempo_espera);

		$chamada->setObservacoes($observacoes);

//     	$chamada->setTarifa(1);
    	if (!$soDadosEdicao) {
    		//$idCliente = $this->input->post('idCliente');
    		$tipoVeic = $this->input->post('tipo_veiculo');
    		$tarifa	  = $this->retornaTarifaPorHorario();
    		$hora	  = date("H:i:s");
    		$idAtendente = $this->input->post('idAtendente');
    		$solicitante = $this->input->post('solicitante');
    		
    	
    		//$chamada->setIdCliente($idCliente);
    		$chamada->setTipo_veiculo($tipoVeic);
    		$chamada->setTarifa($tarifa);
    		$chamada->setHora($hora);
    		$chamada->setIdAtendente($idAtendente);
    		$chamada->setSolicitante($solicitante);
    	
    		$servicos = $this->retornaServicosDaChamada($chamada);
    		$chamada->setServicos($servicos);

    	}
		//quando marcado checkbox de informar valor
		if ($this->input->post('alterar_valor')) {
			$valor_empresa = $this->input->post('valor_empresa');
			$valor_funcionario = $this->input->post('valor_funcionario');
			$chamada->setValor_empresa(conv_num_para_base($valor_empresa));
			$chamada->setValor_funcionario(conv_num_para_base($valor_funcionario));
		}
		//quando utilizado itinerário, lança valores cadastrados
		else if ($this->input->post('idClienteFreteItinerario') && $this->input->post('idClienteFreteItinerario') > 0) {
			$itinerario = $this->chamadaexterna_model->getItinerario($this->input->post('idClienteFreteItinerario'));

			if ($itinerario->valor_empresa > 0) {
				$chamada->setValor_empresa($itinerario->valor_empresa);
				$chamada->setValor_funcionario($itinerario->valor_funcionario);
			}
			else {
				$chamada->calculaValorChamada();
			}
		}
		//cálculo automático
    	else if ($this->input->post('calcula_automatico') || (!$soDadosEdicao && !$this->input->post('alterar_valor'))) {
//			if (!$this->input->post('idClienteFreteItinerario') || $this->input->post('idClienteFreteItinerario') == "") {
				$chamada->calculaValorChamada();
//			}
    	}

    	return $chamada;
    }
    
    private function retornaServicosDaChamada($chamada) {
    	$servicos = array();
    
    	if ($this->input->post('idClienteFreteItinerario') && $this->input->post('idClienteFreteItinerario') > 0) {
			$itinerario = $this->chamadaexterna_model->getItinerario($this->input->post('idClienteFreteItinerario'));
    		$itinerarioServicos = $this->chamadaexterna_model->getItinerarioServicos($this->input->post('idClienteFreteItinerario'));

			$chamadaServicoOrigem = new ChamadaServicoExternaClass($chamada);
    		for ( $i = 0; $i < count($itinerarioServicos); $i++ ) {
    
    			$tipoServico = $itinerarioServicos[$i]->tiposervico;
    			$endereco 	 = $itinerarioServicos[$i]->endereco;
    			$numero 	 = $itinerarioServicos[$i]->numero;
    			$bairro 	 = $itinerarioServicos[$i]->bairro;
    			$cidade		 = $itinerarioServicos[$i]->cidade;
    			$falarcom 	 = $_POST['cham_falarcom'][$i];
    
    			$chamadaServico = new ChamadaServicoExternaClass($chamada);
    			$chamadaServico->setTiposervico($tipoServico);
    			$chamadaServico->setEndereco($endereco);
    			$chamadaServico->setNumero($numero);
    			$chamadaServico->setBairro($bairro);
    			$chamadaServico->setCidade($cidade);
    			$chamadaServico->setFalarcom($falarcom);

				if ($i == 0) {
					$chamadaServicoOrigem = clone $chamadaServico;
					$chamadaServicoOrigem->setTiposervico(2);
				}
    			array_push($servicos, $chamadaServico);
    		}

			if ($itinerario->retorno) {
				array_push($servicos, $chamadaServicoOrigem);
			}
    	}
    	else {
    		$chamadaServicoOrigem = new ChamadaServicoExternaClass($chamada);
    
    		for ( $i = 0; $i < count($this->input->post('cham_tiposervico')); $i++ ) {
    
    			$tipoServico = ($i == 0) ? 0 : 1;
    			$endereco 	 = $this->input->post('cham_endereco')[$i];
    			$numero 	 = $this->input->post('cham_numero')[$i];
    			$bairro 	 = $this->input->post('cham_bairro')[$i];
    			$cidade		 = $this->input->post('cham_cidade')[$i];
    			$falarcom 	 = $this->input->post('cham_falarcom')[$i];
    			
    			$chamadaServico = new ChamadaServicoExternaClass($chamada);
    			$chamadaServico->setTiposervico($tipoServico);
    			$chamadaServico->setEndereco($endereco);
    			$chamadaServico->setNumero($numero);
    			$chamadaServico->setBairro($bairro);
    			$chamadaServico->setCidade($cidade);
    			$chamadaServico->setFalarcom($falarcom);
    
    			array_push($servicos, $chamadaServico);
    
    			if ($i == 0) $chamadaServicoOrigem = clone $chamadaServico;
    		}
    		/**
    		 * caso selecionado para retornar a origem, insere novamente o primeiro endere�o /origem
    		 */
    		if ($this->input->post('retornar-origem') == 'on') {
    			$chamadaServicoOrigem->setTiposervico(2);
    			array_push($servicos, $chamadaServicoOrigem);
    		}
    	}
    	
    	return $servicos;
    }

    private function retornaTarifaPorHorario() {    
    	$currentTime = strtotime(date("H:i:s"));    
    	$startTime = strtotime('8:00');    
    	$endTime = strtotime('18:00');    
    	$retorno = ($currentTime <= $endTime && $startTime <= $currentTime) ? 1 : 2;
       	return $retorno;
    }

    function editar() {
        /*
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar chamadas.');
           redirect(base_url());
        }
        */
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('chamadas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            #echo "<pre>";
            #print_r($this->input->post());
            #die();

        	$chamada = $this->popularCadastroChamada(true);
        	$id_resposta = $chamada->salvar();

        	if ($id_resposta == TRUE) {

				# envia notificação por email do cliente
				$this->email_model->enviar_email("chamada", "operacional", $this->input->post('idChamada'), "editar");

				$this->session->set_flashdata('success','Chamada editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/chamadas/editar/'.$chamada->getIdChamada());
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->chamadas_model->getById($this->uri->segment(3));
        $this->data['view'] = 'chamadas/adicionarChamada';
        $this->load->view('tema/topo', $this->data);

    }

/*
    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar chamadas.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->chamadas_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'chamadas/visualizar';
        $this->load->view('tema/topo', $this->data);

    }*/
	/*
    public function adicional($acao=null, $id=null){
		$dados = $_POST;
		
		$this->logs_modelclass->registrar_log_antes_update('chamada', 'idChamada', $this->input->post('idChamada'), 'Chamadas');
		if ($this->chamadas_model->edit('chamada', $dados, 'idChamada', $this->input->post('idChamada'))) {
			$this->logs_modelclass->registrar_log_depois();
		}
		$this->session->set_flashdata('success','Chamada editada com sucesso!');            
		redirect(base_url().$this->permission->getIdPerfilAtual().'/chamadas/');
    }
	
	
	*/
    public function excluir(){ //deixa nos pontos certos, metodos
/*
            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir chamadas.');
               redirect(base_url());
            }
*/
            $id =  $this->input->post('idChamada');
            

            

            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Chamada.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/chamadas/');
            }
            

            
            $servicos = $this->chamadas_model->getChamadaServicos($id);
            
            
            
            
            $this->logs_modelclass->registrar_log_antes_delete('chamada', 'idChamada', $id, 'Chamadas');
            if ($this->chamadas_model->delete('chamada','idChamada',$id)) {
            	$this->logs_modelclass->registrar_log_depois();
            	
            	
            	foreach ($servicos as $servico) {

            		$this->logs_modelclass->registrar_log_antes_delete('chamada_servico', 'idChamadaServico', $servico->idChamadaServico, 'Chamadas: Serviços');
            		
            		$this->chamadas_model->delete('chamada_servico', 'idChamadaServico', $servico->idChamadaServico);
            		
            		$this->logs_modelclass->registrar_log_depois();
            	}
            }
            
            $this->session->set_flashdata('success','Chamada excluída com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/chamadas/');
    }
	
    public function cancelar(){

        /*

            if(!$this->permission->canUpdate()){
               $this->session->set_flashdata('error','Você não tem permissão para cancelar chamadas.');
               redirect(base_url());
            }
*/
            $id =  $this->input->post('idChamada');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Chamada.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/chamadas/');
            }
			
            $this->logs_modelclass->registrar_log_antes_update('chamada', 'idChamada', $id, 'Chamadas (cancelar)');
            if ($retorno = $this->chamadas_model->cancelar($id)) {
            	$this->logs_modelclass->registrar_log_depois();
            }
            $this->session->set_flashdata('success','Chamada cancelada com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/chamadas/');
    }
	
	
    public function atualiza(){

		$this->data['results'] = $this->chamadas_model->getFuncionarios();
		
		
       	$this->data['view'] = 'chamadas/funcionarios_ajax'; 
       	$this->load->view('chamadas/funcionarios_ajax',$this->data);	
		
    }
	
	// Ajax para busca de dados auxiliares e descontinuação de mysql_connect na raiz
	public function ajax($metodo, $cod){
		switch($metodo){
			case 'endereco':
			$this->db->where('idCliente', $cod);
			$consulta = $this->db->get('cliente')->result();
			foreach($consulta as $valor){ 
				echo "{\"endereco\":\"{$valor->endereco}\",\"bairro\":\"{$valor->endereco_bairro}\",\"cidade\":\"{$valor->endereco_cidade}\",\"estado\":{$valor->endereco_estado},\"cep\":{$valor->endereco_cep},\"numero\":\"{$valor->endereco_numero}\",\"capital\":true}";
			}
			break;


            case 'bairro':
            $this->db->where('idCidade', $cod);
            $consulta = $this->db->get('bairro')->result();
            foreach($consulta as $valor){
                echo "<option value=".$valor->idBairro.">".$valor->bairro."</option>";
            }
            break;              

            case 'solicitante':
            $this->db->where('idCliente', $cod);
            $consulta = $this->db->get('cliente_responsaveis')->result();
            foreach($consulta as $valor){
                echo "<option value=".$valor->idClienteResponsavel.">".$valor->nome."</option>";
            }
            break;	
		}
	}	
	
	public function get_itinerarios_cliente_ajax() {
		$idCliente = $this->uri->segment(3);
		$itinerarios = $this->chamadas_model->getItinerarios($idCliente);
		
		echo json_encode($itinerarios);
	}
		
}
