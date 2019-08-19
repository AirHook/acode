                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="row">
                        <div class="col-sm-12 page-content-inner">

                        	<div class="checkout-wrapper">

                        		<div class="row">

                        			<?php
                        			/***********
                        			 * Noification area
                        			 */
                        			?>
                        			<div class="col-sm-12 clearfix">
                        				<div class="alert alert-danger display-hide" data-test="test">
                        					<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                        				<div class="alert alert-success display-hide">
                        					<button class="close" data-close="alert"></button> Your form validation is successful! </div>
                        				<?php if (validation_errors()) { ?>
                        				<div class="alert alert-danger">
                        					<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                        				</div>
                        				<?php } ?>
                                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        				<div class="alert alert-success ">
                        					<button class="close" data-close="alert"></button> Purchase Order successfully sent
                        				</div>
                        				<?php } ?>
                        			</div>

                        			<div class="col-sm-8 po-summary-company clearfix">
                        				<div class="row">
                        					<div class="col-sm-12">
                                                <div class="well">
                                                    Review Sales Order below and send when ready.
                        						</div>
                                                <h3> <?php echo $company_name; ?> </h3>

                                                <p>
                                                    <?php echo $company_address1; ?><br />
                                                    <?php echo $company_address2 ? $company_address2.'<br />' : ''; ?>
                                                    <?php echo $company_city.', '.$company_state.' '.$company_zipcode; ?><br />
                                                    <?php echo $company_country; ?><br />
                                                    <?php echo $company_telephone; ?>
                                                </p>
                        					</div>
                                        </div>
                        			</div>

                        		</div>

                                <?php
                        		/**
                        		 * SO Summary Form
                        		 */
                        		?>
                                <?php $this->load->view('admin/metronic/so_details_form_v2'); ?>

                        	</div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
