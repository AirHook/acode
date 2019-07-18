<?php
$module = isset($module) ? $module : null;
?>
<aside id="menu">

    <div id="navigation">

        <div class="profile-picture">

            <a href="index.html">

                <img src="<?php echo $this->theme_css_path ?>images/profile.jpg" class="img-circle m-b" alt="logo">

            </a>



            <div class="stats-label text-color">

                <span class="font-extra-bold font-uppercase"><?php echo $this->session->userdata('first_name') ." ". $this->session->userdata('last_name'); ?></span>



                <div class="dropdown">

                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">

                        <small class="text-muted"> CEO OF IT VISION <b class="caret"></b></small>

                    </a>

                    <ul class="dropdown-menu animated flipInX m-t-xs">

                        <li><a href="<?php echo base_url('accounting/dashboard/contactUs') ?>">Contacts</a></li>

                        <li><a href="<?php echo base_url('accounting/dashboard/userProfile') ?>">Profile</a></li>

                        <li><a href="<?php echo base_url('accounting/dashboard/analytical') ?>">Analytics</a></li>

                        <li><a href="<?php echo base_url('auth/changePassword') ?>">Change Password</a></li>

                        <li class="divider"></li>

                        <li><a href="<?php echo base_url('auth/logout') ?>">Logout</a></li>

                    </ul>

                </div>





                <div id="sparkline1" class="small-chart m-t-sm"></div>

                <div>

                    <h4 class="font-extra-bold m-b-xs">

                        $260 104,200

                    </h4>

                    <small class="text-muted">Your income from the last year in sales product X.</small>

                </div>

            </div>

        </div>



        <ul class="nav" id="side-menu">

            <?php

            if(isset($side_nav)){

                foreach ($side_nav as $key => $value) {

                    $value = (object)$value;

                    $flag = false;

                    if(isset($value->modules) && !in_array($module, $value->modules))

                        continue;

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

                            <ul class="nav nav-second-level">

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

        </ul>

        

         <!--  <li class="<?php echo ($active == 'dashboard') ? 'active' :''; ?>">

                <a href="<?php echo base_url('accounting/dashboard')?>"> <span class="nav-label">Dashboard</span> <span class="label label-success pull-right">v.1</span> </a>

            </li>

            <li class="<?php echo ($active == 'suppliers' || $active == 'customer' ) ? 'active' :''; ?>">

                <a href="#"><span class="nav-label">Master</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li class="<?php echo ($active == 'customer') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/users') ?>">Customer</a>

                    </li>

                    <li class="<?php echo ($active == 'suppliers') ? 'active' :''; ?>">

                       <a href="<?php echo base_url('accounting/suppliers') ?>">Supplliers</a>

                    </li>

                    <li class="">

                        <a href="typography.html">Account Group</a>

                    </li>

                    <li class="">

                        <a href="typography.html">Account Ledger</a>

                    </li>

                    <li class="">

                        <a href="typography.html">Currency</a>

                    </li>

                     <li class="">

                        <a href="typography.html">Voucher Type</a>

                    </li>                </ul>

            </li>

             <li class="<?php echo ($active == 'products' || $active == 'catagory' || $active == 'brands' || $active == 'taxes' || $active == 'stock' ) ? 'active' :''; ?>">

                <a href="#"><span class="nav-label">Product</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li class="<?php echo ($active == 'catagory') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/category') ?>">Product Categories</a>

                    </li>

                    <li class="<?php echo ($active == 'products') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/products') ?>">Product Creation</a>

                    </li>

                    <li class="<?php echo ($active == 'brands') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/brands') ?>">Brands</a>

                    </li>

                    <li class="<?php echo ($active == '') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/units') ?>">Units</a>

                    </li>

                    <li class="<?php echo ($active == 'taxes') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/taxes') ?>">Taxes</a>

                    </li>

                    <li class="<?php echo ($active == 'stock') ? 'active' :''; ?>">

                        <a href="<?php echo base_url('accounting/products/stock') ?>">Stock Entry</a>

                    </li>

                </ul>

            </li> -->

        

            <!-- <li>

                <a href="analytics.html"> <span class="nav-label">Analytics</span><span class="label label-warning pull-right">NEW</span> </a>

            </li>

            <li>

                <a href="#"><span class="nav-label">Interface</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="panels.html">Panels design</a></li>

                    <li><a href="typography.html">Typography</a></li>

                    <li><a href="buttons.html">Colors &amp; Buttons</a></li>

                    <li><a href="components.html">Components</a></li>

                    <li><a href="alerts.html">Alerts</a></li>

                    <li><a href="modals.html">Modals</a></li>

                    <li><a href="loading_buttons.html">Loading buttons</a></li>

                    <li><a href="draggable.html">Draggable panels</a></li>

                    <li><a href="code_editor.html">Code editor</a></li>

                    <li><a href="email_template.html">Email template</a></li>

                    <li><a href="nestable_list.html">List</a></li>

                    <li><a href="tour.html">Tour</a></li>

                    <li><a href="icons.html">Icons library</a></li>

                </ul>

            </li>

            <li>

                <a href="#"><span class="nav-label">App views</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="contacts.html">Contacts</a></li>

                    <li><a href="projects.html">Projects</a></li>

                    <li><a href="project.html">Project detail</a></li>

                    <li><a href="app_plans.html">App plans</a></li>

                    <li><a href="social_board.html">Social board</a></li>

                    <li><a href="faq.html">FAQ</a></li>

                    <li><a href="timeline.html">Timeline</a></li>

                    <li><a href="notes.html">Notes</a></li>

                    <li><a href="profile.html">Profile</a></li>

                    <li><a href="mailbox.html">Mailbox</a></li>

                    <li><a href="mailbox_compose.html">Email compose</a></li>

                    <li><a href="mailbox_view.html">Email view</a></li>

                    <li><a href="blog.html">Blog</a></li>

                    <li><a href="blog_details.html">Blog article</a></li>

                    <li><a href="forum.html">Forum</a></li>

                    <li><a href="forum_details.html">Forum details</a></li>

                    <li><a href="gallery.html">Gallery</a></li>

                    <li><a href="calendar.html">Calendar</a></li>

                    <li><a href="invoice.html">Invoice</a></li>

                    <li><a href="file_manager.html">File manager</a></li>

                    <li><a href="chat_view.html">Chat view</a></li>

                    <li><a href="search.html">Search view</a></li>

                </ul>

            </li>

            <li>

                <a href="#"><span class="nav-label">Charts</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="chartjs.html">ChartJs</a></li>

                    <li><a href="flot.html">Flot charts</a></li>

                    <li><a href="inline.html">Inline graphs</a></li>

                    <li><a href="chartist.html">Chartist</a></li>

                    <li><a href="c3.html">C3 Charts</a></li>

                </ul>

            </li>

            <li>

                <a href="#"><span class="nav-label">Box transitions</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="overview.html"><span class="label label-success pull-right">Start</span> Overview </a>  </li>

                    <li><a href="transition_two.html">Columns from up</a></li>

                    <li><a href="transition_one.html">Columns custom</a></li>

                    <li><a href="transition_three.html">Panels zoom</a></li>

                    <li><a href="transition_four.html">Rows from down</a></li>

                    <li><a href="transition_five.html">Rows from right</a></li>

                </ul>

            </li>

            <li>

                <a href="#"><span class="nav-label">Common views</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="login.html">Login</a></li>

                    <li><a href="register.html">Register</a></li>

                    <li><a href="error_one.html">Error 404</a></li>

                    <li><a href="error_two.html">Error 505</a></li>

                    <li><a href="lock.html">Lock screen</a></li>

                    <li><a href="password_recovery.html">Passwor recovery</a></li>

                </ul>

            </li>

            <li>

                <a href="#"><span class="nav-label">Tables</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="tables_design.html">Tables design</a></li>

                    <li><a href="datatables.html">Data tables</a></li>

                    <li><a href="footable.html">Foo Table</a></li>



                </ul>

            </li>

            <li>

                <a href="widgets.html"> <span class="nav-label">Widgets</span> <span class="label label-success pull-right">Special</span></a>

            </li>

            <li>

                <a href="#"><span class="nav-label">Forms</span><span class="fa arrow"></span> </a>

                <ul class="nav nav-second-level">

                    <li><a href="forms_elements.html">Forms elements</a></li>

                    <li><a href="forms_extended.html">Forms extended</a></li>

                    <li><a href="text_editor.html">Text editor</a></li>

                    <li><a href="wizard.html">Wizard</a></li>

                    <li><a href="validation.html">Validation</a></li>

                </ul>

            </li>

            <li>

                <a href="options.html"> <span class="nav-label">Layout options</span></a>

            </li>

            <li>

                <a href="grid_system.html"> <span class="nav-label">Grid system</span></a>

            </li>

            <li>

                <a href="landing_page.html"> <span class="nav-label">Landing page</span></a>

            </li>

            <li>

                <a href="package.html"> <span class="nav-label">Package</span></a>

            </li>-->



    </div>

</aside>

<div id="wrapper">