
</div>
    <!-- Hidden content -->

    <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content animated flipInY">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancel</span></button>

                    <h4 class="modal-title">Modal title</h4>

                    <small class="font-bold"></small>

                </div>

                <div class="modal-body">

                    

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary save-modal">Create</button>

                </div>

            </div>

        </div>

    </div>
    
     <footer class="footer" style="background: #ddd;text-align: center;">

        <span class="pull-right">

           

        </span>

        <strong style="margin-left: 100px"> <a href="javascript:void(0)" target="_blank"><span style="color: #000;">All reserved © <?php echo  date('Y') ?></span> </a></strong>

    </footer>
    <!-- POS All Modal -->

    

 <!-- Mainly scripts -->

    <script src="<?php echo $this->theme_js_path ?>js/jquery-2.1.1.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/bootstrap.min.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>



    <!-- Flot -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.spline.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.resize.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.pie.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/clockpicker/clockpicker.js"></script>



    <!-- Peity -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/peity/jquery.peity.min.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/demo/peity-demo.js"></script>



    <!-- Custom and plugin javascript -->

    <script src="<?php echo $this->theme_js_path ?>js/inspinia.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/pace/pace.min.js"></script>



    <!-- jQuery UI -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>



    <!-- GITTER -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/gritter/jquery.gritter.min.js"></script>



    <!-- Sparkline -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>



    <!-- Signature -->

    <script src="<?php echo $this->theme_js_path ?>js/signature/flashcanvas.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/signature/jSignature.min.js"></script>



    <!-- Sparkline demo data  -->

    <script src="<?php echo $this->theme_js_path ?>js/demo/sparkline-demo.js"></script>



    <!-- ChartJS-->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/chartJs/Chart.min.js"></script>

    <!-- Sweet alert -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/sweetalert/sweetalert.min.js"></script>

    

    <!-- Flot -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.spline.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.resize.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.pie.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.symbol.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/plugins/flot/jquery.flot.time.js"></script>



    <!-- Toastr -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/toastr/toastr.min.js"></script>

    <!-- Switchery -->

   <script src="<?php echo $this->theme_js_path ?>js/plugins/switchery/switchery.js"></script>

    <!-- choosen -->

    <!-- Select2 -->

    <script src="<?php echo $this->theme_js_path ?>js/plugins/select2/select2.full.min.js"></script>



    <script type="text/javascript" src="<?php echo $this->theme_js_path ?>js/signature_pad.js"></script>

    <!-- Datepicker -->

    <script src="<?php  echo $this->theme_js_path ?>js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo $this->theme_js_path ?>js/maskmoney/jquery.maskMoney.min.js"></script>

    <script>

        $(document).ready(function() {
            var base_url='<?php echo base_url() ?>';
        });

    </script>

    <!-- Jasny -->

    

    <!-- <script src="<?php echo base_url('resources/multiselect-master/gulpfile.js') ?>" type="text/javascript"></script -->

    <script src="<?php  echo $this->theme_js_path ?>js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- iCheck -->

    <script src="<?php  echo $this->theme_js_path ?>js/plugins/iCheck/icheck.min.js"></script>



    <script src="<?php  echo $this->theme_js_path ?>js/plugins/dataTables/datatables.min.js"></script>

    <script type="text/javascript" src="<?php  echo $this->theme_js_path ?>js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <script src="<?php  echo $this->theme_js_path ?>js/plugins/summernote/summernote.min.js"></script>
    <?php

    if(isset($resources['js']) && !empty($resources['js'])) {

        foreach ($resources['js'] as $key => $value) {

            echo '<script src="'.$value.'"></script>';

        }

    } ?>
    <script src="<?php  echo base_url('assets/my-account') ?>/js/my_account.js"></script>
</body>

</html>