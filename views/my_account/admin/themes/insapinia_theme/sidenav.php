<?php
    $this->load->model('my_account/common_model');
    $userdetail=$this->common_model->getOne('tbladmin_sales',array('admin_sales_id'=>$this->session->userdata('admin_sales_id')));
    $user_name=isset($userdetail->admin_sales_user) ? $userdetail->admin_sales_user.' '.$userdetail->admin_sales_lname:'';
 ?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="overflow-hide">
        <div class="full-height-scroll scroll-element">
            <div class="sidebar-collapse">
                <div class="close_icons">
                    <img alt="image" class="img-circle" src="<?php echo $this->theme_js_path ?>img/close_menu.png" />
                </div>
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo $this->theme_js_path ?>img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                             <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo isset($user_name) ? $user_name :''; ?></strong> 
                            </span> <span class="text-muted text-xs block"> <b class="caret"></b></span> </span> </a> 
                             <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo base_url('my_account/profile/index') ?>/profile">Profile </a></li>    
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url(); ?>my_account/auth/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                          
                        </div>
                    </li>
                    <li class="<?php echo ($active == 'dashboard') ? 'active' :''; ?>">
                        <a href="<?php echo base_url('my_account/dashboard') ?>"><span class="nav-label"></span>Dashboard </a>
                    </li>
                    <li class="<?php echo ($active == 'sales') ? 'active' :''; ?>">
                        <a href="<?php echo base_url('my_account/sale') ?>"><span class="nav-label"></span>SO List </a>
                    </li>
                    <li class="<?php echo ($active == 'purchase') ? 'active' :''; ?>">
                        <a href="<?php echo base_url('my_account/purchase') ?>"><span class="nav-label"></span>PO List </a>
                    </li>
                    <!-- <li class="<?php echo ($active == 'sales' || $active == 'sales') ? 'active' :''; ?>">
                        <a href=""><span class="nav-label"></span>Mange Sales <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                           <li class="<?php echo (isset($active) && $active == 'sales') ? 'active' :''; ?>">
                                <a href="#"><span class="nav-label"></span>Sale</a>
                            </li> 
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</nav>