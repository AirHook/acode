									<?php
									/**********
									 * Right side column
									 * Top Box
									 * Sales User Info
									 */
									?>
									<div class="order-summary__header clearfix">
										<h6 class="section-heading">
											My Info
										</h6>
									</div>
									<div class="section order-summary__detail clearfix">
										
										<?php echo $this->sales_user_details->fname.' '.$this->sales_user_details->lname; ?>
										<cite><small>(Level <?php echo $this->sales_user_details->access_level; ?>)</small></cite>
										<br /><?php echo $this->sales_user_details->email; ?>
										<br /><?php echo $this->sales_user_details->designer_name; ?>
										
									</div>
