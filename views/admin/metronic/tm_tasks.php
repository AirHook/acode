<?php
/*********
 * TASK MANAGER CONTAINER
 */
?>
<div class="todo-container">
    <div class="row">

        <div class="col-md-12">

            <?php
            /***********
             * Noification area
             */
            ?>
            <div class="notifcations">
                <?php if ($this->session->flashdata('success') == 'add') { ?>
                <div class="alert alert-success ">
                    <button class="close" data-close="alert"></button> New Task ADDED!
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
                    <button class="close" data-close="alert"></button> Tasks(s) successfully removed.
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

            <div class="todo-tasks-container">
                <div class="todo-head">
                    <button class="btn btn-square btn-sm red todo-bold" data-toggle="modal" href="#todo-task-modal">New Task</button>
                    <h3>
                        <span class="todo-grey">Tasks for Project:</span> <?php echo $project_details->name; ?>
                    </h3>
                    <!--
                    <p class="todo-inline hide">
                        22 Members
                        <a class="todo-add-button" href="#todo-members-modal" data-toggle="modal">+</a>
                    </p>
                    -->
                </div>

                <?php if ($project_details->description)
                { ?>

                <p>
                    DESCRIPTION:<br /><br />
                    <?php echo $project_details->description; ?>
                </p>

                    <?php
                } ?>

                <?php if ($tasks)
                { ?>

                <p>TASKS:</p>

                <!-- Tasks -->
                <div class="dd nestable_list">
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
                                $past_due = $task->date_end_target < strtotime('today') ? 'color:red;' : '';
                                if ($task->status == '2') $past_due = 'color:#ccc;';
                                $due_date =
                                    $task->date_end_target == '0'
                                    ? ' - <cite class="small">(no due date)</cite>'
                                    : ' - <span style="'.$past_due.'">'.date('M j, Y', $task->date_end_target).'</span>'
                                ;
                            }

                            $assigned_user =
                                trim($task->fname.' '.$task->lname)
                                ?: '<cite class="small">(no assigned user)</cite>'
                            ;

                            $details_link = site_url('admin/task_manager/task_details/index/'.$task->task_id);
                            $edit_link = site_url('admin/task_manager/task_edit/index/'.$task->task_id);
                            ?>

                        <li class="dd-item dd3-item" data-task_id="<?php echo $task->task_id; ?>">

                            <div class="dd-handle dd3-handle"> </div>
                            <div class="dd3-content <?php echo $task->status == '2' ? 'tooltips' : ''; ?>" data-original-title="Complete">
                                <a href="<?php echo $details_link; ?>" style="display:inline-block;width:87%;color:black;">
                                    <!-- User -->
                                    <span class="pull-right" style="<?php echo $task->status == '2' ? 'color:#ccc;text-decoration:line-through;' : ''; ?>">
                                        <?php echo $assigned_user.$due_date; ?>
                                    </span>
                                    <!-- Task -->
                                    <span style="width:60%;display:inline-block;overflow:hidden;<?php echo $task->status == '2' ? 'color:#ccc;text-decoration:line-through;' : ''; ?>">
                                        <?php
                                        $title = '<span class="t_no">'.$t.'</span>. '.$task->title;
                                        if (strlen($title) > 80)
                                        {
                                            $title = substr($title, 0, 80).'...<cite class="small">(more)</cite>';
                                        }
                                        echo $title;
                                        ?>
                                        <?php echo $task->urgent == '1' ? '<cite class="font-red"><strong>URGENT!</strong></cite>' : ''; ?>
                                    </span>
                                </a>
                                <!-- Actions -->
                                <span class="<?php echo $task->status == '2' ? 'hide' : ''; ?>" style="position:relative;top:-6px;color:<?php echo $task->status == '2' ? '#ccc' : 'black'; ?>;text-decoration:none;margin-left:10px;">
                                    - &nbsp;
                                    <!-- Details -->
                                    <a href="<?php echo $details_link; ?>" style="color:black;text-decoration:none;">
                                        <i class="fa fa-eye small tooltips" data-original-title="View Details"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a href="javascript:;" style="color:black;text-decoration:none;">
                                        <i class="fa fa-pencil small tooltips" data-original-title="Edit"></i>
                                    </a>
                                    <!-- Accept -->
                                    <a data-toggle="modal" href="#accept-<?php echo $task->task_id?>" style="color:black;text-decoration:none;" data-assign="<?php echo $task->user_id; ?>" class="<?php echo $task->status != '1' ?: 'display-none'; ?>">
                                        <i class="fa fa-check-square-o small tooltips" data-original-title="Accept Task"></i>
                                    </a>
                                    <!-- Unaccept -->
                                    <a data-toggle="modal" href="#unaccept-<?php echo $task->task_id?>" style="color:black;text-decoration:none;"  data-assign="<?php echo $task->user_id; ?>" class="<?php echo $task->status == '1' ?: 'display-none'; ?>">
                                        <i class="fa fa-minus-square-o small tooltips" data-original-title="Unaccept Task"></i>
                                    </a>
                                    <!-- Complete -->
                                    <a data-toggle="modal" href="#complete-<?php echo $task->task_id?>" style="color:black;text-decoration:none;">
                                        <i class="fa fa-check small tooltips" data-original-title="Complete"></i>
                                    </a>
                                    <!-- Urgent -->
                                    <a data-toggle="modal" href="#urgent-<?php echo $task->task_id?>" style="color:black;text-decoration:none;" class="<?php echo $task->urgent != '1' ?: 'display-none'; ?>">
                                        <i class="fa fa-exclamation-triangle small tooltips" data-original-title="Set Urgent"></i>
                                    </a>
                                    <a data-toggle="modal" href="#unurgent-<?php echo $task->task_id?>" style="color:red;text-decoration:none;" class="<?php echo $task->urgent == '1' ?: 'display-none'; ?>">
                                        <i class="fa fa-exclamation-triangle small tooltips" data-original-title="Restore Normal"></i>
                                    </a>
                                    <!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $task->task_id?>" style="color:black;text-decoration:none;">
                                        <i class="fa fa-trash small tooltips" data-original-title="Delete"></i>
                                    </a>

                                </span>
                            </div>

                            <!-- ITEM COMPLETE -->
                            <div class="modal fade bs-modal-sm" id="complete-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Update Item Info</h4>
                                        </div>
                                        <div class="modal-body"> Are you sure task is already COMPLETE? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <a href="<?php echo site_url('admin/task_manager/task_edit/complete/'.$task->task_id.'/'.$project_details->project_id.'/2'); ?>" type="button" class="btn green">
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
                            <!-- ITEM URGENT -->
                            <div class="modal fade bs-modal-sm" id="urgent-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Update Item Info</h4>
                                        </div>
                                        <div class="modal-body"> Are you sure you want to set item to URGENT? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <a href="<?php echo site_url('admin/task_manager/task_edit/urgent/'.$task->task_id.'/'.$project_details->project_id.'/1'); ?>" type="button" class="btn green">
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
                            <!-- ITEM UNURGENT -->
                            <div class="modal fade bs-modal-sm" id="unurgent-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Update Item Info</h4>
                                        </div>
                                        <div class="modal-body"> Restore urgent status to NORMAL? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <a href="<?php echo site_url('admin/task_manager/task_edit/urgent/'.$task->task_id.'/'.$project_details->project_id.'/0'); ?>" type="button" class="btn green">
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
                            <div class="modal fade bs-modal-sm" id="delete-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Warning!</h4>
                                        </div>
                                        <div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <a href="<?php echo site_url('admin/task_manager/task_edit/delete/'.$task->task_id.'/'.$project_details->project_id); ?>" type="button" class="btn green">
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
                            <!-- ACCEPT TASK -->
                            <div class="modal fade bs-modal-md" id="accept-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Who is this?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Please select yourself</label>
                                                    <div class="col-md-8">
                                                        <select id="assign-user-<?php echo $task->task_id?>" class="form-control select2 select-height" multiple>

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

                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                                            <button class="btn dark todo-user-accept-modal-submit" data-task_id="<?php echo $task->task_id; ?>" data-project_id="<?php echo $project_details->project_id; ?>">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                            <!-- UNACCEPT TASK -->
                            <div class="modal fade bs-modal-sm" id="unaccept-<?php echo $task->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Unaccept Task!</h4>
                                        </div>
                                        <div class="modal-body"> Are you sure you want to unaccept the task? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <a href="<?php echo site_url('admin/task_manager/task_edit/unaccept/'.$task->task_id.'/'.$project_details->project_id); ?>" type="button" class="btn green">
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
                </div>

                    <?php
                } ?>

            </div>
        </div>
    </div>

    <!-- ADD TASK -->
    <div id="todo-task-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content scroller" style="height: 100%;" data-always-visible="1" data-rail-visible="0">

                <!-- BEGIN FORM-->
                <!-- FORM =======================================================================-->
                <?php echo form_open(
                    'admin/task_manager/tasks_add'
                ); ?>

                <input type="hidden" name="project_id" value="<?php echo $project_details->project_id; ?>" />
                <input type="hidden" name="due_date" value="" />
                <input type="hidden" name="user_id" value="" />
                <input type="hidden" name="title" value="" />

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
                        <textarea class="form-control todo-task-description summernote" id="summernote_1" name="description" rows="15" placeholder="Description..."></textarea>
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn default" data-dismiss="modal" aria-hidden="true" onclick="$('#todo-add-button-attach-input').val('');">Cancel</button>
                    <button type="submit" class="btn dark">Submit</button>
                </div>

                </form>
                <!-- FORM =======================================================================-->
                <!-- END FORM-->

            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- SELECT ASSIGN USER -->
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
                            <label class="control-label col-md-4">Assign a user to the task (optional)</label>
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

</div>
