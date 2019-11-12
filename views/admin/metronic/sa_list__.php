					<?php 
					if ($this->uri->segment(4) == 'send')
					{
						$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'sales_package_send');
					}
					elseif ($this->uri->segment(4) == 'edit')
					{
						$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'sales_package_create'); ?>

						<?php if (
							$this->sales_package_details->sales_package_id != '1'
							&& $this->sales_package_details->sales_package_id != '2'
							&& $this->sales_package_details->author != 'system'
						) { ?>

							<?php if (@$products_count)
							{ ?>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left">
							<?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'sales_package_products_grid'); ?>
						</div>

						<!-- DELETE ITEM -->
						<div class="modal fade bs-modal-sm" id="delete-<?php echo $this->sales_package_details->sales_package_id?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Warning!</h4>
									</div>
									<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
									<div class="modal-footer">
										<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
										<a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/delete/index/'.$this->sales_package_details->sales_package_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

							<?php
							}
						}
					}
					else
					{
						$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'sales_package_list');
					}
					?>

					<!-- ITEMS COUNT NOTICE -->
					<div class="modal fade bs-modal-sm" id="items_count_notice" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Notice...</h4>
								</div>
								<div class="modal-body text-center">
									<p>
										MAX 30 items per pacakge only...
									</p>
								</div>
								<div class="modal-footer">
									<button class="btn blue mt-ladda-btn ladda-button" data-dismiss="modal" data-style="expand-left">
										<span class="ladda-label">Ok</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- CONFIRM BULK DELETE ACTION -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete!</h4>
								</div>
								<div class="modal-body"> Delete (multiple) items? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form-sales_package_list_bulk_action').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- CONFIRM BULK ACTION -->
					<div class="modal fade bs-modal-sm" id="nocando-default_sales_pacakge" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Notice!</h4>
								</div>
								<div class="modal-body"> DEFAULT sales pacakge. <br /> Unable to delete! <br /><br /> Please set a different sales package as default before deleting this sales pacakge. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
