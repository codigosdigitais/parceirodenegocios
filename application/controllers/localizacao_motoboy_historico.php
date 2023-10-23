<?php
/**
 * Created by PhpStorm.
 * User: davic
 * Date: 2016-05-19
 * Time: 22:04
 */

include_once(dirname(__FILE__) . "/global_functions_helper.php");
include_once(dirname(__FILE__) . "/classes/CORS_HEADERS.php");

class localizacao_motoboy_historico extends MY_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('localizacao_model', '', TRUE);
    }

    public function index() {
        if ($this->permission->canSelect()) {

            $idEmpresa = $this->session->userdata['idCliente'];

            $this->data['profissionais'] = $this->localizacao_model->getProfessionals($idEmpresa);

            $this->data['view'] = 'localizacao/mapa_historico_localizacao';
            $this->load->view('tema/topo', $this->data);

        } else redirect('entrega/login');

    }

    public function get_motoboys_location_history_json() {
        $response['error'] = true;
        $response['maxRecordsAchieved'] = false;

        $limit = 1000;

        $idEmpresa = $this->session->userdata['idCliente'];

        $idProfissional = $this->input->post('idProfissional');
        $dataInicio = $this->input->post('dataInicio') ?: date('Y-m-d', strtotime(date('Y-m-d') . "-30 days"));
        $dataFim = $this->input->post('dataFim') ?: date('Y-m-d');
        $offset = $this->input->post('offset') * $limit;

        $locations  = $this->localizacao_model->getLocationHistory($idEmpresa, $idProfissional, $dataInicio, $dataFim, $limit, $offset);
        $totalFound = $this->localizacao_model->getLocationHistory($idEmpresa, $idProfissional, $dataInicio, $dataFim, $limit, $offset, true);
        $response['totalRecords'] = $totalFound[0]->total ?: 0;

        if ($locations !== FALSE) {
            $response['error'] = false;
            $response['locations'] = json_encode($locations, JSON_PRETTY_PRINT);

            if ($totalFound[0]->total >= $limit) {
                $response['maxRecordsAchieved'] = $limit;
            }
        }

        echo json_encode($response);
    }
}
?>