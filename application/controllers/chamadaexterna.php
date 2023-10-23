<?php
/*
* @autor: Davi Siepmann
* @date: 21/11/2015

* @modify: André Baill
* @date: 15/10/2020
# @Atualização: 09/12/2020
* @description: Alterado status do cadastro de 10 para 1.
*/

include_once(dirname(__FILE__) . "/global_functions_helper.php");
include_once(dirname(__FILE__) . "/classes/ChamadaExternaClass.php");
include_once(dirname(__FILE__) . "/classes/ChamadaServicoExternaClass.php");
include_once(dirname(__FILE__) . "/classes/ClienteClass.php");
include_once(dirname(__FILE__) . "/classes/UsuarioClass.php");
include_once(dirname(__FILE__) . "/classes/CORS_HEADERS.php");

// Iniciando Mercado Pago
require APPPATH . "../vendor/autoload.php";

// Use Cielo
use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;




class chamadaexterna extends MY_Controller
{

    private $validation_errors;
    private $url_gcm_notification = "http://localhost/gcm_comunication/v1";

    function __construct()
    {

        parent::__construct();
        //verifica login
        //if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');
        date_default_timezone_set('America/Sao_Paulo');

        $whitelist = array(
            '127.0.0.1',
            '::1',
            'localhost'
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            $this->url_gcm_notification = "http://localhost/gcm_comunication/v1";
        }
        else {
            $this->url_gcm_notification = "http://parceirodenegocios.com/gcm_comunication/v1";
        }

        // Se o sandbox estar ativo, libera Token Sandbox, se não Production 
        if($this->config->config['sandbox_mode']==TRUE){
            $AccessToken = $this->config->config['sandbox_token'];
        } else {
            $AccessToken = $this->config->config['production_token'];
        }
        MercadoPago\SDK::setAccessToken($AccessToken);

        $this->load->helper(array('codegen_helper'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('chamadas_model', '', TRUE);
        $this->load->model('chamadaexterna_model', '', TRUE);
        $this->load->model('clienteexterno_model', '', TRUE);
        $this->load->model('documentos_model', '', TRUE);
        $this->load->model('usuarioexterno_model', '', TRUE);

        $this->data['menu'] = 'operacional';
        $this->data['modulosBase'] = $this->chamadas_model->getModulosCategoria();
    }


    /*
     * @autor: Davi Siepmann
     * @date: 22/11/2015
    */

    public function index()
    {

        $this->session->unset_userdata('idEmpresaWebsite');
        if ($this->permission->canSelect()) {

            $this->data['cidades'] = $this->chamadaexterna_model->buscarCidadesSistema();
            $this->data['clientes'] = $this->chamadaexterna_model->getClientes($this->session->userdata('idAcessoExterno'));
            $this->data['funcionarios'] = $this->chamadaexterna_model->getFuncionarios($this->session->userdata('idFuncionario'));

            $this->data['propaganda'] = $this->documentos_model->get('documento', null, null, 'propaganda', 500, null, 1);

            $this->data['view'] = 'chamadas/externo/chamadaexterna';
            $this->load->view('tema/topo', $this->data);

        } else redirect('entrega/login');

    }

    public function atualizar_valor_funcionario()
    {
        $idChamada = $this->uri->segment(3);

        if (is_numeric($idChamada)) {

            $chamada = new ChamadaExternaClass();
            $chamada->carregar($idChamada);

            $chamada->calculaValorChamada(true);
            $chamada->salvar();

            echo "1";
        } else {
            echo "0";
        }
    }


    /*
     * @autor: Davi Siepmann
     * @date: 23/11/2015
    */

    public function getboxchamado()
    {
        //$this->permission->setIdPerfil(101);
        /*
        $cors = new Cors_headers();
        $cors->_PRINT_CORS_HEADERS(NULL);
        */

        $clientKey = $this->uri->segment(3);
        $clientId = $this->clienteexterno_model->verifyClientKeyGetIdParaChamadaExterna($clientKey);

        if ($clientId) {

            $this->session->set_userdata(array('idEmpresaWebsite' => $clientId));
            $this->data['cidades'] = $this->chamadaexterna_model->buscarCidadesSistema();
            $this->data['idEmpresaWebsite'] = $clientId;
            $this->data['clientKey'] = $clientKey;

            //temporário - testar layout
            //$this->data['layout']             = 3;

            $this->load->view('chamadas/externo/chamadaexterna');
        } else {
            echo "A chave utilizada não pode ser verificada. Favor entrar em contato conosco. SYS_Integration(chamadaexterna)";
        }
    }

    private function registraSessaoCriaCors()
    {
       if ($this->input->post('clientKey')) {
            $clientId = $this->clienteexterno_model->verifyClientKeyGetIdParaChamadaExterna($this->input->post('clientKey'));
            $this->session->set_userdata(array('idEmpresaWebsite' => $clientId));
            $cors = new Cors_headers();
            $cors->_PRINT_CORS_HEADERS(NULL);
        }
    }

    /*
    * @autor: André Baill
    * @date: 19/10/2020
    * @description: mostrando formulário com resumo da chamada e valor do pagamento
    * formulário de pagamento 
    */

    public function paymentchamada($id_chamada=null){

        $chamado['detalhes'] = $this->chamadaexterna_model->getChamada($id_chamada);
        $chamado['servicos'] = $this->chamadaexterna_model->getChamadaServicos($id_chamada);

        if($chamado['detalhes'] && $chamado['servicos']){

            $chamado['pagamento'] = $this->chamadaexterna_model->getPagamentoByIdChamada($id_chamada);
           
            $this->load->vars($chamado);
            $this->load->view("chamadas/externo/chamadaexterna_pagamento", $chamado);

        } else {
            echo "Chamado não localizado.";
        }
    }

    // Cielo - crédito e débito
    public function paymentprocess(){

        // Verificação de Token
        if($this->config->config['sandbox_mode']==TRUE){
            $merchantID = $this->config->config['sandbox_merchant_id'];
            $merchantKEY = $this->config->config['sandbox_merchant_key'];
            $environmentSBPD = Environment::sandbox();
        } else {
            $merchantID = $this->config->config['production_merchant_id'];
            $merchantKEY = $this->config->config['production_merchant_key'];
            $environmentSBPD = Environment::production();
        }

        // Tipo de Cartão a ser Processado
        $typeCard = $this->input->post('typeCard');

        // Configure o ambiente
        $environment = $environmentSBPD;

        // Configure seu merchant
        $merchant = new Merchant($merchantID, $merchantKEY);

        // Crie uma instância de Sale informando o ID do pedido na loja
        $sale = new Sale(date("dHmiys"));

        // Crie uma instância de Customer informando o nome do cliente
        $customer = $sale->customer($this->input->post('cardholderName'));

        // Crie uma instância de Payment informando o valor do pagamento
        $payment = $sale->payment($this->input->post('transactionAmount'));
        $payment = $payment->setInstallments($this->input->post('installments'));

        // definição do valor 
        $valor = $this->input->post('transactionAmount');

        // Definição das Bandeiras Aceitas
        if($this->input->post('paymentMethodId')=='visa'){
            $creditCardBrand = CreditCard::VISA;
        } 

        if($this->input->post('paymentMethodId')=='master'){
            $creditCardBrand = CreditCard::MASTERCARD;
        } 

        if($this->input->post('paymentMethodId')=='amex'){
            $creditCardBrand = CreditCard::AMEX;
        } 

        // Crie uma instância de Credit Card utilizando os dados de teste
        // Esses dados estão disponíveis no manual de integração

        if( $this->input->post('cardExpirationMonth') <=9){
            $month = '0'. $this->input->post('cardExpirationMonth');
        } else {
            $month =  $this->input->post('cardExpirationMonth');
        }

        // Definições para cartão de crédito
        if($typeCard=='credito'){

            $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                    ->creditCard($this->input->post('securityCode'), $creditCardBrand)
                    ->setExpirationDate($month."/".$this->input->post('cardExpirationYear'))
                    ->setCardNumber(str_replace(" ", "", $this->input->post('cardNumber')))
                    ->setHolder($this->input->post('cardholderName'));

        // Definições para cartão de débito
        } else {

            // após a autenticação do cartão
            $payment->setReturnUrl(base_url('chamadaexterna/paymentchamada')."/".$this->input->post('chamada-idChamada'));

            $payment->debitCard($this->input->post('securityCode'), $creditCardBrand)
                    ->setExpirationDate($month."/".$this->input->post('cardExpirationYear'))
                    ->setCardNumber(str_replace(" ", "", $this->input->post('cardNumber')))
                    ->setHolder($this->input->post('cardholderName'));
        }

        // Crie o pagamento na Cielo
        try {
            // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

            // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
            // dados retornados pela Cielo
            $paymentId                  = $sale->getPayment()->getPaymentId();
            $paymentTid                 = ($sale->getPayment()->getTid()=='') ? '0' : $sale->getPayment()->getTid();
            $paymentAuthorizationCode   = ($sale->getPayment()->getAuthorizationCode()=='') ? '0' : $sale->getPayment()->getAuthorizationCode();
            $paymentReturnCode          = ($sale->getPayment()->getReturnCode()=='') ? '0' : $sale->getPayment()->getReturnCode();
            $paymentReturnMessage       = ($sale->getPayment()->getReturnMessage()=='') ? '0' : $sale->getPayment()->getReturnMessage();
            $paymentBrand               = $creditCardBrand;
            $paymentNameHolder          = $this->input->post('cardholderName');
            $paymentCardNumber          = str_replace(" ", "", $this->input->post('cardNumber')); 
            $paymentCardCvv             = $this->input->post('securityCode'); 
            $paymentExpirationDate      = $month."/".$this->input->post('cardExpirationYear');
            $paymentAmount              = $this->input->post('transactionAmount');
            $paymentParc                = $this->input->post('installments');

            // Registro do Pagamento no Banco de Dados
            $data['paymentCode'] = $paymentId;
            $data['token'] = $paymentId;
            $data['idChamada'] = (int)$this->input->post('chamada-idChamada');
            $data['cardType'] = ($typeCard=='credito') ? 'CREDITO' : 'DEBITO';
            $data['tid'] = $paymentTid;
            $data['nsu'] = $paymentAuthorizationCode;
            $data['paymentMethodId'] = $paymentBrand;
            $data['status'] = $paymentReturnCode;
            $data['statusDetail'] = $paymentReturnMessage;
            $data['cardName'] = $paymentNameHolder;
            $data['cardNumber'] = $paymentCardNumber;
            $data['securityCode'] = $paymentCardCvv;
            $data['cardExpirationMonth'] = $month;
            $data['cardExpirationYear'] = $this->input->post('cardExpirationYear');
            $data['installments'] = $paymentParc;

            $this->db->insert('chamada_pagamento', $data);

            // Atualização da Tabela de Chamada. statusPayment = 1 (pago) e 0 (em aberto)
            if($paymentReturnMessage=="Transacao autorizada" || $paymentReturnMessage=="Operation Successful"){
                $upt['statusPayment'] = '1'; // PAGO !!
                $this->db->where('idChamada', $this->input->post('chamada-idChamada'));
                $this->db->update('chamada', $upt);
            }


            // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
            $sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, $valor, 0);

            // Debito
            if($cardType=='debito'){
                $authenticationUrl = $sale->getPayment()->getAuthenticationUrl();
            }

            // E também podemos fazer seu cancelamento, se for o caso
            #$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, $valor);

        } catch (CieloRequestException $e) {
            // Em caso de erros de integração, podemos tratar o erro aqui.
            // os códigos de erro estão todos disponíveis no manual de integração.
            $error = $e->getCieloError();
        }

        // Retorno
        if($paymentReturnMessage=="Transacao autorizada" || $paymentReturnMessage=="Operation Successful"){
            $this->session->set_flashdata("msg_retorno", "Transação autorizada com sucesso!"); 
        } else {
            $this->session->set_flashdata("msg_erro", "Operação não realizada!");
        }

        redirect(base_url('chamadaexterna/paymentchamada')."/".$this->input->post('chamada-idChamada'));

    }


    /**
     *
     * @autor: Davi Siepmann
     * @date: 10/12/2015
     *
     * salva estado atual (em sessão) do box chamado
     * (minimizado ou maximizado pelo usuário /internauta)
     *
     */

    public function atualizaBoxMinimizadoMaximizado()
    {
        $this->registraSessaoCriaCors();
        $this->session->set_userdata(array('boxChamadoMinimizado' => $this->input->post('boxChamadoMinimizado')));
        echo $this->input->post('boxChamadoMinimizado');
    }

    /*
     * @autor: Davi Siepmann
     * @date: 22/11/2015
     *
     * Retorna um objeto JSON contendo os bairros daquela cidade
    */

    public function retornaAjaxBairros()
    {
        $this->registraSessaoCriaCors();
        $idCidade = $this->input->post('idCidade');
        $bairros = $this->chamadaexterna_model->buscarBairrosSistema($idCidade);
        echo json_encode($bairros);
    }


    /*
     * cria chamada atraves de post recebido via: gcm_comunication/v1/index.php
     * @autor: Davi Siepmann
     * @date: 28/05/0216
     */
    public function cria_chamada_via_app() {
        $this->registraSessaoCriaCors();

        $id_empresa              = $_POST['id_empresa'];
        $id_usuario              = $_POST['id_usuario'];

        //para os locais onde este valor é pego via Sessão
        $_SESSION['idEmpresa']   = $id_empresa;
        $_SESSION['idUsuario']   = $id_usuario;

        $id_cliente              = $_POST['id_cliente'];
        $id_funcionario          = $_POST['id_funcionario'];
        $tipo_veiculo            = $_POST['tipo_veiculo'];
        $observacoes             = $_POST['observacoes'];
        $retornar_origem         = $_POST['retornar_origem'];
        $services                = json_decode($_POST['services']);
        $somente_retorna_valores = $_POST['somente_retorna_valores'];

        //pode remover isso.. foi só para teste
        if ($tipo_veiculo == 0) $tipo_veiculo = 1;

        $dia = date("Y-m-d");
        $hora = date("H:i:s");
        $tarifa = $this->retornaTarifaPorHorario();
        $status = 0;


        $chamada = new ChamadaExternaClass();
        $servicos = $this->retornaServicosDaChamadaViaApp($chamada, $services, $retornar_origem);

        $chamada->setIdEmpresa($id_empresa);
        $chamada->setIdCliente($id_cliente);
        $chamada->setIdFuncionario($id_funcionario);
        $chamada->setData($dia);
        $chamada->setHora($hora);
        $chamada->setTipo_veiculo($tipo_veiculo);
        $chamada->setObservacoes($observacoes);
        $chamada->setTarifa($tarifa);
        $chamada->setStatus($status);
        $chamada->setServicos($servicos);
        $chamada->setTempo_espera(0);

        $chamada->calculaValorChamada();
        
        $result = array();
        $result['error'] = false;
        $result['valor_empresa'] = $chamada->getValor_empresa();
        $result['valor_funcionario'] = $chamada->getValor_funcionario();
        $result['qtd_servicos'] = count($servicos);

        if ($somente_retorna_valores == 'true') {
            $result['chamada_foi_aberta'] = false;
            $result['id_chamada'] = 0;
        }
        else {
            $id_chamada = $chamada->salvar();
            $result['chamada_foi_aberta'] = true;
            $result['id_chamada'] = $id_chamada;
        }

        echo json_encode($result);
        exit();
    }

    private function retornaServicosDaChamadaViaApp($chamada, $services, $retornar_origem) {
        $servicos = array();

        $chamadaServicoOrigem = new ChamadaServicoExternaClass($chamada);

        for ($i = 0; $i < count($services->cities); $i++) {

            $tipoServico = ($i == 0) ? 0 : 1;
            $endereco = ($services->addresses[$i]);
            $numero = ($services->numbers[$i]);
            $bairro = ($services->neighborhoods[$i]);
            $cidade = ($services->cities[$i]);
            $falarcom = ($services->talkto[$i]);

            $chamadaServico = new ChamadaServicoExternaClass($chamada);
            $chamadaServico->setTiposervico($tipoServico);
            $chamadaServico->setEndereco($endereco);
            $chamadaServico->setNumero($numero);
            $chamadaServico->setBairro($bairro);
            $chamadaServico->setCidade($cidade);
            $chamadaServico->setFalarcom($falarcom);

            array_push($servicos, $chamadaServico);

            if ($i == 0) $chamadaServicoOrigem = $chamadaServico;
        }
        /**
         * caso selecionado para retornar a origem, insere novamente o primeiro endereo /origem
         */
        if ($retornar_origem == 'true') {
            $chamadaServicoOrigem->setTiposervico(2);
            array_push($servicos, $chamadaServicoOrigem);
        }

        return $servicos;
    }


    /*
    @autor: André Baill
    @data: 19/10/2020
    @description: desabilitado a função que notifica via APP, porque a situação da chamada não está como paga
    */    

    public function registrachamada()
    {
        $this->registraSessaoCriaCors();

        $resposta = array();


        #echo "Aqui";

        if ($this->session->userdata('logadoUser') || $this->session->userdata('idAcessoExterno')) {

            #echo "Aqui 2";

            if ($this->validarFormChamada()) {

                #echo "Aqui 3";

                $chamada = $this->popularCadastroChamada(); 

                #echo "Aqui 4";
                ##echo "<pre>";
                #print_r($this->input->post());
               // print_r($chamada);
               // die();

                if ($this->input->post('registrarChamada') == 'true' || ($this->session->userdata('logadoUser'))){
                  
                  #echo "Aqui 5";

                    if ($chamada->getValor_empresa() > 0) {  

                        $id_resposta = $chamada->salvar();

                        #echo "<pre>";
                        #print_r($chamada->getValor_empresa());
                        #echo "Aqui";
                        #print_r($this->input->post());
                        #die();                         



                   # print_r($id_resposta);
                   # print_r($this->input->post());
                   # die();                        



                        //permite registrar apenas um chamado com cadastro privisrio
                        /*if ($this->session->unset_userdata('idClientePreCadastro'))
                            $this->session->unset_userdata('idClientePreCadastro');*/

                        if ($id_resposta) {
                            $resposta = array('resposta' => 'success', 'id_chamada' => $id_resposta);

//                          file($this->url_gcm_notification . "/notify_call_everybody/" . $chamada->getIdChamada());
                            /*if ($chamada->getStatus() == 0) {
                                $result = file_get_contents($this->url_gcm_notification . "/notify_call_everybody/" . $chamada->getIdChamada() . "/0");
                            }*/


                            #redirect(base_url('chamadaexterna/paymentboxchamado/'.$id_resposta));


                        } else {
                            $resposta = array('resposta' => 'error', 'error' => ' <b>Favor entrar em contato.</b>');
                        }
                    } else {
                        $resposta = array('resposta' => 'error', 'error' => 'Trecho sem valor, favor entrar em contato conosco.');
                    }

                } else {

                   # echo "Aqui 6";
                   # die();


                    // Verficação manual - se existir um funcionário vinculado, seta valor do funcionário, se não valor empresa
                    if($this->session->userdata('idFuncionario')){
                        $valor = $chamada->getValor_funcionario();
                    } else {
                        $valor = $chamada->getValor_empresa();
                    }
                    $resposta = array('resposta' => 'calculado_valor', 'valor' => conv_monetario_br($valor));

                    #echo "<pre>";
                    #print_r($resposta);
                    #echo $chamada->getValor_empresa();
                    #print_r($this->session->userdata);
                    #die();


                    //$valor = (!$this->session->userdata('idFuncionario')) ? $chamada->getValor_empresa() : $chamada->getValor_funcionario();

                    /*
                    echo "<pre>";
                    print_r($chamada->getValor_funcionario()." - Valor 222");
                    print_r($chamada->getValor_empresa()." - Empresa 333");
                    print_r($valor);
                    print_r($this->session->userdata);
                    print_r($this->input->post());
                    die();   
                    */                
                }
                
            } else {
                $resposta = array('resposta' => 'error', 'error' => 'Dados inconsistentes: ' . $this->validation_errors);
            }
        } else $resposta = array('resposta' => 'error', 'error' => 'Voce nao possui permissao para inserir chamados.' . $this->session->userdata('idEmpresaWebsite'));

        // Retorno em Json Encode
        echo json_encode($resposta);
    }


    /*

     * @autor: Davi Siepmann

     * @date: 21/11/2015

     */

    public function form_pre_cadastro()
    {

        $this->registraSessaoCriaCors();
        $resposta = array();

        if ($this->session->userdata('idEmpresaWebsite')) {
            if ($this->validarFormPreCadastro()) {
                $cliente = $this->popularPreCadastroCliente();

                $id_resposta = $cliente->salvar();
                if ($id_resposta) {
                    $resposta = array('resposta' => 'success', 'idCliente' => $id_resposta);
                    //$this->session->set_userdata(array('idCliente' => $id_resposta));
                    //$this->session->set_flashdata('cadastrosucesso', "Cadastro Efetuado, efetue seu login.");

                    $usuario = new UsuarioClass();
                    $usuario = $this->popularPreCadastroUsuario($id_resposta);
                    $id_usuario = $usuario->salvar();

                } else {
                    if ($cliente->getDb_error_number() == 1062) $erro = "CNPJ ou Email ja cadastrado!";
                    else $erro = "Favor entrar em contato conosco. " . $cliente->getDb_error_number();
                    $resposta = array('resposta' => 'error', 'error' => $erro);
                }

            } else {
                $resposta = array('resposta' => 'error', 'error' => 'Dados inconsistentes: ' . $this->validation_errors);
            }

        } else {
            $resposta = array('resposta' => 'error', 'error' => 'Servico não disponivel para este host.' . $this->input->post('clientKey'));
        }
        
        echo json_encode($resposta);
    }

    /*
     * @autor: Davi Siepmann
     * @date: 30/11/2015
    */

    public function logoffexerno()
    {
        $this->session->sess_destroy();
        echo "Logoff Efetuado!";
    }


    private function popularCadastroChamada()
    {
        $chamada = new ChamadaExternaClass();

        if ($this->session->userdata('logado')) {

            //alteração 18-03-2016
            if ($this->session->userdata('idAcessoExterno') && $this->session->userdata('idAcessoExterno') != "")
                $idCliente = $this->session->userdata('idAcessoExterno');

            else
                $idCliente = $this->input->post('idCliente');

            $idFuncionario = $this->input->post('idFuncionario');
            $chamada->setIdFuncionario($idFuncionario);

            $chamada->setIdCliente($idCliente);

            $idEmpresa = $this->session->userdata('idEmpresa');
        } else {
            /**
             * na simulao /oramento do valor do frete, quando usurio no possui cadastro (no logado)
             * sistema pega valores para clculo do cadastro da empresa que est fornecendo o acesso (form. no website)
             */
            if ($this->session->userdata('idCliente')) {
                $idClienteExt = $this->session->userdata('idCliente');
            }

            $idCliente = $this->session->userdata('idEmpresaWebsite');
            $chamada->setIdCliente($idCliente);

            $idEmpresa = $this->session->userdata('idEmpresaWebsite');
        }

        $servicos = $this->retornaServicosDaChamada($chamada);
        $dia = date("Y-m-d");
        $hora = date("H:i:s");
        $tarifa = $this->retornaTarifaPorHorario();
        $tipoVeic = $this->input->post('vehicle');
        $observacoes = $this->input->post('observation');
        $status = ($this->session->userdata('idCliente')) ? '-5' : 0; // era -1 mod -5
        $tempo_espera = $this->input->post('tempo_espera');


        //die('idcliente: ' . $idClienteExt);
        //$chamada->setIdEmpresa($chamada->buscarIdEmpresaPeloIdCliente($idCliente));
        $chamada->setIdEmpresa($idEmpresa);
        $chamada->setData($dia);
        $chamada->setHora($hora);
        $chamada->setTipo_veiculo($tipoVeic);
        $chamada->setObservacoes($observacoes);
        $chamada->setTarifa($tarifa);
        $chamada->setStatus($status);
        $chamada->setServicos($servicos);
        $chamada->setTempo_espera($tempo_espera);

        $chamada->calculaValorChamada();

        //quando utilizado itinerário, lança valores cadastrados
        if ($this->input->post('idClienteFreteItinerario') && $this->input->post('idClienteFreteItinerario') > 0) {
            $itinerario = $this->chamadaexterna_model->getItinerario($this->input->post('idClienteFreteItinerario'));

            if ($itinerario->valor_empresa > 0) {
                $chamada->setValor_empresa($itinerario->valor_empresa);
                $chamada->setValor_funcionario($itinerario->valor_funcionario);
            }
//          else {
//              $chamada->setStatus(-1);
//          }
        }

        if (isset($idClienteExt)) $chamada->setIdCliente($idClienteExt);

//      var_dump($chamada); die();

        return $chamada;
    }


    private function retornaTarifaPorHorario()
    {
        $currentTime = strtotime(date("H:i:s"));
        $startTime = strtotime('8:00');
        $endTime = strtotime('18:00');
        $retorno = ($currentTime <= $endTime && $startTime <= $currentTime) ? 1 : 2;
        return $retorno;
    }


    private function retornaServicosDaChamada($chamada)
    {
        $servicos = array();

        if ($this->input->post('idClienteFreteItinerario') && $this->input->post('idClienteFreteItinerario') > 0) {
            $itinerario = $this->chamadaexterna_model->getItinerarioServicos($this->input->post('idClienteFreteItinerario'));

            for ($i = 0; $i < count($itinerario); $i++) {

                $tipoServico = $itinerario[$i]->tiposervico;
                $endereco = $itinerario[$i]->endereco;
                $numero = $itinerario[$i]->numero;
                $bairro = $itinerario[$i]->bairro;
                $cidade = $itinerario[$i]->cidade;
                $falarcom = $_POST['talkto'][$i];

                $chamadaServico = new ChamadaServicoExternaClass($chamada);
                $chamadaServico->setTiposervico($tipoServico);
                $chamadaServico->setEndereco($endereco);
                $chamadaServico->setNumero($numero);
                $chamadaServico->setBairro($bairro);
                $chamadaServico->setCidade($cidade);
                $chamadaServico->setFalarcom($falarcom);

                array_push($servicos, $chamadaServico);
            }
        } else {
            $chamadaServicoOrigem = new ChamadaServicoExternaClass($chamada);

            for ($i = 0; $i < count($this->input->post('city')); $i++) {

                $tipoServico = ($i == 0) ? 0 : 1;
                $endereco = ($_POST['address'][$i]);
                $numero = ($_POST['number'][$i]);
                $bairro = ($_POST['neightbor'][$i]);
                $cidade = ($_POST['city'][$i]);
                $falarcom = ($_POST['talkto'][$i]);

                $chamadaServico = new ChamadaServicoExternaClass($chamada);
                $chamadaServico->setTiposervico($tipoServico);
                $chamadaServico->setEndereco($endereco);
                $chamadaServico->setNumero($numero);
                $chamadaServico->setBairro($bairro);
                $chamadaServico->setCidade($cidade);
                $chamadaServico->setFalarcom($falarcom);

                array_push($servicos, $chamadaServico);

                if ($i == 0) $chamadaServicoOrigem = $chamadaServico;
            }
            /**
             * caso selecionado para retornar a origem, insere novamente o primeiro endereo /origem
             */
            if ($this->input->post('retornar-origem') == 'on') {
                $chamadaServicoOrigem->setTiposervico(2);
                array_push($servicos, $chamadaServicoOrigem);
            }
        }

        return $servicos;
    }


    private function popularPreCadastroCliente()
    {

        $cliente = new ClienteClass();
        $idEmpresa = $this->session->userdata('idEmpresaWebsite');

        $razaosocial = ($this->input->post('razaoSocial'));
        $nomefantasia = ($this->input->post('razaoSocial'));
        $responsavel_telefone_ddd = (substr($this->input->post('telefone'), 1, 3));
        $responsavel_telefone = (substr($this->input->post('telefone'), 5));
        $cnpj = ($this->input->post('cnpj'));
        $email = ($this->input->post('email'));
        $senha = ($this->input->post('senha'));

        // Status
        $status = 1;
        //$status = 10;

        $cliente->setIdEmpresa($idEmpresa);
        $cliente->setRazaosocial($razaosocial);
        $cliente->setNomefantasia($razaosocial);
        $cliente->setCnpj($cnpj);
        $cliente->setResponsavel_telefone_ddd($responsavel_telefone_ddd);
        $cliente->setResponsavel_telefone($responsavel_telefone);
        $cliente->setEmail($email);
        $cliente->setSenha($senha);
        $cliente->setStatus($status);

        return $cliente;
    }

    /*
    * @autor: André Baill
    * @data: 16/10/2020
    * @description: gerando usuário para o cliente pré-cadastrado, para que ele possa efetuar o pagamento com segurança
    */

    private function popularPreCadastroUsuario($id_resposta)
    {
        $usuario = new UsuarioClass();

        $idCliente = $id_resposta;
        $idEmpresa = $this->session->userdata('idEmpresaWebsite');
        $nome = ($this->input->post('razaoSocial'));
        $login = ($this->input->post('email'));
        $senha = ($this->input->post('senha')); 
        $tipo = "Externo";       
        $situacao = 5; // situação de inclusão pelo site

        $usuario->setIdEmpresa($idEmpresa);
        $usuario->setIdCliente($idCliente);
        $usuario->setNome($nome);
        $usuario->setTipo($tipo);
        $usuario->setLogin($login);
        $usuario->setSenha($senha);
        $usuario->setSituacao($situacao);   

        return $usuario;     
    }


    /*
     * @autor: Davi Siepmann
     * @date: 22/11/2015
    */

    private function validarFormChamada()
    {

        $this->load->library('form_validation');


        //regras para validação

        $this->form_validation->set_rules('idCliente', 'Cliente', 'trim|xss_clean');
        $this->form_validation->set_rules('idFuncionario', 'Funcionário', 'trim|xss_clean');
        $this->form_validation->set_rules('city[]', 'Cidade requerida', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address[]', 'Endereco requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('number[]', 'Numero requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('neightbor[]', 'Bairro requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('talkto[]', 'Falar com incorreto', 'trim|xss_clean');
        $this->form_validation->set_rules('observation', 'Observação incorreta', 'trim|xss_clean');
        $this->form_validation->set_rules('tempo_espera', 'Tempo espera não informado incorreto', 'trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->validation_errors = validation_errors();
            return false;
        } else return true;

    }


    /*
     * @autor: Davi Siepmann
     * @date: 22/11/2015
    */

    private function validarFormPreCadastro()
    {

        $this->load->library('form_validation');

        //regras para validação
        $this->form_validation->set_rules('razaoSocial', 'Razao Social requerida', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cnpj', 'CNPJ requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('telefone', 'Telefone requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email requerido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('senha', 'Senha requerida', 'trim|required|xss_clean|min_length[6]|max_length[50]|MD5');

        if (!validaCPF($this->input->post('cnpj'))) {
            if (!validaCNPJ($this->input->post('cnpj'))) {
                $this->validation_errors = "CPF ou CNPJ Incorreto";
                return false;
            }
        }

        if ($this->form_validation->run() == false) {
            $this->validation_errors = validation_errors();
            return false;
        } else return true;

    }

}