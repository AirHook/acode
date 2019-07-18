                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
										
										<?php 
										if (validation_errors())
										{ ?>
										<div class="alert alert-danger">
											<strong>Error!</strong> 
											<?php echo validation_errors(); ?>
										</div>
											<?php
										} ?>

										<div class="product-details-wrapper">
											<div class="row">
												<div class="col-xs-12">
													<h3 class="uppercase">Contact Us</h3>
												</div>
												<div class="col-sm-7">

													<?php 
													if ($view == 'contact_form')
													{ ?>
													
                                                    <div class="c-contact">
                                                        <div class="c-content-title-1 hide">
                                                            <h3 class="uppercase">Contact Us</h3>
                                                            <div class="c-line-left bg-dark hide"></div>
                                                            <p class="c-font-lowercase hide">Our helpline is always open to receive any inquiry or feedback. Please feel free to drop us an email from the form below and we will get back to you as soon as we can.</p>
                                                        </div>
														
														<!-- BOF Form ==============================================================-->
														<?php echo form_open('contact'); ?>

															<div class="form-group">
                                                                <input type="text" placeholder="Frist Name" class="form-control input-md" name="fname" value="<?php echo set_value('fname'); ?>" required="required" /> 
																<?php echo form_error('fname', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
															<div class="form-group">
                                                                <input type="text" placeholder="Last Name" class="form-control input-md" name="lname" value="<?php echo set_value('lname'); ?>" required="required" /> 
																<?php echo form_error('lname', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
                                                            <div class="form-group">
                                                                <input type="text" placeholder="Your Email" class="form-control input-md" name="email" value="<?php echo set_value('email'); ?>" required="required" /> 
																<?php echo form_error('email', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
                                                            <div class="form-group">
                                                                <input type="text" placeholder="Contact Phone" class="form-control input-md" name="telephone" value="<?php echo set_value('telephone'); ?>" />
																<?php echo form_error('telephone', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
															<div class="form-group">
																<select class="form-control select2 select-state" name="state">
																	<option></option>
																	<?php foreach (list_states() as $state) { ?>
																	<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																	<?php } ?>
																</select>
																<?php echo form_error('state', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
                                                            <div class="form-group">
																<select class="form-control select2 select-country" name="country">
																	<option></option>
																	<?php foreach (list_countries() as $country) { ?>
																	<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																	<?php } ?>
																</select>
																<?php echo form_error('country', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
                                                            <div class="form-group">
                                                                <textarea rows="8" name="comments" placeholder="Write comments here ..." class="form-control input-md"><?php echo set_value('comments'); ?></textarea>
																<?php echo form_error('comments', '<cite class="help-block text-danger">', '</cite>'); ?>
                                                            </div>
                                                            <button type="submit" class="btn dark">Submit</button>
                                                        </form>
                                                    </div>
														<?php
													}
													else
													{ ?>
												
													<div class="note note-default">
														<h4 class="block">Thank you for contacting us.</h4>
														<p> You will be hearing from us within 24 hours to better assist you. </p>
													</div>
														<?php
													} ?>
													
												</div>
												<div class="col-sm-5">
										
													<div class="contact-methods clearfix">
														
														<h4 style="border-bottom:1px solid #ccc;text-transform:uppercase;">Email</h4>
														<p>
															To contact us via email, complete the fields to the left, or write us at <?php echo safe_mailto($this->webspace_details->info_email, $this->webspace_details->info_email); ?>
														</p>
														
														<h4 style="border-bottom:1px solid #ccc;text-transform:uppercase;">Support</h4>
														<p>
															Sales and Customer Support is available 7am – midnight EST, seven days a week: <?php echo safe_mailto($this->webspace_details->info_email, $this->webspace_details->info_email); ?>
														</p>
														
														<h4 style="border-bottom:1px solid #ccc;text-transform:uppercase;">Telephone</h4>
														<p>
															<br /> <?php echo $this->webspace_details->phone; ?>
														</p>
													</div>
													
												</div>
											</div>
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->