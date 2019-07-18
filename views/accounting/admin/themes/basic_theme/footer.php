<?php

$controller =& get_instance();

?>
<?php if(!isset($is_print)): ?>
 <footer class="footer">

        <span class="pull-right">

            Example text

        </span>

        Company 2015-2020

    </footer>



</div>
<div id="myModal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Modal Header</h4>

      </div>

      <div class="modal-body">

            <form action="<?php echo base_url('accounting/customers/importExcel') ?>" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="form-group">

                            <label>Import Excel File</label>

                             <input type="file" name="userfile" class="form-control" >

                        </div>

                        <div class="col-sm-offet-10">

                             <button type="submit" class="btn btn-primary" name="submit">Save</button> 

                        </div>

                    </div>

                </div>

                  <!--   <input type="file" name="userfile" />                                  

                     <button type="submit" name="submit">Save</button> --> 

            </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

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
    

<?php endif; ?>
    <!-- POS All Modal -->

<!-- Vendor scripts -->

<script src="<?php echo $this->theme_js_path ?>vendor/jquery/dist/jquery.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/jquery-ui/jquery-ui.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/jquery-flot/jquery.flot.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/jquery-flot/jquery.flot.resize.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/jquery-flot/jquery.flot.pie.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/flot.curvedlines/curvedLines.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/jquery.flot.spline/index.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/iCheck/icheck.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/peity/jquery.peity.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/sparkline/index.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables/media/js/jquery.dataTables.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>vendor/sweetalert/lib/sweet-alert.min.js"></script>



<!-- datepicker -->

<script src="<?php echo $this->theme_js_path ?>vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>

<!-- select2 -->

<script src="<?php echo $this->theme_js_path ?>vendor/select2-3.5.2/select2.min.js"></script>



<!-- App scripts -->

<script src="<?php echo $this->theme_js_path ?>scripts/homer.js"></script>

<script src="<?php echo $this->theme_js_path ?>scripts/charts.js"></script>

<!-- <script src="<?php echo $this->theme_js_path ?>angular/angularjs-1.5.6-angular.min.js"></script> -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script> -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular-route.min.js"></script> -->

<!-- <script src="<?php echo $this->theme_js_path ?>angular/angular.js-1.5.6-angular-route.min.js"></script>

<script src="<?php echo $this->theme_js_path ?>angular/angular_custom.js"></script> -->





<script>



    $(function () {



        /**

         * Flot charts data and options

         */

        var data1 = [ [0, 55], [1, 48], [2, 40], [3, 36], [4, 40], [5, 60], [6, 50], [7, 51] ];

        var data2 = [ [0, 56], [1, 49], [2, 41], [3, 38], [4, 46], [5, 67], [6, 57], [7, 59] ];



        var chartUsersOptions = {

            series: {

                splines: {

                    show: true,

                    tension: 0.4,

                    lineWidth: 1,

                    fill: 0.4

                },

            },

            grid: {

                tickColor: "#f0f0f0",

                borderWidth: 1,

                borderColor: 'f0f0f0',

                color: '#6a6c6f'

            },

            colors: [ "#62cb31", "#efefef"],

        };

        if($("#flot-line-chart").length > 0)

            $.plot($("#flot-line-chart"), [data1, data2], chartUsersOptions);



        /**

         * Flot charts 2 data and options

         */

        var chartIncomeData = [

            {

                label: "line",

                data: [ [1, 10], [2, 26], [3, 16], [4, 36], [5, 32], [6, 51] ]

            }

        ];



        var chartIncomeOptions = {

            series: {

                lines: {

                    show: true,

                    lineWidth: 0,

                    fill: true,

                    fillColor: "#64cc34"



                }

            },

            colors: ["#62cb31"],

            grid: {

                show: false

            },

            legend: {

                show: false

            }

        };

        if($("#flot-income-chart").length > 0)

           $.plot($("#flot-income-chart"), chartIncomeData, chartIncomeOptions);







    });



</script>

    <?php

    if(isset($resources['js']) && !empty($resources['js'])) {

        foreach ($resources['js'] as $key => $value) {

            echo '<script src="'.$value.'"></script>';

        }

    }

if(isset($model->tax) && $model->tax > 0) {
    ?><script type="text/javascript">
        calculateTotal();
    </script><?php
}

if(isset($edit_purchase) && $edit_purchase) {
    ?><script type="text/javascript">
        calculateTotal();
    </script><?php
}
if(isset($edit_sale) && $edit_sale) {
    ?><script type="text/javascript">
    calculateTotals();
    </script><?php
}

if(isset($edit_return) && $edit_return != null) {
    ?>
    <script type="text/javascript">
        $('.search-by-invoice-no').val('<?php echo $edit_return; ?>').trigger('change');
        $('.search-by-invoice-no').changeInvoiceOnReturn();
    </script>
    <?php
}
    ?>
    ?>

</body>



</html>