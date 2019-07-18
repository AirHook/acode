<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content"> 
                <span class="pull-right">
                    <!-- <a  href="<?php echo base_url('accounting/admin/creatUser') ?>" data-controller="users" data-action="addUser" data-title="Create New User" class="btn btn btn-primary "> <i class="fa fa-plus"></i> Add New</a> -->
                    </span>
                    <h2>
                      User Roles
                    </h2>
                    <div class="clearfix"></div>
                    <?php $controller=& get_instance();
                          $controller->showFlash();
                     ?>
                    <div class="clients-list">
                        <div class="full-height-scroll">
                            <form method="POST" action="<?php echo base_url('accounting/roles/saveUserRole'); ?>">
                            <?php if(isset($model->id)): ?>
                                <input type="hidden" name="id" value="<?php echo $model->id; ?>">
                            <?php endif; ?>
                            <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
                            <h3>Create User Role</h3>
                            <div class="row">  
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo isset($model->name) ? $model->name : ''; ?>" placeholder="Role Name" name="name">
                                </div> 
                                <div class="col-sm-2">
                                    <select class="form-control" name="is_active">
                                        <option value="1" <?php echo (isset($model->is_active) && $model->is_active == 1) ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo (isset($model->is_active) && $model->is_active == 0) ? 'selected' : ''; ?>>Not Active</option>
                                    </select>
                                </div>   
                                <div class="col-sm-2">
                                    <input type="submit" class="form-control btn btn-sm btn-success" name="submit" value="Save">
                                </div>   
                            </div>
                        </form>
                        <br>
                        <table id="" class="dataTables1 table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $serial_no=1;
                            if(!empty($roles)) {
                             foreach ($roles as $key => $single_user) { ?>
                                <tr>
                                    <td><?php echo $serial_no++; ?></td>
                                    <td><?php echo $single_user->name;?></td>
                                    <td>
                                        <?php
                                            if(isset($single_user->is_active) && $single_user->is_active == 0){?>
                                            <span>Not Active</span>
                                         <?php } else {?>
                                         <span>Active</span>
                                         <?php } ?>
                                    </td>
                                    <td>
                                       <div class='btn-group'>
                                          <a class="btn btn-sm btn-info" href="<?php echo base_url('accounting/roles/index')."/". $single_user->id?>" title="Edit User role"><i class="fa fa-edit"></i></a>
                                           <a href='<?php echo base_url(); ?>accounting/roles/deleteUserRole/<?php echo $single_user->id; ?>' class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></a>
                                        </div>
                                     </td>
                                </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
