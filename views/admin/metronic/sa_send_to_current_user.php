								<!--<div class="send_to_current_user <?php echo @$ws_user_details ? '' : 'display-none'; ?>">-->
								<div class="send_to_current_user">

									<div class="form-body selected-users-list-wrapper <?php echo @$ws_user_details ? '' : 'display-none'; ?>">
										<span class="caption">Send to the following <cite class="<?php echo @$ws_user_details ? 'hide' : ''; ?>">(maximum of 30 users per sending)</cite>:</span>
										<input type="hidden" name="emails" value="" />
										<div class="mt-checkbox-list selected-users-list">
											<!-- DOC: example child element --
											<label class="mt-checkbox mt-checkbox-outline" style="font-size:0.9em;">
												Rey Store -
												Rey Millares <cite class="small">(rsbgm@rcpixel.com)</cite>
												<input type="checkbox" class="send_to_current_user selected-list" name="email[]" value="rsbgm@rcpixel.com" checked />
												<span></span>
											</label>
											-->
											<?php if (@$ws_user_details)
											{ ?>

											<label class="mt-checkbox mt-checkbox-outline" style="font-size:0.9em;">
												<?php echo @$ws_user_details->store_name; ?> -
												<?php echo @$ws_user_details->fname.' '.@$ws_user_details->lname; ?> <cite class="small">(<?php echo @$ws_user_details->email; ?>)</cite>
												<input type="checkbox" class="send_to_current_user_ selected-list" name="email[]" value="<?php echo @$ws_user_details->email; ?>" checked />
												<span></span>
											</label>

												<?php
											} ?>

										</div>
	                                    <button type="button" class="btn-send-sales-package btn dark btn-sm <?php echo @$sa_details->sales_package_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?> margin-bottom-10">
	                                        Send <?php echo @$linesheet_sending_only ? 'Linesheet' : 'Package'; ?>
	                                    </button>
									</div>

									<div class="form-body col-md-12 <?php echo @$ws_user_details ? 'hide' : ''; ?>">

										<h5 class="form-group"> <cite>MY CURRENT ACTIVE USERS:</cite> <span class="font-red-flamingo"> * </span></h5>

										<?php if (@$total_users > @$users_per_page) { ?>
										<div class="form-group">
											<div class="row">
					                            <div class="col-md-9 margin-bottom-5">

					                                <!-- BEGIN FORM-->
					                                <!-- FORM =======================================================================-->
					                                <?php //echo form_open('admin/users/wholesale/search', array('class'=>'form-horizontal', 'id'=>'form-wholesale_users_search_email')); ?>

					                                <div class="input-group">
					                                    <input class="form-control select-user-search" placeholder="Search for Email or Store Name..." name="search_string" type="text" data-per_page="<?php echo @$users_per_page; ?>" data-total_users="<?php echo @$total_users; ?>" data-role="<?php echo @$role ?: ''; ?>" />
					                                    <span class="input-group-btn">
					                                        <button class="btn-search-current-user btn dark uppercase bold" type="button">Search</button>
					                                    </span>
														<span class="input-group-btn">
					                                        <button class="btn-reset-search-current-user btn default uppercase bold tooltips" data-original-title="Reset list" type="button" data-end_cur="<?php echo $number_of_pages; ?>"><i class="fa fa-refresh"></i></button>
					                                    </span>
					                                </div>

					                                <!--</form>
					                                <!-- End FORM =======================================================================-->
					                                <!-- END FORM-->

					                            </div>
											</div>
				                        </div>
										<?php } ?>

										<style>
											.sa-send.toolbar .caption.showing {
												position: relative;
												bottom: <?php echo @$total_users > @$users_per_page ? '-12px' : '0px'; ?>;
											}
											.sa-send.toolbar .pagination {
												margin: 0px;
												font-size: 0.8em;
											}
											.sa-send.toolbar .pagination > li > a,
											.sa-send.toolbar .pagination > .active > a {
												padding: 6px 7px;
											}
										</style>

										<?php if ( ! $total_users)
										{ ?>

										<div class="form-group">
											<div class="note note-danger">
												You don't have wholesae users assinged under your care. Add a new user <a href="javascript:;" class="send-to-new-user">here</a>.
											</div>
										</div>

											<?php
										}
										else
										{ ?>

										<div class="form-group" style="margin-bottom:0px;">
											<div class="sa-send current-users toolbar clearfix " style="margin-top:10px;margin-bottom:5px;">

												<span class="caption search display-none">
													Search result for: "<span class="search_string"></span>"
												</span>

												<span class="caption showing">
													Showing <span class="pagination-caption-showing"><?php echo ($page * $users_per_page) - ($users_per_page - 1); ?></span> to <span class="pagination-caption-per-page"><?php echo $total_users > $users_per_page ? $users_per_page : $total_users; ?></span> of <span class="pagination-caption-total_users"><?php echo $total_users; ?></span>
												</span>

												<ul class="pagination pagination-xs pull-right" data-per_page="<?php echo $users_per_page; ?>" data-total_users="<?php echo $total_users; ?>" data-end_cur="<?php echo $number_of_pages; ?>">

													<?php if ($total_users > $users_per_page)
													{
														// show only a max of 5 pagination links
														$in = $number_of_pages < 6 ? $number_of_pages : 6;
														?>

													<li class="first-page hide">
														<a href="javascript:;" data-cur_page="1">
															<i class="fa fa-angle-double-left"></i>
														</a>
													</li>

													<li class="prev-page hide">
														<a href="javascript:;" data-cur_page="">
															<i class="fa fa-angle-left"></i>
														</a>
													</li>

														<?php
														for($i=1;$i<$in;$i++)
														{ ?>
													<li class="page-number <?php echo $i == 1 ? 'page-one active' : ''; ?>">
														<a href="javascript:;" data-cur_page="<?php echo $i; ?>"> <?php echo $i; ?> </a>
													</li>
															<?php
														} ?>

													<li class="next-page <?php echo $number_of_pages > 1 ? '' : 'display-none'; ?>">
														<a href="javascript:;" data-cur_page="2">
															<i class="fa fa-angle-right"></i>
														</a>
													</li>

													<li class="last-page <?php echo $number_of_pages > $in ? '' : 'display-none'; ?>">
														<a href="javascript:;" data-cur_page="<?php echo $number_of_pages; ?>">
															<i class="fa fa-angle-double-right"></i>
														</a>
													</li>
														<?php
													} ?>

												</ul>

											</div>
										</div>

										<div class="form-group">

											<?php
			                                /***********
			                                 * Scrollable Style
			                                 */
			                                ?>
											<div class="form-control height-auto">

												<div class="">

													<div id="email_array_error"> </div>

													<div class="mt-checkbox-list select-users-list">

														<?php
														if (@$users)
														{
															foreach ($users as $user)
															{ ?>

                                                        <label class="mt-checkbox mt-checkbox-outline" style="font-size:0.8em;">
															<?php echo ucwords($user->store_name); ?> -
															<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)).' <cite class="small">('.$user->email.')</cite> '; ?>
                                                            <input type="checkbox" class="send_to_current_user list" name="" value="<?php echo $user->email; ?>" data-error-container="email_array_error" data-store_name="<?php echo $user->store_name; ?>" data-firstname="<?php echo $user->firstname; ?>" data-lastname="<?php echo $user->lastname; ?>" />
                                                            <span></span>
                                                        </label>

																<?php
															}
														} ?>

                                                    </div>

												</div>
											</div>

										</div>

										<hr class="form-group" />

											<?php
										} ?>

									</div>

								</div>
