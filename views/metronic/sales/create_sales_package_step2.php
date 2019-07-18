                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('metronic/sales/steps_wizard'); ?>

                        <p style="color:red;">
							Choose the options for this sales package to send to recipient
						</p>

                        <div class="row margin-bottom-30">

                            <div class="col-md-12">
                            <?php
                            $this->load->view('metronic/sales/product_linesheet_summary_view');
                            ?>
                            </div>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
