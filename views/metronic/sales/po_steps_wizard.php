					<div class="form-wizard" id="form_wizard_1">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
								<!-- DOC: use classes "active" and "done" to make the steps work properly -->
								<!-- DOC: progress bar automatically aligns with steps as per script -->
								<li class="<?php echo @$steps == 1 ? 'active' : ''; ?><?php echo @$steps > 1 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step" onclick="location.href='<?php echo site_url('sales/purchase_orders/create/step1'); ?>'">
										<span class="number"> 1 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Select Vendor
										</span>
									</a>
								</li>
								<li class="<?php echo @$steps == 2 ? 'active' : ''; ?><?php echo @$steps > 2 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step" onclick="location.href='<?php echo site_url('sales/purchase_orders/create/step2/womens_apparel'); ?>'">
										<span class="number"> 2 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Select Products
										</span>
									</a>
								</li>
								<li class="<?php echo @$steps == 3 ? 'active' : ''; ?><?php echo @$steps > 3 ? 'done' : ''; ?>">
									<?php
									$step3_link = $steps >= 3 ? site_url('sales/create/step3') : '';
									?>
									<a href="javascript:;" data-toggle="tab" class="step" data-step="3" data-link="<?php echo site_url('sales/purchase_orders/create/step3'); ?>">
										<span class="number"> 3 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Refine Purchase Order
										</span>
									</a>
								</li>
								<li class="<?php echo @$steps == 4 ? 'active' : ''; ?><?php echo @$steps > 4 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step step4 <?php echo (@$steps == 3 && $po_items_count > 0) ? 'mt-bootbox-new' : ''; ?> " data-step="4" data-link="<?php echo site_url('sales/purchase_orders/create/step4'); ?>">
										<span class="number"> 4 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Send Purchase Order
										</span>
									</a>
								</li>
							</ul>
							<div id="bar" class="progress progress-striped active" role="progressbar">
								<div class="progress-bar progress-bar-success"> </div>
							</div>
							<span class="items_count hide"> <?php echo $po_items_count ?: '0'; ?> </span>
							<span class="items_steps hide"> <?php echo @$steps ?: 1; ?> </span>
						</div>
					</div>
