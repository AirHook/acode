
						<?php
						/**********
						 * All these items are regarding SALES PROGRAM.
						 */
						?>
						<?php if ($this->session->userdata('admin_sales_loggedin')) { ?>
				
						<div class="top-banner center" style="background:pink;padding:20px;">
							<h1>You are currently working on sales program.</h1>
						</div>
						
							<?php
							/**********
							 * SALES PROGRAM menu items
							 */
							?>
						<div class="center" style="background:#e6f2ff;padding:20px;">
							<style>
							.sa-menu-active { 
								text-decoration: underline; 
							}
							</style>
							<h1>
							
								<a class="sa-menu <?php echo ($this->uri->uri_string() == 'sa' OR $this->uri->uri_string() == 'sa/dashboard') ? 'sa-menu-active' : ''; ?>" href="<?php echo site_url('sales/dashboard'); ?>">
									Dashboard</a>
									
							<?php if ($is_with_products) { ?>
									
								<?php if ($this->sales_user_details->access_level == '0' OR $this->sales_user_details->access_level == '2') { ?>
								
								&nbsp; | &nbsp;

								<a class="sa-menu" href="javascript:;" onclick="$('#modal-create_sales_package').show();">
									Create Sales Package</a>
									
								<?php } ?>
								
								<?php if ($this->sales_user_details->access_level == '0' OR $this->sales_user_details->access_level == '1' OR $this->sales_user_details->access_level == '2') { ?>
								
								&nbsp; | &nbsp;

								<a class="sa-menu" href="<?php echo site_url('sales/linesheet'); ?>">
									Send Linesheets Only</a>
								
								<?php } ?>
								
							<?php } ?>
								
							</h1>
						</div>
						
						<?php } ?>
						
						<br />