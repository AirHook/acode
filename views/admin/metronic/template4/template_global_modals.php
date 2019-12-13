		<!-- BEGIN GLOBAL MODALS -->
		<!-- ADD SALES PACKAGE -->
		<div class="modal fade bs-modal-lg" id="modal_create_sales_package" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open($this->config->slash_item('admin_folder').'campaigns/sales_package/create', array('class'=>'form-horizontal', 'id'=>'form_sales_package_list_bulk_action')); ?>

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Create Sales Package</h4>
					</div>
					<div class="modal-body">

							<?php if (validation_errors()) { ?>
							<div class="alert alert-danger">
								<button class="close" data-close="alert"></button> There was a problem with the form. Please check and try again. <br /> <?php echo validation_errors(); ?> </div>
							<?php } ?>
							<div class="form-group">
								<label class="col-md-3 control-label">Sales Package Name:
									<span class="required"> * </span>
								</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="sales_package_name" placeholder="">
									<span class="help-block">Give this sales package a name...</span>
								</div>
							</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Cancel</button>
						<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
							<span class="ladda-label">Confirm?</span>
							<span class="ladda-spinner"></span>
						</button>
					</div>

					</form>
					<!-- End FORM =======================================================================-->
					<!-- END FORM-->

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- SELECT THEME -->
		<div class="modal fade bs-modal-md" id="select_theme_after_add_webspace" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Select Theme Now?</h4>
					</div>
					<div class="modal-body">
						<p class="modal-body-text">
							Would you like to select a theme for you webspace now?<br />
							You can always do it at the 'options' section of the webspace edit page.
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Cancel</button>
						<a type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" href="<?php echo site_url($this->config->slash_item('admin_folder').'themes'); ?>">
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
		<!-- CONTACT ADMIN -->
		<div class="modal fade bs-modal-sm" id="contact_admin" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					</div>
					<div class="modal-body">
						<p class="modal-body-text">Please contact admin about this.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- LOADING -->
		<div class="modal fade bs-modal-sm" id="loading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Loading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text"></p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- RELOADING -->
		<div class="modal fade bs-modal-sm" id="reloading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Reloading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text">You have been idle for quite a while.</p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- SELECT DESIGNER for DESIGNER RECENT PRODUCTS -->
		<div class="modal fade bs-modal-md" id="modal-select_designer_for_designer_recent_sales_package" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-md">
				<div class="modal-content">

					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open(
						$this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/2',
						array(
							'class'=>'form-horizontal',
							'id'=>'form-select_designer'
						)
					); ?>

					<div class="modal-header">
						<h4 class="modal-title">Select a DESIGNER!</h4>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<label class="col-md-3 control-label">Designer:
								<span class="required"> * </span>
							</label>
							<div class="col-md-9">
								<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
									<option value=""> - select one - </option>

									<?php if (@$designers)
									{
										foreach ($designers as $designer)
										{
											// if hub site, show all designers
											if ($this->webspace_details->options['site_type'] == 'hub_site')
											{
												if ($designer->url_structure !== $this->webspace_details->slug)
												{ ?>

									<option value="<?php echo $designer->des_id; ?>" data-url_structure="<?php echo $designer->url_structure; ?>"> <?php echo $designer->designer; ?> </option>
													<?php
												}
											}
											else
											{
												// else show satellite site designer only
												if ($designer->url_structure == $this->webspace_details->slug)
												{ ?>

									<option value="<?php echo $designer->des_id; ?>" data-url_structure="<?php echo $designer->url_structure; ?>"> <?php echo $designer->designer; ?> </option>
													<?php
												}
											}
										}
									} ?>

								</select>
								<input type="hidden" name="designer_slug" value="" />
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
							<span class="ladda-label">Confirm?</span>
							<span class="ladda-spinner"></span>
						</button>
					</div>

					</form>
					<!-- End FORM =======================================================================-->
					<!-- END FORM-->

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/modal-barcode_scan'); ?>
		<!-- END GLOBAL MODALS -->
