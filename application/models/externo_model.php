<?php
class externo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
	public function listaModulosBase(){
        $this->db->where('idModuloBase',"0");
        return $this->db->get('modulos')->result();	
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
	
    public function alterarSenha($senha,$oldSenha,$id){
        $this->db->where('idCliente', $id);
        $this->db->limit(1);
        $usuario = $this->db->get('cliente')->row();
		
		echo $usuario->senha;

        if($usuario->senha != $oldSenha){
           	return false;
        }
        else{
            $this->db->set('senha',$senha);
            $this->db->where('idCliente',$id);
            return $this->db->update('cliente');    
        }
    }	
	
    function getById($id){
		$this->db->select('razaosocial, idCliente, email, senha, responsavel');
		$this->db->where('idCliente', $id);
		$consulta = $this->db->get('cliente')->row();
        return $consulta;
    }

	function getChamadasFuncionario(
										$idFuncionario=null, 
										$data_inicial = null, 
										$data_final = null, 
										$idCliente = null, 
										$view = null
									)
		{

		$where = "WHERE c1.idFuncionario = '".$idFuncionario."' ";

		$ref_data = "";
		if($this->input->get('dataInicial') and $this->input->get('dataFinal')){
			$ref_data = " AND c1.data BETWEEN '".$this->input->get('dataInicial')."' AND '".$this->input->get('dataFinal')."'";
		}

		$sql = "
			SELECT c1.* , (valor_empresa) as valor_empresa_total, (valor_funcionario) as valor_funcionario_total,  c2.nome as nome_funcionario, c3.razaosocial as nome_empresa, c4.razaosocial as nome_cedente, c5.idClienteResponsavel, c5.nome as nome_solicitante, c3.cnpj as cnpj_empresa
			FROM chamada as c1
			LEFT JOIN funcionario c2 USING(idFuncionario)
			LEFT JOIN cliente c3 USING(idCliente)
			LEFT JOIN cedente c4 ON(c4.idCedente=c3.codCedente)
			LEFT JOIN cliente_responsaveis c5 ON(c1.solicitante=c5.idClienteResponsavel)
			".$where." ".$ref_data." AND c1.status = '2'
			ORDER BY c1.data DESC
		";

		$consulta = $this->db->query($sql);

		if ($this->db->affected_rows() > 0) {
			$consulta = $consulta->result();

			foreach ($consulta as &$valor) {
				$sql2 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '" . $data_inicial . "' AND '" . $data_final . "' and idAdministrativo='" . $valor->idCliente . "'
				AND tipoValor = 'C'
			";
				$adicional = $this->db->query($sql2)->result();
				$valor->adicionais_credito = $adicional;

				$sql3 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '" . $data_inicial . "' AND '" . $data_final . "' and idAdministrativo='" . $valor->idCliente . "'
				AND tipoValor = 'D'
			";
				$adicional_debito = $this->db->query($sql3)->result();
				$valor->adicionais_debito = $adicional_debito;

			}

			return $consulta;
		}
		return false;
	}
	# Listagem de Chamadas - Base
	public function getChamadas($data_inicial = null, $data_final = null, $idCliente = null, $idFuncionario = null, $view = null){
		
		$idCliente = $this->session->userdata('idAcessoExterno');
		$where = "WHERE c1.idCliente != '' ";

		$ref_data = "";
		if($this->input->get('dataInicial') and $this->input->get('dataFinal')){
			$ref_data = " AND c1.data BETWEEN '".$this->input->get('dataInicial')."' AND '".$this->input->get('dataFinal')."'";
		}
		//$ref_idcliente = "";
		//if($idCliente){
			$ref_idcliente = " AND c1.idCliente='".$idCliente."'";
		//}
		
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
			".$where." ".$ref_data." ".$ref_idcliente."	".$ref_idfuncionario."
			ORDER BY c1.data DESC
		";

		//  AND c1.status = '2'
		
		$consulta = $this->db->query($sql)->result();
		foreach($consulta as &$valor){
			$sql2 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'C'
			";
			$adicional = $this->db->query($sql2)->result();
			$valor->adicionais_credito = $adicional;

			$sql3 = "
				SELECT  *
				FROM adicional c1
				WHERE data BETWEEN '".$data_inicial."' AND '".$data_final."' and idAdministrativo='".$valor->idCliente."'
				AND tipoValor = 'D'
			";
			$adicional_debito = $this->db->query($sql3)->result();
			$valor->adicionais_debito = $adicional_debito;

		}
		
		return $consulta;

	}
	
	# Chamada por ID
	public function getChamadaById($id){

	
		$this->db->select("
			chamada.*, 
				cliente_responsaveis.nome as solicitante, 
					(CASE chamada.tarifa 
						when 1 then 'Tarifa Normal'
						when 2 then 'Tarifa Após as 18h'
						when 3 then 'Tarifa Metropolitana'
						when 4 then 'Tarifa Metroplitana Após as 18h'
					END) AS tarifa,
					(CASE chamada.tipo_veiculo 
						when 1 then 'Base - Moto'
						when 2 then 'Médio - Carro'
						when 3 then 'Intermediário - Van'
						when 4 then 'Grande Porte - Caminhão'
					END) AS tipo_veiculo,
			cliente.razaosocial as cliente_razaosocial, 
			cliente.cnpj as cliente_cnpj,
			cedente.razaosocial as cedente_razaosocial,
			cedente.cnpj as cedente_cnpj
		");
		$this->db->where('chamada.idChamada', $id);
		$this->db->join('cliente', 'cliente.idCliente=chamada.idCliente');
		$this->db->join('cliente_responsaveis', 'cliente_responsaveis.idClienteResponsavel=chamada.solicitante', 'LEFT');
		$this->db->join('cedente', 'cedente.idCedente=cliente.codCedente');
		$consulta = $this->db->get('chamada')->result();

		foreach($consulta as &$valor){
			if($valor->idCliente==$this->session->userdata('idAcessoExterno')){
				
				$this->db->select('*, (SELECT bairro FROM bairro WHERE idBairro = chamada_servico.bairro) as bairro, (SELECT cidade FROM cidade WHERE idCidade = chamada_servico.cidade) as cidade');
				$this->db->where('idChamada', $id);
				$valor->servicos = $this->db->get('chamada_servico')->result();
			
			} else {
				redirect(base_url('externo/chamadas'));
			}
		}
		
		return $consulta;
	}
	

}