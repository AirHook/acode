                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        'admin/task_manager/bulk_actions',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-tm_projects_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notifications">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New Project ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Record permanently removed.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'item_not_found') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> Item not found.
                        </div>
                        <?php } ?>
                    </div>

                    <div class="table-toolbar">

                        <div class="row">

                            <div class="col-lg-4 pull-right">
                                <a href="<?php echo site_url('admin/task_manager/projects_add'); ?>" class="btn dark pull-right"> Add New Project </a>
                                <a href="<?php echo site_url('admin/task_manager/users'); ?>" class="btn default pull-right" style="margin-right:5px;"> Add User </a>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control selectpicker" id="bulk_actions_select" title="Bulk Actions" name="bulk_action" disabled>
                                    <option value="ac">Activate</option>
                                    <option value="de">Inactivate</option>
                                    <option value="ur">Set URGENT</option>
                                    <option value="del">Permanently Delete</option>
                                </select>
                            </div>
                            <button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                        </div>
                        <button class="btn green btn-block margin-top-10 hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                    </div>

                    <?php
                    /***********
                     * Top Pagination
                     */
                    ?>
                    <?php if ( ! @$search) { ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span style="<?php //echo @$this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
                                <?php if (@$count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo (@$limit * @$page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
                                <?php } ?>
                            </span>
                            <?php //echo @$this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <?php } ?>

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
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-projects_list">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm" style="width:30px;"> <!-- counter --> </th>
                                <th class="text-center" style="width:30px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-projects_list .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Project Name </th>
                                <th style="width:120px;"> Platform </th>
                                <?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
                                <th style="width:120px;"> Reference Designer </th>
                                <?php } ?>
                                <th style="width:80px;"> Status </th>
                                <th style="width:80px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (@$projects)
                            {
                                $i = 1;
                                foreach ($projects as $project)
                                {
                                    $project_no = $project->project_id;
                                    for($c = strlen($project_no);$c < 3;$c++)
                            		{
                            			$project_no = '0'.$project_no;
                            		}

                                    $edit_link = site_url('admin/task_manager/projects_edit/index/'.$project->project_id);
                                    $details_link = site_url('admin/task_manager/tasks/index/'.$project->project_id);
                                    ?>

                            <tr class="odd gradeX ">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $project->project_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <!-- Name -->
                                <td>
                                    <a href="<?php echo $details_link; ?>" class="btn-block font-dark">
                                        <span style="margin-bottom:5px;display:inline-block;">
                                            <small><?php echo $project_no; ?>. &nbsp; </small> <?php echo $project->name; ?>
                                        </span>
                                        <?php
                                        $description = $project->description;
                                        if (strlen($description) > 250)
                                        {
                                            echo '<br />'.substr($description, 0, 250).' ... <small>[read more]</small>';
                                        }
                                        else echo (strlen($description) > 0 ? '<br />'.$description : '');
                                        ?>
                                    </a>

                                    <?php
                                    $tasks = $this->tasks_list->select(
                            			array(
                            				'project_id' => $project->project_id
                            			)
                            		);

                                    if ($tasks)
                                    { ?>

                                    <div class="todo-project-item-foot">

                                        <!-- Number of Tasks -->
                                        <?php if ($this->tasks_list->open_tasks > 0)
                                        { ?>

                                        <p class="todo-red todo-inline">
                                            <?php echo @$this->tasks_list->open_tasks; ?> <?php echo @$this->tasks_list->open_tasks < $this->tasks_list->row_count ? 'Remaining ' : ''; ?>Tasks
                                            &nbsp;
                                            <a class="nestable-collapse-expand nestable-expand" data-action="expand" href="javascript:;" style="color:#d39790;">
                                                <i class="fa fa-chevron-down tooltips" data-original-title="Expand"></i>
                                            </a>
                                            <a class="nestable-collapse-expand nestable-collapse display-none" data-action="collapse" href="javascript:;" style="color:#d39790;">
                                                <i class="fa fa-chevron-up tooltips" data-original-title="Collapse"></i>
                                            </a>
                                        </p>

                                            <?php
                                        }
                                        else
                                        { ?>

                                        <p class="todo-red todo-inline">
                                            Tasks completed
                                        </p>

                                            <?php
                                        } ?>

                                        <!-- Number users involved -->
                                        <p class="todo-inline todo-float-r hide">
                                            1 Responsible
                                            <a class="todo-add-button" href="#todo-members-modal" data-toggle="modal">+</a>
                                        </p>
                                        <!-- Tasks -->
                                        <div class="dd nestable_list display-none" id="<?php echo $project->project_id; ?>">
                                            <ol class="dd-list">

                                                <?php
                                                $t = 1;
                                                foreach ($tasks as $task)
                                                {
                                                    if ($task->date_end_target > strtotime('today') && $task->date_end_target < strtotime('tomorrow'))
                                                    {
                                                        $due_date = ' - TODAY';
                                                    }
                                                    else
                                                    {
                                                        $past_due = $task->date_end_target < strtotime('today') ? 'font-red' : '';
                                                        if ($task->status == '2') $past_due = 'color:#ccc;';
                                                        $due_date =
                                                            $task->date_end_target == '0'
                                                            ? ' - <cite class="small">(no due date)</cite>'
                                                            : ' - <span class="'.$past_due.'">'.date('M j, Y', $task->date_end_target).'</span>'
                                                        ;
                                                    }

                                                    $assigned_user =
                                                        trim($task->fname.' '.$task->lname)
                                                        ?: '<cite class="small">(no assigned user)</cite>'
                                                    ;
                                                    ?>

                                                <li class="dd-item dd3-item" data-task_id="<?php echo $task->task_id; ?>">

                                                    <div class="dd-handle dd3-handle"> </div>
                                                    <div class="dd3-content <?php echo $task->status == '2' ? 'tooltips' : ''; ?>" data-original-title="Complete">
                                                        <a href="<?php echo site_url('admin/task_manager/task_details/index/'.$task->task_id); ?>" style="display:inline-block;width:100%;">
                                                            <span class="pull-right" style="<?php echo $task->status == '2' ? 'color:#ccc;text-decoration:line-through;' : ''; ?>">
                                                                <?php echo $assigned_user.$due_date; ?>
                                                            </span>
                                                            <span style="width:60%;display:inline-block;overflow:hidden;<?php echo $task->status == '2' ? 'color:#ccc;text-decoration:line-through;' : ''; ?>">
                                                                <?php
                                                                $title = '<span class="t_no">'.$t.'</span>. '.$task->title;
                                                                if (strlen($title) > 75)
                                                                {
                                                                    $title = substr($title, 0, 75).'...<cite class="small">(more)</cite>';
                                                                }
                                                                echo $title;
                                                                ?>
                                                                <?php echo $task->urgent == '1' ? '<cite class="font-red"><strong>URGENT!</strong></cite>' : ''; ?>
                                                            </span>
                                                        </a>
                                                    </div>

                                                </li>

                                                    <?php
                                                    $t++;
                                                }
                                                ?>

                                                <!-- Sample original list html --
                                                <li class="dd-item dd3-item" data-id="13">
                                                    <div class="dd-handle dd3-handle"> </div>
                                                    <div class="dd3-content"> Item 13 </div>
                                                </li>
                                                <li class="dd-item dd3-item" data-id="14">
                                                    <div class="dd-handle dd3-handle"> </div>
                                                    <div class="dd3-content"> Item 14 </div>
                                                </li>
                                                -->
                                            </ol>
                                            <a href="javascript:;" class="btn btn-xs grey btn-add-task" data-project_id="<?php echo $project->project_id; ?>">Add Tasks</a>
                                        </div>
                                    </div>

                                        <?php
                                    }
                                    ?>

                                </td>
                                <!-- Platform -->
                                <td> <?php echo $project->platform_name; ?> </td>
                                <!-- Webspace -->
                                <?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
                                <td> <?php echo @$project->webspace_name; ?> </td>
                                <?php } ?>
                                <!-- Status -->
                                <td>
                                    <?php if ($project->status == '1') { ?>
                                    <span class="label label-sm label-success"> Active </span>
                                    <?php } ?>
                                    <?php if ($project->status == '0') { ?>
                                    <span class="label label-sm label-danger"> Inactive </span>
                                    <?php } ?>
                                    <?php if ($project->status == '2') { ?>
                                    <span class="label label-sm label-warning"> URGENT! </span>
                                    <?php } ?>
                                </td>
                                <!-- Actions -->
                                <td class="dropdown-wrap dropdown-fix">

                                    <!-- Edit -->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>
                                    <?php if ($project->status == '0' OR $project->status == '2') { ?>
                                    <!-- Activate -->
                                    <a data-toggle="modal" href="#activate-<?php echo $project->project_id; ?>" class="tooltips" data-original-title="Activate">
                                        <i class="fa fa-check font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($project->status == '1' OR $project->status == '2') { ?>
                                    <!-- Set Inactive -->
                                    <a data-toggle="modal" href="#set-inactive-<?php echo $project->project_id; ?>" class="tooltips" data-original-title="Set Inactive">
                                        <i class="fa fa-ban font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($project->status == '0' OR $project->status == '1') { ?>
                                    <!-- URGENT -->
                                    <a data-toggle="modal" href="#urgent-<?php echo $project->project_id; ?>" class="tooltips" data-original-title="Set Item as URGENT">
                                        <i class="fa fa-exclamation-triangle font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $project->project_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>

                                    <!-- ITEM URGENT -->
                                    <div class="modal fade bs-modal-sm" id="urgent-<?php echo $project->project_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update Item Info</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to set item to URGENT? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/task_manager/projects_edit/status/'.$project->project_id.'/2'); ?>" type="button" class="btn green">
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
                                    <!-- ITEM SET INACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="set-inactive-<?php echo $project->project_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update Item Info</h4>
                                                </div>
                                                <div class="modal-body"> Set Inactive item? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/task_manager/projects_edit/status/'.$project->project_id.'/0'); ?>" type="button" class="btn green">
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
                                    <div class="modal fade bs-modal-sm" id="activate-<?php echo $project->project_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update Item Info</h4>
                                                </div>
                                                <div class="modal-body"> ACTIVATE item? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/task_manager/projects_edit/status/'.$project->project_id.'/1'); ?>" type="button" class="btn green">
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
                                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $project->project_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Warning!</h4>
                                                </div>
                                                <div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/task_manager/projects_edit/delete/'.$project->project_id); ?>" type="button" class="btn green">
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
                                <td colspan="<?php echo $this->webspace_details->options['site_type'] == 'hub_site' ? '7' : '6'; ?>">No recods found.</td>
                            </tr>

                            <?php
                            } ?>

                        </tbody>
                    </table>

                    <?php
                    /***********
                     * Bottom Pagination
                     */
                    ?>
                    <?php if ( ! @$search) { ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span>
                                <?php if (@$count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
                                <?php } ?>
                            </span>
                            <?php //echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <?php } ?>

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
									<button onclick="$('#form-tm_projects_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

                    <!-- BULK INACTIVATE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-de" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Deactivate!</h4>
								</div>
								<div class="modal-body"> Deactivate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-tm_projects_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ur" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">URGENT!</h4>
								</div>
								<div class="modal-body"> Set multiple items as URGENT? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-tm_projects_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-tm_projects_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

                    <!-- ADD TASK -->
                    <div id="todo-task-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content scroller" style="height: 100%;" data-always-visible="1" data-rail-visible="0">

                                <div class="modal-header">
                                    <button type="button" class="close tooltips" data-original-title="Cancel" data-placement="bottom" data-dismiss="modal" aria-hidden="true"></button>
                                    <p class="todo-task-modal-title todo-inline">Due:
                                        <input class="form-control input-inline input-medium date-picker todo-task-due todo-inline" size="16" type="text" value="" placeholder="Select date..." />
                                    </p>
                                    <p class="todo-task-modal-title todo-inline">Assign:
                                        <a class="todo-inline todo-task-assign" href="#todo-members-modal" data-toggle="modal">Select</a>
                                    </p>
                                </div>
                                <div class="modal-body todo-task-modal-body" style="padding-bottom:30px;">
                                    <h3 class="todo-task-modal-bg">
                                        <input class="form-control todo-task-title" type="text" value="" placeholder="Task title..." />
                                    </h3>
                                    <p class="todo-task-modal-bg">
                                        <textarea class="form-control todo-task-description" rows="15" placeholder="Description..."></textarea>
                                    </p>
                                </div>

                                <?php echo form_open(
                                    'admin/task_manager/tasks_add'
                                ); ?>

                                <input type="hidden" name="project_id" value="" />
                                <input type="hidden" name="due_date" value="" />
                                <input type="hidden" name="user_id" value="" />
                                <input type="hidden" name="title" value="" />
                                <textarea style="visibility:hidden;" name="description"></textarea>

                                <div class="modal-footer">
                                    <button class="btn default" data-dismiss="modal" aria-hidden="true" onclick="$('#todo-add-button-attach-input').val('');">Cancel</button>
                                    <button type="submit" class="btn dark">Submit</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->

                    <!-- ADD TASK -->
                    <div id="todo-members-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Select a Member</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="#" class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Selected Members</label>
                                            <div class="col-md-8">
                                                <select id="select2_sample2" class="form-control select2 select-height" multiple>

                                                    <?php
                                                    if (@$users)
                                                    {
                                                        foreach ($users as $user)
                                                        { ?>

                                                    <option value="<?php echo $user->id; ?>"><?php echo $user->fname.' '.$user->lname; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    { ?>

                                                    <option value="add_user">Add users first</option>

                                                        <?php
                                                    } ?>

                                                    <!--
                                                    <optgroup label="Senior Developers">
                                                        <option>Rudy</option>
                                                        <option>Shane</option>
                                                        <option>Sean</option>
                                                    </optgroup>
                                                    <optgroup label="Technical Team">
                                                        <option>Kathy</option>
                                                        <option>Luke</option>
                                                        <option>John</option>
                                                        <option>Darren</option>
                                                    </optgroup>
                                                    <optgroup label="Design Team">
                                                        <option>Bob</option>
                                                        <option>Carolina</option>
                                                        <option>Randy</option>
                                                        <option>Michael</option>
                                                    </optgroup>
                                                    <optgroup label="Testers">
                                                        <option>Chris</option>
                                                        <option>Louis</option>
                                                        <option>Greg</option>
                                                        <option>Ashe</option>
                                                    </optgroup>
                                                    -->
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                                    <button class="btn green todo-members-modal-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->
