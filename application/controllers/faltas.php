<?php

class faltas extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('faltas_model','',TRUE);
			$this->data['listaFuncionario'] = $this->faltas_model->getBase('funcionario', 'nome', 'ASC');
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar faltas.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'faltas/gerenciar/';
        $config['total_rows'] = $this->faltas_model->count('falta');
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
        
	   $this->data['results'] = $this->faltas_model->get('falta','idFalta','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'faltas/faltas';
       	$this->load->view('tema/topo',$this->data);
    }


	function pesquisar(){
		
        $this->load->library('table');
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'descontos/gerenciar/';
        $config['total_rows'] = count($this->faltas_model->getPesquisar());
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

		$this->data['results'] = $this->faltas_model->getPesquisar();
       	$this->data['view'] = 'faltas/faltas';
       	$this->load->view('tema/topo',$this->data);
	}


	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar faltas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('faltas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			# Buscar Atividade Excercida / Carga horária (dia/hora)
			//$funcionario['dados'] = $this->faltas_model->getFuncionarioAtividade($this->input->post('idFuncionarioLista'));
			
			

			
			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
				$data['idFuncionario'] = $this->input->post('idFuncionarioLista');
				unset($data['idFuncionarioLista']);
			}
			
			
			$id = $this->faltas_model->add('falta', $data);
			
            if ($id) {
            	$this->logs_modelclass->registrar_log_insert('falta', 'idFalta', $id, 'Falta');
                $this->session->set_flashdata('success','Registro adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/faltas/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'faltas/adicionarFalta';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar faltas.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('faltas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
				$data['idFuncionario'] = $this->input->post('idFuncionarioLista');
				unset($data['idFuncionarioLista']);
			}
			
			$this->logs_modelclass->registrar_log_antes_update('falta', 'idFalta', $this->input->post('idFalta'), 'Falta');
            if ($this->faltas_model->edit('falta', $data, 'idFalta', $this->input->post('idFalta')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Falta editada com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/faltas/editar/'.$this->input->post('idFalta'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/faltas/');
            }
        }
		// tabela, campo, id, requisitado, tipo (unico, lista)
		$this->data['lista_justificativa'] = $this->faltas_model->getRegistrosParametros('parametro', 'idParametro', '', $this->faltas_model->getRegistrosParametros('falta', 'idFalta', 'idTipo', $this->uri->segment(3), 'unico'), 'lista');
		$this->data['lista_cedente'] = $this->faltas_model->getBase('cedente', 'razaosocial', 'ASC');
		$this->data['lista_funcionario'] = $this->faltas_model->getRegistrosFuncionarios($this->faltas_model->getRegistrosParametros('falta', 'idFalta', 'idCedente', $this->uri->segment(3), 'unico'));
		
        $this->data['result'] = $this->faltas_model->getById($this->uri->segment(3));
        $this->data['view'] = 'faltas/adicionarFalta';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar faltas.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->faltas_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'faltas/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir faltas.');
               redirect(base_url());
            }
			
            $id =  $this->input->post('idFalta');
            
            $this->logs_modelclass->registrar_log_antes_delete('falta', 'idFalta', $id, 'Falta');
            
            if ($this->faltas_model->delete('falta','idFalta',$id)) { 
            	$this->logs_modelclass->registrar_log_depois();
	            $this->session->set_flashdata('success','Falta excluida com sucesso!');            
	            redirect(base_url().$this->permission->getIdPerfilAtual().'/faltas/gerenciar/');
            }

            $this->session->set_flashdata('error','Erro ao tentar excluir Falta.');
            redirect(base_url().$this->permission->getIdPerfilAtual().'/faltas/gerenciar/');
    }
	
	/* AJAX COMPONENTE FALTAS */
	function ajax($parametro, $cod = null){
	
			/*
			$PesquisaArr = strripos($cod, "-");
			if($PesquisaArr==TRUE)
			{
				$getArr = explode("-", $cod);
				for($i=0; $i<=count($getArr); $i++){
					if(isset($getArr[$i])){
						$this->db->where('idParametroCategoria', $getArr[$i]);
						$this->db->order_by('codigoeSocial', 'ASC');
						$consulta = $this->db->get('parametro')->result();
						//echo "<option value=''>Selecione uma Justificativa</option>";	
						foreach($consulta as $valor){ echo "<option>".$valor->codigoeSocial." - ".$valor->parametro."</option>"; }	
					}
				}
					
			}*/
		
			
		
			switch($parametro){
				case 'parametro':
				$this->db->where('idParametroCategoria', $cod);
				$this->db->order_by('codigoeSocial', 'ASC');
				$consulta = $this->db->get('parametro')->result();
				echo "<option value=''>Selecione uma Justificativa</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idParametro."'>".$valor->codigoeSocial." - ".$valor->parametro."</option>"; }		
				break;
				
				case 'empresaregistro':
				
				$consulta = $this->faltas_model->getListaCedentesBase(null);
				echo "<option value=''>Selecione Empresa Registro</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idCedente."'>".$valor->razaosocial."</option>"; }		
				break;
				
				case 'funcionario':
				$this->db->where('empresaregistro', $cod);
				$this->db->group_by('idFuncionario');
				$consulta = $this->db->get('funcionario_dadosregistro')->result();
				echo "<option value=''>Todos os Funcionários</option>";
				
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

	
	
	
	
	
}

