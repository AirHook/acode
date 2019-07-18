					<div class="form-wizard" id="form_wizard_1">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
								<!-- DOC: use classes "active" and "done" to make the steps work properly -->
								<!-- DOC: progress bar automatically aligns with steps as per script -->
								<li class="<?php echo @$steps == 1 ? 'active' : ''; ?><?php echo @$steps > 1 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step">
										<span class="number"> 1 </span>
										<span class="desc">
											<i class="fa fa-check"></i> <?php echo ($this->uri->uri_string() == 'sales/sales_package' && ! @$linesheet_sending_only) ? 'Select Saved Package': 'Edit/Update Info'; ?> </span>
									</a>
								</li>
								<li class="<?php echo @$steps == 2 ? 'active' : ''; ?><?php echo @$steps > 2 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step">
										<span class="number"> 2 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Select Products </span>
									</a>
								</li>
								<li class="<?php echo @$steps == 3 ? 'active' : ''; ?><?php echo @$steps > 3 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step active">
										<span class="number"> 3 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Review Sales Package </span>
									</a>
								</li>
								<li class="<?php echo @$steps == 4 ? 'active' : ''; ?><?php echo @$steps > 4 ? 'done' : ''; ?>">
									<a href="javascript:;" data-toggle="tab" class="step">
										<span class="number"> 4 </span>
										<span class="desc">
											<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
											<i class="fa fa-check"></i> Send Complete </span>
											<?php } else { ?>
											<i class="fa fa-check"></i> Send Sales Package </span>
										<?php } ?>
									</a>
								</li>
							</ul>
							<div id="bar" class="progress progress-striped active" role="progressbar">
								<div class="progress-bar progress-bar-success"> </div>
							</div>
						</div>
					</div>
