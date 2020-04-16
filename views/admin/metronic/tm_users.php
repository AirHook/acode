					<?php
					/***********
					 * Noification area
					 */
					?>
                    <div class="notifcations">
						<?php if ($this->session->flashdata('success') == 'add') { ?>
						<div class="alert alert-success ">
							<button class="close" data-close="alert"></button> New User ADDED!
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'add') { ?>
						<div class="alert alert-danger ">
							<button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'edit') { ?>
						<div class="alert alert-danger ">
							<button class="close" data-close="alert"></button> The form fields where not properly filled. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'delete') { ?>
						<div class="alert alert-success ">
							<button class="close" data-close="alert"></button> User(s) successfully removed.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'edit') { ?>
						<div class="alert alert-success ">
							<button class="close" data-close="alert"></button> Records successfully updated.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger ">
							<button class="close" data-close="alert"></button> An error occured. Please try again.
						</div>
						<?php } ?>
                    </div>

                    <div class="row">
    					<div class="col-md-4 margin-bottom-20">

    						<h1>Users / Developers</h1>
    						<hr />

    						<!-- BEGIN FORM-->
    						<!-- FORM =======================================================================-->
    						<?php echo form_open(
                                'admin/task_manager/users_add',
                                array(
                                    'class'=>'form-horizontal',
                                    'id'=>'form-task_manager_users_add'
                                )
                            ); ?>

    						<div class="form-body">
    							<div class="form-group">
    								<label class="col-lg-4 control-label">Email:
    									<span class="required"> * </span>
    								</label>
    								<div class="col-lg-8">
    									<input type="email" class="form-control facet_name" name="email" value="" />
    								</div>
    							</div>
								<div class="form-group">
    								<label class="col-lg-4 control-label">First Name:
    									<span class="required"> * </span>
    								</label>
    								<div class="col-lg-8">
    									<input type="text" class="form-control facet_name" name="fname" value="" />
    								</div>
    							</div>
								<div class="form-group">
    								<label class="col-lg-4 control-label">Last Name:
    									<span class="required"> * </span>
    								</label>
    								<div class="col-lg-8">
    									<input type="text" class="form-control facet_name" name="lname" value="" />
    								</div>
    							</div>
    						</div>

    						<div class="row">
    							<div class="col-md-offset-4 col-md-8 hidden-md hidden-sm hidden-xs">
    								<button type="submit" class="btn sbold dark btn-block">Add New User</button>
    							</div>
                                <div class="col-sm-12 hidden-lg">
                                    <button type="submit" class="btn sbold dark btn-block">Add New User</button>
                                </div>
								<div class="col-md-offset-4 col-md-8 hidden-md hidden-sm hidden-xs">
									<a class="btn btn-secondary-outline font-dark btn-block" href="<?php echo site_url('admin/task_manager/projects'); ?>">
										<i class="fa fa-reply"></i> Back to projects</a>
    							</div>
                                <div class="col-sm-12 hidden-lg">
									<a class="btn btn-secondary-outline font-dark btn-block" href="<?php echo site_url('admin/task_manager/projects'); ?>">
										<i class="fa fa-reply"></i> Back to projects</a>
                                </div>
    						</div>

    						</form>
    						<!-- End FORM =======================================================================-->
    						<!-- END FORM-->

    					</div>
    					<div class="col-md-8">

    						<!-- BEGIN FORM-->
    						<!-- FORM =======================================================================-->
    						<?php echo form_open(
								'admin/task_manager/bulk_actions',
								array(
									'class'=>'form-horizontal',
									'id'=>'form-task_manager_users_bulk_actions')
							); ?>

    						<div class="table-toolbar">
    							<div class="row">

    								<div class="col-lg-3 col-md-4">
    									<select class="bs-select form-control" id="bulk_actions_select" name="bulk_action" disabled>
    										<option value="" selected="selected">Bulk Actions</option>
    										<option value="del">Permanently Delete</option>
    									</select>
    								</div>
    								<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

    							</div>
    							<button class="btn green btn-block hidden-lg hidden-md margin-top-10" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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
    						<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-task_manager_users">
    							<thead>
    								<tr>
    									<th class="hidden-xs hidden-sm" width="30px"> <!-- counter --> </th>
    									<th class="text-center" width="30px">
    										<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
    											<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-task_manager_users .checkboxes" />
    											<span></span>
    										</label>
    									</th>
    									<th> Name </th>
    									<th> Email </th>
    									<th style="width:60px;"> Actions </th>
    								</tr>
    							</thead>
    							<tbody>

    								<?php
    								if (@$users)
    								{
    									$i = 1;
    									foreach ($users as $user)
    									{ ?>

    								<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
    									<td class="hidden-xs hidden-sm">
    										<?php echo $i; ?>
    									</td>
    									<td class="text-center">
    										<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
    											<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $user->id; ?>" />
    											<span></span>
    										</label>
    									</td>
    									<td>
    										<?php echo $user->fname.' '.$user->lname; ?>
    									</td>
    									<td>
    										<cite><?php echo $user->email; ?></cite>
    									</td>
    									<td class="dropdown-wrap dropdown-fix">

											<!-- Edit -->
		                                    <a href="javascrip:;" class="tooltips hide" data-original-title="Edit">
		                                        <i class="fa fa-pencil font-dark"></i>
		                                    </a>
											<!-- Delete -->
		                                    <a data-toggle="modal" href="#delete-user-<?php echo $user->id; ?>" class="tooltips" data-original-title="Remove User">
		                                        <i class="fa fa-trash font-dark"></i>
		                                    </a>

    										<div class="btn-group hide" >
    											<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
    												<i class="fa fa-angle-down"></i>
    											</button>
    											<!-- DOC: Remove "pull-right" class to default to left alignment -->
    											<ul class="dropdown-menu pull-right">
    												<li>
    													<!--
    													<a href="#edit-colors-facet-<?php echo $user->id; ?>" data-toggle="modal">-->
    													<a href="javascript:;" class="disabled-link disable-target">
    														<i class="icon-pencil"></i> Edit </a>
    												</li>
    												<li>
    													<a data-toggle="modal" href="#delete-user-<?php echo $user->id; ?>">
    														<i class="icon-trash"></i> Delete </a>
    												</li>
    											</ul>
    										</div>

    										<!-- ITEM EDIT -->
    										<div class="modal fade bs-modal-sm" id="edit-colors-facet-<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    											<div class="modal-dialog modal-sm">
    												<div class="modal-content">
    													<div class="modal-header">
    														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    														<h4 class="modal-title">Edit Color</h4>
    													</div>
    													<div class="modal-body"> Edit Color is not yet available at this time. Please contact admin. </div>
    													<div class="modal-footer">
    														<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
    														<!--
    														<a href="<?php echo site_url('admin/task_manager/users_edit/index/'.$user->id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
    															<span class="ladda-label">Confirm?</span>
    															<span class="ladda-spinner"></span>
    														</a>
    														-->
    													</div>
    												</div>
    												<!-- /.modal-content -->
    											</div>
    											<!-- /.modal-dialog -->
    										</div>
    										<!-- /.modal -->
    										<!-- ITEM DELETE -->
    										<div class="modal fade bs-modal-sm" id="delete-user-<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    											<div class="modal-dialog modal-sm">
    												<div class="modal-content">
    													<div class="modal-header">
    														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    														<h4 class="modal-title">Warning!</h4>
    													</div>
    													<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
    													<div class="modal-footer">
    														<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
    														<a href="<?php echo site_url('admin/task_manager/users_delete/index/'.$user->id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
									}
		                            else
		                            { ?>

		                            <tr class="odd gradeX">
		                                <td colspan="5">No recods found.</td>
		                            </tr>

		                            	<?php
    								} ?>

    							</tbody>
    						</table>

    						</form>
    						<!-- End FORM =======================================================================-->
    						<!-- END FORM-->

    					</div>
                    </div>

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
									<button onclick="$('#form-products_color_variants_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
