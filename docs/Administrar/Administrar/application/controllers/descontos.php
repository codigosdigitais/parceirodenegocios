<?php

class Descontos extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('descontos_model','',TRUE);
            $this->data['menuLancamentos'] = 'desconto';
			$this->data['parametroDesconto'] = $this->descontos_model->getParametroById(819);
			$this->data['listaFuncionario'] = $this->descontos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
			$this->data['lista_cedente'] = $this->descontos_model->getListaCedentesBase();
			$this->data['listaCliente'] = $this->descontos_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(4));
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar descontos.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'descontos/gerenciar/';
        $config['total_rows'] = $this->descontos_model->count('desconto');
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
        
	    $this->data['results'] = $this->descontos_model->get('desconto','idDesconto, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'descontos/descontos';
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
				$this->db->order_by('razaosocial', 'ASC');
				$consulta = $this->db->get('cedente')->result();
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
	
	function pesquisar(){
		
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'descontos/gerenciar/';
        $config['total_rows'] = $this->descontos_model->count('desconto');
        $config['per_page'] = 500;
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

		
		
		
		$this->data['results'] = $this->descontos_model->getPesquisar();
       	$this->data['view'] = 'descontos/descontosLista';
       	$this->load->view('tema/topo',$this->data);
	}
	
	
	function lista($editar=NULL, $id=NULL, $alterando=NULL){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->library('table');
        $this->load->library('pagination');
   
        $config['base_url'] = base_url().'descontos/lista/';
        $config['total_rows'] = $this->descontos_model->count('desconto');
        $config['per_page'] = 50;
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
		
		$PaginaAtual = $this->router->method;
		
		if($PaginaAtual=='lista' and $this->uri->segment(3)!='editar'){ 
			$this->data['results'] = $this->descontos_model->get('desconto','idDesconto, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
			$this->data['view'] = "descontos/descontosLista";
		} elseif($this->uri->segment(3)=='editar') {
			$this->data['result'] = $this->descontos_model->getByid($this->uri->segment(4));
			$this->data['view'] = "descontos/editarDesconto";
		}
				
        $this->load->view('tema/topo', $this->data);
		
		if(!empty($alterando)){
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$this->logs_modelclass->registrar_log_antes_update ( 'desconto', 'idDesconto', $this->input->post ( 'idDesconto' ), 'Descontos' );
            if ($this->descontos_model->edit('desconto', $data, 'idDesconto', $this->input->post('idDesconto')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Desconto editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/descontos/lista/');
            }
		}
	}
	
    function adicionar($idParametro=null, $conferir=null, $adicionar=null) {
		

    	if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar descontos.');
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
				
				$id = $this->descontos_model->add('desconto', $data);
				if ( $id ) {
					$this->logs_modelclass->registrar_log_insert ( 'desconto', 'idDesconto', $id, 'Descontos' );
					$this->session->set_flashdata('success','Desconto adicionado com sucesso!');
					redirect(base_url() . $this->permission->getIdPerfilAtual().'/descontos/lista');
				} else {
					$this->session->set_flashdata('success','Desconto adicionado com sucesso!');
					redirect(base_url() . $this->permission->getIdPerfilAtual().'/descontos/lista');
				}
			
			}
       
		$this->data['parametro_selecionado'] = $this->descontos_model->tipo_parametro($this->uri->segment(3));
		$this->data['lista_funcionario'] = $this->descontos_model->lista_funcionario($this->input->post('idFuncionarioLista'));

		if(empty($conferir)){ 
			$this->data['view'] = "descontos/adicionarDesconto";
		} else {
			$this->data['view'] = "descontos/adicionarDescontoConferido";
		}
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
    	if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar descontos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('descontos') == false) {
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
			
			$this->logs_modelclass->registrar_log_antes_update ( 'desconto', 'idDesconto', $this->input->post ( 'idDesconto' ), 'Descontos' );
            if ($this->descontos_model->edit('desconto', $data, 'idDesconto', $this->input->post('idDesconto')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Desconto editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/descontos/editar/'.$this->input->post('idDesconto'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->descontos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'descontos/adicionardesconto';
        $this->load->view('tema/topo', $this->data);

    }
	


    public function visualizar(){

    	if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar descontos.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->descontos_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'descontos/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
	
    public function excluir(){

    	if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir descontos.');
               redirect(base_url());
            }

            $id =  $this->input->post('idDesconto');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir desconto.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/descontos/lista');
            }
			
            $this->logs_modelclass->registrar_log_antes_delete ( 'desconto', 'idDesconto', $id, 'Descontos' );
            if ($this->descontos_model->delete('desconto','idDesconto',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }
            $this->session->set_flashdata('success','Desconto excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/descontos/lista');
    }
	

}

