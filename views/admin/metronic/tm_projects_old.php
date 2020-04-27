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
                    <button class="close" data-close="alert"></button> New Project ADDED!
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
                    <button class="close" data-close="alert"></button> Project(s) successfully removed.
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

            <ul class="todo-projects-container">
                <li class="todo-padding-b-0">
                    <div class="todo-head">
                        <button class="btn btn-square btn-sm dark todo-bold" data-toggle="modal" href="#modal-tm_add_project">Add Project</button>
                        <a href="<?php echo site_url('admin/task_manager/users'); ?>" class="btn btn-square btn-sm default todo-bold" style="margin-right:5px;float:right;">Add User</a>
                        <h3>Projects</h3>
                        <p class="additional-info"></p>
                    </div>
                </li>

                <?php
                /*********
                 * PROJECT LIST
                 */
                ?>

                <?php if (@$projects)
                {
                    foreach ($projects as $project)
                    { ?>

                <li class="todo-projects-item todo-link" data-href="<?php echo site_url('admin/task_manager/tasks/index/'.$project->project_id); ?>">
                    <h3>
                        <?php echo $project->name; ?>
                    </h3>
                    <p>
                        <?php echo $project->description; ?>
                    </p>
                    <div class="todo-project-item-foot">
                        <p class="todo-red todo-inline">17 Tasks Remaining</p> <!-- Number of Tasks -->
                        <p class="todo-inline todo-float-r hide">
                            1 Responsible
                            <a class="todo-add-button" href="#todo-members-modal" data-toggle="modal">+</a>
                        </p> <!-- Number users involved -->
                    </div>
                </li>

                        <?php
                    }
                }
                else
                { ?>

                <li class="todo-projects-item">
                    <h3>No Projects on record</h3>
                    <p>
                        Add a project now. <button class="btn btn-square btn-sm dark todo-bold" data-toggle="modal" href="#modal-tm_add_project">Add Project</button>
                    </p>
                </li>

                <!-- Sample Project List
                <!-- DOC: A divider <div> separates each list with the last item having no more <div> after
                <li class="todo-projects-item">
                    <h3>Metronic Admin Reborn</h3>
                    <p>Lorem dolor sit amet ipsum dolor sit consectetuer dolore. Lorem dolor sit amet ipsum dolor sit consectetuer dolore.</p>
                    <div class="todo-project-item-foot">
                        <p class="todo-red todo-inline">17 Tasks Remaining</p> <!-- Number of Tasks --
                        <p class="todo-inline todo-float-r">
                            16 Members
                            <a class="todo-add-button" href="#todo-members-modal" data-toggle="modal">+</a>
                        </p> <!-- Number users involved --
                    </div>
                </li>
                <div class="todo-projects-divider"></div>
                <!-- DOC: Class "todo-active" shows the task on right side --
                <!-- DOC: Will link this to the task list page instead --
                <li class="todo-projects-item todo-active">
                    <h3 class="todo-blue">Williams Logistics CRM</h3>
                    <p>Lorem dolor sit amet ipsum dolor sit consectetuer dolore. Lorem dolor sit amet ipsum dolor sit consectetuer dolore.</p>
                    <div class="todo-project-item-foot">
                        <p class="todo-red todo-inline">43 Tasks Remaining</p> <!-- Number of Tasks --
                        <p class="todo-inline todo-float-r">
                            32 Members
                            <a class="todo-add-button" href="#todo-members-modal" data-toggle="modal">+</a>
                        </p> <!-- Number users involved --
                    </div>
                </li>
                -->
                    <?php
                } ?>
            </ul>
        </div>

        <!-- ADD PROJECT -->
		<div class="modal fade bs-modal-lg" id="modal-tm_add_project" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open(
                        'admin/task_manager/projects_add',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-tm_add_project')); ?>

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Add New Porject</h4>
					</div>
					<div class="modal-body">

							<div class="form-group">
								<label class="col-md-3 control-label">Project Name:
									<span class="required"> * </span>
								</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="name" placeholder="">
									<span class="help-block">Give this project a friendly name...</span>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-md-3 control-label">Short Description:
								</label>
								<div class="col-md-9">
                                    <textarea class="form-control" name="description" rows="7"></textarea>
									<span class="help-block">A summary or a short description of the project...</span>
								</div>
							</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Cancel</button>
						<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
							<span class="ladda-label">Confirm?</span>
							<span class="ladda-spinner"></span>
						</button>
					</div>

					</form>
					<!-- End FORM =======================================================================-->
					<!-- END FORM-->

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

    </div>
</div>
