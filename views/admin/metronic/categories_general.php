									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->config->slash_item('admin_folder').'categories/bulk_actions',
										array(
											'class'=>'form-horizontal',
											'id'=>'form-categories_bulk_actions-general'
										)
									); ?>

                                    <div class="table-toolbar">
                                        <div class="row">

											<div class="col-lg-3 col-md-4">
												<select class="bs-select form-control selectpicker" id="bulk_actions_select-general" name="bulk_action" disabled>
													<option value="" selected="selected">Bulk Actions</option>
													<option value="ac">Activate</option>
													<option value="su">Suspend</option>
													<option value="del">Permanently Delete</option>
												</select>
											</div>
											<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions-general" disabled> Apply </button>

										</div>
										<button class="btn green btn-block hidden-lg hidden-md margin-top-10" id="apply_bulk_actions-general" disabled> Apply </button>
                                    </div>

									<?php
									/*********
									 * This style a fix to the dropdown menu inside table-responsive table-scrollable
									 * datatables. Setting position to relative allows the main dropdown button to
									 * follow cell during responsive mode. A jquery is also needed on the button to
									 * toggle class to change back position to absolute so that the dropdown menu
									 * shows even on overflow
									 */
									?>
									<style>
										.dropdown-fix {
											position: relative;
										}
									</style>
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-categories_general">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs hidden-sm" style="width:30px;"> <!-- counter --> </th>
                                                <th class="text-center" style="width:30px;">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" id="heading_checkbox-general" class="group-checkable" data-set="#tbl-categories_general .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Categories</th>
                                                <th class="hidden-xs" style="max-width:100px;"> With Products </th>
                                                <th class="hidden-xs hidden-sm" style="max-width:100px;"> Status </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
											if ($categories)
											{
												$i = 1;
												foreach ($categories as $category)
												{ ?>

                                            <tr class="odd gradeX <?php echo $category->view_status == '1' ? '': 'danger'; ?>">
                                                <td class="hidden-xs hidden-sm">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $category->category_id; ?>" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
						<?php if ($category->category_level == 0) echo '<span style="margin:0px 20px;">-</span>'; ?>
							<?php if ($category->category_level == 1) echo '<span style="margin-left:25px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
								<?php if ($category->category_level == 2) echo '<span style="margin-left:55px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
									<?php if ($category->category_level == 3) echo '<span style="margin-left:85px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
										<?php if ($category->category_level == 4) echo '<span style="margin-left:115px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
											<?php if ($category->category_level == 5) echo '<span style="margin-left:145px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
												<?php if ($category->category_level == 6) echo '<span style="margin-left:175px;">&nbsp;</span><span style="margin:0px 20px;">-</span>'; ?>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>">
													<?php echo $category->category_name; ?></a> <small><cite>(<?php echo $category->category_slug; ?>)</cite></small>
													&nbsp;
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>"><small><cite>edit</cite></small></a>
												</td>
                                                <td class="hidden-xs text-center">
													<?php if (@$category->with_products) { ?>
													<i class="fa fa-check" style="color:green;"></i>
													<?php } else { ?>
													-
													<?php } ?>
                                                </td>
                                                <td class="hidden-xs hidden-sm">
                                                    <span class="label label-sm label-<?php echo $category->view_status == '1' ? 'success': 'danger'; ?>"> <?php echo $category->view_status == '1' ? 'Active': 'Suspended'; ?> </span>
                                                </td>
                                                <td class="dropdown-wrap dropdown-fix">
                                                    <div class="btn-group" >
                                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > <i class="fa fa-tasks hidden-sm hidden-md hidden-lg"></i><span class="hidden-xs">Actions</span>
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
														<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>">
                                                                    <i class="icon-pencil"></i> Edit </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" href="#<?php echo $category->view_status == '1' ? 'suspend': 'activate'; ?>-<?php echo $category->category_id; ?>">
                                                                    <i class="icon-<?php echo $category->view_status == '1' ? 'ban': 'check'; ?>"></i> <?php echo $category->view_status == '1' ? 'Suspend': 'Activate'; ?> </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" href="#delete-<?php echo $category->category_id; ?>">
                                                                    <i class="icon-trash"></i> Delete </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
																<a href="#modal-add_category" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                                                                    <i class="fa fa-plus"></i> Add category </a>
                                                            </li>
                                                        </ul>
                                                    </div>
													<!-- ITEM SUSPEND -->
													<div class="modal fade bs-modal-sm" id="suspend-<?php echo $category->category_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Update Category Info</h4>
																</div>
																<div class="modal-body"> Are you sure you want to SUSPEND category? </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/suspend/index/'.$category->category_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																		<span class="ladda-label">Confirm?</span>
																		<span class="ladda-spinner"></span>
																	</a>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													<!-- ITEM ACTIVATE -->
													<div class="modal fade bs-modal-sm" id="activate-<?php echo $category->category_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Update Category Info</h4>
																</div>
																<div class="modal-body"> ACTIVATE Category? </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/activate/index/'.$category->category_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																		<span class="ladda-label">Confirm?</span>
																		<span class="ladda-spinner"></span>
																	</a>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													<!-- ITEM DELETE -->
													<div class="modal fade bs-modal-sm" id="delete-<?php echo $category->category_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Warning!</h4>
																</div>
																<div class="modal-body">
																	DELETE item? <br />
																	This cannot be undone! <br />
																	<br />
																	<div class="note note-danger">
																		<h4 class="block">Notie! </h4>
																		<p> If item has child categories, all children will be pushed upwards to the next parent category level. </p>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/delete/index/'.$category->category_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																		<span class="ladda-label">Confirm?</span>
																		<span class="ladda-spinner"></span>
																	</a>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
                                                </td>
                                            </tr>

													<?php
													$i++;
												}
											} ?>

                                        </tbody>
                                    </table>

									</form>
									<!-- End FORM ===================================================================-->
									<!-- END FORM-->

									<!-- BULK ACTIVATE -->
									<div class="modal fade bs-modal-md" id="confirm_bulk_actions-general-ac" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Activate!</h4>
												</div>
												<div class="modal-body">
													Activate multiple items?
													<br /><br />
													This might affect products from other designers under the same category. Editing the item details will provide more information on your actions to the item.
												</div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form" data-style="expand-left">
														<span class="ladda-label">Confirm?</span>
														<span class="ladda-spinner"></span>
													</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->

									<!-- BULK SUSPEND -->
									<div class="modal fade bs-modal-md" id="confirm_bulk_actions-general-su" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Suspend!</h4>
												</div>
												<div class="modal-body">
													Suspend or Deactivate multiple items?
													<br /><br />
													This might affect products from other designers under the same category. Editing the item details will provide more information on your actions to the item.
												</div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form" data-style="expand-left">
														<span class="ladda-label">Confirm?</span>
														<span class="ladda-spinner"></span>
													</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->

									<!-- BULK DELETE -->
									<div class="modal fade bs-modal-md" id="confirm_bulk_actions-general-del" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Delete!</h4>
												</div>
												<div class="modal-body">
													Delete multiple items? <br />
													This cannot be undone!
													<br /><br />
													This might affect products from other designers under the same category. Editing the item details will provide more information on your actions to the item.
												</div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form" data-style="expand-left">
														<span class="ladda-label">Confirm?</span>
														<span class="ladda-spinner"></span>
													</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
