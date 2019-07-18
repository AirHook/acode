
		<ul class="screenreaderonly">
			<li><a href="<?php echo site_url('accessibility'); ?>" accesskey="0">Accessibility Information</a></li>
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
					 * Hambutger Menu Icon
					 * For mobile browsing
					 */
					?>
					<li class="primary-nav-control narrow-this" data-nav-control=''>
						<a href="#" class="icon icon--hamburger fa fa-bars">
							<span class="text">Open Navigation</span>
						</a>
					</li>
					<!--
					<li class="store-locations">
						<a href="<?php echo site_url(); ?>" class="icon icon--location-marker">
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
						<a href="<?php echo site_url(); ?>" accesskey="1">
						
							<?php if (isset($this->designers_ary) && in_array($this->uri->segment(1), $this->designers_ary)): ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->uri->segment(1); ?>.png" width="100%" height="100%" />
							
							<?php elseif ($this->webspace_details->slug === 'instylenewyork'): ?>
							
							<div class="logo_slider hidden">
								<ul>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-instylenewyork.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basix-black-label.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basixbridal.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basixprom.png" width="100%" height="100%" />
									</li>
								</ul>
							</div>
							
							<?php elseif ($this->webspace_details->slug === 'shop7thavenue'): ?>
							
							<div class="logo_slider hidden">
								<ul>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-shop7thavenue.png" width="100%" height="100%" />
									</li>
									
									<?php if ($designers): ?>
									
										<?php foreach ($designers as $designer): ?>
									
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/<?php echo $designer->logo_image; ?>" width="100%" height="100%" />
									</li>
									
										<?php endforeach; ?>
									
									<?php endif; ?>
									
								</ul>
							</div>
							
							<?php else: ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->config->item('site_slug'); ?>.png" width="100%" height="100%" onerror="$(this).attr('src', '<?php echo base_url(); ?>assets/themes/roden2/images/logo-instylenewyork.png');" />
							
							<?php endif; ?>
							
						</a>
					</li>

					<?php
					/*****
					 * Hide SEARCH by STYLE on resource login
					 */
					?>
					<?php if ($this->uri->segment(1) !== 'resource') { ?>
					
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
					<li class="search-control hidden-on-mobile">
						<div class="search-control__wrap">
								<span class="icon  icon--search fa fa-search" onclick="document.getElementById('vSearch_basicSearchForm_form_1').submit();" style="cursor:pointer;"></span>
								
								<span class="text" style="margin-right: 10px;">
								
								<!-- bof ============================================================-->
								<form action="<?php echo site_url('search'); ?>" method="POST" id="vSearch_basicSearchForm_form_1" name="vSearch_basicSearchForm_form_1">
								
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									
									<input type="hidden" name="search" value="TRUE" />
									<input type="hidden" name="c_url_structure" value="<?php echo isset($c_url_structure) ? $c_url_structure : 'apparel'; ?>" />
									<input type="hidden" name="sc_url_structure" value="<?php echo isset($sc_url_structure) ? $sc_url_structure : ''; ?>" />

									<input type="text" class="input-text" id="search_by_style" id="vSearch-basicSearchForm-searchString-1" name="style_no" placeholder="Search" style="text-transform:uppercase;vertical-align:baseline;"/>
									
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
								<form action="<?php echo site_url('search'); ?>" method="POST" id="vSearch_basicSearchForm_form_1" name="vSearch_basicSearchForm_form_1">
								
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									
									<input type="hidden" name="fuseaction" value="search.results" />
									
									<input type="hidden" name="search" value="TRUE" />
									<input type="hidden" name="c_url_structure" value="<?php echo isset($c_url_structure) ? $c_url_structure : 'apparel'; ?>" />
									<input type="hidden" name="sc_url_structure" value="<?php echo isset($sc_url_structure) ? $sc_url_structure : ''; ?>" />

									<label for="vSearch-basicSearchForm-searchString-1">Search</label>
									<input type="text" class="input-text" id="search_by_style_mobile_nav__" id="vSearch-basicSearchForm-searchString-1" name="style_no" placeholder="Search" style="text-transform:uppercase;"/>
									
									<button type="submit" class="input-submit visually-hidden">Search</button>
								<?php echo form_close(); ?>
								<!-- eof ============================================================-->
							</div>

						</div>
					</li>
					
						<?php if (
							$this->webspace_details->slug === 'instylenewyork'
							OR $this->webspace_details->slug === 'shop7thavenue'
						) { ?>
						
					<?php
					/*****
					 * CART
					 */
					?>
					<li class="cart narrow-this">
						<a href="<?php echo site_url('cart'); ?>" accesskey="Y" class="icon icon--cart fa fa-shopping-bag ">
							<span class="text">Shopping Cart:</span>
							<span class="count"><?php echo $this->cart->total_items() ?: '0'; ?></span>
						</a>
					</li>
					
						<?php } ?>
					
					<!--
					<li class="account">
						<a href="<?php echo site_url(); ?>">
							Account
							
						</a>
					</li>
					-->
					
						<?php if ( ! $this->session->userdata('user_loggedin') OR $this->session->userdata('user_cat') != 'wholesale') { ?>
					
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
					
						<?php } ?>
					
					<?php } ?>
					
					<?php
					/*****
					 * Hiding Retailer Login on some sites
					 */
					if (
						$this->webspace_details->slug === 'basixbridal' 
						OR $this->webspace_details->slug === 'basixprom' 
						OR $this->uri->segment(1) === 'resource'
					)
					{
						$display_none = 'style="display:none;"';
					}
					else $display_none = '';
					?>
					
					<li class="store-locations-desktop narrow-this" <?php echo $display_none; ?>>
					
						<?php if ($this->session->userdata('user_loggedin') && $this->session->userdata('user_cat') == 'wholesale'): ?>
						
						<a href="<?php echo site_url('wholesale/details'); ?>">
							<span class="text">Welcome, <?php echo $this->wholesale_user_details->fname; ?>!</span>
						</a>
						
						&nbsp; | &nbsp; 
						
						<a href="<?php echo site_url('wholesale/logout'); ?>" accesskey="L">
							<span class="text">Logout</span>
						</a>
						
						<?php else: ?>
						
							<?php if ($this->uri->segment(1) === 'special_sale'): ?>
					
						<span class="text" style="color:transparent;">Retailer Login</span>
					
							<?php else: ?>
						
						<a href="<?php echo site_url('wholesale/signin'); ?>">
							<span class="text">Retailer Login</span>
						</a>
					
							<?php endif; ?>
					
						<?php endif; ?>
						
					</li>
					
					<?php
					/*****
					 * Logo
					 */
					?>
					<li class="logo hidden-on-mobile">
						<a href="<?php echo site_url(); ?>" accesskey="1">
							
							<?php if (isset($this->designers_ary) && in_array($this->uri->segment(1), $this->designers_ary)): ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->uri->segment(1); ?>.png" width="100%" height="100%" />
							
							<?php elseif ($this->webspace_details->slug === 'instylenewyork' && $this->uri->segment(1) !== 'resource'): ?>
							
							<div class="logo_slider hidden">
								<ul>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-instylenewyork.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basix-black-label.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basixbridal.png" width="100%" height="100%" />
									</li>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-basixprom.png" width="100%" height="100%" />
									</li>
								</ul>
							</div>
							
							<?php elseif ($this->webspace_details->slug === 'shop7thavenue' && $this->uri->segment(1) !== 'resource'): ?>
							
							<div class="logo_slider hidden">
								<ul>
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-shop7thavenue.png" width="100%" height="100%" />
									</li>
									
									<?php if ($designers): ?>
									
										<?php foreach ($designers as $designer): ?>
										
									<li>
										<img src="<?php echo base_url(); ?>assets/themes/roden2/images/<?php echo $designer->logo_image; ?>" width="100%" height="100%" onerror="$(this).closest('li').hide();" />
									</li>
									
										<?php endforeach; ?>
									
									<?php endif; ?>
									
								</ul>
							</div>
							
							<?php else: ?>
							
							<img src="<?php echo base_url(); ?>assets/themes/roden2/images/logo-<?php echo $this->webspace_details->slug ?: $this->config->item('site_slug'); ?>.png" width="100%" height="100%" onerror="$(this).attr('src', '<?php echo base_url(); ?>assets/themes/roden2/images/logo-instylenewyork.png');" />
							
							<?php endif; ?>
							
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
					//$this->load->view('roden2/template_header_'.$this->webspace_details->slug);
					$this->load->view('roden2/template_header_navigation');
					?>