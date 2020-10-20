<!-- BEGIN FORM-->
<!-- FORM =======================================================================-->
<?php echo form_open(
	(
		$this->uri->segment(1) === 'sales'
		? 'sales/wholesale/edit/index/'.$this->wholesale_user_details->user_id
		: 'my_account/wholesale/profile'
	),
	array(
		'class'=>'form-horizontal',
		'id'=>'form-users_wholesale_edit'
	)
); ?>
<div class="page-head">
	<div class="container">
		<div class="page-title">
			<h1>MY INFO</h1>
		</div>
	</div>
</div>
<div class="table-toolbar">
	<ul class="nav nav-tabs">
		<li class="<?php echo $this->uri->uri_string() == 'my_account/'.$role.'/orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>">
				All Orders
			</a>
		</li>
		<?php
		if($role=="wholesale") {
			if ($this->webspace_details->slug !== 'tempoparis') { ?>
			<li class="<?php echo $this->uri->segment(4) == 'pending' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/pending'); ?>">
					Pending Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'onhold' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/onhold'); ?>">
					On Hold Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'completed' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/completed'); ?>">
					Completed Orders
				</a>
			</li>
			<?php }
		} ?>
		<li class="<?php echo $this->uri->segment(3) == 'profile' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>">
				My Info
			</a>
		</li>
	</ul>
</div>
	<div class="form-actions top">
		<div class="row">
			<div class="col-md-3 text-right">
			</div>
			<div class="col-md-9">
				<button type="submit" class="btn red-flamingo">Update</button>
				<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url('my_account/wholesale/orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back</a>
			</div>
		</div>
	</div>

	<hr />
	<div class="form-body">

		<?php
		/***********
		 * Noification area
		 */
		?>
		<div class="notifications">
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
			<div class="alert alert-success display-hide">
				<button class="close" data-close="alert"></button> Your form validation is successful! </div>
			<?php if ($this->session->flashdata('success') == 'add') { ?>
			<div class="alert alert-success auto-remove">
				<button class="close" data-close="alert"></button> New user added. Continue editing...
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success') == 'edit') { ?>
			<div class="alert alert-success auto-remove">
				<button class="close" data-close="alert"></button> User information updated...
			</div>
			<?php } ?>
			<?php if (validation_errors()) { ?>
			<div class="alert alert-danger">
				<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
			</div>
			<?php } ?>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Sales User Association
				<span class="required"> * </span>
			</label>
			<div class="col-md-6">
				<select class="form-control select2me" name="admin_sales_email" disabled>
					<option value="">Select...</option>
					<?php if ($sales) { ?>
					<?php foreach ($sales as $sale) { ?>
					<option value="<?php echo $sale->admin_sales_email; ?>" <?php echo ($this->wholesale_user_details->admin_sales_email === $sale->admin_sales_email OR ( ! $this->wholesale_user_details->user_id && $sale->admin_sales_id === '1')) ? 'selected="selected"' : ''; ?>><?php echo ucwords(strtolower($sale->admin_sales_user.' '.$sale->admin_sales_lname)).'&nbsp; &nbsp;('.$sale->admin_sales_email.')&nbsp; &nbsp;'.$sale->designer; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-3 control-label">Primary Email
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email" class="form-control" value="<?php echo $this->wholesale_user_details->email; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Email 2
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email2" class="form-control" value="<?php echo $this->wholesale_user_details->email2; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Email 3
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email3" class="form-control" value="<?php echo $this->wholesale_user_details->email3; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Email 4
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email4" class="form-control" value="<?php echo $this->wholesale_user_details->email4; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Email 5
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email5" class="form-control" value="<?php echo $this->wholesale_user_details->email5; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Email 6
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email6" class="form-control" value="<?php echo $this->wholesale_user_details->email6; ?>" />
				</div>
				<cite class="help-block small"> Any optional emails found invalid will not be saved. </cite>
			</div>
		</div>
		<hr /> <!--------------------------------->
		<div class="tabbable-bordered">

			<!-- TABS -->
			<ul class="nav nav-tabs">
				<li class="nav-tabs-item active">
					<a href="#main_address" data-toggle="tab">
						Main Billing Address 1
					</a>
				</li>
				<li class="nav-tabs-item ">
					<a href="#alt2_address" data-toggle="tab">
						Alternate Address 2
					</a>
				</li>
				<li class="nav-tabs-item ">
					<a href="#alt3_address" data-toggle="tab">
						Alternate Address 3
					</a>
				</li>
				<li class="nav-tabs-item ">
					<a href="#alt4_address" data-toggle="tab">
						Alternate Address 4
					</a>
				</li>
				<li class="nav-tabs-item ">
					<a href="#alt5_address" data-toggle="tab">
						Alternate Address 5
					</a>
				</li>
				<li class="nav-tabs-item ">
					<a href="#alt6_address" data-toggle="tab">
						Alternate Address 6
					</a>
				</li>
			</ul>

			<!-- BEGIN TAB CONTENTS -->
			<div class="tab-content clearfix">

				<div class="tab-pane active" id="main_address">
					<div class="form-group">
						<label class="col-md-3 control-label">First Name
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="firstname" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->fname; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="lastname" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->lname; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="store_name" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->store_name; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Fed Tax ID
						</label>
						<div class="col-md-4">
							<input name="fed_tax_id" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->fed_tax_id; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Main Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="telephone" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->telephone; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number 2
						</label>
						<div class="col-md-4">
							<input name="telephone2" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->telephone2; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number 3
						</label>
						<div class="col-md-4">
							<input name="telephone3" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->telephone3; ?>" />
							<cite class="help-block small"> Contact numbers can be a landline or mobile number. </cite>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="address1" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->address1; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="address2" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->address2; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="city" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->city; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="state">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->state === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="country">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="zipcode" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->zipcode; ?>" />
						</div>
					</div>
				</div>

				<div class="tab-pane " id="alt2_address">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact First Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][firstname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['firstname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][lastname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['lastname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][store_name]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['store_name']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][telephone]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['telephone']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][address1]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['address1']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][address2]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['address2']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][city]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['city']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[2][state]">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->alt_address[2]['state'] === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[2][country]">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->alt_address[2]['country'] === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
						</label>
						<div class="col-md-4">
							<input name="alt_address[2][zipcode]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[2]['zipcode']; ?>" />
						</div>
					</div>
				</div>

				<div class="tab-pane " id="alt3_address">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact First Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][firstname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['firstname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][lastname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['lastname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][store_name]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['store_name']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][telephone]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['telephone']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][address1]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['address1']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][address2]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['address2']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][city]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['city']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[3][state]">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->alt_address[3]['state'] === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[3][country]">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->alt_address[3]['country'] === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
						</label>
						<div class="col-md-4">
							<input name="alt_address[3][zipcode]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[3]['zipcode']; ?>" />
						</div>
					</div>
				</div>

				<div class="tab-pane " id="alt4_address">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact First Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][firstname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['firstname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][lastname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['lastname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][store_name]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['store_name']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][telephone]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['telephone']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][address1]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['address1']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][address2]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['address2']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][city]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['city']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[4][state]">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->alt_address[4]['state'] === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[4][country]">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->alt_address[4]['country'] === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
						</label>
						<div class="col-md-4">
							<input name="alt_address[4][zipcode]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[4]['zipcode']; ?>" />
						</div>
					</div>
				</div>

				<div class="tab-pane " id="alt5_address">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact First Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][firstname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['firstname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][lastname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['lastname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][store_name]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['store_name']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][telephone]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['telephone']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][address1]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['address1']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][address2]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['address2']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][city]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['city']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[5][state]">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->alt_address[5]['state'] === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[5][country]">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->alt_address[5]['country'] === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
						</label>
						<div class="col-md-4">
							<input name="alt_address[5][zipcode]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[5]['zipcode']; ?>" />
						</div>
					</div>
				</div>

				<div class="tab-pane " id="alt6_address">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact First Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][firstname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['firstname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][lastname]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['lastname']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Store Name
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][store_name]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['store_name']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact Number
							<span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][telephone]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['telephone']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 1
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][address1]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['address1']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Address 2
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][address2]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['address2']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">City
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][city]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['city']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">State
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[6][state]">
								<option value="">Select...</option>
								<?php foreach (list_states() as $state) { ?>
								<option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->alt_address[6]['state'] === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Country
						</label>
						<div class="col-md-4">
							<select class="form-control select2me" name="alt_address[6][country]">
								<option value="">Select...</option>
								<?php foreach (list_countries() as $country) { ?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->alt_address[6]['country'] === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Zip Code
						</label>
						<div class="col-md-4">
							<input name="alt_address[6][zipcode]" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->alt_address[6]['zipcode']; ?>" />
						</div>
					</div>
				</div>

			</div>
		</div>
		<hr /> <!--------------------------------->
		<div class="form-group">
			<label class="col-md-3 control-label">Comments
			</label>
			<div class="col-md-4">
				<textarea class="form-control" name="comments"><?php echo $this->wholesale_user_details->comments; ?></textarea>
			</div>
		</div>
		<hr /> <!--------------------------------->
		<div class="form-group">
			<label class="control-label col-md-3">View/Edit Password
			</label>
			<div class="col-md-4">
				<input type="password" id="pword" name="pword" class="form-control input-password" value="<?php echo $this->wholesale_user_details->password; ?>" data-original_value="<?php echo $this->wholesale_user_details->password; ?>"/>
				<input type="checkbox" class="show-password" /> Show password
			</div>
		</div>
		<div class="form-group hide">
			<label class="control-label col-md-3">Confirm Password
			</label>
			<div class="col-md-4">
				<input type="password" name="passconf" class="form-control input-passconf" disabled />
				<cite class="help-block small"> Re-type your password here if you are changing it </cite>
			</div>
		</div>
	</div>

	<hr />
	<div class="form-actions bottom">
		<div class="row">
			<div class="col-md-3 text-right">
			</div>
			<div class="col-md-9">
				<button type="submit" class="btn red-flamingo">Update</button>
				<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url('my_account/wholesale/orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
				<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
			</div>
		</div>
	</div>

</form>
<!-- END FORM-->
