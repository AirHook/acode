<?php
// -----------------------------------------
// --> Set check for items already in cart
foreach ($this->cart->contents() as $content):
	$checked[$content['id']] = 'checked="checked"';
endforeach;

/*
| -----------------------------------------------------------------------
| Added this breadcrumb and pagination at bottom for easier naviagtion
*/
?>
<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;margin-bottom:10px;">
<tr>
	<td style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*
	if ($view_pane_sql->num_rows() > 0)
	{
		echo generate_breadcrumb($view_pane_sql->row());
	}
	*/
	?>
	
	<?php
	/***********
	 * SEARCH - results notices
	 */
	if (isset($search_term))
	{
		if (is_string($search_term))
		{
			echo '<p style="color:black;">Search results for: &nbsp; '.$search_term.'</p>';
		}
		
		if (is_array($search_term))
		{
			echo '<p style="color:black;">Multiple search results:</p>';
		}
	}
	?>
	
	</td>
	<td style="text-align:right;">
	
		<?php echo ! isset($search_term) ? $this->pagination->create_links() : ''; ?>
		
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php //print_r($this->cart->contents()); // --> for debugging purposes ?>
	</td>
</tr>
</table>

<?php
if ($products_count > 0)
{
	/*
	| ---------------------------------------------------------------------------------
	| The counter $i_thumb is to differentiate tag id's for all thumbs
	| The counter $ii limits thumbs per row while being float=left determined at bottom of loop 
	| The counter $ii allows for possible uneven product name rows under each thumb and making
	| the next row aligned horizontally circumventing the float left css property.
	*/
	$ii = 1;
	$i_thumb = 1;
	/*
	| ---------------------------------------------------------------------------------
	| The $dont_display_thumb is style property used to set thumbs for unveil script
	| The $batch identifies the batch to unveil
	| The $unveil is a switch condition to set the element properties
	| The $cnti is a counter
	*/
	$dont_display_thumb = '';
	$batch = '';
	$unveil = FALSE;
	$cnti = 0;
	foreach ($products as $product)
	{
		if ($ii == 1) $px = 15;
		else $px = 40;
		
		// set image paths
		$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_front/thumbs/';
		$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_back/thumbs/';
		$img_linesheet_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_linesheet/';
		// the image filename
		$large_image = $product->prod_no.'_'.$product->primary_img_id.'.jpg';
		$image = $product->prod_no.'_'.$product->primary_img_id.'_3.jpg';
		
		// after the first batch of 100, hide the images
		if ($cnti > 0 && fmod($cnti, 100) == 0)
		{
			$dont_display_thumb = 'display:none;';
			$batch = 'batch-'.($cnti / 100);
			if (($cnti / 100) > 1) $unveil = TRUE;
		}
		
		// let set the classes and other items...
		$classes = $product->prod_no.'_'.$product->primary_img_id.' ';
		$classes.= $batch.' ';
		if (
			isset($this->sales_user_details->options['selected']) 
			&& ! empty($this->sales_user_details->options['selected'])
			&& in_array($product->prod_no, $this->sales_user_details->options['selected'])
		)
		{
			$classes2 = 'selected';
			$checked2 = 'checked';
		}
		else
		{
			$classes2 = '';
			$checked2 = '';
		}
		
		// let set the css style...
		$styles = $dont_display_thumb;
		$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';
		?>
		
		<div class="<?php echo $classes; ?>" style="width:228px;position:relative;float:left;margin:2px 0px 15px <?php echo $px;?>px;;<?php echo $styles; ?>">
		
			<a class="sa_thumbs_group" href="<?php echo $img_linesheet_pre.$large_image; ?>" data-lightbox="lightbox-gallery">
				<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.$img_back_pre.$image.'"' : 'src="'.$img_back_pre.$image.'"'; ?>>
				<img class="img-a img-unveil" <?php echo $unveil ? 'data-src="'.$img_front_pre.$image.'"' : 'src="'.$img_front_pre.$image.'"'; ?> alt="">
			</a>
			
			<div style="margin-top:345px;">
				<div>
					<input type="checkbox" class="checkbox-prod_id <?php echo $classes2; ?>" name="prod_id" id="<?php echo $product->prod_id; ?>" value="<?php echo $product->prod_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>" <?php echo $checked2; ?> style="margin-left:0px;" /> 
					<span style="position:relative;bottom:1px;color:red;">Add to Sales Package</span>
				</div>
				<div>
					<span style="float:right;">$ <?php echo number_format($product->wholesale_price, 2) ; ?></span>
					<span><?php echo $product->prod_no; ?></span>
				</div>
				<div>
					<?php echo $product->prod_name.'<br />('.$product->color_name.')'; ?>
				</div>
			</div>
			
		</div>
		
		<?php
		if ($ii < 3) $ii++;
		else
		{
			$ii = 1;
			echo '<div style="clear:both;">&nbsp;</div>';
		}
		$i_thumb++;
	}
	
	echo '<div style="clear:both;">&nbsp;</div>';
}
else
{
	echo 'No products return';
}

/*
| -----------------------------------------------------------------------
| Added this breadcrumb and pagination at bottom for easier naviagtion
*/
?>
<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;margin-bottom:10px;">
<tr>
	<td style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*
	if ($view_pane_sql->num_rows() > 0)
	{
		echo generate_breadcrumb($view_pane_sql->row());
	}
	*/
	?>
	
	<?php
	/***********
	 * SEARCH - results notices
	 */
	if (isset($search_term))
	{
		if (is_string($search_term))
		{
			echo '<p style="color:black;">Search results for: &nbsp; '.$search_term.'</p>';
		}
		
		if (is_array($search_term))
		{
			echo '<p style="color:black;">Multiple search results:</p>';
		}
	}
	?>
	
	</td>
	<td style="text-align:right;">
	
		<?php echo ! isset($search_term) ? $this->pagination->create_links() : ''; ?>
		
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php //print_r($this->cart->contents()); // --> for debugging purposes ?>
	</td>
</tr>
</table>

	<!-- Place this javascript function for the runway veiw mode -->
	<script type="text/javascript">

		<?php
		if (isset($this->sales_user_details->options['selected']) && ! empty($this->sales_user_details->options['selected']))
		{
			$count = count($this->sales_user_details->options['selected']);
		}
		else $count = 0;
		?>
		$('.checkbox-prod_id').click(function(){
			if (<?php echo $count; ?> < 30 || $(this).hasClass('selected'))
			{
				$(this).toggleClass('selected');
				// set checked attribute
				if ($(this).hasClass('selected')) $(this).attr('checked', true);
				else $(this).attr('checked', false);
				// load modal
				if ($(this).hasClass('selected')) $('#modal-loading .modal-title').html('Adding...');
				else $('#modal-loading .modal-title').html('Removing...');
				$('#modal-loading').show();
				// set action
				var action;
				if ($(this).hasClass('selected')){ 
					action = 'add_item';
					$('#step_2').removeClass('inactive');
						$('#step_2_active_link').show();
						$('#step_2_inactive_link').hide();
					$('#sidebar_continue_button').show();
				}else{
					action = 'rem_item';
					if ((<?php echo $count; ?> - 1) > 0) $('#step_2').removeClass('inactive');
					else{
						$('#step_2').addClass('inactive');
						$('#step_2_active_link').hide();
						$('#step_2_inactive_link').show();
						$('#sidebar_continue_button').hide();
					}
				}
				// ajax call
				$.ajax({
					type:    "POST",
					url:     "<?php echo site_url('sales/sales_selection_addrem'); ?>",
					data:    {
						"action":action,
						"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
						"prod_no":$(this).data('prod_no'),
						"prod_id":$(this).data('prod_id')
					},
					success: function(data) {
						//alert('call back');
						$('.temp_notice').hide();
						$('.sales-pacakge-items, #sa_cart_sidebar_link').html('');
						$('.sales-pacakge-items, #sa_cart_sidebar_link').html(data);
						$('#modal-loading').hide();
					},
					// vvv---- This is the new bit
					error:   function(jqXHR, textStatus, errorThrown) {
						$('#modal-loading').hide();
						//location.reload();
						alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					}
				});
			}else{
				alert('Maximum of 30 items only in a package.');
			}
		});
		
	</script>
