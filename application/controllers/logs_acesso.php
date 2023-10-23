<?php
/*
 * @autor: Davi Siepmann
* @date: 04-12-2015
*/
include_once (dirname(__FILE__) . "/global_functions_helper.php");

class logs_acesso extends MY_Controller {

	function __construct() {
		parent::__construct();
		//verifica login
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');

		$this->load->helper(array('codegen_helper'));
	}
	
	function index() {

		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar logs do sistema.');
			redirect(base_url());
		}
		
		$this->data['tabelascomlog'] = $this->logs_modelclass->getTabelasContendoLog();
		$this->data['usuarioscomlog']= $this->logs_modelclass->getUsuariosContendoLog();
		
		$this->data['view'] = 'logs/logs_view';
		$this->load->view('tema/topo',$this->data);
		
	}
	
	function getLogsPeloFiltro() {
		
		$tabela 	 = $this->input->post('tabela');
		$dataInicial = conv_data_DMY_para_YMD($this->input->post('dataInicial'));
		$dataFinal 	 = conv_data_DMY_para_YMD($this->input->post('dataFinal'));
		$operacao 	 = $this->input->post('operacao');
		$usuario 	 = $this->input->post('usuario');
		$pagina 	 = $this->input->post('pagina');
		
		$logsERegistros = $this->logs_modelclass->getLogsPeloFiltro($tabela, $dataInicial, $dataFinal, $operacao, $usuario, $pagina);
		$logs = $logsERegistros[0];
		
		if (count($logs) == 0) echo "Não foram encontrados registros para estes filtros.";
		
		else {
			echo '<table class="table-logs"><tr>';
			echo '<th style="max-width:250px">Função</th>';
			echo '<th style="width:90px">Operação</th>';
			echo '<th style="width:125px">Data /Hora</th>';
			echo '<th style="max-width:90px">Registro</th>';
			echo '<th>Usuário</th>';
			echo '<th></th>';
			echo '<th>Descrição</th>';
			echo '</tr>';
			
			foreach ($logs as $log) {
				echo '<tr>';
				echo '<td>'.$log->descricaotabela.'</td>';
				echo '<td>'.$this->getDescOperacao($log->operacao).'</td>';
				echo '<td>'.conv_data_YMDHMS_para_DMYHMS($log->dataHora).'</td>';
				echo '<td>'.$log->primarykey_atr.' = '. $log->primarykey_val .'</td>';
				echo '<td>'.$log->nome.'</td>';
				echo '<td>';

				if (($log->data)) {
					echo '<div class="btn-log-data-show icon-list-alt" title="Detalhes">';
					
					$data = "<br>";
					switch ($log->operacao) {
						case 'insert' : $data .= "<b>Inseridas informações: </b><br>"; break;
						case 'update' : $data .= "<b>Informações antes da alteração:</b><br>"; break;
						case 'delete' : $data .= "<b>Registro antes de ser removido: </b><br>"; break;
					}
					
					$data .= $log->data;
					$data = str_replace('[{', '', $data);
					$data = str_replace(',', '<br>', $data);
					$data = str_replace('}]', '', $data);
					echo '<div class="log-data-show">'.$data.'</div>';
					echo '</div>';
				}
				
				echo '</td>';
				echo '<td>'.$log->descricao.'</td>';
				echo '</tr>';
			}
			echo '</table>';
			
			if ($logsERegistros[1] > 1) {
				for ($i = 1; $i <= $logsERegistros[1]; $i++) {
					$pagSelecionada = ($pagina +1 == $i) ? 'div-pages-selected' : '';
					echo '<div class="div-pages-registros '.$pagSelecionada.'">'.$i.'</div>';
				}
			}
		}
	}
	
	private function getDescOperacao($op) {
		switch ($op) {
			case 'insert' : return 'Inserir'; break;
			case 'update' : return 'Atualizar'; break;
			case 'delete' : return 'Remover'; break;
			default: return 'Desconhecida'; break;
		}
	}
}
?>