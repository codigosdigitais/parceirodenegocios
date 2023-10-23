
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/vendor.bundle.base.js"></script>
        <!-- endinject -->

        <!-- Plugin js for this page -->
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/vendors/chart.js/Chart.min.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/vendors/datatables.net-bs4/jquery.dataTables.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/vendors/datatables.net-bs4/dataTables.select.min.js"></script>
        <!-- End plugin js for this page -->

        <!-- inject:js -->
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/off-canvas.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/hoverable-collapse.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/template.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/settings.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/todolist.js"></script>
        <!-- endinject -->

        <!-- Custom js for this page-->
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/dashboard.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/todolist.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/Chart.roundedBarCharts.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/bootstrap3-typeahead.js"></script>
        <!-- End custom js for this page-->

        <!-- Select 2 -->
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/vendors/select2/select2.min.js"></script>
        <!-- End select 2 -->


        <!-- Custom JS dashboard Chamado Novo -->
        <script>
            var BASE_URL = "<?php echo base_url($this->uri->segment(1)); ?>";
        </script>
        <script src="<?php echo base_url('assets/controllers'); ?>/chamadas/js/chamadas.js"></script>
        <script src="<?php echo base_url('assets/chamada'); ?>/assets/js/dashboard_148.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.js"></script>


        <script>
            <?php if($this->session->flashdata('error') != null){?>
            Swal.fire({
              icon: 'error',
              title: 'Algo deu errado',
              text: '<?php echo $this->session->flashdata('error');?>',
              footer: 'Dúvidas? Chame o suporte!'
            })    
            <?php } ?>        

            <?php if($this->session->flashdata('success') != null){?>
            Swal.fire({
              icon: 'success',
              title: 'Pronto, deu certo!',
              text: '<?php echo $this->session->flashdata('success');?>',
              footer: 'Dúvidas? Chame o suporte!',
              /*position: 'bottom-end'*/
            }) 
            <?php } ?> 
        </script>

        <!-- End custom dashboard --> 
      

    </body>
</html>