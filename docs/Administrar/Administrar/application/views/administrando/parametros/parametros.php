

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Parâmetros</li></ol>
    <ol class="breadcrumb"> 
        <a href="<?php echo base_url();?>administrando/parametrosAdicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Parâmetro</a>     
    </ol>
</nav>


<?php if(!$results){ ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Parâmetro</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">Nenhum Parâmetro Cadastrado</td>
        </tr>
    </tbody>
</table>

<?php } else { ?>
    <!-- Filtro de Pesquisa desabilitado / 09/02/2021
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <form action="<?php echo base_url()?>administrando/parametros" method="get">
                        <div class="span12">
                           	<select class="form-control span8" name="tipo_parametro" id="tipo_parametro">
                            	
                            	<option>Selecione o Tipo de Parâmetro</option>
                                <?
                    				foreach($results_lista as $valor){
                    			?>	
                                <option value="<? echo $valor->base_idParametro; ?>" style="text-transform:uppercase" <? if(isset($_GET['tipo_parametro'])){ if($_GET['tipo_parametro']==$valor->base_idParametro){ echo "selected"; } } ?>><? echo $valor->base_parametro; ?></option>
                                <? } ?>

                            </select>
                        </div>

                        <div class="span2">
                            <button class="btn btn-inverse btn-primary">Pesquisar</button>
                        </div>
                    </form>
                </li>
            </ol>
        </nav>
    -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="30px;">#</th>
            <th>Categoria/Parâmetro</th>
            <th width="110px;">Código eSocial</th>
            <th width="120px;">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		foreach ($results as $r) {
			//if(!isset($_GET['tipo_parametro'])){ $cor = "#CCCCCC"; } else { $cor = ""; }
	           if(isset($_GET['tipo_parametro'])){ $tipo_parametro = "?tipo_parametro=".$_GET['tipo_parametro']; } else { $tipo_parametro = ""; }
			
            $cor = ($r->base_idParametro) ? "#CCCCCC" : '';
			
            echo "<tr bgcolor='".$cor."'>";
				echo "<td bgcolor='".$cor."'><center>".$r->base_idParametro.'</center></td>';
				echo '<td style="text-transform:uppercase;">'.$r->base_parametro.'</td>';
				echo '<td>'.$r->codigoeSocial.'</td>';
           		echo '<td>';
                echo '<a href="'.base_url().'administrando/parametrosEditar/'.$r->base_idParametro.$tipo_parametro.'" style="margin: 0px !important;" class="btn btn-info btn-icone-pequeno" title="Editar Parametro"><i class="icon-pencil icon-white"></i></a>'; 
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" Parametro="'.$r->base_idParametro.'" style="margin: 0px !important;" class="btn btn-danger btn-icone-pequeno" title="Excluir Parametro"><i class="icon-remove icon-white"></i></a>'; 
            echo '</td>';
            echo '</tr>';
			
			
			foreach ($r->sub_parametros as $r_sub) {
				
				if(isset($_GET['tipo_parametro'])){ $tipo_parametro = "?tipo_parametro=".$_GET['tipo_parametro']; } else { $tipo_parametro = ""; }
				
				echo '<tr>';
					echo '<td></td>';
					echo '<td style="text-transform:uppercase;">'.$r_sub->sub_parametro.'</td>';
					echo '<td>'.$r_sub->codigoeSocial.'</td>';
					echo '<td>';
					echo '<a href="'.base_url().'administrando/parametrosEditar/'.$r_sub->sub_idParametro.$tipo_parametro.'" style="margin: 0px !important;" class="btn btn-info btn-icone-pequeno" title="Editar Parametro"><i class="icon-pencil icon-white"></i></a>'; 
					echo '<a href="#modal-excluir" role="button" data-toggle="modal" Parametro="'.$r_sub->sub_idParametro.'" style="margin: 0px !important;" class="btn btn-danger btn-icone-pequeno" title="Excluir Parametro"><i class="icon-remove icon-white"></i></a>'; 
				echo '</td>';
				echo '</tr>';
			}
        }
		
		?>
        <tr>
            
        </tr>
    </tbody>
</table>

<?php if(empty($_GET['tipo_parametro'])){ echo $this->pagination->create_links();} }?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>administrando/parametroExcluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Parametro</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idParametro" name="idParametro" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Parâmetro?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var Parametro = $(this).attr('Parametro');
        $('#idParametro').val(Parametro);

    });

});

</script>