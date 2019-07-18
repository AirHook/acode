                    <!-- BEGIN PAGE CONTENT BODY -->
					
					<?php $this->load->view('metronic/sales/steps_wizard'); ?>
					
                    <div class="note note-success">
                        <h3>Sales <?php echo $linesheet_sending_only ? 'Linesheet' : 'Package'; ?> Sent</h3>
						<?php if ($linesheet_sending_only) { ?>
                        <p> Sales Linesheet successfully sent. Your linesheet selection has now been cleared. You may select new items again. </p>
                        <p> Select categories here...
                            <a class="btn red btn-outline" href="<?php echo site_url('sales/dashboard'); ?>" target="">Categories</a>
                        </p>
						<?php } else { ?>
                        <p> Your sales package was successfully sent. You may now send another sales package or just send linesheets only. </p>
                        <p> Choose what to do next...
                            <a class="btn red btn-outline" href="<?php echo site_url('sales/dashboard'); ?>" target="">Back to Dashboard</a>
							<?php if ($this->sales_user_details->access_level == '2') { ?>
                            <a class="btn red btn-outline" href="<?php echo site_url('sales/sales_package'); ?>" target="">Create a new Sales Package</a>
                            <a class="btn red btn-outline" href="<?php echo site_url('sales/sales_package'); ?>" target="">Select another saved Sales Package</a>
							<?php } ?>
                        </p>
						<?php } ?>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
