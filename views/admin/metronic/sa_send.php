                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row body-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                        <div class="col col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications col-sm-12 clearfix margin-top-20">
                                    <div class="alert alert-danger display-hide" data-test="test">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Sales Package successfully saved.
                                    </div>
                                    <?php } ?>
                                </div>

                                <!-- BEGIN FORM =======================================================-->
                                <?php echo form_open(
                                    'admin/campaigns/sales_package/send',
                                    array(
                                        'class' => 'form-horizontal'
                                    )
                                ); ?>

                                <?php
                                /***********
                                 * Sales Package Info
                                 */
                                ?>
                                <div class="col-sm-12 sa-info">

                                    <div class="form-body sa_info">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Package Name
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="sales_package_name" class="form-control input-sa_info clear-readonly" value="<?php echo $sa_details->sales_package_name; ?>" readonly />
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email Subject
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="email_subject" class="form-control input-sa_info clear-readonly" value="<?php echo $sa_details->email_subject; ?>" readonly />
                                            </div>
                                        </div>
                                        <br />
                                        <h4>Email Details</h4>
                                        <hr />

                                    </div>

                                </div>

                                <div class="col-sm-12">

                                    <?php $this->load->view('admin/metronic/sa_email_view'); ?>

                                </div>

                                </form>
                                <!-- END FORM =======================================================-->

                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-horizontal" role="form">

    							<div class="form-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <style>
                                        .help-block-error {
                                            font-size: 0.8em;
                                            font-style: italic;
                                        }
                                        .form-group-badge > label.control-label {
                                            text-align: left;
                                        }
                                        .badge-label {
                                            padding-left: 10px;
                                        }
                                        .badge.custom-badge {
                                            height: 30px;
                                            width: 30px;
                                            background-color: #E5E5E5; /* #E5E5E5, grey */
                                            position: relative;
                                            top: -7px;
                                            padding-top: 10px;
                                            border-radius: 18px !important;
                                            color: black;
                                        }
                                        .badge.custom-badge.active {
                                            background-color: black;
                                            color: white;
                                        }
                                        .badge.custom-badge.done {
                                            background-color: grey;
                                            color: white;
                                        }
                                    </style>

                                    <?php
    								/***********
    								 * Dropdowns and Options
    								 */
    								?>
                                    <div class="form-group form-group-badge select-vendor-dropdown">
                                        <label class="control-label col-md-4">
                                            <span class="badge custom-badge active pull-left step1"> 1 </span>
                                            <span class="badge-label"> Send Sales Package </span>
                                        </label>
                                        <div class="col-md-8">
                                            <cite class="help-block font-red" style="padding-top:3px;">
                                                Select From Options below
                                            </cite>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a href="javascript:;" class="btn dark btn-md select-send-options send-to-current-user col-md-4">
                                                Send to Existing User(s)
                                            </a>
                                            <a href="javascript:;" class="btn dark btn-md select-send-options send-to-new-user col-md-4">
                                                Send to New Wholesale User
                                            </a>
                                            <!--
                                            <a href="<?php echo site_url('admin/campaigns/sales_package/modify/index/'.$sa_details->sales_package_id); ?>" class="btn dark btn-md select-send-options thumbs-grid-view col-md-4" style="">
                                            -->
                                            <a href="javascript:;" class="btn dark btn-md select-send-options thumbs-grid-view col-md-4 tooltips" data-original-title="Under Construction" style="">
                                                Modify Sales Package
                                            </a>
                                        </div>
                                    </div>

                                    <hr />

                                </div>

                            </div>

                            <?php
                            /***********
                             * Select from
                             * Existing Users or Add New User
                             */
                            ?>
                            <div class="">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open(
                                    'admin/campaigns/sales_package/send/sa/'.$sa_details->sales_package_id,
                                    array(
                                        'id' => 'form-send_sales_package'
                                    )
                                ); ?>

                                <input type="hidden" name="sales_package_id" value="<?php echo $sa_details->sales_package_id; ?>" />
                                <input type="hidden" name="send_to" value="" />

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications">
                                    <div class="alert alert-danger display-none">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if ($this->session->error == 'no_input_data') { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
                                    </div>
                                    <?php } ?>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                </div>

                                <?php $this->load->view('admin/metronic/sa_send_to_new_user'); ?>

                                <?php $this->load->view('admin/metronic/sa_send_to_current_user'); ?>

                                <h3 class="notice-select-action"><cite>Select action...</cite></h3>

                                <div class="btn-set btn-set-send-sales-package display-none">
                                    <button type="submit" class="btn dark btn-lg btn-block <?php echo $sa_details->sales_package_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?>">
                                        Send <?php echo @$linesheet_sending_only ? 'Linesheet' : 'Package'; ?>
                                    </button>
                                </div>

                                <?php echo form_close(); ?>
                                <!-- End FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>

                        </div>

                        <!-- ADD STYLE NUMBERS NOT YET UPLOADED -->
                        <div class="modal fade" id="modal-unlisted_style_no" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Add STYLE NUMBERS not on productl ist </h4>
                                    </div>

                                    <!-- BEGIN FORM-->
                                    <!-- FORM =======================================================================-->
                                    <form id="form-add_unlisted_style_no" class="form-horizontal" action="" method="POST" accept-charset="utf-8" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <input type="hidden" name="action" value="add_item" />

                                    <div class="modal-body">

                                        <div class="form margin-bottom-30">

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Style Number:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control facet_name" name="prod_no" value="" style="text-transform:uppercase;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Color Code:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <select class="form-control bs-select" name="color_code" data-live-search="true" data-size="8" data-show-subtext="true">
                                                        <option value="" selected disabled> - Select a color - </option>

                                                        <?php
                                                        if (@$colors)
                                                        {
                                                            foreach ($colors as $color)
                                                            { ?>

                                                        <option value="<?php echo $color->color_code; ?>" data-subtext="<cite>(<?php echo $color->color_code; ?>)</cite>" data-color_name="<?php echo $color->color_name; ?>">
                                                            <?php echo ucwords(strtolower($color->color_name)); ?>
                                                        </option>

                                                                <?php
                                                            }
                                                        } ?>

                                                    </select>
                                                    <input type="hidden" name="color_name" value="" />
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn dark"> Submit </button>
                                    </div>

                                    </form>
                                    <!-- END FORM ===================================================================-->
                                    <!-- END FORM-->

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- EDIT VENDOR PRICE -->
                        <div id="modal-edit_item_price" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Item Price</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="eip-modal-item"></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">New Price
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="item_price" data-required="1" class="form-control input-sm modal-input-item-price" value="" size="2" data-prod_no="" data-item="" data-page="create" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark submit-edit_item_prices" data-item="">Apply changes</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>
                    <!-- END PAGE CONTENT BODY -->