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
                    <button class="close" data-close="alert"></button> Information successfully updated!
                </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error') == 'add') { ?>
                <div class="alert alert-danger ">
                    <button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
                </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error') == 'edit') { ?>
                <div class="alert alert-danger ">
                    <button class="close" data-close="alert"></button> The message fields where not properly filled. Please try again.
                </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success') == 'attach') { ?>
                <div class="alert alert-success ">
                    <button class="close" data-close="alert"></button> Files attached to task.
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
                <?php
                /*********
                 * HEADER
                 */
                ?>
                <div class="todo-head">

                    <?php if ($task_details->status == '2')
                    { ?>

                    <button onclick="location.href='<?php echo site_url('admin/task_manager/task_edit/reopen/'.$task_details->task_id); ?>';" class="btn btn-square btn-sm dark todo-bold todo-inline" style="margin-right:2em;">Re-Open Task</button>

                        <?php
                    }
                    else
                    { ?>

                    <button data-toggle="modal" href="#complete-<?php echo $task_details->task_id; ?>" class="btn btn-square btn-sm dark todo-bold todo-inline" style="margin-right:2em;">Complete Task</button>
                    <button data-toggle="modal" href="#todo-task-modal" class="btn btn-square btn-sm grey todo-bold todo-inline" style="margin-right:5px;">Edit</button>

                        <?php
                    } ?>

                    <a class="btn btn-secondary-outline font-dark todo-bold todo-inline" href="<?php echo site_url('admin/task_manager/tasks/index/'.$task_details->project_id); ?>">
                        <i class="fa fa-reply"></i> Back to task list</a>

                    <p class="todo-task-modal-title todo-inline">

                        Due: &nbsp; <input class="form-control input-inline input-medium date-picker todo-details-task-due todo-inline" type="text" value="<?php echo $task_details->date_end_target ? date('M j, Y', $task_details->date_end_target) : ''; ?>" placeholder="Select date..." data-date-format="MM d, yyyy" style="width:150px !important;" <?php echo $task_details->status == '2' ? 'disabled' : '';?> />

                    </p>
                    <p class="todo-task-modal-title todo-inline">

                        Champion: &nbsp; <button class="btn <?php echo $task_details->fname ? 'default' : 'btn-outline'; ?> todo-task-assign" data-toggle="modal" href="#todo-members-modal" <?php echo $task_details->status == '2' ? 'disabled' : '';?>><?php echo $task_details->fname ? $task_details->fname.' '.$task_details->lname : 'Select'; ?></button>

                    </p>
                </div>
                <?php
                /*********
                 * BODY
                 */
                ?>
                <div class="modal-body todo-task-modal-body">

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notifcations">
                        <div class="alert alert-danger <?php echo $task_details->urgent ?: 'display-none';?>">
                            <button class="close hide" data-close="alert"></button>
                            This item is <strong>Urgent!</strong>
                        </div>
                        <div class="alert alert-success <?php echo $task_details->status == '2' ?: 'display-none';?>">
                            <button class="close hide" data-close="alert"></button>
                            This item is compmlete and <strong>CLOSED!</strong>
                        </div>
                    </div>

                    <?php
                    /*********
                     * TASK TITLE
                     */
                    ?>
                    <h3 class="todo-task-modal-bg">
                        <?php echo $task_details->title; ?>
                    </h3>
                    <?php
                    /*********
                     * TASK DESCRIPTION
                     */
                    ?>
                    <p class="todo-task-modal-bg">
                        <?php echo $task_details->description; ?>
                    </p>
                    <br />
                    <br />
                    <?php
                    /*********
                     * TASK ASSETS
                     */
                    ?>
                    <style>
                        .todo-add-button {
                            float: none;
                        }
                    </style>
                    <h4>Attach File
                        <a class="todo-add-button" data-toggle="modal" href="#modal-upload_images">+</a>
                    </h4>
                    <div class="todo-task-file-container row margin-top-20">

                        <?php if (@$attachments)
                        {
                            foreach ($attachments as $attachment)
                            { ?>

                        <div class="col-md-2" style="overflow:hidden;">
                            <div class="thumbnail" style="width:140px;height:95px;overflow:hidden;margin-bottom:5px;">
                                <a href="<?php echo base_url().$attachment->media_url; ?>" class="fancybox-button" data-fancybox data-rel="fancybox-button" data-options='{"autoResize":"false","fitToView":"false"}'>
                                    <img src="<?php echo base_url().$attachment->media_url; ?>" alt="<?php echo $attachment->media_filename; ?>" />
                                </a>
                            </div>
                            <a href="<?php echo base_url().$attachment->media_url; ?>">
                                <i class="fa fa-download font-dark tooltips" data-original-title="Download"></i>
                                <?php echo trim($attachment->media_dimensions) == 'x' ? '<small title="'.$attachment->media_filename.'">'.$attachment->media_filename.'</small>' : ''; ?>
                            </a>
                            <?php echo trim($attachment->media_dimensions) == 'x' ? '<br />' : ''; ?>
                            <a href="<?php echo site_url('remove_file'); ?>" class="hide">
                                <i class="fa fa-trash font-dark tooltips" data-original-title="Delete"></i>
                                <?php echo trim($attachment->media_dimensions) == 'x' ? '<small title="'.$attachment->media_filename.'">'.$attachment->media_filename.'</small>' : ''; ?>
                            </a>
                        </div>

                                <?php
                            }
                        } ?>

                    </div>

                </div>
                <!-- BEGIN PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bubble font-hide hide"></i>
                            <span class="caption-subject font-hide bold uppercase">Correspondece and Team Notes</span>
                        </div>
                    </div>
                    <div class="portlet-body" id="chats">
                        <!--<div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1">-->
                        <div class="">
                            <ul class="chats" style="min-height:150px;">

                                <?php if (@$chats)
                                {
                                    foreach ($chats as $chat)
                                    {
                                        if (strtotime('today') == strtotime(date('Y-m-d', $chat->date_sent)))
                                        {
                                            // if today...
                                            $datetime = date('g:i a', $chat->date_sent).' Today';
                                        }
                                        else
                                        {
                                            $datetime = date('F j, Y g:i a', $chat->date_sent);
                                        }
                                        ?>

                                <li class="in">
                                    <div class="message" style="margin-left:0px;">
                                        <a href="javascript:;" class="name"> <?php echo $chat->fname.' '.$chat->lname; ?> </a>
                                        <span class="datetime"> at <?php echo $datetime; ?> </span>
                                        <span class="body"> <?php echo $chat->message; ?> </span>
                                    </div>
                                </li>

                                        <?php
                                    }
                                }
                                else
                                { ?>

                                <li class="in">
                                    <div class="message" style="margin-left:0px;">
                                        <a href="javascript:;" class="name"> Admin </a>
                                        <span class="datetime"> at 0:00 am Today </span>
                                        <span class="body"> Type a brief message below regarding this task and post it so that the others can read it. </span>
                                    </div>
                                </li>

                                    <?php
                                } ?>

                                <!-- DOC: a sample correspondence from original template --
                                <li class="out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"> </span>
                                        <a href="javascript:;" class="name"> Lisa Wong </a>
                                        <span class="datetime"> at 20:11 </span>
                                        <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                    </div>
                                </li>
                                <li class="out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"> </span>
                                        <a href="javascript:;" class="name"> Lisa Wong </a>
                                        <span class="datetime"> at 20:11 </span>
                                        <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                    </div>
                                </li>
                                -->
                            </ul>
                        </div>

                        <!-- FORM open =========================================================-->
                        <?php echo form_open(
                            'admin/task_manager/chats_add/index/'.$task_details->task_id,
                            array(
                                'id' => 'form-send_correspondence'
                            )
                        ); ?>

                        <input type="hidden" name="task_id" value="<?php echo $task_details->task_id; ?>" />

                        <div class="chat-form">
                            <div class="input-cont">
                                <select class="form-control select2m" name="user_id" style="width:15%!important;float:left;" <?php echo $task_details->status == '2' ? 'disabled' : '';?>>

                                    <option value="">Select...</option>

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
                                <input class="form-control" type="text" style="width:85%!important;" name="message" placeholder="Type your message here..." <?php echo $task_details->status == '2' ? 'disabled' : '';?> />
                            </div>
                            <div class="btn-cont">
                                <span class="arrow" style="border-right: 8px solid <?php echo $task_details->status == '2' ? '#2f353b' : '#2f353b';?>;"> </span>
                                <button type="submit" class="btn dark icn-only" <?php echo $task_details->status == '2' ? 'disabled' : '';?>>
                                    <i class="fa fa-check icon-white"></i>
                                </button>
                            </div>
                        </div>

                        </form>
                        <!-- FORM close ========================================================-->

                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>

        <!-- ITEM COMPLETE -->
        <div class="modal fade bs-modal-sm" id="complete-<?php echo $task_details->task_id?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Update Item Info</h4>
                    </div>
                    <div class="modal-body"> Are you sure task is already COMPLETE? </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <a href="<?php echo site_url('admin/task_manager/task_details/complete/'.$task_details->task_id); ?>" type="button" class="btn green">
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

        <!-- UPLOAD IMAGES -->
        <div class="modal fade bs-modal-md" id="modal-upload_images" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
                        <h4 class="modal-title">Attach Files</h4>
                    </div>
                    <div class="modal-body">

                        <div class="m-heading-1 border-green m-bordered">
                            <p> Files are uploaded automatically after full progress and check appears momentarily. </p>
                        </div>

                        <div class="row margin-bottom-10">
                            <div class="col col-md-12">

                                <?php echo form_open(
                                    'admin/task_manager/uploads',
                                    array(
                                        'class'=>'dropzone dropzone-file-area',
                                        'id'=>'my-dropzone-attach',
                                        'enctype'=>'multipart/form-data'
                                    )
                                ); ?>

                                    <input type="hidden" name="task_id" value="<?php echo $task_details->task_id; ?>" />
                                    <h4 class="sbold"> Attach File </h4>

                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo site_url('admin/task_manager/task_details/index/'.$task_details->task_id); ?>" class="btn dark">Close</a>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
                                <label class="control-label col-md-4">Assign a user to the task</label>
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
                        <button class="btn green todo-details-members-modal-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- EDIT TASK -->
        <div id="todo-task-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content scroller" style="height: 100%;" data-always-visible="1" data-rail-visible="0">

                    <div class="modal-header">
                        <button type="button" class="close tooltips" data-original-title="Cancel" data-placement="bottom" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Edit Task Details</h4>
                    </div>

                    <!-- FORM open =========================================================-->
                    <?php echo form_open(
                        'admin/task_manager/task_edit'
                    ); ?>

                    <input type="hidden" name="task_id" value="<?php echo $task_details->task_id; ?>" />

                    <div class="modal-body todo-task-modal-body" style="padding-bottom:30px;">
                        <h3 class="todo-task-modal-bg">
                            <input class="form-control todo-task-title" name="title" type="text" value="<?php echo $task_details->title; ?>" placeholder="Task title..." />
                        </h3>
                        <p class="todo-task-modal-bg">
                            <textarea class="form-control todo-task-description summernote" name="description" id="summernote_1" rows="15" placeholder="Description..."><?php echo $task_details->description; ?></textarea>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button type="submit" class="btn dark">Submit</button>
                    </div>

                    </form>
                    <!-- FORM close ========================================================-->

                </div>
            </div>
        </div>
        <!-- /.modal -->

    </div>
</div>
