					<?php
					/**********
					 * Notifications
					 */
					?>
					<div class="notifications">
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'zero_search_result') { ?>
						<div class="alert alert-danger">
							<button class="close" data-close="alert"></button> There were no records of the search. Please try to browse through products listing below.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
						<div class="alert alert-danger ">
							<button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
							<?php echo $this->session->flashdata('error_value') ?: 'Unknown'; ?>
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'add') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> New Product ADDED!
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'edit') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Product information updated.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'delete') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Product permanently removed from records.
						</div>
						<?php } ?>
					</div>

					<?php
					/**********
					 * Tabs Tooolbar
					 */
					?>
                    <div class="table-toolbar" style="margin-bottom:0px;">

						<style>
							.nav > li > a {
								padding: 8px 15px;
								background-color: #eee;
								color: #555;
							}
							.nav-tabs > li > a {
								font-size: 10px;
							}
							.nav-tabs > li > a:hover {
								background-color: #333;
								color: #eee;
							}
						</style>

						<?php
						/**********
						 * This allows user of tabs for admin and sales users
						 */
						if (@$role)
						{
							switch ($role)
							{
								case 'sales':
									$link_prefix = 'my_account/sales';
								break;

								default:
									$link_prefix = 'admin';
							}
						}
						else $link_prefix = 'admin';
						?>

						<ul class="nav nav-tabs">
							<li class="<?php echo ($this->uri->segment(3) == 'all' OR $this->uri->segment(4) == 'all') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/all'); ?>">
									All Products
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'is_public'  OR $this->uri->segment(4) == 'is_public') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/is_public'); ?>">
									Public
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'not_public' OR $this->uri->segment(4) == 'not_public') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/not_public'); ?>">
									Private
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'clearance' OR $this->uri->segment(4) == 'clearance') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/clearance'); ?>">
									On Sale
								</a>
							</li>
							<?php
							// available only on hub sites for now
							if (
								$this->webspace_details->options['site_type'] == 'hub_site'
								&& ! @$role
							)
							{ ?>
							<li class="<?php echo ($this->uri->segment(3) == 'clearance_cs_only' OR $this->uri->segment(4) == 'clearance_cs_only') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/clearance_cs_only'); ?>">
									Clearance CS Only
								</a>
							</li>
							<?php } ?>
							<li class="<?php echo ($this->uri->segment(3) == 'unpublished' OR $this->uri->segment(4) == 'unpublished') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/unpublished'); ?>">
									Unpublished
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'instock' OR $this->uri->segment(4) == 'instock') ? 'active' : ''; ?>">
								<a href="<?php echo site_url($link_prefix.'/products/instock'); ?>">
									In Stock
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'onorder' OR $this->uri->segment(4) == 'onorder') ? 'active' : ''; ?>">
								<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
									On Order
								</a>
							</li>
							<li class="<?php echo ($this->uri->segment(3) == 'by_vendor' OR $this->uri->segment(4) == 'by_vendor') ? 'active' : ''; ?>">
								<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
									By Vendor
								</a>
							</li>
							<?php
							// available only on hub sites for now
							if (
								$this->webspace_details->options['site_type'] == 'hub_site'
								&& ! @$role
							)
							{ ?>
							<li>
								<a href="<?php echo site_url('admin/products/add'); ?>">
									Add Product <i class="fa fa-plus"></i>
								</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/products/add/multiple_upload_images'); ?>">
									Add Multiple Products via Images <i class="fa fa-plus"></i>
								</a>
							</li>
							<?php } ?>
						</ul>

						<br />

						<?php if (@$search) { ?>
                        <h1><small><em>Search results for:</em></small> "<?php echo @$search_string; ?>"</h1>
                        <br />
                        <?php } ?>

					</div>

					<?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').$view_as, $this->data); ?>

                    <!-- END PAGE CONTENT BODY -->

					<!-- FORM =======================================================================-->
					<?php echo form_open($this->config->slash_item('admin_folder').'products/set_active_designer_category', array('id'=>'form-product_list_view_as')); ?>

						<input type="hidden" id="view_as" name="view_as" value="products_list" />
						<input type="hidden" id="uri_string" name="uri_string" value="<?php echo $this->uri->uri_string(); ?>" />

					</form>
					<!-- End FORM ===================================================================-->
					<!-- END FORM-->

					<!-- BEGIN PAGE MODALS -->
					<!-- BULK PUBLISH -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-0" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">UNPublish!</h4>
								</div>
								<div class="modal-body"> Are you sure you want to UNPUBLISH multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- BULK UNPUBLISH -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-1" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Public!</h4>
								</div>
								<div class="modal-body"> Publish PUBLIC multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- BULK PRIVATE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-2" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Private!</h4>
								</div>
								<div class="modal-body"> Publish PRIVATE multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- BULK DELETE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete!</h4>
								</div>
								<div class="modal-body">
									Delete multiple items? <br /> This cannot be undone!
									<div class="note note-danger">
										<h4 class="block">Danger! </h4>
										<p> This action will delete the entire product item including its color variants. Please ensure you know what you are doing before proceeding. </p>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- END PAGE MODALS -->
