                    <?php
                    $pre_link = @$role == 'sales' ? 'my_account/sales' : 'admin';
                    ?>

                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $pre_link.'/marketing/carousels/bulk_actions',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-wholesale_users_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="nortifications">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New Carousel ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Carousel information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Carousel permanently removed from records.
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
                                    <a href="<?php echo site_url($pre_link.'/marketing/carousels/add'); ?>" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Carousel
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
                                <select class="bs-select form-control selectpicker" id="bulk_actions_select" name="bulk_action" disabled>
                                    <option value="" selected="selected">Bulk Actions</option>
                                    <option value="ac">Activate</option>
                                    <option value="deac">Set as Inactive</option>
                                    <option value="del">Premanently Remove</option>
                                </select>
                            </div>
                            <button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                        </div>
                        <button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                    </div>

                    <?php
                    /***********
                     * Top Pagination
                     */
                    ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span style="<?php echo @$this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
                                <?php if (@$count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo (@$limit * @$page) - (@$limit - 1); ?> to <?php echo @$count_all < (@$limit * @$page) ? @$count_all : @$limit * @$page; ?> of about <?php echo number_format(@$count_all); ?> records <?php echo strtotime('today'); ?>
                                <?php } ?>
                            </span>
                            <?php echo @$this->pagination->create_links(); ?>
                        </div>
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
                        table.dataTable > tbody > tr.child span.dtr-title {
                            min-width: 125px;
                        }
                    </style>
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-carousels_">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm" style="width:40px;"> <!-- counter --> </th>
                                <th class="all text-center hidden-xs hidden-sm" style="width:40px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-carousels_ .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="all"> Name </th>
                                <th class="all" style="width:300px;"> Schedule </th>
                                <th class="all" style="width:100px;"> Status </th>
                                <th class="all" style="width:100px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (@$carousels)
                            {
                                $i = @$page ? ($limit * $page) - ($limit - 1) : 1;
                                foreach ($carousels as $carousel)
                                {
                                    $edit_link = site_url($pre_link.'/marketing/carousels/edit/index/'.@$carousel->carousel_id);
                                    ?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center hidden-xs hidden-sm">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo @$carousel->carousel_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <?php
                                /***********
                                 * Name
                                 */
                                ?>
                                <td>
                                    <a href="<?php echo $edit_link; ?>" />
                                        <?php echo ucwords(strtolower(@$carousel->name)); ?>
                                    </a>
                                </td>
                                <?php
                                /***********
                                 * Schedule
                                 */
                                ?>
                                <td>
                                    <?php
                                    $type = @$carousel->type;
                                    if ($type == 'recurring')
                                    {
                                        $cron_data = @$carousel->cron_data ? json_decode($carousel->cron_data, TRUE) : array();
                                        if (@$cron_data['week'])
                                        {
                                            $text = 'Weekly every';
                                            $days = explode(',', $cron_data['week']);
                                            foreach ($days as $day)
                                            {
                                                $text.= ' '.ucfirst($day).',';
                                            }
                                            $text = substr($text, 0, -1);
                                        }
                                        else
                                        {
                                            $text = 'Every';
                                            $days = explode(',', $cron_data['month']);
                                            sort($days);
                                            foreach ($days as $day)
                                            {
                                                $text.= ' '.ucfirst($day).',';
                                            }
                                            $text = substr($text, 0, -1);
                                            $text.= ' of each month';
                                        }
                                    }
                                    else
                                    {
                                        $text = 'Once on '.date('F j, Y', @$carousel->schedule);
                                    }
                                    echo $text;
                                    echo '<br />Next schedule is on '.date('F j, Y', @$carousel->schedule);
                                    ?>
                                </td>
                                <?php
                                /***********
                                 * Status
                                 */
                                ?>
                                <td>
                                    <?php if (@$carousel->status == '1') { ?>
                                    <span class="label label-sm label-success"> Active </span>
                                    <?php } ?>
                                    <?php if (@$carousel->status == '0') { ?>
                                    <span class="label label-sm label-danger"> Inactive </span>
                                    <?php } ?>
                                    <?php if (@$carousel->status == '2') { ?>
                                    <span class="label label-sm label-warning"> Suspended </span>
                                    <?php } ?>
                                </td>
                                <!-- ACTIONS column -->
                                <td class="dropdown-wrap dropdown-fix">

                                    <!-- Edit -->
                                    <!--<a href="javascript:;" class="tooltips" data-original-title="Edit">-->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>

                                    <?php if (@$carousel->status == '1') { ?>
                                    <!-- Deactivate -->
                                    <a data-toggle="modal" href="#deactivate-<?php echo @$carousel->carousel_id; ?>" class="tooltips" data-original-title="Deactivate">
                                        <i class="fa fa-ban font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if (@$carousel->status == '0') { ?>
                                    <!-- Activate -->
                                    <a data-toggle="modal" href="#activate-<?php echo @$carousel->carousel_id; ?>" class="tooltips" data-original-title="Activate">
                                        <i class="fa fa-check font-dark"></i>
                                    </a>
                                    <?php } ?>

                                    <!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo @$carousel->carousel_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>

                                    <!-- Test Send -->
                                    <a data-toggle="modal" href="#test_send-<?php echo @$carousel->carousel_id; ?>" class="tooltips" data-original-title="Test Send">
                                        <i class="fa fa-play-circle-o font-dark"></i>
                                    </a>

                                    <!-- ITEM ACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="activate-<?php echo @$carousel->carousel_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Activate Carousel</h4>
                                                </div>
                                                <div class="modal-body"> Set Carousel to ACTIVE? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($pre_link.'/marketing/carousels/activate/index/'.@$carousel->carousel_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM DEACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="deactivate-<?php echo @$carousel->carousel_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Deactivate Carousel</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to SET INACTIVE carousel? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($pre_link.'/marketing/carousels/deactivate/index/'.@$carousel->carousel_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM REMOVE -->
                                    <div class="modal fade bs-modal-sm" id="delete-<?php echo @$carousel->carousel_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Warning!</h4>
                                                </div>
                                                <div class="modal-body"> DELETE carousel permanently? <br /> This cannot be undone! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($pre_link.'/marketing/carousels/delete/index/'.@$carousel->carousel_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- TEST SEND -->
                                    <div class="modal fade bs-modal-md" id="test_send-<?php echo @$carousel->carousel_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Test Send Carousel</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <!-- Carousel Name -->
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">
                                                            Email
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="email" name="email" data-required="1" class="form-control test-send-email" value="" data-carousel_id="<?php echo @$carousel->carousel_id?>" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn green test-send-carousel">Send</button>
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

							<tr><td colspan="6" align="center">No records found.</td></tr>

								<?php
                            } ?>

                        </tbody>
                    </table>

                    <?php
                    /***********
                     * Bottom Pagination
                     */
                    ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span>
                                <?php if (@$count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo (@$limit * @$page) - (@$limit - 1); ?> to <?php echo @$count_all < (@$limit * @$page) ? @$count_all : @$limit * @$page; ?> of about <?php echo number_format(@$count_all); ?> records
                                <?php } ?>
                            </span>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>

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
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- BULK DEACTIVATE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-deac" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Deactivate!</h4>
								</div>
								<div class="modal-body"> Deactivate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
