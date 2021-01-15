<?php
/***********
 * Noification area
 */
?>
<div>
	<?php if ($this->session->flashdata('color_exists')) { ?>
	<div class="alert alert-danger auto-remove" style="margin-bottom:50px;">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> Color already esists...
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('color_added')) { ?>
	<div class="alert alert-success auto-remove margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> Color added!
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('primary_color_updated')) { ?>
	<div class="alert alert-success auto-remove margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> Priamry color updated!
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('stock_udpated')) { ?>
	<div class="alert alert-success auto-remove margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> EDIT STOCK updated!
	</div>
	<?php } ?>
	<?php if ($this->session->flashdata('color_deleted')) { ?>
	<div class="alert alert-success auto-remove margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> Color deleted!
	</div>
	<?php } ?>
	<?php if ( ! $this->product_details->primary_img_id) { ?>
	<div class="alert alert-danger margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> You product item has no primary color.
	</div>
	<?php } ?>
	<?php if (empty($this->product_details->colors)) { ?>
	<div class="alert alert-danger margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> You product has no colors.
	</div>
	<?php } ?>
	<?php if ($inc_images) { ?>
	<div class="alert alert-danger margin-bottom-10">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		<i class="fa fa-warning fa-lg"></i> You product must have at least the front main image for your primary color. Upload images first.
	</div>
	<?php } ?>
</div>

<div class="row margin-bottom-10">
	<div class="col-md-6">
		<div class="btn-group">
			<a href="#modal-add-color" id="" class="btn sbold green" data-toggle="modal"> Add New Color
				<i class="fa fa-plus"></i>
			</a>
		</div>
	</div>
</div>

<div class="row">
	<?php
	/***********
	 * Available COLORS
	 */
	?>
	<?php
	if ($this->product_details->available_colors())
	{
		foreach ($this->product_details->available_colors() as $color)
		{
			// set main image
			$_image_url =
				$color->image_url_path
				? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_f.jpg'
				: $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_front/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
			;
			// set color-icon url path prefixes
			// incorporating new media path system
			$img_prefix_coloricon =
				$color->image_url_path
				? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg'
				: $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
			;
			// get options if any
			$color_options = json_decode($color->options, TRUE);
			?>

	<input type="hidden" name="st_id[]" value="<?php echo $color->st_id; ?>" />
	<input type="hidden" name="color_name[<?php echo $color->st_id; ?>]" value="<?php echo $color->color_name; ?>" />
	<input type="hidden" name="color_code[<?php echo $color->st_id; ?>]" value="<?php echo $color->color_code; ?>" />
	<input type="hidden" name="primary_color[<?php echo $color->st_id; ?>]" value="<?php echo $color->primary_color; ?>" />
	<input type="hidden" name="image_url_path[<?php echo $color->st_id; ?>]" value="<?php echo $color->image_url_path; ?>" />
	<input type="hidden" name="image_url[<?php echo $color->st_id; ?>]" value="<?php echo $_image_url; ?>" />

	<div class="col-md-12">
		<div class="portlet box <?php echo $color->color_code == $this->product_details->primary_img_id ? 'yellow-soft' : 'grey-salsa'?>">

			<div class="portlet-title">
				<div class="caption">
					<strong> <?php echo $color->color_name; ?> </strong>
					<?php if ($color->color_code == $this->product_details->primary_img_id) { ?>
					<span class="caption-helper" style="color:#080808;"><em>primary color</em></span>
					<?php } ?>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
				</div>
				<!-- DOC: Remove "hide" class to enable -->
				<div class="actions <?php echo $color->color_code == $this->product_details->primary_img_id ? 'hide' : ''?>">
					<a data-toggle="modal" href="#setprimary-<?php echo $color->st_id; ?>" class="btn btn-default btn-sm">
						<i class="fa fa-check"></i> Set as Primary </a>
				</div>
				<div class="actions <?php echo $color->color_code == $this->product_details->primary_img_id ? 'hide' : ''?>">
					<a data-toggle="modal" href="#delcolor-<?php echo $color->st_id; ?>" class="btn btn-default btn-sm">
						<i class="fa fa-trash"></i> Delete </a>
				</div>
			</div>

			<div class="portlet-body">

				<?php
				/***********
				 * Image Heading Bar
				 */
				?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div style="float:right;display:inline;height:40px;width:auto;text-align:right;">
							<img class="img-responsive" src="<?php echo $img_prefix_coloricon; ?>" style="float:right;height:40px;width:40px;background-color:#67809F;" onerror="this.style.visibility='hidden'">
							<br />
							<small><cite>coloricon/swatch</cite></small>
						</div>
						<div class="caption">
							<i class="fa fa-file-image-o"></i>
							<span class="caption-subject uppercase"> Images</span>
							<span class="caption-helper"> <em>click for large view...</em></span>
						</div>
						<div class="actions">
							<a href="#modal-upload_images" class="btn btn-default btn-sm sbold blue upload_images" data-toggle="modal" data-st_id="<?php echo $color->st_id; ?>" data-color_publish="<?php echo $color->color_publish; ?>" data-new_color_publish="<?php echo $color->new_color_publish; ?>">
								<i class="fa fa-plus"></i> Add Images to this color </a>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-md-4">

						<?php
						/***********
						 * Image Row
						 */
						?>
						<style>
							.thumb-tiles {
								position: relative;
								/*margin-right: -10px;*/
								display: inline-block;
							}
							.thumb-tiles .color-tile {linesheet
								display: block;
								float: left;
								height: 116px;
								width: 80px !important;
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
							.thumb-tiles .linesheet {
								width: 205px !important;
							}
							.thumb-tiles .color-tile.image .tile-body {
								padding: 0 !important;
							}
							.thumb-tiles .color-tile .tile-body {
								height: 100%;
								vertical-align: top;
								padding: 10px;
								overflow: hidden;
								position: relative;
								font-weight: 400;
								font-size: 12px;
								color: #fff;
								/*margin-bottom: 10px;*/
							}
							.thumb-tiles .color-tile.image .tile-body > img {
								width: 100%;
								height: auto;
								min-height: 100%;
								max-width: 100%;
							}
							.thumb-tiles .color-tile .tile-body img {
								/*margin-right: 10px;*/
							}
							.thumb-tiles .color-tile .tile-object {
								position: absolute;
								bottom: 0;
								left: 0;
								right: 0;
								min-height: 30px;
								background-color: transparent;
							}
							.thumb-tiles .color-tile .tile-object > .name {
								position: relative;
								bottom: 0;
								left: 0;
								margin: 0 auto;
								font-weight: 400;
								font-size: 13px;
								color: #fff;
							}
						</style>

						<div class="row">
							<div class="col-xs-12 text-center">
								<div class="alert alert-danger margin-bottom-10 display-hide" id="no-image-notice-<?php echo $color->st_id; ?>">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
									<i class="fa fa-warning fa-lg"></i> This product color has no front main image. Upload images first.
								</div>
								<div class="thumb-tiles">

									<?php
									// set image url path prefixes
									$img_prefix_front = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_front/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code;
									$img_prefix_back = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_back/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code;
									$img_prefix_side = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_side/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code;
									$img_prefix_video = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_video/'.$this->product_details->prod_no.'_'.$color->color_code;
									$img_prefix_linesheet = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_linesheet/'.$this->product_details->prod_no.'_'.$color->color_code;
									// new image media path
									$image_prefix = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name;
									?>

									<div class="color-tile image bg-blue-hoki">
										<div class="tile-body">
											<a href="<?php echo $color->image_url_path ? $image_prefix.'_f4.jpg' : $img_prefix_front.'_4.jpg'; ?>" class="fancybox-button" data-rel="fancybox-button">
												<img class="img-responsive" src="<?php echo $color->image_url_path ? $image_prefix.'_f3.jpg' : $img_prefix_front.'_3.jpg'; ?>" onerror="this.style.display='none';document.getElementById('no-image-notice-<?php echo $color->st_id; ?>').classList.remove('display-hide');">
											</a>
										</div>
										<div class="tile-object">
											<div class="name"> Front </div>
										</div>
									</div>
									<div class="color-tile image bg-blue-hoki">
										<div class="tile-body">
											<a href="<?php echo $color->image_url_path ? $image_prefix.'_b4.jpg' : $img_prefix_back.'_4.jpg'; ?>" class="fancybox-button" data-rel="fancybox-button">
												<img class="img-responsive" src="<?php echo $color->image_url_path ? $image_prefix.'_b3.jpg' : $img_prefix_back.'_3.jpg'; ?>" onerror="this.style.display='none';">
											</a>
										</div>
										<div class="tile-object">
											<div class="name"> Back </div>
										</div>
									</div>
									<div class="color-tile image bg-blue-hoki">
										<div class="tile-body">
											<a href="<?php echo $color->image_url_path ? $image_prefix.'_s4.jpg' : $img_prefix_side.'_4.jpg'; ?>" class="fancybox-button " data-rel="fancybox-button">
												<img class="img-responsive" src="<?php echo $color->image_url_path ? $image_prefix.'_s3.jpg' : $img_prefix_side.'_3.jpg'; ?>" onerror="this.style.display='none'">
											</a>
										</div>
										<div class="tile-object">
											<div class="name"> Side </div>
										</div>
									</div>
									<div class="color-tile image bg-blue-hoki">
										<div class="tile-body">
											<img class="img-responsive" src="<?php echo base_url().'images/instylelnylogo_3.jpg'; ?>" alt="">
										</div>
										<div class="tile-object">
											<div class="name"> Video </div>
										</div>
									</div>
									<div class="color-tile image bg-blue-hoki linesheet">
										<div class="tile-body">
											<a href="<?php echo $color->image_url_path ? $image_prefix.'_linesheet.jpg' : $img_prefix_linesheet.'.jpg'; ?>" class="fancybox-button " data-rel="fancybox-button">
												<img class="img-responsive" src="<?php echo $color->image_url_path ? $image_prefix.'_linesheet.jpg' : $img_prefix_linesheet.'.jpg'; ?>" onerror="this.style.display='none'">
											</a>
										</div>
										<div class="tile-object">
											<div class="name"> Linesheet </div>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>

					<div class="col-md-8">

						<?php
						/***********
						 * Options
						 */
						?>
						<div class="row section-options" data-color_code="<?php echo $color->color_code; ?>" data-base_url="<?php echo base_url(); ?>" data-st_id="<?php echo $color->st_id; ?>" data-primary_color="<?php echo $color->color_code == $this->product_details->primary_img_id ? 'true' : 'false'; ?>" data-object_data='{"st_id":"<?php echo $color->st_id; ?>","prod_id":"<?php echo $this->product_details->prod_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","prod_no":"<?php echo $this->product_details->prod_no; ?>","color_name":"<?php echo $color->color_name; ?>"}'>

							<div class="col-xs-12">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div class="notifications">
									<?php if ($this->product_details->pending) { ?>
									<div class="alert alert-danger">
										<i class="fa fa-warning fa-lg"></i> Publish PENDING until main product item Publish Date is current.
									</div>
									<?php } ?>
									<div class="alert alert-danger notice-variant_level_publish" <?php echo ($this->product_details->publish === '0' OR $this->product_details->publish === '3') ? '': 'style="display:none;"'; ?>>
										<i class="fa fa-warning fa-lg"></i> Color will be published when product is Published.
									</div>
								</div>

								<?php if ($color->color_code == $this->product_details->primary_img_id)
								{ ?>

								<div class="note note-warning">
									<p> This is a primary color. The only available option is the "Clearance Consumer Option" only. Other options for this item follows that of main product publish options. </p>
								</div>
								<input type="hidden" name="new_color_publish[<?php echo $color->st_id; ?>]" value="<?php echo $this->product_details->publish; ?>" />
								<input type="hidden" name="color_publish[<?php echo $color->st_id; ?>]" value="<?php echo $this->product_details->publish === '2' ? 'N' : 'Y'; ?>" />
								<input type="hidden" name="stock_date[<?php echo $color->st_id; ?>]" value="<?php echo $color->stock_date ?: $this->product_details->create_date; ?>" />
								<input type="hidden" name="custom_order[<?php echo $color->st_id; ?>]" value="<?php echo $color->custom_order == '3' ?: '0'; ?>" />

									<?php
								}
								else
								{ ?>

								<div class="form-group">
									<label class="col-lg-4 control-label"> Publish:
										<span class="required"> * </span>
									</label>
									<div class="col-lg-8 <?php echo $color->color_code == $this->product_details->primary_img_id ? 'tooltips': ''; ?>" data-original-title="Primary Color! Change MAIN Publish Date Options to change this variant primary color publish date option.">
										<div class="mt-radio-inline new_color_publish <?php echo $color->new_color_publish; ?>">
											<label class="mt-radio mt-radio-outline">
												<input type="radio" name="new_color_publish[<?php echo $color->st_id; ?>]" value="1" <?php echo ($color->new_color_publish === '1' OR $color->new_color_publish === '11' OR $color->new_color_publish === '12' OR $color->new_color_publish === '2') ? 'checked': ''; ?> /> Publish
												<span></span>
											</label>
											<label class="mt-radio mt-radio-outline">
												<input type="radio" name="new_color_publish[<?php echo $color->st_id; ?>]" value="0" <?php echo $color->new_color_publish === '0' ? 'checked': ''; ?> /> UN-Publish
												<span></span>
											</label>
										</div>
									</div>
									<?php if (@$this->webspace_details->options['site_type'] == 'hub_site') { ?>
									<div class="col-md-8 col-md-offset-4">
										<div class="mt-checkbox-list">
											<label class="mt-checkbox mt-checkbox-outline <?php echo ($color->new_color_publish === '0') ? 'mt-checkbox-disabled' : ''; ?>">
												<input type="checkbox" class="new_color_publish_at new_color_publish_at_hub" id="new_color_publish_at_hub-<?php echo $color->color_code; ?>" name="new_color_publish_at_hub[<?php echo $color->st_id; ?>]" value="1" <?php echo ($color->new_color_publish === '1' OR $color->new_color_publish === '11') ? 'checked': ''; ?> <?php echo ($this->product_details->publish === '0') ? 'disabled' : ''; ?> /> at this hub site
												<span></span>
											</label>
											<label class="mt-checkbox mt-checkbox-outline <?php echo ($color->new_color_publish === '0') ? 'mt-checkbox-disabled' : ''; ?>">
												<input type="checkbox" class="new_color_publish_at new_color_publish_at_satellite" id="new_color_publish_at_satellite-<?php echo $color->color_code; ?>" name="new_color_publish_at_satellite[<?php echo $color->st_id; ?>]" value="1" <?php echo ($color->new_color_publish === '1' OR $color->new_color_publish === '12') ? 'checked': ''; ?> <?php echo ($this->product_details->publish === '0') ? 'disabled' : ''; ?> data-color_code="<?php echo $color->color_code; ?>" /> at satellite site
												<span></span>
											</label>
										</div>
									</div>
									<?php } ?>
									<label class="col-lg-4 control-label"> View:
										<span class="required"> * </span>
									</label>
									<div class="col-lg-8 <?php echo $color->color_code == $this->product_details->primary_img_id ? 'tooltips': ''; ?>" data-original-title="Primary Color! Change MAIN Publish Date Options to change this variant primary color publish date option.">
										<div class="mt-radio-inline color_publish <?php echo $color->new_color_publish; ?>">
											<label class="mt-radio mt-radio-outline">
												<input type="radio" name="color_publish[<?php echo $color->st_id; ?>]" value="1" <?php echo $color->color_publish === 'Y' ? 'checked': ''; ?> /> Public
												<span></span>
											</label>
											<label class="mt-radio mt-radio-outline">
												<input type="radio" name="color_publish[<?php echo $color->st_id; ?>]" value="0" <?php echo $color->color_publish === 'N' ? 'checked': ''; ?> /> Private
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4">Date to Publish:
										<span class="required"> * </span>
									</label>
									<div class="col-md-7 <?php echo $color->color_code == $this->product_details->primary_img_id ? 'tooltips': ''; ?>" data-original-title="Primary Color! Change MAIN Publish Date Options to change this variant primary color publish date option.">
										<input class="form-control form-control-inline color_date date-picker" type="text" id="stock_date-<?php echo $color->color_code; ?>" name="stock_date[<?php echo $color->st_id; ?>]" value="<?php echo $color->stock_date ?: $this->product_details->create_date; ?>" <?php echo ($this->product_details->publish === '0' OR $color->color_code == $this->product_details->primary_img_id) ? 'disabled': ''; ?> data-initial_value="<?php echo $color->stock_date ?: $this->product_details->create_date; ?>" />
										<span class="help-block">
											Select/Type date <br /> format: yyyy-mm-dd <br />
											<small><a class="color_date" data-stock_date_id="#stock_date-<?php echo $color->color_code; ?>" onclick="$('#stock_date-<?php echo $color->color_code; ?>').datepicker('setDate', '<?php echo $color->stock_date ?: $this->product_details->create_date; ?>');"><cite>refresh date</cite></a></small>
										</span>
										<span class="help-block">
											Set date to future to make Publish in Pending mode. Set to present or past to publish immediately.
										</span>
									</div>
								</div>

									<?php
								} ?>

								<div class="form-group" style="margin-bottom:0px;">
									<label class="control-label col-md-5">On Sale:</label>
									<div class="col-md-7">
										<div class="mt-checkbox-inline" style="padding-bottom:0px;">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="custom_order" id="custom_order-<?php echo $color->color_code; ?>" name="custom_order[<?php echo $color->st_id; ?>]" value="3" <?php echo $color->custom_order == '3' ? 'checked': ''; ?> <?php echo ($this->product_details->publish === '0') ? 'disabled': ''; ?> /> Yes
												<span></span>
												<input type="hidden" name="custom_order_old[<?php echo $color->st_id; ?>]" value="<?php echo $color->custom_order; ?>" />
											</label>
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-bottom:0px;">
									<label class="control-label col-md-5">Clearance Consumer Only:</label>
									<div class="col-md-7">
										<div class="mt-checkbox-inline" style="padding-bottom:0px;">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="clearance_consumer_only" id="clearance_consumer_only-<?php echo $color->color_code; ?>" name="clearance_consumer_only[<?php echo $color->st_id; ?>]" value="1" <?php echo @$color_options['clearance_consumer_only'] == '1' ? 'checked': ''; ?> /> Yes
												<span></span>
												<input type="hidden" name="clearance_consumer_only_old[<?php echo $color->st_id; ?>]" value="<?php echo @$color_options['clearance_consumer_only']; ?>" />
											</label>
										</div>
									</div>
								</div>

								<?php if ($this->webspace_details->options['site_type'] == 'hub_site')
								{ ?>

								<div class="form-group" style="margin-bottom:0px;">
									<label class="control-label col-md-5">Shop7th Private Stock Sale:</label>
									<div class="col-md-7">
										<div class="mt-checkbox-inline" style="padding-bottom:0px;">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="admin_stocks_only" id="admin_stocks_only-<?php echo $color->color_code; ?>" name="admin_stocks_only[<?php echo $color->st_id; ?>]" value="1" <?php echo @$color_options['admin_stocks_only'] == '1' ? 'checked': ''; ?> /> Yes
												<span></span>
											</label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-5">Post Item to Google</label>
									<div class="col-md-7">
										<div class="mt-checkbox-inline" style="padding-bottom:0px;">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="post_to_goole" id="post_to_goole-<?php echo $color->color_code; ?>" name="post_to_goole[<?php echo $color->st_id; ?>]" value="<?php echo @$color_options['post_to_goole'] ?: '1'; ?>" <?php echo @$color_options['post_to_goole'] ? 'checked': ''; ?> /> Yes
												<span></span>
											</label>
										</div>
										<cite class="small help-block">
											NOTE: It may take between 2-5 mins before actually reflecting at Google Merchant Center. Images gets crawled within 3 days. Google approval usually haapens within a day.
										</cite>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-5">Post and Update at DSCO</label>
									<div class="col-md-7">
										<div class="mt-checkbox-inline" style="">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" class="post_to_dsco" id="post_to_dsco-<?php echo $color->color_code; ?>" name="post_to_dsco[<?php echo $color->st_id; ?>]" value="1" <?php echo @$color_options['post_to_dsco'] ? 'checked': ''; ?> /> Yes
												<span></span>
											</label>
											<cite class="small help-block">
												NOTES: Previously checked items that are being unchecked will set items at DSCO to 'out-of-stock' for all sizes. Otherwise, 'in-stock' status will be posted to sizes with available quantity.
											</cite>
										</div>
										<?php
										/***********
										 * Noification area
										 */
										?>
										<div class="notifications">
											<?php if ($this->session->flashdata('invalid_dsco_sku')) { ?>
											<div class="alert alert-danger">
												<i class="fa fa-warning fa-lg"></i> ...
											</div>
											<?php } ?>
											<div class="alert alert-warning" style="margin-bottom:5px;">
												Before POSTING, please check DSCO SKU# below...
											</div>
										</div>
										<div class="">
											<?php
											$dsco_sku = @$color_options['post_to_dsco'] ?: $this->product_details->prod_no.'-'.$color->color_name;
											?>
											DSCO SKU: <input type="text" name="dsco_sku" value="<?php echo $dsco_sku; ?>" style="width:110px;border:1px solid #ccc;" /> <span style="color:#737373;">(_1/2/.../9)</span>
										</div>
										<cite class="small help-block">
											NOTES:
											<ul style="padding-left:10px;">
												<li>
													Please ensure that the above SKU matches that of DSCO SKU#.
												</li>
												<li>
													Re-type SKU so that the system will save the correct SKU.
												</li>
												<li>
													DO NOT include the suffix '_1' and so on...
												</li>
											</ul>
										</cite>
									</div>
								</div>


									<?php
								} ?>

							</div>
						</div>

					</div>

				</div>

				<?php
				/***********
				 * Stocks
				 */
				?>
				<div class="panel panel-default" data-width_stocks="<?php echo isset($color->with_stocks) ? $color->with_stocks : ''; ?>">
					<div class="panel-heading">

						<?php if (isset($color->with_stocks) && $color->with_stocks == '0')
						{ ?>

						<div style="float:right;display:inline;">
							<div class="note note-danger bg-red bg-font-red" >
								PRE ORDER
							</div>
						</div>

							<?php
						} ?>

						<div class="caption">
							<i class="glyphicon glyphicon-folder-close"></i>
							<span class="caption-subject uppercase"> Edit Stock </span>
						</div>

						<?php if ($this->product_details->size_mode == '2_')
						{ ?>

						<div class="actions">
							Pre-packed... (1S-2M-2L-1XL)
						</div>

							<?php
						}
						else
						{
							$size_ary = array();
							$size_assoc_ary = array();
							foreach ($size_names as $size_label => $s)
							{
								$available_size_label = str_replace('size', 'size_physical', $size_label);
								array_push($size_ary, $color->$size_label);
								$size_assoc_ary[$size_label] = $color->$size_label;
							}
							$size_csv = implode(',',$size_ary);
							$size_json = json_encode($size_assoc_ary);
							?>

						<div class="actions">
							<a id="modal_stocks-<?php echo $color->st_id; ?>" data-toggle="modal" href="#update_stock" class="modal_stocks btn btn-default btn-sm" data-stocks="<?php echo $size_csv; ?>" data-size_mode="<?php echo $this->product_details->size_mode; ?>" data-color_name="<?php echo $color->color_name; ?>" data-st_id="<?php echo $color->st_id; ?>">
								<i class="fa fa-pencil"></i> Edit stocks... </a>
							<a href="javascript:;" class="modal_stocks btn btn-default btn-sm">
								Last modified: <?php echo date('Y-m-d', @$color_options['last_modified']); ?> </a>
							<a href="#barcode-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" data-toggle="modal" class="btn dark btn-sm">Print Barcode Labels</a>
						</div>

						<table class=" table-bordered table-striped table-hover margin-top-10">
							<thead>
								<tr>
									<?php $size_cnt = count($size_names); ?>
									<tr>
										<th colspan="<?php echo $size_cnt; ?>">
											Si<a href="javascript:;" class="font-dark" onclick="$('.stock-status-regular-<?php echo $color->st_id; ?>').toggle();">z</a>e
										</th>
									</tr>

									<tr>
										<?php
										foreach ($size_names as $size_label => $s)
										{
											if (
												$this->product_details->size_mode == '2'
												OR $this->product_details->size_mode == '4'
											)
											{
												$th_width = 'width:150px;';
											}
											else $th_width = 'width:70px;';
											?>

										<th style="text-align:center;font-weight:600;padding:8px;<?php echo $th_width; ?>"> <?php echo $s; ?> </th>

											<?php
										} ?>
									</tr>
								</tr>
							</thead>
							<tbody>
								<tr>

									<?php
									foreach ($size_names as $size_label => $s)
									{ ?>

									<td style="padding:5px;text-align:center;"><small> <?php echo $color->$size_label ?: 0; ?> </small></td>

										<?php
									} ?>

								</tr>
								<tr class="stock-status-regular-<?php echo $color->st_id; ?> available <?php echo ENVIRONMENT === 'development' ?: 'display-none'; ?>">

									<?php
									foreach ($size_names as $size_label => $s)
									{
										$available_label =  str_replace('size', 'available', $size_label)
										?>

									<td style="padding:5px;text-align:center;"><small> <?php echo $color->$available_label ?: 0; ?> </small></td>

										<?php
									} ?>

								</tr>
								<tr class="stock-status-regular-<?php echo $color->st_id; ?> onorder <?php echo ENVIRONMENT === 'development' ?: 'display-none'; ?>">

									<?php
									foreach ($size_names as $size_label => $s)
									{
										$onorder_label =  str_replace('size', 'onorder', $size_label)
										?>

									<td style="padding:5px;text-align:center;"><small> <?php echo $color->$onorder_label ?: 0; ?> </small></td>

										<?php
									} ?>

								</tr>
						</table>

							<?php
						} ?>

						<div class="actions margin-top-10">
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][0]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][1]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][2]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][3]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][4]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['warehouse_code'][5]; ?>" placeholder="WHCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
						</div>

					</div>
				</div>

				<?php
				/***********
				 * Admin Stocks
				 */
				?>
				<?php if ($this->webspace_details->options['site_type'] == 'hub_site')
				{ ?>

				<div class="panel panel-default" data-width_stocks="<?php echo isset($color->with_stocks) ? $color->with_stocks : ''; ?>">
					<div class="panel-heading">

						<div class="caption">
							<i class="glyphicon glyphicon-folder-close"></i>
							<span class="caption-subject uppercase"> Edit Admin Stock </span>
						</div>

						<?php if ($this->product_details->size_mode == '2_')
						{ ?>

						<div class="actions">
							Pre-packed... (1S-2M-2L-1XL)
						</div>

							<?php
						}
						else
						{
							$size_ary = array();
							$size_assoc_ary = array();
							foreach ($size_names as $size_label => $s)
							{
								$admin_size_label = str_replace('size', 'admin_physical', $size_label);
								array_push($size_ary, ($color->$admin_size_label ?: '0'));
								$size_assoc_ary[$size_label] = $color->$admin_size_label ?: '0';
							}
							$size_csv = implode(',',$size_ary);
							$size_json = json_encode($size_assoc_ary);
							?>

						<div class="actions">
							<a id="modal_admin-stocks-<?php echo $color->st_id; ?>" data-toggle="modal" href="#update_admin_stock" class="modal_admin_stocks btn btn-default btn-sm" data-stocks="<?php echo $size_csv; ?>" data-size_mode="<?php echo $this->product_details->size_mode; ?>" data-color_name="<?php echo $color->color_name; ?>" data-st_id="<?php echo $color->st_id; ?>">
								<i class="fa fa-pencil"></i> Edit admin stocks... </a>
							<a href="javascript:;" class="modal_stocks btn btn-default btn-sm">
								Last modified: <?php echo date('Y-m-d', @$color_options['last_modified_admin_stocks']); ?> </a>
						</div>

						<table class=" table-bordered table-striped table-hover margin-top-10">
							<thead>
								<tr>
									<?php $size_cnt = count($size_names); ?>
									<tr>
										<th colspan="<?php echo $size_cnt; ?>">
											Si<a href="javascript:;" class="font-dark" onclick="$('.stock-status-admin-<?php echo $color->st_id; ?>').toggle();">z</a>e
										</th>
									</tr>

									<tr>
										<?php
										foreach ($size_names as $size_label => $s)
										{
											if (
												$this->product_details->size_mode == '2'
												OR $this->product_details->size_mode == '4'
											)
											{
												$th_width = 'width:150px;';
											}
											else $th_width = 'width:70px;';
											?>

										<th style="text-align:center;font-weight:600;padding:8px;<?php echo $th_width; ?>"> <?php echo $s; ?> </th>

											<?php
										} ?>
									</tr>
								</tr>
							</thead>
							<tbody>
								<tr>

									<?php
									foreach ($size_names as $size_label => $s)
									{
										$admin_size_label = str_replace('size', 'admin_physical', $size_label);
										?>

									<td style="padding:5px;text-align:center;"><small> <?php echo @$color->$admin_size_label ?: '0'; ?> </small></td>

										<?php
									} ?>

								</tr>
								<tr class="stock-status-admin-<?php echo $color->st_id; ?> available <?php echo ENVIRONMENT === 'development' ?: 'display-none'; ?>">

									<?php
									foreach ($size_names as $size_label => $s)
									{
										$admin_available_label =  str_replace('size', 'admin', $size_label)
										?>

									<td style="padding:5px;text-align:center;"><small> <?php echo $color->$admin_available_label ?: 0; ?> </small></td>

										<?php
									} ?>

								</tr>
								<tr class="stock-status-admin-<?php echo $color->st_id; ?> onorder <?php echo ENVIRONMENT === 'development' ?: 'display-none'; ?>">

									<?php
									foreach ($size_names as $size_label => $s)
									{
										$admin_onorder_label =  str_replace('size', 'admin_onorder', $size_label)
										?>

									<td style="padding:5px;text-align:center;"><small> <?php echo $color->$admin_onorder_label ?: 0; ?> </small></td>

										<?php
									} ?>

								</tr>
						</table>

							<?php
						} ?>

						<div class="actions margin-top-10">
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][0]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][1]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][2]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][3]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][4]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
							<input type="text" class="" name="admin_warehouse_code[<?php echo $color->st_id; ?>][]" value="<?php echo @$color_options['admin_warehouse_code'][5]; ?>" placeholder="AWCode" style="width:60px;text-align:center;border:1px solid #ccc;font-size:12px;line-height:1.5;padding:5px 0px;" />
						</div>

					</div>
				</div>

					<?php
				} ?>

				<?php
				/***********
				 * Colors Facet
				 */
				?>
				<div class="section-colors-facet clearfix" data-color_code="<?php echo $color->color_code; ?>" data-base_url="<?php echo base_url(); ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>" data-st_id="<?php echo $color->st_id; ?>" data-object_data='{"st_id":"<?php echo $color->st_id; ?>","prod_id":"<?php echo $this->product_details->prod_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","prod_no":"<?php echo $this->product_details->prod_no; ?>","color_name":"<?php echo $color->color_name; ?>"}'>
					<div class="col-md-12">
						<div class="form-group" data-color_facets="<?php echo $color->color_facets; ?>">
							<label class="control-label">Colors Facet:</label>
							<div class="mt-checkbox-inline">

								<?php foreach ($color_facets as $color_facet) { ?>
									<?php
									$color_facet_value = strlen($color_facet->color_name) == 3 ? $color_facet->color_name.'1' : $color_facet->color_name;
									$checked = in_array(strtoupper($color_facet_value), explode('-', strtoupper($color->color_facets))) ? 'checked="checked"' : '' ;
									?>

								<label class="mt-checkbox mt-checkbox-outline" style="width:125px;">
									<input type="checkbox" class="color_facets" name="color_facets[<?php echo $color->st_id; ?>][]" value="<?php echo $color_facet_value ?>" <?php echo $checked; ?> /> <?php echo $color_facet->color_name; ?>
									<span></span>
								</label>

								<?php } ?>

							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- SET COLOR ITEM AS PRIMARY -->
	<div class="modal fade bs-modal-sm" id="setprimary-<?php echo $color->st_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Notice!</h4>
				</div>
				<div class="modal-body"> Setting color item as primary! </div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/setprimary/index/'.$color->color_code.'/'.$color->color_name.'/'.$color->st_id.'/'.$this->product_details->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
						<span class="ladda-label">Confirm?</span>
						<span class="ladda-spinner"></span>
					</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!-- DELETE COLOR ITEM -->
	<div class="modal fade bs-modal-sm" id="delcolor-<?php echo $color->st_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Warning!</h4>
				</div>
				<div class="modal-body"> DELETE color item? </div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
					<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/delcolor/index/'.$color->color_code.'/'.$color->color_name.'/'.$color->st_id.'/'.$this->product_details->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
						<span class="ladda-label">Confirm?</span>
						<span class="ladda-spinner"></span>
					</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<!-- BARCODES -->
	<div class="modal fade bs-modal-md" id="barcode-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Barcode Labels</h4>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="col col-sm-12 margin-bottom-10">
							<strong><?php echo $this->product_details->prod_no.'_'.$color->color_code; ?></strong> Barcodes
						</div>
					</div>
					<div class="row margin-bottom-10">
						<div class="col col-sm-2">
							<strong>Size</strong>
						</div>
						<div class="col col-sm-6">
							<strong>Barcode</strong>
						</div>
						<div class="col col-sm-4">
							<strong>Actions</strong>
						</div>
					</div>

						<?php
						if ($this->product_details->get_color_sizes($color->st_id))
						{
							foreach ($this->product_details->get_color_sizes($color->st_id) as $size_label => $qty)
							{ ?>

					<div class="row margin-bottom-10">
						<div class="col col-sm-2">
							<?php echo $size_label; ?>
						</div>
						<div class="col col-sm-6">
							<?php
							$code_text = $this->product_details->prod_no.'-'.$color->color_code.'-'.$size_label.'-'.$color->st_id;
							$barcode_image_name = $this->product_details->prod_no.'_'.$color->color_code.'_'.$size_label.'_'.$color->st_id;
							$imageResource = Zend_Barcode::draw(
								'code128',
								'image',
								//$barcodeOptions,
								array('text' => $code_text, 'barHeight' => 50),
								//$rendererOptions
								array()
							);
							$store_image = imagepng($imageResource, "assets/barcodes/".$barcode_image_name.".png");
							?>
							<img src="<?php echo base_url(); ?>assets/barcodes/<?php echo $barcode_image_name; ?>.png" style="max-width:90%;" />
						</div>
						<div class="col col-sm-4">
							<a href="<?php echo site_url('admin/products/barcodes/print_barcode/'.$color->st_id); ?>?size_label=<?php echo $size_label; ?>" class="btn dark btn-outline btn-sm" target="_blank">Print Barcode</a>
						</div>
					</div>

								<?php
							}
						} ?>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

			<?php
		}
	}
	?>
</div>
