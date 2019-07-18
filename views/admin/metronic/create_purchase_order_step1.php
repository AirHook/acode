                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('admin/metronic/po_steps_wizard'); ?>

                        <p style="color:red;">
							Select a vendor for your Purchase Order.
						</p>

                        <div class="row margin-bottom-30">

                            <?php
                            $this->load->view('admin/metronic/po_select_vendor');
                            ?>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
