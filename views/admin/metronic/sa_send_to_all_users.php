								<div class="send_to_all_users display-none">

									<div class="form-body col-md-12 <?php echo @$ws_user_details ? 'hide' : ''; ?>">

										<h5 class="form-group"> <cite>SEND TO ALL USERS:</cite> <span class="font-red-flamingo"> * </span></h5>

										<div id="email_array_error"> </div>

										<div class="form-group">

											<label class="mt-checkbox mt-checkbox-outline">
												Active Users
												<input type="checkbox" class="send_to_all_users list" name="active_users" value="1" data-error-container="email_array_error" checked />
												<span></span>
											</label>

											<br />

											<label class="mt-checkbox mt-checkbox-outline">
												InActive Users
												<input type="checkbox" class="send_to_all_users list" name="inactive_users" value="1" data-error-container="email_array_error" />
												<span></span>
											</label>

										</div>

										<hr class="form-group" />

										<div class="form-group">
											<button type="button" class="btn-send-sales-package-all-users btn dark btn-sm <?php echo @$sa_details->sales_package_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?> margin-bottom-10">
		                                        Send <?php echo @$linesheet_sending_only ? 'Linesheet' : 'Package'; ?>
		                                    </button>
										</div>

									</div>

								</div>
