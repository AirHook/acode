												<div class="col-md-4 margin-bottom-20">

													<div class="row">
														<div class="col-md-12">
															<h1>Color Facets</h1>
															<hr />
															<p>Simlpy type in a new Color facet name and click on the button to Add New Facet. The new facet should appear in the list afterwards.</p>
														</div>
													</div>

													<!-- BEGIN FORM-->
													<!-- FORM =======================================================================-->
													<?php echo form_open($this->config->slash_item('admin_folder').'facets/add', array('class'=>'form-horizontal', 'id'=>'form-color_facets_add')); ?>

													<input type="hidden" name="table" value="tblcolors" />
													<input type="hidden" name="facet" value="colors" />

													<div class="form-body">
														<div class="form-group">
															<label class="col-lg-4 control-label">Color Name:
																<span class="required"> * </span>
															</label>
															<div class="col-lg-8">
																<input type="text" class="form-control facet_name" data-facet="color_facets" name="color_name" value="">
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-4 control-label">Slug:
																<span class="required"> * </span>
															</label>
															<div class="col-lg-8">
																<input type="text" class="form-control facet_slug" data-facet="color_facets" name="url_structure" value="" tabindex="-1">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-offset-4 col-md-8 hidden-md hidden-sm hidden-xs">
															<button type="submit" class="btn sbold blue">Add New Facet</button>
														</div>
														<div class="col-xs-12 hidden-lg">
															<button type="submit" class="btn sbold blue">Add New Facet</button>
														</div>
													</div>

													</form>
													<!-- End FORM =======================================================================-->
													<!-- END FORM-->

												</div>
												<div class="col-md-8">

													<!-- BEGIN FORM-->
													<!-- FORM =======================================================================-->
													<?php echo form_open($this->config->slash_item('admin_folder').'facets/bulk_actions', array('class'=>'form-horizontal', 'id'=>'form-color_facets_bulk_actions')); ?>

													<input type="hidden" name="table" value="tblcolors" />
													<input type="hidden" name="facet" value="colors" />

													<div class="table-toolbar">
														<div class="row">

															<div class="col-lg-3 col-md-4">
																<select class="bs-select form-control selectpicker" id="bulk_actions_select-colors" name="bulk_action" disabled>
																	<option value="" selected="selected">Bulk Actions</option>
																	<option value="del">Permanently Delete</option>
																</select>
															</div>
															<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions-colors" data-toggle="modal" href="#confirm_bulk_actions-colors" disabled> Apply </button>

														</div>
														<button class="btn green btn-block margin-top-10 hidden-lg hidden-md" id="apply_bulk_actions-colors" data-toggle="modal" href="#confirm_bulk_actions-colors" disabled> Apply </button>

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
													<table class="table table-striped table-hover table-checkable order-column" id="tbl-facets_colors">
														<thead>
															<tr>
																<th class="hidden-xs hidden-sm"> <!-- counter --> </th>
																<th class="text-center">
																	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																		<input type="checkbox" id="heading_checkbox-colors" class="group-checkable" data-set="#tbl-facets_colors .checkboxes" />
																		<span></span>
																	</label>
																</th>
																<th> Color Facet Name </th>
																<th> Slug </th>
																<th> Actions </th>
															</tr>
														</thead>
														<tbody>

															<?php
															if ($color_facets)
															{
																$i = 1;
																foreach ($color_facets as $color)
																{ ?>

															<tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
																<td class="hidden-xs hidden-sm">
																	<?php echo $i; ?>
																</td>
																<td class="text-center">
																	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																		<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $color->color_id; ?>" />
																		<span></span>
																	</label>
																</td>
																<td>
																	<a href="#edit-colors-facet-<?php echo $color->color_id; ?>" data-toggle="modal">
																	<?php echo $color->color_name; ?></a>
																	<!--
																	&nbsp; &nbsp;
																	<a class="hidden_first_edit_link" style="display:none;" href="#edit-colors-facet-<?php echo $color->color_id; ?>" data-toggle="modal"><small><cite>edit</cite></small></a>-->
																</td>
																<td>
																	<cite><?php echo $color->url_structure; ?></cite>
																</td>
																<td class="dropdown-wrap dropdown-fix">
																	<div class="btn-group" >
																		<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
																			<i class="fa fa-angle-down"></i>
																		</button>
																		<!-- DOC: Remove "pull-right" class to default to left alignment -->
																		<ul class="dropdown-menu pull-right">
																			<li>
																				<!--
																				<a href="#edit-colors-facet-<?php echo $color->color_id; ?>" data-toggle="modal">-->
																				<a href="javascript:;" class="disabled-link disable-target">
																					<i class="icon-pencil"></i> Edit </a>
																			</li>
																			<li>
																				<a data-toggle="modal" href="#delete-colors-facet-<?php echo $color->color_id; ?>">
																					<i class="icon-trash"></i> Delete </a>
																			</li>
																		</ul>
																	</div>
																	<!-- ITEM EDIT -->
																	<div class="modal fade bs-modal-md" id="edit-colors-facet-<?php echo $color->color_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																		<div class="modal-dialog modal-md">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																					<h4 class="modal-title">Update Webspace Info</h4>
																				</div>
																				<div class="modal-body"> ACTIVATE webspace? </div>
																				<div class="modal-footer">
																					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'facets/edit/index/'.$color->color_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
																	<div class="modal fade bs-modal-sm" id="delete-colors-facet-<?php echo $color->color_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																		<div class="modal-dialog modal-sm">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																					<h4 class="modal-title">Warning!</h4>
																				</div>
																				<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
																				<div class="modal-footer">
																					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'facets/delete/index/colors/'.$color->color_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
												<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-colors-del" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Delete!</h4>
															</div>
															<div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<button onclick="$('#form-color_facets_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
