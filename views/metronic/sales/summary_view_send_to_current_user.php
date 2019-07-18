								<div class="send_to_current_user" style="display:none;">

									<div class="form-body">

										<h4> <cite>CURRENT USER:</cite> </h4>

										<input type="hidden" class="send_to_current_user" sname="send_to" value="current_user" />

										<?php if (
											$this->uri->segment(2) === 'purchase_orders'
											OR $this->uri->segment(2) === 'sales_orders'
										)
										{ ?>
										<div class="alert alert-warning">
											<button class="close" data-close="alert"></button>
											Select only one user
										</div>
											<?php
										}
										else
										{ ?>
										<div class="form-group">
											<label>
												<input type="checkbox" class="send_to_current_user send_to_all" name="send_to_all" value="Y" /> Send to all </label>
										</div>
											<?php
										} ?>

										<div class="form-group">
											<label>My Users:<span class="required"> * </span>
											</label>
											<div class="form-control height-auto">
												<div class="scroller" style="height:<?php echo $this->uri->segment(2) === 'purchase_orders' ? '300px' : '500px'; ?>;" data-always-visible="1">

													<div id="email_array_error"> </div>
													<div class="mt-checkbox-list">

														<?php foreach ($users as $user)
														{ ?>

                                                        <label class="mt-checkbox mt-checkbox-outline">
															<?php echo ucwords($user->store_name); ?> <br />
															<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)).' <cite class="small">('.$user->email.')</cite> '; ?>
                                                            <input type="checkbox" class="send_to_current_user list" name="email[]" value="<?php echo $user->email; ?>" data-error-container="email_array_error" />
                                                            <span></span>
                                                        </label>

															<?php
														} ?>

                                                    </div>

												</div>
											</div>
										</div>

										<hr />

									</div>

								</div>
