<div class="row">

	<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
	<div class="admin_product_thumbs_sidebar col col-md-2">
		<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_list_sidebar', $this->data); ?>
	</div>
	<!-- END PRODUCT THUMGS SIDEBAR -->

	<!-- BEGIN PRODUCT THUMGS LIST -->
	<div class="col col-md-10">

		<!-- FORM =======================================================================-->
		<?php echo form_open(
			$this->config->slash_item('admin_folder').'products/bulk_actions',
			array(
				'class'=>'form-horizontal',
				'id'=>'form_product_list_bulk_actions'
			)
		); ?>

		<div class="table-toolbar">
			<div class="row">
				<div class="col-md-6 pull-right text-right">
                    <div class="btn-group">

						<a class="btn btn-link" style="color:black;text-decoration:none;cursor:default;" disabled>
							View as:
						</a>
                        <button type="button" class="btn blue btn-<?php echo $view_as == 'products_nestable_list' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_nestable_list" data-container="body" data-placement="top" data-original-title="List View" style="margin-right:3px;">
                            <i class="glyphicon glyphicon-list"></i>
                        </button>
                        <button type="button" class="btn blue btn-<?php echo $view_as == 'products_grid' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_grid" data-container="body" data-placement="top" data-original-title="Grid View">
                            <i class="glyphicon glyphicon-th"></i>
                        </button>

                    </div>
                </div>

				<div class="col-lg-3 col-md-4">
					<select class="bs-select form-control selectpicker" id="bulk_actions_select" name="bulk_action" disabled>
						<option value="" selected="selected">Bulk Actions</option>
						<option value="0">UnPublish</option>
						<option value="1">Publish Public</option>
						<option value="2">Publish Private</option>
						<option value="del">Permanently Delete</option>
					</select>
				</div>
				<button class="btn green hidden-sm hidden-xs apply_bulk_actions" id="apply_bulk_actions" disabled data-toggle="modal" href="#confirm_bulk_actions"> Apply </button>
			</div>
			<button class="btn green hidden-lg hidden-md apply_bulk_actions" id="apply_bulk_actions" disabled data-toggle="modal" href="#confirm_bulk_actions"> Apply </button>

		</div>

		<?php
        /***********
         * Top Pagination
         */
        ?>
        <?php if ( ! @$search) { ?>
        <div class="row margin-bottom-10">
            <div class="col-md-12 text-justify pull-right">
                <span style="<?php echo $count_all > 100 ? 'position:relative;top:15px;' : ''; ?>">
                    Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
                </span>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
        <?php } ?>

		<?php
		/*********
		 * This style a fix to nestable list item
		 */
		?>
		<style>
			.nl-thumb-tiles {
				position: relative;
				margin-right: 5px;
				/*margin-bottom: 5px;*/
				/*float: left;*/
			}
			.nl-thumb-tiles .thumb-tile {
				display: block;
				float: left;
					height: 60px; /*135px;*/
					width: 40px !important; /*90px !important;*/
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
				margin: 0 5px 0 0;
			}
			.nl-thumb-tiles .thumb-tile.image .tile-body {
				padding: 0 !important;
			}
			.nl-thumb-tiles .thumb-tile .tile-body {
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
			.nl-thumb-tiles .thumb-tile.image .tile-body > img {
					width: 100%;
					height: auto;
				min-height: 100%;
				max-width: 100%;
			}
			.nl-thumb-tiles .thumb-tile .tile-body img {
				margin-right: 10px;
			}
			.nl-thumb-tiles .thumb-tile .tile-object {
				position: absolute;
				bottom: 0;
				left: 0;
				right: 0;
					min-height: 20px;
				background-color: transparent;
			}
			.nl-thumb-tiles .thumb-tile .tile-object > .name {
				position: relative;
				bottom: 0;
				left: 0;
				margin: 0 auto;
				font-weight: 300;
					font-size: 10px;
				color: #fff;
			}
		</style>
		<style>
			.dd3-handle::before {
				line-height: 60px;
			}
			.dd-handle,
			.dd3-content {
				height: 70px;
			}
			.dd3-content.active {
				background: #ededed;
			}
			<?php if ($page_param == 'clearance_cs_only')
			{ ?>
			.dd3-handle {
				cursor: not-allowed;
			}
				<?php
			} ?>
		</style>
		<!-- Tasks -->
        <div class="dd nestable_list" data-count_all="<?php echo @$count_all; ?>" data-page="<?php echo @$page ?: '1'; ?>" style="margin-bottom:10px;">
            <ol class="dd-list">

				<?php
				if (@$products)
				{
					$i = @$page ? ($limit * $page) - ($limit - 1) : 1; // counter
					$unveil = FALSE;
					foreach ($products as $product)
					{
						// set image paths
						$pre_url =
							$this->config->item('PROD_IMG_URL')
							.'product_assets/WMANSAPREL/'
							.$product->d_url_structure.'/'
							.$product->sc_url_structure
						;
						$img_front_pre = $pre_url.'/product_front/thumbs/';
						$img_back_pre = $pre_url.'/product_back/thumbs/';
						$img_side_pre = $pre_url.'/product_side/thumbs/';
						// the image filename
						// the old ways dependent on category and folder structure
						$image = $product->prod_no.'_'.$product->primary_img_id.'_1.jpg';
						// the new way relating records with media library
						$new_pre_url = $this->config->item('PROD_IMG_URL').$product->media_path.$product->media_name;
						$img_front_new = $new_pre_url.'_f1.jpg';
						$img_back_new = $new_pre_url.'_b1.jpg';
						$img_side_new = $new_pre_url.'_s1.jpg';

						// edit link
						$edit_link = site_url('admin/products/edit/index/'.$product->prod_id)

						// after the first batch, hide the images through unveil
						//if (($i / 25) > 1) $unveil = TRUE;
						?>

				<li class="dd-item dd3-item" data-prod_id="<?php echo $product->prod_id; ?>" data-seque="<?php echo $product->seque; ?>">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content" style="color:black;">

						<!-- Checkbox -->
						<span style="vertical-align:top;">
							<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" style="padding-left:20px;">
								<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $product->prod_id; ?>" />
								<span style="background-color:white;"></span>
							</label>
						</span>
						<!-- Counter -->
						<span style="display:inline-block;vertical-align:top;width:40px;text-align:center;padding-right:5px;">
							<span class="t_no"><?php echo $i; ?></span>
							<br />
							<small>
								<a class="small tooltips modal-edit_seque" href="javascript:;" data-original-title="Manual Edit Sequence">
									<i class="fa fa-pencil" style="color:#ccc;"></i>
								</a>
							</small>
						</span>
						<!-- Status -->
						<span style="display:inline-block;vertical-align:top;margin-right:10px;">
							<?php
							switch ($product->publish)
							{
								case '1':
								case '11':
								case '12':
									$label = 'success';
									$label_text = 'Public';
									break;
								case '2':
									$label = 'info';
									$label_text = 'Private';
									break;
								case '3':
									$label = 'warning';
									$label_text = 'Pending';
									break;
								case '0':
								default:
									$label = 'danger';
									$label_text = 'Unpublished';
							}
							?>
							<span class="label label-sm label-<?php echo $label; ?>" style="display:block;"> <?php echo $label_text; ?> </span>

							<?php
							if ($product->view_status == 'Y' OR $product->publish == '1') { $checked1 = 'checked="checked"'; $checked2 = 'checked="checked"'; }
							elseif ($product->view_status == 'Y1' OR $product->publish == '11') { $checked1 = 'checked="checked"'; $checked2 = ''; }
							elseif ($product->view_status == 'Y2' OR $product->publish == '12') { $checked1 = ''; $checked2 = 'checked="checked"'; }
							else { $checked1 = ''; $checked2 = ''; }

							if ($product->public == 'Y' OR $product->publish == '1') { $checked3 = 'checked="checked"'; $checked4 = ''; }
							elseif ($product->public == 'N' OR $product->publish == '2') { $checked3 = ''; $checked4 = 'checked="checked"'; }
							?>
							<div>
								<div style="display:inline-block;">
									<input name="pub3<?php echo $product->prod_no; ?>" class="list_publish_button" id="public<?php echo $product->prod_no; ?>" type="radio" value="1" <?php echo $checked3; ?> data-action="publish" data-prod_id="<?php echo $product->prod_id; ?>" />Public
									<br />
									<input name="pub3<?php echo $product->prod_no; ?>" class="list_publish_button" id="public<?php echo $product->prod_no; ?>" type="radio" value="2" <?php echo $checked4; ?> data-action="private" data-prod_id="<?php echo $product->prod_id; ?>" />Private
								</div>
								<div style="display:inline-block;background-color:#E0E0E0;border-top:1px dashed gray;" <?php echo (($product->publish == '2' OR $product->view_status == 'Y') && $product->public == 'N') ? 'class="disabled-link disable-target"': ''; ?>>
									<input name="pub1<?php echo $product->prod_no; ?>" id="pub1<?php echo $product->prod_id; ?>" type="checkbox" value="1" <?php echo $checked1; ?> class="set_purblish_state"  data-prod_id="<?php echo $product->prod_id; ?>" onchange="setPublishState('<?php echo $product->prod_id?>');" />at Shop7
									<br />
									<input name="pub2<?php echo $product->prod_no; ?>" id="pub2<?php echo $product->prod_id; ?>" type="checkbox" value="2" <?php echo $checked2; ?> class="set_purblish_state"  data-prod_id="<?php echo $product->prod_id; ?>" onchange="setPublishState('<?php echo $product->prod_id?>');" />at Designer
								</div>
							</div>
						</span>
						<!-- Thumbs -->
						<span style="display:inline-block;">
							<?php
							/*********
							 * Original thumb tile with image hover commented out
							 */
							?>
							<div class="nl-thumb-tiles">
								<div class="thumb-tile image bg-blue-hoki">
									<a href="<?php echo $edit_link; ?>">
										<div class="tile-body">
											<!--
											<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
											-->
											<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
											<noscript>
												<!--
												<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
												-->
												<img class=" " src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
											</noscript>
										</div>
										<div class="tile-object">
											<div class="name"> <?php //echo $product->prod_no; ?>Front </div>
										</div>
									</a>
								</div>
								<div class="thumb-tile image bg-blue-hoki">
									<a href="<?php echo $edit_link; ?>">
										<div class="tile-body">
											<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"' : 'src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"'; ?> alt="">
										</div>
										<div class="tile-object">
											<div class="name"> <?php //echo $product->prod_no; ?>Side </div>
										</div>
									</a>
								</div>
								<div class="thumb-tile image bg-blue-hoki">
									<a href="<?php echo $edit_link; ?>">
										<div class="tile-body">
											<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
										</div>
										<div class="tile-object">
											<div class="name"> <?php //echo $product->prod_no; ?>Back </div>
										</div>
									</a>
								</div>
							</div>
						</span>
						<!-- Prod No -->
						<span style="display:inline-block;vertical-align:top;width:140px;">
							<cite class="small" style="color:#ccc;">Prod No</cite>
							<br />
							<a class="" href="<?php echo $edit_link; ?>">
								<?php echo $product->prod_no; ?>
							</a>
						</span>
						<!-- Designer -->
						<span style="display:inline-block;vertical-align:top;width:140px;">
							<cite class="small" style="color:#ccc;">Designer</cite>
							<br />
							<?php echo $product->designer; ?>
						</span>
						<!-- Vendor Code -->
						<span style="display:inline-block;vertical-align:top;">
							<cite class="small" style="color:#ccc;">Vendor</cite>
							<br />
							<?php echo $product->vendor_code; ?>
						</span>
						<!-- Actions -->
						<span style="display:inline-block;vertical-align:top;width:50px;float:right;">
							<cite class="small" style="color:#ccc;">Actions</cite>
							<br />
							<!-- Edit -->
                            <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
                                <i class="fa fa-pencil font-dark"></i>
                            </a>
							<!-- Delete -->
                            <a href="javascript:;" class="tooltips delete-item" data-original-title="Delete" data-prod_id="<?php echo $product->prod_id; ?>">
                                <i class="fa fa-trash font-dark"></i>
                            </a>

							<!-- UNPUBLISH -->
							<div class="modal fade bs-modal-sm" id="unpublish-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Update Product Info</h4>
										</div>
										<div class="modal-body"> Are you sure you want to UNPUBLISH item? </div>
										<div class="modal-footer">
											<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
											<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/0/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

							<!-- PUBLISH -->
							<div class="modal fade bs-modal-sm" id="publish-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Update Product Info</h4>
										</div>
										<div class="modal-body"> PUBLISH item? </div>
										<div class="modal-footer">
											<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
											<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/1/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

							<!-- PRIVATE -->
							<div class="modal fade bs-modal-sm" id="private-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Update Product Info</h4>
										</div>
										<div class="modal-body"> Set item to PRIVATE? </div>
										<div class="modal-footer">
											<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
											<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/2/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

							<!-- DELETE -->
							<div class="modal fade bs-modal-sm" id="delete-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Warning!</h4>
										</div>
										<div class="modal-body">
											DELETE item? <br /> This cannot be undone!
											<div class="note note-danger">
												<h4 class="block">Danger! </h4>
												<p> This action will delete the entire product item including its color variants. Please ensure you know what you are doing before proceeding. </p>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
											<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/delete/index/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

						</span>

					</div>
                </li>

						<?php
						$i++;
					}
				}
				else
				{ ?>

				<li class="dd-item dd3-item" data-id="0">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content text-center"> No records found </div>
                </li>

				<?php
				} ?>


				<!-- Sample original list html --
                <li class="dd-item dd3-item" data-id="13">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content"> Item 13 </div>
                </li>
                <li class="dd-item dd3-item" data-id="14">
                    <div class="dd-handle dd3-handle"> </div>
                    <div class="dd3-content"> Item 14 </div>
                </li>
                <!-- -->
            </ol>
        </div>

		<div style="padding-left:50px;margin-bottom:10px;">
			<i class="fa fa-level-up" style="transform:scaleX(-1);-ms-filter:fliph;filter:fliph;"></i>
			<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" style="padding-left:17px;">
				<input type="checkbox" id="nl-group-checkable" class="group-checkable" data-set=".nestable_list .checkboxes" />
				<span></span>
			</label>
			<cite>Check all</cite>
		</div>

		<?php
        /***********
         * Bottom Pagination
         */
        ?>
        <?php if ( ! @$search) { ?>
        <div class="row margin-bottom-10">
            <div class="col-md-12 text-justify pull-right">
                <span>
                    Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
                </span>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
        <?php } ?>

		</form>
		<!-- End FORM =======================================================================-->
		<!-- END FORM-->

	</div>
	<!-- END PRODUCT THUMGS LIST -->

	<!-- EDIT SEQUE -->
	<div class="modal fade bs-modal-sm" id="modal-edit_seque" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Update Product Info</h4>
				</div>

				<?php if ($page_param == 'clearance_cs_only')
				{ ?>

				<div class="modal-body">
					<div class="note note-info">
	                    <h3> Notice! </h3>
	                    <p> Sorting on this page is disabled. </p>
	                </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				</div>

					<?php
				}
				else
				{ ?>

				<!-- FORM =======================================================================-->
				<?php echo form_open(
					'admin/products/update_seque/nl_manual_seque',
					array(
						'class'=>'form-horizontal',
						'id'=>'form-manual_edit_seque'
					)
				); ?>

				<div class="modal-body">
					<div class="form-body">
						<input type="hidden" name="page_param" value="<?php echo $page_param; ?>" />
						<input type="hidden" name="active_category_id" value="<?php echo $active_category_id; ?>" />
						<input type="hidden" name="active_designer" value="<?php echo $active_designer; ?>" />
						<input type="hidden" name="cur_seque" value="" />
						<input type="hidden" name="prod_id" value="" />
						<div class="">
							<div class="form-group">
								<label class="control-label col-md-5">New Sequence:</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="seque" value="" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
					<button type="submit" class="btn dark">Submit</button>
				</div>

				</form>
				<!-- End FORM =======================================================================-->
				<!-- END FORM-->

					<?php
				} ?>

			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

</div>
