<ul class="nav navbar-nav">

	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/dashboard' ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/dashboard'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Dashboard
		</a>
	</li>
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/dashboard' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/dashboard'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Dashboard
		</a>
	</li>

	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo strpos($this->uri->uri_string(), 'my_account/'.$role.'/orders') !== false ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Orders
		</a>
	</li>
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/orders' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Orders
		</a>
	</li>

	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/profile' ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Profile
		</a>
	</li>
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/profile' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Profile
		</a>
	</li>

</ul>
