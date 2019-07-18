	<h2 style="color:red;">
		<?php
		if (@$this->input->post('linesheets_only') == 'Y') echo 'SEND LINESHEET';
		else echo 'SEND SALES PACKAGE';
		?>
	</h2>
	<br />
	
	<div data-section_name="select_user_input_boxes" style="position:relative;">

		<style>
		.new_user.field div {
			margin-bottom: 10px;
		}
		.new_user.field .input-text,
		.new_user.field .input-select {
			width: 80%;
		}
		.new_user.field .input-select {
			height: 22px;
		}
		.send_linesheet.submit {
			color: grey;
			width: 200px;
			text-align: center;
			cursor: pointer;
			height: 30px;
			background-color: #f0f0f0;
			border: 1px solid #a0a0a0;
		}
		.send_linesheet.submit:hover {
			background-color: #d9d9d9;
			color: red;
		}
		.input-error {
			color: red;
		}
		.input-error input {
			border: 1px solid red;
		}
		.help-block {
			display: block;
			font-style: italic;
			color: red;
		}
		</style>
		
		<?php
		/**********
		 * Notification area
		 */
		?>
		<?php if (validation_errors()) { ?>
		<div style="padding:10px 20px;background:pink;color:red;">
			There are errors in the form. Please try again.
			<?php echo validation_errors(); ?>
		</div>
		<?php } ?>
		<?php if ($this->session->flashdata('error') == 'add_new_user_error') { ?>
		<div style="padding:10px 20px;background:pink;color:red;">
			There was an error in the form. Please try again.
			Please note that options has been reset to default. Please review your summary &amp; options again where necessary.
			<?php echo $this->session->flashdata('validation-errors'); ?>
		</div>
		<?php } ?>
		<?php if ( ! $this->input->post()) { ?>
		<div style="padding:10px 20px;background:pink;color:red;">
			Some of the options has been reset to default. Click <a href="<?php echo site_url('sales/view_summary'); ?>">here to review your summary &amp; options</a> again where necessary.
			<?php echo $this->session->flashdata('validation-errors'); ?>
		</div>
		<?php } ?>
		
		<div style="width:373px;margin-bottom:5px;float:left;">
		
			<!-- Begin FORM ===================================================-->
			<?php echo form_open('sales/send_package/new_user'); ?>
			
			<input type="hidden" id="w_prices" name="w_prices" value="<?php echo $this->input->post('w_prices') ?: 'Y'; ?>" />
			<input type="hidden" id="w_images" name="w_images" value="<?php echo $this->input->post('w_images') ?: 'N'; ?>" />
			<input type="hidden" id="linesheets_only" name="linesheets_only" value="<?php echo $this->input->post('linesheets_only') ?: 'N'; ?>" />
			
			<input type="hidden" id="is_active" name="is_active" value="1" />
			<input type="hidden" id="reference_designer" name="reference_designer" value="<?php echo $this->sales_user_details->designer; ?>" />
			<input type="hidden" id="admin_sales_email" name="admin_sales_email" value="<?php echo $this->sales_user_details->email; ?>" />
			
			<h3 style="color:red;">SEND TO NEW USER</h3>
			<div class="new_user field" style="height:150px;overflow:auto;background:#fff;border:1px solid #c0c0c0;padding:10px 5px 5px 10px;">
				<div class="<?php echo form_error('email') ? 'input-error' : ''; ?>">
					<label class="primary page-text-body" for="vAccount-fields-email-1">
						<span class="pairing-label">Email Address</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="email" required="required" class="input-text" name="email" value="<?php echo set_value('email'); ?>" style=""/>
								<input type="hidden" class="input-password" name="pword" value="shopseven2018" />
								<?php echo form_error('email', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="  <?php echo form_error('store_name') ? 'input-error' : ''; ?>">
					<label class="primary page-text-body" for="vAccount-fields-store_name-1">
						<span class="pairing-label">Company / Store</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="store_name" value="" />
								<?php echo form_error('store_name', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div>
					<label class="primary page-text-body" for="vAccount-fields-fed_tax_id-1">
						<span class="pairing-label">Federal Tax ID</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" class="input-text" name="fed_tax_id" value="" />
								<?php echo form_error('fed_tax_id', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('firstname') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-firstname-1">
						<span class="pairing-label">First Name</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="firstname" value="" />
								<?php echo form_error('firstname', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('lastname') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-lastname-1">
						<span class="pairing-label">Last Name</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="lastname" value="" />
								<?php echo form_error('lastname', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('address1') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-address1-1">
						<span class="pairing-label">Address 1</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="address1" value="" />
								<?php echo form_error('address1', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div>
					<label class="primary page-text-body" for="vAccount-fields-address2-1">
						<span class="pairing-label">Address 2</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" class="input-text" name="address2" value="" />
								<?php echo form_error('address2', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('city') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-city-1">
						<span class="pairing-label">City</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="city" value="" />
								<?php echo form_error('city', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('country') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-country-1">
						<span class="pairing-label">Country</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<select required="required" class="input-select" name="country">
									<option value="">- Select Country -</option>
									<?php foreach (list_countries() as $country) { ?>
									<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('country', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('state') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-state-1">
						<span class="pairing-label">State/Province</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<select required="required" class="input-select" name="state">
									<option value="">- Select State -</option>
									<?php foreach (list_states() as $state) { ?>
									<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('state', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('zipcode') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-zipcode-1">
						<span class="pairing-label">Zip</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="zipcode" value="" />
								<?php echo form_error('zipcode', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div <?php echo form_error('telephone') ? 'input-error' : ''; ?>>
					<label class="primary page-text-body" for="vAccount-fields-telephone-1">
						<span class="pairing-label">Telephone</span>
						<span class="required">*</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" required="required" class="input-text" name="telephone" value="" />
								<?php echo form_error('telephone', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div>
					<label class="primary page-text-body" for="vAccount-fields-fax-1">
						<span class="pairing-label">Fax</span>
					</label>
					<div class="pairing-content">
						<div class="pairing-controls"> 
							<div class="field">
								<input type="text" class="input-text" name="fax" value="" />
								<?php echo form_error('fax', '<span class="help-block">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="margin:10px 0;text-align:right;">
				<input type="submit" class="send_linesheet submit" value="SEND LINESHEET PACKAGE" style="" />
			</div>
			
			</form>
			<!-- End FORM   ===================================================-->
			
		</div>
		<div style="width:373px;margin-bottom:5px;float:right;">
		
			<!-- Begin FORM ===================================================-->
			<?php echo form_open('sales/send_package/current_user'); ?>
			
			<input type="hidden" id="w_prices" name="w_prices" value="<?php echo $this->input->post('w_prices') ?: 'Y'; ?>" />
			<input type="hidden" id="w_images" name="w_images" value="<?php echo $this->input->post('w_images') ?: 'N'; ?>" />
			<input type="hidden" id="linesheets_only" name="linesheets_only" value="<?php echo $this->input->post('linesheets_only') ?: 'N'; ?>" />
			
			<h3 style="color:red;">SEND TO ONE OR MORE EXISTING STORE BUYERS</h3>
			<div class="field" style="height:150px;overflow:auto;background:#fff;border:1px solid #c0c0c0;padding:10px 5px 5px 10px;">
				<?php foreach ($wholesale_users as $user) { ?>

				<div style="position:relative;margin-bottom:5px;">
					<input type="checkbox" name="email[]" value="<?php echo $user->email; ?>" style="position:absolute;margin:0;"/>
					<div style="margin-left:25px;"><?php echo ucwords($user->store_name).' <small>('.$user->email.')</small> '; ?></div>
				</div>
				
				<?php } ?>
			</div>
			<div style="margin:10px 0;text-align:right;">
				<input type="submit" class="send_linesheet submit" value="SEND LINESHEET PACKAGE" style="" />
			</div>
			
			</form>
			<!-- End FORM   ===================================================-->
			
		</div>
		<br />
		<div style="clear:both;"></div>
	</div>
	
	<h2 style="color:red;">SELECTED ITEMS</h2>
	
	<div style="position:relative;">
	
		<?php
		echo $this->session->flashdata('flashMsg');
		?>
		
		<div id="summary_view_div" style="position:realtive;left:0;top:0;">
		
			<?php
			/***********
			 * Notifications
			 */
			?>
			<?php if ($this->session->flashdata('error') == 'edited_prices_updated') { ?>
			<div style="padding:10px 20px;background:pink;margin:10px 0 20px;color:red;">
				NOTE: Some or all of the prices has been edited. Click <a href="<?php echo site_url('sales/clear_prices'); ?>">here to CLEAR edited prices</a>.
			</div>
			<?php } elseif ( ! empty($this->sales_package_details->prices)) { ?>
			<div style="color:red;margin:10px 0 20px;font-size:1.1em;">
				NOTE: Some or all of the prices has been edited. Click <a href="<?php echo site_url('sales/clear_prices'); ?>">here to CLEAR edited prices</a>.
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success') == 'cleared_edited_prices') { ?>
			<div style="padding:10px 20px;background:#7cc576;margin:10px 0 20px;color:red;">
				Edited prices cleared. Now using default wholesale prices.
			</div>
			<?php } ?>
			
			<?php
			echo form_open('sales/update_prices');
			?>
			
			<?php
			/***********
			 * The THUMBS
			 */
			?>
			<?php
			//if ($this->cart->total_items() != 0)
			if ( 
				isset($this->sales_user_details->options['selected'])
				&& ! empty($this->sales_user_details->options['selected'])
			)
			{
				// --> smaller thumbs 2 columns multiple row view
				?>
				<div>
					<?php
					$ii = 1;
					$ii_thumb = 1;
					$btn_series = 0;
					//foreach ($this->cart->contents() as $items)
					foreach ($this->sales_user_details->options['selected'] as $product)
					{
						//echo form_hidden($ii.'[rowid]', $items['rowid']);
						
						// get product details
						$this->product_details->initialize(array('prod_no'=>$product));
						
						// let set the classes and other items...
						$classes2 = in_array($this->product_details->prod_no, $this->sales_user_details->options['selected']) ? 'selected ' : '';
						
						// set image paths
						$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
						$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
						$img_linesheet_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_linesheet/';
						// the image filename
						$large_image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'.jpg';
						$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
						
						if (fmod($ii_thumb, 2) == 1) $imarg = 'width:373px;margin-bottom:5px;float:left;';
						else $imarg = 'width:373px;margin-bottom:5px;float:right;';
						?>

						<div style="<?php echo $imarg; ?>">
						
							<?php
							/************
							 * THUMBNAIL and details
							 */
							?>
							
							<!-- THUMBNAIL Div -->
							<div  style="height:90px;position:relative;width:60px;margin-right:1px;float:left;">
								<div id="<?php echo $product;//$items['id']; ?>" class="fadehover">
								
									<!--placeholder for product images with fadehover effect-->
									<a class="sa_thumbs_group" href="<?php echo $img_linesheet_pre.$large_image; ?>" data-lightbox="lightbox-gallery">
										<img class="product-browse-s img-block img-b" src="<?php echo $img_back_pre.$image; ?>">
										<img class="product-browse-s img-block img-a" src="<?php echo $img_front_pre.$image; ?>" alt="<?php echo $this->product_details->prod_no; ?>">
									</a>
									
								</div>
							</div> <!-- End THUMBNAIL Div -->
							
							<!-- Details Div -->
							<div style="width:205px;height:85px;background-color:#dfdfdf;margin-right:1px;padding:5px 5px 0 5px;float:left;">
									<?php
									/*
									| -------------------------------------------------------------------------------------------
									| The Product No, Pricing, and Product Name
									*/
									?>
									<?php echo $product; ?>
									<br />
									<br />
									<?php echo $this->product_details->prod_name.' ('.$this->product_details->primary_color.')'; ?>
									<br />
									<br />
							</div> <!-- End Details Div -->
							
							<!-- Price Div -->
							<div id="price_div<?php echo $ii; ?>" style="width:53px;height:85px;background-color:#dfdfdf;margin-right:1px;padding:5px 5px 0 5px;float:left;">
							
								<?php
								if (
									$this->session->userdata('access_level') !== '1'
									&& $this->sales_user_details->access_level !== '1'
									&& $this->input->post('w_prices') == 'Y'
								) 
								{ ?>
								
								<div id="the_price_<?php echo $ii; ?>" class="the_price">
									<span style="float:left;">$</span>
									<span style="float:right;"><?php echo number_format((isset($this->sales_user_details->options['edited_prices'][$product]) ? $this->sales_user_details->options['edited_prices'][$product] : $this->product_details->wholesale_price), 2); ?></span>
								</div>
									
								<div id="edited_price_<?php echo $ii; ?>" class="edited_price">
									<input type="text" id="price_<?php echo $ii; ?>" name="<?php echo $product; ?>" value="<?php echo isset($this->sales_user_details->options['edited_prices'][$product]) ? $this->sales_user_details->options['edited_prices'][$product] : $this->product_details->wholesale_price; ?>" size="5" style="float:right;text-align:right;display:none;" />
								</div>
								
								<div id="the_price_disabled_<?php echo $ii; ?>" class="the_price_disabled" style="display:none;">
									<span style="position:relative;left:25px;">-</span>
								</div>
								
								<?php } else { ?>
								
								<div id="the_price_disabled_<?php echo $ii; ?>">
									<span style="position:relative;left:25px;">-</span>
								</div>
								
								<?php } ?>
								
							</div> <!-- End Price Div -->
							
							<!-- Selection Box Div -->
							<div style="height:88px;background-color:#dfdfdf;padding:2px 6px 0 5px;float:left;">
								<input type="checkbox" class="checkbox-prod_id <?php echo $classes2; ?>" name="prod_no[]" id="<?php echo $this->product_details->prod_id; ?>" value="<?php echo $this->product_details->prod_no; ?>" data-prod_no="<?php echo $product; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>" <?php echo in_array($product, $this->sales_user_details->options['selected']) ? 'checked' : ''; ?> style="margin-left:0px;" /> 

							</div> <!-- End Selection Box Div -->
							
						</div>
						
						<?php
						// set count for div id for javascript to work
						if (fmod($ii, 6) == 0)
						{
							$btn_series = $ii / 6;
							?>
						
							<!-- Series of Update Price Button -->
							<div id="upd_price_btnupd_price_btn_<?php echo $btn_series; ?>" class="upd_price_btn" style="padding:20px;clear:both;display:none;text-align:center;">
								<input type="submit" value="UPDATE PRICES" style="margin:0 auto;padding:5px 25px;" onclick="update_form()" />
							</div>
						
							<?php
						}
						
						// increase count and set thumb variable used for floating left or right
						if ($ii_thumb < 2) $ii_thumb++;
						else
						{
							$ii_thumb = 1;
						}
						$ii++;
					} ?>
		
					<div style="clear:both;"></div>
					
					<!-- LAST Update Price Button -->
					<?php $btn_series++; ?>
					<div id="upd_price_btn_<?php echo $btn_series; ?>" class="upd_price_btn" style="padding:20px;display:none;text-align:center;">
						<input type="submit" value="UPDATE PRICES" style="margin:0 auto;padding:5px 25px;" onclick="update_form()" />
					</div>
					
				</div>
				
				<?php
				echo '<div style="clear:both;">&nbsp;</div>';
			}
			else echo '<br />Please select items again.';
			
			echo form_close();
			?>
			<!--
			</form>
			eof form==================================================================================-->
		
		</div> <!-- #summary_view_div -->
		
	</div>

	<br /><br />

	<!-- Place this javascript function for the runway veiw mode -->
	<script type="text/javascript">

		$('.checkbox-prod_id').click(function(){
			$('#modal-loading .modal-title').html('Removing...');
			$('#modal-loading').show();
			$(this).removeClass('selected');
			$(this).attr('checked', false);
			$.ajax({
				type:    "POST",
				url:     "<?php echo site_url('sales/sales_selection_addrem'); ?>",
				data:    {
					"action":"rem_item",
					"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
					"prod_no":$(this).data('prod_no'),
					"prod_id":$(this).data('prod_id')
				},
				success: function(data) {
					//alert('call back');
					$('#modal-loading').show();
					window.location.href='<?php echo site_url('sales/view_summary/rem_item'); ?>';
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#modal-loading').show();
					window.location.href='<?php echo site_url('sales/view_summary'); ?>';
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
				}
			});
			$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
		});
		
	</script>
