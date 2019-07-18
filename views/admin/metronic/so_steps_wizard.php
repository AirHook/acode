					<div class="form-wizard" id="form_wizard_1">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
								<!-- DOC: use classes "active" and "done" to make the steps work properly -->
								<!-- DOC: progress bar automatically aligns with steps as per script -->
								<li class="<?php echo @$steps == 1 ? 'active' : ''; ?><?php echo @$steps > 1 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step step1" data-step="1" onclick="location.href='<?php echo site_url('sales/sales_orders/create/step1'); ?>'">
										<span class="number"> 1 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Select Products
										</span>
									</a>
								</li>
								<li class="<?php echo @$steps == 2 ? 'active' : ''; ?><?php echo @$steps > 2 ? 'done' : ''; ?>">
									<?php
									$step2_link =
										(
											$steps >= 1
											&& $items_count > 0
										)
										? site_url('sales/purchase_orders/create/step2')
										: 'javascript:;'
									;
									?>
									<a href="javascript:;" data-toggle="tab" class="step step2" data-step="2" data-link="<?php echo site_url('sales/sales_orders/create/step2'); ?>">
										<span class="number"> 2 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Refine Sales Order
										</span>
									</a>
								</li>
								<li class="<?php echo @$steps == 3 ? 'active' : ''; ?><?php echo @$steps > 3 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step step3 <?php echo (@$steps == 2 && $items_count > 0) ? 'mt-bootbox-new submit-so_summary_review' : ''; ?> " data-step="3" data-link="<?php echo site_url('admin/purchase_orders/create/step3'); ?>">
										<span class="number"> 3 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Submit Sales Order
										</span>
									</a>
								</li>
							</ul>
							<div id="bar" class="progress progress-striped active" role="progressbar">
								<div class="progress-bar progress-bar-success"> </div>
							</div>
							<span class="items_count hide"> <?php echo $items_count ?: '0'; ?> </span>
							<span class="items_steps hide"> <?php echo @$steps ?: 1; ?> </span>
						</div>
					</div>
