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
                    <button class="btn btn-square btn-sm dark todo-bold todo-inline">Complete Task</button>
                    <p class="todo-task-modal-title todo-inline">
                        Due: &nbsp; <?php echo date('M j, Y', $task_details->date_end_target); ?>
                    </p>
                    <p class="todo-task-modal-title todo-inline">
                        Champion: &nbsp; <?php echo $task_details->fname.' '.$task_details->lname; ?>
                    </p>
                </div>
                <?php
                /*********
                 * BODY
                 */
                ?>
                <div class="modal-body todo-task-modal-body">
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

                        <div class="col-md-2">
                            <div class="thumbnail" style="width:140px;height:95px;overflow:hidden;margin-bottom:5px;">
                                <a href="<?php echo base_url().$attachment->media_url; ?>" class="fancybox-button" data-fancybox data-rel="fancybox-button" data-options='{"autoResize":"false","fitToView":"false"}'>
                                    <img src="<?php echo base_url().$attachment->media_url; ?>" alt="" />
                                </a>
                            </div>
                            <a href="<?php echo base_url().$attachment->media_url; ?>" download> <cite class="small"><i class="fa fa-download font-dark"></i></cite> </a>
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
                            <span class="caption-subject font-hide bold uppercase">Correspondeces</span>
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
                                <select class="form-control select2m" name="user_id" style="width:15%!important;float:left;" >

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
                                <input class="form-control" type="text" style="width:85%!important;" name="message" placeholder="Type your message here..." />
                            </div>
                            <div class="btn-cont">
                                <span class="arrow" style="border-right: 8px solid #2f353b;"> </span>
                                <button type="submit" class="btn dark icn-only">
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

    </div>
</div>
