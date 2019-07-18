						<?php
						/**********
						 * Breadcrumbs Row Section
						 *
						 */
						if (
							$this->uri->uri_string() !== '' AND
							$file !== 'cart_basket'
						): ?>
						
						<?php
						/**********
						 * This DIV holds a height that helps in ensuring a space for the sesarch input
						 * on mobile devices....
						 */
						?>
						<div class="hidden-on-desktop" style="height:35px;">&nbsp;</div>
					
						<div id="breadcrumbs" class="breadcrumbs clearfix" data-source="v-content-breadcrumbs">
							<ul class="clearfix">
								<li class="first">
									<a href="<?php echo site_url(); ?>">
										<span class="txt">Home</span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
								
								<?php
								/**********
								 * Pages
								 */
								?>
								<?php if (@$file == 'page'): ?>
								
								<li>
									<h1 class="cuurent"><?php echo $page_title; ?></h1>
								</li>
								
								<?php
								/**********
								 * Product Thumbs
								 */
								?>
								<?php elseif ($file == 'product_thumbs_new' OR $file == 'product_thumbs_faceted'): ?>
								
									<?php if ($this->webspace_details->options['site_type'] === 'hub_site' AND @$left_nav == 'sidebar_browse_by_designer'): ?>
									
								<li>
									<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/designers/').$d_url_structure); ?>">
										<span class="txt"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $d_url_structure)); ?></span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
									
									<?php endif; ?>
									
								<li>
									<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$c_url_structure); ?>">
										<span class="txt"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $c_url_structure)); ?></span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
								<li>
									<h1 class="current"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $sc_url_structure)); ?></h1>
								</li>
								
								<?php
								/**********
								 * Product Details
								 */
								?>
								<?php elseif ($file == 'product_detail' OR $file == 'product_detail_order' OR $file == 'product_detail_inquiry'): ?>
								
									<?php if ($this->webspace_details->options['site_type'] === 'hub_site'): ?>
									
								<li>
									<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/designers/').$this->product_details->d_url_structure); ?>">
										<span class="txt"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $this->product_details->d_url_structure)); ?></span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
									
									<?php endif; ?>
									
								<li>
									<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/designers/').$this->product_details->d_url_structure); ?>">
										<span class="txt"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $this->product_details->c_url_structure)); ?></span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
								<li>
									<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$this->product_details->d_url_structure.'/'.$this->product_details->c_url_structure.'/'.$this->product_details->sc_url_structure); ?>">
										<span class="txt"><?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $this->product_details->sc_url_structure)); ?></span>
									</a>
									<span class="ico">&raquo;</span>
								</li>
								<li>
										<span class="txt">
											<?php echo $this->product_details->prod_no; ?>
										</span>
									<span class="ico">&raquo;</span>
								</li>
								<li>
										<span class="txt">
											<?php echo $this->product_details->color_name; ?>
										</span>
									<span class="ico">&raquo;</span>
								</li>
								<li>
									<h1 class="current"><?php echo $this->product_details->prod_name; ?></h1>
								</li>
								
								<?php endif; ?>
								
							</ul>
						</div>
						
						<?php endif; ?>
						
					</div><!-- end HEADER -->
