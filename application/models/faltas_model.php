<?php
class faltas_model extends CI_Model {

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
	
		/*if (is_numeric($id)) {
			$this->db->where('(situacao = 1 OR idCedente = (select idCedente from folhapagamento_parametro where idFolhaParametro = '.$id.') )');
		}
		else {*/
			$this->db->where('situacao', 1);
		//}
	
		$this->db->order_by('razaosocial');
	
		$result = $this->db->get($tabela);
		//die($this->db->last_query());
		if ($this->db->affected_rows() > 0) {
			return  $result->result();
		}
	
		return false;
	
	}
	
	// Parametrização das faltas na hora de Editar
	public function getRegistrosParametros($tabela=NULL, $campo=NULL, $requisitado=NULL, $id=NULL, $tipo=NULL){
		
		if($tipo=='unico'){
			$this->db->where($campo, $id);
			return $this->db->get($tabela)->row($requisitado);
		} else {
			$this->db->where("idParametroCategoria", $id);
			return $this->db->get($tabela)->result();
		}
		
	}

	public function getRegistrosFuncionarios($codCedente){
			$this->db->select('funcionario_dadosregistro.idFuncionario, funcionario_dadosregistro.empresaregistro, funcionario.nome');
			$this->db->join('funcionario', 'funcionario.idFuncionario=funcionario_dadosregistro.idFuncionario');
			$this->db->order_by('funcionario.nome', 'ASC');
			$this->db->where('empresaregistro', $codCedente);
			return $this->db->get('funcionario_dadosregistro')->result();	
	}
	
	function getPesquisar(){
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->db->select("falta.*, funcionario.idFuncionario, funcionario.nome as nomeFuncionario, parametro.parametro as nomeParametro, p.parametro as nomeJustificativa
		");
			
		if($this->input->post('idFuncionarioLista')){ $this->db->where('falta.idFuncionario', $this->input->post('idFuncionarioLista')); }
		if($this->input->post('idParametro')){ $this->db->where('falta.idParametro', $this->input->post('idParametro')); }
		if($this->input->post('idTipo')){ $this->db->or_where_in('falta.idTipo', $this->input->post('idTipo')); }
		if($this->input->post('data_inicial') and $this->input->post('data_final')){ $this->db->where("falta.data_solicitado BETWEEN '".$this->input->post('data_inicial')."' AND '".$this->input->post('data_final')."'"); }
		
		$this->db->where('funcionario.idEmpresa', $idEmpresa);
		
		$this->db->join("funcionario", "funcionario.idFuncionario=falta.idFuncionario", "LEFT");		
		$this->db->join("parametro", "parametro.idParametro=falta.idTipo", "LEFT");
		$this->db->join("parametro p", "p.idParametro=falta.idParametro", "LEFT");
		
		$this->db->order_by('falta.data_solicitado', 'DESC');
		$consulta = $this->db->get('falta')->result();
		
		return $consulta;
	}

	
	   
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
		if($start==NULL || !is_numeric($start)) $start = 0;
		if (!is_numeric($perpage)) $perpage = 0;
				
				$sql = "
						SELECT 
							p.*, 
							f.idFuncionario, 
							f.nome AS nomeFuncionario, 
							pa.parametro AS  nomeParametro,
							pr.parametro as nomeJustificativa
						FROM
							falta AS p, 
							funcionario AS f, 
							parametro AS pa,
							parametro AS pr 
						WHERE 
							p.idFuncionario = f.idFuncionario 
						AND
							f.idEmpresa = ".$idEmpresa."
						AND 
							pa.idParametro = p.idTipo 
						AND 
							pr.idParametro = p.idParametro
						ORDER BY p.data_solicitado DESC
						LIMIT  $start, $perpage
				";
			return $this->db->query($sql)->result();
    }


	function getFuncionarioAtividade($id=NULL){
		
		/*
			Falta Justificada: ID 897
		*/
		$montaSQL['tabela'] = NULL;
		
		$this->db->select("idFuncionario, funcao, cargahorariacompleta, cargahorariadiaria");
		$this->db->where('idFuncionario', $id);
		$consulta = $this->db->get('funcionario_dadosregistro')->result();
		
			foreach($consulta as &$valor){ 
				
				# Buscando salário da função em Questão
				$this->db->select("idFolhaParametro, salario");
				$this->db->where('idParametro', $valor->funcao);
				$valor->dados_salario = $this->db->get('folhapagamento_parametro')->row();
				
				# Buscando ID BASE Parametro
				$this->db->where('idParametro', $this->input->post('idParametro'));
				$valor->dados_parametro = $this->db->get('parametro')->row('idParametroCategoria');
				
				if($valor->dados_parametro==897){
					$montaSQL['tabela'] = "folhapagamento_faltajust";	
				}
				
				# Buscando Parâmetros para calcular
				$sql = "
						SELECT 
							c1.tipo as tipoSQL, 
							c1.formato, 
							c2.valor, 
							c2.data 
						FROM 
							".$montaSQL['tabela']." as c1 
						JOIN 
							provento AS c2 
						ON (c1.tipo=c2.tipo) 
						WHERE c2.idFuncionario = '".$id."'";
				
				//$this->db->where('idFolhaParametro', $valor->dados_salario->idFolhaParametro);
				$valor->dados_calculo = $this->db->query($sql)->result();
				
					foreach($valor->dados_calculo as $valor_calc){
						if($valor_calc->formato == 1){
							$base_de_calculo = 30;
							$calcular = $valor->dados_salario->salario / $base_de_calculo;	
						}						
					}
					
					//echo $calcular;
				
				//echo $montaSQL['tabela'];
				
			}
		return $consulta;
	}
		
    function getById($id){
		
        $this->db->where('idFalta',$id);
        $this->db->limit(1);
        return $this->db->get('falta')->row();
		
		
    }
    
	function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return $this->db->insert_id();
		}
		
		return FALSE;       
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
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }

    function count($table) {
        return $this->db->count_all($table);
    }
    
	
	public function getBase($tabela, $cod, $order)
	{
		$idEmpresa = $this->session->userdata['idCliente'];
		$this->db->where('idEmpresa', $idEmpresa);
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
		
	}
	
    function getByIdView($id){

        $sql = "
				SELECT 
					f.*,
					fn.nome as nomeFuncionario,
					fn.idFuncionario
				FROM
					falta AS f,
					funcionario AS fn
				WHERE
					f.idFalta = '".$id."'
				AND
					fn.idFuncionario = f.idFuncionario
		";
		 $consulta = $this->db->query($sql)->result();
		 
		 	foreach($consulta as &$valor)
			{
				$sql = "
							SELECT 
								f.*,
								p.parametro as nomeParametro,
								p.idParametro
							FROM
								falta AS f,
								parametro AS p
							WHERE
								f.idFuncionario = '".$valor->idFuncionario."'
				"; //AND f.tipo = p.idParametro
				
				$valor->listaFaltas = $this->db->query($sql)->result();
				
			}
		 
		
		return $consulta;
    }

}