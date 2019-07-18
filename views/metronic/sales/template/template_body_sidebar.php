                                            <!-- BEGIN PAGE SIDEBAR -->
                                            <div class="page-sidebar">

                                                <!-- BEGIN TOP TABS -->
                                                <ul class="nav nav-pills nav-browse-cart margin-bottom-35">
                                                    <li class="active">
                                                        <a href="<?php echo site_url('sales/dashboard'); ?>" class="text-center uppercase">
                                                            Browse By <br /> Categories
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <?php
                                                        $link = $this->uri->segment(2) == 'purchase_orders'
                                                            ? site_url('sales/purchase_orders/create/step3')
                                                            : site_url('sales/create/step2')
                                                        ;
                                                        $cart_nav_items_count = $this->uri->segment(2) == 'purchase_orders'
                                                            ? $po_items_count
                                                            : $sa_items_count
                                                        ;
                                                        ?>
                                                        <a href="<?php echo $cart_nav_items_count ? $link : 'javascript:;'; ?>" class="sidebar_cart_link" style="padding-top:15px;">
                                                            <i class="icon-present "></i> ( <span class="items_count"><?php echo $cart_nav_items_count ?: '0'; ?></span> ) View Items </a>
                                                    </li>
                                                </ul>
                                                <!-- END TOP TABS -->

                                                <!-- BEGIN PRODUCT THUMGS SIDEBAR -->
                                                <?php $this->load->view('metronic/sales/sales_package_sidebar_categories'); ?>
                                                <!-- END PRODUCT THUMGS SIDEBAR -->

                                                <!-- BEGIN MID BUTTONS -->
                                                <div class="clearfix">

                                                    <?php if ($this->uri->segment(2) == 'purchase_orders')
                                                    { ?>

                                                    <div class="col-md-12 margin-bottom-10">
                                                        <?php if (@$steps == 2 && $cart_nav_items_count == 0) { ?>
                                                            <a href="javascript:;" class="btn btn-default btn-block btn-sm sidebar-send-package-btn disabled-link disable-target tooltips" data-original-title="Nothing to send">
                                                                <span style="color:red;">
                                                                    <?php
                                                                    echo $this->uri->segment(2) == 'purchase_orders'
                                                                        ? 'REFINE PURCHASE ORDER'
                                                                        : 'SEND PACKAGE'
                                                                    ;
                                                                    ?>
                                                                </span>
                                                            </a>
                                                        <?php } elseif (@$steps == 2 && $cart_nav_items_count > 0) { ?>
                                                            <a href="<?php echo site_url('sales/'.($this->uri->segment(2) == 'purchase_orders' ? 'purchase_orders/' : '').'create/step3'); ?>" class="btn btn-default btn-block btn-sm sidebar-send-po-btn" data-original-title="Nothing to send">
                                                                <span style="color:red;">
                                                                    <?php
                                                                    echo $this->uri->segment(2) == 'purchase_orders'
                                                                        ? 'REFINE PURCHASE ORDER'
                                                                        : 'SEND PACKAGE'
                                                                    ;
                                                                    ?>
                                                                </span>
                                                            </a>
                                                        <?php } elseif (@$steps == 3) { ?>
                                                            <button type="button" class="btn btn-default btn-block btn-sm sidebar-send-po-btn <?php echo (@$steps == 3 && $po_items_count > 0) ? 'mt-bootbox-new' : ''; ?>">
                                                                <span style="color:red;">
                                                                    <?php
                                                                    echo $this->uri->segment(2) == 'purchase_orders'
                                                                        ? 'SEND PURCHASE ORDER'
                                                                        : 'SEND PACKAGE'
                                                                    ;
                                                                    ?>
                                                                </span>
                                                            </button>
                                                        <?php } elseif (@$steps == 1) { ?>
                                                            <a href="<?php echo $this->session->po_vendor_id ? site_url('sales/purchase_orders/create/step2') : 'javascript:;';?>" class="btn btn-default btn-block btn-sm sidebar_cart_link">
                                                                <span style="color:red;">
                                                                    <?php
                                                                    echo $this->uri->segment(2) == 'purchase_orders'
                                                                        ? 'SEND PURCHASE ORDER'
                                                                        : 'SEND PACKAGE'
                                                                    ;
                                                                    ?>
                                                                </span>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('sales/create/step1/womens_apparel'); ?>" class="btn btn-default btn-block btn-sm ">
                                                                <span style="color:red;">
                                                                    <?php
                                                                    echo $this->uri->segment(2) == 'purchase_orders'
                                                                        ? 'SEND PURCHASE ORDER'
                                                                        : 'SEND PACKAGE'
                                                                    ;
                                                                    ?>
                                                                </span>
                                                            </a>
                                                        <?php } ?>
                                                    </div>

                                                        <?php
                                                    }
                                                    else
                                                    { ?>

                                                    <div class="col-md-12 margin-bottom-10">
                                                        <?php if (@$steps == 2 && $cart_nav_items_count == 0) { ?>
                                                            <a href="javascript:;" class="btn btn-default btn-block btn-sm disabled-link disable-target tooltips" data-original-title="Nothing to send">
                                                                <span style="color:red;"> SEND PACKAGE </span>
                                                            </a>
                                                        <?php } elseif (@$steps == 2 && $cart_nav_items_count > 0) { ?>
                                                            <a href="<?php echo site_url('sales/create/step3'); ?>" class="btn btn-default btn-block btn-sm sidebar-send-package-btn" data-original-title="Nothing to send">
                                                                <span style="color:red;"> SEND PACKAGE </span>
                                                            </a>
                                                        <?php } elseif (@$steps == 3) { ?>
                                                            <button type="button" class="btn btn-default btn-block btn-sm sidebar-send-package-btn <?php echo $this->session->sa_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?>">
                                                                <span style="color:red;"> SEND PACKAGE </span>
                                                            </button>
                                                        <?php } elseif (@$steps == 1) { ?>
                                                            <a href="<?php echo $cart_nav_items_count ? site_url('sales/create/step2') : 'javascript:;';?>" class="btn btn-default btn-block btn-sm sidebar_cart_link">
                                                                <span style="color:red;"> SEND PACKAGE </span>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo site_url('sales/create/step1/womens_apparel'); ?>" class="btn btn-default btn-block btn-sm ">
                                                                <span style="color:red;"> SEND PACKAGE </span>
                                                            </a>
                                                        <?php } ?>
                                                    </div>

                                                        <?php
                                                    } ?>

                                                    <div class="col-md-12 margin-bottom-10">
                                                        <?php
                                                        $add_more_items_link =
                                                            $this->uri->segment(2) == 'purchase_orders'
                                                            ? site_url('sales/purchase_orders/create/step2/womens_apparel')
                                                            : site_url('sales/create/step1/womens_apparel')
                                                        ;
                                                        ?>
                                                        <a class="btn btn-default btn-block btn-sm" href="<?php echo $add_more_items_link; ?>"> ADD MORE ITEMS </a>
                                                    </div>
                                                    <div class="col-md-12 margin-bottom-10 <?php echo $cart_nav_items_count == 0 ? 'hide': ''; ?>">
                                                        <a class="btn btn-default btn-block btn-sm clear_all_items" href="#modal-clear_all_items" data-toggle="modal" data-step="<?php echo @$steps ?: 0; ?>"> CLEAR ALL ITEMS </a>
                                                    </div>
                                                </div>
                                                <!-- END MID BUTTONS -->

                                                <!-- BEGIN OTHER NAVS -->
                                                <div class="other-navs margin-top-20">

                                                    <div class="clearfix">
                                                        <div class="col-md-12">

                                                            <ul class="list-unstyled neseted-nav">
                                                                <li>
                                                                    <a href="javascript:;" class="uppercase">
                                                                        My Wholesale Users
                                                                    </a>
                                                                    <ul class="list-unstyled">
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/wholesale/add'); ?>" class="">
                                                                                Add New Wholesale User
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/wholesale'); ?>" class="">
                                                                                Wholesale User List
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </il>
                                                                <br />
                                                                <li>
                                                                    <a href="<?php echo site_url('sales/sales_package'); ?>" class="uppercase">
                                                                        My Sales Packages
                                                                    </a>
                                                                    <ul class="list-unstyled" data-items_count="<?php echo $cart_nav_items_count; ?>">
                                                                        <li>
                                                                            <?php
                                                                            $new_sales_package_link = site_url('sales/create/step1/womens_apparel');
                                                                            ?>
                                                                            <a href="javascript:;" data-link="<?php echo site_url('sales/create/step1/womens_apparel'); ?>" class="sidebar-nav-sales-package">
                                                                                New Sales Package
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <?php
                                                                            $preorder =
                                                                                @$this->sales_user_details->options['preset']['preorder']
                                                                                ? 'view/index/'.$this->sales_user_details->options['preset']['preorder']
                                                                                : 'preset/index/preorder'
                                                                            ;
                                                                            ?>
                                                                            <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/'.$preorder); ?>" class="sidebar-nav-sales-package">
                                                                                Pre Order Package
                                                                            </a>
                                                                        </li>
                                                                        <li style="color:grey;">
                                                                            <?php
                                                                            $instock =
                                                                                @$this->sales_user_details->options['preset']['instock']
                                                                                ? 'view/index/'.$this->sales_user_details->options['preset']['instock']
                                                                                : 'preset/index/instock'
                                                                            ;
                                                                            ?>
                                                                            <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/'.$instock); ?>" class="sidebar-nav-sales-package">
                                                                                In Stock Package
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <?php
                                                                            $onsale =
                                                                                @$this->sales_user_details->options['preset']['onsale']
                                                                                ? 'view/index/'.$this->sales_user_details->options['preset']['onsale']
                                                                                : 'preset/index/onsale'
                                                                            ;
                                                                            ?>
                                                                            <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/'.$onsale); ?>" class="sidebar-nav-sales-package">
                                                                                OFF Price Package
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <?php
                                                                            $bestseller =
                                                                                @$this->sales_user_details->options['preset']['bestseller']
                                                                                ? 'view/index/'.$this->sales_user_details->options['preset']['bestseller']
                                                                                : 'preset/index/instock'
                                                                            ;
                                                                            ?>
                                                                            <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/'.$bestseller); ?>" class="sidebar-nav-sales-package">
                                                                                Best Sellers Package
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/sales_package'); ?>" class="">
                                                                                All Sales Packages
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </il>
                                                                <br />
                                                                <li>
                                                                    <a href="javascript:;" class="uppercase">
                                                                        My Sales Orders
                                                                    </a>
                                                                    <ul class="list-unstyled">
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/sales_orders/create'); ?>" class="">
                                                                                Create Sales Orders
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/sales_orders'); ?>" class="">
                                                                                Sales Orders List
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </il>
                                                                <br />
                                                                <li>
                                                                    <a href="javascript:;" class="uppercase">
                                                                        Purchase Orders
                                                                    </a>
                                                                    <ul class="list-unstyled">
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/purchase_orders/create/step1'); ?>" class="">
                                                                                Create Purchase Orders
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="<?php echo site_url('sales/purchase_orders'); ?>" class="">
                                                                                Purchase Orders List
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </il>
                                                                <br />
                                                                <li>
                                                                    <a href="<?php echo site_url('sales/logout'); ?>">
                                                                        <i class="icon-logout"></i> Log Out
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END OTHER NAVS -->

                                            </div>
                                            <!-- END PAGE SIDEBAR -->
