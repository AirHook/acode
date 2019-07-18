
						<?php if ($this->config->item('site_slug') === 'instylenewyork') { ?>
						
							<?php
							/**********
							 * All these items are regarding SPECIAL SALE. Since as of 20170128
							 * SPECIAL SALE is now part of normal website pages, we are not gonna
							 * show these benner notices anymore...
							 */
							?>
							<?php if ($this->session->flashdata('special_sale_epxiry_notice__')) { ?>
					
						<div class="center" style="background:pink;padding:20px;">
							<h1>
								We're sorry but the link you are accessing is no longer available.
							</h1>
						</div>
						
							<?php } ?>
						
							<?php if ($this->session->flashdata('special_sale_send_back__')) { ?>
					
						<div class="center" style="background:#e6f2ff;padding:20px;">
							<h1>
								You are currently in a special sale loop.<br />
								To leave loop will end your session.<br />
								You can always come back as long as your access link is still available.<br /><br />
								Click <a href="<?php echo site_url('special_sale/leave'); ?>">here</a> to leave special sale.
							</h1>
						</div>
						
							<?php } ?>
						
							<?php 
							if ($this->uri->uri_string() === 'special_sale/apparel__' AND ! $this->session->flashdata('special_sale_send_back__')) { 
							?>
					
						<div class="center" style="background:#e6f2ff;padding:20px;">
							<h1 style="color:red;">
								Welcome to the Special Sale.<br />
								Click on any category to save 50% or more on select items.<br /><br />
								All items are subject to availability verification.<br /><br />
								Your card will not be charged until we ship your order.
							</h1>
						</div>
						
							<?php } ?>
					
						<?php } else { ?>

							<?php if ($this->session->flashdata('special_sale_epxiry_notice__')) { ?>
					
						<div class="center" style="background:pink;padding:20px;">
							<h1 <?php echo $this->config->item('site_slug') == 'basixbridal' ? 'style="color:#846921;"' : '';?>>
								We're sorry but the link you are accessing is not available.<br />
								Please browse our products here.
							</h1>
						</div>
						
							<?php } ?>
					
						<?php } ?>
						
					<?php
					/**********
					 * Sales package unsuccesful notices
					 */
					?>
						<?php if ($this->session->flashdata('no_sales_package')) { ?>
				
						<div class="center" style="background:pink;padding:20px;margin-bottom:20px;">
							<h1 <?php echo $this->config->item('site_slug') == 'basixbridal' ? 'style="color:#846921;"' : '';?>>
								Ooops... The page you are accessing is not available.<br />
								Please browse our products here.
							</h1>
						</div>
						
						<?php } ?>
				
						<?php if ($this->session->flashdata('sales_package_expired')) { ?>
				
						<div class="center" style="background:pink;padding:20px;margin-bottom:20px;">
							<h1 <?php echo $this->config->item('site_slug') == 'basixbridal' ? 'style="color:#846921;"' : '';?>>
								We're sorry but the link you are accessing is not available.<br />
								Please browse our products here.
							</h1>
						</div>
						
						<?php } ?>
				
						<?php if ($this->session->flashdata('sales_package_invalid_credentials')) { ?>
				
						<div class="center" style="background:pink;padding:20px;margin-bottom:20px;">
							<h1 <?php echo $this->config->item('site_slug') == 'basixbridal' ? 'style="color:#846921;"' : '';?>>
								We're sorry but you are not authorized to access the link.<br />
								Please signin, or, browse our products <a href="<?php echo site_url('shop/categories'); ?>">here</a>.
							</h1>
						</div>
						
						<?php } ?>
					
						<?php
						/**********
						 * At the sales package thumbs page
						 */
						?>
						<?php if (
								@$view_pane === 'thumbs_list_sales_pacakge' 
								&& $this->session->userdata('sales_package')
								&& $this->session->userdata('sales_package_tc')
								&& $this->session->userdata('sales_package_id')
							) { ?>
				
						<div class="center" style="background:#e6f2ff;padding:20px;margin-bottom:20px;">
							<h1>
								Hi <?php echo @$this->wholesale_user_details->fname; ?><br />
								Welcome to your sales pacakge with several new designs for your review.<br />
								Please respond with items of interest for your stores.
							</h1>
						</div>
						
						<?php } elseif (
							$this->session->userdata('wholesale_user_loggedin')
							&& $this->session->userdata('sales_package')
							&& $this->session->userdata('sales_package_tc')
							&& $this->session->userdata('sales_package_id')
						) { ?>
						
						<div class="center" style="background:#e6f2ff;padding:20px;margin-bottom:20px;">
							<h1>
								Click <a href="<?php echo site_url('sales_package/link/'.$this->session->userdata('sales_package_id').'/'.$this->session->userdata('user_id').'/'.$this->session->userdata('sales_package_tc')); ?>">here</a> to view your sales package.
							</h1>
						</div>
						
						<?php } ?>
						
