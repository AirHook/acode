<!-- BEGIN HEADER SEARCH BOX -->
<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
<!-- DOC: Apply "open" right after the "search-form" class to have full expanded search box --
<form class="search-form search-form-expanded " action="page_general_search_2.html" method="GET">
<!-- FORM =======================================================================-->
<?php echo form_open(
	'my_account/sales/products/search',
	array(
		'method'=>'POST',
		'class'=>'search-form search-form-expanded '
	)
); ?>
	<div class="input-group">
		<input type="text" class="form-control input-sm search_by_style__" placeholder="Search..." name="style_no">
		<span class="input-group-btn">
			<a href="javascript:;" class="btn submit">
				<i class="icon-magnifier"></i>
			</a>
		</span>
	</div>
</form>
<!-- END HEADER SEARCH BOX -->

<!-- BEGIN SEARCH -->
<!-- FORM =======================================================================-->
<?php echo form_open(
	'my_account/sales/search',
	array(
		'method'=>'POST',
		//'id'=>'form-admin_tobbar_search',
		'class'=>'search search-form open hide'
		//'style'=>'padding:8px 10px;'
	)
); ?>
	<div class="input-group">
		<input type="text" class="form-control input-sm search_by_style" id="search_by_style_" name="style_no" placeholder="Search..." style="text-transform:uppercase;"/>
		<span class="input-group-btn">
			<a href="javascript:;" class="btn submit md-skip">
				<i class="fa fa-search"></i>
			</a>
		</span>
	</div>
</form>
<!-- End FORM ===================================================================-->
<!-- END FORM-->
<!-- END SEARCH -->

<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">

	<?php
	// let's set the role for sales user my account
	if (@$role == 'sales') $profile_pre_link = 'my_account/sales';
	elseif (@$role == 'vendor') $profile_pre_link = 'my_account/vendors';
	else 'admin';
	?>

	<ul class="nav navbar-nav pull-right">
		<li class="dropdown dropdown-user dropdown-dark">
			<a href="<?php echo site_url($profile_pre_link.'/dashboard'); ?>" class="dropdown-toggle">
				<?php
				// since we are using the template for sales user and possibly vendor users,
				// we use a common variable to show the name on the top bar
				// put the varialbe at the controller library class
				?>
				<span class="username" style="font-weight:normal;"> Welcome, <?php echo @$top_bar_welcome_name ?: 'Guest'; ?>! </span>
			</a>
		</li>
		<li class="dropdown dropdown-user dropdown-dark">
			<!--<a href="javascript:;" class="dropdown-toggle disabled-link disable-target">-->
			<a href="<?php echo site_url($profile_pre_link.'/profile'); ?>" class="dropdown-toggle">
				<span class="username" style="font-weight:normal;"> Profile </span>
			</a>
		</li>
		<!-- BEGIN USER LOGIN DROPDOWN -->
		<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
		<li class="dropdown dropdown-user dropdown-dark">
			<a href="<?php echo site_url($profile_pre_link.'/logout'); ?>" class="dropdown-toggle">
				<span class="username" style="font-weight:normal;"> Log Out </span>
			</a>
		</li>
		<!-- END USER LOGIN DROPDOWN -->
		<!-- BEGIN QUICK SIDEBAR TOGGLER -->
		<li class="dropdown dropdown-extended quick-sidebar-toggler hide">
			<span class="sr-only">Toggle Quick Sidebar</span>
			<i class="icon-logout"></i>
		</li>
		<!-- END QUICK SIDEBAR TOGGLER -->
	</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
