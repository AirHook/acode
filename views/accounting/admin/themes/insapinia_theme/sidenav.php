<?php
$controller =& get_instance(); 
$controller->load->model('common_model');
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="overflow-hide">
    <div class="full-height-scroll scroll-element">
    <div class="sidebar-collapse">
        <div class="close_icons">
            <img alt="image" class="img-circle" src="<?php echo $controller->theme_js_path ?>img/close_menu.png" />
        </div>
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $controller->theme_js_path ?>img/profile_small.jpg" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                     <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->session->first_name.' '.$this->session->last_name ?></strong> 
                    </span> <span class="text-muted text-xs block"> <b class="caret"></b></span> </span> </a> 
                     <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="<?php echo base_url('accounting/admin/userCreation') .'/'.encode_url($this->session->userdata('id')) ?>/profile"><?php lang('lab_profile'); ?> </a></li>                        
                        <li><a href="<?php echo base_url('accounting/company/changePassword')?>"><?php lang('lab_change_password'); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>auth/logout"><?php lang('lab_logout'); ?></a></li>
                    </ul>
                </div>
                <div class="logo-element">
                  <?php 
                        $company_id=$controller->session->userdata('company_id');
                        $companyName=$controller->common_model->getOne('tbl_company',array('companyId'=>$company_id));
                        if(!empty($companyName)){
                            echo isset($companyName->companyName) ? $companyName->companyName :'';
                        }
                  ?>
                </div>
            </li>
            <?php if($this->session->userdata('role') == 'super_admin' && isset($module) && $module == 'accounting') { ?>
                <li class="<?php echo ($active == 'All Users' || $active == 'Create User') ? 'active' :''; ?>">
                        <a href=""><span class="nav-label"></span><?php lang('lab_manage_companies'); ?> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li class="<?php echo (isset($active) && $active == 'All Users') ? 'active' :''; ?>">
                                    <a href="<?php echo base_url('accounting/admin/index') ?>"><span class="nav-label"></span><?php lang('heading_companies'); ?></a>
                                </li>
                              <!--   <li class="<?php echo (isset($active) && $active == 'Create User') ? 'active' :''; ?>">
                                    <a href="<?php echo base_url('accounting/admin/creatUser') ?>"><span class="nav-label"></span>Create User</a>
                                </li> -->
                            </ul>
                    </li>
            
            <?php } else {?>
         <?php
          if(isset($side_nav)){
                foreach ($side_nav as $key => $value) {
                    $value = (object)$value;
                    $flag = false;
                    if(isset($value->children)) {
                        foreach ($value->children as $bacha) {
                            $bacha=(object)$bacha;
                            if(isset($bacha->title) && $bacha->title == $active) {
                                $flag = true;
                                break;  
                            }
                            
                        }
                    }
                    ?>
                    <li class="<?php echo (isset($active) && ($active == $value->title || $flag)) ? 'active' :''; ?>">
                        <a href="<?php echo isset($value->link) ? base_url($value->link) : '#'; ?>"><span class="nav-label"><?php echo isset($value->title) ? $value->title : ''; ?></span><?php echo isset($value->children) ? '<span class="fa arrow"></span>' : ''; ?> </a>
                        <?php
                        if(isset($value->children) && !empty($value->children)) {
                            ?>
                            <ul class="nav nav-second-level collapse <?php echo (isset($active) && $active == $value->title) ? 'in' : ''; ?>">
                            <?php
                            foreach ($value->children as $key) {
                                $key = (object)$key;
                                ?>
                                <li class="<?php echo (isset($active) && $active == $key->title) ? 'active' :''; ?>">
                                <a href="<?php echo isset($key->link) ? base_url($key->link) : '#'; ?>"><span class="nav-label"><?php echo isset($key->title) ? $key->title : ''; ?></span> </a>
                                </li>
                        <?php } ?>
                            
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
            }
            ?>
            <?php } ?>
        </ul>
    </div>
    </div>
    </div>
</nav>