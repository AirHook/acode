                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start ">
                            <a href="<?php echo site_url('admin/dashboard'); ?>" class="nav-link ">
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <li class="heading">
                            <h3 class="uppercase">Products</h3>
                        </li>
                        <li class="nav-item <?php echo $this->uri->segment(2) == 'products' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/products'); ?>" class="nav-link ">
                                <span class="title uppercase">All Products</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'products' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'is_public' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/is_public'); ?>" class="nav-link  ">
                                        <span class="title">Public</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->segment(3) == 'not_publicj' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/products/not_public'); ?>" class="nav-link  ">
                                        <span class="title">Private</span>
                                    </a>
                                </li>
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
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">On Order <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                        <span class="title">By Vendor <cite class="small font-red-flamingo">(Under Construction)</cite></span>
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
                                <span class="arrow <?php echo $this->uri->segment(2) == 'designers' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                                <span class="arrow <?php echo $this->uri->segment(2) == 'categories' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                            <?php
                        } ?>

                        <li class="heading">
                            <h3 class="uppercase">Orders</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'orders' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/orders'); ?>" class="nav-link ">
                                <span class="title">Order Logs</span>
                            </a>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'sales_package' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="nav-link ">
                                <span class="title uppercase">Sales Package Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'sales_package' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="nav-link  ">
                                        <span class="title">List Sales Package</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package/create' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/campaigns/sales_package/create'); ?>" class="nav-link  ">
                                        <span class="title">Create Sales Package</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'sales_orders' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/sales_orders'); ?>" class="nav-link ">
                                <span class="title uppercase">Sales Order Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'sales_orders' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/sales_orders' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/sales_orders'); ?>" class="nav-link  ">
                                        <span class="title">List Sales Order</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/sales_orders/create' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/sales_orders/create'); ?>" class="nav-link  ">
                                        <span class="title">Create New Sales Order</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/purchase_orders'); ?>" class="nav-link ">
                                <span class="title uppercase">Purchase Order Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php echo $this->uri->uri_string() == 'admin/purchase_orders' ? 'active open' : ''; ?>">
                                    <a href="<?php echo site_url('admin/purchase_orders'); ?>" class="nav-link  ">
                                        <span class="title">List Purchase Order</span>
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

                        <li class="heading">
                            <h3 class="uppercase">Users</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'wholesale' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/users/wholesale'); ?>" class="nav-link ">
                                <span class="title uppercase">Wholesale Users Manager</span>
                                <span class="arrow <?php echo $this->uri->segment(3) == 'purchase_orders' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                                <span class="arrow <?php echo $this->uri->segment(3) == 'consumer' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                                <span class="arrow <?php echo $this->uri->segment(3) == 'sales' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                                <span class="arrow <?php echo $this->uri->segment(3) == 'vendor' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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
                                <span class="arrow <?php echo $this->uri->segment(3) == 'admin' ? 'open' : ''; ?>"></span>
                            </a>
                            <ul class="sub-menu">
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

                        <li class="heading">
                            <h3 class="uppercase">Inventory</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'admin/inventory/physical') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/inventory/physical'); ?>" class="nav-link ">
                                <span class="title">Physical Stocks</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'admin/inventory/available') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/inventory/available'); ?>" class="nav-link ">
                                <span class="title">Available Stocks</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'admin/inventory/onorder') === FALSE ? '' : 'active'; ?>">
                            <a href="<?php echo site_url('admin/inventory/onorder'); ?>" class="nav-link ">
                                <span class="title">On-Order Stocks</span>
                            </a>
                        </li>

                        <li class="heading">
                            <h3 class="uppercase">Production</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'production' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/production'); ?>" class="nav-link ">
                                <span class="title">Production <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                            </a>
                        </li>

                        <li class="heading">
                            <h3 class="uppercase">Accounting</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'accounting' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/accounting'); ?>" class="nav-link ">
                                <span class="title">Accounting <cite class="small font-red-flamingo">(Under Construction)</cite></span>
                            </a>
                        </li>

                        <li class="heading">
                            <h3 class="uppercase">General</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/settings/general' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/general'); ?>" class="nav-link ">
                                <span class="title">General Settings</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/settings/meta' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/meta'); ?>" class="nav-link ">
                                <span class="title">Site SEO</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/settings/options' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/settings/options'); ?>" class="nav-link ">
                                <span class="title">Site Options</span>
                            </a>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/chagne_pass' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/change_pass'); ?>" class="nav-link ">
                                <span class="title">Admin Change Password</span>
                            </a>
                        </li>
                            <?php
                        } ?>

                        <li class="heading">
                            <h3 class="uppercase">Tools</h3>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/dcn/create' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/dcn/create'); ?>" class="nav-link ">
                                <span class="title">Documentation</span>
                            </a>
                        </li>
                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/accounts' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/accounts'); ?>" class="nav-link ">
                                <span class="title">Accounts</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/webspaces' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/webspaces'); ?>" class="nav-link ">
                                <span class="title">Webspaces</span>
                            </a>
                        </li>
                        <li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'admin/sales' ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/sales'); ?>" class="nav-link ">
                                <span class="title">Link to Sales Dashboard</span>
                            </a>
                        </li>
                            <?php
                        } ?>
                        <li class="nav-item with-heading ">
                            <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                <span class="title uppercase">Pages Manager</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
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
                        <li class="nav-item with-heading ">
                            <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                <span class="title uppercase">Reports Manager</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
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
                        <li class="nav-item with-heading ">
                            <a href="javascript:;" class="nav-link tooltips" data-original-title="Currently Under Construction" data-placement="right">
                                <span class="title uppercase">Newsletter</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
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
                    </ul>
                    <!-- END SIDEBAR MENU -->