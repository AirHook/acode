                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('metronic/sales/po_steps_wizard'); ?>

                        <?php
                        /***********
                         * Noification area
                         */
                        ?>
                        <div class="notifcations">
                            <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                            <div class="alert alert-danger ">
                                <button class="close" data-close="alert"></button> An error occured. Please try again.
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success') == 'item_added') { ?>
                            <div class="alert alert-success ">
                                <button class="close" data-close="alert"></button> Success. Item added.
                            </div>
                            <?php } ?>
                        </div>

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
                            &nbsp; OR... <i class="fa fa-long-arrow-right"></i>
                            <a href="#modal-unlisted_style_no" data-toggle="modal" class="btn grey btn-sm">
                                <span style="color:red;">CLICK</span> HERE TO ADD STYLE NUMBERS NOT IN THE LIST
                            </a>
						</p>

                        <div class="row margin-bottom-30">

                            <?php
                            $this->load->view('metronic/sales/po_products_grid');
                            ?>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
