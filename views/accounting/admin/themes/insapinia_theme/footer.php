<?php

$controller =& get_instance();
// debug($controller->currency);
?>
<script type="text/javascript">
    var base_url='<?php echo base_url() ?>';
    var token_value='<?php echo $controller->security->get_csrf_hash() ?>';
    var today = '<?php echo date('M d,Y'); ?>';
    var currency = {};
    currency.prefix = '<?php echo isset($controller->currency->prefix) ? $controller->currency->prefix : ''; ?>';
    currency.suffix = '<?php echo isset($controller->currency->suffix) ? $controller->currency->suffix : ''; ?>';


    function price_input_field(attributes = array()) {
        var field = '<div class="input-group" style="width: 145px;">';
        if(currency.prefix)
            field += '<div class="input-group-addon">'+currency.prefix+'</div>';
        field += '<input type="MyNumber" ';
        if(attributes) {
            for(var i in attributes) {
                field += i+'="'+attributes[i]+'" ';
            }
        }
        field += ' />';
        if(currency.suffix)
            field += '<div class="input-group-addon">'+currency.suffix+'</div>';
        field += '</div>';
        return field;
    }
    

    function quantity_input_field(attributes = array(), parent_class='') {
        var field = '<div class="input-group quantity-field '+parent_class+'" style="width: 120px;">';
        field += '<div class="input-group-addon minus-qty">-</div>';
        field += '<input type="MyNumber" ';
        if(attributes) {
            for(var i in attributes) {
                field += i+'="'+attributes[i]+'" ';
            }
        }
        field += ' />';
        field += '<div class="input-group-addon add-qty">+</div>';
        field += '</div>';
        return field;
    }

    function has_access_of(permission = '') {
        <?php 
        $permission = '<script>document.write(permission)</script';
        ?>
        return '<?php echo $controller->has_access_of($permission); ?>';
    }
</script>
</div>
<?php if(!isset($is_print)): ?>
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
    
     <footer class="footer" style="background: #ddd;text-align: center;">

        <span class="pull-right">

           

        </span>

        <strong style="margin-left: 100px"> <a href="https://www.itvision.com.pk/" target="_blank"><span style="color: #000;">All reserved © 2017</span> IT VISION</a></strong>

    </footer>
<?php endif; ?>
    <!-- POS All Modal -->

    

 <!-- Mainly scripts -->

    <script src="<?php echo $controller->theme_js_path ?>js/jquery-2.1.1.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/bootstrap.min.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>



    <!-- Flot -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.spline.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.resize.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.pie.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/clockpicker/clockpicker.js"></script>



    <!-- Peity -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/peity/jquery.peity.min.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/demo/peity-demo.js"></script>



    <!-- Custom and plugin javascript -->

    <script src="<?php echo $controller->theme_js_path ?>js/inspinia.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/pace/pace.min.js"></script>



    <!-- jQuery UI -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>



    <!-- GITTER -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/gritter/jquery.gritter.min.js"></script>



    <!-- Sparkline -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>



    <!-- Signature -->

    <script src="<?php echo $controller->theme_js_path ?>js/signature/flashcanvas.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/signature/jSignature.min.js"></script>



    <!-- Sparkline demo data  -->

    <script src="<?php echo $controller->theme_js_path ?>js/demo/sparkline-demo.js"></script>



    <!-- ChartJS-->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/chartJs/Chart.min.js"></script>

    <!-- Sweet alert -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/sweetalert/sweetalert.min.js"></script>

    

    <!-- Flot -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.spline.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.resize.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.pie.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.symbol.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/flot/jquery.flot.time.js"></script>



    <!-- Toastr -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/toastr/toastr.min.js"></script>

    <!-- Switchery -->

   <script src="<?php echo $controller->theme_js_path ?>js/plugins/switchery/switchery.js"></script>

    <!-- choosen -->

    <!-- Select2 -->

    <script src="<?php echo $controller->theme_js_path ?>js/plugins/select2/select2.full.min.js"></script>



    <script type="text/javascript" src="<?php echo $controller->theme_js_path ?>js/signature_pad.js"></script>

    <!-- Datepicker -->

    <script src="<?php  echo $controller->theme_js_path ?>js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo $controller->theme_js_path ?>js/maskmoney/jquery.maskMoney.min.js"></script>

    <script>

        $(document).ready(function() {

            $('body').on('click', '.checkbox', function(event) {

                if($(this).find('.icheckbox_square-green').hasClass('checked'))

                    $(this).find('input[type="hidden"]').val('0');

                else

                    $(this).find('input[type="hidden"]').val('1');

            });

            $('input[type="checkbox"]').parent().on('click', function(event) {

                var value = $(this).find('input[type="checkbox"]').prop('checked');

                if(value == false) {

                    $(this).find('input[type="checkbox"]').val('1')

                } else {

                    $(this).find('input[type="checkbox"]').val('0')

                }

            });

            $('body').on('click', '.serialized-field', function(event) {

                var value = $(this).find('input').prop('checked');

                if(value == false) {

                    $(this).parent().parent().parent().find('.serial-input').show();

                } else {

                    $(this).parent().parent().parent().find('.serial-input').hide();

                }

            });

            $('body').on('click', '.warranty-field', function(event) {

                var value = $(this).find('input').prop('checked');

                if(value == false) {

                    $(this).parent().parent().parent().next('div').find('.warranty-date-input').show();

                } else {

                    $(this).parent().parent().parent().next('div').find('.warranty-date-input').hide();

                }

            });

        });

    </script>

    <!-- Jasny -->

    

    <!-- <script src="<?php echo base_url('resources/multiselect-master/gulpfile.js') ?>" type="text/javascript"></script -->

    <script src="<?php  echo $controller->theme_js_path ?>js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- iCheck -->

    <script src="<?php  echo $controller->theme_js_path ?>js/plugins/iCheck/icheck.min.js"></script>



    <script src="<?php  echo $controller->theme_js_path ?>js/plugins/dataTables/datatables.min.js"></script>

    <script type="text/javascript" src="<?php  echo $controller->theme_js_path ?>js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <script src="<?php  echo $controller->theme_js_path ?>js/plugins/summernote/summernote.min.js"></script>
<script type="text/javascript">
// General Methods
Number.prototype.formatNumber = function(decimal = null) {
    decimal = (decimal) ? decimal : 2;
    return this.toFixed(decimal).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
Number.prototype.formatPrice = function() {

    return '<?php echo price_value('+value+') ?>';
}
var parseFloatFormatted = function(value) {
    if(value == undefined || value == '')
        return value;
    return parseFloat(value.toString().replaceAll(',', '').replaceAll(' ', ''));
}
var parseIntFormatted = function(value) {
    if(value == undefined || value == '')
        return value;
    return parseInt(value.toString().replaceAll(',', '').replaceAll(' ', ''));
}
String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(new RegExp(find, 'g'), replace);
};

function price_value(value) {
    var amount = parseFloatFormatted(value);
    amount = amount.formatNumber();
    if(currency.prefix)
        amount = '<span class="">'+currency.prefix+'</span>'+amount;
    if(currency.suffix)
        amount += '<span class="">'+currency.suffix+'</span>';

    return amount;
}

function printPage(url = null, data=null) {
    if(url != null) {
        $.ajax({
            url: url,
            data: data,
            type: 'GET',
            success: function(response) {
                var originalContents = document.body.innerHTML;
                window.document.body.innerHTML = response;
                setTimeout(function() {
                    window.print();
                    setTimeout(function() {
                        document.body.innerHTML = originalContents; 
                        window.location.reload();
                    }, 300);
                }, 500);
            }
        })
    }
}
function printbarcodePage(url = null, data=null) {
    if(url != null) {
        $.ajax({
            url: url,
            data: data,
            type: 'GET',
            success: function(response) {
                var originalContents = document.body.innerHTML;
                window.document.body.innerHTML = response;
                setTimeout(function() {
                    window.print();
                    setTimeout(function() {
                        document.body.innerHTML = originalContents; 
                        window.location.reload();
                    }, 300);
                }, 500);
            }
        })
    }
}
function ApplyCustomNumberInputs() {
    document.querySelectorAll('[type="MyNumber"]').forEach(function(element, index) {
        element.addEventListener('input', function(e) {
            // invented by Musa
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        });
        element.addEventListener('click', function(e) {
            this.select();
        })
    });
}
ApplyCustomNumberInputs();
</script>
    <script>

        $(document).ready(function() {

            $('body').on('click', '.quantity-field .add-qty, .quantity-field .minus-qty', function(e) {
                e.preventDefault();
                var wrapper = $(this).closest('.quantity-field');
                var qty = wrapper.find('input').val();
                qty = (qty) ? parseInt(qty) : 0;
                if($(this).hasClass('add-qty'))
                    qty++;
                else
                    qty--;
                wrapper.find('input').val(qty);
                wrapper.find('input').trigger('keyup');
                wrapper.find('input').trigger('change');
            });
            // setTimeout(function() {

            //     toastr.options = {

            //         closeButton: true,

            //         progressBar: true,

            //         showMethod: 'slideDown',

            //         timeOut: 4000

            //     };

            //     toastr.success('Responsive Admin Panel', 'Welcome to Repair Pro');



            // }, 1300);





            

            $('.i-checks').iCheck({

                checkboxClass: 'icheckbox_square-green',

                radioClass: 'iradio_square-green',

            });

            $('.summernote').summernote({

                height: '200px'

            });

        });

    </script>

    <?php

    if(isset($resources['js']) && !empty($resources['js'])) {

        foreach ($resources['js'] as $key => $value) {

            echo '<script src="'.$value.'"></script>';

        }

    }
if(isset($edit_purchase) && $edit_purchase) {
    ?><script type="text/javascript">
        calculatePriceForProduct();
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
$print_sale_quoatation = $this->session->flashdata('print_sale_quoatation');
if($print_sale_quoatation != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/sales/printQuotation/".$print_sale_quoatation); ?>';
    printPage(url);
</script>
<?php }
$print_product_barcode = $this->session->flashdata('print_product_barcode');
if($print_product_barcode != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/products/printbarcode/".$print_product_barcode); ?>';
    printbarcodePage(url);
</script>
<?php }
$print_sale_invoice = $this->session->flashdata('print_sale_invoice');
if($print_sale_invoice != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/sales/printInvoice/".$print_sale_invoice."/print"); ?>';
    printPage(url);
</script>
<?php }
$print_sale_order = $this->session->flashdata('print_sale_order');
if($print_sale_order != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/sales/printOrder/".$print_sale_order); ?>';
    printPage(url);
</script>
<?php }
$print_sale_return = $this->session->flashdata('print_sale_return');
if($print_sale_return != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/sales/printReturn/".$print_sale_return); ?>';
    printPage(url);
</script>
<?php }
$print_purchase_invoice = $this->session->flashdata('print_purchase_invoice');
if($print_purchase_invoice != null) { ?>
<script type="text/javascript">
    // alert('abid is here')
    var url = '<?php echo base_url("accounting/purchases/printInvoice/".$print_purchase_invoice."/print"); ?>';
    printPage(url);
</script>
<?php }
$print_purchase_quotation = $this->session->flashdata('print_purchase_quotation');
if($print_purchase_quotation != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/purchases/printQuotation/".$print_purchase_quotation); ?>';
    printPage(url);
</script>
<?php }
$print_purchase_order = $this->session->flashdata('print_purchase_order');
if($print_purchase_order != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/purchases/printOrder/".$print_purchase_order); ?>';
    printPage(url);
</script>
<?php }
$print_purchase_return = $this->session->flashdata('print_purchase_return');
if($print_purchase_return != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/purchases/printReturn/".$print_purchase_return); ?>';
    printPage(url);
</script>
<?php }
$print_payment_voucher = $this->session->flashdata('print_payment_voucher');
if($print_payment_voucher != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/transactions/printPaymentVoucher/".$print_payment_voucher); ?>';
    printPage(url);
</script>
<?php }
$print_receipt_voucher = $this->session->flashdata('print_receipt_voucher');
if($print_receipt_voucher != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/transactions/printReceiptVoucher/".$print_receipt_voucher); ?>';
    printPage(url);
</script>
<?php }
$print_stock_count = $this->session->flashdata('print_stock_count');
if($print_stock_count != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/products/viewStockInvoice/".$print_stock_count)."/print"; ?>';
    printPage(url);
</script>
<?php }
    ?>

   
<?php
if(isset($permissions_page) && $permissions_page) { ?>
<script type="text/javascript">
  load_user_permissions();
</script>
<?php } ?>
<script type="text/javascript">
    if($('[name="stock_type"]').length > 0) {
        updatePriceListTable($('[name="stock_type"]').val());
    }
</script>
</body>

</html>