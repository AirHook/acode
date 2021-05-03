                    <?php
                    // let's set the role for sales user my account
                    $pre_link =
                        @$role == 'sales'
                        ? 'my_account/sales'
                        : 'admin/campaigns'
                    ;
                    ?>
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row body-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                        <div class="col col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications col-sm-12 clearfix margin-top-20">
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Lookbook successfully saved.
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'sa_email_sent') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Lookbook Email successfully sent!.
                                    </div>
                                    <?php } ?>
                                </div>

                                <!-- BEGIN FORM =======================================================-->
                                <?php
                                // the form tag is used for the UI only..
                                // form is not being sent here
                                echo form_open(
                                    (@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/lookbook/send',
                                    array(
                                        'class' => 'form-horizontal'
                                    )
                                ); ?>

                                <?php
                                /***********
                                 * Sales Package Info
                                 */
                                ?>
                                <div class="col-sm-12 sa-info">

                                    <div class="form-body sa_info">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Lookbook Name
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="lookbook_name" class="form-control input-sa_info clear-readonly" value="<?php echo $sa_details->lookbook_name; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date Created
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="date_create" class="form-control input-sa_info clear-readonly" value="<?php echo is_numeric($sa_details->date_create) ? @date('Y-m-d', $sa_details->date_create) : $sa_details->date_create; ?>" readonly />
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email Subject
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="email_subject" class="form-control input-sa_info clear-readonly" value="<?php echo $sa_details->email_subject; ?>" readonly />
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <?php
                                /***********
                                 * Sales Package Items
                                 */
                                ?>
                                <div class="col-sm-12">

                                    <h4>Lookbook <?php echo $sa_items_count ? '('.$sa_items_count.')' : ''; ?> Items</h4>
                                    <hr />
                                    <?php //$this->load->view('admin/metronic/sa_email_view', $this->data); ?>

                                    <div class="thumb-tiles sales-package lookbook clearfix" style="min-height:350px;max-height:600px;overflow-y:scroll;border:1px solid #ccc;margin-right:0px;background-color:#eee;padding:5px;">

            							<?php
            							if ( ! empty(@$lb_items))
            							{
                                            $i = 2;
            								foreach ($lb_items as $item => $options)
            								{
            									// get product details
            									$exp = explode('_', $item);
            									$product = $this->product_details->initialize(
            										array(
            											'tbl_product.prod_no' => $exp[0],
            											'color_code' => $exp[1]
            										)
            									);

            									if ( ! $product)
            									{
            										// a catch all system
            										continue;
            									}

            									// set image paths
            									// the new way relating records with media library
            									$style_no = $item;
            									$prod_no = $exp[0];
            									$color_code = $exp[1];
            									$color_name = $this->product_details->get_color_name($color_code);

            									// the image filename
            									$image = $product->media_path.$style_no.'_f3.jpg';
            									$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
            									if (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg'))
            									{
            										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
            									}
            									elseif (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg'))
            									{
            										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg';
            									}
            									else $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';

            									// set product logo
            									if ( ! @getimagesize($this->config->item('PROD_IMG_URL').$product->designer_logo))
            									{
            										// get default logo folder
            										$logo = base_url().'assets/images/logo/logo-'.$product->designer_slug.'.png';
            									}
            									else
            									{
            										$logo = $this->config->item('PROD_IMG_URL').$product->designer_logo;
            									}

            									// set some data
                                                $price = @$options[2] ?: 0;
                                                $size_names = $this->size_names->get_size_names($product->size_mode);
            									$category = $this->categories_tree->get_name($options[1]); // get category name of category slug

                                                $show_price = @$lb_options['w_prices'] == 'Y' ? '' : "display-none";
            									$show_sizes = @$lb_options['w_sizes'] == 'Y' ? '' : "display-none";
            									?>

            							<div class="lookbook-item package_items" style="min-height:340px;padding:3%;border:1px solid #ccc;margin: 0 3px 8px;background:white;">
            								<div class="pull-left" style="width:48%;position:relative;">
            									<img src="<?php echo $img_front_new; ?>" style="width:100%;" />
            									<img src="<?php echo $logo; ?>" style="position:absolute;top:5px;left:5px;width:100px;height:auto;" />
            									<p style="color:white;position:absolute;top:83%;left:7px;font-size:90%;transform-origin: 0 0;transform:rotate(270deg);">
            										<?php echo strtoupper($category); ?>
            									</p>
            									<p style="color:white;position:absolute;bottom:-10px;left:10px;font-size:60%;">
            										<?php echo $prod_no; ?> &nbsp; &nbsp; <?php echo $color_name; ?> &nbsp; &nbsp; <span class="lb-items-w_prices <?php echo $show_price; ?>">$<?php echo $price; ?></span>
                                                    <?php
                                                    $i = 0;
            										$span_size = FALSE; // assume initially there is no available sizes
            										foreach ($size_names as $size_label => $s)
            										{
            											// do not show zero stock sizes
            											if ($product->$size_label === '0') continue;

            											// it is now assumed that this next size after is with stocks
            											//<br />
            											//Sizes: 0(2) 2(2) 4(6) 6(2) 12(2)
                                                        if ($i === 0)
            											{
            												// this means there is a size with stock
            												echo '<br class="lb-items-w_sizes '.$show_sizes.'" /><span class="lb-items-w_sizes '.$show_sizes.'">Sizes: ';
            												$span_size = TRUE;
            											}

            											echo $s.'('.$product->$size_label.') ';

            											$i++;
            										}
            										if ($span_size) echo '</span>';
            										?>
            									</p>
            								</div>
            								<div class="pull-right" style="width:48%;position:relative;">
            									<img src="<?php echo $img_back_new; ?>" style="width:100%;" />
                                                <p style="color:white;position:absolute;bottom:-10px;right:10px;font-size:60%;">
            										<?php echo $i; ?>
            									</p>
            								</div>
            								<div class="clearfix"></div>
            							</div>

            									<?php
                                                $i = $i + 2;
            								} ?>

            							<!--<input type="hidden" id="items_count" name="items_count" value="<?php echo @$lb_items_count; ?>" />-->

            								<?php
            							} ?>

            						</div>


                                </div>

                                </form>
                                <!-- END FORM =======================================================-->

                            </div>
                        </div>

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
                                            <span class="badge-label"> Send Lookbook </span>
                                        </label>
                                        <div class="col-md-8 <?php echo @$ws_user_details ? 'hide' : ''; ?>">
                                            <cite class="help-block font-red" style="padding-top:3px;">
                                                Select From Options below
                                            </cite>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin:0px -10px;">
                                        <a class="btn btn-secondary-outline btn-sm font-dark pull-right" href="<?php echo site_url($pre_link.'/lookbook'); ?>">
                                            <i class="fa fa-reply"></i> Back to List
                                        </a>
                                        <a class="btn btn-secondary-outline btn-sm font-dark" href="<?php echo site_url($pre_link.'/lookbook/modify/index/'.$sa_details->lookbook_id); ?>">
        	                                <i class="fa fa-pencil"></i> Modify Lookbook
        								</a>
                                    </div>
                                    <div class="form-group" style="margin:0px -10px 0px 0px;">
                                        <cite style="font-size:120%;">SEND TO:</cite>
                                    </div>
                                    <div class="form-group">
                                        <?php
        								/***********
        								 * Only super admin for 'Send to a friend'
        								 */
                                        if (
                                            $this->webspace_details->options['site_type'] == 'hub_site'
                                            OR $role == 'admin'
                                        )
                                        {
                                            $col_md = 3;
                                            $show_sent_to_friend = ''; // show
                                        }
                                        else
                                        {
                                            $col_md = 4;
                                            $show_sent_to_friend = 'hide';
                                        }
        								?>
                                        <div class="col-md-12">
                                            <a href="javascript:;" class="btn dark btn-md btn-active select-send-options send-to-current-user col-md-<?php echo $col_md; ?> <?php echo @$ws_user_details ? 'hide' : ''; ?>" style="font-size:0.9em;background-color:#E5E5E5;color: black;">
                                                Existing User(s)
                                            </a>
                                            <a href="javascript:;" class="btn dark btn-md select-send-options send-to-new-user col-md-<?php echo $col_md; ?> <?php echo @$ws_user_details ? 'hide' : ''; ?>" style="font-size:0.9em;">
                                                New Wholesale User
                                            </a>
                                            <button type="button" class="btn dark btn-md select-send-options send-to-all-users_ col-md-<?php echo $col_md; ?> tooltips" data-original-title="Under Construction" style="font-size:0.9em;">
                                                All Users
                                            </button>
                                            <button type="button" class="btn dark btn-md select-send-options send-to-a-friend col-md-3 <?php echo $show_sent_to_friend; ?>" style="font-size:0.9em;">
                                                A Friend
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
                                    $pre_link.'/lookbook/send/sa/'.$sa_details->lookbook_id,
                                    array(
                                        'class' => 'form-horizontal',
                                        'id' => 'form-send_sales_package'
                                    )
                                ); ?>

                                <input type="hidden" name="lookbook_id" value="<?php echo $sa_details->lookbook_id; ?>" />
                                <input type="hidden" name="send_to" value="current_user" />
                                <input type="hidden" name="sales_user" value="<?php echo $sales_user; ?>" />
                                <input type="hidden" name="user_id" value="<?php echo $author_id; ?>" />
                                <input type="hidden" name="user_role" value="admin" />
                                <input type="hidden" name="user_name" value="<?php echo $author; ?>" />
                                <input type="hidden" name="user_email" value="<?php echo $author_email; ?>" />

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

                                <div class="send_to_a_friend display-none">

									<h4> <cite>SEND TO A FRIEND:</cite> </h4>

									<div class="form-body col-md-12">

										<div class="form-group">
											<label>Email<span class="required"> * </span>
											</label>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-envelope"></i>
												</span>
												<input type="email" name="email_a_friend" class="form-control input_send_to_a_friend display-none" value="<?php echo set_value('email'); ?>" />
											</div>
										</div>

                                    </div>

                                    <button type="submit" class="btn-send-lookbook-to-a-friend btn dark btn-sm margin-bottom-10">
                                        Send Lookbook
                                    </button>

                                </div>

                                <?php $this->load->view('admin/metronic/sa_send_to_new_user'); ?>

                                <?php $this->load->view('admin/metronic/sa_send_to_current_user'); ?>

                                <?php $this->load->view('admin/metronic/sa_send_to_all_users'); ?>

                                <h3 class="notice-select-action <?php echo @$ws_user_details ? 'hide' : 'hide'; ?>"><cite>Select action...</cite></h3>

                                <?php echo form_close(); ?>
                                <!-- End FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>

                        </div>

                        <!-- ADD STYLE NUMBERS NOT YET UPLOADED -->
                        <div class="modal fade" id="modal-unlisted_style_no" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Add STYLE NUMBERS not on productl ist </h4>
                                    </div>

                                    <!-- BEGIN FORM-->
                                    <!-- FORM =======================================================================-->
                                    <form id="form-add_unlisted_style_no" class="form-horizontal" action="" method="POST" accept-charset="utf-8" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <input type="hidden" name="action" value="add_item" />

                                    <div class="modal-body">

                                        <div class="form margin-bottom-30">

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Style Number:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control facet_name" name="prod_no" value="" style="text-transform:uppercase;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Color Code:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <select class="form-control bs-select" name="color_code" data-live-search="true" data-size="8" data-show-subtext="true">
                                                        <option value="" selected disabled> - Select a color - </option>

                                                        <?php
                                                        if (@$colors)
                                                        {
                                                            foreach ($colors as $color)
                                                            { ?>

                                                        <option value="<?php echo $color->color_code; ?>" data-subtext="<cite>(<?php echo $color->color_code; ?>)</cite>" data-color_name="<?php echo $color->color_name; ?>">
                                                            <?php echo ucwords(strtolower($color->color_name)); ?>
                                                        </option>

                                                                <?php
                                                            }
                                                        } ?>

                                                    </select>
                                                    <input type="hidden" name="color_name" value="" />
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn dark"> Submit </button>
                                    </div>

                                    </form>
                                    <!-- END FORM ===================================================================-->
                                    <!-- END FORM-->

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- EDIT VENDOR PRICE -->
                        <div id="modal-edit_item_price" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Item Price</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="eip-modal-item"></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">New Price
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="item_price" data-required="1" class="form-control input-sm modal-input-item-price" value="" size="2" data-prod_no="" data-item="" data-page="create" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark submit-edit_item_prices" data-item="">Apply changes</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>
                    <!-- END PAGE CONTENT BODY -->
