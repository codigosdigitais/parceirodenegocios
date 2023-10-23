<?php
# RELATORIOS EXTENDS CONTROLLER #
class Relatorios extends MY_Controller {
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('relatorios_model','',TRUE);
			
			$this->data['lista_cedente'] = $this->relatorios_model->getListaCedentesBase(null);
			$this->data['listaCliente'] = $this->relatorios_model->getBase('cliente','razaosocial', 'razaosocial');
			$this->data['listaFuncionario'] = $this->relatorios_model->getBase('funcionario','nome', 'nome');
	}	
	
	function index(){
		$this->gerenciar();
	}

	# gerencia a pagina principal #
	function gerenciar(){
		$this->setControllerMenu('relatorios/contratos');
		
        if(!$this->permission->controllerManual('relatorios/contratos')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
       	$this->data['view'] = 'relatorios/relatorios';
       	$this->load->view('tema/topo',$this->data);
    }
	
	# gerencia contrato
	function contratos($tipo=null){
		$this->setControllerMenu('relatorios/contratos');
		
        if(!$this->permission->controllerManual('relatorios/contratos')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }

        if($tipo==true){
        	switch($tipo){
        		case 'faturamento':
        			$template = "relatorios/relatorio/contrato_listar";
        			$this->data['results'] = $this->relatorios_model->listar_contratos();
        		break;

        		case 'horarios':
        			$template = "relatorios/relatorio/contrato_listar_horarios";
        		break;
        	}

			$this->data['view'] = $template;
			$this->load->view('tema/topo',$this->data);

        } else {

			$this->data['view'] = "relatorios/relatorio/contrato";
			$this->load->view('tema/topo',$this->data);     

		} 

	}
	
	
	# gerencia credito e debito
	function creditodebito(){
		$this->setControllerMenu('relatorios/creditodebito');
		
        if(!$this->permission->controllerManual('relatorios/creditodebito')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios de Crédito de Débito.');
           redirect(base_url());
        }
		
		$this->data['view'] = 'relatorios/relatorio/creditodebito';
		$this->load->view('tema/topo',$this->data);
	}
	
	public function ajax($metodo=null, $id=null){
		if($metodo=='tipo'){
			$this->db->where("idParametroCategoria", $id);
			$retorno = $this->db->get('parametro')->result();
			echo "<option value=''>Selecione</option>";
			foreach($retorno as $valor){ echo "<option value='".$valor->idParametro."'>".$valor->parametro."</option>"; }
		}
		
		if($metodo=='idadministrativo'){
			if($id=='2'){
				$this->db->where("status", '0');
				$retorno_funcionario = $this->db->get('funcionario')->result();
				echo "<option value=''>Selecione</option>";
				foreach($retorno_funcionario as $valor_funcionario){ echo "<option value='".$valor_funcionario->idFuncionario."'>".$valor_funcionario->nome."</option>"; }
			}
			if($id=='1'){
				$this->db->where("status", '0');
				$retorno_cliente = $this->db->get('cliente')->result();
				echo "<option value=''>Selecione</option>";
				foreach($retorno_cliente as $valor_cliente){ echo "<option value='".$valor_cliente->idCliente."'>".$valor_cliente->razaosocial."</option>"; }
			}			
		}
	}
	
	function listarCreditoDebito(){
		$this->setControllerMenu('relatorios/creditodebito');
		
		if(!$this->permission->controllerManual('relatorios/creditodebito')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios de Crédito de Débito.');
           redirect(base_url());
        }
		
		$this->data['results'] = $this->relatorios_model->listar_creditodebito();
		$this->data['view'] = 'relatorios/relatorio/credito_listar';
		$this->load->view('tema/topo',$this->data);
	}	
	
	# gerencia chamada
	function chamada(){
		$this->setControllerMenu('relatorios/chamada');
		
		if(!$this->permission->controllerManual('relatorios/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['view'] = 'relatorios/relatorio/chamada';
		$this->load->view('tema/topo',$this->data);
	}
	
	function listarChamada(){
		$this->setControllerMenu('relatorios/chamada');
		
		if(!$this->permission->controllerManual('relatorios/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['results'] = $this->relatorios_model->listar_chamada();
		$this->data['view'] = 'relatorios/relatorio/chamada_listar';
		$this->load->view('tema/topo',$this->data);
	}

	# gerencia faltas
	function faltas(){
		$this->setControllerMenu('relatorios/faltas');
		
		if(!$this->permission->controllerManual('relatorios/faltas')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['listaCedente'] = $this->relatorios_model->getListaCedentesBase(null);
		$this->data['view'] = 'relatorios/relatorio/falta';
		$this->load->view('tema/topo',$this->data);
	}
	
	function listarFalta(){
		$this->setControllerMenu('relatorios/faltas');
		
		if(!$this->permission->controllerManual('relatorios/faltas')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['results'] = $this->relatorios_model->listar_falta();
		$this->data['view'] = 'relatorios/relatorio/falta_listar';
		$this->load->view('tema/topo',$this->data);
	}

	
	# gerencia substituicao
	function substituicoes(){
		$this->setControllerMenu('relatorios/substituicoes');
		
		if(!$this->permission->controllerManual('relatorios/substituicoes')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['listaCliente'] = $this->relatorios_model->getClienteContrato();
		$this->data['view'] = 'relatorios/relatorio/substituicoes';
		$this->load->view('tema/topo',$this->data);
	}
	
	function listarSubstituicoes(){
		$this->setControllerMenu('relatorios/substituicoes');
		
		if(!$this->permission->controllerManual('relatorios/substituicoes')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['listaCliente'] = $this->relatorios_model->getClienteContrato();
		$this->data['results'] = $this->relatorios_model->listar_substituicoes();
		$this->data['view'] = 'relatorios/relatorio/substituicoes_lista';
		$this->load->view('tema/topo',$this->data);
	}
	
	
	# Contratos
	function listarContrato($tipo=null){
		$this->setControllerMenu('relatorios/contratos');
		
		if(!$this->permission->controllerManual('relatorios/contratos')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['results'] = $this->relatorios_model->listar_contratos();	
		
		if(empty($tipo)){
			$this->data['view'] = 'relatorios/relatorio/contrato_listar';
		}
		echo $tipo;
		die();
		
		if(!empty($tipo)){
			
			foreach($_POST['campo'] as $valor){
				
				# Filtros por Status
				if($valor=="dados_faturamento"){
					$this->data['view'] = 'relatorios/relatorio/contrato_listar';
				}

				if($valor=="dados_faturamento_administrativo"){
					$this->data['view'] = 'relatorios/relatorio/contrato_listar_admin';
				}				
				
				if($valor=="dados_horarios"){
					$this->data['view'] = 'relatorios/relatorio/contrato_listar_horarios';
				}
			
			}
		}
		$this->load->view('tema/topo',$this->data);
	}	


	# Clientes
	function clientes(){
		$this->setControllerMenu('relatorios/clientes');
		
		if(!$this->permission->controllerManual('relatorios/clientes')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		$this->data['results'] = $this->relatorios_model->getBase('contrato','idContrato', 'idContrato');
		$this->data['listaCedente'] = $this->relatorios_model->getBase('cedente','idCedente', 'razaosocial');
		$this->data['listaFuncionario'] = $this->relatorios_model->getBase('funcionario','idFuncionario', 'nome');

       	$this->data['view'] = 'relatorios/relatorio/cliente';
       	$this->load->view('tema/topo',$this->data);
	}
	
	
	function listarCliente($tipo=null){

		$this->setControllerMenu('relatorios/clientes');
		
		if(!$this->permission->controllerManual('relatorios/clientes')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Relatórios.');
           redirect(base_url());
        }
		
		# No relatório de Clientes teremos 4 tipos de relatórios
		# 1: Ativo/Inativo (por cedente)

		if(empty($tipo)){
			$this->data['results'] = $this->relatorios_model->listar_clientes_status("situacao");
			$this->data['view'] = 'relatorios/relatorio/clientesListar';
		}
		
		if(!empty($tipo)){

			echo $tipo;
			
			foreach($_POST['campo'] as $valor){
				
				# Filtros por Status
				if($valor=="situacao"){
					$this->data['results'] = $this->relatorios_model->listar_clientes_status();
					$this->data['view'] = 'relatorios/relatorio/clientes_status';
				}
				
				# Filtros por Dados da Empresa
				if($valor=="dados_empresa"){
					$this->data['results'] = $this->relatorios_model->listar_clientes_dados_empresa();
					$this->data['view'] = 'relatorios/relatorio/clientes_dados_empresa';
				}

				# Filtros por Dados de Faturamento
				if($valor=="dados_faturamento"){
					$this->data['results'] = $this->relatorios_model->listar_clientes_dados_faturamento();
					$this->data['view'] = 'relatorios/relatorio/clientes_dados_faturamento';
				}
				
				# Filtros por Dados de Responsaveis
				if($valor=="contatos_empresa"){
					$this->data['results'] = $this->relatorios_model->listar_clientes_responsaveis();
					$this->data['view'] = 'relatorios/relatorio/clientes_responsaveis';
				}
				
				# Filtros por Dados de Frete
				if($valor=="dados_frete"){
					$this->data['results'] = $this->relatorios_model->listar_clientes_frete();
					$this->data['view'] = 'relatorios/relatorio/clientes_frete';
				}

			}
				
		}

		$this->load->view('tema/topo',$this->data);
	}	
	
	
}

