		<!-- BEGIN GLOBAL MODALS -->
		<?php
		/**
		 * GENERAL Modals
		 */
		?>
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

		<?php
		/**
		 * SALES ORDERS Modals
		 */
		?>
		<!-- SALES PACKAGE WITH PREVIOUSLY EDITED PRICES -->
		<div class="modal fade" id="modal-prev_e_prices" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Notice!</h4>
					</div>
					<div class="modal-body">
						<p class="modal-body-text">
							This sales package has some items whose prices has been changed.
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn dark dismiss-modal-prev_e_prices">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /modal -->

		<!-- CLEAR ALL ITEMS -->
		<div class="modal fade bs-modal-sm" id="modal-clear_all_items" tabindex="-1" role="dialog" aria-hidden="true">
			<!-- DOC: with vertical align helper to center modal vertically -->
			<div class="vertical-alignment-helper">
				<div class="modal-dialog modal-sm vertical-align-center">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Clear All Items In Package!</h4>
						</div>
						<div class="modal-body">
							<p class="modal-body-text">
								Are you sure you want to clear all selected items?<br />
								This cannot be undone!
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="button" class="btn dark confirm-clear_all_items">Confirm</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
		</div>
		<!-- /.modal -->

		<!-- NOTICE - ITEMS ON CART -->
		<div class="modal fade bs-modal-sm" id="modal-items_on_cart" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="vertical-alignment-helper">
				<div class="modal-dialog modal-sm vertical-align-center">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">NOTICE: Items on cart!</h4>
						</div>
						<div class="modal-body">
							<p class="modal-body-text">
								You are selecting a new set of sale package items.<br />
								This will remove current items on cart!
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
							<a href="javascript:;" class="btn dark continue-items_on_cart">Continue?</a>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
		</div>
		<!-- /.modal -->

		<?php
		/**
		 * PURCHASE ORDERS Modals
		 */
		if ($file == 'create_purchase_order_step2' && $steps == 2)
		{
		?>
		<!-- CHANGE VENDOR -->
		<div class="modal fade" id="modal-change_vendor" tabindex="-1" role="basic" aria-hidden="true">
			<!-- DOC: with vertical align helper to center modal vertically -->
			<div class="vertical-alignment-helper">
				<div class="modal-dialog vertical-align-center">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Select New Vendor</h4>
						</div>

						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
						<?php echo form_open(
							'sales/purchase_orders/create/step1',
							array(
								'id'=>'form-select_vendor'
							)
						); ?>

						<div class="modal-body">

							<div class="form margin-bottom-30">

									<div class="form-body">
										<div class="form-group">
											<label class="control-label col-md-3">Vendor
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<select class="form-control select2me step2-select-vendor" name="vendor_id">
													<option value="">Select...</option>

													<?php
													if ($vendors)
													{
														foreach ($vendors as $vendor)
														{ ?>

													<option value="<?php echo $vendor->vendor_id; ?>" <?php echo set_select('vendor_id', $vendor->vendor_id, ($vendor->vendor_id === $this->session->po_vendor_id)); ?> data-url_structure="<?php echo $vendor->url_structure; ?>">
														<?php echo ucwords(strtolower($vendor->vendor_name)).'&nbsp; &nbsp;('.$vendor->vendor_code.')&nbsp; &nbsp;'.$vendor->designer; ?>
													</option>

															<?php
														}
													} ?>

												</select>
												<span class="help-block">  </span>
												<input type="hidden" name="url_structure" value="<?php echo $this->session->po_des_url_structure ?: ''; ?>" />
											</div>
										</div>
									</div>

							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn dark confirm-clear_all_items">SELECT VENDOR</button>
						</div>

						</form>
						<!-- END FORM ===================================================================-->
						<!-- END FORM-->

					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
		</div>
		<!-- /.modal -->
			<?php
		} ?>
