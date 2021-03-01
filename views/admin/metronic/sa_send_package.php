                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row body-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                        <!-- BEGIN FORM =======================================================-->
                        <?php
                        // the form tag is used for the UI only..
                        // form is not being sent here
                        echo form_open(
                            (@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/sales_package/send_product_clicks/send',
                            array(
                                'class' => 'form-horizontal'
                            )
                        ); ?>

                        <input type="hidden" name="sales_user" value="<?php echo @$sales_user; ?>" />

                        <div class="col col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications col-sm-12 clearfix margin-top-20">
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
                                        <button class="close" data-close="alert"></button> Sales Package successfully saved.
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'sa_email_sent') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Sales Package Email successfully sent!.
                                    </div>
                                    <?php } ?>
                                </div>

                                <?php
                                /***********
                                 * Sales Package Info
                                 */
                                ?>
                                <div class="col-sm-12 sa-info">

                                    <div class="form-body sa_info">
                                        <br />
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email Subject
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" name="email_subject" class="form-control input-sa_info clear-readonly" value="<?php echo $sa_email_subject; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Message
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="email_message" class="form-control summernote input-sa_info" id="summernote_1" data-error-container="email_message_error"><?php echo $sa_email_message; ?></textarea>
                                                <cite class="help-block small"> A short message to the users. HTML tags are accepted. </cite>
                                                <div id="email_message_error"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />

                                </div>

                                <?php
                                /***********
                                 * Sales Package Items
                                 */
                                ?>
                                <div class="col-sm-12">

                                    <h4 style="margin:5px 0;">Package Items</h4>
                                    <?php //$this->load->view('admin/metronic/sa_modify_items'); ?>
                                    <?php //$this->load->view('admin/metronic/sa_email_view'); ?>

                                    <?php
                                	/***********
                                	 * The IMAGES PARENT container
                                	 */

                                	// Set condition for the table width
                                	// Table width is set to 758px to accomodate max viewing width for emails
                                	// Condition is set for when the template is viewed on a browser via
                                	// admin view of sales package for sending to users
                                	?>
                                	<!--<table cellspacing="0" cellpadding="0" border="0" style="<?php echo @$file == 'sa_send' ? '' : 'width:758px;'; ?>">-->
                                    <table cellspacing="0" cellpadding="0" border="0" style="<?php echo @$file == 'sa_send' ? '' : 'width:610px;'; ?>">
                                		<tbody>
                                			<tr>
                                				<td>

                                					<?php
                                					/***********
                                					 * The IMAGES CHILD container
                                					 */
                                					?>
                                					<table cellspacing="0" cellpadding="0" border="0" style="margin-top:10px;<?php echo @$file == 'sa_send' ? '' : 'width:610px;'; ?>">
                                						<tbody>
                                							<tr>
                                								<?php
                                								// load library
                                								//$this->load->library('product_details');

                                								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
                                								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
                                								$ii = 0; // items count
                                								foreach($sa_items as $item)
                                								{
                                									// get product details
                                									// either item is a prod_no only or the complete style number
                                									// consider both
                                									$product = $this->product_details->initialize(array('tbl_product.prod_no' => $item));
                                									if ( ! $product)
                                									{
                                										$exp = explode('_', $item);
                                										$product = $this->product_details->initialize(
                                											array(
                                												'tbl_product.prod_no' => $exp[0],
                                												'color_code' => $exp[1]
                                											)
                                										);
                                										$prod_no = $exp[0];
                                										$color_code = $exp[1];
                                									}
                                									else
                                									{
                                										$prod_no = $product->prod_no;
                                										$color_code = $product->color_code;
                                									}

                                									// set image paths
                                									// the new way relating records with media library
                                									$style_no = $prod_no.'_'.$color_code;

                                									// the image filename
                                									if ($product)
                                									{
                                										$image = $product->media_path.$style_no.'_f3.jpg';
                                										$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                										$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
                                										$img_coloricon = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_c.jpg';
                                										$color_name = $product->color_name;
                                									}
                                									else
                                									{
                                										$image = 'images/instylelnylogo_3.jpg';
                                										$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
                                										$img_back_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
                                										$img_large = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
                                										$img_coloricon = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
                                										$color_name = $this->product_details->get_color_name($color_code);
                                									}

                                                                    // check stocks options for clearance cs only and pre-set price for on sale
                                									// even if on sale price is not used
                                                                    $stocks_options = @$product->stocks_options ?: array();
                                									$price =
                                                                        ! $product
                                                                        ? '0'
                                                                        : @$sa_options['e_prices'][$item]
                                                    						?: (
                                                    							($product->clearance == '3' OR $product->custom_order == '3')
                                                    							? $product->wholesale_price_clearance
                                                    							: $product->wholesale_price
                                                    						)
                                                                    ;

                                									// check if item is on sale
                                									if (
                                										@$product->clearance == '3'
                                										OR $product->custom_order == '3'
                                										OR $stocks_options['clearance_consumer_only'] == '1'
                                										OR @$sa_options['e_prices'][$item]
                                									)
                                									{
                                										$onsale = TRUE;
                                									}
                                									else
                                									{
                                										$onsale= FALSE;
                                									}

                                									if ($icol == 6)
                                									{
                                										$icol = 1;
                                										echo '</tr><tr>';
                                									}
                                									?>

                                								<td style="vertical-align:top;width:20%;padding-right:10px;">
                                									<a href="<?php echo @$access_link; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
                                										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="<?php echo @$file == 'sa_send' ? '' : 'width:100%;'; ?>">
                                											<img src="<?php echo $img_front_new; ?>" alt="<?php echo $prod_no; ?>" title="<?php echo $prod_no; ?>" border="0" style="width:100%;">
                                										</div>
                                									</a>
                                									<div style="margin:3px 0 0;">
                                										<img src="<?php echo $img_coloricon; ?>" width="10" height="10">
                                									</div>

                                									<div style="width:100%;">
                                										<span style="font-size:10px;"><?php echo $prod_no; ?></span>
                                										<?php if (@$sa_options['w_prices'] == 'Y') { ?>
                                										<br />
                                                                        <span style="font-size:10px;<?php echo $onsale ? 'text-decoration:line-through;' : ''; ?>">
                                                                            $<?php echo number_format($product->wholesale_price, 2); ?>
                                										</span>
                                										<span style="font-size:10px;color:red;<?php echo $onsale ? '' : 'display:none;'; ?>">
                                											&nbsp;$<?php echo number_format($price, 2); ?>
                                										</span>
                                										<?php } ?>
                                									</div>
                                								</td>

                                									<?php
                                									$icol++;
                                									$ii++;

                                									// finish iteration at 15 items max
                                									if ($ii == 15)
                                									{
                                										$load_more = FALSE; //TRUE;
                                										break;
                                									}
                                									else $load_more = FALSE;
                                								}

                                								// let us finish the columns to 5 if less than 5 on the last item
                                								for($icol; $icol <= 5; $icol++)
                                								{
                                									echo '<td style="vertical-align:top;width:20%;padding-right:10px;"></td>';
                                								}
                                								?>
                                							</tr>
                                							<?php
                                							// show load more for items more than 15
                                							if ($load_more)
                                							{
                                								echo '<tr><td colspan="5" style="padding-top:20px;padding-right:14px;"><a href="'.@$access_link.'"><button type="button" style="width:100%;height:50px;padding:20px auto;text-align:center;cursor:pointer;">LOAD MORE</button></a></td></tr>';
                                							}
                                							?>
                                						</tbody>
                                					</table>

                                					<br style="clear:both;">
                                				</td>
                                			</tr>
                                			<tr height="20">
                                				<td>&nbsp;</td>
                                			</tr>
                                		</tbody>
                                	</table>


                                </div>

                            </div>
                        </div>

                        <?php echo form_close(); ?>
                        <!-- End FORM ===================================================================-->
                        <!-- END FORM-->

                        <div class="col-md-6">

                            <div class="form-horizontal" role="form">

    							<div class="form-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <style>
                                        .help-block-error {
                                            font-size: 0.8em;
                                            font-style: italic;
                                        }
                                        .form-group-badge > label.control-label {
                                            text-align: left;
                                        }
                                        .badge-label {
                                            padding-left: 10px;
                                        }
                                        .badge.custom-badge {
                                            height: 30px;
                                            width: 30px;
                                            background-color: #E5E5E5; /* #E5E5E5, grey */
                                            position: relative;
                                            top: -7px;
                                            padding-top: 10px;
                                            border-radius: 18px !important;
                                            color: black;
                                        }
                                        .badge.custom-badge.active {
                                            background-color: black;
                                            color: white;
                                        }
                                        .badge.custom-badge.done {
                                            background-color: grey;
                                            color: white;
                                        }
                                    </style>

                                    <?php
    								/***********
    								 * Send Options
    								 */
    								?>
                                    <div class="form-group form-group-badge select-vendor-dropdown">
                                        <label class="control-label col-md-4">
                                            <span class="badge custom-badge active pull-left step1"> 1 </span>
                                            <span class="badge-label"> Send Sales Package </span>
                                        </label>
                                        <div class="col-md-8">
                                            <cite class="help-block font-red" style="padding-top:3px;">
                                                Select From Options below
                                            </cite>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin:0px -10px;">
                                        <a class="btn btn-secondary-outline btn-sm font-dark pull-right" href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/sales_package'); ?>">
                                            <i class="fa fa-reply"></i> Back to List
                                        </a>
                                        <a class="btn btn-secondary-outline btn-sm font-dark" href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/sales_package/create'); ?>">
        	                                <i class="fa fa-pencil"></i> Modify Sales Package
        								</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a href="javascript:;" class="btn dark btn-md select-send-options send-to-current-user col-md-4 btn-active" style="font-size:0.9em;background-color:#E5E5E5;color:black;">
                                                Send To Existing User(s)
                                            </a>
                                            <a href="javascript:;" class="btn dark btn-md select-send-options send-to-new-user col-md-4" style="font-size:0.9em;">
                                                Send To New Wholesale User
                                            </a>
                                            <button type="button" class="btn dark btn-md select-send-options send-to-all-users_ col-md-4 tooltips" data-original-title="Under Construction" style="font-size:0.9em;">
                                                Send To All Users
                                            </button>
                                        </div>
                                    </div>

                                    <hr />

                                </div>

                            </div>

                            <?php
                            /***********
                             * Select from
                             * Existing Users or Add New User
                             */
                            ?>
                            <div class="form-select-users-wrapper">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open(
                                    (@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/sales_package/send_package/send',
                                    array(
                                        'class' => 'form-horizontal',
                                        'id' => 'form-send_sales_package'
                                    )
                                ); ?>

                                <input type="hidden" name="send_to" value="current_user" />
                                <input type="hidden" name="sales_user" value="<?php echo $sales_user; ?>" />

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications">
                                    <div class="alert alert-danger display-none">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if ($this->session->error == 'no_input_data') { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
                                    </div>
                                    <?php } ?>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                </div>

                                <?php $this->load->view('admin/metronic/sa_send_to_new_user'); ?>

                                <?php $this->load->view('admin/metronic/sa_send_to_current_user'); ?>

                                <h3 class="notice-select-action hide"><cite>Select action...</cite></h3>

                                <?php echo form_close(); ?>
                                <!-- End FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>

                        </div>

                    </div>
                    <!-- END PAGE CONTENT BODY -->
