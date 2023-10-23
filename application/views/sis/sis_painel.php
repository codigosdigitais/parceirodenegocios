
<script type="text/javascript">
$(document).ready(function(){
	$('.idUsuario').change(function() {
		if ( $(this).val() != '' ) 	$(this).parent().find('#idPerfil').attr('disabled', true);
		else 						$(this).parent().find('#idPerfil').attr('disabled', false);
	});

	$('.idPerfil').change(function() {
		if ( $(this).val() != '' )  $(this).parent().find('#idUsuario').attr('disabled', true);
		else 						$(this).parent().find('#idUsuario').attr('disabled', false);
	});
});
</script>

<style>
.current{background-color: #696969 !important;color: #fff;font-weight: bold;}
.div-parceiro{width: 240px; display: inline-block; background-color: #CCCCCC;margin: 10px 10px;text-align: center;padding: 5px;box-sizing: border-box;}
.div-parceiro .title{font-size: 30px;height: 30px;font-weight: bold;padding: 5px;margin: 10px 0;}
.div-parceiro .title, .div-parceiro .sub-title{width: 100%; overflow: hidden;    box-sizing: border-box;}
.div-parceiro .sub-title{height: 40px;font-size: 14px;}
.div-parceiro .situacao{font-size: 12px;margin-top: 5px;font-weight: normal;}
.div-parceiro{}
</style>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
		    	
	            <fieldset>
	            	<legend>
		            	Selecione a empresa a vincular
	            	</legend>
	            </fieldset>
	            
	            <fieldset>
	            	<?php
	            		if ($parceiros) {
	            			foreach ($parceiros as $parceiro) {
	            				$situacao = ($parceiro->situacao) ? 'Ativo' : 'Inativo';
	            				
	            				echo "<div class='div-parceiro ";
	            				if ($this->session->userdata('idEmpresa') == $parceiro->idCliente) echo "current";
	            				echo "'>";

	            				echo "<form method='post' action='".base_url('entrega/vinculaParceiroSISAdmin/' . $parceiro->idCliente)."'>";
	            				echo "<input type='hidden' name='idCliente' value='".$parceiro->idCliente."'>";
	            				
	            				echo "<div class='title'>" . $parceiro->idCliente."</div>";
	            				echo "<div class='sub-title'>" . $parceiro->nomefantasia ."</div>";
	            				
	            				echo "<span>Usuário</span>";
	            				echo "<select id='idUsuario' name='idUsuario' class='idUsuario' required ";
	            				
	            				if ($this->session->userdata('idPerfilSimular') &&
	            						$this->session->userdata('idEmpresa') == $parceiro->idCliente) echo "disabled";
	            				
	            				echo ">";
	            				echo "<option></option>";
	            				
	            				if (isset($parceiro->usuarios)) {
	            					foreach ($parceiro->usuarios as $usuarios) {
	            						echo "<option value='".$usuarios->idUsuario."' ";
	            						
	            						if ($this->session->userdata('idUsuarioSimulacao') &&
            								$this->session->userdata('idUsuarioSimulacao') == $usuarios->idUsuario
            								) {
            									echo "selected";
            								}
	            								
	            						echo ">".$usuarios->nome."</option>";
	            					}
	            				}
	            				echo "</select>";

	            				
	            				echo "<span>Perfil</span>";
	            				echo "<select id='idPerfil' name='idPerfil' class='idPerfil' required ";
	            				
	            				if ($this->session->userdata('idUsuarioSimulacao') &&
	            						$this->session->userdata('idEmpresa') == $parceiro->idCliente) echo "disabled";
	            				
	            				echo ">";
	            				echo "<option></option>";
	            				 
	            				if (isset($parceiro->perfis)) {
	            					foreach ($parceiro->perfis as $perfil) {
	            						echo "<option value='".$perfil->idPerfil."' ";
	            						
	            						if ($this->session->userdata('idPerfilSimular') && 
	            							$this->session->userdata('idPerfilSimular') == $perfil->idPerfil &&
	            							$this->session->userdata('idEmpresa') == $parceiro->idCliente
	            							) {
	            								echo "selected";
	            							}
	            							
	            						echo ">".$perfil->nome."</option>";
	            					}
	            				}
	            				echo "</select>";
	            				
	            				echo "<div class='situacao'>" . $situacao."</div>";
	            				echo "<button class='btn btn-default'>Acessar</button>";

	            				echo "</form>";
	            				echo "</div>";
	            			}
	            		}
	            	?>
	            </fieldset>
	            
	</div>
</div>
