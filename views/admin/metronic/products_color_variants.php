					<?php
					/***********
					 * Noification area
					 */
					?>
                    <div class="notifcations">
						<?php if ($this->session->flashdata('success') == 'add') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> New Color ADDED!
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'edit') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Color information updated.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'delete') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Color permanently removed from records.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'color_exists') { ?>
						<div class="alert alert-danger ">
							<button class="close" data-close="alert"></button> Color/Color Code already exists. Try again, or, edit color code (see note below the field Color Code).
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> An error occured. Please try again.
						</div>
						<?php } ?>
                    </div>

                    <div class="row">
    					<div class="col-md-4 margin-bottom-20">

    						<h1>Color Variants</h1>
    						<hr />
    						<p>
    							These are the colors used as variants for products. The important item here is the color code which is used as part of the product image file name.
    						</p>
    						<p>
    							Simlpy type in a new Color name and click on the button to Add New Color. The new color should appear in the list afterwards.
    						</p>

    						<!-- BEGIN FORM-->
    						<!-- FORM =======================================================================-->
    						<?php echo form_open(
                                $this->config->slash_item('admin_folder').'products/color_variants/add',
                                array(
                                    'class'=>'form-horizontal',
                                    'id'=>'form-products_color_variants_add'
                                )
                            ); ?>

    						<div class="form-body">
    							<div class="form-group">
    								<label class="col-lg-4 control-label">Color Name:
    									<span class="required"> * </span>
    								</label>
    								<div class="col-lg-8">
    									<input type="text" class="form-control facet_name" name="color_name" value="" style="text-transform:uppercase;">
    								</div>
    							</div>
    							<div class="form-group">
    								<label class="col-lg-4 control-label">Color Code:
    									<span class="required"> * </span>
    								</label>
    								<div class="col-lg-8">
    									<input type="text" class="form-control facet_slug" name="color_code" value="" tabindex="-1" readonly style="text-transform:uppercase;">
                                        <span class="help-block">
    										If color always comes back as already existing, try changing the color code. You can edit the color code by clicking <a href="javascript:;" id="disable-readonly"><cite>here</cite></a>.
    									</span>
    								</div>
    							</div>
    						</div>

    						<div class="row">
    							<div class="col-md-offset-4 col-md-8 hidden-md hidden-sm hidden-xs">
    								<button type="submit" class="btn sbold blue">Add New Color</button>
    							</div>
                                <div class="col-sm-12 hidden-lg">
                                    <button type="submit" class="btn sbold blue">Add New Color</button>
                                </div>
    						</div>

    						</form>
    						<!-- End FORM =======================================================================-->
    						<!-- END FORM-->

    					</div>
    					<div class="col-md-8">

    						<!-- BEGIN FORM-->
    						<!-- FORM =======================================================================-->
    						<?php echo form_open($this->config->slash_item('admin_folder').'products/color_variants/bulk_actions', array('class'=>'form-horizontal', 'id'=>'form-products_color_variants_bulk_actions')); ?>

    						<input type="hidden" name="table" value="tblcolors" />
    						<input type="hidden" name="facet" value="colors" />

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
    						<table class="table table-striped table-hover table-checkable order-column" id="tbl-product_color_variants">
    							<thead>
    								<tr>
    									<th class="hidden-xs hidden-sm" width="30px"> <!-- counter --> </th>
    									<th class="text-center" width="30px">
    										<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
    											<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-product_color_variants .checkboxes" />
    											<span></span>
    										</label>
    									</th>
    									<th> Color Name </th>
    									<th> Color Code </th>
    									<th> Actions </th>
    								</tr>
    							</thead>
    							<tbody>

    								<?php
    								if ($colors)
    								{
    									$i = 1;
    									foreach ($colors as $color)
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
    										<cite><?php echo $color->color_code; ?></cite>
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
    										<div class="modal fade bs-modal-sm" id="edit-colors-facet-<?php echo $color->color_id?>" tabindex="-1" role="dialog" aria-hidden="true">
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
    														<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/color_variants/edit/index/'.$color->color_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
    														<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/color_variants/delete/index/'.$color->color_id); ?>" type="button" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
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
