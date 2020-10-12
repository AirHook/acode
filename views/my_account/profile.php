<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                    <div class="scroll-element full-height-scroll">
                        <div class="row">
                            <div class="col-sm-12">
                            <!-- <div class="row">
                                <div class="col-sm-12">
                                    <a href="#" class="pull-right btn btn-info"><i class="fa fa-reply">Go Back</i></a>
                                </div>
                            </div>
                            <br> -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span>
                                           <?php $controller->showFlash();
                                            ?>
                                         </span>
                                        <div class="panel panel-info">
                                            <div class="panel panel-heading">
                                               Profile
                                            </div>
                                            <div class="panel panel-body">
                                                <form action="<?php echo base_url('my_account/profile/index') ?>" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control" placeholder="Email" required="" name="admin_sales_email" value="<?php  echo  isset($profiledata->admin_sales_email) ? $profiledata->admin_sales_email :'';?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input type="text" class="form-control" placeholder="First Name" name="admin_sales_user" required="" value="<?php  echo isset($profiledata->admin_sales_user) ? $profiledata->admin_sales_user :'';?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input type="text" class="form-control" required="" placeholder="Last Name" name="admin_sales_lname" value="<?php  echo isset($profiledata->admin_sales_lname) ? $profiledata->admin_sales_lname :'';?>"> 
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="text" class="form-control" required="" placeholder="Password" name="admin_sales_password" value="<?php  echo isset($profiledata->admin_sales_password) ? $profiledata->admin_sales_password :'';?>"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-info">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    