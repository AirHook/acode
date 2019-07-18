                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('metronic/sales/steps_wizard'); ?>

                        <p style="color:red;">
							Add items to sales offer package by going to each subcategory and checking the items boxes to send a PRODUCT OFFER to 1 or multiple store buyers. You will receive a copy of this offer for your record.
						</p>

                        <div class="row margin-bottom-30">

                            <?php
                            $this->load->view('metronic/sales/products_grid');
                            ?>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
