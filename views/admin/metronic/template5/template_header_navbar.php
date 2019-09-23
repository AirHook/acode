                            <ul class="nav navbar-nav">

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo in_array('dashboard', $this->uri->segment_array()) ? 'active open selected' : ''; ?> ">
                                    <a href="<?php echo site_url('admin/dashboard'); ?>" class="text-uppercase">
                                        <i class="icon-home hidden-md"></i> Dashboard
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">
                                        <li>
                                            <a href="<?php echo site_url('admin/settings/general'); ?>">
                                                General Settings </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/products'); ?>">
                                                Products Manager </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>">
                                                Sales Manager </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/users/wholesale'); ?>">
                                                Users Manager </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/inventory/physical'); ?>">
                                                Inventory Manager </a>
                                        </li>

                                        <?php
                                        // available only on hub sites only for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li>
                                            <a href="<?php echo site_url('admin/production'); ?>">
                                                Production Manager </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/accounting'); ?>">
                                                Accounting Manager </a>
                                        </li>
                                            <?php
                                        } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown hidden-md hidden-lg <?php echo in_array('dashboard', $this->uri->segment_array()) ? 'active selected' : ''; ?> ">
                                    <a href="<?php echo site_url('admin/dashboard'); ?>" class="text-uppercase">
                                        <i class="icon-home hidden-md"></i> Dashboard
                                    </a>
                                </li>

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo (! empty(array_intersect(array('themes','settings','change_pass','accounts','webspaces','dcn'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/settings/general'); ?>" class="text-uppercase">
                                        <i class="icon-settings hidden-md"></i> General
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/change_pass') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/change_pass'); ?>">
                                                Admin Change Password </a>
                                        </li>
                                            <?php
                                        } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/settings') !== FALSE ? 'active' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Settings
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/general') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/general'); ?>">
                                                        General Settings </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/meta') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/meta'); ?>">
                                                        Site SEO </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/options') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/options'); ?>">
                                                        Site Options </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(dcn|accounts|webspaces)', $this->uri->uri_string()) === 1 ? 'active' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Tools
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/dcn') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/dcn/create'); ?>">
                                                        Documentation </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                    <li class="<?php echo strpos($this->uri->uri_string(), 'admin/accounts') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/accounts'); ?>">
                                                        Accounts </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/webspaces') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/webspaces'); ?>">
                                                        Webspaces </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('sales'); ?>" target="_blank">
                                                        Link to Sales User Dashboard </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target">
                                                Task Manager </a>
                                        </li>
                                            <li class="hide">
                                                <a href="javascript:;" class=" disabled-link disable-target">
                                                    List Tasks </a>
                                            </li>
                                            <li class="hide">
                                                <a href="javascript:;" class=" disabled-link disable-target">
                                                    Add Task </a>
                                            </li>

                                        <li class="hide">
                                            <a href="javascript:;" class="text-uppercase " style="cursor:default;">
                                                Layout Manager </a>
                                        </li>
                                            <li>
                                                <a href="<?php echo site_url('admin/themes'); ?>">
                                                    Themes </a>
                                            </li>
                                        -->

                                        <li class="dropdown more-dropdown-sub">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Pages Manager </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Pages </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Add New Page </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Reports Manager </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Sales Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Orders Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Click Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Stock Report </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Newsletter Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        List Newletters </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Create Newletter </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-md hidden-lg <?php echo (! empty(array_intersect(array('themes','settings','change_pass','accounts','webspaces','dcn'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="javascript:;" class="text-uppercase">
                                        <i class="icon-settings hidden-md"></i> General
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/change_pass') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/change_pass'); ?>">
                                                Admin Change Password </a>
                                        </li>
                                            <?php
                                        } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/settings') !== FALSE ? 'active' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Settings
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/general') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/general'); ?>">
                                                        General Settings </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/meta') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/meta'); ?>">
                                                        Site SEO </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/settings/options') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/settings/options'); ?>">
                                                        Site Options </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(dcn|accounts|webspaces)', $this->uri->uri_string()) === 1 ? 'active' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Tools
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/dcn') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/dcn/create'); ?>">
                                                        Documentation </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                    <li class="<?php echo strpos($this->uri->uri_string(), 'admin/accounts') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/accounts'); ?>">
                                                        Accounts </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/webspaces') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/webspaces'); ?>">
                                                        Webspaces </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('sales'); ?>" target="_blank">
                                                        Link to Sales User Dashboard </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target">
                                                Task Manager </a>
                                        </li>
                                            <li class="hide">
                                                <a href="javascript:;" class=" disabled-link disable-target">
                                                    List Tasks </a>
                                            </li>
                                            <li class="hide">
                                                <a href="javascript:;" class=" disabled-link disable-target">
                                                    Add Task </a>
                                            </li>

                                        <li class="hide">
                                            <a href="javascript:;" class="text-uppercase " style="cursor:default;">
                                                Layout Manager </a>
                                        </li>
                                            <li>
                                                <a href="<?php echo site_url('admin/themes'); ?>">
                                                    Themes </a>
                                            </li>
                                        -->

                                        <li class="dropdown more-dropdown-sub">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Pages Manager </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Pages </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Add New Page </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Reports Manager </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Sales Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Orders Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Click Report </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Stock Report </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub open">
                                            <a href="javascript:;" class="text-uppercase disabled-link disable-target" style="cursor:default;">
                                                Newsletter Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        List Newletters </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Create Newletter </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo (! empty(array_intersect(array('designers','categories','products','facets'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/products'); ?>" class="text-uppercase">
                                        <i class="icon-puzzle hidden-md"></i> Product Mgr
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/designers') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Designers
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/designers' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/designers'); ?>">
                                                        All Designers </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/designers/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/designers/add'); ?>">
                                                        Add New Designer </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/categories') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Categories
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/categories' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/categories'); ?>">
                                                        List Categories </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/categories/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/categories/add'); ?>">
                                                        Add New Category </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/products/index') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/products'); ?>">
                                                All Products </a>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/products/add'); ?>">
                                                Add Single Product Number </a>
                                        </li>
                                        -->
                                        <li class="<?php echo $this->uri->uri_string() == 'admin/products/add/multiple_upload_images' ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/products/add/multiple_upload_images'); ?>">
                                                Add Multiple Product via Images </a>
                                        </li>

                                        <li class="<?php echo $this->uri->uri_string() == 'admin/products/color_variants' ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/products/color_variants'); ?>">
                                                Color Variants Manager </a>
                                        </li>
                                        <li class="<?php echo $this->uri->uri_string() == 'admin/facets' ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/facets'); ?>">
                                                Facets Manager </a>
                                        </li>

                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/products/crunch_images'); ?>">
                                                Mass Update Images </a>
                                        </li>
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/media_library/products'); ?>">
                                                Product Media Library </a>
                                        </li>
                                        -->
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-md hidden-lg <?php echo (! empty(array_intersect(array('designers','categories','products','facets'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="javascript:;" class="text-uppercase">
                                        <i class="icon-puzzle hidden-md"></i> Product Mgr
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/designers') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Designers
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/designers' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/designers'); ?>">
                                                        All Designers </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/designers/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/designers/add'); ?>">
                                                        Add New Designer </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/categories') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Categories
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/categories' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/categories'); ?>">
                                                        List Categories </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/categories/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/categories/add'); ?>">
                                                        Add New Category </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/products/index') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/products'); ?>">
                                                All Products </a>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/products/add'); ?>">
                                                Add Single Product Number </a>
                                        </li>
                                        -->
                                        <li class="<?php echo $this->uri->uri_string() == 'admin/products/add/multiple_upload_images' ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/products/add/multiple_upload_images'); ?>">
                                                Add Multiple Product via Images </a>
                                        </li>

                                        <li class="<?php echo $this->uri->uri_string() == 'admin/products/color_variants' ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/products/color_variants'); ?>">
                                                Color Variants Manager </a>
                                        </li>
                                        <li class="<?php echo $this->uri->uri_string() == 'admin/facets' ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/facets'); ?>">
                                                Facets Manager </a>
                                        </li>

                                        <!-- keeping this here for plausible usage
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/products/crunch_images'); ?>">
                                                Mass Update Images </a>
                                        </li>
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/media_library/products'); ?>">
                                                Product Media Library </a>
                                        </li>
                                        -->
                                        <?php } ?>

                                    </ul>
                                </li>

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo (! empty(array_intersect(array('campaigns','sales_orders','purchase_orders','orders'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/sales_orders'); ?>" class="text-uppercase">
                                        <i class="icon-tag hidden-md"></i> Order Manager
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/campaigns') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="text-uppercase">
                                                Sales Package Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>">
                                                        List Sales Packages </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Create Sales Package </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/sales_orders') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/sales_orders'); ?>" class="text-uppercase">
                                                Sales Order Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/sales_orders' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/sales_orders'); ?>">
                                                        List Sales Orders </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/sales_orders/create' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/sales_orders/create'); ?>">
                                                        Create New Sales Order </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(purchase_orders)', $this->uri->uri_string()) === 1 ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/purchase_orders'); ?>" class="text-uppercase">
                                                Purchase Order Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/purchase_orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/purchase_orders'); ?>">
                                                        List Puchase Orders </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/purchase_orders/create') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/purchase_orders/create'); ?>">
                                                        Create New Purchase Order </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(admin/orders)', $this->uri->uri_string()) === 1 ? 'active selected' : ''; ?> ">
                                            <a href="<?php echo site_url('admin/orders'); ?>" class="text-uppercase">
                                                Order Logs
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/orders'); ?>">
                                                        Wholesale Order Logs </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/orders'); ?>">
                                                        Retail Order Logs </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-md hidden-lg <?php echo (! empty(array_intersect(array('campaigns','sales_orders','purchase_orders','orders'),$this->uri->segment_array()))) ? 'active open selected' : ''; ?>" >
                                    <a href="javascript:;" class="text-uppercase">
                                        <i class="icon-tag hidden-md"></i> Order Manager
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/campaigns') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Sales Package Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>">
                                                        List Sales Packages </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class=" disabled-link disable-target">
                                                        Create Sales Package </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/sales_orders') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Sales Order Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/sales_orders' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/sales_orders'); ?>">
                                                        List Sales Orders </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/sales_orders/create' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/sales_orders/create'); ?>">
                                                        Create New Sales Order </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(purchase_orders|admin/orders)', $this->uri->uri_string()) === 1 ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Purchase Order Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/purchase_orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/purchase_orders'); ?>">
                                                        List Puchase Orders </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/purchase_orders/create') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/purchase_orders/create'); ?>">
                                                        Create New Purchase Order </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo preg_match('(purchase_orders|admin/orders)', $this->uri->uri_string()) === 1 ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Order Logs
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/orders'); ?>">
                                                        Wholesale Order Logs </a>
                                                </li>
                                                <li class="<?php echo strpos($this->uri->uri_string(), 'admin/orders') !== FALSE ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/orders'); ?>">
                                                        Retail Order Logs </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo in_array('users', $this->uri->segment_array()) ? 'active open selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/users/wholesale'); ?>" class="text-uppercase">
                                        <i class="icon-users hidden-md"></i> Users </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">
                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/admin') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Admin Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/admin' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/admin'); ?>">
                                                        List Admin Users </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/admin/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/admin/add'); ?>">
                                                        Add New Admin User </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/sales') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Sales Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales'); ?>">
                                                        List Sales Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales/add'); ?>">
                                                        Add New Sales User </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales/csv' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales/csv'); ?>">
                                                        CSV Manage Sales User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/vendor') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Vendor Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor'); ?>">
                                                        List Vendor Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/add'); ?>">
                                                        Add New Vendor User </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/types' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/types'); ?>">
                                                        Manage Vendor Types </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/csv' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/csv'); ?>">
                                                        CSV Manage Vendor User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/wholesale') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Wholesale Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/wholesale' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/wholesale'); ?>">
                                                        List Wholesale Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/wholesale/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/wholesale/add'); ?>">
                                                        Add New Wholesale User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/consumer') !== FALSE ? 'active selected' : ''; ?> ">
                                            <a href="javascript:;" class="text-uppercase">
                                                Consumer Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/consumer' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/consumer'); ?>">
                                                        List Consumer Users </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/consumer/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/consumer/add'); ?>">
                                                        Add New Consumer User </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-md hidden-lg <?php echo in_array('users', $this->uri->segment_array()) ? 'active open selected' : ''; ?>" >
                                    <a href="javascript:;" class="text-uppercase">
                                        <i class="icon-users hidden-md"></i> Users </a>
                                    <ul class="dropdown-menu dropdown-menu-fw">
                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/admin') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Admin Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/admin' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/admin'); ?>">
                                                        List Admin Users </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/admin/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/admin/add'); ?>">
                                                        Add New Admin User </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/sales') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Sales Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales'); ?>">
                                                        List Sales Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales/add'); ?>">
                                                        Add New Sales User </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/sales/csv' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/sales/csv'); ?>">
                                                        CSV Manage Sales User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/vendor') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Vendor Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor'); ?>">
                                                        List Vendor Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/add'); ?>">
                                                        Add New Vendor User </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/types' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/types'); ?>">
                                                        Manage Vendor Types </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/vendor/csv' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/vendor/csv'); ?>">
                                                        CSV Manage Vendor User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/wholesale') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Wholesale Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/wholesale' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/wholesale'); ?>">
                                                        List Wholesale Users </a>
                                                </li>
                                                <?php
                                                // available only on hub sites for now
                                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                                { ?>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/wholesale/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/wholesale/add'); ?>">
                                                        Add New Wholesale User </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                        <?php
                                        // available only on hub sites for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="dropdown more-dropdown-sub <?php echo strpos($this->uri->uri_string(), 'admin/users/consumer') !== FALSE ? 'active selected' : ''; ?> open">
                                            <a href="javascript:;" class="text-uppercase">
                                                Consumer Users Manager
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/consumer' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/consumer'); ?>">
                                                        List Consumer Users </a>
                                                </li>
                                                <li class="<?php echo $this->uri->uri_string() == 'admin/users/consumer/add' ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('admin/users/consumer/add'); ?>">
                                                        Add New Consumer User </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>

                                <!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
                                <!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown -->
                                <!-- DOC: use class "open" on active to show fw dropdown items -->
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo in_array('inventory', $this->uri->segment_array()) ? 'active open selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/inventory/physical'); ?>" class="text-uppercase">
                                        <i class="icon-social-dropbox hidden-md"></i> Inventory
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/available') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/available'); ?>">
                                                Available Stocks </a>
                                        </li>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/physical') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/physical'); ?>">
                                                Physical Stocks </a>
                                        </li>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/onorder') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/onorder'); ?>">
                                                On-Order Stocks </a>
                                        </li>

                                        <?php
                                        // available only on hub sites only for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li class="hide">
                                            <a href="javascript:;" class=" disabled-link disable-target">
                                                Stocks Reports </a>
                                        </li>

                                        <hr class="hide" style="margin:8px 0;" />
                                        <li class="hide">
                                            <a href="<?php echo site_url('admin/inventory/barcode_scaning'); ?>">
                                                Scaning Barcodes </a>
                                        </li>

                                        <li>
                                            <button class="btn btn-link btn-sm" href="#modal-barcode_scan" data-toggle="modal" style="color:#6c7b88;">
                                                SCAN BARCODES </button>
                                        </li>
                                            <?php
                                        } ?>

                                    </ul>
                                </li>
                                <?php
                                /*********
                                 * Mobile Nav
                                 */
                                ?>
                                <li class="dropdown dropdown-fw dropdown-fw-disabled hidden-md hidden-lg <?php echo in_array('inventory', $this->uri->segment_array()) ? 'active open selected' : ''; ?>" >
                                    <a href="javascript:;" class="text-uppercase">
                                        <i class="icon-social-dropbox hidden-md"></i> Inventory
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/available') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/available'); ?>">
                                                Available Stocks </a>
                                        </li>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/physical') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/physical'); ?>">
                                                Physical Stocks </a>
                                        </li>
                                        <li class="<?php echo strpos($this->uri->uri_string(), 'admin/inventory/onorder') !== FALSE ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/inventory/onorder'); ?>">
                                                On-Order Stocks </a>
                                        </li>

                                        <?php
                                        // available only on hub sites only for now
                                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                                        { ?>
                                        <li>
                                            <button class="btn btn-link btn-sm" href="#modal-barcode_scan" data-toggle="modal" style="color:#6c7b88;">
                                                SCAN BARCODES </button>
                                        </li>
                                            <?php
                                        } ?>

                                    </ul>
                                </li>

                                <?php
                                // available only on hub sites only for now
                                if ($this->webspace_details->options['site_type'] == 'hub_site')
                                { ?>
                                <li class="dropdown <?php echo in_array('production', $this->uri->segment_array()) ? 'active selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/production'); ?>" class="text-uppercase">
                                        <i class="icon-wallet hidden-md"></i> Production Mgr </a>
                                </li>

                                <li class="dropdown <?php echo in_array('accounting', $this->uri->segment_array()) ? 'active selected' : ''; ?>" >
                                    <a href="<?php echo site_url('admin/accounting'); ?>" class="text-uppercase">
                                        <i class="icon-wallet hidden-md"></i> Accounting Mgr </a>
                                </li>
                                    <?php
                                } ?>

                            </ul>
