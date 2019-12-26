<ul class="nav navbar-nav">

	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<!--li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/dashboard' ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/dashboard'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Dashboard
		</a>
	</li-->
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<!--li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/dashboard' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/dashboard'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> Dashboard
		</a>
	</li-->

	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo strpos($this->uri->uri_string(), 'my_account/'.$role.'/orders') !== false ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Orders
		</a>
	</li>
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/orders' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Orders
		</a>
	</li>
	
	<?php if($role=='sales') { ?>
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo strpos($this->uri->uri_string(), 'my_account/'.$role.'/users') !== false ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/users'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Wholesale Users
		</a>
	</li>
	<!--*********
	 * Mobile Nav
	 *-->
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/users' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/users'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Wholesale Users
		</a>
	</li>
	<?php } ?>
	<!-- DOC: Add class "more-dropdown" to make nav item drop down on hover -->
	<!-- DOC: Add classes "dropdown-fw dropdown-fw-disabled" to disable dropdown but with more sub menu items -->
	<!-- DOC: use class "open" on active to show fw dropdown items -->
	<li class="dropdown dropdown-fw dropdown-fw-disabled hidden-xs hidden-sm <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/profile' ? 'active open selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Info
		</a>
	</li>
	<?php
	/*********
	 * Mobile Nav
	 */
	?>
	<li class="dropdown hidden-md hidden-lg <?php echo $this->uri->uri_string() == 'my_account/'.$role.'/profile' ? 'active selected' : ''; ?> ">
		<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>" class="text-uppercase">
			<i class="icon-home hidden-md"></i> My Info
		</a>
	</li>

</ul>
