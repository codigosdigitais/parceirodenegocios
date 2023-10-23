<?php
/*
* @autor: Davi Siepmann
* @date: 21/09/2015
*/

class paramemprestimos_model extends CI_Model {

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
	
	/*
	* @autor: Davi Siepmann
	* @date: 18/09/2015
	*/
	public function getBase($table, $where, $order)
	{
		if (NULL != $where) $this->db->where($where);
        if (NULL != $order) $this->db->order_by($order);
		
		$result = $this->db->get($table)->result();
		
		return $result;		
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 26/09/2015
	 */
	public function getCedentes() {
		$idEmpresa = $this->session->userdata['idCliente'];
		
		$this->db->select('a.*, b.habilitado, b.idParametro');
		$this->db->from('cedente a');
		$this->db->join('emprestimos_habilita_cedentes b', 'a.idCedente = b.idCedente', 'left');
		$this->db->order_by('a.idCedente ASC');
		$this->db->where('a.idEmpresa', $idEmpresa);
		$this->db->where('a.situacao', 1);
		
		$result = $this->db->get();
		
		if (0 < $this->db->affected_rows()) {
			return $result->result();
		}
		
		return NULL;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 25/09/2015
	 */
	public function getParametrosCedente($idCedente)
	{
		$idEmpresa = $this->session->userdata['idCliente'];
		
		$this->db->select('a.*, c.nomefantasia');
		$this->db->from('emprestimos_parametros a');
		$this->db->join('cedente c', 'a.idCedente = c.idCedente', 'left');
		$this->db->where(array("a.idEmpresa" => $idEmpresa, "a.idFuncionario" => NULL));
		
		if ($idCedente) $this->db->where(array("a.idCedente" => $idCedente));
		else 			$this->db->where(array("a.idCedente" => NULL));
			
		$this->db->limit(1);
		
		$result = $this->db->get();
		
		if (0 == $this->db->affected_rows()) {
			
			//verifica se cedente existe
			$this->db->query("SELECT * FROM `cedente` where `idEmpresa` = $idEmpresa and `idCedente` = '".($idCedente)."'");
			
			if (1 == $this->db->affected_rows() || !$idCedente) {
				//insere registro contendo os par�metros para este cedente
				$data = array('idEmpresa' => $idEmpresa);
				
				//se n�o houver cedente, par�metros s�o globais
				if ($idCedente) $data = array_merge($data, array("idCedente" => $idCedente));
				
				$this->insert('emprestimos_parametros', $data);
				
				return $this->getParametrosCedente($idCedente);
			}
		}
		return $result->result();
	}
	
	/*
	* @autor: Davi Siepmann
	* @date: 21/09/2015
	*/
	public function getParamFuncionarios($idCedente) {
		$idEmpresa = $this->session->userdata['idCliente'];
		
		$this->db->select('a.*, b.nome');
		$this->db->from('emprestimos_parametros a');
		$this->db->join('funcionario b', 'a.idFuncionario = b.idFuncionario', 'left');
		$this->db->where(array("a.idEmpresa" => $idEmpresa));
		$this->db->where('a.idFuncionario IS NOT NULL');
		
		//se n�o houver cedente, par�metros s�o globais
		if ($idCedente) $this->db->where(array("a.idCedente" => $idCedente));
		else 			$this->db->where(array("a.idCedente" => NULL));
		
		$query = $this->db->get();
		
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
	}
	
	/*
	* @autor: Davi Siepmann
	* @date: 26/09/2015
	*/
	public function getFuncionariosCedente($idCedente) {
		$idEmpresa = $this->session->userdata['idCliente'];
		
		$this->db->from('funcionario a');
		$this->db->where(array("a.idEmpresa" => $idEmpresa));
		
		if ($idCedente) {
			$this->db->join('funcionario_dadosregistro c',
					'a.idFuncionario = c.idFuncionario and c.empresaregistro = '. $idCedente,
					'left');
			$this->db->where(array('c.empresaregistro' => $idCedente));
		}

		$query = $this->db->get();
		
		if (0 < $this->db->affected_rows()) {
			return $query->result();
		}
		else return NULL;
	}
	
	/*
	* @autor: Davi Siepmann
	* @date: 20/09/2015
	*/
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        
        $this->db->update($table, $data);
        
        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
	
	/*
	* @autor: Davi Siepmann
	* @date: 21/09/2015
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
	* @date: 21/09/2015
	*/
    function delete($table,$where){
		$this->db->where($where);
        $this->db->delete($table);
		
        if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
}
?>