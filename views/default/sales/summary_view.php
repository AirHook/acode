	<h3><?php echo strtoupper($page_title); ?></h3>
	<br />
	
	<ul class="view_tabs">
		<li class="selected" id="summary_view_tab">Summary View</li>
	</ul>

	<br /><br />
	
	<div style="position:relative;">
	
		<?php
		echo $this->session->flashdata('flashMsg');
		?>
		
		<div id="summary_view_div" style="position:realtive;left:0;top:0;">
			<div align="right" style="float:right;font-size:14px;">UNTICK CHECK BOX TO REMOVE AN ITEM</div>
			<div align="left" style="font-size: 14px;">CLICK ON IMAGE TO VIEW LINE SHEET</div>
			<br style="clear:both;" />
			
			<?php if ($this->sales_user_details->access_level == '2') { ?>
			
			<?php
			/***********
			 * Options box
			 */
			?>
			<div style="border:1px solid gray;padding:5px 10px 10px;<?php echo $this->session->userdata('access_level') !== '1' ? '' : 'display:none;'; ?>">
			
				<div style="float:left;">
					<span>OPTIONS:</span>
				</div>
				
				<div style="float:right;width:135px;">
					<span style="float:left;">TOTAL NO OF ITEMS:</span>
					<span style="float:right;"><?php echo (isset($this->sales_user_details->options['selected']) && count($this->sales_user_details->options['selected']) > 0) ? count($this->sales_user_details->options['selected']) : 0; ?></span>
				</div>
				
				<br style="clear:both;" /><br />
				
				<div class="options" style="">
					<span class="span-send_w_prices" style="position:relative;">
						<input type="radio" id="send_w_prices" class="send_w_prices" name="send_w_prices" value="Y" checked="checked" /> Yes 
						<input type="radio" id="no_send_w_prices" class="send_w_prices" name="send_w_prices" value="N" /> No 
						&nbsp; &nbsp; - Send with prices?
					</span>
					<br />
					<span id="span_e_prices">
						<input type="radio" id="yes_e_prices" class="edit_prices" name="send_e_prices" value="Y" /> Yes 
						<input type="radio" id="no_e_prices" class="edit_prices" name="send_e_prices" value="N" checked="checked" /> No &nbsp; &nbsp; - Edit prices?
					</span>
					<br />
					<span id="span_w_images" style="">
						<input type="radio" id="yes_w_images" class="attach_linesheets" name="send_w_images" value="Y" /> Yes 
						<input type="radio" id="no_w_images" class="attach_linesheets" name="send_w_images" value="N" checked="checked" /> No &nbsp; &nbsp; - Attach Linesheets
					</span>
					<br />
					<span id="span_linesheets_only" style="">
						<input type="radio" id="yes_linesheets_only" class="linesheets_only" name="attached_linesheets_only" value="Y" /> Yes 
						<input type="radio" id="no_linesheets_only" class="linesheets_only" name="attached_linesheets_only" value="N" checked="checked" /> No &nbsp; &nbsp; - Send Linesheets only
					</span>
					
				</div>
				
			</div>
			
			<?php
			/***********
			 * Notifications
			 */
			?>
			<?php if ($this->session->flashdata('error') == 'item_removed_from_view_send_package') { ?>
			<div style="padding:10px 20px;background:pink;margin-top:30px;color:red;">
				An item has been removed from your selection. Options are reset to default. Please review summary again.
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('error') == 'edited_prices_updated') { ?>
			<div style="padding:10px 20px;background:pink;margin-top:30px;color:red;">
				NOTE: Some or all of the prices has been edited. Click <a href="<?php echo site_url('sales/clear_prices'); ?>">here to CLEAR edited prices</a>.
			</div>
			<?php } elseif ( ! empty($this->sales_user_details->options['edited_prices'])) { ?>
			<div style="color:red;margin-top:30px;font-size:1.1em;">
				NOTE: Some or all of the prices has been edited. Click <a href="<?php echo site_url('sales/clear_prices'); ?>">here to CLEAR edited prices</a>.
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success') == 'cleared_edited_prices') { ?>
			<div style="padding:10px 20px;background:#7cc576;margin-top:30px;color:red;">
				Edited prices cleared. Now using default wholesale prices.
			</div>
			<?php } ?>
			
			<?php } ?>
			
			<?php
			echo form_open('sales/update_prices');
			?>
			
			<?php
			/***********
			 * The THUMBS 
			 * The Selection
			 */
			?>
			<?php
			if (
				isset($this->sales_user_details->options['selected']) 
				&& ! empty($this->sales_user_details->options['selected'])
			)
			{
				// --> smaller thumbs 2 columns multiple row view
				?>
				<br /><br />
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
								): 
								
									// set price to $0 again if record indicates $1 else use actual record
									//$price = $items['price'] == 1 ? number_format(0, 2) : number_format($items['price'], 2);
									echo '<div id="the_price_'.$ii.'" class="the_price"><span style="float:left;">$</span><span style="float:right;">'.number_format((isset($this->sales_user_details->options['edited_prices'][$product]) ? $this->sales_user_details->options['edited_prices'][$product] : $this->product_details->wholesale_price), 2).'</span></div>';
									?>
								<div id="edited_price_<?php echo $ii; ?>" class="edited_price">
									<input type="text" id="price_<?php echo $ii; ?>" name="<?php echo $product; ?>" value="<?php echo isset($this->sales_user_details->options['edited_prices'][$product]) ? $this->sales_user_details->options['edited_prices'][$product] : $this->product_details->wholesale_price; ?>" size="5" style="float:right;text-align:right;display:none;" />
								</div>
								
								<div id="the_price_disabled_<?php echo $ii; ?>" class="the_price_disabled" style="display:none;">
									<span style="position:relative;left:25px;">-</span>
								</div>
								
								<?php else: ?>
								
								<div id="the_price_disabled_<?php echo $ii; ?>">
									<span style="position:relative;left:25px;">-</span>
								</div>
								
								<?php endif; ?>
								
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

		$('.send_w_prices').click(function(){
			var check = $(this).val();
			if (check == 'Y'){
				$('.the_price').show();
				$('.edited_price').hide();
				$('.the_price_disabled').hide();
				$('#w_prices').val('Y');
			}else{
				$('.the_price').hide();
				$('.edited_price').hide();
				$('.the_price_disabled').show();
				$('#w_prices').val('N');
			}
		});
		$('.edit_prices').click(function(){
			var check = $(this).val();
			if (check == 'Y'){
				$('#send_w_prices').prop('checked', true);
				$('#no_send_w_prices').prop('checked', false);
				$('.send_w_prices').prop('disabled', true);
				$('.the_price').hide();
				$('.edited_price').show();
				$('.edited_price input').show();
				$('.the_price_disabled').hide();
				$('#w_prices').val('Y');
				$('#send_linesheet').hide();
				$('.upd_price_btn').show();
			}else{
				$('#send_w_prices').prop('checked', true);
				$('#no_send_w_prices').prop('checked', false);
				$('.send_w_prices').prop('disabled', false);
				$('.the_price').show();
				$('.edited_price').hide();
				$('.edited_price input').hide();
				$('.the_price_disabled').hide();
				$('#w_prices').val('Y');
				$('#send_linesheet').show();
				$('.upd_price_btn').hide();
			}
		});
		$('.attach_linesheets').click(function(){
			var check = $(this).val();
			if (check == 'Y'){
				$('#w_images').val('Y');
			}else{
				$('#w_images').val('N');
			}
		});
		$('.linesheets_only').click(function(){
			var check = $(this).val();
			if (check == 'Y'){
				$('#linesheets_only').val('Y');
			}else{
				$('#linesheets_only').val('N');
			}
		});
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
					$('.sales-pacakge-items, #sa_cart_sidebar_link').html('');
					$('.sales-pacakge-items, #sa_cart_sidebar_link').html(data);
					$('#modal-loading').hide();
					location.reload();
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#modal-loading').show();
					location.reload();
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
				}
			});
			$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
		});
		
	</script>
