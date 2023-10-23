<?php
/*
 * @autor: Davi Siepmann
 * @date: 21/11/2015
 */

include_once (dirname(__FILE__) . "/PersistivelInterface.php");
include_once (dirname(__FILE__) . "/ChamadaExternaClass.php");

class ChamadaServicoExternaClass extends CI_Controller implements PersistivelInterface {

	private $idChamadaServico = null;
	private $Chamada;
	private $tiposervico;
	private $endereco;
	private $numero;
	private $bairro;
	private $cidade;
	private $falarcom;
	
	
	function __construct($Chamada) {
		parent::__construct();
		
		$this->load->model('chamadaexterna_model','',TRUE);
		
		$this->Chamada = $Chamada;
	}
	
	
	/**
	 * Inherited
	 */
	/**
	 * 
	 * {@inheritDoc}
	 * @see Persistivel::carregar()
	 * M�todo carregar n�o implementado para chamados externos
	 */
	public function carregar($id) {}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see Persistivel::salvar()
	 * M�todo salvar implementado apenas para inserir chamados externos
	 */
	public function salvar() {
		/*$dados = array(
				'idChamada'		=> $this->Chamada->getIdChamada(),
				'tiposervico'	=> $this->tiposervico,
				'endereco'		=> $this->endereco,
				'numero'		=> $this->numero,
				'bairro'		=> $this->bairro,
				'cidade'		=> $this->cidade,
				'falarcom'		=> $this->falarcom
		);
		*/
		$dados = $this->retornaArrayChamadaServico();
		
		#if (null == $this->idChamadaServico)
			return $this->inserir($dados);
		
	}
	private function inserir($dados) {
		$idChamada = $this->chamadaexterna_model->inserirChamadaServico($dados);
		
		if ($idChamada) {
			$this->idChamada = $idChamada;
			return $this->db->insert_id();
		}
		
		else return false;
	}
	
	/**
	 * Retorna array contendo dados deste servi�o
	 * @return array
	 */
	public function retornaArrayChamadaServico() {
		$dados = array(
				'idChamada'		=> $this->Chamada->getIdChamada(),
				'tiposervico'	=> $this->tiposervico,
				'endereco'		=> $this->endereco,
				'numero'		=> $this->numero,
				'bairro'		=> $this->bairro,
				'cidade'		=> $this->cidade,
				'falarcom'		=> $this->falarcom
		);
		
		return $dados;
	
	}
	/**
	 * 
	 * @param array contendo endere�os $dados
	 * @param $idCliente
	 * 
	 * insere servi�os do chamado calculando e atualizando valorres 
	 */
	public function inserirMetodoAntigo($dados, $idCliente) {
		
		$this->chamadaexterna_model->addChamadaServicoSistemaAntigo($dados, $idCliente);
	
		return true;
	}
	/**
	 * 
	 * {@inheritDoc}
	 * @see Persistivel::remover()
	 * M�todo remover n�o implementado para chamados externos
	 */
	public function remover() {}
	
	/**
	 * Getters and Setters
	 */
	public function getChamada(){
		return $this->Chamada;
	}
	
	public function setChamada($Chamada){
		$this->Chamada = $Chamada;
	}
	
	public function getTiposervico(){
		return $this->tiposervico;
	}
	
	public function setTiposervico($tiposervico){
		$this->tiposervico = $tiposervico;
	}
	
	public function getEndereco(){
		return $this->endereco;
	}
	
	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function setNumero($numero){
		$this->numero = $numero;
	}
	
	public function getBairro(){
		return $this->bairro;
	}
	
	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	public function getFalarcom(){
		return $this->falarcom;
	}
	
	public function setFalarcom($falarcom){
		$this->falarcom = $falarcom;
	}
	
}