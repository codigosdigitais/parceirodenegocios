<?php
/*
 * @autor: Davi Siepmann
 * @date: 21/11/2015
 */
include_once (dirname(__FILE__) . "/PersistivelInterface.php");

class FuncionarioExternoClass extends MY_Controller implements PersistivelInterface {

	private $id = null;
	private $idEmpresa;
	private $nome;
	private $email;
	private $senha;
	private $telefone;
	private $cidade;
	private $estado;
	private $temSmartphone;
	private $tipoSmartphone;
	private $temBauInstalado;
	private $temMEI;
	private $temPlacaVermelha;
	private $temCondumoto;
	
	
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('funcionarioexterno_model','',TRUE);
	}
	

	public function getDb_error_message() {
		return $this->funcionarioexterno_model->getDb_error_message();
	}
	public function getDb_error_number() {
		return $this->funcionarioexterno_model->getDb_error_number();
	}
	
	public function getListaFuncionarios($idEmpresa) {
		return $this->funcionarioexterno_model->getListaFuncionarios($idEmpresa);
	}
	
	public function existeEmailFuncionarioCadastrado($email, $idEmpresa) {
		return $this->funcionarioexterno_model->existeEmailFuncionarioCadastrado($email, $idEmpresa);
	}
	

	/**
	 * Inherited
	 */
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::carregar()
	 */
	public function carregar($id) {
		
		$funcDB = $this->funcionarioexterno_model->carregarCadFuncExterno($id);
		$funcDB = array_shift($funcDB);
		
		if ($funcDB) {
			$this->id 				= $funcDB->id;
			$this->idEmpresa		= $funcDB->idEmpresa;
			$this->nome				= $funcDB->nome;
			$this->email			= $funcDB->email;
			$this->telefone			= $funcDB->telefone;
			$this->cidade			= $funcDB->cidade;
			$this->estado			= $funcDB->estado;
			$this->temSmartphone	= $funcDB->temSmartphone;
			$this->tipoSmartphone	= $funcDB->tipoSmartphone;
			$this->temBauInstalado	= $funcDB->temBauInstalado;
			$this->temMEI			= $funcDB->temMEI;
			$this->temPlacaVermelha	= $funcDB->temPlacaVermelha;
			$this->temCondumoto		= $funcDB->temCondumoto;
		}
	}
	
	public function getCodigoEstado($estado) {
		return $this->funcionarioexterno_model->getCodigoEstado($estado);
	}
	
	public function copiarCadastroParaFuncionario() {

		$idEstado = $this->getCodigoEstado($this->getEstado());
		$ddd = ""; $fone = "";
		
		if (strlen($this->getTelefone()) > 13) {
					
			$telefone	  = explode(' ', $this->getTelefone());
			if (count($telefone) > 0) {
				$ddd  = preg_replace('/\D/', '', $telefone[0]);
				$fone = preg_replace('/\D/', '', $telefone[1]);
			}
		}
		
		$dadosFuncionario = array(
				'idEmpresa' => $this->getIdEmpresa(),
				'nome'		=> $this->getNome(),
				'enderecocidade' => $this->getCidade(),
				'enderecoestado' => $idEstado,
				'email'			 => $this->getEmail(),
				'responsaveltelefoneddd' => $ddd ,
				'responsaveltelefone'	 => $fone
		);
		
		return $this->funcionarioexterno_model->insertTableData('funcionario', $dadosFuncionario);
	}
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::salvar()
	 */
	public function salvar() {
		$dados = array(
				'idEmpresa'		=> $this->idEmpresa,
				'nome'			=> $this->nome,
				'email'			=> $this->email,
				'senha'			=> $this->senha,
				'telefone'		=> $this->telefone,
				'cidade'		=> $this->cidade,
				'estado'		=> $this->estado,
				'temSmartphone'		=> $this->temSmartphone,
				'tipoSmartphone'	=> $this->tipoSmartphone,
				'temBauInstalado'	=> $this->temBauInstalado,
				'temMEI'			=> $this->temMEI,
				'temPlacaVermelha'	=> $this->temPlacaVermelha,
				'temCondumoto'		=> $this->temCondumoto
		);
		
		if (null == $this->id)
			return $this->inserir($dados);
	
	}
	private function inserir($dados) {
		$id = $this->funcionarioexterno_model->inserirPreCadastro($dados);
	
		if ($id) {
			$this->id = $id;
			return $id;
		}
	
		else return false;
	}
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::remover()
	 * M�todo remover n�o implementado  em cadastros externos /integração
	 * implementar quando surgir necessidade
	 */
	public function remover() {}
	
	/**
	 * Getters and Setters
	 */
	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	
	public function setIdEmpresa($idEmpresa){
		$this->idEmpresa = $idEmpresa;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
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

	public function getTelefone(){
		return $this->telefone;
	}
	
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	public function getEstado(){
		return $this->estado;
	}
	
	public function setEstado($estado){
		$this->estado = $estado;
	}
	
	public function getTemSmartphone(){
		return $this->temSmartphone;
	}
	
	public function setTemSmartphone($temSmartphone){
		$this->temSmartphone = $temSmartphone;
	}
	
	public function getTipoSmartphone(){
		return $this->tipoSmartphone;
	}
	
	public function setTipoSmartphone($tipoSmartphone){
		$this->tipoSmartphone = $tipoSmartphone;
	}
	
	public function getTemBauInstalado(){
		return $this->temBauInstalado;
	}
	
	public function setTemBauInstalado($temBauInstalado){
		$this->temBauInstalado = $temBauInstalado;
	}
	
	public function getTemMEI(){
		return $this->temMEI;
	}
	
	public function setTemMEI($temMEI){
		$this->temMEI = $temMEI;
	}
	
	public function getTemPlacaVermelha(){
		return $this->temPlacaVermelha;
	}
	
	public function setTemPlacaVermelha($temPlacaVermelha){
		$this->temPlacaVermelha = $temPlacaVermelha;
	}
	
	public function getTemCondumoto(){
		return $this->temCondumoto;
	}
	
	public function setTemCondumoto($temCondumoto){
		$this->temCondumoto = $temCondumoto;
	}
}
?>