                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('admin/metronic/po_steps_wizard'); ?>

                        <h2 style="color:red;">
                            VENDOR: <?php echo $vendor->vendor_name; ?>
                            <a href="#modal-change_vendor" data-toggle="modal">
                                <span style="font-size:1rem;color:initial;margin-left:10px;"> Edit/Change Vendor </span>
                            </a>
                        </h2>

                        <div class="row margin-bottom-30">

                            <div class="col-md-12">
                                <?php
                                $this->load->view('admin/metronic/po_product_linesheet_multisearch_view');
                                ?>
                            </div>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
