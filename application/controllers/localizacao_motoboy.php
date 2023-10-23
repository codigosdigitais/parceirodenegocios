<?php
/**
 * Created by PhpStorm.
 * User: davic
 * Date: 2016-05-19
 * Time: 22:04
 */

include_once(dirname(__FILE__) . "/global_functions_helper.php");
include_once(dirname(__FILE__) . "/classes/CORS_HEADERS.php");

class localizacao_motoboy extends MY_Controller
{

    private $url_gcm_notification = "http://parceirodenegocios.com/gcm_comunication/v1";

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('localizacao_model', '', TRUE);

        $whitelist = array(
            '127.0.0.1',
            '::1',
            'localhost'
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            $this->url_gcm_notification = "http://localhost/gcm_comunication/v1";
        }
        else {
            $this->url_gcm_notification = "http://parceirodenegocios.com/gcm_comunication/v1";
        }
    }

    public function index() {
        if ($this->permission->canSelect()) {

            $this->data['view'] = 'localizacao/mapa_localiza_profissionais';
            $this->load->view('tema/topo', $this->data);

        } else redirect('entrega/login');

    }

    public function send_location_request() {
        $idEmpresa = $this->session->userdata['idCliente'];
        $result = file_get_contents($this->url_gcm_notification . "/send_location_request/".$idEmpresa);

        echo "OK:".$result;
    }

    public function get_motoboys_location_json() {
        $response['error'] = true;
        $idEmpresa = 148;
    
        $locations = $this->localizacao_model->getLocations($idEmpresa);

        if ($locations) {
            $this->localizacao_model->updateLastRequestDate($idEmpresa);

            $response['error'] = false;
            $response['locations'] = json_encode($locations, JSON_PRETTY_PRINT);
        }

        echo json_encode($response);
    }
}
?>