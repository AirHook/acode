<!-- BEGIN FORM-->
<!-- FORM =======================================================================-->
<?php echo form_open(
	'/my_account/consumer/profile',
	array(
		'class'=>'form-horizontal',
		'id'=>'form-users_consumer_edit'
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
				<!--div class="btn-group">
					<a href="<?php //echo site_url($this->config->slash_item('admin_folder').'users/consumer/add'); ?>" class="btn sbold blue"> Add a New User
						<i class="fa fa-plus"></i>
					</a>
				</div-->
			</div>
			<div class="col-md-9">
				<button type="submit" class="btn red-flamingo">Update</button>
				<a href="<?php echo site_url('/my_account/consumer/orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
				<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_consumer_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
		<div class="notification">
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
			<label class="col-md-3 control-label">Email
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="email" class="form-control" value="<?php echo $this->consumer_user_details->email; ?>" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">First Name
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="firstname" type="text" class="form-control" value="<?php echo $this->consumer_user_details->fname; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Last Name
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="lastname" type="text" class="form-control" value="<?php echo $this->consumer_user_details->lname; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Company
			</label>
			<div class="col-md-4">
				<input name="company" type="text" class="form-control" value="<?php echo $this->consumer_user_details->store_name; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Telephone
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="telephone" type="text" class="form-control" value="<?php echo $this->consumer_user_details->telephone; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Address 1
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="address1" type="text" class="form-control" value="<?php echo $this->consumer_user_details->address1; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Address 2
			</label>
			<div class="col-md-4">
				<input name="address2" type="text" class="form-control" value="<?php echo $this->consumer_user_details->address2; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">City
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="city" type="text" class="form-control" value="<?php echo $this->consumer_user_details->city; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">State
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<select class="form-control select2me" name="state_province">
					<option value="">Select...</option>
					<?php foreach (list_states() as $state) { ?>
					<option value="<?php echo $state->state_name; ?>" <?php echo $this->consumer_user_details->state === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
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
					<option value="<?php echo $country->countries_name; ?>" <?php echo $this->consumer_user_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Zip Code
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="zip_postcode" type="text" class="form-control" value="<?php echo $this->consumer_user_details->zipcode; ?>" />
			</div>
		</div>

		<hr />

		<div class="form-group">
			<div class="col-md-offset-3 col-md-4">
				<input type="checkbox" class="change-password" name="change-password" value="1" tabindex="-1" /> Change password
			</div>
		</div>
		<div class="form-group hide-password display-none">
			<label class="control-label col-md-3">Password
			</label>
			<div class="col-md-4">
				<input type="password" id="password" name="password" class="form-control" />
				<cite class="help-block small"> Enter new password </cite>
				<input type="checkbox" class="show-password" tabindex="-1" /> Show password
			</div>
		</div>
		<div class="form-group hide-password display-none">
			<label class="control-label col-md-3">Confirm Password
			</label>
			<div class="col-md-4">
				<input type="password" name="passconf" class="form-control" />
				<cite class="help-block small"> Re-type your password here </cite>
			</div>
		</div>
	</div>

	<hr />
	<div class="form-actions bottom">
		<div class="row">
			<div class="col-md-3 text-right">
				<!--div class="btn-group">
					<a href="<?php //echo site_url($this->config->slash_item('admin_folder').'users/consumer/add'); ?>" class="btn sbold blue" tabindex="-98"> Add a New User
						<i class="fa fa-plus"></i>
					</a>
				</div-->
			</div>
			<div class="col-md-9">
				<button type="submit" class="btn red-flamingo">Update</button>
				<a href="<?php echo site_url('/my_account/consumer/orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
				<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_consumer_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
			</div>
		</div>
	</div>
</form>
<!-- END FORM-->
<!-- DELETE ITEM -->
<div class="modal fade bs-modal-sm" id="delete-<?php echo $this->consumer_user_details->user_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Warning!</h4>
			</div>
			<div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/delete/index/'.$this->consumer_user_details->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
					<span class="ladda-label">Confirm?</span>
					<span class="ladda-spinner"></span>
				</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
