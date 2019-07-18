											<div class="form-body">

												Options
												<br />

												<?php
												// let's process session sa_options if any
												$options_array =
													$this->session->sa_options
													? json_decode($this->session->sa_options, TRUE)
													: array()
												;
												$w_prices = @$options_array['w_prices'] ?: 'Y';
												$w_images = @$options_array['w_images'] ?: 'N';
												$linesheets_only = @$options_array['linesheets_only'] ?: 'N';
												?>

												<span>
													<input type="radio" class="sa_options" name="w_prices" value="Y" <?php echo $w_prices == 'Y' ? 'checked' : ''; ?> /> Yes
													<?php echo nbs(2); ?>
													<input type="radio" class="sa_options" name="w_prices" value="N" <?php echo $w_prices == 'N' ? 'checked' : ''; ?> /> No
													<?php echo nbs(3); ?> - Send with prices
												</span>

												<br class="hide"/>

												<span id="span_e_prices" class="hide">
													<input type="radio" class="sa_options" name="e_prices" value="Y" /> Yes
													<?php echo nbs(2); ?>
													<input type="radio" class="sa_options" name="e_prices" value="N" checked="checked" /> No
													<?php echo nbs(3); ?> - Edit prices?
												</span>

												<br />

												<span id="span_w_images" style="">
													<input type="radio" class="sa_options" name="w_images" value="Y" <?php echo $w_images == 'Y' ? 'checked' : ''; ?> /> Yes
													<?php echo nbs(2); ?>
													<input type="radio" class="sa_options" name="w_images" value="N" <?php echo $w_images == 'N' ? 'checked' : ''; ?> /> No
													<?php echo nbs(3); ?> - Attach Linesheets
												</span>

												<br />

												<span id="span_linesheets_only" style="">
													<input type="radio" class="sa_options" name="linesheets_only" value="Y" <?php echo $linesheets_only == 'Y' ? 'checked' : ''; ?> /> Yes
													<?php echo nbs(2); ?>
													<input type="radio" class="sa_options" name="linesheets_only" value="N" <?php echo $linesheets_only == 'N' ? 'checked' : ''; ?> /> No
													<?php echo nbs(3); ?> - Send Linesheets only
												</span>

												<h3> Send Sales Package to: </h3>

												<br />

												<div class="form-group">
													<div class="btn-group btn-group-justified">
														<a href="javascript:;" class="btn dark select-user" data-user="new_user"> NEW USER </a>
														<a href="javascript:;" class="btn dark btn-outline select-user" data-user="current_user"> CURRENT USER </a>
	                                                </div>
												</div>

											</div>

											<?php $this->load->view('metronic/sales/summary_view_send_to_new_user'); ?>

											<?php $this->load->view('metronic/sales/summary_view_send_to_current_user'); ?>
