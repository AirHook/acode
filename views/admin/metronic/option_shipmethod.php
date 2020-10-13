												<div class="col-md-3 margin-bottom-20">

													<div class="row">
														<div class="col-md-12">
															<h1>Ship Method</h1>
															<hr />
															<p></p>
														</div>
													</div>

													<!-- BEGIN FORM-->
													<!-- FORM =======================================================================-->
													<?php echo form_open(
														'admin/options/shipmethod/add',
														array(
															'class' => '',
															'id' => 'form-option_shipmethod_add'
														)
													); ?>

													<input type="hidden" name="table" value="tbl_shipmethod" />
													<input type="hidden" name="option" value="shipmethod" />

													<div class="form-body">
														<div class="form-group">
															<label class="control-label">Courier:
																<span class="required"> * </span>
															</label>
															<input type="text" class="form-control option_name" data-option="shipmethod" name="courier" value="" />
														</div>
														<div class="form-group">
															<label class="control-label">Fee:
																<span class="required"> * </span>
															</label>
															<input type="text" class="form-control option_slug" data-option="shipmethod" name="fix_fee" value="" />
														</div>
													</div>

													<hr />
							                        <div class="form-actions bottom">
														<button type="submit" class="btn btn-block dark sbold">Add New Ship Method</button>
													</div>

													</form>
													<!-- End FORM =======================================================================-->
													<!-- END FORM-->

												</div>
												<div class="col-md-9">

													<!-- BEGIN FORM-->
													<!-- FORM =======================================================================-->
													<?php echo form_open($this->config->slash_item('admin_folder').'facets/bulk_actions', array('class'=>'form-horizontal', 'id'=>'form-styles_facets_bulk_actions')); ?>

													<input type="hidden" name="table" value="tblstyle" />
													<input type="hidden" name="facet" value="styles" />

													<div class="table-toolbar hide">
														<div class="row">

															<div class="col-lg-3 col-md-4">
																<select class="bs-select form-control selectpicker" id="bulk_actions_select-styles" name="bulk_action" disabled>
																	<option value="" selected="selected">Bulk Actions</option>
																	<option value="del">Permanently Delete</option>
																</select>
															</div>
															<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions-styles" data-toggle="modal" href="#confirm_bulk_actions-styles" disabled> Apply </button>

														</div>
														<button class="btn green btn-block hidden-lg hidden-md margin-top-10" id="apply_bulk_actions-styles" data-toggle="modal" href="#confirm_bulk_actions-styles" disabled> Apply </button>

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
													<table class="table table-striped table-hover table-checkable order-column" id="tbl-option_shipmethod">
														<thead>
															<tr>
																<th class="hidden-xs hidden-sm" style="width:30px;"> <!-- counter --> </th>
																<th class="text-center" style="width:30px;">
																	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																		<input type="checkbox" id="heading_checkbox-styles" class="group-checkable" data-set="#tbl-option_shipmethod .checkboxes" />
																		<span></span>
																	</label>
																</th>
																<th> Courier </th>
																<th class="text-center"> Fee </th>
																<th> Actions </th>
															</tr>
														</thead>
														<tbody>

															<?php
															if ($shipmethods)
															{
																$i = 1;
																foreach ($shipmethods as $shipmethod)
																{ ?>

															<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
																<td class="hidden-xs hidden-sm">
																	<?php echo $i; ?>
																</td>
																<td class="text-center">
																	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																		<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $shipmethod->ship_id; ?>" />
																		<span></span>
																	</label>
																</td>
																<td>
																	<!--<a href="#edit-shipmethod-option-<?php echo $shipmethod->ship_id; ?>" data-toggle="modal">-->
																	<a href="javascript:;">
																		<?php echo $shipmethod->courier; ?>
																	</a>
																</td>
																<td class="text-center">
																	<?php echo $shipmethod->fix_fee ? '$ '.number_format($shipmethod->fix_fee, 2) : ''; ?>
																</td>
																<td class="dropdown-wrap dropdown-fix">

																	<div class="btn-group hide" >
																		<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
																			<i class="fa fa-angle-down"></i>
																		</button>
																		<!-- DOC: Remove "pull-right" class to default to left alignment -->
																		<ul class="dropdown-menu pull-right">
																			<li>
																				<!--
																				<a href="#edit-styles-facet-<?php echo $shipmethod->ship_id; ?>" data-toggle="modal">-->
																				<a href="javascript:;" class="disabled-link disable-target">
																					<i class="icon-pencil"></i> Edit </a>
																			</li>
																			<li>
																				<a data-toggle="modal" href="#delete-styles-facet-<?php echo $shipmethod->ship_id; ?>">
																					<i class="icon-trash"></i> Delete </a>
																			</li>
																		</ul>
																	</div>
																	<!-- ITEM EDIT -->
																	<div class="modal fade bs-modal-md" id="edit-styles-facet-<?php echo $shipmethod->ship_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																		<div class="modal-dialog modal-md">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																					<h4 class="modal-title">Update Option Info</h4>
																				</div>
																				<div class="modal-body"> ACTIVATE option? </div>
																				<div class="modal-footer">
																					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'facets/edit/index/'.$shipmethod->ship_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
																	<div class="modal fade bs-modal-sm" id="delete-styles-facet-<?php echo $shipmethod->ship_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																		<div class="modal-dialog modal-sm">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																					<h4 class="modal-title">Warning!</h4>
																				</div>
																				<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
																				<div class="modal-footer">
																					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'facets/delete/index/styles/'.$shipmethod->ship_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
													<!-- End FORM =======================================================================-->
													<!-- END FORM-->

												</div>

												<!-- BULK DELETE -->
												<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-styles-del" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Delete!</h4>
															</div>
															<div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<button onclick="$('#form-styles_facets_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
