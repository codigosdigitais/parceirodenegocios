<?php
/**
 * 
 * @author davic
 * data: 21/11/2015
 * @uses classes que realizam persist�ncia em banco de dados devem implementar esta classe
 */
interface ModelInterface {

	/**
	 *
	 * {@inheritDoc}
	 * @see ModelInterface::getDb_error_number()
	 * @uses quando ocorre erro em uma query � poss�vel resgatar seu n�mero (mysql)
	 */
	public function getDb_error_number();
	
	/**
	 *
	 * {@inheritDoc}
	 * @see ModelInterface::getDb_error_message()
	 * @uses quando ocorre erro em uma query � poss�vel resgatar sua mensagem (mysql)
	 */
	public function getDb_error_message();
	
}