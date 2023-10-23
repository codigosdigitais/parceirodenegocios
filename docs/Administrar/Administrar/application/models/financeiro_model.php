<?php
class financeiro_model extends CI_Model {

    function __construct() {
        parent::__construct();
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
	

	public function getListaCedentesBase($id) {
		 
		$tabela = "cedente";
		 
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
	
		if (is_numeric($id)) {
			$this->db->where('(situacao = 1 OR idCedente = (select idCedente from folhapagamento_parametro where idFolhaParametro = '.$id.') )');
		}
		else {
			$this->db->where('situacao', 1);
		}
	
		$this->db->order_by('razaosocial');
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
    public function limpa_dados_anteriores($id, $tabela, $campo)
    {
		$this->db->where($campo, $id);
		$this->db->delete($tabela);  
        
		if ($this->db->affected_rows() > 0)
			return true;
		
		return false;
    }
	
	
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);
		
        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
	
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		}
		
		return FALSE;       
    }
	
    function add_batch($table,$data){
		$ids = array();
		foreach ($data as $dado) {
			$this->db->insert($table, $dado);
		
			if ($this->db->affected_rows() == '1') {
				array_push($ids, $this->db->insert_id());
			}
		}
		if (count($ids) > 0) return $ids;
		return false;
    }
	

	function getParametrosGlobaisByStorage($categoria=NULL, $idFolhaParametro=NULL){
		$this->db->where('categoria',$categoria);
		$this->db->where('idFolhaParametro',$idFolhaParametro);
		$this->db->order_by('idFolhaStorage', 'ASC');
		return $this->db->get('folhapagamento_storages')->result();
	}
	
	function getParametrosGlobaisByIDResult($tabela=NULL, $idFolhaParametro=NULL){
		$this->db->where('idFolhaParametro',$idFolhaParametro);
		return $this->db->get($tabela)->result();
	}	
	
	function getParametrosGlobaisByID($id){
		$sql = "
			SELECT * FROM folhapagamento_parametro AS c1
			WHERE c1.idFolhaParametro = '".$id."'
		";
		$consulta = $this->db->query($sql)->result();
		

			foreach($consulta as &$valor){
				$valor->consulta_inss = $this->getParametrosGlobaisByStorage('inss', $id);	
				$valor->consulta_irr = $this->getParametrosGlobaisByStorage('irr', $id);
				$valor->consulta_familia = $this->getParametrosGlobaisByStorage('familia', $id);
				$valor->consulta_insalubridade = $this->getParametrosGlobaisByStorage('insalubridade', $id);
				
				$valor->consulta_desconto = $this->getParametrosGlobaisByIDResult('folhapagamento_desconto', $id);
				$valor->consulta_provento = $this->getParametrosGlobaisByIDResult('folhapagamento_provento', $id);
				
				$valor->consulta_faltasjust = $this->getParametrosGlobaisByIDResult('folhapagamento_faltajust', $id);
				$valor->consulta_faltasinjust = $this->getParametrosGlobaisByIDResult('folhapagamento_faltainjust', $id);
				$valor->consulta_atrasosjust = $this->getParametrosGlobaisByIDResult('folhapagamento_atrasojust', $id);
				$valor->consulta_atrasosinjust = $this->getParametrosGlobaisByIDResult('folhapagamento_atrasoinjust', $id);
				$valor->consulta_folha_inss = $this->getParametrosGlobaisByIDResult('folhapagamento_inss', $id);
			}
		
			
		return $consulta;
		
	}
	

	# Listagem de Parametros Globais
	function getParametrosGlobais(){
		
		$consulta = $this->db
							->select('idCedente, razaosocial, cnpj')
							->where('idCedente', 5)
							->get('cedente')
							->row();
		
		$consulta->parametros = $this->db
										->select("c1.*, c2.parametro")
										->where("c1.idCedente", $consulta->idCedente)
										//->where("c2.idParametro", '969')
										->join("parametro AS c2", "c2.idParametro=c1.idParametro")
										->order_by("c2.parametro", "ASC")
										->get('folhapagamento_parametro AS c1')
										->result();

		return $consulta;

	}
	
	
	
	public function getTiposProventos(){
		$this->db->where("idParametroCategoria", '518');
		$this->db->order_by("parametro", "ASC");
		return $this->db->get('parametro')->result();	
	}
	
	public function getTiposDescontosAdicionais(){
		$this->db->where("idParametroCategoria", '518');
		$this->db->order_by("parametro", "ASC");
		return $this->db->get('parametro')->result();	
	}
	
	public function getTiposProventosAdicionais(){
		$this->db->where("idParametroCategoria", '819');
		$this->db->order_by("parametro", "ASC");
		return $this->db->get('parametro')->result();	
	}
	
	
	public function getTiposAtividade(){
		$this->db->where("idParametroCategoria", '969'); // OLD 889
		$this->db->order_by("parametro", "ASC");
		return $this->db->get('parametro')->result();	
	}

	public function getBase($tabela, $cod, $order) //, $idAtual = null
	{
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$this->db->where('idEmpresa', $idEmpresa);
		$this->db->order_by($cod, $order);
	
		if ($tabela == 'cliente') {
			$this->db->where('situacao', 1);
			/*if ($idAtual != null) {
				$this->db->or_where('idCliente = (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}*/
		}
	
		if ($tabela == 'funcionario') {
			$this->db->where('situacao', 1);
			/*if ($idAtual != null) {
				$this->db->or_where('idFuncionario IN (select idAdministrador from documento where idDocumento = '.$idAtual.')');
			}*/
		}
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
	# Fechamento Funcionário
    public function fechamentoFuncionario($view = null, $idFuncionario = null, $data_inicial = null,$data_final = null){
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
		$ref_data = "";
		if($data_inicial and $data_final){
			$ref_data = " c1.data BETWEEN '".$data_inicial."' AND '".$data_final."'  ";
		}

		
		$ref_idfuncionario = "";
		if($idFuncionario){
			$ref_idfuncionario = " AND c1.idFuncionario = '".$idFuncionario."'";
		}
		
		$sql = "

				SELECT 
					c1.* , 
					SUM(if(idChamada IS NOT NULL, valor_funcionario, 0)) as valor_empresa_total,
					c3.nome as nome_funcionario,
					c4.razaosocial as nome_cedente,
					SUM(if(idChamada IS NOT NULL, 1, 0)) as total_por_agrupamento,
					c3.idFuncionario
				FROM 
					chamada AS c1
					LEFT JOIN funcionario AS c3 USING(idFuncionario)
					LEFT JOIN funcionario_dadosregistro AS c6 ON(c6.idFuncionario=c1.idFuncionario)
					LEFT JOIN cedente AS c4 ON(c4.idCedente=c6.empresaregistro)
				WHERE 
					".$ref_data."
					".$ref_idfuncionario." 
					AND c1.status = '2' 
					AND c3.idEmpresa = ".$idEmpresa."
					AND c4.idEmpresa = ".$idEmpresa."
					GROUP BY c1.idFuncionario
				ORDER BY c3.nome ASC
		";
		
		//echo $sql;
		
		$consulta = $this->db->query($sql)->result();
		
		


		foreach($consulta as &$valor){
			$sql2 = "
				SELECT  SUM(IF(tipoValor='C', valor, 0)) as total_credito , SUM(IF(tipoValor='D', valor, 0)) as total_debito
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idFuncionario."' AND modulo = 'funcionario'
				GROUP BY idAdministrativo		
			";
			$adicional = $this->db->query($sql2)->result();
			$valor->adicionais = $adicional;
		}
		
		//echo "<pre>";
		//print_r($consulta);
		//echo "</pre>";
		
		//die();
		
		return $consulta;
    }
	
	public function fechamentoChamada($data_inicial = null, $data_final = null, $idCliente = null, $idFuncionario = null, $view = null){
		
		$ref_data = "";
		if($data_inicial and $data_final){
			$ref_data = " c1.data BETWEEN '".$data_inicial."' AND '".$data_final."'  ";
		}
		$ref_idcliente = "";
		if($idCliente){
			$ref_idcliente = " AND c1.idCliente='".$idCliente."'";
		}
		
		$ref_idfuncionario = "";
		if($idFuncionario){
			$ref_idfuncionario = " AND c1.idFuncionario = '".$idFuncionario."'";
		}
		
		$sql = "

				SELECT 
					c1.* , 
					SUM(if(idChamada IS NOT NULL, valor_empresa, 0)) as valor_empresa_total,
					c3.razaosocial as nome_empresa,
					c4.razaosocial as nome_cedente,
					SUM(if(idChamada IS NOT NULL, 1, 0)) as total_por_agrupamento,
					c5.idParametro,
					c5.parametro as nota_fiscal,
					c3.idCliente
				FROM 
					chamada AS c1
					JOIN cliente AS c3 USING(idCliente)
					JOIN cedente AS c4 ON(c4.idCedente=c3.codCedente)
					JOIN parametro AS c5 ON(c5.idParametro = c3.nota)
				WHERE 
					".$ref_data."
					".$ref_idcliente."
					".$ref_idfuncionario." 
					AND c1.status = '2' 

					GROUP BY c1.idCliente
				ORDER BY c3.razaosocial ASC
		";
		
		$consulta = $this->db->query($sql)->result();

		foreach($consulta as &$valor){
			$sql2 = "
				SELECT  SUM(IF(tipoValor='C', valor, 0)) as total_credito , SUM(IF(tipoValor='D', valor, 0)) as total_debito
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."' AND modulo = 'cliente'
				GROUP BY idAdministrativo		
			";
			$adicional = $this->db->query($sql2)->result();
			$valor->adicionais = $adicional;
		}
		
		
		return $consulta;
	}
	
	
	public function fechamentoParticular(){
	
		$this->db->select('funcionario.nome as nome_funcionario, count(funcionario.idFuncionario) as total_lista, chamada.*');
		$this->db->join('funcionario', 'funcionario.idFuncionario=chamada.idFuncionario');
		if(!empty($_GET['idFuncionario'])){ $this->db->where('idFuncionario', $_GET['idFuncionario']); }
		if(!empty($_GET['data_inicial']) and !empty($_GET['data_final'])){ $this->db->where("data BETWEEN '".$_GET['data_inicial']."' AND '".$_GET['data_final']."'"); }
		$this->db->where('chamada.idCliente', '153');
		$this->db->order_by('funcionario.nome', 'ASC');
		$this->db->group_by('idFuncionario');
		$consulta = $this->db->get('chamada')->result();
		
			foreach($consulta as &$valor){
				$this->db->select('chamada.*, cliente_responsaveis.nome as nome_solicitante');
				$this->db->join('cliente_responsaveis', 'cliente_responsaveis.idClienteResponsavel=chamada.solicitante', 'LEFT');
				if(!empty($_GET['idFuncionario'])){ $this->db->where('idFuncionario', $_GET['idFuncionario']); }
				if(!empty($_GET['data_inicial']) and !empty($_GET['data_final'])){ $this->db->where("data BETWEEN '".$_GET['data_inicial']."' AND '".$_GET['data_final']."'"); }
				$this->db->where('chamada.idFuncionario', $valor->idFuncionario);
				$this->db->where('chamada.idCliente', '153');	
				$valor->lista_particular = $this->db->get('chamada')->result();
			}
			
		return $consulta;
	}
	

	
}
?>