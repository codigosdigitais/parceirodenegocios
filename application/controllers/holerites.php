<?php
# HOLERITES EXTENDS CONTROLLER #
class Holerites extends MY_Controller
{
    
    # CLASSE HOLERITE #
    public function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('entrega/login');
        }
        //$this->load->library('database');
        $this->load->helper(array('codegen_helper'));
        $this->load->model('holerites_model', '', true);
    }
    
    // public function index()
    // {
    //     $this->gerenciar();
    // }

    # gerencia a pagina principal #
    public function index($data_inicial=null)
    {
        if (!$this->permission->canInsert()) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar holerites.');
            redirect(base_url());
        }

        $ciclo_atual = (!isset($data_inicial)) ? date("Y-m-d", strtotime('-2 months')) : date("Y-m-d", strtotime($data_inicial));
        $metodo = (!isset($data_inicial)) ? 'lista' : 'troca';
        
        $this->data['listagem_holerite'] = $this->holerites_model->listaHolerite($this->get_ciclo_atual($ciclo_atual), $metodo);
        $this->data['ciclo_atual'] = $this->get_ciclo_atual($ciclo_atual);
        $this->data['ciclo_lista'] = $this->monta_ciclo();
        $this->data['view'] = 'holerites/holerites';
        
        $this->load->view('tema/topo', $this->data);
    }
    
    # gerar holerite  base #
    # Modificação - inclusão do ciclo mensal, para fechamento de 21 a 20 automatico
    public function gerar($idFuncionario=null, $data_inicial=null, $data_final=null)
    {
        $datas_ciclo_selecionado = array($data_inicial, $data_final);
        
        $ciclo_atual = date('Y-m-d', strtotime('-2 months'));
        $this->data['dados'] = $this->holerites_model->getDados($idFuncionario, $this->get_ciclo_atual($ciclo_atual), $datas_ciclo_selecionado);
        $this->data['ciclo'] = $this->get_ciclo_atual($ciclo_atual);
        $this->data['view'] = 'holerites/holerites_gerar';
        $this->load->view('tema/topo', $this->data);
    }


    public function imprimir($idFuncionario=null, $data_inicial=null, $data_final=null)
    {
        $datas_ciclo_selecionado = array($data_inicial, $data_final);
        $ciclo_atual = date('Y-m-d', strtotime('-2 months'));
        $this->data['dados'] = $this->holerites_model->getDados($idFuncionario, $this->get_ciclo_atual($ciclo_atual), $datas_ciclo_selecionado);
        $this->data['ciclo'] = $this->get_ciclo_atual($ciclo_atual);
        $this->data['view'] = 'holerites/holerites_gerar_impressao';
        $this->setPDF($this->data['view'], $this->data);


        #$this->load->view('tema/topo',$this->data);
    }

    /* Confirmar Holerite - Salvar */
    public function confirmar_holerite()
    {
        $dados['idFuncionario'] 	= $this->input->post('idFuncionario');
        $dados['ciclo_1'] 			= $this->input->post('ciclo_1');
        $dados['ciclo_2'] 			= $this->input->post('ciclo_2');
        $dados['bruto'] 			= $this->input->post("vencimentos"); // total sem descontos
        $dados['desconto'] 			= $this->input->post("descontos"); // valor do desconto total
        $dados['liquido'] 			= $this->input->post("liquido"); // valor a receber


        if ($this->db->insert('folhapagamento_holerite', $dados)) {
            echo "confirmado";
        } else {
            echo "erro";
        }
    }
}
