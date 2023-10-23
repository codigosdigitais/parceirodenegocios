<?php
/*
 * @autor: André Baill
 * @date: 16/10/2020
 * @base: ClienteClass.php
*/
include_once (dirname(__FILE__) . "/PersistivelInterface.php");

class UsuarioClass extends CI_Controller implements PersistivelInterface {

	private $idUsuario = null;
	private $idEmpresa;
	private $idCliente;
	private $nome;
	private $tipo;
	private $login;
	private $senha;
	private $situacao;
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('usuarioexterno_model','',TRUE);
	}
	
	public function carregar($id) {}
	public function remover() {}

	public function getDb_error_message() {
		return $this->usuarioexterno_model->getDb_error_message();
	}
	public function getDb_error_number() {
		return $this->usuarioexterno_model->getDb_error_number();
	}


	public function salvar() {
		$dados = array(
				'idUsuario'					=> $this->idUsuario,
				'idEmpresa'					=> $this->idEmpresa,
				'idCliente'					=> $this->idCliente,
				'nome'						=> $this->nome,
				'login'						=> $this->login,
				'senha'						=> $this->senha,
				'tipo'						=> $this->tipo,
				'situacao'					=> $this->situacao
		);
	
		if (null == $this->idUsuario)
			return $this->inserir($dados);
	
	}
	private function inserir($dados) {
		$id = $this->usuarioexterno_model->inserirUsuario($dados);
	
		if ($id) {
			$this->idUsuario = $id;
			return $this->db->insert_id();
		}
	
		else return false;
	}


	// PERMISSAO
	public function salvarPermissao() {
		$dados = array(
				'idUsuario'					=> $this->idUsuario,
				'idEmpresa'					=> $this->idPerfil,
				'situacao'					=> $this->situacao
		);
	
		if (null == $this->idUsuario)
			return $this->inserirPermissao($dados);
	
	}
	private function inserirPermissao($dados) {
		$id = $this->usuarioexterno_model->inserirUsuarioPermissao($dados);
	
		if ($id) {
			$this->idUsuario = $id;
			return $this->db->insert_id();
		}
	
		else return false;
	}	


	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	


	public function getIdPerfilUser(){
		return $this->idPerfil;
	}
	
	public function setIdPerfilUser($idPerfil){
		$this->idPerfil = $idPerfil;
	}


	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	
	public function setIdEmpresa($idEmpresa){
		$this->idEmpresa = $idEmpresa;
	}

	public function getIdCliente(){
		return $this->idCliente;
	}
	
	public function setIdCliente($idCliente){
		$this->idCliente = $idCliente;
	}

	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getLogin(){
		return $this->login;
	}
	
	public function setLogin($login){
		$this->login = $login;
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
	
	public function getSituacao(){
		return $this->situacao;
	}
	
	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

	public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}	
}

?>