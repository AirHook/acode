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
								 * Sales User Info
								 */
								?>
								<div class="order-summary col col-4of12">
            
									<?php $this->load->view('roden2/sales/my_info'); ?>
								
								</div>
								
								<?php
								/**********
								 * Left side column
								 * Top Box
								 * CART DETAILS
								 */
								?>
								<div class="cart-detail col col-7of12">
            
									<div class="v-cart-cartdetail">

										<div class="section cart clearfix">
										
											<?php
											/**********
											 * Notification area
											 */
											?>
											<div>
												<?php if ($this->session->flashdata('error') == 'no_products') { ?>
												<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
													Please note that there are currently no products available for the respective designer <?php echo $this->sales_user_details->designer_name; ?>. Other sections of this program is not available at this time. Please contact your admin about this.
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('error') == 'error_sending_package') { ?>
												<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
													There was an error sending package or linesheet. Please try again.
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('error') == 'error_creating_package') { ?>
												<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
													There was an error creating new sales package. Please try again.
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
												<div style="padding:10px 20px;background:green;margin-bottom:30px;color:red;">
													Sales package successfully sent.
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('success') == 'linesheet_sent') { ?>
												<div style="padding:10px 20px;background:green;margin-bottom:30px;color:red;">
													Linesheet successfully sent.
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('success') == 'clear_linesheet_history') { ?>
												<div style="padding:10px 20px;background:#c0fca4;margin-bottom:30px;">
													<span style="float:right;cursor:pointer;" onclick="$(this).closest('div').hide();">[X]</span>
													<a name="#" style="text-decoration:none;">Linesheet History cleared.</a>
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('flash-message')): ?>
												<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
													<?php echo $this->session->flashdata('flash-message'); ?>
												</div>
												<?php endif; ?>
											</div>
											
											<?php if ($this->sales_user_details->access_level == '0' OR $this->sales_user_details->access_level == '1' OR $this->sales_user_details->access_level == '2') { ?>
											
											<?php
											/**********
											 * Linesheet History
											 */
											?>
											<div>
												<h6 class="section-heading">
													Linesheet Sending History
												</h6>
												
													<?php if ($history = @$this->sales_user_details->options['linesheet_history']) { ?>
													
												<ul class="cart-items clearfix">
												
														<?php $i = 1; foreach ($history as $date => $info) { ?>
												
													<li class="">
														<?php echo (@$i ?: '1').'. &nbsp; '.(@$info['items'] ?: 'Items1, Item2'); ?>
														<ul style="list-style-type:none;margin:0 0 0 1.5em;">
															<li style="margin:0;">Sent <?php echo @$date ? @date('Y-m-d h:ia', $date) : 'Date'; ?> to: <?php echo @$info['name'] ?: 'Name'; ?> <small>(<?php echo @$info['email'] ?: 'Email'; ?>)</small> <?php echo @$info['store_name'] ?: 'Store Name'; ?></li>
														</ul>
													</li>
													
														<?php $i++; if ($i === 6) break; } ?>
												</ul>
												
												<p>
													NOTE: Showing only last 5 activites for linesheet sending.
												</p>
											
													<?php } else { ?>
													
												<p>
													No history yet...
												</p>
												
													<?php } ?>
													
											</div>
										
											<?php } // end linesheet history ?>
										
											<br />
										
											<?php if ($this->sales_user_details->access_level == '0' OR $this->sales_user_details->access_level == '2') { ?>
								
											<?php
											/**********
											 * Sales Packages
											 */
											?>
											<div>
												<h6 class="section-heading">
													Sales Packages
												</h6>
												
												<?php if ($is_with_products) { ?>
												<div class="order-summary__detail" style="width:100%;font-size:1.4em;">
													<div style="text-align:center;">
														<button type="button" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" onclick="$('#modal-create_sales_package').show();" >
															Create Sales Package
														</button>
													</div>
												</div>
												<?php } ?>
												
												<ul class="cart-items clearfix">
												
													<?php if (@$packages) { ?>
														<?php $i = 1; foreach ($packages as $package) { ?>
												
													<li class="product-line-item">
														<div class="product-line-item__info" style="width:100%;">
															<?php if ($is_with_products) { ?>
															<div class="product-line-item__actions" style="width:auto;float:right;">
																<div class="actionlist clearfix">
																	<ul class="actions clearfix">
																		<li class="action-remove action-secondary action clearfix"> 
																			<a class="button button--alt button--small" href="<?php echo site_url('sales/view/index/'.$package->sales_package_id); ?>">View Package</a>
																		</li>
																	</ul>
																</div>
															</div>
															<?php } ?>
															<h3 class="product__name">
																<?php echo $i.'. &nbsp; '.$package->sales_package_name; ?>
																<?php if ($package->sales_package_id == '1' OR $package->sales_package_id == '2') { ?>
																<cite style="font-size:0.7em;">(system generated)</cite>
																<?php } ?>
																<?php if ($package->sales_package_id != '1' && $package->sales_package_id != '2' && $package->sales_user == '1') { ?>
																<cite style="font-size:0.7em;">(admin generated)</cite>
																<?php } ?>
															</h3>
														</div>
													</li>
													
														<?php $i++; } ?>
													<?php } ?>
													
												</ul>
											</div>
											
											<?php } // end sales packages ?>
											
										</div>

									</div>
									
								</div>
								<!-- .cart-detail -->

								<?php
								/**********
								 * Right side column
								 * Bottom Service Box
								 * Contact Info and notations to user
								 */
								?>
								<section class="ct ct-cartbody col col-4of12">
								
									<div class="order-summary__header clearfix">
										<h6 class="section-heading">
											My Users
										</h6>
									</div>
									<div class="cart-information">
										<div class="return-policy-block">
										
											<?php if (@$wholesale_users) { ?>
											
											<ol>
											
												<?php foreach ($wholesale_users as $user) { ?>
												<?php echo '<li>'.ucwords($user->store_name).'<br />'.ucwords($user->firstname.' '.$user->lastname).'<br /><small>('.$user->email.')</small></li>'; ?>
												<?php } ?>

											</ol>
											
											<?php } else { ?>
											
											No users available...
											
											<?php } ?>
											
										</div>
									</div>
									
								</section>
								
							</div>
							<!-- .wl-grid -->
	
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->

					<!-- Regular Modal -->
					<div id="modal-create_sales_package" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<span class="close" onclick="$('#modal-create_sales_package').hide();"><span style="font-size:0.7em;">CLOSE</span> &times;</span>
									<h1 class="modal-title">Create Sales Package</h1>
								</div>
								<div class="modal-body">
								
									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open('sales/create_sales_package', array('id'=>'form_create_sales_package')); ?>
									
									<input type="hidden" name="sales_user" value="<?php echo $this->sales_user_details->admin_sales_id; ?>" />
									
									<div class="form-group">
										<label class="col-md-3 control-label">Sales Package Name:
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="sales_package_name" placeholder="" style="width:100%;" /> 
											<span class="help-block">Give this sales package a name...</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Email Subject
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" name="email_subject" data-required="1" class="form-control" value="" style="width:100%;" /> 
											<span class="help-block">used as the subject for the email campaign</span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-9 col-md-offset-2">
											<button type="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>">Create Sales Package</button>
										</div>
									</div>
									
									<?php echo form_close(); ?>
									<!-- End FORM ===================================================================-->
									
								</div>
							</div>
						</div>
					</div>
					<!-- END Regular Modal -->
