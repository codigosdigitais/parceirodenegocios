<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/proventos/js/proventos.js"></script>

<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
</style>
<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>proventos/lista" class="btn btn-success"><i class="icon-plus icon-white"></i> Listar Proventos Adicionados</a>    
<?php } ?>

<a href="<?php echo base_url()?>administrando/parametros" class="btn"><span>Parâmetros</span></a>

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                    <i class="icon-tags"></i>
                    </span>
                    <h5>Adicionar Provento</h5>
                </div>
                <div class="widget-content">

                    
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th width="30px;">#</th>
                                <th>Parâmetro</th>
                                <th>Código eSocial</th>
                                <th width="140px">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							foreach ($parametroProvento as $r) {
                                echo '<tr>';
                                    echo '<td>'.$r->idParametro.'</td>';
                                    echo '<td>'.$r->parametro.'</td>';
									echo '<td>'.$r->codigoeSocial.'</td>';
                                echo '<td>';
                                if($this->permission->canInsert()){
                                    echo '<a href="'.base_url().'proventos/adicionar/'.$r->idParametro.'" style="margin-right: 1%" class="btn ">INCLUIR REGISTROS</a>'; 
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
							?>
                            <tr>
                                
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>


	<script>
	
		function getParametro() {
			var id = $('#idTipo').val();
			$(".idParametro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>proventos/ajax/parametro/" + id,
				{idParametro:jQuery(id).val()},
				function(valor){
					 $(".idParametro").html(valor);
				}
			);
		}
		
		function getEmpresaRegistro() {
			var id = $('#idParametro').val();
			$(".empresaRegistro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>proventos/ajax/empresaregistro/",
				{empresaRegistro:jQuery(id).val()},
				function(valor){
					 $(".empresaRegistro").html(valor);
				}
			);
		}
		
		function getFuncionario() {
			var id = $('#empresaRegistro').val();
			$(".idFuncionarioLista").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>proventos/ajax/funcionario/"+id,
				{idFuncionarioLista:jQuery(id).val()},
				function(valor){
					 $(".idFuncionarioLista").html(valor);
				}
			);
		}
	
	</script>