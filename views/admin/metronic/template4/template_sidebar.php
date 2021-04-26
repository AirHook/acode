                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <!-- DOC: Set class="always-open" to "sub-menu" to keep submenus open -->
                    <!-- DOC: Set class="open" to keep arrow pointing down for "sub-menu always-open" -->
                    <!-- DOC: Set class="with-heading" li nav-item if with sub-menu -->
                    <ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('admin/dashboard'); ?>" class="nav-link ">
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Products</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'products' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/products'); ?>" class="nav-link ">
                                <span class="title uppercase">All Products</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'products' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'is_public' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/is_public'); ?>" class="nav-link  ">
                                        <span class="title">Public</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'not_public' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/not_public'); ?>" class="nav-link  ">
                                        <span class="title">Private</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'clearance' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/clearance'); ?>" class="nav-link  ">
                                        <span class="title">On Sale</span>
                                    </a>
                                </li>
                                <?php
                                // available only on hub sites for now
                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                { ?>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'clearance_cs_only' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/clearance_cs_only'); ?>" class="nav-link  ">
                                        <span class="title">Clearance CS Only</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'admin_stocks' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/admin_stocks'); ?>" class="nav-link  ">
                                        <span class="title">Admin Stocks</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'at_google' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/at_google'); ?>" class="nav-link  ">
                                        <span class="title">Google</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'dsco_stocks' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/dsco_stocks'); ?>" class="nav-link  ">
                                        <span class="title">DSCO</span>
                                    </a>
                                </li>
                                    <?php
                                } ?>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'unpublished' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/unpublished'); ?>" class="nav-link  ">
                                        <span class="title">Unpublished</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'instock' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/instock'); ?>" class="nav-link  ">
                                        <span class="title">In Stock</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'by_vendor' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/by_vendor'); ?>" class="nav-link  ">
                                        <span class="title">By Vendor</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">On Order <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/desiproducts/add' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/products/add'); ?>" class="nav-link ">
                                <span class="title">Add New Product</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/desiproducts/add/multiple_upload_images' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/products/add/multiple_upload_images'); ?>" class="nav-link ">
                                <span class="title">Add Multiple Product via Images</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'designers' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/designers'); ?>" class="nav-link ">
                                <span class="title uppercase">Designers</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'designers' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/designers' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/designers'); ?>" class="nav-link  ">
                                        <span class="title">Designer List</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/designers/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/designers/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Designer</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                            <?php
                        } ?>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'categories' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/categories'); ?>" class="nav-link ">
                                <span class="title uppercase">Categories</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'categories' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/categories' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/categories'); ?>" class="nav-link  ">
                                        <span class="title">Category List</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/categories/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/categories/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Category</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/desiproducts/color_variants' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/products/color_variants'); ?>" class="nav-link ">
                                <span class="title">Color Variants Manager</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/facets' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/facets'); ?>" class="nav-link ">
                                <span class="title">Facets Manager</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/products/csv/stocks_update') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/products/csv/stocks_update'); ?>" class="nav-link ">
                                <span class="title">Product Stocks CSV Update</span>
                            </a>
                        </li>
                            <?php
                        } ?>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Orders</h3>
                        </li>
                        <?php
                        // available only for tempoparis
                        if ($this->webspace_details->slug == 'tempoparis')
                        { ?>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/new_orders') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/new_orders'); ?>" class="nav-link ">
                                <span class="title">Order Logs</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/shipped') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/shipped'); ?>" class="nav-link ">
                                <span class="title">Shipped</span>
                            </a>
                        </li>
                            <?php
                        } ?>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/new_orders') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/new_orders'); ?>" class="nav-link ">
                                <span class="title">New Order Inquiries</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/payment_pending') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/payment_pending'); ?>" class="nav-link ">
                                <span class="title">Payment Pending</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/shipment_pending') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/shipment_pending'); ?>" class="nav-link ">
                                <span class="title">Shipment Pending</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/shipped') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/shipped'); ?>" class="nav-link ">
                                <span class="title">Shipped</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/store_credit') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/store_credit'); ?>" class="nav-link ">
                                <span class="title">Store Credit</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/refunded') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/refunded'); ?>" class="nav-link ">
                                <span class="title">Refunded</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/orders/cancelled') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/orders/cancelled'); ?>" class="nav-link ">
                                <span class="title">Cancelled</span>
                            </a>
                        </li>
                        <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/sales_orders/create' ? 'active open' : ''; ?>">
                            <a href="<?php echo site_url('admin/sales_orders/create'); ?>" class="nav-link  ">
                                <span class="title">Create New Sales Order</span>
                            </a>
                        </li>
                            <?php
                        } ?>

                        <?php
                        // available only on hub sites for now
                        if (
                            $this->webspace_details->options['site_type'] == 'hub_site'
                            OR $this->webspace_details->slug == 'tempoparis'
                            OR $this->webspace_details->slug == 'chaarmfurs'
                        )
                        { ?>
                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Sales</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'sales_package' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="nav-link ">
                                <span class="title uppercase">Sales Package Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'sales_package' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="nav-link  ">
                                        <span class="title">List Sales Packages</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package/create' ? 'active open' : ''; ?>">
                                    <!--<a href="javascript:;" class="nav-link disabled-link disable-target">-->
                                    <a href="<?php echo site_url('admin/campaigns/sales_package/create'); ?>" class="nav-link  ">
                                        <span class="title">Create Sales Package</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'lookbook' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/campaigns/lookbook'); ?>" class="nav-link ">
                                <span class="title uppercase">Lookbook Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'lookbook' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/lookbook' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/campaigns/lookbook'); ?>" class="nav-link  ">
                                        <span class="title">List Lookbooks</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/lookbook/create' ? 'active open' : ''; ?>">
                                    <!--<a href="javascript:;" class="nav-link disabled-link disable-target">-->
                                    <a href="<?php echo site_url('admin/campaigns/lookbook/create'); ?>" class="nav-link  ">
                                        <span class="title">Create Lookbook</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                            <?php
                        } ?>

                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <!--
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'sales_orders' ? 'active' : ''; ?> hide">
                            <a href="<?php echo site_url('admin/sales_orders'); ?>" class="nav-link ">
                                <span class="title uppercase">Sales Order Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'sales_orders' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/sales_orders' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/sales_orders'); ?>" class="nav-link  ">
                                        <span class="title">List Sales Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/sales_orders/create' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/sales_orders/create'); ?>" class="nav-link  ">
                                        <span class="title">Create New Sales Order</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        -->
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/purchase_orders'); ?>" class="nav-link ">
                                <span class="title uppercase">Purchase Order Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/purchase_orders' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/purchase_orders'); ?>" class="nav-link  ">
                                        <span class="title">List Purchase Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/purchase_orders/create' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/purchase_orders/create'); ?>" class="nav-link  ">
                                        <span class="title">Create New Purchase Order</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                            <?php
                        } ?>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Users</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'wholesale' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/wholesale'); ?>" class="nav-link ">
                                <span class="title uppercase">Wholesale Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'purchase_orders' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/users/wholesale/active' OR $this->uri->uri_string() == 'admin/users/wholesale/inactive' OR $this->uri->uri_string() == 'admin/users/wholesale/suspended') ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/wholesale'); ?>" class="nav-link  ">
                                        <span class="title">List Wholesale Users</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/wholesale/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/wholesale/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Wholesale User</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->slug != 'tempoparis')
                        { ?>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'consumer' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/consumer'); ?>" class="nav-link ">
                                <span class="title uppercase">Consumer Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'consumer' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/users/consumer/active' OR $this->uri->uri_string() == 'admin/users/consumer/inactive' OR $this->uri->uri_string() == 'admin/users/consumer/suspended') ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/consumer'); ?>" class="nav-link  ">
                                        <span class="title">List Consumer Users</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/consumer/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/consumer/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Consumer User</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                            <?php
                        } ?>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'sales' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/sales'); ?>" class="nav-link ">
                                <span class="title uppercase">Sales Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'sales' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/users/sales/active' OR $this->uri->uri_string() == 'admin/users/sales/inactive' OR $this->uri->uri_string() == 'admin/users/sales/suspended') ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/sales'); ?>" class="nav-link  ">
                                        <span class="title">List Sales Users</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/sales/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/sales/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Sales User</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'vendor' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/vendor'); ?>" class="nav-link ">
                                <span class="title uppercase">Vendor Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'vendor' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/vendor' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/vendor'); ?>" class="nav-link  ">
                                        <span class="title">List Vendor Users</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/vendor/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/vendor/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Vendor User</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'admin' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/admin'); ?>" class="nav-link ">
                                <span class="title uppercase">Admin Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'admin' ? 'open' : 'open'; ?>"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/admin' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/admin'); ?>" class="nav-link  ">
                                        <span class="title">List Admin Users</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/users/admin/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/users/admin/add'); ?>" class="nav-link  ">
                                        <span class="title">Add New Admin User</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Inventory</h3>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/inventory/physical') === FALSE ? '' : 'active'; ?>">
                            <!--<a href="javascript:;" class="nav-link disabled-link disable-target tooltips" data-original-title="Under Construction">-->
                            <a href="<?php echo site_url('admin/inventory/physical'); ?>" class="nav-link ">
                                <span class="title">Physical Stocks</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/inventory/available') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/inventory/available'); ?>" class="nav-link ">
                                <span class="title">Available Stocks</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/inventory/onorder') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/inventory/onorder'); ?>" class="nav-link ">
                                <span class="title">On-Order Stocks</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/inventory/update_by_scan') === FALSE ? '' : 'active'; ?>">
                            <a href="javascript:;" class="nav-link disabled-link disable-target tooltips" data-original-title="Under Construction">
                            <!--<a href="<?php echo site_url('admin/inventory/update_by_scan'); ?>" class="nav-link ">-->
                                <span class="title">Inventory Count By Barcode Scan</span>
                            </a>
                        </li>

                            <?php
                        } ?>

                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Production</h3>
                        </li>
                        <li class="nav-item <?php echo $this->uri->segment(2) == 'production' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/production'); ?>" class="nav-link ">
                                <span class="title">Production <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                            </a>
                        </li>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Accounting</h3>
                        </li>
                        <li class="nav-item <?php echo $this->uri->segment(2) == 'accounting' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/accounting'); ?>" class="nav-link ">
                                <span class="title">Accounting <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                            </a>
                        </li>

                            <?php
                        } ?>

                        <!-- =============-->
                		<li class="heading">
                			<h3 class="uppercase">Marketing</h3>
                		</li>
                		<li class="nav-item with-heading ">
                			<a href="javascript:;" class="nav-link tooltips_" data-original-title="Currently Under Construction" data-placement="right">
                				<span class="title uppercase">Mailgun Emailing</span>
                				<span class="arrow open"></span>
                			</a>
                			<ul class="sub-menu always-open">
                                <li class="nav-item  <?php echo ($this->uri->uri_string() == 'admin/marketing/carousels' OR (strpos($this->uri->uri_string(), 'admin/marketing/carousels/edit') !== FALSE)) ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/marketing/carousels'); ?>" class="nav-link  ">
                					<!--<a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">-->
                						<span class="title">Carousels</span>
                					</a>
                				</li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/marketing/carousels/add' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/marketing/carousels/add'); ?>" class="nav-link  ">
                					<!--<a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">-->
                						<span class="title">Add New Carousel</span>
                					</a>
                				</li>

                                <?php
                                // available only on hub sites for now
                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                { ?>

                				<li class="nav-item  ">
                					<a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                						<span class="title">Wholesale Special Sale Email Carousel</span>
                					</a>
                				</li>
                				<li class="nav-item  ">
                					<a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                						<span class="title">Factory Email Carousel for New Products</span>
                					</a>
                				</li>
                				<li class="nav-item  ">
                					<a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                						<span class="title">Create Newsletter</span>
                					</a>
                				</li>

                                    <?php
                                } ?>

                			</ul>
                		</li>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">General</h3>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/settings/general' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/general'); ?>" class="nav-link ">
                                <span class="title">General Settings</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/settings/meta' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/meta'); ?>" class="nav-link ">
                                <span class="title">Site SEO</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/settings/options' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/options'); ?>" class="nav-link ">
                                <span class="title">Site Options</span>
                            </a>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/chagne_pass' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/change_pass'); ?>" class="nav-link ">
                                <span class="title">Admin Change Password</span>
                            </a>
                        </li>

                        <!-- =============-->
                        <li class="heading">
                            <h3 class="uppercase">Tools</h3>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/dcn/create' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/dcn/create'); ?>" class="nav-link ">
                                <span class="title">Documentation</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/accounts' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/accounts'); ?>" class="nav-link ">
                                <span class="title">Accounts</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/webspaces' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/webspaces'); ?>" class="nav-link ">
                                <span class="title">Webspaces</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $this->uri->uri_string() == 'admin/sales' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/sales'); ?>" class="nav-link ">
                                <span class="title">Link to Sales Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'admin/task_manager') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/task_manager/projects'); ?>" class="nav-link ">
                                <span class="title uppercase">Task Manager</span>
                            </a>
                        </li>

                            <?php
                        } ?>

                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'pages' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/pages'); ?>" class="nav-link ">
                                <span class="title uppercase">Pages Manager</span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item <?php echo strpos($this->uri->uri_string(), 'admin/pages') === FALSE ? '' : 'active'; ?>">
                                    <a href="<?php echo site_url('admin/pages'); ?>" class="nav-link ">
                                        <span class="title">Pages</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Add New Page</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item with-heading ">
                            <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                <span class="title uppercase">Reports Manager</span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Sales Report</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Orders Report</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Click Report</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Stock Report</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- DOC: Changing NEWSLETTER to MARKETING -- new menu items in a separate group and heading
                        <li class="nav-item with-heading ">
                            <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                <span class="title uppercase">Newsletter</span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu always-open">
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">List Newsletter</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">Create Newsletter</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        -->
                            <?php
                        } ?>
                    </ul>
                    <!-- END SIDEBAR MENU -->
