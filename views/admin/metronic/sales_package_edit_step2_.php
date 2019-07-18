                        <!-- BEGIN PAGE CONTENT BODY -->

                        <?php $this->load->view('metronic/sales/steps_wizard'); ?>

                        <?php
    					/***********
    					 * Noification area
    					 */
    					?>
    					<div class="notification">
    					</div>

                        <div class="row margin-bottom-30">

                            <?php
                            $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/products_grid'), $this->data);
                            ?>

                        </div>

						<?php if ($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2') { ?>
						<script>
						$('.thumb-tiles.sales-package').on('click', '.thumb-tile.package', function() {
							$('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							$.ajax({
								type:    "POST",
								url:     "<?php echo $this->uri->segment(1) == 'sales' ? site_url('sales/sales_package/addrem') : site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/addrem'); ?>",
								data:    {
									"action":"rem_item",
									"id":"<?php echo $this->sales_package_details->sales_package_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
									"sku":$(this).data('sku'),
									"prod_no":$(this).data('prod_no'),
									"prod_id":$(this).data('prod_id')
								},
								success: function(data) {
									$('.thumb-tiles.sales-package').html('');
									$('.thumb-tiles.sales-package').html(data);
									$('#loading').modal('hide');
								},
								// vvv---- This is the new bit
								error: function(jqXHR, textStatus, errorThrown) {
									$('#reloading .modal-body .modal-body-text').html('');
									$('#reloading').modal('show');
									location.reload();
									//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
								}
							});
							$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
						});
						</script>
						<?php } ?>

                        <!-- END PAGE CONTENT BODY -->
