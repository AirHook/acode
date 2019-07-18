                    <div class="col-md-3">

                        <ul class="list-unstyled neseted-nav">

                            <?php
                            /***********
                             * DOCUMENTATION
                             */
                            if (in_array('dcn', $this->uri->segment_array()))
                            { ?>

                                <li>
                                    <a href="<?php echo site_url('admin/dcn/create'); ?>">
                                        Add/Edit Documentation </a>
                                </li>
                                <hr style="margin:8px 0;" />
                                <li class="<?php echo strpos($this->uri->uri_string(), 'products_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/1/products_manager'); ?>" class="dcn">
                                        1. Products Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'orders_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/4/orders_manager'); ?>" class="dcn">
                                        2. Orders Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'designers_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/5/designers_manager'); ?>" class="dcn">
                                        3. Designers Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'categories_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/6/categories_manager'); ?>" class="dcn">
                                        4. Designers Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'facets_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/7/facets_manager'); ?>" class="dcn">
                                        5. Facets Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'sales_package_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/13/sales_package_manager'); ?>" class="dcn">
                                        6. Sales Package Manager </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        7. Newsletter Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'wholesale_users_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/8/wholesale_users_manager'); ?>" class="dcn">
                                        8. Wholesale Users Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'consumer_users_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/9/consumer_users_manager'); ?>" class="dcn">
                                        9. Consumer Users Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'sales_users_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/10/sales_users_manager'); ?>" class="dcn">
                                        10. Sales Users Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'vendor_users_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/11/vendor_users_manager'); ?>" class="dcn">
                                        11. Vendor Users Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin_users_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/12/admin_users_manager'); ?>" class="dcn">
                                        12. Admin Users Manager </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        13. Appearance Manager </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        14. Pages Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'purchase_orders_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/3/purchase_orders_manager'); ?>" class="dcn">
                                        15. Vendor Purchase Orders Manager </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'sales_orders_manager') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/2/sales_orders_manager'); ?>" class="dcn">
                                        16. Sales Orders Manager </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        17. ERP Management </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        18. General </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        19. Accounts </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="dcn disabled-link disable-target">
                                        20. Features </a>
                                </li>
                                <li class="<?php echo strpos($this->uri->uri_string(), 'barcode_generator') !== FALSE ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/dcn/pages/index/14/barcode_generator'); ?>" class="dcn">
                                        21. Barcode Generator </a>
                                </li>
                                <hr class="hide" style="margin:8px 0;" />
                                <li>
                                    <a href="javascript:;" class=" disabled-link disable-target hide">
                                        Add/Edit Tasks </a>
                                </li>

                                <?php
                            } ?>

                        </ul>

                    </div>
