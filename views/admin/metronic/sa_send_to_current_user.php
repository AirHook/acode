								<div class="send_to_current_user display-none">

									<div class="form-body">

										<h4> <cite>CURRENT USERS:</cite> </h4>

										<div class="form-group">
											<label class="tooltips" data-original-title="Under Construcction">
												<input type="checkbox" class="send_to_current_user send_to_all" name="send_to_all" value="Y" disabled /> Send to all
											</label>
										</div>

										<div class="notice-send-to-all alert alert-danger display-none">
	                                        <button class="close" data-close="alert"></button> "Send to all" will be done in the background during which you may continue browsing.  </div>

										<div class="form-group">

											<label>My Users:<span class="required"> * </span>
											</label>

											<?php
			                                /***********
			                                 * Scrollable Style
			                                 */
			                                ?>
											<div class="form-control height-auto">
												<div class="scroller" style="height:800px;" data-always-visible="1">

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

											<?php
			                                /***********
			                                 * Pagination Style
			                                 *
			                                ?>
											<div>
												<ul class="sa-send pagination pagination-sm nav nav-tabs" data-total_users="<?php echo $total_users; ?>" data-end_cur="<?php echo $end_cur_users; ?>">
												    <li>
														&nbsp; &nbsp;
												    </li>
												    <li class="active">
												        <a href="#cur_users_1" data-toggle="tab" data-cur="1"> 1 </a>
												    </li>
													<li>
												        <a href="#cur_users_2" data-toggle="tab" data-cur="2"> 2 </a>
												    </li>
													<li>
												        <a href="#cur_users_3" data-toggle="tab" data-cur="3"> 3 </a>
												    </li>
													<li>
														<a href="#cur_users_4" data-toggle="tab" data-cur="4"> 4 </a>
												    </li>
													<li>
														<a href="#cur_users_5" data-toggle="tab" data-cur="5"> 5 </a>
												    </li>
													<li>
														<a href="#cur_users_6" data-toggle="tab" data-cur="6"> 6 </a>
												    </li>
												    <li>
												        <a href="#cur_users_2" data-toggle="tab" data-cur="2">
												            <i class="fa fa-angle-right"></i>
												        </a>
												    </li>
													<li>
												        <a href="#cur_users_<?php echo $end_cur_users; ?>" data-toggle="tab" data-cur="<?php echo $end_cur_users; ?>">
												            <i class="fa fa-angle-double-right"></i>
												        </a>
												    </li>
													<li>
														&nbsp; &nbsp;
												    </li>
												</ul>
											</div>
											<div class="tab-content">

												<?php
												$i = 1; // user counter
												$cur = 1; // tab pane counter
												$per_page = $users_per_page;
												foreach ($users as $user)
												{
													if ($i == 1)
													{
														echo '<div id="cur_users_'.$cur.'" class="form-control height-auto tab-pane active in"><div class="mt-checkbox-list">';
														$cur++;
													}

													if (($i % $per_page) == 1 && $i != 1)
													{
														echo '</div></div>';
														echo '<div id="cur_users_'.$cur.'" class="form-control height-auto tab-pane"><div class="mt-checkbox-list">';
														$cur++;
													}
													?>

														<label class="mt-checkbox mt-checkbox-outline">
															<?php echo $user->store_name ? ucwords($user->store_name) : '-'; ?> <br />
															<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)).' <cite class="small">('.$user->email.')</cite> '; ?>
															<input type="checkbox" class="send_to_current_user list" name="email[]" value="<?php echo $user->user_id; ?>" data-error-container="email_array_error" />
															<span></span>
														</label>

													<?php
													$i++;
												} ?>

													</div>
												</div>

											</div>
											<?php // /* */ ?>

										</div>

										<hr />

									</div>

								</div>
