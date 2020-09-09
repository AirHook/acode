								<div class="send_to_new_user display-none">

									<h4> <cite>NEW USER:</cite> </h4>

									<div class="form-body col-md-12">

										<input type="hidden" name="reference_designer" class="send_to_new_user" value="<?php echo @$this->sales_user_details->designer; ?>" />
										<input type="hidden" name="admin_sales_email" class="send_to_new_user" value="<?php echo @$this->sales_user_details->email; ?>" />
										<input type="hidden" name="admin_sales_id" class="send_to_new_user" value="<?php echo @$this->sales_user_details->admin_sales_id; ?>" />
										<input type="hidden" name="access_level" value="2" />

										<div class="form-group">
											<label>Email<span class="required"> * </span>
											</label>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-envelope"></i>
												</span>
												<input type="email" name="email" class="form-control send_to_new_user" value="<?php echo set_value('email'); ?>" />
											</div>
										</div>
										<div class="form-group">
											<label>First Name<span class="required"> * </span>
											</label>
											<input name="firstname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('firstname'); ?>" />
										</div>
										<div class="form-group">
											<label>Last Name<span class="required"> * </span>
											</label>
											<input name="lastname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('lastname'); ?>" />
										</div>
										<div class="form-group">
											<label>Store Name<span class="required"> * </span>
											</label>
											<input name="store_name" type="text" class="form-control send_to_new_user" value="<?php echo set_value('store_name'); ?>" />
										</div>
										<div class="form-group">
											<label>Fed Tax ID
											</label>
											<input name="fed_tax_id" type="text" class="form-control send_to_new_user" value="<?php echo set_value('fed_tax_id'); ?>" />
										</div>
										<div class="form-group">
											<label>Telephone<span class="required"> * </span>
											</label>
											<input name="telephone" type="text" class="form-control send_to_new_user" value="<?php echo set_value('telephone'); ?>" />
										</div>
										<div class="form-group">
											<label>Address 1<span class="required"> * </span>
											</label>
											<input name="address1" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address1'); ?>" />
										</div>
										<div class="form-group">
											<label>Address 2
											</label>
											<input name="address2" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address2'); ?>" />
										</div>
										<div class="form-group">
											<label>City<span class="required"> * </span>
											</label>
											<input name="city" type="text" class="form-control send_to_new_user" value="<?php echo set_value('city'); ?>" />
										</div>
										<div class="form-group">
											<label>State<span class="required"> * </span>
											</label>
											<select class="form-control select2me send_to_new_user" name="state">
												<option value="">Select...</option>
												<?php foreach (list_states() as $state) { ?>
												<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label>Country<span class="required"> * </span>
											</label>
											<select class="form-control select2me send_to_new_user" name="country">
												<option value="">Select...</option>
												<?php foreach (list_countries() as $country) { ?>
												<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label>Zip Code<span class="required"> * </span>
											</label>
											<input name="zipcode" type="text" class="form-control send_to_new_user" value="<?php echo set_value('zipcode'); ?>" />
										</div>

										<hr class="form-group" />

										<div class="form-group">
											<div class="btn-set btn-set-send-sales-package display-none">
			                                    <button type="submit" class="btn-send-sales-package-new-user btn dark btn-lg btn-block <?php echo @$sa_details->sales_package_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?>">
			                                        Send <?php echo @$linesheet_sending_only ? 'Linesheet' : 'Package'; ?>
			                                    </button>
			                                </div>
										</div>

									</div>

								</div>
