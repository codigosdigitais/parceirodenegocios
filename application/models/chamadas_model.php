<?php

class chamadas_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->helper('codegen');
    }


    
	public function getModulosCategoria(){
		$sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
		$consulta = $this->db->query($sql)->result();	

			foreach($consulta as &$valor){
				$sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
				$valor->subModulo = $this->db->query($sql_model)->result();		
			}

		return $consulta;
	}
	


	// Listagem de chamadas - Inicial
	public function getChamadasLista($tipo=null, $periodo=null)
	{

		$data_atual = date("Y-m-d");


		$data = "data = '".$data_atual."'";
		switch($periodo)
		{
			case 1:
				$data = "data = '".$data_atual."'";
				break;

			case 7:
				$data = "data BETWEEN NOW() - INTERVAL 7 DAY AND NOW()";
				break;

			case 14:
				$data = "data BETWEEN NOW() - INTERVAL 14 DAY AND NOW()";
				break;

			case 30:
				$data = "data BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
				break;

			case 90:
				$data = "data BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
				break;

			case 15:
				$data = "data BETWEEN CURRENT_DATE AND CURRENT_DATE() + 15";
				break;				

		}

		if(!$tipo==null)
		{
			if($tipo=='pendente')
			{
				$status = "status != 2";
			}

			if($tipo=='finalizada')
			{
				$status = "status = 2";
			}
		}

		$consulta = $this->db
							->where($data)
							->where($status)
							->get('v_chamada_lista')
							->result();
		return $consulta;

	}

	/*
	function getFuncionarios(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$sql = "
			SELECT 
				c1.idFuncionario,
				c1.idFuncionario as idFuncionarioLista,
				c1.nome,
				c1.imei,
				c1.responsaveltelefoneddd,
				c1.responsaveltelefone,
				c1.responsavelcelular,
				c1.imei AS imei_usuario,
				c2.idFuncionarioOnline,
				c2.idFuncionario,
				c2.status AS status_usuario,
				c3.*,
				DATE_FORMAT(DATE(c3.data_update), '%d/%m/%Y') as data
			FROM
			funcionario AS c1
				LEFT JOIN funcionario_online AS c2 ON (c2.idFuncionario = c1.idFuncionario)
				LEFT JOIN gcm_users AS c3 ON (c3.imei=c1.imei)
			WHERE c1.imei != '' AND c1.imei != '0'
			AND	  c1.idEmpresa = ".$idEmpresa."
				GROUP BY c1.idFuncionario
				ORDER BY c3.data_update DESC, c1.nome ASC
			";

		

		$consulta = $this->db->query($sql)->result();		

			foreach($consulta as &$valor){

				

				$sql_aberto = "SELECT * FROM chamada WHERE idFuncionario = '".$valor->idFuncionarioLista."' AND status = '1' and via_app = '1'";	

				$valor->total_aberto = $this->db->query($sql_aberto)->num_rows();

				

				$sql_concluido = "SELECT * FROM chamada WHERE idFuncionario = '".$valor->idFuncionarioLista."' AND status = '2' and via_app = '1'";	

				$valor->total_concluido = $this->db->query($sql_concluido)->num_rows();

				

				$sql_cancelado = "SELECT * FROM chamada WHERE idFuncionario = '".$valor->idFuncionarioLista."' AND status = '3' and via_app = '1'";	

				$valor->total_cancelado = $this->db->query($sql_cancelado)->num_rows();

				

				$sql_status = "SELECT * FROM funcionario_online WHERE idFuncionario = '".$valor->idFuncionarioLista."' ORDER BY idFuncionarioOnline DESC LIMIT 1";	// faltava o operador ali -> row()

				$valor->status = $this->db->query($sql_status)->row();	



			}

		

		//usort($consulta, 'my_comparison');

			

		return $consulta; 	

	}
	*/
	
	
	function get_lista_chamadas($por_pagina=0, $inicio=0){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select('cliente.nomefantasia, cliente.idCliente, funcionario.nome as funcionarioNome, chamada.*');
		$this->db->join('cliente', 'cliente.idCliente=chamada.idCliente', 'INNER');
		$this->db->join('funcionario', 'funcionario.idFuncionario=chamada.idFuncionario', 'LEFT');
		$this->db->order_by('chamada.status asc, chamada.data desc');
		$this->db->where('cliente.idEmpresa', $idEmpresa);
		
		if(!empty($_GET['idFuncionario'])){ $this->db->where('chamada.idFuncionario', $_GET['idFuncionario']); }
		if(!empty($_GET['data_inicial']) and !empty($_GET['data_final'])){ $this->db->where("chamada.data BETWEEN '".$_GET['data_inicial']."' AND '".$_GET['data_final']."'"); }
		if(!empty($_GET['idCliente'])){ $this->db->where('chamada.idCliente', $_GET['idCliente']); }
		if(!empty($_GET['idChamada'])){ $this->db->where('chamada.idChamada', $_GET['idChamada']); }
		
		$this->db->limit($por_pagina, $inicio);
		
		$result = $this->db->get('chamada');

		
		
		if ($this->db->affected_rows() > 0) {
			return $result->result();
		}
		
		else return false;
		/*
		echo $this->db->last_query();	
		
		echo "<pre>";
		print_r($consulta);
		echo "</pre>";
		die();*/
	}


	/*
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

		if(empty($start)) $start = 0;

		if(@$_GET['dataInicial']==false and @$_GET['dataFinal']==false and @$_GET['idChamada']==false){
			
			$sql = "
				SELECT DISTINCT c.*, 
				   cl.nomefantasia, 
				   cl.idCliente,
				   f.nome as funcionarioNome
				FROM chamada as c
				INNER JOIN cliente as cl on c.idCliente = cl.idCliente
				LEFT JOIN funcionario as f on c.idFuncionario = f.idFuncionario
				ORDER BY c.data DESC
				LIMIT $start, $perpage
			";

		} elseif(@$_GET['dataInicial']==true and @$_GET['dataFinal']==true and @$_GET['idChamada']==false) { 

			$sql = "
				SELECT DISTINCT c.*, 
				   cl.nomefantasia, 
				   cl.idCliente,
				   f.nome as funcionarioNome
				FROM chamada as c
				INNER JOIN cliente as cl on c.idCliente = cl.idCliente
				LEFT JOIN funcionario as f on c.idFuncionario = f.idFuncionario
				WHERE c.data BETWEEN '".$_GET['dataInicial']."' AND '".$_GET['dataFinal']."' 
				ORDER BY c.data DESC
				LIMIT $start, $perpage
			";

		} else {

			$sql = "
				SELECT DISTINCT c.*, 
				   cl.nomefantasia, 
				   cl.idCliente,
				   f.nome as funcionarioNome
				FROM chamada as c
				INNER JOIN cliente as cl on c.idCliente = cl.idCliente
				LEFT JOIN funcionario as f on c.idFuncionario = f.idFuncionario
				WHERE c.idChamada = '".$_GET['idChamada']."' 
				ORDER BY c.data DESC
				LIMIT 1
			";
		}

		$consulta = $this->db->query($sql)->result();
		return $consulta;
    }

	*/

    function count($table) {

        return $this->db->count_all($table);

    }

    

    /**

     * 

     * @param $idChamada

     * @return servi�os

     */

    /*
    public function getChamadaServicos($idChamada) { 

	    $this->db->where('idChamada',$idChamada);

	    $servicos = $this->db->get('chamada_servico')->result();

    	

    	return $servicos;

    }

	*/
	/*
	 * Modificada 06/05/2021
	 * Adaptação de busca do nome do atendente
	*/

    function getById($id){

    	$this->db->select("
    		chamada.*, 
			(
				CASE WHEN 
					(chamada.idAtendente = null) 
				THEN
					(SELECT nome FROM funcionario WHERE idFuncionario=chamada.idFuncionario)
				ELSE
					sis_usuario.nome
				END
			)
			as nomeAtendente,
    		cliente_responsaveis.nome as nomeSolicitante"
    	);
        $this->db->join("cliente_responsaveis", "cliente_responsaveis.idClienteResponsavel=chamada.solicitante", "LEFT");
        $this->db->join("sis_usuario", "sis_usuario.idUsuario=chamada.idAtendente", "LEFT");
        $this->db->where('chamada.idChamada', $id);
        $consulta = $this->db->get('chamada')->row();
        
        
        $this->db->select("chamada_servico.*, bairro.bairro, cidade.cidade");
        $this->db->join("cidade", "cidade.idCidade=chamada_servico.cidade");
        $this->db->join("bairro", "bairro.idBairro=chamada_servico.bairro");
        $this->db->where('idChamada', $consulta->idChamada);
        $consulta->chamadaServico = $this->db->get('chamada_servico')->result();
        
        /*
        echo "<pre>";
        print_r($this->db->last_query());
        echo "<br><br><br>";
        print_r($consulta);
        echo "</pre>";
        die();
        */

		return $consulta;
    }

    /*
	@Autor: André Baill
	@Date: 14/12/2020
	@Description: Visualização da chamada e da forma de pagamento com todos os detalhes
    */

	public function getByIdView($idChamada){

		$this->db->select('
							chamada.idChamada, 
							chamada.idCliente,
							chamada.idFuncionario,
							chamada.idEmpresa, 
							chamada.data,
							chamada.hora, 
							chamada.valor_empresa,
							chamada.statusPayment, 
							chamada.status,

							cliente.razaosocial cliente_nome,
							funcionario.nome funcionario_nome,

							chamada_pagamento.tid,
							chamada_pagamento.nsu,
							chamada_pagamento.cardName,
							chamada_pagamento.cardNumber,
							chamada_pagamento.status statusPayment,
							chamada_pagamento.dateOfPayment,
							chamada_pagamento.cardType, 

							chamada_pagamento_resposta.status_detail
						');
		$this->db->where('chamada.idChamada', $idChamada);
		$this->db->join("cliente", 'cliente.idCliente=chamada.idCliente');
		$this->db->join("funcionario", 'funcionario.idFuncionario=chamada.idFuncionario', "LEFT");
		$this->db->join('chamada_pagamento', "chamada_pagamento.idChamada=chamada.idChamada", "LEFT");
		$this->db->join('chamada_pagamento_resposta', 'chamada_pagamento_resposta.status=chamada_pagamento.status', 'LEFT');
		$chamada = $this->db->get('chamada')->row();

		return $chamada;
	}
	



    /*function getByIdView($id){



        $sql = "

				SELECT 

					c.*,

					cli.*,
        			cf.*,

					cli.razaosocial as nomeCliente,

					c.idCliente as idClienteChamada

				FROM 

					chamada as c, 

					cliente as cli 
        			left join cliente_frete cf on (cf.idClienteFrete = getIdClienteFreteVigente(cli.idCliente))

				WHERE 

					c.idChamada = '".$id."' 

				AND 

					cli.idCliente = c.idCliente

		";

		 $consulta = $this->db->query($sql)->result();


		foreach($consulta as &$valor)

		{

			$sql = "

			

				SELECT c.*,

					   cli.*,
					   cf.*,

					   f.idFuncionario,

					   f.*,

					   f.nome as nomeFuncionario

				FROM chamada AS c

				INNER JOIN cliente AS cli ON c.idCliente = cli.idCliente
				inner join cliente_frete cf on (cf.idClienteFrete = getIdClienteFreteVigente(cli.idCliente))

				LEFT JOIN funcionario AS f ON c.idFuncionario = f.idFuncionario

				WHERE c.idCliente = '".$valor->idClienteChamada."'

				ORDER BY c.idChamada DESC

			

			";	

			 $valor->listaClientesView = $this->db->query($sql)->result();		 
			 
		}

		

		return $consulta;

    }
    */



    
    /*
    function add($table,$data){
        $this->db->insert($table, $data);     
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		return FALSE;
    }

	

	function cancelar($id){

		$update = "UPDATE chamada SET status = '3' WHERE idChamada = '{$id}'";

		$this->db->query($update);

	

        if ($this->db->affected_rows() >= 0)

		{

			return TRUE;

		}

		

		return FALSE;



	}

	

	function editAdicional($table,$data,$fieldID,$ID){

		

        $this->db->where($fieldID,$ID);

        $this->db->update($table, $data);



        if ($this->db->affected_rows() == '1')

		{

			return TRUE;

		}

	}
	
*/


	public function getItinerario($idClienteFreteItinerario) {
	
		$this->db->select('a.*');
		$this->db->from('cliente_frete_itinerario a');
		$this->db->where('a.idClienteFreteItinerario', $idClienteFreteItinerario);
	
		$result = $this->db->get();
// 				die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	
		return FALSE;
	}


/*
	public function atualizarDadosTabela($tabela, $dados, $where) {
	
		$this->db->where($where);
	
		$this->db->update($tabela, $dados);
	
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
	
		return FALSE;
	}
	*/
	

	/*

    function edit($table,$data,$fieldID,$ID){



		

		$idVeiculo = $data['tipo_veiculo'];

		

		if(!empty($km)){

			

			if($idVeiculo=='1') $keyCli = "valor_moto_km";

			if($idVeiculo=='2') $keyCli = "valor_carro_km";

			if($idVeiculo=='3') $keyCli = "valor_van_km";

			if($idVeiculo=='4') $keyCli = "valor_caminhao_km";

			

		} else { 

			

			if($data['tarifa']=='1' and $data['tipo_veiculo']=='1'){ $keyCli = "valor_moto_normal";}

			if($data['tarifa']=='2' and $data['tipo_veiculo']=='1'){ $keyCli = "valor_moto_depois_18"; }

			if($data['tarifa']=='3' and $data['tipo_veiculo']=='1'){ $keyCli = "valor_moto_metropolitano"; }

			if($data['tarifa']=='4' and $data['tipo_veiculo']=='1'){ $keyCli = "valor_moto_metropolitano_apos18"; }

	

			if($data['tarifa']=='1' and $data['tipo_veiculo']=='2'){ $keyCli = "valor_carro_normal"; }

			if($data['tarifa']=='2' and $data['tipo_veiculo']=='2'){ $keyCli = "valor_carro_depois_18"; }

			if($data['tarifa']=='3' and $data['tipo_veiculo']=='2'){ $keyCli = "valor_carro_metropolitano"; }

			if($data['tarifa']=='4' and $data['tipo_veiculo']=='2'){ $keyCli = "valor_carro_metropolitano_apos18"; }

			

			if($data['tarifa']=='1' and $data['tipo_veiculo']=='3'){ $keyCli = "valor_van_normal"; }

			if($data['tarifa']=='2' and $data['tipo_veiculo']=='3'){ $keyCli = "valor_van_depois_18"; }

			if($data['tarifa']=='3' and $data['tipo_veiculo']=='3'){ $keyCli = "valor_van_metropolitano"; }

			if($data['tarifa']=='4' and $data['tipo_veiculo']=='3'){ $keyCli = "valor_van_metropolitano_apos18"; }

			

			if($data['tarifa']=='1' and $data['tipo_veiculo']=='4'){ $keyCli = "valor_caminhao_normal"; }

			if($data['tarifa']=='2' and $data['tipo_veiculo']=='5'){ $keyCli = "valor_caminhao_depois_18"; }

			if($data['tarifa']=='3' and $data['tipo_veiculo']=='4'){ $keyCli = "valor_caminhao_metropolitano"; }

			if($data['tarifa']=='4' and $data['tipo_veiculo']=='4'){ $keyCli = "valor_caminhao_metropolitano_apos18"; }

		

		}



		#calculo do funcionario valor

		$sql_funcionario = "SELECT * FROM funcionario_frete WHERE idFuncionario = '".$data['idFuncionario']."'";

		$consulta_funcionario = $this->db->query($sql_funcionario)->row();



		//die('aqui:' . $this->db->last_query());

		$valorFuncionario = 0;

		if (count($consulta_funcionario) >= 1) {

			$valorFuncionario = $consulta_funcionario->$keyCli;

		}

		

		#atualiza valor da chamada

		if($data['valor_funcionario']==0){

			if(empty($km)){

				$data['valor_funcionario_novo'] = ($data['pontos']) * $valorFuncionario;

			} else { 

				$data['valor_funcionario_novo'] = ($km) * $valorFuncionario;

			}

		} else {

			$data['valor_funcionario_novo'] = $data['valor_funcionario'];	

		}

		

		$data['valor_funcionario'] = $data['valor_funcionario_novo'];



		unset($data['valor_funcionario_novo']);



        $this->db->where($fieldID,$ID);

        $this->db->update($table, $data);



        if ($this->db->affected_rows() == '1')

		{

			return TRUE;

		}

		

		return FALSE;        

    }



    function delete($table,$fieldID,$ID){

		



        $this->db->where($fieldID,$ID);

        $this->db->delete($table);

        if ($this->db->affected_rows() == '1')

		{

			return TRUE;

		}

		

		return FALSE;        

    }
	*/


    /*
	function cadastrando($tabela, $dados, $tipo_veiculo, $idFuncionario){



		if($tipo_veiculo==1) $tipo_veiculo = "moto";

		if($tipo_veiculo==2) $tipo_veiculo = "carro";

		if($tipo_veiculo==3) $tipo_veiculo = "van";

		if($tipo_veiculo==4) $tipo_veiculo = "caminhao";



		file("http://www.codigo3.com.br/app/pusher/send_message.php?action=enviar_notificacao&tipo=". $tipo_veiculo);



		$this->db->insert($tabela, $dados);
		
// 		die($this->db->last_query());

		return $this->db->insert_id();	

	}

	*/


	
	public function getParametroById($id)
	{
        $this->db->where('idParametroCategoria',$id);
        $this->db->order_by('parametro','ASC');
        return $this->db->get('parametro')->result();		
	}
	


	public function getBase($tabela, $cod, $order, $idAtual = null)
	{
		if (!is_numeric($idAtual)) $idAtual = null;
		
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by($cod, $order);
	
		if ($tabela == 'cliente') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idCliente = (select idCliente from chamada where idChamada = '.$idAtual.')');
			}
		}
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFuncionario = (select idFuncionario from chamada where idChamada = '.$idAtual.')');
			}
		}

		/*if ($tabela == 'fornecedor') {
			$this->db->where('situacao', 1);
			if ($idAtual != null) {
				$this->db->or_where('idFornecedor IN (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}
		}*/
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}

	

	public function getBaseCadastro($tabela, $cod, $order)

	{

        $this->db->order_by($cod, $order);

        return $this->db->get($tabela)->result();

	}

	

	public function addChamadaServico($dados){

		

		//echo "Nao foi possivel adicionar chamadas neste momento. Sistema em teste.";

		//die();

		

		#construção base 

		$tipoDeTarifa = 	$this->input->post('tarifa');

		$idVeiculo = 		$this->input->post('tipo_veiculo');

		$idFuncionario = 	$this->input->post('idFuncionario');

		$idCliente = 		$this->input->post('idCliente');

		$km = 				$this->input->post('km');

		$v_empresa = 		$this->input->post('valor_empresa');

		$v_funcionario = 	$this->input->post('valor_funcionario');

		

		if(!empty($km)){

			

			if($idVeiculo=='1') $keyCli = "valor_moto_km";

			if($idVeiculo=='2') $keyCli = "valor_carro_km";

			if($idVeiculo=='3') $keyCli = "valor_van_km";

			if($idVeiculo=='4') $keyCli = "valor_caminhao_km";

			

		} else { 

			

			if($tipoDeTarifa=='1' and $idVeiculo=='1'){ $keyCli = "valor_moto_normal"; }

			if($tipoDeTarifa=='2' and $idVeiculo=='1'){ $keyCli = "valor_moto_depois_18"; }

			if($tipoDeTarifa=='3' and $idVeiculo=='1'){ $keyCli = "valor_moto_metropolitano"; }

			if($tipoDeTarifa=='4' and $idVeiculo=='1'){ $keyCli = "valor_moto_metropolitano_apos18"; }

	

			if($tipoDeTarifa=='1' and $idVeiculo=='2'){ $keyCli = "valor_carro_normal"; }

			if($tipoDeTarifa=='2' and $idVeiculo=='2'){ $keyCli = "valor_carro_depois_18"; }

			if($tipoDeTarifa=='3' and $idVeiculo=='2'){ $keyCli = "valor_carro_metropolitano"; }

			if($tipoDeTarifa=='4' and $idVeiculo=='2'){ $keyCli = "valor_carro_metropolitano_apos18"; }

			

			if($tipoDeTarifa=='1' and $idVeiculo=='3'){ $keyCli = "valor_van_normal"; }

			if($tipoDeTarifa=='2' and $idVeiculo=='3'){ $keyCli = "valor_van_depois_18"; }

			if($tipoDeTarifa=='3' and $idVeiculo=='3'){ $keyCli = "valor_van_metropolitano"; }

			if($tipoDeTarifa=='4' and $idVeiculo=='3'){ $keyCli = "valor_van_metropolitano_apos18"; }

			

			if($tipoDeTarifa=='1' and $idVeiculo=='4'){ $keyCli = "valor_caminhao_normal"; }

			if($tipoDeTarifa=='2' and $idVeiculo=='5'){ $keyCli = "valor_caminhao_depois_18"; }

			if($tipoDeTarifa=='3' and $idVeiculo=='4'){ $keyCli = "valor_caminhao_metropolitano"; }

			if($tipoDeTarifa=='4' and $idVeiculo=='4'){ $keyCli = "valor_caminhao_metropolitano_apos18"; }

		

		}

		

		

		$sql_cliente = "

						SELECT cli.*, cf.* FROM 

							cliente cli
							left join cliente_frete cf on (cf.idClienteFrete = getIdClienteFreteVigente(cli.idCliente))

						WHERE 

							cli.idCliente = '{$idCliente}'

		";

		$consulta_cliente = $this->db->query($sql_cliente)->row();
		
		$valorhora = $consulta_cliente->$keyCli;

		

		$veic = array();

		$veic[1] = "Moto";

		$veic[2] = "Carro";

		$veic[3] = "Van";

		$veic[4] = "Caminhao";						

		

		$tip_serv = array();

		$tip_serv[0] = "ponto";

		$tip_serv[1] = "ponto";

		$tip_serv[2] = "retorno";				



		$pontoTotal = 0;

		



		for($ii=0;$ii<count($dados);$ii++){

			if(isset($dados[$ii]) and $dados[$ii] and $ii!=0){  //verifica primeiro se tem vinculo depois

				if(isset($dados[$ii+1])){

					if($dados[$ii]['cidade']!=$dados[$ii+1]['cidade']){



						//metropolitano

						$bairroReferencia = "SELECT idBairro, idTipo FROM bairro WHERE idBairro = '".$dados[$ii]['bairro']."'";

						$referencia = $this->db->query($bairroReferencia)->row('idTipo');

						

						$referenciaBase = array();

						$referenciaBase[1] = "C";

						$referenciaBase[2] = "B";

						$referenciaBase[3] = "A";

						

						//print_r($referencia);

	

						$sql = "SELECT ".($tip_serv[$dados[$ii]['tiposervico']].$veic[$idVeiculo])." as vlrFrete FROM tabelafretem WHERE idSaida = ".$dados[$ii]['cidade']." AND idDestino = ".$dados[$ii+1]['cidade']." AND referencia = '".$referenciaBase[$referencia]."'";	

											

					} else {

	 

						//local

						$sql = "SELECT ".($tip_serv[$dados[$ii]['tiposervico']].$veic[$idVeiculo])." as vlrFrete FROM tabelafrete WHERE idSaida = ".$dados[$ii]['bairro']." AND idDestino = ".$dados[$ii+1]['bairro']."";

					}



				} else {

					



					if($dados[$ii]['cidade']!=$dados[$ii-1]['cidade']){



						//metropolitano

						$bairroReferencia = "SELECT idBairro, idTipo FROM bairro WHERE idBairro = '".$dados[$ii]['bairro']."'";

						$referencia = $this->db->query($bairroReferencia)->row('idTipo');

						

						$referenciaBase = array();

						$referenciaBase[1] = "C";

						$referenciaBase[2] = "B";

						$referenciaBase[3] = "A";

						

						

						//print_r($referencia);

	

						$sql = "SELECT ".($tip_serv[$dados[$ii]['tiposervico']].$veic[$idVeiculo])." as vlrFrete FROM tabelafretem WHERE idSaida = ".$dados[$ii-1]['cidade']." AND idDestino = ".$dados[$ii]['cidade']." AND referencia = '".$referenciaBase[$referencia]."'";	

											

					} else {

	

						//local

						$sql = "SELECT ".($tip_serv[$dados[$ii]['tiposervico']].$veic[$idVeiculo])." as vlrFrete FROM tabelafrete WHERE idSaida = ".$dados[$ii-1]['bairro']." AND idDestino = ".$dados[$ii]['bairro']."";

					}

					

				}

				

				$pontos = $this->db->query($sql)->row();
				
				if (count($pontos) > 0)
					$pontoTotal += $pontos->vlrFrete;

				

				//echo $sql."<br><br>";

				//echo "<pre>";

				//print_r($pontos);

				//echo "</pre>";

			} 

		

		}		

		#calculo do funcionario valor
		if($this->input->post('idFuncionario')==""){
			$valorFuncionario = 0;	
		} else { 
			$sql_funcionario = "SELECT * FROM funcionario_frete WHERE idFuncionario = '".$idFuncionario."'";
			$consulta_funcionario = $this->db->query($sql_funcionario)->row();
			$valorFuncionario = $consulta_funcionario->$keyCli;
		}

		#atualiza valor da chamada
		if(empty($km)){

			if(empty($v_empresa)){
				$valores['valor_funcionario'] = ($pontoTotal) * $valorFuncionario;
				$valores['valor_empresa'] = ($pontoTotal) * ($valorhora);
			} else {
				$valores['valor_funcionario'] = $v_funcionario;
				$valores['valor_empresa'] = $v_empresa;
			}	

		} else { 

			if(empty($v_empresa)){
				$valores['valor_funcionario'] = ($km) * $valorFuncionario;
				$valores['valor_empresa'] = ($km) * ($valorhora);
			} else {
				$valores['valor_funcionario'] = $v_funcionario;
				$valores['valor_empresa'] = $v_empresa;
			}

		}
		

		$valores['pontos'] = $pontoTotal;
        $this->db->where('idChamada',$dados[0]['idChamada']);
        $this->db->update('chamada', $valores);		

		#insere dados na tabela
		$this->db->insert_batch('chamada_servico', $dados); 

	}


	public function getItinerarios($idCliente) {
		
		$sqlIdClienteVigencia = 
			'SELECT idClienteFrete 
			 FROM cliente_frete 
			 WHERE idCliente = ' . $idCliente . '
			 AND vigencia_final is null
			 ORDER BY vigencia_inicial desc
			 LIMIT 1';
	
		$this->db->select('a.*, b.idClienteFreteItinerarioServico, b.tiposervico, b.endereco, b.numero, b.bairro, b.cidade, b.falarcom');
		$this->db->select("ELT(FIELD(a.tipo_veiculo, 1,2,3,4), 'Moto', 'Carro', 'Van', 'Caminhão') nomeTipoVeiculo", false);
		$this->db->select("ELT(FIELD(a.retorno, 0,1), 'Não', 'Sim') nomeRetorno", false);
		$this->db->from('cliente_frete_itinerario a');
		$this->db->join('cliente_frete_itinerario_servicos b', 'a.idClienteFreteItinerario = b.idClienteFreteItinerario', 'left');
		$this->db->join('cliente_frete c', 'a.idClienteFrete = c.idClienteFrete', 'left');
		$this->db->where('a.idClienteFrete = ('.$sqlIdClienteVigencia.')');
		$this->db->order_by('a.nome asc');
	
		$result = $this->db->get();
// 				die($this->db->last_query());
		if ($this->db->affected_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	
		return FALSE;
	}
	
	
	
	
}

