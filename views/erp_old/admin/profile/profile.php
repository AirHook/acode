<div id="wrapper">

    <div class="normalheader ">

        <div class="hpanel">

            <div class="panel-body">

                <a class="small-header-action" href="#">

                    <div class="clip-header"><i class="fa fa-arrow-up"></i></div>

                </a> 

                <div id="hbreadcrumb" class="pull-right m-t-lg" style="margin-right: 20px;">

                    <!-- <ol class="hbreadcrumb breadcrumb">

                        <li><a href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>

                        <li>

                           <a href="<?php echo base_url('profile') ?>"> <span>Profile</span></a>

                        </li>

                    </ol> -->

                </div>

                <h2 class="font-light m-b-xs">

                    <?php echo ucwords($user->first_name).' '.ucwords($user->last_name) ; ?>

                </h2>

                <small></small>

            </div>

        </div>

    </div>

<div class="content">    
    <div class="row">
        <div class="col-sm-12">
            <?php 

        $succ = $this->session->flashdata('success'); 

        $up = $this->session->flashdata('error');

        if(isset($succ)) {

            echo "<div class='alert alert-dismissible alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$succ</div>";

        } 

        if(isset($up)){

            echo "<div class='alert alert-dismissible alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$up</div>";

        }?>
        </div>
    </div>
    <div class="row">
        
        <div class="col-lg-4">

            <div class="hpanel hgreen">

                <div class="panel-body">

                    <img alt="profile image" class="img-circle" style="margin: auto;display: block;width: 220px;height: 200px;border-radius: 0 !important;" src="<?php echo base_url($user->profile_image); ?>">

                    <form method="post" action="<?php echo base_url();?>admin/Profile/updateprofileimage" enctype="multipart/form-data">

                        <?php 

                        if(isset($user->id)) {

                            echo "<input type='hidden' name='id' value='".$user->id."' />";

                        }?>

                        <div class="col-sm-9" style="padding-top: 20px;">

                            <div class="form-group">

                                <!-- <input type="file" class="form-control m-b" name="profile_image"> -->

                               <input type="file" class="filestyle" name="profile_image" data-buttonName="btn-primary" required="">

                            </div> 

                        </div>

                        <div class="col-sm-3" style=" margin-top: 27px;">

                            <input type="submit" name="submit" value="Save Image" class="btn btn-sm btn-primary m-t-n-xs pull-right ">

                        </div>

                    </form>

                </div>    

            </div>

        </div>

        <div class="col-lg-8">

            <div class="hpanel hgreen">

                    <div class="tab-content">

                        <div id="tab-1" class="tab-pane active">

                            <div class="panel-body">

                                <div class="table-responsive">

                                    <!-- <form action="profile_submit" method="get" accept-charset="utf-8"> -->

                                    

                                    <?php  $this->load->helper( 'form' );

                                    echo form_open('admin/Profile/updateprofile');

                                        if(isset($user->id)) {

                                            echo "<input type='hidden' name='id' value='".$user->id."' />";

                                        }?>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="name">First Name</label> 

                                                <input type="text" name="first_name" placeholder="Enter first name" class="form-control" required value="<?php if(isset($user) && $user->first_name != '') echo $user->first_name?>">

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="name">Last Name</label> 

                                                <input type="text" name="last_name" placeholder="Enter last name" class="form-control" required value="<?php if(isset($user) && $user->last_name != '') echo $user->last_name?>">

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="name">User Name</label> 

                                                <input type="text" name="username" placeholder="Enter user name" class="form-control" required value="<?php if(isset($user) && $user->username != '') echo $user->username?>">

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="name">Email</label> 

                                                <input type="text" name="email" placeholder="Enter email" class="form-control" required value="<?php if(isset($user) && $user->email != '') echo $user->email?>">

                                            </div>

                                        </div> 

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="name">Phone #</label> 

                                                <input type="text"  name="phone" placeholder="Enter contact number" class="form-control" required value="<?php if(isset($user) && $user->phone != '') echo $user->phone?>">

                                            </div>

                                        </div> 

                                        <div class="col-sm-12">

                                            <input type="submit" name="submit" value="Update Profile" class="btn btn-sm btn-primary m-t-n-xs pull-right ">

                                        </div>

                                    <!-- </form>     -->

                                    <?php form_close();?> 

                                </div>

                            </div>

                        </div>

                    </div>      

            </div>

        </div>            
    </div>
</div>
    