<?php 
class email_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    public function enviar_email($setor=NULL, $tipo=NULL, $cod=NULL, $acao=NULL, $boleto=NULL) {
	
		switch($setor){
			
			# envio de chamadas por email #
			# Setor de E-mail: Chamada #
			# Tipo de E-mail: Operacional #
			# Acao: Adicionar / Modificada / Cancelada	 #	
				
			case "chamada";
				$get_chamada = $this->chamadaexterna_model->getChamada($cod);
				$get_servico = $this->chamadaexterna_model->getChamadaServicosNew($cod);
			
				# Dados do Cliente
				$dados['nome_cliente'] = $this->get_dados($get_chamada->idCliente, 'cliente', 'idCliente', 'razaosocial');
				$dados['nome_funcionario'] = $this->get_dados($get_chamada->idFuncionario, 'funcionario', 'idFuncionario', 'nome');
					if($dados['nome_funcionario']==false){ $dados['nome_funcionario'] = "NENHUM FUNCIONARIO SELECIONADO."; }
				$dados['nome_solicitante'] = $this->get_dados($get_chamada->solicitante, 'cliente_responsaveis', 'idClienteResponsavel', 'nome');	
					if($dados['nome_solicitante']==false){ $dados['nome_solicitante'] = "NÃO SELECIONADO"; }
				$dados['nome_cedente'] = $this->get_dados($get_chamada->idEmpresa, 'cliente', 'idCliente', 'razaosocial');	
				$dados['email_cedente'] = $this->get_dados($get_chamada->idEmpresa, 'cliente', 'idCliente', 'email');	
				
				# Emails que vão receber a notificação
				$dados['nome_cliente_emails'] = $this->get_dados_emails($get_chamada->idCliente, $tipo);
				
				# Corpo do Email
				$assunto_simples = "";
				if($acao=='adicionar'){ $assunto_simples = "adicionada"; } 
				if($acao=='editar'){ $assunto_simples = "modificada"; } 
				if($acao=='cancelar'){ $assunto_simples = "cancelada"; } 
				
				$email['assunto_padrao'] = utf8_decode("Chamada {$assunto_simples} em ".date("d/m/Y", strtotime($get_chamada->data))." ".$get_chamada->hora);
				
				# Envia Email
				foreach($dados['nome_cliente_emails'] as $valor){
				
					# Classe de envio das informações
					$mail = new PHPMailer();
					$mail->CharSet = "UTF-8";
					$mail->IsHTML(true); 
					$mail->SetFrom("sac@parceirodenegocios.com", utf8_decode($dados['nome_cedente'])); //Quem está enviando o e-mail.
					$mail->AddReplyTo($dados['email_cedente'], utf8_decode($dados['nome_cedente'])); //Para que a resposta será enviada.
					$mail->Subject = $email['assunto_padrao']; //Assunto do e-mail.
					$mail->Body = "
						<style>
							* {
								font-family: Verdana, Arial, Helvetica, sans-serif;
								font-size: 12px;
							}
						</style>
						<table width='100%' cellspacing='10' bgcolor='#F0F0F0'>
							<tr>
								<td><img src='http://www.parceirodenegocios.com/Administrar/assets/img/logo-jc.png'></td>
							</tr>
							<tr>
							  <td>Ol&aacute; <strong>".$valor[$tipo]['nome']." (".$dados['nome_cliente'].")! </strong></td>
						  </tr>
							<tr>
							  <td>Uma chamada foi <strong>{$assunto_simples}</strong> #".$cod." em nossos registros. Confira os detalhes abaixo: </td>
						  </tr>
							<tr>
							  <td>
								<table width='100%' cellpadding='5' cellspacing='5'>
									<tr>
										<td width='30%'><div align='right'><strong>CLIENTE</strong></div></td>
										<td>".$dados['nome_cliente']."</td>
									</tr>
									<tr bgcolor='#FFFFFF'>
									  <td><div align='right'><strong>SOLICITANTE</strong></div></td>
									  <td>".$dados['nome_solicitante']."</td>
								  </tr>
									<tr>
									  <td><div align='right'><strong>FUNCION&Aacute;RIO</strong></div></td>
									  <td>".$dados['nome_funcionario']."</td>
								  </tr>
									
									<tr bgcolor='#FFFFFF'>
										<td width='30%'><div align='right'><strong>DATA</strong></div></td>
										<td>".date("d/m/Y", strtotime($get_chamada->data))." ".$get_chamada->hora."</td>
									</tr>
									
									<tr>
										<td width='30%'><div align='right'><strong>ITINERÁRIO</strong></div></td>
										<td>
											<table class=\"table table-responsive\" style=\"text-transform: uppercase;width: 815px;border-bottom: 1px solid #CCCCCC;\">
												<tbody>
														<tr>
															<td></td>
															<td><strong>ENDEREÇO</strong></td>
															<td><strong>Nº</strong></td>
															<td><strong>CIDADE</strong></td>
															<td><strong>BAIRRO</strong></td>
															<td><strong>FALAR COM</strong></td>
														</tr>
                                                										
										";
										

										foreach($get_servico as $valor_tipo){
										if($valor_tipo->tiposervico=='0'){ $tipo_servico = "Coleta"; } elseif($valor_tipo->tiposervico=='1'){ $tipo_servico =  "Entrega"; } else { $tipo_servico =  "Retorno"; }			
										$mail->Body .= "	
														<tr>
															<td style=\"text-align: right;\">{$tipo_servico}</td>
															<td>{$valor_tipo->endereco}</td>
															<td>{$valor_tipo->numero}</td>
															<td>".utf8_decode($valor_tipo->cidade)."</td>
															<td>{$valor_tipo->bairro}</td>
															<td>{$valor_tipo->falarcom}</td>
														</tr>";										
										}


	
										$mail->Body .= "
												</tbody>
											</table>										
										</td>
									</tr>
									
									<tr bgcolor='#FFFFFF'>
										<td width='30%'><div align='right'><strong>OBSERVA&Ccedil;&Atilde;O</strong></div></td>
										<td>".$get_chamada->observacoes."</td>
									</tr>
									<tr>
									  <td><div align='right'><strong>PONTUA&Ccedil;&Atilde;O</strong></div></td>
									  <td>".$get_chamada->pontos."</td>
								  </tr>
									<tr bgcolor='#FFFFFF'>
									  <td><div align='right'><strong>VALOR</strong></div></td>
									  <td>R$ ".number_format($get_chamada->valor_empresa, "2", ",", ".")."</td>
								  </tr>									
								</table>
							  </td>
						  </tr>
						</table>

					
					";
					$mail->AddAddress($valor[$tipo]['email'], utf8_decode($valor[$tipo]['nome']));
				//	echo $mail->Body;
 
					$mail->Send();
				}
				
			   /*Também é possível adicionar anexos.
				$mail->AddAttachment("images/phpmailer.gif");
				$mail->AddAttachment("images/phpmailer_mini.gif");
				*/
			
			break;
			
			case "email":
				
				# Construção de emails para enviar - método financeiro
				$dados['nome_cliente_emails'] = $this->get_dados_emails($cod, $tipo);
				$dados['nome_cliente'] = $this->get_dados($cod, 'cliente', 'idCliente', 'razaosocial');
								
								
				# Envia Email
				foreach($dados['nome_cliente_emails'] as $valor){
				
					# Classe de envio das informações
					$mail = new PHPMailer();
					$mail->CharSet = "UTF-8";
					$mail->IsHTML(true); 
					$mail->SetFrom("sac@parceirodenegocios.com", utf8_decode($dados['nome_cliente'])); //Quem está enviando o e-mail.
					//$mail->AddReplyTo($dados['email_cedente'], utf8_decode($dados['nome_cedente'])); //Para que a resposta será enviada.
					$mail->Subject = "Boleto JC"; //Assunto do e-mail.
					$mail->Body = "Boleto em anexo";
					$mail->AddAttachment($boleto.".pdf");
					$mail->AddAddress($valor[$tipo]['email'], utf8_decode($valor[$tipo]['nome']));
					$mail->Send();			
					
				}
			break;
		}

			/*
			echo "<pre>";
		//	print_r($mail);
			print_r($email);
			print_r($dados);
			
			print_r($get_chamada);
			print_r($get_servico);
			echo "</pre>";
			echo "aqui";	
        	die();
			*/
			
				
		/*
			tipo = chamada | boleto
			cod = id chamada | id cliente
			acao = alterar, adicionar | gerar
		*/
		
		
    }
	
	# dados default
	public function get_dados($cod=NULL, $tabela=NULL, $campo_cod=NULL, $campo_retorno=NULL){
		$this->db->where($campo_cod, $cod);
		return $this->db->get($tabela)->row($campo_retorno);
	}
	
	# pessoas e setores que vão receber as notificações
	public function get_dados_emails($cod=NULL, $tipo=NULL){
		
		# Tipos: financeiro, operacional, marketing, retorno
		if($tipo=="financeiro") $campo_retorno = "confemail1";
		if($tipo=="operacional") $campo_retorno = "confemail2";
		if($tipo=="marketing") $campo_retorno = "confemail3";
		if($tipo=="retorno") $campo_retorno = "confemail4";
		
		$this->db->where("idCliente", $cod);
		$this->db->where($campo_retorno, "on");
		$result = $this->db->get("cliente_responsaveis")->result();
		$i=0;
		foreach($result as $valor){
			if($valor->confemail1=="on" and $tipo=="financeiro"){
				$setor[$i]['financeiro']['nome'] = $valor->nome;
				$setor[$i]['financeiro']['setor'] = "financeiro";
				$setor[$i]['financeiro']['email'] = $valor->email;
			}
			
			if($valor->confemail2=="on" and $tipo=="operacional"){
				$setor[$i]['operacional']['nome'] = $valor->nome;
				$setor[$i]["operacional"]['setor'] = "operacional";
				$setor[$i]["operacional"]['email'] = $valor->email;
			}
			
			if($valor->confemail3=="on" and $tipo=="marketing"){
				$setor[$i]['marketing']['nome'] = $valor->nome;
				$setor[$i]["marketing"]['setor'] = "marketing";
				$setor[$i]["marketing"]['email'] = $valor->email;
			}
			
			if($valor->confemail4=="on" and $tipo=="retorno"){
				$setor[$i]['retorno']['nome'] = $valor->nome;
				$setor[$i]["retorno"]['setor'] = "retorno";
				$setor[$i]["retorno"]['email'] = $valor->email;
			}
			$i++;
			
		}
		
		return $setor;
	}
	
	
	
}