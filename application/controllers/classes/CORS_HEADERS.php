<?php
/*
 * @autor: Davi Siepmann
 * @date: 21/11/2015

 */
class Cors_headers extends CI_Controller {
	
    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }

	public function _PRINT_CORS_HEADERS($domainOrNullForAuto) {
		
		$domain = $domainOrNullForAuto;
		
		if ( is_null($domain) || empty($domain) ) $domain = $this->getDomainFromRequest();
	
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Headers: Authorization, Content-Type, Content-MD5, X-Alt-Referer");
		header('Access-Control-Allow-Origin: ' . $domain);
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Max-Age: 1728000');
		//header('content-type: text/html; charset=utf-8;');
		//header('content-type: application/json; charset=utf-8;');
	}
	
	private function getDomainFromRequest() {
		$headers = array();
		foreach($_SERVER as $key => $value) {
			if (substr($key, 0, 11) == 'HTTP_ORIGIN')
				return $value;
		}
	}
}

?>