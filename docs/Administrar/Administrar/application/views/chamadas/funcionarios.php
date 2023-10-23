

<?php


if(!$results){?>

    <div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-wrench"></i>
         </span>
        <h5>Funcionários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefones</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Funcionário Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>



<?php }
else{ ?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-wrench"></i>
         </span>
        <h5>Funcionários Online no APP</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>Nome</th>
            <th>Telefones</th>
            <th>Data</th>
            <th>Status</th>
            <th>Imei</th>
            <th style="width: 40px">ABERTO</th>
            <th style="width: 40px">CONCLU</th>
            <th style="width: 40px">CANCEL</th>

        </tr>
    </thead>
    <tbody id="conteudo-atualiza">
        <?php 
		//echo "<pre>";
		//print_r($results);
		//echo "</pre>";
		//abre o controller o model e o view eu abri
		
		foreach ($results as $r) {
			if(isset($r->status->status)) $status = $r->status->status; else $status="OFF-LINE";
			
			if(!empty($status) and $r->data==date("d/m/Y") and $status == "ONLINE" or $status == "AUSENTE" )
			{
				if($status=="ONLINE"){
					$cor = "#FFCC00"; 
				} else { 
					$cor = "#44B03D";
				}
				//$status = $r->status->status;
				$data = date("d/m/Y H:i", strtotime($r->status->data));
				
				
			} 
				else
			{ 
				$cor = "";
				
				//$status = "OFF-LINE"; // no model, eu coloquei pra vir somente a data sem a hora... 
				$data = "<span style='color:red'  >".( (isset($r->status->data)) ? date("d/m/Y H:i", strtotime($r->status->data)) : "Sem Registro" )."</span>";
			}
			if(strtoupper($status)=="ONLINE") $class_online = "class='div_online'"; else $class_online = "";
			
            echo "<tr>";
            echo '<td>'.$r->nome.'</td>';
            echo '<td>('.$r->responsaveltelefoneddd.') '.$r->responsaveltelefone.' | '.$r->responsavelcelular.' </td>';
            echo '<td>'.$data.'</td>';
			echo "<td style='text-transform: uppercase' bgcolor='".$cor."' ".$class_online."><center>".$status."</center></td>";
			echo '<td>'.$r->imei_usuario.'</td>';
			echo '<td>'.$r->total_aberto.'</td>';
			echo '<td>'.$r->total_concluido.'</td>';
			echo '<td>'.$r->total_cancelado.'</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
	
        



<?php }?>


<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>funcionario/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Funcionário</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFuncionario" name="idFuncionario" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Funcionário?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<div id="notification" style="display:none; position:absolute; width: 500px; height: 200px; top:200px; left: calc( (100% - 500px) / 2); border:1px solid red;padding:20px; background-color:white">
	<h1>Atualizou</h1>
</div>




<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var funcionario = $(this).attr('funcionario');
        $('#idFuncionario').val(funcionario);

    });
	
	var intervalo = window.setInterval(function() {
		quant_online = $(".div_online").length;
		var request = $.ajax({
		  url: <? base_url(); ?>"/Administrar/chamadas/atualiza",
		  method: "POST",
		  dataType: "text"
		});
		 
		request.done(function( msg ) {
			$("#conteudo-atualiza").html(msg);
			quant_online_atual = $(".div_online").length;
			$.notify("Listagem de Funcionários Online Atualizada!", "success");
			
			if(quant_online_atual > quant_online){
				$.notify("Novo usuário Online", "success");
			}
		});
		
		//pronto, entendeu todo o esquema?  s im sim, entendi... 

		 
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}, 10000);

});

</script>