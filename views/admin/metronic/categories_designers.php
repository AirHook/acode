											<?php foreach ($designers as $designer) { ?>
											<?php if ($designer->url_structure !== 'instylenewyork' && $designer->url_structure !== 'shop7thavenue') { ?>
											
											<div class="tab-pane <?php echo $active_category_tab == $designer->url_structure ? 'active' : ''; ?>" id="tab_<?php echo $designer->url_structure; ?>">
											
												<div class="note note-info">
													<h4 class="block">NOTES:</h4>
													<p> To be able to show the parent/child tree relationship, sorting is disabled. </p>
													<p> All inactive/suspended items are at the bottom of the tree list. </p>
													<p> BULK ACTIONS - use sparringly as this affect the item which may still be linked to more than one designer. </p>
												</div>
									
												<!-- BEGIN FORM-->
												<!-- FORM =======================================================================-->
												<?php echo form_open($this->config->slash_item('admin_folder').'categories/bulk_actions', array('class'=>'form-horizontal', 'id'=>'form-categories_bulk_actions-'.$designer->url_structure)); ?>
												
												<div class="table-toolbar">
													<div class="row">
													
														<div class="col-lg-3 col-md-4">
															<select class="bs-select form-control selectpicker" id="bulk_actions_select-<?php echo $designer->url_structure; ?>" name="bulk_action" disabled>
																<option value="" selected="selected">Bulk Actions</option>
																<option value="ac">Activate</option>
																<option value="su">Suspend</option>
																<option value="del">Permanently Delete</option>
															</select>
														</div>
														<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions-<?php echo $designer->url_structure; ?>" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>
														
													</div>
													<button class="btn green hidden-lg hidden-md" id="apply_bulk_actions-<?php echo $designer->url_structure; ?>" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>
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
												<table class="table table-striped table-bordered table-hover table-checkable order-column tbl-categories_designers" data-table="#tbl-categories_<?php echo $designer->url_structure; ?>_wrapper" data-designer="<?php echo $designer->url_structure; ?>" id="tbl-categories_<?php echo $designer->url_structure; ?>">
													<thead>
														<tr>
															<th class="hidden-xs hidden-sm" style="width:30px;"> <!-- counter --> </th>
															<th class="text-center" style="width:30px;">
																<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																	<input type="checkbox" id="heading_checkbox-<?php echo $designer->url_structure; ?>" class="group-checkable" data-set="#tbl-categories_<?php echo $designer->url_structure; ?> .checkboxes" />
																	<span></span>
																</label>
															</th>
															<th> Categories for <?php echo strtoupper($designer->designer); ?> </th>
															<th style="max-width:150px;"> With Products </th>
															<th style="max-width:150px;"> Status </th>
															<th style="max-width:150px;"> Actions </th>
														</tr>
													</thead>
													<tbody>
													
														<?php 
														$des_categories = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure));
														
														if ($des_categories) 
														{
															$i = 1;
															foreach ($des_categories as $category) 
															{ ?>
															
														<tr class="odd gradeX <?php echo $category->view_status == '1' ? '': 'danger'; ?>" onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
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
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>">
																<?php echo $category->category_name; ?></a> <small><cite>(<?php echo $category->category_slug; ?>)</cite></small>
																&nbsp; &nbsp;
																<a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>"><small><cite>edit</cite></small></a>
															</td>
															<td class="hidden-xs hidden-sm text-center">
																<?php if ($category->with_products) { ?>
																<i class="fa fa-check" style="color:green;"></i>
																<?php } else { ?>
																-
																<?php } ?>
															</td>
															<td>
																<span class="label label-sm label-<?php echo $category->view_status == '1' ? 'success': 'danger'; ?>"> <?php echo $category->view_status == '1' ? 'Active': 'Suspended'; ?> </span>
															</td>
															<td class="dropdown-wrap dropdown-fix">
																<div class="btn-group" >
																	<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
																		<i class="fa fa-angle-down"></i>
																	</button>
																	<!-- DOC: Remove "pull-right" class to default to left alignment -->
																	<ul class="dropdown-menu pull-right">
																		<li>
																			<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$category->category_id); ?>">
																				<i class="icon-pencil"></i> Edit </a>
																		</li>
																		<!--
																		<li>
																			<a data-toggle="modal" href="#<?php echo $category->view_status == '1' ? 'suspend': 'activate'; ?>-<?php echo $category->category_id; ?>">
																				<i class="icon-<?php echo $category->view_status == '1' ? 'ban': 'check'; ?>"></i> <?php echo $category->view_status == '1' ? 'Suspend': 'Activate'; ?> </a>
																		</li>
																		<li>
																			<a data-toggle="modal" href="#delete-<?php echo $category->category_id; ?>">
																				<i class="icon-trash"></i> Delete </a>
																		</li>
																		-->
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
																			<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
																			<div class="modal-footer">
																				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																				<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/delete/index/'.$category->category_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
												<div class="modal fade bs-modal-md" id="confirm_bulk_actions-<?php echo $designer->url_structure; ?>-ac" tabindex="-1" role="dialog" aria-hidden="true">
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
																<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form-designers" data-form="#form-categories_bulk_actions-<?php echo $designer->url_structure; ?>" data-style="expand-left">
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
												<div class="modal fade bs-modal-md" id="confirm_bulk_actions-<?php echo $designer->url_structure; ?>-su" tabindex="-1" role="dialog" aria-hidden="true">
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
																<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form-designers" data-form="#form-categories_bulk_actions-<?php echo $designer->url_structure; ?>" data-style="expand-left">
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
												<div class="modal fade bs-modal-md" id="confirm_bulk_actions-<?php echo $designer->url_structure; ?>-del" tabindex="-1" role="dialog" aria-hidden="true">
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
																<button type="button" class="btn green mt-ladda-btn ladda-button submit-bulk-action-form-designers" data-form="#form-categories_bulk_actions-<?php echo $designer->url_structure; ?>" data-style="expand-left">
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
												
											</div>
											
											<?php } ?>
											<?php } ?>
