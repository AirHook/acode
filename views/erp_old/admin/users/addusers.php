<div id="wrapper">    
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo base_url(); ?>admin/users/users" class="btn btn-success pull-right">Back</a>
            </div>
        </div>  
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php  $name = isset($user->id) ? 'Update User' : 'Add User'; ?>
                        <h4><?php echo $name ?></h4>
                    </div>
                    <div class="panel-body">
                    <?php 
                        $succ = $this->session->flashdata('success'); 
                        $up = $this->session->flashdata('error');
                        if(isset($succ)) {
                            echo "<div class='alert alert-dismissible alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$succ</div>";
                       } 
                       if(isset($up)){
                            echo "<div class='alert alert-dismissible alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$up</div>";
                        }

                        $check = isset($user->id) ? 'updateuser' : 'storeuser'; 
                        echo form_open_multipart('admin/users/'.$check);
                            if(isset($user->id)) {
                                echo "<input type='hidden' name='id' value='".$user->id."' />";
                            }
                    ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">First Name</label> 
                                <input type="text" id="name" name="first_name" placeholder="Enter first name" class="form-control" required value="<?php if(isset($user) && $user->first_name != '') echo $user->first_name?>">
                            </div>
                        </div>  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Last Name</label> 
                                <input type="text" id="name" name="last_name" placeholder="Enter last name" class="form-control" required value="<?php if(isset($user) && $user->last_name != '') echo $user->last_name?>">
                            </div>
                        </div>  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">User Name</label> 
                                <input type="text" id="name" name="username" placeholder="Enter unique username" class="form-control" required value="<?php if(isset($user) && $user->username != '') echo $user->username?>">
                            </div>
                        </div>    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label> 
                                <input type="email" placeholder="Enter email" class="form-control" name="email" value="<?php if(isset($user) && $user->email != '') echo $user->email?>">
                            </div>
                        </div>   
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone #</label> 
                                <input type="text" placeholder="Enter phone #" class="form-control" name="phone" value="<?php if(isset($user) && $user->phone != '') echo $user->phone?>">
                            </div>
                        </div>   
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Password</label> 
                                <input type="password" placeholder="Enter password" class="form-control" name="password">
                                <!-- value="<?php if(isset($user) && $user->password != '') echo $user->password ?>" -->
                            </div>
                        </div>   
                        <div class="col-sm-6" ">    
                            <div class="form-group">
                                <label>Profile Image</label> 
                                <?php
                                    $image = '';
                                    if(isset($user->profile_image)) {
                                        $image = $user->profile_image;
                                    }
                                    if(isset($user->profile_image)) {
                                    echo '<img class="show_form_pic" style="width: 120px;" src="'.base_url($image).'" />'; }?>
                                    <input type="file" name="profile_image" class="form-control m-b" onchange="document.querySelector('.show_form_pic').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>  
                        <div class="col-sm-12">
                            <input type="submit" name="submit" value="Submit" class="btn btn-sm btn-primary m-t-n-xs pull-right ">
                        </div>
                        <?php form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

