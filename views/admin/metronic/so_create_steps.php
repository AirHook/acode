                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('admin/metronic/so_steps_wizard'); ?>

                        <?php if ( ! @$search && $steps == '1')
                        { ?>
                        <p style="color:red;">
                            Select items to add to Purchase Order from thumbs, OR... <i class="fa fa-long-arrow-right"></i>
                            <a href="<?php echo site_url('sales/sales_orders/search_multiple'); ?>" class="btn dark btn-sm">
                                <span style="color:red;">CLICK</span> HERE TO SEACH MULTIPLE STYLE NUMBERS
                            </a>
						</p>
                            <?php
                        } ?>

                        <div class="row margin-bottom-30">

                            <?php
                            switch ($steps)
                            {
                                case '1':
                                    if (@$search) $this->load->view('admin/metronic/so_search_multi_products');
                                    else $this->load->view('admin/metronic/so_products_grid');
                                break;
                                case '2':
                                    $this->load->view('admin/metronic/so_summary_review');
                                break;
                            }
                            ?>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
