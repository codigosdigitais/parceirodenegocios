<?php
/**
 * 
 * @author davic
 * data: 22/11/2015
 * @uses classes do pacote modelo devem implementar esta classe
 */
interface PersistivelInterface {

	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::carregar()
	 * @uses carregar o cadastro via banco utilizando ID
	 */
	public function carregar($id);
	
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::salvar()
	 * @uses chamado publicamente para realizar persistência
	 * 		 caso cadastro já exista, chama método alterar(), do contrário inserir()
	 */
	public function salvar();
	
	/**
	 *
	 * {@inheritDoc}
	 * @see Persistivel::remover()
	 * @uses remover o registro do banco de dados
	 */
	public function remover();
	
}