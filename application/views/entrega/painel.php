<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/dist/plugins/jqplot.donutRenderer.min.js"></script>


<?php if (isset($propaganda) && $propaganda) { ?>
  <script type="text/javascript" src="<?php echo base_url("assets/jGalley/jGalley-1.0.9.js"); ?>"></script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function(){

    <?php if (isset($propaganda) && $propaganda) { ?>
      $('.propaganda').jGalley({'criarNavegacao': false});
    <?php } ?>

  });
</script>

<style>
  .propaganda{float: right;margin-top: 10px;width: 33%;height: 320px;}
</style>

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions" style="text-align: left;">


        <?php
        if (isset($propaganda) && $propaganda) {
          echo '<div class="propaganda">';
          foreach ($propaganda as $p) {
            echo '<img src="'.base_url($p->url).'">';
          }
        }
        echo '</div>';
        ?>

      </ul>
    </div>
  </div>  
<!--End-Action boxes-->  