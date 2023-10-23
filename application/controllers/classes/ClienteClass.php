<?php
/*
 * @autor: Davi Siepmann
 * @date: 21/11/2015
 */
include_once (dirname(__FILE__) . "/PersistivelInterface.php");

class ClienteClass extends CI_Controller implements PersistivelInterface {

	private $idCliente = null;
	private $idEmpresa;
	private $razaosocial;
	private $nomefantasia;
	private $responsavel_telefone_ddd;
	private $responsavel_telefone;
	private $cnpj;
	private $email;
	private $senha;
	private $status;
	
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('clienteexterno_model','',TRUE);
	}
	

	public function getDb_error_message() {
		return $this->clienteexterno_model->getDb_error_message();
	}
	public function getDb_error_number() {
		return $this->clienteexterno_model->getDb_error_number();
	}

	/**
	 * Inherited
	 */
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::carregar()
	 * M�todo carregar n�o implementado pois est� utilizando somente chamados externos
	 * implementar quando surgir necessidade
	 */
	public function carregar($id) {}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::salvar()
	 * M�todo salvar implementado apenas para inserir  pois est� utilizando somente chamados externos
	 * implementar quando surgir necessidade
	 */
	public function salvar() {
		$dados = array(
				'idEmpresa'					=> $this->idEmpresa,
				'razaosocial'				=> $this->razaosocial,
				'nomefantasia'				=> $this->nomefantasia,
				'cnpj'						=> preg_replace('/[^0-9]/', '', $this->cnpj),
				'responsavel_telefone_ddd' 	=> preg_replace('/[^0-9]/', '', $this->responsavel_telefone_ddd),
				'responsavel_telefone'		=> preg_replace('/[^0-9]/', '', $this->responsavel_telefone),
				'email'						=> $this->email,
				'senha'						=> $this->senha,
				'situacao'					=> $this->status
		);
	
		if (null == $this->idCliente)
			return $this->inserir($dados);
	
	}
	private function inserir($dados) {
		$id = $this->clienteexterno_model->inserirCliente($dados);
	
		if ($id) {
			$this->idCliente = $id;
			return $this->db->insert_id();
		}
	
		else return false;
	}
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::remover()
	 * M�todo remover n�o implementado  pois est� utilizando somente chamados externos
	 * implementar quando surgir necessidade
	 */
	public function remover() {}
	
	/**
	 * Getters and Setters
	 */
	public function getIdCliente(){
		return $this->idCliente;
	}
	
	public function setIdCliente($idCliente){
		$this->idCliente = $idCliente;
	}
	
	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	
	public function setIdEmpresa($idEmpresa){
		$this->idEmpresa = $idEmpresa;
	}
	
	public function getRazaosocial(){
		return $this->razaosocial;
	}
	
	public function setRazaosocial($razaosocial){
		$this->razaosocial = $razaosocial;
	}
	
	public function getNomefantasia(){
		return $this->nomefantasia;
	}
	
	public function setNomefantasia($nomefantasia){
		$this->nomefantasia = $nomefantasia;
	}
	
	public function getCnpj(){
		return $this->cnpj;
	}
	
	public function setCnpj($cnpj){
		$this->cnpj = $cnpj;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function getSenha(){
		return $this->senha;
	}
	
	public function setSenha($senha){
		$this->senha = $senha;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	public function getResponsavel_telefone_ddd(){
		return $this->responsavel_telefone_ddd;
	}
	
	public function setResponsavel_telefone_ddd($responsavel_telefone_ddd){
		$this->responsavel_telefone_ddd = $responsavel_telefone_ddd;
	}
	
	public function getResponsavel_telefone(){
		return $this->responsavel_telefone;
	}
	
	public function setResponsavel_telefone($responsavel_telefone){
		$this->responsavel_telefone = $responsavel_telefone;
	}
}
?>