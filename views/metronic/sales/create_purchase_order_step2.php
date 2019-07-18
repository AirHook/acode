                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('metronic/sales/po_steps_wizard'); ?>

                        <h2 style="color:red;">
                            VENDOR: <?php echo $vendor->vendor_name; ?>
                            <a href="#modal-change_vendor" data-toggle="modal">
                                <span style="font-size:1rem;color:initial;margin-left:10px;"> Edit/Change Vendor </span>
                            </a>
                        </h2>
                        <p style="color:red;">
                            Select items to add to Purchase Order from thumbs, OR... <i class="fa fa-long-arrow-right"></i>
                            <a href="<?php echo site_url('sales/purchase_orders/search_multiple'); ?>" class="btn dark btn-sm">
                                <span style="color:red;">CLICK</span> HERE TO SEACH MULTIPLE STYLE NUMBERS
                            </a>
						</p>

                        <div class="row margin-bottom-30">

                            <?php
                            $this->load->view('metronic/sales/po_products_grid');
                            ?>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
