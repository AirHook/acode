                    <div class="form-body">
                        <?php
                        /***********
                         * Noification area
                         */
                        ?>
                        <div class="notifications">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                            <?php if ($this->session->flashdata('success') == 'add') { ?>
                            <div class="alert alert-success auto-remove">
                                <button class="close" data-close="alert"></button> New Sales Order CREATED!
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success') == 'edit') { ?>
                            <div class="alert alert-success auto-remove">
                                <button class="close" data-close="alert"></button> Sales Order information updated...
                            </div>
                            <?php } ?>
                            <?php if (validation_errors()) { ?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                            </div>
                            <?php } ?>
                        </div>

                        <?php
                        /***********
                         * Action Bar
                         */
                        ?>
                        <div class="portlet solid " style="padding-right:0px;padding-left:0px;">

                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase"> <?php echo $page_title; ?></span>
                                </div>
                                <div class="actions btn-set">
                                    <a class="btn btn-secondary-outline" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders') : site_url($this->config->slash_item('admin_folder').'sales_orders'); ?>">
                                        <i class="fa fa-reply"></i> Back to Sales Order list</a>
                                    <a class="btn blue" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/create') : site_url($this->config->slash_item('admin_folder').'sales_orders/create'); ?>">
                                        <i class="fa fa-plus"></i> Create New Sales Order </a>
                                </div>
                            </div>
                            <hr />
                            <div class="portlet-title">

                                <?php if ($this->sales_order_details->status != '5')
                                { ?>

                                <div class="caption modify-so">
                                    <!--
                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/purchase_orders/modify/index/'.$so_details->sales_order_id); ?>">
                                    -->
                                    <a class="btn dark " href="javascript:;">
                                        <i class="fa fa-pencil"></i> Modify SO
                                    </a>
                                </div>

                                    <?php
                                } ?>

                                <div class="actions btn-set">
                                    <a class="btn dark" href="<?php echo site_url($this->uri->segment(1).'/barcodes/print_so_barcodes/'.$so_details->sales_order_id); ?>" target="_blank">
                                        <i class="fa fa-print"></i> Print SO Barcodes
                                    </a>
                                    &nbsp;
                                    <a class="btn btn-default po-pdf-print_" href="<?php echo site_url($this->uri->segment(1).'/sales_orders/view_pdf/index/'.$so_details->sales_order_id); ?>" target="_blank">
                                        <i class="fa fa-eye"></i> View PDF for Print/Download
                                    </a>
                                    &nbsp;
                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/sales_orders/create/send/'.$so_details->sales_order_id); ?>">
                                        <i class="fa fa-send"></i> Send SO Again
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                        /***********
                         * STATUS
                         */
                        ?>
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"sales_order_id":"<?php echo $this->sales_order_details->sales_order_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                    <label class="control-label col-md-3">Status</label>
                                    <div class="col-md-9">
                                        <div class="margin-bottom-10">
                                            <input id="option4" type="radio" name="status" value="1" class="make-switch switch-status" data-size="mini" data-on-text="<i class='icon-plus'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '1' ? 'checked' : ''; ?> />
                                            <label for="option4">Open/Pending</label>
                                        </div>
                                        <div class="margin-bottom-10">
                                            <input id="option3" type="radio" name="status" value="3" class="make-switch switch-status" data-size="mini" data-on-color="warning" data-on-text="<i class='icon-energy'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '3' ? 'checked' : ''; ?> />
                                            <label for="option3">Return</label>
                                        </div>
                                        <div class="margin-bottom-10">
                                            <input id="option2" type="radio" name="status" value="2" class="make-switch switch-status" data-size="mini" data-on-color="danger" data-on-text="<i class='icon-ban'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '2' ? 'checked' : ''; ?> />
                                            <label for="option2">On HOLD</label>
                                        </div>
                                        <!--
                                        <div class="margin-bottom-10">
                                            <input id="option2" type="radio" name="status" value="4" class="make-switch switch-status" data-size="mini" data-on-color="info" data-on-text="<i class='fa fa-truck'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '4' ? 'checked' : ''; ?> />
                                            <label for="option2">In Transit</label>
                                        </div>
                                        -->
                                        <div class="margin-bottom-10">
                                            <input id="option1" type="radio" name="status" value="5" class="make-switch switch-status" data-size="mini" data-on-color="success" data-on-text="<i class='icon-check'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '5' ? 'checked' : ''; ?> />
                                            <label for="option1">Complete/Delivery</label>
                                        </div>
                                        <cite class="help-block small"> Changing the PO Status will update the PO almost immediately.<br />Be sure you know what you are doing. </cite>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    /***********
                     * SO Form Read Only Mode
                     */
                    ?>
                    <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/so_details_view')); ?>
