<!-- BEGIN FORM-->
<!-- FORM =======================================================================-->
<?php echo form_open(
	'my_account/vendors/profile',
	array(
		'class'=>'form-horizontal',
		'id'=>'form-users_vendor_edit'
	)
); ?>

	<div class="form-actions top">
		<div class="row">
			<div class="col-md-3 text-right">
			</div>
			<div class="col-md-9">
				<button type="submit" class="btn red-flamingo">Update</button>
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
		<div>
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
			<div class="alert alert-success display-hide">
				<button class="close" data-close="alert"></button> Your form validation is successful! </div>
			<?php if ($this->session->flashdata('success') == 'edit') { ?>
			<div class="alert alert-success auto-remove">
				<button class="close" data-close="alert"></button> Vendor information updated...
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
			<div class="alert alert-danger ">
				<button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
				<?php echo $this->session->flashdata('error_value'); ?>
			</div>
			<?php } ?>
			<?php if (validation_errors()) { ?>
			<div class="alert alert-danger">
				<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
			</div>
			<?php } ?>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Vendor Name
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="vendor_name" type="text" class="form-control" value="<?php echo $this->vendor_user_details->vendor_name; ?>" />
				<?php if (form_error('vendor_name')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('vendor_name'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Main Email
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="vendor_email" class="form-control" value="<?php echo $this->vendor_user_details->vendor_email; ?>" />
				</div>
				<?php if (form_error('vendor_email')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('vendor_email'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Vendor Code
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="vendor_code" type="text" class="form-control" value="<?php echo $this->vendor_user_details->vendor_code; ?>" style="text-transform:uppercase" readonly />
				<span class="help-block small"><em> Must be only up to 4 characters max. Just letters and numbers and no spaces. </em></span>
				<?php if (form_error('vendor_code')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('vendor_code'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-3 control-label">Contact 1
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="contact_1" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_1; ?>" />
				<?php if (form_error('contact_1')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('contact_1'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Contact Email 1
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="contact_email_1" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_1; ?>" />
				</div>
				<?php if (form_error('contact_email_1')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_1'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Contact 2
			</label>
			<div class="col-md-4">
				<input name="contact_2" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_2; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Contact Email 2
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="contact_email_2" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_2; ?>" />
				</div>
				<?php if (form_error('contact_email_2')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_2'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Contact 3
			</label>
			<div class="col-md-4">
				<input name="contact_3" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_3; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Contact Email 3
			</label>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
					<input type="email" name="contact_email_3" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_3; ?>" />
				</div>
				<?php if (form_error('contact_email_3')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_3'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-3 control-label">Address 1
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="address1" type="text" class="form-control" value="<?php echo $this->vendor_user_details->address1; ?>" />
				<?php if (form_error('address1')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('address1'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Address 2
			</label>
			<div class="col-md-4">
				<input name="address2" type="text" class="form-control" value="<?php echo $this->vendor_user_details->address2; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">City
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="city" type="text" class="form-control" value="<?php echo $this->vendor_user_details->city; ?>" />
				<?php if (form_error('city')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('city'); ?> </cite>
				<?php } ?>
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
					<option value="<?php echo $state->state_name; ?>" <?php echo $this->vendor_user_details->state === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
					<?php } ?>
				</select>
				<?php if (form_error('state')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('state'); ?> </cite>
				<?php } ?>
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
					<option value="<?php echo $country->countries_name; ?>" <?php echo $this->vendor_user_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
					<?php } ?>
				</select>
				<?php if (form_error('country')) { ?>
				<cite class="help-block small font-red-,mint"> <?php echo form_error('country'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Zip Code
			</label>
			<div class="col-md-4">
				<input name="zipcode" type="text" class="form-control" value="<?php echo $this->vendor_user_details->zipcode; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Telephone
				<span class="required"> * </span>
			</label>
			<div class="col-md-4">
				<input name="telephone" type="text" class="form-control" value="<?php echo $this->vendor_user_details->telephone; ?>" />
				<?php if (form_error('telephone')) { ?>
				<cite class="help-block small font-red-mint"> <?php echo form_error('telephone'); ?> </cite>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Fax
			</label>
			<div class="col-md-4">
				<input name="fax" type="text" class="form-control" value="<?php echo $this->vendor_user_details->fax; ?>" />
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
			</div>
		</div>
	</div>
</form>
<!-- END FORM-->