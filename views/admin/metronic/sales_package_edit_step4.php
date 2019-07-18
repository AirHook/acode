                        <!-- BEGIN PAGE CONTENT BODY -->

                        <div class="hidden-sm hidden-xs">
                            <?php $this->load->view('admin/metronic/sales_package_steps_wizard'); ?>
                        </div>

                        <div class="row margin-bottom-30">

                            <div class="col-md-12">
    							<div class="portlet ">
    								<div class="portlet-title">

    									<?php
    									/***********
    									 * Noification area
    									 */
    									?>
                                        <div class="notification">
        									<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
        									<div class="alert alert-success">
        										<button class="close" data-close="alert"></button> Sales Package sent to multiple email.
        									</div>
        									<?php } ?>
        									<?php if ($this->session->flashdata('success') == 'edit') { ?>
        									<div class="alert alert-success auto-remove">
        										<button class="close" data-close="alert"></button> Product item updated...
        									</div>
        									<?php } ?>
        									<?php if (validation_errors()) { ?>
        									<div class="alert alert-danger auto-remove">
        										<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
        									</div>
        									<?php } ?>
        									<?php if ($this->session->flashdata('error') == 'error_sending_package') { ?>
        									<div class="alert alert-danger auto-remove">
        										<button class="close" data-close="alert"></button> There were some errors sending package.
        									</div>
        									<?php } ?>
                                        </div>

                                        <div class="actions btn-set">
    										<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package'); ?>">
    											<i class="fa fa-reply"></i> Back to package list</a>
    										<a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    											<i class="fa fa-plus"></i> Create Another Sales Package </a>
    									</div>

    								</div>
    							</div>
                            </div>

    						<!-- BEGIN FORM-->
    						<!-- FORM =======================================================================-->
    						<?php echo form_open(
                                ($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/send/index/'.$this->sales_package_details->sales_package_id,
                                array(
                                    'id' => 'form-sales_package_sending',
                                    'class'=>'form-horizontal'
                                )
                            ); ?>

    						<input type="hidden" name="sales_package_id" value="<?php echo $this->sales_package_details->sales_package_id; ?>" />

    						<div class="col-xs-12">
                                <!-- BEGIN PORTLET-->
                                <div class="portlet box blue-hoki">
    								<div class="portlet-title">
    									<div class="caption">
    										<i class="fa fa-info"></i> Send Sales Package </div>
    									<!-- DOC: Remove "hide" class to enable -->
    									<div class="actions hide">
    										<a href="javascript:;" class="btn btn-default btn-sm">
    											<i class="fa fa-check"></i> Save </a>
    									</div>
    								</div>
    								<div class="portlet-body">

    									<div class="row">
                                            <div class="form-body">
                                                <br />
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Select Email(s)</label>
                                                    <div class="col-md-9">
    													<?php
    													/***********
    													 * Default Multi Select plugin
    													 * Initialized with $('#my_multi_select1').multiSelect();
    													 * at page's plugin script
    													 */
    													if ($users)
    													{
                                                            if ($user_id)
                                                            {
                                                                foreach ($users as $user)
                                                                { ?>

                                                        <input type="text" class="form-control" name="users[]" value="<?php echo $user->email; ?>" readonly />

                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            { ?>

                                                        <select multiple="multiple" class="multi-select" id="my_multi_select1" name="users[]" style="width:200px;">

    														<?php
    														foreach ($users as $user)
    														{ ?>

                                                            <option value="<?php echo $user->email; ?>"><?php echo $user->store_name; ?> &nbsp; <small>&lt;<?php echo $user->email; ?>&gt;</small></option>

    														<?php
    														} ?>
                                                        </select>

        													<?php
        													}
                                                        }
    													else
    													{
    														echo 'No Active Wholesale Users.';
    													}
    													?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4 col-md-offset-2 btn-set">
                                                        <button type="submit" class="btn blue btn-md btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">
                                                            <span class="ladda-label">Send Package</span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                    </div>
                                                </div>
    										</div>
    									</div>

    									<hr />

    									<h2> <?php echo $this->sales_package_details->sales_package_name; ?>
    									<span class="actions btn-set text-right">
    										<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/step1/'.$this->sales_package_details->sales_package_id); ?>">
    											<i class="fa fa-pencil"></i> Edit this sales package</a>
    									</span>
    									</h2>

    									<div class="col-xs-12">
    									<br />
    									<p> Dear [user] </p>
    									<p> <?php echo $this->sales_package_details->email_message; ?> </p>
    									<p> CLICK HERE for more details of the package... </p>
    									</div>

    									<style>
        									.thumb-tiles {
        										position: relative;
        										margin-right: -10px;
        									}
        									.thumb-tiles .thumb-tile {
        										display: block;
        										float: left;
        										height: 210px;
        										width: 140px !important;
        										cursor: pointer;
        										text-decoration: none;
        										color: #fff;
        										position: relative;
        										font-weight: 300;
        										font-size: 12px;
        										letter-spacing: .02em;
        										line-height: 20px;
        										overflow: hidden;
        										border: 4px solid transparent;
        										margin: 0 10px 10px 0;
        									}
        									.thumb-tiles .package {
        										width: 80px !important;
        										height: 120px;
        									}
        									.thumb-tiles .thumb-tile.selected .corner::after {
        										content: "";
        										display: inline-block;
        										border-left: 40px solid transparent;
        										border-bottom: 40px solid transparent;
        										border-right: 40px solid #ccc;
        										position: absolute;
        										top: -3px;
        										right: -3px;
        										z-index: 100;
        									}
        									.thumb-tiles .thumb-tile.selected .check::after {
        										font-family: FontAwesome;
        										font-size: 13px;
        										content: "\f00c";
        										color: red;
        										position: absolute;
        										top: 2px;
        										right: 2px;
        										z-index: 101;
        									}
        									.thumb-tiles .thumb-tile.image .tile-body {
        										padding: 0 !important;
        									}
        									.thumb-tiles .thumb-tile .tile-body {
        										height: 100%;
        										vertical-align: top;
        										padding: 10px;
        										overflow: hidden;
        										position: relative;
        										font-weight: 400;
        										font-size: 12px;
        										color: #fff;
        										margin-bottom: 10px;
        									}
        									.thumb-tiles .thumb-tile.image .tile-body > img {
        										width: 100%;
        										height: auto;
        										min-height: 100%;
        										max-width: 100%;
        									}
        									.thumb-tiles .thumb-tile .tile-body img {
        										margin-right: 10px;
        									}
        									.thumb-tiles .thumb-tile .tile-object {
        										position: absolute;
        										bottom: 0;
        										left: 0;
        										right: 0;
        										min-height: 30px;
        										background-color: transparent;
        									}
        									.thumb-tiles .thumb-tile .tile-object > .name {
        										position: absolute;
        										bottom: 0;
        										left: 0;
        										margin-bottom: 5px;
        										margin-left: 10px;
        										margin-right: 15px;
        										font-weight: 400;
        										font-size: 13px;
        										color: #fff;
        									}
        									.img-a {
        										position: absolute;
        										left: 0;
        										top: 0;
        									}
        									.img-b {
        										position: absolute;
        										left: 0;
        										top: 0;
        									}
    									</style>

    									<div class="thumb-tiles sales-package clearfix">

    										<?php
    										if ( ! empty($this->sales_package_details->items))
    										{
    											foreach ($this->sales_package_details->items as $product)
    											{
    												// get product details
    												$this->product_details->initialize(array('tbl_product.prod_no'=>$product));

    												// set image paths
    												$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
    												$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
    												// the image filename
    												$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
                                                    // the new way relating records with media library
                                                    $img_front_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg';
                                                    $img_back_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_b3.jpg';
    												?>

    											<div class="thumb-tile package image bg-blue-hoki <?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?> selected" data-sku="<?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>">

    												<div class="corner"> </div>
    												<div class="check"> </div>
    												<div class="tile-body">
                                                        <img class="img-b" src="<?php echo ($this->product_details->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
                                                        <img class="img-a" src="<?php echo ($this->product_details->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
    												</div>
    												<div class="tile-object">
    													<div class="name"> <?php echo $this->product_details->public == 'N' ? '<span style="color:#ed6b75;"> Private </span> <br />' : ''; ?> <?php echo $this->product_details->prod_no; ?> </div>
    												</div>

    											</div>

    										<?php
    											}

    											echo '<input type="hidden" id="items_count" name="items_count" value="'.$this->sales_package_details->items_count.'" />';
    										}
    										else echo '<input type="hidden" id="items_count" name="items_count" value="0" />';
    										?>

    									</div>

    								</div>
                                </div>
                                <!-- END \PORTLET-->
    						</div>

    						</form>
    						<!-- End FORM ===================================================================-->
    						<!-- END FORM-->

    						<script>
    						</script>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
