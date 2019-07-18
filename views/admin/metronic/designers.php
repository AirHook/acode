					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open($this->config->slash_item('admin_folder').'designers/bulk_actions', array('class'=>'form-horizontal', 'id'=>'form-designers_bulk_actions')); ?>

					<?php
					/***********
					 * Noification area
					 */
					?>
					<div class="notification-are">
						<?php if ($this->session->flashdata('success') == 'add') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> New Designer ADDED!
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'edit') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Designer information updated.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'delete') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Designer permanently removed from records.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> An error occured. Please try again.
						</div>
						<?php } ?>
					</div>

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/add'); ?>" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Designer
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
						<br />
                        <div class="row">

							<div class="col-lg-3 col-md-4">
								<select class="bs-select form-control bs-select" id="bulk_actions_select" name="bulk_action" disabled>
									<option value="" selected="selected">Bulk Actions</option>
									<option value="ac">Activate</option>
									<option value="su">Suspend</option>
									<option value="del">Permanently Delete</option>
								</select>
							</div>
							<button class="btn green hidden-xs hidden-sm apply_bulk_actions" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

						</div>
						<button class="btn green btn-block hidden-md hidden-lg apply_bulk_actions margin-top-10" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-designers">
                        <thead>
                            <tr>
                                <th class="hidden-xs" style="width:40px;"> <!-- counter --> </th>
                                <th class="text-center" style="width:40px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-designers .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th > Designer </th>
                                <th class="hidden-xs"> Account </th>
                                <th class="hidden-xs" style="width:75px;"> Status </th>
                                <th class="hidden-xs" style="width:75px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

							<?php
							if ($designers)
							{
								$i = 1;
								foreach ($designers as $designer)
								{
									if (
										$this->webspace_details->options['site_type'] === 'hub_site'
										&& $designer->url_structure != $this->webspace_details->slug
									)
									{ ?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" id="heading_checkbox" name="checkbox[]" value="<?php echo $designer->des_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>">
										<?php echo $designer->designer; ?></a>
									<?php if ($designer->complete_info_status == '100') { ?>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>" style="text-decoration:none;">
										&nbsp; <span class="badge badge-danger tooltips" data-original-title="Has incomplete information">
										<i class="fa fa-bolt"></i> </span>
									</a>
									<?php } ?>
									&nbsp; &nbsp;
									<a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>"><small><cite>edit</cite></small></a>
								</td>
                                <td class="hidden-xs">
									<?php echo $designer->company_name; ?>
								</td>
                                <td class="hidden-xs">
                                    <span class="label label-sm label-<?php echo $designer->view_status == 'Y' ? 'success': 'danger'; ?>"> <?php echo $designer->view_status == 'Y' ? 'Active': 'Suspended'; ?> </span>
                                </td>
                                <td class="hidden-xs dropdown-wrap dropdown-fix">
                                    <div class="btn-group" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
										<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $designer->view_status == 'Y' ? 'suspend': 'activate'; ?>-<?php echo $designer->des_id; ?>">
                                                    <i class="icon-<?php echo $designer->view_status == 'Y' ? 'ban': 'check'; ?>"></i> <?php echo $designer->view_status == 'Y' ? 'Suspend': 'Activate'; ?> </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $designer->des_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/add'); ?>">
                                                    <i class="fa fa-plus"></i> Add Designer </a>
                                            </li>
                                        </ul>
                                    </div>
									<!-- ITEM SUSPEND -->
									<div class="modal fade bs-modal-sm" id="suspend-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Designer Info</h4>
												</div>
												<div class="modal-body"> Are you sure you want to SUSPEND designer? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/suspend/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									<div class="modal fade bs-modal-sm" id="activate-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Designer Info</h4>
												</div>
												<div class="modal-body"> ACTIVATE designer? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/activate/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									<div class="modal fade bs-modal-sm" id="delete-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Warning!</h4>
												</div>
												<div class="modal-body"> DELETE designer? <br /> This cannot be undone! </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/delete/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									elseif (
										$this->webspace_details->options['site_type'] !== 'hub_site'
										&& (
											$designer->url_structure === $this->webspace_details->slug
											OR $designer->folder === $this->webspace_details->slug
										) // backwards compatibility for 'basix-black-label'
									)
									{
										?>
                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" id="heading_checkbox" name="checkbox[]" value="<?php echo $designer->des_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>">
										<?php echo $designer->designer; ?></a>
									<?php if ($designer->complete_info_status) { ?>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>" style="text-decoration:none;">
										&nbsp; <span class="badge badge-danger tooltips" data-original-title="Has incomplete information">
										<i class="fa fa-bolt"></i> </span>
									</a>
									<?php } ?>
									&nbsp; &nbsp;
									<a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>"><small><cite>edit</cite></small></a>
								</td>
                                <td class="hidden-xs">
									<?php echo $designer->company_name; ?>
								</td>
                                <td class="hidden-xs">
                                    <span class="label label-sm label-<?php echo $designer->view_status == 'Y' ? 'success': 'danger'; ?>"> <?php echo $designer->view_status == 'Y' ? 'Active': 'Suspended'; ?> </span>
                                </td>
                                <td class="hidden-xs dropdown-wrap dropdown-fix">
                                    <div class="btn-group" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
										<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/edit/index/'.$designer->des_id); ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $designer->view_status == 'Y' ? 'suspend': 'activate'; ?>-<?php echo $designer->des_id; ?>">
                                                    <i class="icon-<?php echo $designer->view_status == 'Y' ? 'ban': 'check'; ?>"></i> <?php echo $designer->view_status == 'Y' ? 'Suspend': 'Activate'; ?> </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $designer->des_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/add'); ?>">
                                                    <i class="fa fa-plus"></i> Add Designer </a>
                                            </li>
                                        </ul>
                                    </div>
									<!-- ITEM SUSPEND -->
									<div class="modal fade bs-modal-sm" id="suspend-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Designer Info</h4>
												</div>
												<div class="modal-body"> Are you sure you want to SUSPEND designer? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/suspend/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									<div class="modal fade bs-modal-sm" id="activate-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Designer Info</h4>
												</div>
												<div class="modal-body"> ACTIVATE designer? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/activate/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									<div class="modal fade bs-modal-sm" id="delete-<?php echo $designer->des_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Warning!</h4>
												</div>
												<div class="modal-body"> DELETE designer? <br /> This cannot be undone! </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/delete/index/'.$designer->des_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									}
								}
							} ?>

                        </tbody>
                    </table>

					</form>
					<!-- End FORM =======================================================================-->
					<!-- END FORM-->

					<!-- BULK ACTIVATE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ac" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Activate!</h4>
								</div>
								<div class="modal-body"> Activate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-designers_bulk_actions').submit();" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-su" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Suspend!</h4>
								</div>
								<div class="modal-body"> Suspend or Deactivate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-designers_bulk_actions').submit();" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete!</h4>
								</div>
								<div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-designers_bulk_actions').submit();" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
