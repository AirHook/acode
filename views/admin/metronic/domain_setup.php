                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light bordered" id="form_wizard_1">
									<?php
									/***********
									 * Form Wizard Title
									 */
									?>
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-red"></i>
                                            <span class="caption-subject font-red bold uppercase"> Domain Setup Wizard -
                                                <span class="step-title"> Step 1 of 4 </span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-cloud-upload"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-wrench"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div>
                                    </div>
									<?php
									/***********
									 * Form Wizard Steps
									 */
									?>
                                    <div class="portlet-body form">
									
										<!-- BEGIN FORM-->
										<!-- FORM =======================================================================-->
										<?php echo form_open($this->config->slash_item('admin_folder').'domain_setup/submit', array('class'=>'form-horizontal', 'id'=>'submit_form')); ?>
										
											<input type="hidden" name="industry" value="fashion" />
											<input type="hidden" name="account_status" value="1" />
											
											<div class="form-wizard">
                                                <div class="form-body">
                                                    <ul class="nav nav-pills nav-justified steps">
                                                        <li>
                                                            <a href="#tab1" data-toggle="tab" class="step">
                                                                <span class="number"> 1 </span>
                                                                <span class="desc">
                                                                    <i class="fa fa-check"></i> Account Setup </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab2" data-toggle="tab" class="step">
                                                                <span class="number"> 2 </span>
                                                                <span class="desc">
                                                                    <i class="fa fa-check"></i> Webspace Setup </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab3" data-toggle="tab" class="step active">
                                                                <span class="number"> 3 </span>
                                                                <span class="desc">
                                                                    <i class="fa fa-check"></i> Webspace Options </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab4" data-toggle="tab" class="step">
                                                                <span class="number"> 4 </span>
                                                                <span class="desc">
                                                                    <i class="fa fa-check"></i> Confirm </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                                        <div class="progress-bar progress-bar-success"> </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="alert alert-danger display-none">
                                                            <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                                        <div class="alert alert-success display-none">
                                                            <button class="close" data-dismiss="alert"></button> Your form validation is successful! </div>
														<?php
														/***********
														 * Form Wizard Step 1
														 */
														?>
                                                        <div class="tab-pane active" id="tab1">
                                                            <h3 class="block">Provide your account details</h3>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Account/Company Name
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="company_name" />
                                                                    <span class="help-block"> Provide your company name </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Owner Name
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="owner_name" />
                                                                    <span class="help-block"> Provide owner name </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Owner Email
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="owner_email" />
                                                                    <span class="help-block"> Provide owner email address </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Address 1
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="address1" />
                                                                    <span class="help-block"> Provide your street number and address </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Address 2 (optional)
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="address2" />
                                                                    <span class="help-block"> Provide your additional address </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">City
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="city" />
                                                                    <span class="help-block"> Provide your city </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">State
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select name="state" id="state_list" class="form-control">
                                                                        <option value=""></option>
																		<?php foreach (list_states() as $state) { ?>
																		<option value="<?php echo $state->state_id; ?>"><?php echo $state->state_name.' ('.$state->abb.')'; ?></option>
																		<?php } ?>
																	</select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Country
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select name="country" id="country_list" class="form-control">
                                                                        <option value=""></option>
																		<?php foreach (list_countries() as $state) { ?>
																		<option value="<?php echo $state->countries_id; ?>"><?php echo $state->countries_name; ?></option>
																		<?php } ?>
																	</select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Zip Code
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="zip" />
                                                                    <span class="help-block"> Provide your zip code </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Phone Number
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="phone" />
                                                                    <span class="help-block"> Provide your phone number </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Password
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="password" class="form-control" name="password" id="submit_form_password" />
                                                                    <span class="help-block"> Provide your password. </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Confirm Password
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="password" class="form-control" name="rpassword" />
                                                                    <span class="help-block"> Confirm your password </span>
                                                                </div>
                                                            </div>
                                                        </div>
														<?php
														/***********
														 * Form Wizard Step 2
														 */
														?>
                                                        <div class="tab-pane" id="tab2">
                                                            <h3 class="block">Provide your webspace details</h3>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Webspace Name
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="webspace_name" />
                                                                    <span class="help-block"> Provide your website name </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Domain Name
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
																	<div class="input-group">
																		<span class="input-group-addon">www.</span>
																		<input type="text" class="form-control" id="domain_name" name="domain_name" />
																	</div>
                                                                    <span class="help-block"> Accepted TLD's are .com &amp; .net </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Webspace Slug
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="webspace_slug" class="form-control" name="webspace_slug" readonly tabindex="-1" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Webspace Info Email
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="info_email" />
                                                                </div>
                                                            </div>
                                                        </div>
														<?php
														/***********
														 * Form Wizard Step 3
														 */
														?>
                                                        <div class="tab-pane" id="tab3">
                                                            <h3 class="block">Provide your website options</h3>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Website Option
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-4">
																	<div class="mt-radio-list" style="padding-top:8px;">
																		<label class="mt-radio mt-radio-outline">
																			<input type="radio" name="site_type" value="sal_site" data-title="Stand-Alone Site"> Stand-Alone Site
																			<span></span>
																		</label>
																		<label class="mt-radio mt-radio-outline">
																			<input type="radio" name="site_type" value="hub_site" data-title="Hub Site"> Hub Site
																			<span></span>
																		</label>
																		<label class="mt-radio mt-radio-outline">
																			<input type="radio" name="site_type" value="sat_site" data-title="Satellite Site"> Satellite Site
																			<span></span>
																		</label>
																	</div>
                                                                    <span class="help-block"> </span>
																	<div id="form_payment_error"> </div>
                                                                </div>
                                                            </div>
                                                        </div>
														<?php
														/***********
														 * Form Wizard Step 4
														 */
														?>
                                                        <div class="tab-pane" id="tab4">
                                                            <h3 class="block">Confirm your account</h3>
                                                            <h4 class="form-section">Account</h4>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Account/Company Name:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="company_name"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Owner Name:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="owner_name"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Owner Email Address:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="owner_email"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Address1:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="address1"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Address2:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="address2"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">City:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="city"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">State:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="state"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Country</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="country"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Zip Code:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="zip"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Phone Number:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="phone"> </p>
                                                                </div>
                                                            </div>
                                                            <h4 class="form-section">Webspace</h4>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Webspace Name:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="webspace_name"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Domain Name:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="domain_name"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Slug:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="webspace_slug"> </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Website Info Email:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="info_email"> </p>
                                                                </div>
                                                            </div>
                                                            <h4 class="form-section">Options</h4>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Type of Site:</label>
                                                                <div class="col-md-4">
                                                                    <p class="form-control-static" data-display="site_type"> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <a href="javascript:;" class="btn default button-previous" tabindex="-1">
                                                                <i class="fa fa-angle-left"></i> Back </a>
                                                            <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                                                <i class="fa fa-angle-right"></i>
                                                            </a>
                                                            <a href="javascript:;" class="btn green button-submit"> Submit
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
										<!-- End FORM ===================================================================-->
										<!-- END FORM-->
                                    </div>
                                </div>
                            </div>
                        </div>
