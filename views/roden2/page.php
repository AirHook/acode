					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content with-side-container clearfix">
					
						<div id="main" class="content-grid  clearfix" role="main">
						
							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary">
										<li class="nav-item">
											<a name="#">Customer Services</a>
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'ordering' OR $this->uri->uri_string() === 'special_sale/ordering') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('ordering'); ?>">Ordering </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'shipping' OR $this->uri->uri_string() === 'special_sale/shipping') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('shipping'); ?>">Shipping </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'return_policy' OR $this->uri->uri_string() === 'special_sale/return_policy') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('return_policy'); ?>">Returns </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'privacy_notice' OR $this->uri->uri_string() === 'special_sale/privacy_notice') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('privacy_notice'); ?>">Privacy </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'faq' OR $this->uri->uri_string() === 'special_sale/faq') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('faq'); ?>">FAQ </a> 
										</li>
										
										<?php if ($this->uri->segment(1) !== 'special_sale'): ?>
										
											<?php if (
												$this->config->item('site_slug') !== 'basix-black-label' 
												AND $this->config->item('site_slug') !== 'instylenewyork'
												AND $this->config->item('site_slug') !== 'tempoparis'
												AND $this->config->item('site_slug') !== 'issuenewyork'
												AND $this->config->item('site_slug') !== 'issueny'
												AND $this->config->item('site_slug') !== 'andrewoutfitter'
												AND $this->config->item('site_slug') !== 'storybookknits'
											): ?>
											
										<li class="nav-item<?php echo $this->uri->uri_string() === 'made_to_order' ? ' active current' : ''; ?>" style="display:none;">
											<a href="<?php echo site_url('made_to_order'); ?>">Made To Order </a> 
										</li>
										
											<?php endif; ?>
										
										<li class="nav-item<?php echo $this->uri->uri_string() === 'events' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('events'); ?>">Events </a> 
										</li>
										
											<?php if ($this->config->item('site_slug') !== 'tempoparis'): ?>
											
										<li class="nav-item<?php echo $this->uri->uri_string() === 'press' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('press'); ?>">Press </a> 
										</li>
										
											<?php endif; ?>
										
										<?php endif; ?>
										
										<?php if (
											$this->config->item('site_slug') !== 'issuenewyork' 
											AND $this->config->item('site_slug') !== 'issueny'
											AND $this->config->item('site_slug') !== 'andrewoutfitter'
											AND $this->config->item('site_slug') !== 'storybookknits'
											AND $this->config->item('site_domain') !== 'www.tempoparis.net'
										) { ?>
										
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'terms_of_use' OR $this->uri->uri_string() === 'special_sale/terms_of_use') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('terms_of_use'); ?>">Terms Of Use </a> 
										</li>
										
										<?php } ?>
										
										<li class="nav-item<?php echo $this->uri->uri_string() === 'sitemap' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('sitemap'); ?>">Sitemap </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'contact' OR $this->uri->uri_string() === 'special_sale/contact') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('contact'); ?>">Contact </a> 
										</li>
									</ul>
								</div>
                            </div><!-- end ASIDE -->
							
							<?php
							/**********
							 * Right side content
							 */
							?>
                            <div class="wl-grid">
                                <div class="col col-12of12">
									<div class="ct ct-body clearfix">

										<?php if ($page == '') { ?>
										
										<h3><?php echo strtoupper($page_title); ?></h3>
										<div class="page-text-body">
											<?php echo @$page_text; ?>
										</div>
										
										<?php } elseif ($page == 'events') { ?>
										
											<h3><?php echo strtoupper($page_title); ?></h3>
											<p>
												<?php echo $this->webspace_details->name; ?> is present in many global trade shows and fashion venues. See schedule below.
											</p>
											<hr />
											
											<?php if ($view_events): ?>

												<table cellpadding="0" cellspacing="0" border="0">
													
													<?php foreach ($view_events as $event): ?>

													<tr>
														<td style="padding:30px 0;">
															<?php echo nl2br(strip_tags($event->n_text)); ?><br />
														</td>
													</tr>
														
													<?php endforeach; ?>
														
												</table>
											
											<?php else: ?>

												<p style="text-transform:uppercase;font-size:1.15em;margin:50px 0;">
													There are currently no scheduled events for <?php echo $this->webspace_details->name; ?>.
												</p>
												
											<?php endif; ?>

										<?php } elseif ($page == 'press') { ?>
										
											<h3><?php echo strtoupper($page_title); ?></h3>
											<p>
												<div align="left" style="font-size:14px;">CLICK ANY COVER TO VIEW ARTICLE</div>
												<br />
												<div align="left">
													For press inquiries, please email <a href="mailto:<?php echo $this->webspace_details->info_email; ?>"><?php echo $this->webspace_details->info_email; ?></a>.
												</div>
											</p>
											
											<div class="wl-grid">
											
											<?php
											if ($presses):
											
												foreach ($presses as $rows): ?>

													<div class="wl-grid col sm-col-6of12 col-3of12">
														<a class="press_group_1" href="<?php echo base_url(); ?>images/press/press_1/<?php echo $rows->img_1; ?>" title="<?php echo $rows->title; ?>">
															<img alt="<?php echo $rows->title; ?>" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/press/press_cover/thumb/<?php echo $rows->cover_img; ?>" style="border:1px solid #666666;" />
														</a>
														<p><?php echo $rows->title; ?></p>
													</div>
												
												<?php endforeach; ?>
												
											<?php endif; ?>
											
											</div>

										<?php } elseif ($page == 'how_to_oder') 
										{
											$this->load->view($this->webspace_details->options['theme'].'/'.$page);
											//$this->load->view($this->config->slash_item('template').$page);
										} 
										else 
										{
											$this->load->view($this->webspace_details->options['theme'].'/'.$page);
											//$this->load->view($this->config->slash_item('template').$page);
										} ?>
										
									</div><!-- end CT BODY -->
                                </div> 
                            </div> 
							<!-- .wl-grid -->
                        
						</div><!-- end MAIN -->
					
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->

