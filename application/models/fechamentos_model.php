<?php
class fechamentos_model extends CI_Model {

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

	public function getBase($tabela, $cod, $order)
	{
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
	}
	
	# Fechamento Funcionário
    public function fechamentoFuncionario($idFuncionario = null, $data_inicial = null,$data_final = null, $view = null){
		
		
		$ref_data = "";
		if($data_inicial and $data_final){
			$ref_data = " c1.data BETWEEN '".$data_inicial."' AND '".$data_final."'";
		}

		
		$ref_idfuncionario = "";
		if($idFuncionario){
			$ref_idfuncionario = " AND c1.idFuncionario = '".$idFuncionario."'";
		}
		
		$sql = "
			SELECT c1.* , (valor_empresa) as valor_empresa_total, (valor_funcionario) as valor_funcionario_total,  c2.nome as nome_funcionario, c3.razaosocial as nome_empresa, c4.razaosocial as nome_cedente, c5.idClienteResponsavel, c5.nome as nome_solicitante, c3.cnpj as cnpj_empresa
			FROM chamada as c1
			LEFT JOIN funcionario c2 USING(idFuncionario)
			LEFT JOIN cliente c3 USING(idCliente)
			LEFT JOIN cedente c4 ON(c4.idCedente=c3.codCedente)
			LEFT JOIN cliente_responsaveis c5 ON(c1.solicitante=c5.idClienteResponsavel)
			WHERE ".$ref_data."	".$ref_idfuncionario." AND c1.status = '2'
			ORDER BY c3.razaosocial ASC
		";
		
		$consulta = $this->db->query($sql)->result();

		foreach($consulta as &$valor){
			$sql2 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'C'
				AND modulo = 'cliente'
			";
			$adicional = $this->db->query($sql2)->result();
			$valor->adicionais_credito = $adicional;

			$sql3 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'D'
				AND modulo = 'cliente'
			";
			$adicional_debito = $this->db->query($sql3)->result();
			$valor->adicionais_debito = $adicional_debito;

		}
		
		return $consulta;



    }


	
	public function fechamentoChamada2($data_inicial = null, $data_final = null, $idCliente = null, $idFuncionario = null, $view = null){

		$ref_data = "";
		if($data_inicial and $data_final){
			$ref_data = " c1.data BETWEEN '".$data_inicial."' AND '".$data_final."'";
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
			SELECT c1.* , (valor_empresa) as valor_empresa_total, (valor_funcionario) as valor_funcionario_total,  c2.nome as nome_funcionario, c3.razaosocial as nome_empresa, c4.razaosocial as nome_cedente, c5.idClienteResponsavel, c5.nome as nome_solicitante, c3.cnpj as cnpj_empresa
			FROM chamada as c1
			LEFT JOIN funcionario c2 USING(idFuncionario)
			LEFT JOIN cliente c3 USING(idCliente)
			LEFT JOIN cedente c4 ON(c4.idCedente=c3.codCedente)
			LEFT JOIN cliente_responsaveis c5 ON(c1.solicitante=c5.idClienteResponsavel)
			WHERE ".$ref_data." ".$ref_idcliente."	".$ref_idfuncionario." AND c1.status = '2'
			ORDER BY c3.razaosocial ASC
		";
		
		$consulta = $this->db->query($sql)->result();

		foreach($consulta as &$valor){
			$sql2 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'C'
				AND modulo = 'cliente'
			";
			$adicional = $this->db->query($sql2)->result();
			$valor->adicionais_credito = $adicional;

			$sql3 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'D'
				AND modulo = 'cliente'
			";
			$adicional_debito = $this->db->query($sql3)->result();
			$valor->adicionais_debito = $adicional_debito;

		}
		
		return $consulta;
	}
}
?>