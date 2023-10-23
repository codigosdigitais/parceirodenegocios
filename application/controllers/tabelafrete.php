<?php

class TabelaFrete extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('tabelafrete_model','',TRUE);
			$this->data['cidades'] = $this->tabelafrete_model->getCidades();
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar tabelafrete.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'tabelafrete/gerenciar/';
        $config['total_rows'] = $this->tabelafrete_model->count('tabelafrete');
        $config['per_page'] = NULL;
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
		
		if(!$this->uri->segment(3)) $start = 0; else $start = $this->uri->segment(3);
        
        $this->pagination->initialize($config); 	
        
	    $this->data['results'] = $this->tabelafrete_model->get('tabelafrete','idTabelaFrete, idSaida, idDestino, pontoMoto, pontoCarro, pontoCaminhao, retornoMoto, retornoCarro','',$config['per_page'],$this->uri->segment(3));
		
       	$this->data['view'] = 'tabelafrete/tabelafrete';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
	function metropolitano($acao=null, $id=null){
		
		if($acao!= null and $id!= null){
			$view = "adicionarTabelaFreteMetropolitano"; 
		} else { 
			$view = "tabelafretemetropolitano";
		}
		

			
		$this->load->library('form_validation');
        if ($this->form_validation->run('tabelafretes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			$campo = array($_POST);
			$ind=0;
			foreach($campo as $valor){	
				foreach($valor['pon_pontoBase'] as $key=>$valor2){
					foreach($valor2 as $key3=>$valor3){
						if($valor['pon_pontoBase'][$key][$key3]){
							$novo_ponto[$ind]['idSaida'] = $valor['idCidade'];	
							$novo_ponto[$ind]['idDestino'] = $valor['hiddenDestino'][$key][$key3];//agora colocar ele no formulario - fui
							$idCidade = $valor['idCidade'];	
							$novo_ponto[$ind]['referencia'] = $key; // o nome dos campos não tem pon_
							$novo_ponto[$ind]['pontoBase'] = $valor['pon_pontoBase'][$key][$key3];						
							$novo_ponto[$ind]['pontoMoto'] = $valor['pon_pontoMoto'][$key][$key3];						
							$novo_ponto[$ind]['pontoCarro'] = $valor['pon_pontoCarro'][$key][$key3];						
							$novo_ponto[$ind]['pontoVan'] = $valor['pon_pontoVan'][$key][$key3];						
							$novo_ponto[$ind]['pontoCaminhao'] = $valor['pon_pontoCaminhao'][$key][$key3];						
							$novo_ponto[$ind]['retornoMoto'] = $valor['pon_retornoMoto'][$key][$key3];						
							$novo_ponto[$ind]['retornoCarro'] = $valor['pon_retornoCarro'][$key][$key3];						
							$novo_ponto[$ind]['retornoVan'] = $valor['pon_retornoVan'][$key][$key3];	
							$novo_ponto[$ind]['retornoCaminhao'] = $valor['pon_retornoCaminhao'][$key][$key3];	
							$ok = 1;
						}
						$ind++;
					}
				}
										
				
			}
			/**
			 * @autor Davi Daniel
			 * @date 17/12/2015
			 * 
			 * não implementado logs na remoção da tabela de fretes que acontece durante alteração
			 * o procedimento correto seria alterar os registros
			 * se salvar os logs desta tabela a cada edição vai encher o banco de dados de registros desnecssários, além
			 * de ser muito difícil compreender os dados removidos (que serão muitos, muitos)
			 */
			$this->tabelafrete_model->limpa_dados_anteriores($idCidade, 'tabelafretem');
			
			
			$ids = $this->tabelafrete_model->addTabelaFreteMetropolitano($novo_ponto);
			
			if ($ids) {
				//importante: armazena log de inserção juntamente com os dados inseridos (ultimo atributo = true)
				$this->logs_modelclass->registrar_log_insert ( 'tabelafretem', 'idTabelaFrete', json_encode($ids), 'Tabela Frete (em) (on edit)', true );
			}
			
			if ($ok == TRUE) {
				$this->session->set_flashdata('success','Tabela Frete editada com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafrete/metropolitano/editar/'.$this->input->post('idCidade'));
			} else {
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
			}
		}

		
		$this->data['result'] = $this->tabelafrete_model->getByIdMetropolitano($this->uri->segment(4));
		$this->data['results'] = $this->tabelafrete_model->getCidades();
		$this->data['cidadeAtual'] = $this->tabelafrete_model->getCidadesById($id);
		$this->data['view'] = "tabelafrete/{$view}";
       	$this->load->view('tema/topo',$this->data);
	}
	
    function adicionar() {
    	if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar Tabela Frete.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
        if ($this->form_validation->run('tabelafretes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$id = $this->tabelafrete_model->add('tabelafrete', $data);
            if ( $id ) {
            	//importante: armazena log de inserção juntamente com os dados inseridos (ultimo atributo = true)
            	$this->logs_modelclass->registrar_log_insert ( 'tabelafrete', 'idTabelaFrete', $id, 'Tabela Frete', true );
                $this->session->set_flashdata('success','Tabela Frete adicionada com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafrete/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'tabelafrete/adicionarTabelaFrete';
        $this->load->view('tema/topo', $this->data);

    }

    function editar($id_atual) {//vc nao criou outro modulo? criei uma fucao
    	if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar tabelafrete.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
		$this->data['bairroAtual'] = $this->tabelafrete_model->getBairrosById($id_atual);
		$this->data['listaBairrosAdd'] = $this->tabelafrete_model->getBairrosByIdCidade($this->data['bairroAtual']->idCidade);
        $this->data['custom_error'] = '';
		

        if ($this->form_validation->run('tabelafretes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

		
			$campo = array($_POST);
			foreach($campo as $valor){
				$novo_ponto = $valor;	
			}

			/**
			 * @autor Davi Daniel
			 * @date 17/12/2015
			 *
			 * não implementado logs na remoção da tabela de fretes que acontece durante alteração
			 * o procedimento correto seria alterar os registros
			 * se salvar os logs desta tabela a cada edição vai encher o banco de dados de registros desnecssários, além
			 * de ser muito difícil compreender os dados removidos (que serão muitos, muitos)
			 */
			#limpa dados anteriores
			$this->tabelafrete_model->limpa_dados_anteriores($novo_ponto['idBairroSaida'], 'tabelafrete');

				
			foreach($this->data['listaBairrosAdd'] as $valor){
				
				$i = $valor->idBairro;
			

				if($novo_ponto['pon_pontoMoto'][$i]==""){

				} else {
					$data['idSaida'] = $novo_ponto['idBairroSaida'];
					$data['idDestino'] = $i;
					$data['pontoBase'] = str_replace(",", ".", $novo_ponto['pon_pontoBase'][$i]);
					$data['pontoMoto'] = $novo_ponto['pon_pontoMoto'][$i];
					$data['pontoCarro'] = $novo_ponto['pon_pontoCarro'][$i];
					$data['pontoVan'] = $novo_ponto['pon_pontoVan'][$i];
					$data['pontoCaminhao'] = $novo_ponto['pon_pontoCaminhao'][$i];
					$data['retornoMoto'] = $novo_ponto['pon_retornoMoto'][$i];
					$data['retornoCarro'] = $novo_ponto['pon_retornoCarro'][$i];
					$data['retornoVan'] = $novo_ponto['pon_retornoVan'][$i];
					$data['retornoCaminhao'] = $novo_ponto['pon_retornoCaminhao'][$i];
					$ok = 1;
					
					$id = $this->tabelafrete_model->addTabelaFrete($data);
					if ($id) {
						//importante: armazena log de inserção juntamente com os dados inseridos (ultimo atributo = true)
						$this->logs_modelclass->registrar_log_insert ( 'tabelafrete', 'idTabelaFrete', $id, 'Tabela Frete (on edit)', true );
					}
					
				}
			}
			
            if ($ok == TRUE) {
                $this->session->set_flashdata('success','Tabela Frete editada com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/tabelafrete/editar/'.$this->input->post('idBairroSaida'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->tabelafrete_model->getById($this->uri->segment(3));
		$this->data['view'] = 'tabelafrete/adicionarTabelaFrete';
        $this->load->view('tema/topo', $this->data);

    }


    public function excluir(){

    		if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Tabela Frete.');
               redirect(base_url());
            }
            
            $id =  $this->input->post('idTabelaFrete');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Tabela Frete.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/tabelafrete/gerenciar/');
            }

            $this->logs_modelclass->registrar_log_antes_delete ( 'tabelafrete', 'idTabelaFrete', $id, 'Tabela Frete' );
            if ($this->tabelafrete_model->delete('tabelafrete','idTabelaFrete',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }

            $this->session->set_flashdata('success','Tabela Frete excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/tabelafrete/gerenciar/');
    }
}

