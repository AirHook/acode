                            <!-- Brand and toggle get grouped for better mobile display -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="toggle-icon">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </span>
                            </button>
                            <!-- End Toggle Button -->

                            <!-- BEGIN LOGO -->
                            <div class="page-logo">
                                <a href="index.html">

        							<?php if (@$this->webspace_details->options['logo_light'])
                                    { ?>

                                    <img src="<?php echo $this->config->item('PROD_IMG_URL').$this->webspace_details->options['logo_light']; ?>" alt="logo" class="logo-default" />

                                        <?php
                                    }
                                    else if (@$this->webspace_details->options['site_type'] == 'sat_site')
                                    {
                                        $designer_details = $this->designer_details->initialize(
                                            array(
                                                'designer.url_structure'=>$this->webspace_details->slug
                                            )
                                        );
                                        ?>

                                    <img src="<?php echo $this->config->item('PROD_IMG_URL').$this->designer_details->logo_light; ?>" alt="logo" style="height:14px;" class="logo-light" />

                                        <?php
                                    }
                                    else
                                    { ?>

                                    <!--<img src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" />-->
                                    <img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>-light.png" alt="logo" style="height:14px;" class="logo-light" />

                                        <?php
                                    } ?>

        						</a>
                                <div class="menu-toggler sidebar-toggler">
                                    <span></span>
                                </div>
                            </div>
                            <!-- END LOGO -->

                            <!-- BEGIN SEARCH -->
                            <!-- FORM =======================================================================-->
                            <?php echo form_open(
                                $this->config->slash_item('admin_folder').'search',
                                array(
                                    'method'=>'POST',
                                    //'id'=>'form-admin_tobbar_search',
                                    'class'=>'search'
                                    //'style'=>'padding:8px 10px;'
                                )
                            ); ?>
                                <input type="text" class="form-control search_by_style" id="search_by_style_" name="style_no" placeholder="Search..." style="text-transform:uppercase;"/>
                                <a href="javascript:;" class="btn submit md-skip">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                            <!-- End FORM ===================================================================-->
                            <!-- END FORM-->
                            <!-- END SEARCH -->

                            <!-- BEGIN TOPBAR ACTIONS -->
                            <div class="topbar-actions">

                                <!-- BEGIN USER PROFILE -->
                                <div class="btn-group-img btn-group">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <span class="username username-hide-on-mobile"> Welcome, <?php echo @$this->admin_user_details->username; ?> </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu-v2" role="menu">
                                        <li>
                                            <a href="javascript:;" class="disabled-link disable-target">
                                                <i class="icon-user"></i> My Profile
                                                <span class="badge badge-danger">1</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="disabled-link disable-target">
                                                <i class="icon-calendar"></i> My Calendar </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="disabled-link disable-target">
                                                <i class="icon-envelope-open"></i> My Inbox
                                                <span class="badge badge-danger"> 3 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="disabled-link disable-target">
                                                <i class="icon-rocket"></i> My Tasks
                                                <span class="badge badge-success"> 7 </span>
                                            </a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="javascript:;" class="disabled-link disable-target">
                                                <i class="icon-lock"></i> Lock Screen </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/logout'); ?>">
                                                <i class="icon-key"></i> Log Out </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- END USER PROFILE -->

                            </div>
                            <!-- END TOPBAR ACTIONS -->
