<?php
/*
* @autor: Davi Siepmann
* @date: 21/09/2015
*/
class financiamento_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * @autor: Davi Siepmann
     * @date: 22/10/2015
     */
    function getListaEmprestimosExternos($idAcessoExterno){
    	$idEmpresa = $this->session->userdata['idCliente'];
    	 
    	$sql = 'SELECT `a`.*, `b`.`nome`, IFNULL(c.nomefantasia, g.nomefantasia) as nomefantasia
    			FROM (`emprestimos_grava_financiamento` a)
    			LEFT JOIN `funcionario` b ON `a`.`idFuncionario` = `b`.`idFuncionario`
    			LEFT JOIN `cedente` c ON `a`.`idCedente` = `c`.`idCedente`
    			LEFT JOIN `cliente` g ON `g`.`idCliente` = '.$idEmpresa .'
    			RIGHT JOIN `cliente` f ON `f`.`idCliente` = `a`.`idFornecedor`
    			WHERE `a`.`idEmpresa` = '.$idEmpresa .'
    			AND `f`.`idCliente` = '.$idAcessoExterno.'
    			ORDER BY `a`.`dataSolicitacao` desc, `a`.`idEmprestimo` DESC';
    
    	$query = $this->db->query($sql);
    	
    	if (0 < $this->db->affected_rows()) {
    		
    		return $query->result();
    	}
    	else return NULL;
    }
    
    /*
     * @autor: Davi Siepmann
     * @date: 09/10/2015
     */
    function getListaFinanciamentos($tipoEmprestimo){
    	$idEmpresa = $this->session->userdata['idCliente'];
    	
    	$sql = 'SELECT `a`.*, `b`.`nome`, IFNULL(c.nomefantasia, g.nomefantasia) as nomefantasia,
    			f.nomefantasia as nomefornecedor
    			FROM (`emprestimos_grava_financiamento` a) 
    			LEFT JOIN `funcionario` b ON `a`.`idFuncionario` = `b`.`idFuncionario` 
    			LEFT JOIN `cedente` c ON `a`.`idCedente` = `c`.`idCedente` 
    			LEFT JOIN `cliente` g ON `g`.`idCliente` = '.$idEmpresa .'
    			LEFT JOIN `fornecedor` f ON `f`.`idFornecedor` = `a`.`idFornecedor`
    			WHERE `a`.`idEmpresa` = '.$idEmpresa .'
    			AND `a`.`tipoEmprestimo` = "'.$tipoEmprestimo.'"
    			ORDER BY `a`.`dataSolicitacao` desc, `a`.`idEmprestimo` DESC';
		
		$query = $this->db->query($sql);
		
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
    }
    
	/*
	 * @autor: Davi Siepmann
	 * @date: 16/10/2015
	 */
    function getListaFornecedoresEmprestimo($idFornecedor) {
    	$idEmpresa = $this->session->userdata['idCliente'];
    	
    	$this->db->from('fornecedor a');
    	$this->db->where(array("a.idEmpresa" => $idEmpresa));
    	$this->db->where("a.situacao", 1);
    	
    	if (null != $idFornecedor) $this->db->where(array("a.idFornecedor" => $idFornecedor));
    	
    	$query = $this->db->get();
    	
    	if (0 < $this->db->affected_rows()) {
    		return $query->result();
    	}
    	else return NULL;
    }

    function getIdEmpresaPeloIdFuncionario($idFuncionario) {
    	$this->db->from('funcionario a');
    	$this->db->where(array("a.idFuncionario" => $idFuncionario));
    	
    	$query = $this->db->get();
    	
    	if (0 < $this->db->affected_rows()) {
    		$result = $query->result();
    		
    		return $result[0]->idEmpresa;
    	}
    	else return NULL;
    }

    /*
     * @autor: Davi Siepmann
     * @date: 01/03/2016
     */
    function isSenhaFuncionarioOK($idFuncionario, $senha) {
    	
    	//return true; //privisorio
    	
    	//################################################################################
    	//vai precisar tratar esta senha antes de buscar
    	
    	$this->db->from('sis_usuario a');
    	$this->db->where(array("a.idFuncionario" => $idFuncionario, "a.senha" => $senha));
    	
    	$query = $this->db->get();
    	
    	if ($this->db->affected_rows() > 0) {
    		return true;
    	}
    	return false;
    }
    
    /*
     * @autor: Davi Siepmann
     * @date: 22/10/2015
     */
    function existeParamFuncionarioXCedente($idFuncionario, $idCedente, $idParametro) {
    	
    	$paramCedentes = $this->buscaParamFuncionario($idFuncionario);
    	
    	foreach ($paramCedentes as $param) {
    	/*
    	 * esta checagem � para evitar que aconte�a do usu�rio tentar lan�ar um empr�stimo para outra empresa /cedente
    	 * caso par�metro para funcion�rio e cedente existam OK
    	 * caso n�o exista par�metro por funcion�rio e cedente, mas exista par�metro geral na empresa, e requisi��o POST
    	 * foi enviada contendo 0 == idCedente OK
    	 */
    		if ($param->idParametro == $idParametro ||
    			$param->idFuncionario == '' && $idCedente == 0)
    			return true;
    	}
    	
    	return false;
    }
    
	/*
	 * @autor: Davi Siepmann
	 * @date: 27/09/2015
	 */
	function buscaParamFuncionario($idFuncionario) {
		
		$sql = 'SELECT 
					c.nomefantasia, a.idParametro, a.idCedente, a.idFuncionario, a.emp_max_valor, a.emp_max_comprometimento, 
					a.emp_max_parcelas, a.emp_tx_juros, a.financ_max_valor, a.financ_max_comprometimento, a.financ_max_parcelas, a.financ_tx_juros, 
					e.emp_periodo emp_periodo, e.emp_tipo emp_tipo,	e.financ_periodo financ_periodo, e.financ_tipo financ_tipo,
					IFNULL(f.salario, "0.00") salario
				FROM 
					emprestimos_parametros a
				LEFT JOIN
					funcionario_remuneracao f ON (f.idFuncionario = "'.($idFuncionario).'"),
				    emprestimos_habilita_cedentes b
				LEFT JOIN
					cedente c ON b.idCedente = c.idCedente
                LEFT JOIN
                	emprestimos_parametros e ON b.idCedente = e.idCedente and e.idFuncionario is null
				WHERE 
					a.idFuncionario = "'.($idFuncionario).'"
				    and a.idCedente = b.idCedente
				    and a.idCedente in (SELECT c.empresaregistro FROM `funcionario_dadosregistro` c where c.idFuncionario = "'.($idFuncionario).'")
				    and b.habilitado = 1
				    OR
				    (
				        a.idFuncionario is null
				        and a.idCedente = b.idCedente
				        and b.habilitado = 1
				        and a.idCedente in (SELECT c.empresaregistro FROM `funcionario_dadosregistro` c where c.idFuncionario = "'.($idFuncionario).'")
				        and (
				            select d.idFuncionario 
				            from emprestimos_parametros d
				            where d.idFuncionario = "'.($idFuncionario).'"
				            and d.idCedente = b.idCedente
				            limit 1
				        ) is null
				    )';
		
		$result = $this->db->query($sql);
		
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		if (0 == $this->db->affected_rows()) {
			$idEmpresa = $this->session->userdata['idCliente'];
		
			$sql = 'SELECT
					g.nomefantasia, a.idParametro, a.idCedente, a.idFuncionario, a.emp_max_valor, a.emp_max_comprometimento, 
					a.emp_max_parcelas, a.emp_tx_juros, a.financ_max_valor, a.financ_max_comprometimento, a.financ_max_parcelas, a.financ_tx_juros, 
					0 idCedente,
					e.emp_periodo emp_periodo, e.emp_tipo emp_tipo,	e.financ_periodo financ_periodo, e.financ_tipo financ_tipo,
					IFNULL(f.salario, "0.00") salario
				FROM
					emprestimos_parametros a
				LEFT JOIN
					funcionario_remuneracao f ON (f.idFuncionario = "'.($idFuncionario).'"),
				    emprestimos_habilita_cedentes b
				LEFT JOIN
					cedente c ON b.idCedente = c.idCedente
                LEFT JOIN
                	emprestimos_parametros e ON e.idEmpresa = "'.$idEmpresa.'" and e.idCedente is null and e.idFuncionario is null
				LEFT JOIN
					cliente g ON g.idCliente = "'.$idEmpresa.'"
				WHERE
					a.idFuncionario = "'.($idFuncionario).'"
				    and a.idEmpresa = '.$idEmpresa.'
					and a.idCedente is null
					and b.idCedente is null
				    and b.habilitado = 1
				    OR
				    (
				        a.idFuncionario is null
				        and b.habilitado = 1
				        and a.idEmpresa = '.$idEmpresa.'
					    and a.idCedente is null
					    and b.idCedente is null
						and (
				            select d.idFuncionario 
				            from emprestimos_parametros d
				            where d.idFuncionario = "'.($idFuncionario).'"
				            limit 1
				        ) is null
				    )';

			//echo $sql; die();
			$result = $this->db->query($sql);
		}
		
		return $result->result();
	}
	
	function buscaComprometimentoFuncionario($idFuncionario,$tipo,$idEmprestimo) {
		$sql = 'SELECT getValorComprometidoFuncionario("'.$idFuncionario.'","'.$tipo.'","'.$idEmprestimo.'") as valor';
		
		$result = $this->db->query($sql);
		
		if (0 < $this->db->affected_rows())
			return $result->result();
			
		else return false;
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	function getFinanciamento($idEmprestimo) {
		$this->db->from('emprestimos_grava_financiamento a');
		$this->db->where(array("a.idEmprestimo" => $idEmprestimo));
		
		$query = $this->db->get();
		
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	function edit($table,$data,$fieldID,$ID){
		$this->db->where($fieldID,$ID);
	
		$this->db->update($table, $data);

		if ($this->db->affected_rows() >= 0)
		{
			return true;
		}
		
		return false;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	function insert($table,$data){
	
		$this->db->insert($table, $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	
		return FALSE;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	function delete($table,$where){
		$this->db->where($where);
		$this->db->delete($table);
	
		if ($this->db->affected_rows() >= 0)
		{
			return true;
		}
	
		return false;
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 12/10/2015
	 */
	public function getFuncionarioEmpExterno($idFuncionario) {
	
		$this->db->from('funcionario a');
		$this->db->where(array("a.idFuncionario" => $idFuncionario));
		$this->db->where(array("a.situacao" => 1));
	
		$query = $this->db->get();
	
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 12/10/2015
	 */
	public function getFuncionarios($idFuncionario) {
		$idEmpresa = $this->session->userdata['idCliente'];
	
		$this->db->from('funcionario a');
		$this->db->where("a.idEmpresa", $idEmpresa);
	
		if ($idFuncionario) {
			$this->db->where(array("a.idFuncionario" => $idFuncionario));
		}
		else {
			$this->db->where("a.situacao", 1);
		}
	
		$query = $this->db->get();
	
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 12/10/2015
	 */
	public function getCedentes($idCedente) {
		$this->db->select('a.*, b.habilitado, b.idParametro');
		$this->db->from('cedente a');
		
		if ($idCedente) {
			$this->db->where(array("a.idCedente" => $idCedente));
		}
		else {
			$this->db->where("a.situacao", 1);
		}
		
		$this->db->join('emprestimos_habilita_cedentes b', 'a.idCedente = b.idCedente', 'left');
		$this->db->order_by('a.idCedente ASC');
		
		$result = $this->db->get();
	
		if (0 < $this->db->affected_rows()) {
			return $result->result();
		}
	
		else return NULL;
	}
}
?>