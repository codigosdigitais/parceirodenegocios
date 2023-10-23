<?php

// composer
require APPPATH . "../vendor/autoload.php";

// Dompdf namespace
use Dompdf\Dompdf;

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Modelo responsável por inserir logs de acesso
        $this->load->model('logs_modelclass', '', true);
        $this->setPerfilController();
        $this->userCanAccesFunctionByType($this->router->class);
    }

    /*novo modelo de chamadas*/
    public function __template21($view=null)
    {
        ($view) ? $this->load->view($view) : 'nada';
        $this->load->view("tema/chamada/dashboard", '', true);
    }
    
    public function setControllerMenu($controller)
    {
        $idPerfil = (isset($this->data['menuActive'][0])) ? $this->data['menuActive'][0] : false;
        $this->data['menuActive'] = array($idPerfil, $controller);
        $this->userCanAccesFunctionByType($controller);
    }


    public function get_ciclo($dia_inicial=21, $dia_final=20, $data_referencia)
    {
        $mes = date('m', $data_referencia) - 3; // começa no mês anterior
        $ano = date('Y', $data_referencia);
        if (date("d", $data_referencia) < $dia_inicial) {
            $mes--; // // nesse caso, volta mais um mês
        }
        return array(
            date("Y-m-d", mktime(0, 0, 0, $mes, $dia_inicial, $ano)),
            date("Y-m-d", mktime(0, 0, 0, $mes + 1, $dia_final, $ano))
        );
    }

    public function monta_ciclo()
    {
        $dia_inicial = 21;
        $dia_final = 20;

        // começa no mês e ano atual
        $hoje = strtotime("-9 months");
        $mes = date('m', $hoje);
        $ano = date('Y', $hoje);
        $todos = [];
        for ($i = 0; $i < 12; $i++) { // itera por 12 meses

            // gera o ciclo do mês atual
            $todos[] = self::get_ciclo($dia_inicial, $dia_final, mktime(0, 0, 0, $mes, $dia_inicial, $ano));
        
            // avança um mês
            $data = mktime(0, 0, 0, $mes + 1, $dia_inicial, $ano);
            $mes = date('m', $data);
            $ano = date('Y', $data);
        }
        
        return $todos;
    }




    
    public function get_ciclo_atual($data)
    {
        $dia_inicial = 21;
        $dia_final = 20;
        $hoje =  strtotime($data);

        
        $mes = date('m', $hoje); // começa no mês anterior
        $ano = date('Y', $hoje); // ano atual
        if (date("d", $hoje) < $dia_inicial) {
            //$mes--; // // nesse caso, volta mais um mês
        }
        return array(
            date("Y-m-d", mktime(0, 0, 0, $mes, $dia_inicial, $ano)),
            date("Y-m-d", mktime(0, 0, 0, $mes + 1, $dia_final, $ano))
        );
    }


    // 	public function get_ciclo_atual($hoje, $dia_inicial=21, $dia_final=20){
    // 		$ciclo = array();
    // 		$hoje = date("Y-m-d");
    // 		if(date("d", strtotime($hoje)) >= $dia_inicial){
    // 			$ciclo[0] = date("Y", strtotime($hoje))."-".date("m", strtotime($hoje))."-".$dia_inicial;
    // 			$ciclo[1] = date("Y", strtotime($hoje))."-".date("m", strtotime($hoje." +1 month"))."-".$dia_final;
    // 		}else{
    // 			$ciclo[0] = date("Y", strtotime($hoje))."-".date("m", strtotime($hoje." -1 month"))."-".$dia_inicial;
    // 			$ciclo[1] = date("Y", strtotime($hoje))."-".date("m", strtotime($ciclo[0]." +1 month"))."-".$dia_final;
    // 		}

    // 		return $ciclo;
    // 	}
    
    private function userCanAccesFunctionByType($controller)
    {
        if (!$this->permission->userCanAccesFunctionByType($controller)) {
            $this->session->set_flashdata('error', 'Funcção exige cliente externo vinculado ao cadasatro do usuário.');
            redirect(base_url());
        }
    }
    
    private function setPerfilController()
    {

        //Recupera perfil da URL e seta na classe de permissões
        $idPerfil = $this->uri->segment(1);
        if (is_numeric($idPerfil)) {
            $this->permission->setIdPerfil($idPerfil);
        } else {
            $idPerfil = false;
        }
        
        //Recupera controller atual (via nome da classe) e seta em permissões
        $controller = $this->router->class;
        $this->permission->setController($controller);
        
        //seta perfil e controller atual para destacar no menu
        $this->data['menuActive'] = array($idPerfil, $controller);
        
        //var_dump($this->data['menuActive']); die();
    }
    

    public function setPDF($template=null, $dados=null)
    {
        $nome = str_replace(" ", "_", preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($dados['dados']['dados_funcionario']->nome))));
        $ciclo = str_replace(" ", "_", preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($dados['ciclo'][0]."_A_".$dados['ciclo'][1]))));

        $arquivo = $nome."-".$ciclo;
        #echo $arquivo;

        #echo "<pre>";
        #print_r($dados);
        #die();

        $template = utf8_decode($template);

        $template = $this->load->view($template, $dados, true);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4');
        $dompdf->render();

        //echo $template;
        $dompdf->stream($arquivo);
    }
}
