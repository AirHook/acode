<div id="wrapper">    
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo base_url(); ?>admin/users/users" class="btn btn-success pull-right">Back</a>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <span>
                <?php 
                $success=$this->session->flashdata('success');
                if (isset($success)){
                  echo '<div class="alert alert-success alert-dismissable"> ';
                  echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                  print_r($success);
                  echo '</span>';
                  echo'</div>';
                } ?>
                <?php 
                    $errors=$this->session->flashdata('errors');
                    if(isset($errors)){
                      echo '<div class="alert alert-danger alert-dismissable"> ';
                      echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                      print_r($errors);
                      echo '</span>';
                      echo'</div>';
                } ?>
                </span>
                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Edit User</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url('admin/users/editSiteUser')."/".$profiledata->id ?>" method="POST" role="form">
                                <div class="row">
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Email</label>
                                         <input type="text" name="email" required=""   class="form-control" value="<?php echo isset($profiledata->email) ? $profiledata->email :''; ?>" placeholder="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Username</label>
                                         <input type="text" name="username" required=""  class="form-control" value="<?php echo isset($profiledata->username) ? $profiledata->username :''; ?>" placeholder="username">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Password</label>
                                         <input type="password" name="password" autocomplete="off" class="form-control" value="" placeholder="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Repeat Password</label>
                                         <input type="password" name="rpassword" autocomplete="off" class="form-control" value="" placeholder="repeat password">
                                        </div>
                                    </div>
                                </div> -->
                                 
                                 <div class="row">
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" placeholder="City"  value="<?php echo isset($profiledata->city) ? $profiledata->city :''; ?>" name="city" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label>State</label>
                                           <input type="text" placeholder="State"   name="state" value="<?php echo isset($profiledata->state) ? $profiledata->state :''; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                             <input type="text" placeholder="United State" class="form-control" name="country" value="<?php echo isset($profiledata->country) ? $profiledata->country :''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" placeholder="11368"  name="postal_code" value="<?php echo isset($profiledata->postal_code) ? $profiledata->postal_code :''; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Street Address 1</label>
                                            <input type="text" placeholder="111-17 northern Btvd"  name="address1" value="<?php echo isset($profiledata->address1) ? $profiledata->address1 :''; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Street Address 2</label>
                                            <input type="text" placeholder="111-17 northern Btvd"  name="address2" value="<?php echo isset($profiledata->address2) ? $profiledata->address2 :''; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Phone No</label>    
                                        <input type="tele" name="phone"  class="form-control fontStyle" value="<?php echo isset($profiledata->phone) ? $profiledata->phone :'+44'; ?>" placeholder="Phone No" style="margin-bottom:0px !important">
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                  <div class="col-sm-12">
                                       <button type="submit" name="submit" class="pull-right btn btn-success">Save</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

