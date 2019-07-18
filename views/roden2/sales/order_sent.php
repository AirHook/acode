					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-cart-viewtemplate wl-grid">
							
								<?php
								/**********
								 * Right side column
								 * Top Box
								 * ORDER SUMMARY
								 */
								?>
								<div class="order-summary col col-4of12">
            
									<div class="section order-summary__detail clearfix">
									
										<div class="actionlist clearfix">
											<ul class="actions clearfix" style="text-align:center;">
												<!-- Series of Update Price Button -->
												<div id="upd_price_btn_1">
													<button class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" type="button" name="upd_price_btn" onclick="window.location.href='<?php echo site_url('sa/apparel'); ?>';">
														Select items again
													</button>
												</div>
											</ul>
										</div>
										
									</div>
            
								</div>
								<!-- .order-summary -->
								
								<?php
								/**********
								 * Left side column
								 * Topo Box
								 * CART DETAILS
								 */
								?>
								<div class="cart-detail col col-7of12">
            
									<div class="v-cart-cartdetail">

										<div class="section cart clearfix">
										
											<?php if ($this->session->flashdata('flashRegMsg')): ?>
											
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
												<?php echo $this->session->flashdata('flashRegMsg'); ?>
											</div>
											
											<?php endif; ?>
											
											<div style="padding:30px 20px;margin-bottom:30px;border:1px solid #dcdcdc;font-style:italic;">
												THANK YOU!
												<br /><br />
												<?php if($this->session->userdata('access_level') != '1'): ?>
												Your linesheets has been sent to your email address.
												<?php else: ?>
												Sales package sent!
												<?php endif; ?>
												<br />
											</div>
										
										</div>

										<?php
										/**********
										 * Source has a second box at left side
										 * Intended for Save For Later items
										 * Adding a wrapping div to hide the section
										 
										<div class="hidden"><!-- added wrapping div -->
										<div class="section saved clearfix">
											<h2 class='section-heading'>Saved For Later</h2>
											<div class="saved-items  product-line-item  product-line-item--empty">
												<p class="product-line-item__empty-text">You have not saved anything for later yet</p>
											</div>
										</div>
										<div class="section saved clearfix">
										</div>
										</div>
										 */
										?>

									</div>
								</div>
								<!-- .cart-detail -->

							</div>
							<!-- .wl-grid -->
	
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->
