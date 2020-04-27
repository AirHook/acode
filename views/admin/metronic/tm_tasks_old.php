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

                <ul class="todo-tasks-content">

                    <?php if ($tasks)
                    {
                        $i = 1;
                        foreach ($tasks as $task)
                        { ?>

                    <li class="todo-tasks-item">
                        <h4 class="todo-inline">
                            <small><?php echo $i; ?>. </small>
                            &nbsp;
                            <a href="<?php echo site_url('admin/task_manager/task_details/index/'.$task->task_id); ?>">
                                <?php echo $task->title; ?>
                            </a>
                        </h4>
                        <p class="todo-inline todo-float-r">
                            <?php echo $task->fname ? $task->fname.',' : ''; ?>
                            <span class="todo-<?php echo $task->date_end_target < strtotime('tomorrow') ? 'red' : 'green'; ?>">

                                <?php if ($task->date_end_target > strtotime('today') && $task->date_end_target < strtotime('tomorrow'))
                                {
                                    echo 'TODAY';
                                }
                                else
                                {
                                    echo date('M j, Y', $task->date_end_target);
                                } ?>

                            </span>
                        </p>
                    </li>

                            <?php
                        }

                        $i++;
                    }
                    else
                    { ?>

                    <li class="todo-tasks-item">
                        <h4 class="todo-inline">
                            No tasks for this project. <button class="btn btn-square btn-sm red" data-toggle="modal" href="#todo-task-modal">New Task</button>
                        </h4>
                        <p class="todo-inline todo-float-r hide">Bob,
                            <span class="todo-red">TODAY</span>
                        </p>
                    </li>

                    <!-- DOC: Sample list --
                    <li class="todo-tasks-item">
                        <h4 class="todo-inline">
                            <a data-toggle="modal" href="#todo-task-modal">Design for full featured ToDo Page with something</a>
                        </h4>
                        <p class="todo-inline todo-float-r">Bob,
                            <span class="todo-red">TODAY</span>
                        </p>
                    </li>
                    <li class="todo-tasks-item">
                        <h4 class="todo-inline">
                            <a data-toggle="modal" href="#todo-task-modal">Owl carousel pagination animation issue(clients logo, testimonials)</a>
                        </h4>
                        <p class="todo-inline todo-float-r">Shane,
                            <span class="todo-green">01 OCT</span>
                        </p>
                    </li>
                    -->

                        <?php
                    } ?>

                </ul>
            </div>
        </div>
    </div>

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
                    'admin/task_manager/tasks_add/index/'.$project_details->project_id
                ); ?>

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

</div>
