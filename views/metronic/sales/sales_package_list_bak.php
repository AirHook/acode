                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> My Sales Packages </span>
                                    </div>
                                </div>
                                <div class="portlet-body">

									<!-- FORM =======================================================================-->
									<?php echo form_open(
                                        $this->config->slash_item('admin_folder').'campaigns/sales_package/bulk_actions',
                                        array(
                                            'class'=>'form-horizontal',
                                            'id'=>'form-sales_package_list_bulk_action'
                                        )
                                    ); ?>

                                    <?php
									/***********
									 * Noification area
									 */
									?>
                                    <div>
    									<?php if ($this->session->flashdata('success') == 'add') { ?>
    									<div class="alert alert-success auto-remove">
    										<button class="close" data-close="alert"></button> New Sales Package CREATED!
    									</div>
    									<?php } ?>
    									<?php if ($this->session->flashdata('success') == 'edit') { ?>
    									<div class="alert alert-success auto-remove">
    										<button class="close" data-close="alert"></button> Sales Package information updated.
    									</div>
    									<?php } ?>
    									<?php if ($this->session->flashdata('success') == 'delete') { ?>
    									<div class="alert alert-success auto-remove">
    										<button class="close" data-close="alert"></button> Sales Package permanently removed from records.
    									</div>
    									<?php } ?>
    									<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
    									<div class="alert alert-danger auto-remove">
    										<button class="close" data-close="alert"></button> An error occured. Please try again.
    									</div>
    									<?php } ?>
                                        <?php if ($this->session->flashdata('error') == 'del_system_sales_package') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> Unable to delete system generated sales packages. Please try again.
										</div>
										<?php } ?>
                                    </div>

                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Create a Sales Package
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
										<br />
                                        <div class="row">

											<div class="col-lg-3 col-md-4">
												<select class="bs-select form-control bs-select" id="bulk_actions_select" name="bulk_action" disabled>
													<option value="" selected="selected">Bulk Actions</option>
													<option value="del">Permanently Delete</option>
												</select>
											</div>
											<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

										</div>
										<button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-sales_packages">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                                <th class="text-center">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-sales_packages .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Sales Package </th>
                                                <th> Author </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
											if ($packages)
											{
												$i = 1;
												foreach ($packages as $package)
												{
													if (
														$package->sales_user == $this->sales_user_details->admin_sales_id
														OR $package->sales_user == '0'
													) { ?>

                                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                                <td class="hidden-xs hidden-sm">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center">
													<?php if ($package->sales_user != '0') { ?>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="checkboxes" name="<?php echo $package->set_as_default == '1' ? 'default_checkbox': 'checkbox[]'; ?>" value="<?php echo $package->sales_package_id; ?>" />
                                                        <span></span>
                                                    </label>
													<?php } ?>
                                                </td>
                                                <td>
													<a href="<?php echo site_url('sales/select_items/index/'.$active_category_id.'/'.$package->sales_package_id); ?>">
													<?php echo $package->sales_package_name; ?></a>
													<?php if ($package->sales_package_id == '2') { ?>
													&nbsp;
													<a class="text-danger" href="javascript:;"><cite class="small">Under construction</cite></a>
													<?php } elseif ($package->sales_package_items == '') { ?>
													&nbsp;
													<a class="text-danger" href="<?php echo site_url('sales/select_items/index/'.$package->sales_package_id); ?>"><small><cite>Select items first for this package</cite></small></a>
													<?php } ?>
													&nbsp;
													<a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url('sales/select_items/index/'.$active_category_id.'/'.$package->sales_package_id); ?>"><small><cite>view/edit</cite></small></a>
												</td>
                                                <td class="hidden-xs hidden-sm">
													<?php if ($package->sales_package_id == '1' OR $package->sales_package_id == '2') { ?>
													<small class="text-info"> <cite> system generated </cite></small>
													<?php } else if ($package->sales_user == '1') { ?>
													<small class="text-info"> <cite> admin </cite></small>
													<?php } else { ?>
                                                    <?php echo ucwords($package->admin_sales_user.' '.$package->admin_sales_lname); ?> - <small class="text-info"> <cite> sales </cite></small>
													<?php } ?>
                                                </td>
                                            </tr>

													<?php
													$i++;
													}
												}
											}
											else
											{ ?>

                                            <tr class="odd gradeX">
												<td colspan="4">No recods found.</td>
											</tr>

											<?php
											} ?>

                                        </tbody>
                                    </table>

									</form>
									<!-- End FORM =======================================================================-->
									<!-- END FORM-->

									<br />
									<div class="m-heading-1 border-blue m-bordered">
										<h3>NOTE:</h3>
										<p> System generated sales pacakges and sales packages that are set as default cannot be deleted. </p>
									</div>
									<div class="m-heading-1 border-green m-bordered hide">
										<h3>Sales Package</h3>
										<p> Here you can create sales packages for sending to wholesale users, etc... </p>
										<p> For more info please check out
											<a class="btn red btn-outline" href="javascript:;" target="">the official documentation</a>
										</p>
									</div>
                                </div>

                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>

						<!-- CHOOSE WHAT TO DO NOTICE -->
						<div class="modal fade bs-modal-MD" id="modal-choose_what_to_do" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-MD">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title"></h4>
									</div>
									<div class="modal-body text-center">
										<h3 class="margin-bottom-30"> Choose what to do:
										</h3>
										<div class="actions btn-set">
											<a href="<?php echo site_url('sales/select_items/index/'.$active_category_id); ?>" id="btn-send_linesheet_only" class="btn green btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left" onclick="$('#loading').modal('show');">
												<span class="ladda-label">Send Linesheet Only</span>
												<span class="ladda-spinner"></span>
											</a>
										</div>
										<p></p>
										<div class="actions btn-set">
											<a href="#modal_create_sales_package" data-toggle="modal" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">
												<span class="ladda-label">Create and Send Sales Package</span>
												<span class="ladda-spinner"></span>
											</a>
										</div>
										<p></p>
										<div class="actions btn-set">
											<a href="<?php echo site_url('sales/sales_package'); ?>" class="btn yellow btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left" onclick="$('#loading').modal('show');">
												<span class="ladda-label">Select and Send Saved Sales Package</span>
												<span class="ladda-spinner"></span>
											</a>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn dark btn-outline" data-dismiss="modal" onclick="Ladda.stopAll();">Cancel</button>
									</div>
								</div>
								<!-- /.modal-content -->
							</div>
							<!-- /.modal-dialog -->
						</div>
						<!-- /.modal -->
