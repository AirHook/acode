		<!-- BEGIN GLOBAL MODALS -->
		<!-- ADD SALES PACKAGE -->
		<div class="modal fade bs-modal-lg" id="modal_create_sales_package" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				
					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open('sales/create_sales_package/create', array('class'=>'form-horizontal', 'id'=>'form-sales_create_sales_package')); ?>
					
					<input type="hidden" id="form-sales_create_sales_package-category_id" name="category_id" value="">
					
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
									<input type="text" class="form-control" required name="sales_package_name" placeholder=""> 
									<cite class="help-block small">Give this sales package a descriptive name, e.g., "Item with 50% OFF", "Tis the Season Collections", "My Collections", etc... This will be saved so you can re-use and resend the package.<cite>
								</div>
							</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark btn-outline btn-cancel" data-dismiss="modal" aria-hidden="true" onclick="Ladda.stopAll();">Cancel</button>
						<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" onclick="$('.btn-cancel, .close').prop('disabled','disabled')">
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
		<!-- END GLOBAL MODALS -->
