<?php
class email extends MY_Controller {

    public function __construct() {
    	parent::__construct();
		$this->load->model('chamadaexterna_model','',TRUE);
    }
}

