
		<ul class="screenreaderonly">
			<li><a href="<?php echo str_replace('https', 'http', site_url('accessibility')); ?>" accesskey="0">Accessibility Information</a></li>
			<li><a href="#content" accesskey="S">Skip To Main Content</a></li>
			<li><a href="#nav-primary" accesskey="M">Skip To Main Navigation</a></li>
			<?php if ($file == 'product_thumbs'): ?>
			<li><a href="#aside" accesskey="N">Skip To Secondary Navigation</a></li>
			<?php endif; ?>
		</ul>

		<div class="header-bg-wrap fixedsticky">
			<header>
				<ul class="utility">
				
					<?php
					/*****
					 * Hamburger Menu Icon
					 * For mobile browsing
					<li class="primary-nav-control narrow-this" data-nav-control=''>
						<a href="#" class="icon icon--hamburger fa fa-bars">
							<span class="text">Open Navigation</span>
						</a>
					</li>
					 */
					?>
					<!--
					<li class="store-locations">
						<a href="<?php echo str_replace('https', 'http', site_url()); ?>" class="icon icon--location-marker">
							<span class="text">Stores</span>
						</a>
					</li>
					-->
					
					<?php
					/*****
					 * Logo
					 */
					?>
					<li class="logo logo-mobile hidden-on-desktop narrow-this">
						<a href="<?php echo str_replace('https', 'http', site_url()); ?>" accesskey="1">
						
							<?php if (isset($this->designers_ary) && in_array($this->uri->segment(1), $this->designers_ary)): ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->uri->segment(1); ?>.png" width="100%" height="100%" />
							
							<?php elseif ($this->webspace_details->slug === 'instylenewyork'): ?>
							
							<div class="logo_slider hidden">
								<ul>

									<?php if ($this->sales_user_details->designer !== $this->webspace_details->slug) { ?>
								
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->sales_user_details->designer; ?>.png" width="100%" height="100%" />
									</li>
									
									<?php } else { ?>
							
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-instylenewyork.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basix-black-label.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-junnieleigh.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-chaarmfurs.png" width="100%" height="100%" />
									</li>
									
									<?php } ?>
									
								</ul>
							</div>
							
							<?php elseif ($this->webspace_details->slug === 'shop7thavenue'): ?>
							
							<div class="logo_slider hidden">
								<ul>
								
									<?php if ($this->sales_user_details->designer !== $this->webspace_details->slug) { ?>
								
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->sales_user_details->designer; ?>.png" width="100%" height="100%" />
									</li>
									
									<?php } else { ?>
							
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-shop7thavenue.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-storybookknits.png" width="100%" height="100%" />
									</li>
									
									<?php } ?>
									
								</ul>
							</div>
							
							<?php else: ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->webspace_details->slug; ?>.png" width="100%" height="100%" />
							
							<?php endif; ?>
							
						</a>
					</li>

					<?php
					/*****
					 * Search By Style#
					 * employing two type of search so we hide one from desktop
					 * and the other from mobile
					 */
					?>
					<?php
					/*****
					 * DESKTOP search
					 */
					?>
					<!-- DOC: adding inline style to correct position with the lib-min.js hidden (bottom section scrip loading) -->
					<li class="search-control hidden-on-mobile" style="padding: 2px 10px 12px;">
						<div class="search-control__wrap">
								<span class="icon  icon--search fa fa-search" onclick="document.getElementById('vSearch_basicSearchForm_form_1').submit();" style="cursor:pointer;"></span>
								
								<span class="text" style="margin-right: 10px;">
								
								<!-- bof ============================================================-->
								<form action="<?php echo str_replace('https', 'http', site_url('sales/search_products')); ?>" method="POST" id="vSearch_basicSearchForm_form_1" name="vSearch_basicSearchForm_form_1">
								
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									
									<input type="text" class="input-text search_by_prod_no" id="search_by_style" id="vSearch-basicSearchForm-searchString-1" name="style_no" placeholder="Search By Style#" style="text-transform:uppercase;" />
									
									<button type="submit" class="input-submit visually-hidden">Search</button>
								<?php echo form_close(); ?>
								<!-- eof ============================================================-->
								
								</span>
						</div>
					</li>
					
					<?php
					/*****
					 * MOBILE search
					 */
					?>
					<li class="search-control mobile hidden-on-desktop hidden-on-tablet narrow-this">
						<div class="search-control__wrap hidden">
							<a href="#" class="search-control__link">
								<span class="icon  icon--search fa fa-search"></span>
								<span class="text  js-search-control">Search</span>
							</a>
						</div>
						<div class="search-wrap is-visible">
                        
							<div class="v-search-basicsearchform">
								<!-- bof ============================================================-->
								<form action="<?php echo str_replace('https', 'http', site_url('sales/search_products')); ?>" method="POST" id="vSearch_basicSearchForm_form_1" name="vSearch_basicSearchForm_form_1">
								
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									
									<label for="vSearch-basicSearchForm-searchString-1">Search</label>
									<input type="text" class="input-text search_by_prod_no" id="search_by_style_mobile_nav__" required="required" id="vSearch-basicSearchForm-searchString-1" name="style_no" placeholder="Search By Style#" style="text-transform:uppercase;"/>
									
									<button type="submit" class="input-submit visually-hidden">Search</button>
								<?php echo form_close(); ?>
								<!-- eof ============================================================-->
							</div>

						</div>
					</li>

					<?php if ($this->webspace_details->slug === 'instylenewyork'): ?>
					
					<?php
					/*****
					 * CART
					 */
					?>
					<li class="cart narrow-this" id="sa_cart_top_right_link">
						<a href="javascript:void();" onclick="return check_cart();" class="icon icon--cart fa fa-shopping-bag ">
							<span class="text">Shopping Cart:</span>
							<span class="count"><?php echo $this->cart->total_items() ?: '0'; ?></span>
						</a>
					</li>
					
					<?php endif; ?>
					
					<?php if ( ! $this->session->userdata('admin_sales_loggedin')): ?>
					
						<?php if ( ! $this->session->userdata('user_loggedin') OR $this->session->userdata('user_cat') != 'wholesale'): ?>
					
					<li class="instagram hide-on-mobile narrow-this">
					
							<?php if ($this->webspace_details->slug === 'basixbridal'): ?>
						
						<a href="https://www.instagram.com/<?php echo $this->webspace_details->slug === 'basixbridal' ? 'basixbridal' : ''; ?>/" class="icon fa fa-instagram" target="_blank" disabled>
							<span class="text">Instagram</span>
						</a>
						
							<?php else: ?>
						
						<span class="text icon fa fa-instagram">Instagram</span>
						
							<?php endif; ?>
						
					</li>
					<li class="pinterest hide-on-mobile narrow-this">
						<span class="text icon fa fa-pinterest-square">Pinterest</span>
					</li>
					<li class="youtube hide-on-mobile narrow-this">
						<span class="text icon fa fa-youtube-play">Pinterest</span>
					</li>
					
						<?php endif; ?>
					
						<?php
						/*****
						 * Hding Retailer Login on some sites
						 */
						if (
							$this->webspace_details->slug === 'basixbridal' 
							OR $this->webspace_details->slug === 'basixprom' 
						)
						{
							$display_none = 'style="display:none;"';
						}
						else $display_none = '';
						?>
					
					<li class="store-locations-desktop narrow-this" <?php echo $display_none; ?>>
							
							<?php if ($this->session->userdata('admin_sales_loggedin')): ?>
							
						<span class="text">Welcome, <?php echo $this->sales_user_details->fname.' '.$this->sales_user_details->lname; ?>!</span>
						
						&nbsp; | &nbsp; 
						
						<a href="<?php echo site_url('sales/logout'); ?>" accesskey="L">
							<span class="text">Logout</span>
						</a>
						
							<?php endif; ?>
					
							<?php if ($this->session->userdata('user_loggedin') && $this->session->userdata('user_cat') == 'wholesale'): ?>
						
						<a href="<?php echo str_replace('https', 'http', site_url('wholesale/details')); ?>">
							<span class="text">Welcome, <?php echo $this->session->userdata('user_firstname'); ?>!</span>
						</a>
						
						&nbsp; | &nbsp; 
						
						<a href="<?php echo str_replace('https', 'http', site_url('wholesale/logout')); ?>" accesskey="L">
							<span class="text">Logout</span>
						</a>
						
							<?php else: ?>
							
								<?php if ($this->uri->segment(1) === 'special_sale'): ?>
						
						<span class="text" style="color:transparent;">Retailer Login</span>
					
								<?php else: ?>
						
						<a href="<?php echo str_replace('https', 'http', site_url('wholesale/signin')); ?>">
							<span class="text">Retailer Login</span>
						</a>
					
								<?php endif; ?>
						
							<?php endif; ?>
						
					</li>
					
					<?php else: ?>
					
					<li class="store-locations-desktop narrow-this">
							
						<span class="text">Welcome, <?php echo $this->sales_user_details->fname.' '.$this->sales_user_details->lname; ?>!</span>
						
						&nbsp; | &nbsp; 
						
						<a href="<?php echo site_url('sales/logout'); ?>" accesskey="L">
							<span class="text">Logout</span>
						</a>
					
					</li>
					
					<?php endif; ?>
					
					<?php
					/*****
					 * Logo DESKTOP
					 */
					?>
					<li class="logo hidden-on-mobile">
						<a href="<?php echo str_replace('https', 'http', site_url()); ?>" accesskey="1">
							
							<?php
							/*****
							 * 1.0 	Using source logo
							 * 2.0 	Reserving a multi-designer logo slider for when sales user is from hub site
							 *		like instyle or shop7th
							 *
							 * NOTE: 	This file is shown only when at sales program including the login page
							 *			Focus is done on this consideration.
							 */
							?>
							<div class="logo_slider hidden">
								<ul>
								
									<?php if ($this->sales_user_details->designer !== $this->webspace_details->slug) { ?>
								
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->sales_user_details->designer; ?>.png" width="100%" height="100%" />
									</li>
									
									<?php } else { ?>
									
									<li class="instylenewyork">
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->webspace_details->slug ?: $this->config->item('site_slug'); ?>.png" width="100%" height="100%" />
									</li>
									
										<?php foreach ($designer_list as $designer) { ?>
										
									<li class="instylenewyork">
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $designer->url_structure; ?>.png" width="100%" height="100%" />
									</li>
									
										<?php } ?>
									
									<?php } ?>
								
								</ul>
							</div>
							
						</a>
					</li>

					
				</ul>
			</header>
		</div>
		<!-- header-bg-wrap -->
		
		
		<div id="wrap" class="wrap">
			<div id="wrap-bg2" class="wrap--internal">
			
				<div id="wrap-content" class="clearfix">

					<?php
					// instead of loading the usual main menu file, we go straight
					// to the banner part to show the user he is in admin sales pages
					//$this->load->view(THEME_FOLDER.'template_header_'.$this->config->item('site_slug'));
					$this->load->view('roden2/sales/template_header_banner_part');
					?>