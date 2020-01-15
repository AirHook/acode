<!-- BEGIN HEADER SEARCH BOX -->
<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
<!-- DOC: Apply "open" right after the "search-form" class to have full expanded search box --
<form class="search-form search-form-expanded " action="page_general_search_2.html" method="GET">
<!-- FORM =======================================================================-->
<?php echo form_open(
	'my_account/sales/search',
	array(
		'method'=>'POST',
		'class'=>'search-form search-form-expanded hide'
	)
); ?>
	<div class="input-group">
		<input type="text" class="form-control input-sm search_by_style" placeholder="Search..." name="style_no">
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
	<ul class="nav navbar-nav pull-right">
		<li class="separator hide"> </li>
		<!-- BEGIN USER LOGIN DROPDOWN -->
		<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
		<li class="dropdown dropdown-user dropdown-dark">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<span class="username username-hide-on-mobile"> Welcome, <?php echo @$this->sales_user_details->fname ?: 'Guest'; ?> </span>
				<i class="fa fa-angle-down"></i>
				<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
				<img alt="" class="img-circle hide" src="../assets/layouts/layout4/img/avatar9.jpg" /> </a>
			<ul class="dropdown-menu dropdown-menu-default">
				<li>
					<a href="javascript:;" class="disabled-link disable-target">
						<i class="icon-user"></i> My Profile </a>
				</li>
				<li>
					<a href="<?php echo site_url('my_account/'.$role.'/logout'); ?>">
						<i class="icon-key"></i> Log Out </a>
				</li>
			</ul>
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
