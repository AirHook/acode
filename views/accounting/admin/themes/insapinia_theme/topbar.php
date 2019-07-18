<div id="page-wrapper" class="gray-bg dashbard-1">

    <div class="under-page-wrapper" style="margin-bottom: 39px;">

        <div class="row border-bottom">

        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">

            <?php if(isset($full_view) && $full_view === true) { 

            } else {?>

            <?php } ?>

            <div class="humburger_menu">
            <img src="<?php echo base_url() ?>assets/erp/insapinia_theme/img/humbuger-menu11.png" />
            </div>

            <div class="desktop-menu">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>

            <form role="search" class="navbar-form-custom" action="search_results.html">

                <div class="form-group">
                    <h5 style="margin-top: 17px; margin-left: 34px;"><?php echo date('M d Y h:i A e'); ?></h5>
                    <!-- <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search"> -->

                </div>

            </form>

        </div>

            <ul class="nav navbar-top-links navbar-right">

                <li class="modules-link">

                   

                </li>

                <li>

                    <a href="<?php echo base_url(); ?>accounting/auth/logout">

                        <i class="fa fa-sign-out"></i> <?php lang('btn_log_out'); ?> 

                    </a>

                </li>

                <li>

                    <a class="right-sidebar-toggle">

                        <i class="fa fa-tasks"></i>

                    </a>

                </li>

            </ul>



        </nav>

        </div>

 