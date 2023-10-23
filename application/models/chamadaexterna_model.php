<?php

include_once (dirname(__FILE__) . "/classes/ModelInterface.php");

class chamadaexterna_model extends CI_Model implements ModelInterface {

	const TABELA_CHAMADA = "chamada";
	const TABELA_SERVICO = "chamada_servico";
    const TABELA_CHAMADA_PAGAMENTO = "chamada_pagamento";
    const TABELA_CHAMADA_PAGAMENTO_RESPOSTA = "chamada_pagamento_resposta";

	private $db_error_number;
	private $db_error_message;

    function __construct() {
        parent::__construct();
		$this->load->helper('codegen');
		$this->db_error_message = "";
		$this->db_error_number = "";
    }

    function getChamada($idChamada) {
    	
        $this->db->select('chamada.*, cliente.razaosocial as idCliente, cliente.cnpj, cliente.email');
    	$this->db->where('idChamada', $idChamada);
    	$this->db->from('chamada');
        $this->db->join("cliente", "cliente.idCliente=chamada.idCliente");
    	
    	$result = $this->db->get();

    	if ($this->db->affected_rows() > 0)
    	{
    		$result = $result->result();
    		return $result[0];
    	}
    	
    	return FALSE;
    }

    function getChamadaServicosNew($cod){
			$sql = "
						SELECT
							cs.*, 
							b.bairro,
							c.idCidade,
							c.cidade
						FROM
							chamada_servico as cs,
							bairro as b,
							cidade as c
						WHERE 
							b.idBairro = cs.bairro
						AND
							c.idCidade = cs.cidade
						AND
							cs.idChamada = '".$cod."'
						ORDER BY idChamadaServico ASC
			";

			return $this->db->query($sql)->result();
    }

    function getChamadaServicos($idChamada) {
    	 
    	$this->db->where('idChamada', $idChamada);
    	$this->db->from('chamada_servico');
    	$this->db->order_by('idChamadaServico ASC');
    	 
    	$result = $this->db->get();
    	 
    	if ($this->db->affected_rows() > 0)
    	{
    		$result = $result->result();
    		return $result;
    	}
    	 
    	return FALSE;
    }

    function inserirChamada($dados) {


    	$this->db->insert(self::TABELA_CHAMADA, $dados);

        #print_r($this->db->affected_rows());
        #echo $this->db->last_query();
        #die();


        #echo "<pre>";
        #print_r($dados);
        #echo "<hr>";
        #die();

    	if ($this->db->affected_rows())
    		return $this->db->insert_id();        
    	else {
    		$this->db_error_number  = $this->db->_error_number();
    		$this->db_error_message = $this->db->_error_message();
    	}

    	return FALSE;

    }

    // Salvar pagamento
    function setPaymentByCreditCard($dados){

        $this->db->insert(self::TABELA_CHAMADA_PAGAMENTO, $dados);

        if ($this->db->affected_rows())
            return $this->db->insert_id();

        else {
            $this->db_error_number  = $this->db->_error_number();
            $this->db_error_message = $this->db->_error_message();
        }

        return FALSE;

    }

    /**
    * Verificação e retorno da mensagem ref. ao pagamento
    */
    public function getPaymentReasonByReturn($status, $status_detail){
        
        $table = self::TABELA_CHAMADA_PAGAMENTO_RESPOSTA;

        $this->db->from($table);
        $this->db->where('status', $status);
        $this->db->where('status_detail', $status_detail);

        $result = $this->db->get();

        if ($this->db->affected_rows() > 0) {
            $result = $result->row('mesage');
            return  $result;
        }     
        
        return false;   

    }   

    /*
    @autor: André Baill
    @data: 03/11/2020
    @description: Buscando pagamentos referentes a esta chamada
    */ 

    public function getPagamentoByIdChamada($id_chamada){

        $table = self::TABELA_CHAMADA_PAGAMENTO;
        $tableReturn = self::TABELA_CHAMADA_PAGAMENTO_RESPOSTA;

        $this->db->from($table);
        $this->db->where('idChamada', $id_chamada);
        $this->db->order_by('idChamadaPagamento', 'DESC');
        $results = $this->db->get();

        if ($this->db->affected_rows() > 0) {
            $result = $results->result();
            foreach($result as &$value){
                $this->db->where('status', $value->status);
                $this->db->where('status_detail', $value->statusDetail);
                $value->mesage_table = $this->db->get($tableReturn)->row('mesage');
            }

            return  $result;
        }     
        
        return false;  
    }


    
    function atualizar($where, $dados) {
    	$table = self::TABELA_CHAMADA;
    	
    	$this->db->where($where);
    	
    	$this->db->update($table, $dados);
    	
    	if ($this->db->affected_rows() >= 0) {
    		return TRUE;
    	}
    	return false;
    }
    
    function getItinerario($idClienteFreteItinerario) {

    	$this->db->select('a.*');
    	$this->db->from('cliente_frete_itinerario a');
    	$this->db->where("a.idClienteFreteItinerario", $idClienteFreteItinerario);
    	 
   		$result = $this->db->get();
   		 
   		if ($this->db->affected_rows() > 0) {
   			$result = $result->result();
   			return  $result[0];
   		}
    		 
   		return false;
    }

    function getItinerarioServicos($idClienteFreteItinerario) {
    
   		$this->db->select('a.*');
   		$this->db->from('cliente_frete_itinerario_servicos a');
   		$this->db->where("a.idClienteFreteItinerario", $idClienteFreteItinerario);
   
   		$result = $this->db->get();
   		
   		if ($this->db->affected_rows() > 0) {
   			$result = $result->result();
   			
   			return $result;
   		}
   
   		return false;
    }

    function getFuncionarios($idFuncionario) {
    
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	 
    	$this->db->select("a.idFuncionario, a.nome");
    	$this->db->from('funcionario a');
    	$this->db->where("a.idEmpresa", $idEmpresa);
    	$this->db->where("a.situacao", true);
    	
    	if ($idFuncionario && $idFuncionario != "")
    		$this->db->where('a.idFuncionario', $idFuncionario);
    	
    	$this->db->order_by('a.nome');
    	 
    	$result = $this->db->get();
    	 
//     	die($this->db->last_query());
    	 
    	if ($this->db->affected_rows() > 0) {
    		return  $result->result();
    	}
    	 
    	return false;
    	 
    }
    
    function getClientes($idCliente) {
    
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
    	$this->db->select("a.idCliente, a.razaosocial nome");
    	$this->db->from('cliente a');
    	$this->db->where("a.idEmpresa", $idEmpresa);
    	$this->db->where("a.situacao", true);
    	
    	if ($idCliente && $idCliente != "")
    		$this->db->where("a.idCliente", $idCliente);
    	
    	$this->db->order_by('a.razaosocial');
    	
    	$result = $this->db->get();
    	
//     	var_dump($result->result());
//     	die($this->db->last_query());
    	
    	if ($this->db->affected_rows() > 0) {
    		return  $result->result();
    	}
    	
    	return false;
    	
    }

    /**

     * 

     * @param array de endere�os $dados

     * @return boolean

     * 

     * Utilizar fun��o addChamadaServicoSistemaAntigo() para c�lculo dos valores

     */

    function inserirChamadaServico($dados) {

        #echo "<pre> >> Serviços >> ";
        #print_r($dados);
        #die();

    	$this->db->insert(self::TABELA_SERVICO, $dados);

        #echo $this->db->last_query();
        #die();

    	

    	if ($this->db->affected_rows())

    		return $this->db->insert_id();



    	else {

    		$this->db_error_number  = $this->db->_error_number();

    		$this->db_error_message = $this->db->_error_message();

    	}

    		

    	return FALSE;

    }

    

    function alterar($dados, $where) {

    	

    }

    

    function buscarIdEmpresaPeloIdCliente($idCliente) {

    	$this->db->where('idCliente',$idCliente);

    	$row = $this->db->get('cliente')->row();

    	

    	if ($this->db->affected_rows())

    		return $row->idEmpresa;

    

    	else {

    		$this->db_error_number  = $this->db->_error_number();

    		$this->db_error_message = $this->db->_error_message();

    	}

    	

    	return false;

    }

    

    public function getDb_error_number() {

    	return $this->db_error_number;

    }

    

    public function getDb_error_message() {

    	return $this->db_error_message;

    }

    	

	/**

	 * realiza busca das cidades do banco de dados

	 * 

	 */

    public function buscarCidadesSistema() {

    	//$this->db->where('idCliente',$idCliente);

    	//$this->db->select('idCidade, cidade');

    	$this->db->order_by("cidade", "asc");

    	$row = $this->db->get('cidade');

    	 

    	if ($this->db->affected_rows())

    		return $row->result();

    

    	return false;

    }

    

	/**

	 * realiza busca dos bairros conf. cidade

	 * @param idCidade

	 * 

	 */

    public function buscarBairrosSistema($idCidade) {

    	$this->db->where('idCidade',$idCidade);

    	

    	$row = $this->db->get('bairro');

    	

    	if ($this->db->affected_rows())

    		return $row->result();

    

    	return false;

    }

    /**

     * 

     * @param array $servicos

     * @param int $idCliente

     * 

     * Retorna array $valores['valor_empresa'] + $valores['pontos']

     * 

     */

    function retornaArrVlPtChamadaEmpresa($servicos, $chamada) { // print_r($servicos); die();
    	$dados = $servicos;
    
    	$tipoDeTarifa = $chamada->getTarifa ();
    
    	$idVeiculo = $chamada->getTipo_veiculo ();
    
    	$idCliente = $chamada->getIdCliente ();
    
    	if ($tipoDeTarifa == '1' and $idVeiculo == '1') {
    		$keyCli = "valor_moto_normal";
    		$keyCliFunc = "valormotonormal";
    	}
    
    	if ($tipoDeTarifa == '2' and $idVeiculo == '1') {
    		$keyCli = "valor_moto_depois_18";
    		$keyCliFunc = "valormotodepois18";
    	}
    
    	if ($tipoDeTarifa == '3' and $idVeiculo == '1') {
    		$keyCli = "valor_moto_metropolitano";
    		$keyCliFunc = "valormotometropolitano";
    	}
    
    	if ($tipoDeTarifa == '4' and $idVeiculo == '1') {
    		$keyCli = "valor_moto_metropolitano_apos18";
    		$keyCliFunc = "valormotometrodepois18";
    	}
    
    	if ($tipoDeTarifa == '1' and $idVeiculo == '2') {
    		$keyCli = "valor_carro_normal";
    		$keyCliFunc = "valorcarronormal";
    	}
    
    	if ($tipoDeTarifa == '2' and $idVeiculo == '2') {
    		$keyCli = "valor_carro_depois_18";
    		$keyCliFunc = "valorcarrodepois18";
    	}
    
    	if ($tipoDeTarifa == '3' and $idVeiculo == '2') {
    		$keyCli = "valor_carro_metropolitano";
    		$keyCliFunc = "valorcarrometropolitano";
    	}
    
    	if ($tipoDeTarifa == '4' and $idVeiculo == '2') {
    		$keyCli = "valor_carro_metropolitano_apos18";
    		$keyCliFunc = "valorcarrometrodepois18";
    	}
    
    	if ($tipoDeTarifa == '1' and $idVeiculo == '3') {
    		$keyCli = "valor_van_normal";
    		$keyCliFunc = "valorvannormal";
    	}
    
    	if ($tipoDeTarifa == '2' and $idVeiculo == '3') {
    		$keyCli = "valor_van_depois_18";
    		$keyCliFunc = "valorvandepois18";
    	}
    
    	if ($tipoDeTarifa == '3' and $idVeiculo == '3') {
    		$keyCli = "valor_van_metropolitano";
    		$keyCliFunc = "valorvanmetropolitano";
    	}
    
    	if ($tipoDeTarifa == '4' and $idVeiculo == '3') {
    		$keyCli = "valor_van_metropolitano_apos18";
    		$keyCliFunc = "valorvanmetrodepois18";
    	}
    
    	if ($tipoDeTarifa == '1' and $idVeiculo == '4') {
    		$keyCli = "valor_caminhao_normal";
    		$keyCliFunc = "valorcaminhaonormal";
    	}
    
    	if ($tipoDeTarifa == '2' and $idVeiculo == '4') {
    		$keyCli = "valor_caminhao_depois_18";
    		$keyCliFunc = "valorcaminhaodepois18";
    	}
    
    	if ($tipoDeTarifa == '3' and $idVeiculo == '4') {
    		$keyCli = "valor_caminhao_metropolitano";
    		$keyCliFunc = "valorcaminhaometropolitano";
    	}
    
    	if ($tipoDeTarifa == '4' and $idVeiculo == '4') {
    		$keyCli = "valor_caminhao_metropolitano_apos18";
    		$keyCliFunc = "valorcaminhaometrodepois18";
    	}
    
    	$sql_cliente = "
    
    	SELECT cli.*, cf.* FROM
    
    	cliente cli
    	left join cliente_frete cf on (cf.idClienteFrete = getIdClienteFreteVigente(cli.idCliente))
    
    	WHERE
    
    	cli.idCliente = '{$idCliente}'
    
    	";
    
    	$consulta_cliente = $this->db->query ( $sql_cliente )->row ();
    
    	$valorhora = $consulta_cliente->$keyCli;
    
    	$veic = array ();
    
    	$veic [1] = "Moto";
    
    	$veic [2] = "Carro";
    
    	$veic [3] = "Van";
    
    	$veic [4] = "Caminhao";
    
    	$tip_serv = array ();
    
    	$tip_serv [0] = "ponto";
    
    	$tip_serv [1] = "ponto";
    
    	$tip_serv [2] = "retorno";
    
    	$pontoTotal = 0;
    
    	for($ii = 0; $ii < count ( $dados ); $ii ++) {
    
    		if (isset ( $dados [$ii] ) and $dados [$ii] and $ii != 0) { // verifica primeiro se tem vinculo depois
    				
    			if (isset ( $dados [$ii + 1] )) {
    
    				if ($dados [$ii] ['cidade'] != $dados [$ii + 1] ['cidade']) {
    						
    					// metropolitano
    						
    					$bairroReferencia = "SELECT idBairro, idTipo FROM bairro WHERE idBairro = '" . $dados [$ii] ['bairro'] . "'";
    						
    					$referencia = $this->db->query ( $bairroReferencia )->row ( 'idTipo' );
    						
    					$referenciaBase = array ();
    						
    					$referenciaBase [1] = "C";
    						
    					$referenciaBase [2] = "B";
    						
    					$referenciaBase [3] = "A";
    						
    					$sql = "SELECT " . ($tip_serv [$dados [$ii] ['tiposervico']] . $veic [$idVeiculo]) . " as vlrFrete FROM tabelafretem WHERE idSaida = " . $dados [$ii] ['cidade'] . " AND idDestino = " . $dados [$ii + 1] ['cidade'] . " AND referencia = '" . $referenciaBase [$referencia] . "'";
    				} else {
    						
    					$sql = "SELECT " . ($tip_serv [$dados [$ii] ['tiposervico']] . $veic [$idVeiculo]) . " as vlrFrete FROM tabelafrete WHERE idSaida = " . $dados [$ii] ['bairro'] . " AND idDestino = " . $dados [$ii + 1] ['bairro'] . "";
    				}
    			} else {
    
    				if ($dados [$ii] ['cidade'] != $dados [$ii - 1] ['cidade']) {
    						
    					// metropolitano
    						
    					$bairroReferencia = "SELECT idBairro, idTipo FROM bairro WHERE idBairro = '" . $dados [$ii] ['bairro'] . "'";
    						
    					$referencia = $this->db->query ( $bairroReferencia )->row ( 'idTipo' );
    						
    					$referenciaBase = array ();
    						
    					$referenciaBase [1] = "C";
    						
    					$referenciaBase [2] = "B";
    						
    					$referenciaBase [3] = "A";
    						
    					$sql = "SELECT " . ($tip_serv [$dados [$ii] ['tiposervico']] . $veic [$idVeiculo]) . " as vlrFrete FROM tabelafretem WHERE idSaida = " . $dados [$ii - 1] ['cidade'] . " AND idDestino = " . $dados [$ii] ['cidade'] . " AND referencia = '" . $referenciaBase [$referencia] . "'";
    				} else {
    						
    					$sql = "SELECT " . ($tip_serv [$dados [$ii] ['tiposervico']] . $veic [$idVeiculo]) . " as vlrFrete FROM tabelafrete WHERE idSaida = " . $dados [$ii - 1] ['bairro'] . " AND idDestino = " . $dados [$ii] ['bairro'] . "";
    				}
    			}
    				
    			$pontos = $this->db->query ( $sql )->row ();
    				
    			if (count ( $pontos ))
    
    				$pontoTotal += $pontos->vlrFrete;
    		}
    	}
    
    	// $valores['valor_funcionario'] = 0;
    
    	$valores ['valor_empresa'] = ($pontoTotal) * ($valorhora);
    
    	$valores ['pontos'] = $pontoTotal;
    
    	return $valores;
    
    	// $this->db->where('idChamada',$dados[0]['idChamada']);
    
    	// $this->db->update('chamada', $valores);
    
    	// $this->db->insert_batch('chamada_servico', $dados);
    }
    
    
    
    


    /**
     * Novo cálculo valor chamada
     */
    function getValorHoraCliente($idCliente, $atributo_valor) {
        $idCliente = ($idCliente==null) ? '148' : $idCliente;
    	$this->db->select('cf.' . $atributo_valor .' valor');
    	$this->db->from('cliente_frete cf');
    	$this->db->where('cf.idClienteFrete = getIdClienteFreteVigente('.$idCliente.')');
    
    	$result = $this->db->get();
    	
    	if ($this->db->affected_rows() > 0) {
    		$result = $result->result();
    		$result = $result[0];
    			
    		return $result->valor;
    	}
    
    	return 0;
    }

    function getTipoCidade($idCidade) {
    	$this->db->select('idTipo');
    	$this->db->from('cidade');
    	$this->db->where('idCidade', $idCidade);
    
    	$result = $this->db->get();
    	
    	if ($this->db->affected_rows() > 0) {
    		$result = $result->result();
    		$result = $result[0];
    		 
    		return $result->idTipo;
    	}
    
    	return false;
    }
    
    function getCidadeDaEmpresa($idCliente) {
    	$this->db->select('endereco_cidade');
    	$this->db->from('cliente');
    	$this->db->where('idCliente', $idCliente);
    
    	$result = $this->db->get()->result();
    	
    	if ($this->db->affected_rows() > 0) {
    		$result = $result[0];
    		return $result->endereco_cidade;
    	}
    
    	return false;
    }

    function getValorHoraFuncionario($idFuncionario, $atributo_valor) {
    	$sql_ff = "(SELECT idFuncionarioFrete 
    			FROM funcionario_frete 
    			WHERE idFuncionario = $idFuncionario 
    			AND vigencia_final is null 
    			ORDER BY vigencia_inicial DESC 
    			LIMIT 1)";
    	
    	$this->db->select('ff.' . $atributo_valor .' valor');
    	$this->db->from('funcionario_frete ff');
    	$this->db->where('ff.idFuncionarioFrete = ' . $sql_ff);
    
    	$result = $this->db->get();

    	if ($this->db->affected_rows() > 0) {
    		$result = $result->result();
    		$result = $result[0];
    		 
    		return $result->valor;
    	}
    
    	return 0;
    }
    
    function getPontosTabelaCidadeABC($idBairro, $idCidadeOrigem, $idCidadeDestino, $idVeiculo, $tipoServico) {
    	$bairroReferencia = "SELECT idTipo FROM bairro WHERE idBairro = " . $idBairro;

    	$referencia = $this->db->query ( $bairroReferencia )->row ( 'idTipo' );
    	
    	$referenciaBase = array ();
    	$referenciaBase [1] = "C";
    	$referenciaBase [2] = "B";
    	$referenciaBase [3] = "A";
    	
    	$veic = array ();
    	$veic [1] = "Moto";
    	$veic [2] = "Carro";
    	$veic [3] = "Van";
    	$veic [4] = "Caminhao";
    	
    	$tip_serv = array ();
    	$tip_serv [0] = "ponto";
    	$tip_serv [1] = "ponto";
    	$tip_serv [2] = "retorno";
    	
//     	echo "[tab " . $referenciaBase [$referencia] . "] ";
    	
    	$sql = "SELECT " . ($tip_serv [$tipoServico] . $veic [$idVeiculo]) . " as pontos 
    			FROM tabelafretem 
    			WHERE idSaida = " . $idCidadeOrigem . " 
    			AND idDestino = " . $idCidadeDestino . " 
    			AND referencia = '" . $referenciaBase [$referencia] . "'";
    	
    	$pontos = $this->db->query ( $sql )->row ( 'pontos' );
    	
    	if (!is_numeric($pontos)) $pontos = 0;
    	
    	return $pontos;
    }

    function getPontosTabelaBairro($idBairro, $idBairroOrigem, $idBairroDestino, $idVeiculo, $tipoServico) {
    	 
    	$veic = array ();
    	$veic [1] = "Moto";
    	$veic [2] = "Carro";
    	$veic [3] = "Van";
    	$veic [4] = "Caminhao";
    	 
    	$tip_serv = array ();
//     	$tip_serv [0] = "ponto";
    	$tip_serv [1] = "ponto";
    	$tip_serv [2] = "retorno";
    	 
    	$sql = "SELECT " . ($tip_serv [$tipoServico] . $veic [$idVeiculo]) . " as pontos
    			FROM tabelafrete
    			WHERE idSaida = " . $idBairroOrigem . "
    			AND idDestino = " . $idBairroDestino;
    	 
    	$pontos = $this->db->query ( $sql )->row ( 'pontos' );
    	
    	if (!is_numeric($pontos)) $pontos = 0;
    	
    	return $pontos;
    }
}
