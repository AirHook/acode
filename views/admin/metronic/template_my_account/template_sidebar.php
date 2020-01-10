<?php
if ($role=='sales')
{ ?>
	<ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
		<li class="heading">
			<h3 class="uppercase">
				<a href="<?php echo site_url('my_account/sales/dashboard'); ?>" class="nav-link ">
					Dashboard
				</a>
			</h3>
		</li>

		<li class="heading">
			<h3 class="uppercase">Products</h3>
		</li>
		<li class="nav-item <?php echo $this->uri->segment(3) == 'products' ? 'active' : ''; ?> ">
			<a href="<?php echo site_url('my_account/sales/products'); ?>" class="nav-link ">
				<span class="title uppercase">All Products</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'products' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->segment(4) == 'is_public' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/is_public'); ?>" class="nav-link  ">
						<span class="title">Public</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(4) == 'not_publicj' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/not_public'); ?>" class="nav-link  ">
						<span class="title">Private</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(4) == 'unpublished' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/unpublished'); ?>" class="nav-link  ">
						<span class="title">Unpublished</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(4) == 'instock' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/instock'); ?>" class="nav-link  ">
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

		<li class="heading">
			<h3 class="uppercase">Orders</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/orders'); ?>" class="nav-link ">
				<span class="title">Order Logs</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">Sales Orders</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales_orders'); ?>" class="nav-link  ">
				<span class="title">My Sales Order</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders/create' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales_orders/create'); ?>" class="nav-link  ">
				<span class="title">Create New Sales Order</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">Purchase Orders</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders' ? 'active' : ''; ?>">
			<a href="javascript:;" class="nav-link  ">
				<span class="title">My Purchase Orders</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders/create' ? 'active' : ''; ?>">
			<a href="javascript:;" class="nav-link  ">
				<span class="title">Create New Purchase Order</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">Sales Packages</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_package' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales_package'); ?>" class="nav-link  ">
				<span class="title">My Sales Package</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales_package/create' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales_package/create'); ?>" class="nav-link  ">
				<span class="title">Create Sales Package</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">Users</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/users/wholesale' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/wholesale'); ?>" class="nav-link  ">
				<span class="title">My Wholesale Users</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/users/wholesale/add' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/wholesale/add'); ?>" class="nav-link  ">
				<span class="title">Add Wholesale User</span>
			</a>
		</li>
	</ul>
	<?php
}
elseif ($role=='vendors')
{ ?>
	<ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
		<li class="heading">
			<h3 class="uppercase">
				<a href="<?php echo site_url('my_account/vendors/dashboard'); ?>" class="nav-link ">
					Dashboard
				</a>
			</h3>
		</li>
		<li class="heading">
			<h3 class="uppercase">
				<a href="<?php echo site_url('my_account/vendors/profile'); ?>" class="nav-link ">
					My Info
				</a>
			</h3>
		</li>
		<li class="heading">
			<h3 class="uppercase">Products</h3>
		</li>
		<li class="nav-item active">
			<a href="<?php echo site_url('my_account/vendors/products'); ?>" class="nav-link ">
				<span class="title uppercase">All Products</span>
			</a>
		</li>
		<li class="nav-item with-heading active">
			<a class="nav-link ">
				<span class="title uppercase">Categories</span>
				<span class="arrow open"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item active open">
					<a href="<?php echo site_url('my_account/vendors/categories'); ?>" class="nav-link">
						<span class="title">Category List</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="heading">
			<h3 class="uppercase">Orders</h3>
		</li>
		<li class="nav-item with-heading active">
			<a class="nav-link ">
				<span class="title uppercase">My Purchase Orders</span>
				<span class="arrow open"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item open active <?php echo $this->uri->uri_string() == 'my_account/vendors/categories' ? 'active' : ''; ?>">
					<a href="<?php echo site_url('my_account/vendors/listorders'); ?>" class="nav-link">
						<span class="title">List Purchase Orders</span>
					</a>
				</li>
			</ul>
		</li>
	</ul>
	<?php
}
else
{ ?>
	<ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
		<li class="nav-item start ">
			<a href="<?php echo site_url('my_account/sales/dashboard'); ?>" class="nav-link ">
				<span class="title">Dashboard</span>
			</a>
		</li>
		<li class="heading">
			<h3 class="uppercase">Products</h3>
		</li>
		<li class="nav-item <?php echo $this->uri->segment(2) == 'products' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/products'); ?>" class="nav-link ">
				<span class="title uppercase">All Products</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'products' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->segment(3) == 'is_public' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/is_public'); ?>" class="nav-link">
						<span class="title">Public</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(3) == 'not_publicj' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/not_public'); ?>" class="nav-link">
						<span class="title">Private</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(3) == 'unpublished' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/unpublished'); ?>" class="nav-link">
						<span class="title">Unpublished</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->segment(3) == 'instock' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/products/instock'); ?>" class="nav-link">
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
			<li class="nav-item <?php echo $this->uri->uri_string() == 'my_account/sales/desiproducts/add' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/sales/products/add'); ?>" class="nav-link ">
					<span class="title">Add New Product</span>
				</a>
			</li>
		<li class="nav-item <?php echo $this->uri->uri_string() == 'my_account/sales/desiproducts/add/multiple_upload_images' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/products/add/multiple_upload_images'); ?>" class="nav-link ">
				<span class="title">Add Multiple Product via Images</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'designers' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/designers'); ?>" class="nav-link ">
				<span class="title uppercase">Designers</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'designers' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/designers' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/designers'); ?>" class="nav-link">
						<span class="title">Designer List</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/designers/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/designers/add'); ?>" class="nav-link">
						<span class="title">Add New Designer</span>
					</a>
				</li>
			</ul>
		</li>
			<?php
		} ?>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'categories' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/categories'); ?>" class="nav-link ">
				<span class="title uppercase">Categories</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'categories' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/categories' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/categories'); ?>" class="nav-link">
						<span class="title">Category List</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/categories/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/categories/add'); ?>" class="nav-link">
						<span class="title">Add New Category</span>
					</a>
				</li>
			</ul>
		</li>
		<?php
		// available only on hub sites for now
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{ ?>
		<li class="nav-item <?php echo $this->uri->uri_string() == 'my_account/sales/desiproducts/color_variants' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/products/color_variants'); ?>" class="nav-link ">
				<span class="title">Color Variants Manager</span>
			</a>
		</li>
		<li class="nav-item <?php echo $this->uri->uri_string() == 'my_account/sales/facets' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/facets'); ?>" class="nav-link ">
				<span class="title">Facets Manager</span>
			</a>
		</li>
			<?php
		} ?>

		<li class="heading">
			<h3 class="uppercase">Orders</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/orders'); ?>" class="nav-link ">
				<span class="title">Order Logs</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'sales_package' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/campaigns/sales_package'); ?>" class="nav-link ">
				<span class="title uppercase">Sales Package Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'sales_package' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/campaigns/sales_package' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/campaigns/sales_package'); ?>" class="nav-link">
						<span class="title">List Sales Package</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/campaigns/sales_package/create' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/campaigns/sales_package/create'); ?>" class="nav-link">
						<span class="title">Create Sales Package</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'sales_orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales_orders'); ?>" class="nav-link ">
				<span class="title uppercase">Sales Order Manager</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'sales_orders' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/sales_orders'); ?>" class="nav-link">
						<span class="title">List Sales Order</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/sales_orders/create' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/sales_orders/create'); ?>" class="nav-link">
						<span class="title">Create New Sales Order</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/purchase_orders'); ?>" class="nav-link ">
				<span class="title uppercase">Purchase Order Manager</span>
				<span class="arrow <?php echo $this->uri->segment(2) == 'purchase_orders' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/purchase_orders' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/purchase_orders'); ?>" class="nav-link">
						<span class="title">List Purchase Order</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/purchase_orders/create' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/purchase_orders/create'); ?>" class="nav-link">
						<span class="title">Create New Purchase Order</span>
					</a>
				</li>
			</ul>
		</li>

		<li class="heading">
			<h3 class="uppercase">Users</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'wholesale' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/wholesale'); ?>" class="nav-link ">
				<span class="title uppercase">Wholesale Users Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'purchase_orders' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo ($this->uri->uri_string() == 'my_account/sales/users/wholesale/active' OR $this->uri->uri_string() == 'my_account/sales/users/wholesale/inactive' OR $this->uri->uri_string() == 'my_account/sales/users/wholesale/suspended') ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/wholesale'); ?>" class="nav-link">
						<span class="title">List Wholesale Users</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/wholesale/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/wholesale/add'); ?>" class="nav-link">
						<span class="title">Add New Wholesale User</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'consumer' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/consumer'); ?>" class="nav-link ">
				<span class="title uppercase">Consumer Users Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'consumer' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo ($this->uri->uri_string() == 'my_account/sales/users/consumer/active' OR $this->uri->uri_string() == 'my_account/sales/users/consumer/inactive' OR $this->uri->uri_string() == 'my_account/sales/users/consumer/suspended') ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/consumer'); ?>" class="nav-link">
						<span class="title">List Consumer Users</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/consumer/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/consumer/add'); ?>" class="nav-link">
						<span class="title">Add New Consumer User</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'sales' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/sales'); ?>" class="nav-link ">
				<span class="title uppercase">Sales Users Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'sales' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo ($this->uri->uri_string() == 'my_account/sales/users/sales/active' OR $this->uri->uri_string() == 'my_account/sales/users/sales/inactive' OR $this->uri->uri_string() == 'my_account/sales/users/sales/suspended') ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/sales'); ?>" class="nav-link">
						<span class="title">List Sales Users</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/sales/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/sales/add'); ?>" class="nav-link">
						<span class="title">Add New Sales User</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'vendor' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/vendor'); ?>" class="nav-link ">
				<span class="title uppercase">Vendor Users Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'vendor' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/vendor' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/vendor'); ?>" class="nav-link">
						<span class="title">List Vendor Users</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/vendor/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/vendor/add'); ?>" class="nav-link">
						<span class="title">Add New Vendor User</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(3) == 'admin' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/users/admin'); ?>" class="nav-link ">
				<span class="title uppercase">Admin Users Manager</span>
				<span class="arrow <?php echo $this->uri->segment(3) == 'admin' ? 'open' : ''; ?>"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/admin' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/admin'); ?>" class="nav-link">
						<span class="title">List Admin Users</span>
					</a>
				</li>
				<li class="nav-item  <?php echo $this->uri->uri_string() == 'my_account/sales/users/my_account/sales/add' ? 'active open' : ''; ?>">
					<a href="<?php echo site_url('my_account/sales/users/my_account/sales/add'); ?>" class="nav-link">
						<span class="title">Add New Admin User</span>
					</a>
				</li>
			</ul>
		</li>

		<li class="heading">
			<h3 class="uppercase">Inventory</h3>
		</li>
		<li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'my_account/sales/inventory/physical') === FALSE ? '' : 'active'; ?>">
			<a href="<?php echo site_url('my_account/sales/inventory/physical'); ?>" class="nav-link ">
				<span class="title">Physical Stocks</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'my_account/sales/inventory/available') === FALSE ? '' : 'active'; ?>">
			<a href="<?php echo site_url('my_account/sales/inventory/available'); ?>" class="nav-link ">
				<span class="title">Available Stocks</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo strpos($this->uri->uri_string(), 'my_account/sales/inventory/onorder') === FALSE ? '' : 'active'; ?>">
			<a href="<?php echo site_url('my_account/sales/inventory/onorder'); ?>" class="nav-link ">
				<span class="title">On-Order Stocks</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">Others</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'production' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/production'); ?>" class="nav-link ">
				<span class="title">Production</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->segment(2) == 'accounting' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/accounting'); ?>" class="nav-link ">
				<span class="title">Accounting</span>
			</a>
		</li>

		<li class="heading">
			<h3 class="uppercase">General</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/settings/general' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/settings/general'); ?>" class="nav-link ">
				<span class="title">General Settings</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/settings/meta' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/settings/meta'); ?>" class="nav-link ">
				<span class="title">Site SEO</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/settings/options' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/settings/options'); ?>" class="nav-link ">
				<span class="title">Site Options</span>
			</a>
		</li>
		<?php
		// available only on hub sites for now
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{ ?>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/chagne_pass' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/change_pass'); ?>" class="nav-link ">
				<span class="title">Admin Change Password</span>
			</a>
		</li>
			<?php
		} ?>

		<li class="heading">
			<h3 class="uppercase">Tools</h3>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/dcn/create' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/dcn/create'); ?>" class="nav-link ">
				<span class="title">Documentation</span>
			</a>
		</li>
		<?php
		// available only on hub sites for now
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{ ?>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/accounts' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/accounts'); ?>" class="nav-link ">
				<span class="title">Accounts</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/webspaces' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/webspaces'); ?>" class="nav-link ">
				<span class="title">Webspaces</span>
			</a>
		</li>
		<li class="nav-item with-heading <?php echo $this->uri->uri_string() == 'my_account/sales/sales' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/sales/sales'); ?>" class="nav-link ">
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
	<?php
} ?>
