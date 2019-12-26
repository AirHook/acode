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
				<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url('my_account/wholesale/orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
				<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
			<label class="control-label col-md-3">Status
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<select class="form-control select2me" name="is_active">
					<option value="1" <?php echo $this->wholesale_user_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
					<option value="0" <?php echo $this->wholesale_user_details->status === '0' ? 'selected="selected"' : ''; ?>>Suspended</option>
				</select>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="control-label col-md-3">Reference Designer
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<select class="form-control select2me" name="reference_designer" data-reference_designer="<?php echo $this->wholesale_user_details->reference_designer; ?>">
					<option value="">Select...</option>
					<?php if ($designers) { ?>
					<?php foreach ($designers as $designer) { ?>
					<option value="<?php echo $designer->url_structure; ?>" <?php echo ($this->wholesale_user_details->reference_designer == $designer->url_structure OR $this->wholesale_user_details->reference_designer == $designer->folder) ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
			<?php if ( ! $this->wholesale_user_details->user_id) { ?>
			<cite class="help-block small"> By default, current site is reference designer. </cite>
			<?php } ?>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Sales User Association
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<select class="form-control select2me" name="admin_sales_email">
					<option value="">Select...</option>
					<?php if ($sales) { ?>
					<?php foreach ($sales as $sale) { ?>
					<option value="<?php echo $sale->admin_sales_email; ?>" <?php echo ($this->wholesale_user_details->admin_sales_email === $sale->admin_sales_email OR ( ! $this->wholesale_user_details->user_id && $sale->admin_sales_id === '1')) ? 'selected="selected"' : ''; ?>><?php echo ucwords(strtolower($sale->admin_sales_user.' '.$sale->admin_sales_lname)).'&nbsp; &nbsp;('.$sale->admin_sales_email.')&nbsp; &nbsp;'.$sale->designer; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
			<?php if ( ! $this->wholesale_user_details->user_id) { ?>
			<cite class="help-block small"> By default, system sales admin is sales user associated. </cite>
			<?php } ?>
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
			<label class="col-md-3 control-label">Telephone
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="telephone" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->telephone; ?>" />
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
		<div class="form-group">
			<label class="col-md-3 control-label">Comments
			</label>
			<div class="col-md-4">
				<textarea class="form-control" name="comments"><?php echo $this->wholesale_user_details->comments; ?></textarea>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="control-label col-md-3">Password
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
