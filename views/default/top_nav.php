<div id="header_wrapper">
	<div id="header">
	
		<div style="float:right;display:none;">
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Serach By Style # area
			*/
			?>
			<!--bof form==========================================================================-->
			<?php //echo form_open(str_replace('https', 'http', site_url('search_products')), array('method'=>'POST')); ?>
			<?php echo form_open('search_products', array('method'=>'POST')); ?>
			<?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'): ?>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<?php endif; ?>
			<input type="hidden" name="search" value="TRUE" />
			<input type="hidden" name="c_url_structure" value="<?php echo isset($c_url_structure) ? $c_url_structure : 'apparel'; ?>" />
			<input type="hidden" name="sc_url_structure" value="<?php echo isset($sc_url_structure) ? $sc_url_structure : ''; ?>" />
			
			<div class="search_wrapper">
				<input type="text" name="style_no" class="search_by_style" placeholder="Search" />
				<input type="image" src="<?php echo base_url(); ?>images/search-icon.png" alt="Go Icon" name="submit_search" value="SEARCH" height="15" style="position:relative;top:3px;" />
			</div>
			<?php echo form_close(); ?>
			<!--eof form==========================================================================-->
		</div>
		
		<div id="logo" style="width:295px;height:40px;top:4px;">
			<div id="logoslide" class="logo_slider">
				<!-- This Div will be for the Logo Rotator-->
				
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
				<ul>
				
					<li>
						<img src="<?php echo base_url('assets/images/logo'); ?>/logo-<?php echo $this->webspace_details->slug ?: $this->config->item('site_slug'); ?>.png" width="100%" height="100%" />
					</li>
					
					<?php if ($this->sales_user_details->designer == $this->webspace_details->slug) { ?>
					
						<?php foreach ($designer_list as $designer) { ?>
					
					<li>
						<img src="<?php echo base_url('assets/images/logo'); ?>/logo-<?php echo $designer->url_structure; ?>.png" width="100%" height="100%" />
					</li>
					
						<?php } ?>
					
					<?php } ?>
				
				</ul>
				
			</div>
		</div>
		
		<div id="mainmenu" style="display:none;">
			<?php
				/*
				|-----------------------------------------
				| RETAILER LOGIN
				*/
				if ($this->session->userdata('user_cat') == 'wholesale')
				{
					//
					//|-----------------------------------------
					//| DOWNLOAD PDF catalog
					//
					//$docs = $this->session->userdata('user_reference_designer').'/'.$this->session->userdata('user_reference_designer').'.pdf';
					//if (file_exists('docs/'.$docs))
					//{
					//	echo anchor(str_replace('https', 'http', base_url('docs/'.$docs)), 'DOWNLOAD CATALOG', 'target="_blank"');
					//}
					
					//
					//|-----------------------------------------
					//| Show login username
					//
					//echo '<a href="javascript:void();" style="">LOGGED IN AS: '.$this->session->userdata('user_firstname').'</a>';
					
					//
					//|-----------------------------------------
					//| LOGOUT - for wholesale
					//
					echo anchor(str_replace('https', 'http', site_url('sign_out')), 'LOGOUT', 'class="active"');
				}
				else
				{
					echo anchor(str_replace('https', 'http', site_url('wholesale/signin')), 'STORE LOGIN', 'class="'.($this->uri->segment(1) == 'wholesale' ? 'active' : '').'"');
				}

				/*
				|-----------------------------------------
				| REGISTER - for consumers
				*/
				if ($this->session->userdata('user_cat') != 'wholesale')
				{
					$link2 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('register') : str_replace('http','https',site_url('register'));
					echo anchor((ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing') ? site_url('register') : $link2, 'REGISTER', 'class="'.(uri_string() == 'register' ? 'active' : '').'"');
				}

				/*
				|-----------------------------------------
				| SHOPPING CART
				|
				if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
				{
					$link1 = site_url('cart');
					echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'ITEMS'),'class=""');
				}
				else
				{
					$link1 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('cart') : str_replace('http','https',site_url('cart'));
					echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'ITEMS'),'class=""');
				}
				*/
				
				/*
				|-----------------------------------------
				| LIVE CHAT
				*/
				$live_chat = 'inactive';
				if ($live_chat == 'active')
				{
					echo '<a href="javascript: void();" class="active" onclick="return win1()" style="color:white;"><img src="'.base_url().'admin/phponline/statusimage.php"></a>';
				}
			?>
			
		</div>
		
	</div> <!--eof header-->
</div> <!--eof header_wrapper-->
