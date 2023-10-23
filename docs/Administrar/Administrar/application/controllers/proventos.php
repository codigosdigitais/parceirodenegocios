<?php

class Proventos extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('proventos_model','',TRUE);
            $this->data['menuLancamentos'] = 'provento';
			$this->data['parametroProvento'] = $this->proventos_model->getParametroById(518);
			$this->data['listaFuncionario'] = $this->proventos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
			$this->data['lista_cedente'] = $this->proventos_model->getListaCedentesBase(null);
	}
	
	function pesquisar(){
		
        $this->load->library('table');
        //$this->load->library('pagination');
        
   /*
        $config['base_url'] = base_url().'proventos/pesquisar/';
        $config['total_rows'] = $this->proventos_model->count('provento');
        $config['per_page'] = 100;
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
        $limit = 100;
		$this->data['limitePesquisa'] = $limit;
		$this->data['results'] = $this->proventos_model->getPesquisar($limit);
       	$this->data['view'] = 'proventos/proventosLista';
       	$this->load->view('tema/topo',$this->data);
	}
	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar proventos.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'proventos/gerenciar/';
        $config['total_rows'] = $this->proventos_model->count('provento');
        $config['per_page'] = 10;
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
        
	    $this->data['results'] = $this->proventos_model->get('provento','idProvento, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'proventos/proventos';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
	function ajax($parametro, $cod){
		
			switch($parametro){
				case 'parametro':
				$this->db->where('idParametroCategoria', $cod);
				$this->db->order_by('codigoeSocial', 'ASC');
				$consulta = $this->db->get('parametro')->result();
				echo "<option value=''>Selecione um Parâmetro</option>";	
				foreach($consulta as $valor){ echo "<option>".$valor->codigoeSocial." - ".$valor->parametro."</option>"; }		
				break;
				
				case 'empresaregistro':
				//$this->db->order_by('razaosocial', 'ASC');
				//$consulta = $this->db->get('cedente')->result();
				
				$consulta = $this->proventos_model->getListaCedentesBase(null);
					
				echo "<option value=''>Selecione Empresa Registro</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idCedente."'>".$valor->razaosocial."</option>"; }		
				break;
				
				case 'funcionario':
				$this->db->where('empresaregistro', $cod);
				$this->db->group_by('idFuncionario');
				$consulta = $this->db->get('funcionario_dadosregistro')->result();
				
					echo "<option value='all'>Todos os Funcionários</option>";
					foreach($consulta as $valor){
						$this->db->select('nome, idFuncionario');
						$this->db->where('idFuncionario', $valor->idFuncionario);
						$this->db->where('situacao', 1);
						$this->db->order_by('nome', 'ASC');
						$valor->getFuncionarios = $this->db->get('funcionario')->result();
						
						foreach($valor->getFuncionarios as $valor_funcionario){
							echo "<option value='".$valor_funcionario->idFuncionario."'>".$valor_funcionario->nome."</option>";
						}
					}
				break;
				
			}
			
	}
	
	
	function lista($editar=NULL, $id=NULL, $alterando=NULL){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->library('table');
        $this->load->library('pagination');
   
        $config['base_url'] = base_url().'proventos/lista/';
        $config['total_rows'] = $this->proventos_model->count();
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
		//die('aa'.$config['total_rows']);
		$PaginaAtual = $this->router->method;
		
		if($PaginaAtual=='lista' and $this->uri->segment(3)!='editar'){ 
			$this->data['results'] = $this->proventos_model->get('provento','idProvento, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
			$this->data['view'] = "proventos/proventosLista";
		} elseif($this->uri->segment(3)=='editar') {
			$this->data['result'] = $this->proventos_model->getByid($this->uri->segment(4));
			$this->data['view'] = "proventos/editarProvento";
		}
				
        $this->load->view('tema/topo', $this->data);
		
		if(!empty($alterando)){
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			$this->logs_modelclass->registrar_log_antes_update ( 'provento', 'idProvento', $this->input->post ( 'idProvento' ), 'Proventos' );
            if ($this->proventos_model->edit('provento', $data, 'idProvento', $this->input->post('idProvento')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Provento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/proventos/lista/');
            }
		}
	}
	
    function adicionar($idParametro=null, $conferir=null, $adicionar=null) {
		

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar proventos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

			if(!empty($adicionar)){

				// adiciona campos criados dinamicamentes para inserção de conteudos
				$campos = array($_POST['campo']);
				foreach($campos as $valor){
					$data = $valor;
				}
				//var_dump($data); die();
				$id = $this->proventos_model->add('provento', $data);
				if ( $id ) {
					$this->logs_modelclass->registrar_log_insert ( 'provento', 'idProvento', $id, 'Proventos' );
					$this->session->set_flashdata('success','Provento adicionado com sucesso!');
					redirect(base_url() . $this->permission->getIdPerfilAtual().'/proventos/lista');
				} else {
					$this->session->set_flashdata('success','Provento adicionado com sucesso!');
					redirect(base_url() . $this->permission->getIdPerfilAtual().'/proventos/lista');
				}
			
			}
       
		$this->data['parametro_selecionado'] = $this->proventos_model->tipo_parametro($this->uri->segment(3));
		$this->data['lista_funcionario'] = $this->proventos_model->lista_funcionario($this->input->post('idFuncionarioLista'));

		if(empty($conferir)){ 
			$this->data['view'] = "proventos/adicionarProvento";
		} else {
			$this->data['view'] = "proventos/adicionarProventoConferido";
		}
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar proventos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('proventos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$date = $this->input->post('data');
			$date = str_replace('/', '-', $date);
			$data['data'] = date('Y-m-d', strtotime($date));
			
			$this->logs_modelclass->registrar_log_antes_update ( 'provento', 'idProvento', $this->input->post ( 'idProvento' ), 'Proventos' );
            if ($this->proventos_model->edit('provento', $data, 'idProvento', $this->input->post('idProvento')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Provento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/proventos/editar/'.$this->input->post('idProvento'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->proventos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'proventos/adicionarprovento';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar proventos.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->proventos_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'proventos/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir proventos.');
               redirect(base_url());
            }

            $id =  $this->input->post('idProvento');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir provento.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/proventos/lista');
            }

            $this->logs_modelclass->registrar_log_antes_delete ( 'provento', 'idProvento', $id, 'Proventos' );
            if ($this->proventos_model->delete('provento','idProvento',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }
            $this->session->set_flashdata('success','Provento excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/proventos/lista');
    }
	

}

