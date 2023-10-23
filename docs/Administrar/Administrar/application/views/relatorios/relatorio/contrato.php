<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?php $tituloBase = ($this->uri->segment(2)=='editar') ? '' : 'Relatório de Contratos'; ?>
<div class="row-fluid" style="margin-top:-35px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content" id="botao-novo-relatorio">

                <a href="<?php echo base_url('101/relatorios/contratos/faturamento'); ?>">
                    <button type="button" class="btn btn-primary" aria-label="Relatório de Faturamento">
                        <i class="mdi mdi-currency-usd" aria-hidden="true"></i>
                        <p>Faturamento</p>
                    </button>
                </a>

                <a href="<?php echo base_url('101/relatorios/contratos/horario'); ?>">
                    <button type="button" class="btn btn-warning" aria-label="Relatório de Horários">
                        <i class="mdi mdi-clock" aria-hidden="true"></i>
                        <p>Horários</p>
                    </button>
                </a>

	        </div>
   	 	</div>
	</div>
</div>

