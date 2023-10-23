<?php
/**
 * 
 * @author davic
 * data: 21/11/2015
 * @uses classes que realizam persistência em banco de dados devem implementar esta classe
 */
interface ModelInterface {

	/**
	 *
	 * {@inheritDoc}
	 * @see ModelInterface::getDb_error_number()
	 * @uses quando ocorre erro em uma query é possível resgatar seu número (mysql)
	 */
	public function getDb_error_number();
	
	/**
	 *
	 * {@inheritDoc}
	 * @see ModelInterface::getDb_error_message()
	 * @uses quando ocorre erro em uma query é possível resgatar sua mensagem (mysql)
	 */
	public function getDb_error_message();
	
}