<?php $controller = &get_instance(); ?>
<div id="wrapper">
    <div class="normalheader ">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs">
                    User Permissions
                </h2>
                <small></small>
            </div>
        </div>
    </div>
    <div class="permissions-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
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
                    ?>
                    <form class="permissions-form" action="<?php echo base_url('accounting/roles/save_roles'); ?>" method="POST" role="form">
                        <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >

        <div>

            
            <div class="row">

                <div class="col-sm-6">

                    <div class="form-group">

                        <label>Select a User Role</label>
                        <?php
                        $selected_id = $this->session->flashdata('group_id');
                        ?>
                        <select class="form-control" name="group">
                            <?php
                            if(isset($groups) && !empty($groups)) {
                                foreach ($groups as $key => $value) {
                                    if($selected_id == $value->id)
                                        echo '<option selected value="'.$value->id.'">'.$value->name.'</option>';
                                    else
                                        echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                }
                            }
                            ?>                            
                        </select>

                    </div>

                </div>

            </div>



            <div class="row"><div class="col-sm-12"><label>Set permissions of Selected role</label></div></div>

            <div class="result"> </div>

                                <div class="row"><div class="col-sm-6">

                                <input type="submit" class="btn btn-primary" name="user_permissions_submit" value="Save Settings">

                                </div></div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>    
</div>    
