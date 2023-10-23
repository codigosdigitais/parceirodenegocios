<?php
/*
* @autor: Davi Siepmann
* @date: 04/12/2015
*/
class logs_modelclass extends CI_Model {
	
	/**
	 * 	Definido no construtor da classe #####
	 * Necess�rio devido a maneira como vem sendo tratado usu�rio no sistema
	 * uma hora � uma tabela outra hora � outra...
	 * 
	 * @var idUsuario que realizou inser��o /altera��o ou remo��o do registro
	 * 
	 */
	private $idUsuario;
	private $tabelaUsuarioTabela;
	private $tabelaUsuarioPk;
	private $tabelaUsuarioNome;
	private $limiteRegistrosConsulta;
	
	//armazena dados consultados do banco previamente 
	//para realizar remo��o posterior e registro dos dados que foram removidos
	private $registroBanco;
	private $tabela;
	private $pk;
	private $pkValue;
	private $descricao;
	private $operacao;
	private $idEmpresa;
	
    function __construct() {
        parent::__construct();
        
       	date_default_timezone_set ('America/Sao_Paulo');
        
        //define ID usuario utilizado para logs
        $this->idUsuario 		   = $this->session->userdata('idUsuario');
       	$this->idEmpresa 		   = $this->session->userdata('idEmpresa');
       	
        $this->tabelaUsuarioTabela = "sis_usuario";
        $this->tabelaUsuarioPk	   = "idUsuario";
        $this->tabelaUsuarioNome   = "nome";
        $this->limiteRegistrosConsulta = 25;
    }

    public function registrar_log_antes_delete($tabela, $pk, $pkValue, $descricao) {
    	$this->registroBanco   = null;
    	$this->operacao  = 'delete';
    	 
    	$data = array(
    			'tabela' 		 => $tabela,
    			'idEmpresa'		 => $this->idEmpresa,
    			'primarykey_atr' => $pk,
    			'primarykey_val' => $pkValue,
    			'operacao' 	  	 => 'delete',
    			'descricao'		 => $descricao
    	);
    
   		$registroBanco = $this->getRegistroBanco($tabela, $pk, $pkValue);
   		$this->registroBanco = array_merge($data, array('data' => $this->getDescricaoArrayParaTexto($registroBanco)));
    }

    public function registrar_log_depois() {
    	if ($this->operacao == 'delete')
    		$this->salvarLog($this->registroBanco);
    	
    	else {
    		
    		$novoRegistroBanco = $this->getRegistroBanco($this->tabela, $this->pk, $this->pkValue);
    		
    		$array1 = (array) $novoRegistroBanco[0];
    		$array2 = (array) $this->registroBanco[0];
    		
    		//armazena apenas a direfen�a entre os registros
    		$diferenca = array_diff_assoc($array2, $array1);

			if (count($diferenca) > 0) {
	    		$data = array(
	    				'tabela' 		 => $this->tabela,
	    				'idEmpresa'		 => $this->idEmpresa,
	    				'primarykey_atr' => $this->pk,
	    				'primarykey_val' => $this->pkValue,
	    				'operacao' 	  	 => 'update',
	    				'descricao'		 => $this->descricao
	    		);
	    		
	    		$this->registroBanco = array_merge($data, array('data' => $this->getDescricaoArrayParaTexto($diferenca)));
	    		$this->salvarLog($this->registroBanco);
			}
    	}
    	
    	$this->registroBanco = null;
    }
    
    public function registrar_log_antes_update($tabela, $pk, $pkValue, $descricao) {
    	$this->registroBanco   = null;
    	$this->tabela 	 = $tabela;
    	$this->pk 		 = $pk;
    	$this->pkValue   = $pkValue;
    	$this->descricao = $descricao;
    	$this->operacao  = 'update';
    	
    	$this->registroBanco = $this->getRegistroBanco($tabela, $pk, $pkValue);
    }
    
    public function registrar_log_insert($tabela, $pk, $pkValue, $descricao, $armazenaDados = false) {
    	$this->idUsuario 		   = $this->session->userdata('idUsuario');
    	$this->idEmpresa 		   = $this->session->userdata('idEmpresa');

    	$data = array(
    			'tabela' 		 => $tabela,
    			'idEmpresa'		 => $this->idEmpresa,
    			'primarykey_atr' => $pk,
    			'primarykey_val' => $pkValue,
    			'operacao' 	  	 => 'insert',
    			'descricao'		 => $descricao
    	);
    	
    	if ($armazenaDados) {
    		$registroBanco = $this->getRegistroBanco($tabela, $pk, $pkValue);
    		$data = array_merge($data, array('data' => $this->getDescricaoArrayParaTexto($registroBanco)));
    	}
		
    	$this->salvarLog($data);
    }

    public function getUsuariosContendoLog() {
    	$this->db->select('a.idUsuario id, b.'. $this->tabelaUsuarioNome .' nome');
    	$this->db->distinct('a.idUsuario');
    	$this->db->from('logs a');
    	$this->db->join($this->tabelaUsuarioTabela .' b', 'a.idUsuario = b.' .$this->tabelaUsuarioPk, 'left');
    	$this->db->where(array('a.idEmpresa' => $this->idEmpresa));
    	$this->db->order_by($this->tabelaUsuarioNome .' ASC');
    	 
    	$result = $this->db->get();
    	 
    	if (0 < $this->db->affected_rows()) {
    		return $result->result();
    	}
    	 
    	else return NULL;
    }
    
    public function getTabelasContendoLog() {
    	$this->db->select('a.tabela, coalesce(b.descricao, a.tabela) descricao', false);
    	$this->db->distinct('a.tabela');
    	$this->db->from('logs a');
    	$this->db->join('logs_desc_tabelas b', 'a.tabela = b.tabela', 'left');
    	$this->db->where(array('a.idEmpresa' => $this->idEmpresa));
    	$this->db->order_by('tabela ASC');
    	
    	$result = $this->db->get();

    	if (0 < $this->db->affected_rows()) {
    		return $result->result();
    	}
    	
    	else return NULL;
    }
    
    public function getLogsPeloFiltro($tabela, $dataInicial, $dataFinal, $operacao, $usuario, $pagina) {

    	$where = array('a.idEmpresa' => $this->idEmpresa);

    	//filtros vindos do cliente
    	if (!empty($tabela)) 		$where = array_merge($where, array('a.tabela' => $tabela));
    	if (!empty($operacao))		$where = array_merge($where, array('a.operacao' => $operacao));
    	if (!empty($usuario))		$where = array_merge($where, array('a.idUsuario' => $usuario));
    	if (!empty($dataInicial))	$where = array_merge($where, array('a.dataHora >=' => $dataInicial . ' 00:00:00'));
    	if (!empty($dataFinal))		$where = array_merge($where, array('a.dataHora <=' => $dataFinal . ' 23:59:59'));
    	
    	//verifica quantidade de registros para montar pagina��o
    	$query = $this->db->get_where('logs a', $where);
    	$num_rows = $query->num_rows();
    	
    	
    	//realiza segunda busca, filtrando os registros
    	$this->db->select('a.*, coalesce(c.descricao, a.tabela) descricaotabela, b.'. $this->tabelaUsuarioNome .' as nome', false);
    	$this->db->join($this->tabelaUsuarioTabela .' b', 'a.idUsuario = b.' .$this->tabelaUsuarioPk, 'left');
    	$this->db->join('logs_desc_tabelas c', 'a.tabela = c.tabela', 'left');
    	$this->db->from('logs a');
    	$this->db->where($where);
    	
    	//seta o limite de acordo com p�gina vinda do cliente
    	$limit = $this->limiteRegistrosConsulta;
    	$offset = ($this->limiteRegistrosConsulta * $pagina);
    	$this->db->limit($limit, $offset);

    	$this->db->order_by('dataHora DESC, tabela, '. $this->tabelaUsuarioNome .', operacao');
    	$result = $this->db->get();

    	//echo $this->db->last_query();
    	
    	if (0 < $this->db->affected_rows()) {
    		$result = $result->result();
    		$paginas = ceil($num_rows /$this->limiteRegistrosConsulta);
    		return array($result, $paginas);
    	}
    	 
    	else return NULL;
    }
    
    private function salvarLog($data) {
    
    	$this->db->set('idUsuario', $this->idUsuario, TRUE);
    	$this->db->set('dataHora', date('Y-m-d H:i:s'));
    
    	$this->db->insert("logs", $data);
    	
    	if ($this->db->affected_rows() >= 0)
    	{
    		return $this->db->insert_id();
    	}
    	
    	return FALSE;
    }
    
    private function getRegistroBanco($tabela, $pk, $pkValue) {
    	
    	$this->db->from($tabela);
    	$this->db->where(array($pk => $pkValue));
    	
    	$result = $this->db->get();
    	
    	if (0 < $this->db->affected_rows()) {
    		return $result->result();
    	}
    	
    	else return false;
    }
    
    private function getDescricaoArrayParaTexto($descricaoArray) {
    	$desc = json_encode($descricaoArray);
    	
    	return $desc;
    }	
}
?>