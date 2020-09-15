<div class="how-to-order-form">

	<div style="padding:0 15px 15px;">

		<div class="row" style="background:black;">
			<div class="col col-md-6 hidden-sm hidden-xs">
				<img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>.png" />
			</div>
			<div class="col col-md-6 hidden-sm hidden-xs text-right" style="padding-top:7px;">
				<h5 style="color:white;">COMPLETE BELOW FORM TO SEE PRICE AND AVAILABILITY</h5>
			</div>
			<div class="col hidden-lg hidden-md col-sm-12 text-center">
				<img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>.png" style="max-width:100%;" />
			</div>
			<div class="col hidden-lg hidden-md col-md-6 col-sm-12 text-center">
				<h6 style="color:white;font-size:0.8em;">COMPLETE BELOW FORM TO SEE PRICE AND AVAILABILITY</h6>
			</div>
		</div>

	</div>

	<div class="row hidden-lg hidden-md hidden-sm">

		<div class="col col-xs-12">
			<img src="<?php echo $img_front_large; ?>" alt="" width="100%" />
		</div>

	</div>

	<div class="row">

		<div class="col col-sm-4 hidden-xs">
			<img src="<?php echo $image; ?>" alt="" width="100%" />
		</div>
		<br class="hidden-lg hidden-md hidden-sm" />
		<div class="col col-sm-8">

			<style>
				#form-about_product .form-group {
					margin-bottom: 5px;
				}
				#form-about_product input {
					line-height: 12px;
					height: 25px;
				}
				#form-about_product .mt-radio-list {
					padding: 0;
				}
				#form-about_product .mt-radio {
					font-size: 0.9em;
				}
			</style>

			<!--bof form=========================================================================-->
			<?php
			echo form_open(
				'about_product/inquiry',
				array(
					'style'=>'font-size:0.9em;',
					'id'=>'form-about_product',
					'class'=>'' // form-horizontal
				)
			);
			?>

			<input type="hidden" name="the_time" value="<?php echo time(); ?>" />
			<input type="hidden" name="return_url" value="<?php echo @$return_url ?: $this->uri->uri_string(); ?>" />
			<input type="hidden" name="prod_no" value="<?php echo @$prod_no; ?>" />
			<input type="hidden" name="color_code" value="<?php echo @$color_code; ?>" />
			<input type="hidden" name="no_stocks_at_all" value="<?php echo @$no_stocks_at_all; ?>" />

			<input type="hidden" name="image" value="<?php echo $image; ?>" />

			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
						<label class="hide">NAME<span class="required"> * </span>
						</label>
						<input type="text" class="form-control" name="name" value="" placeholder="NAME *" style="height:auto;" />
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label class="hide">DRESS SIZE<span class="required"> * </span>
						</label>
						<input type="text" class="form-control" name="dress_size" value="" placeholder="DRESS SIZE" style="height:auto;" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="hide">EMAIL<span class="required"> * </span>
				</label>
				<input type="email" class="form-control" name="email" value="" placeholder="EMAIL *" style="height:auto;" />
			</div>
			<div class="form-horizontal" role="form" style="color:red;">
				<div class="form-group">
                    <label class="col-xs-7 control-label" style="text-align:left;text-transform:uppercase;">Send me reduced price offers on items *</label>
                    <div class="col-xs-5">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="opt_type" value="1" checked /> Yes
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="opt_type" value="0" /> No
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
			</div>
			<div role="form" style="color:red;">
				<div class="form-group">
                    <div class="mt-radio-list">
                        <label class="mt-radio mt-radio-outline" style="text-transform:uppercase;"> I AM A STORE * You will be taken to fill out wholesale form for verification
                            <input type="radio" name="u_type" value="Store" />
                            <span></span>
                        </label>
                        <label class="mt-radio mt-radio-outline" style="text-transform:uppercase;"> I AM A CONSUMER * You will be taken to shop7thavenue.com our shop site
                            <input type="radio" name="u_type" value="Consumer" />
                            <span></span>
                        </label>
                    </div>
                </div>
			</div>
			<div class="form-group">
                <label>MESSAGE OR COMMENTS</label>
                <textarea class="form-control" rows="3" name="message"></textarea>
            </div>
			<br />
			<button type="submit" class="btn dark btn-block" name="send" value="Send">SEND PRODUCT INQUIRY</button>

			</form>
			<!--eof form=========================================================================-->

		</div>

	</div>

</div>
