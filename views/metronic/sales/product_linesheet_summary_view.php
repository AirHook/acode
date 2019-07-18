	<h3>SUMMARY VIEW</h3>
	<br />

	<div style="position:relative;">

		<?php
		echo $this->session->flashdata('flashMsg');
		// -----------------------------------------
		// --> SUMMARY VIEW
		?>
		<div id="summary_view_div" style="position:realtive;left:0;top:0;">
			<div align="right" style="float:right;font-size:14px;">UNTICK CHECK BOX TO REMOVE AN ITEM</div>
			<div align="left" style="font-size: 14px;">CLICK ON IMAGE TO VIEW LINE SHEET</div>
			<br style="clear:both;" />

			<?php
			// -----------------------------------------
			// --> Options box
			?>
			<div style="border:1px solid gray;padding:5px 10px 10px;<?php echo $this->session->userdata('access_level') !== '1' ? '' : 'display:none;'; ?>">

				<div style="float:left;">
					<span>OPTIONS:</span>
				</div>

				<div style="float:right;width:135px;">
					<span style="float:left;">TOTAL NO OF ITEMS:</span>
					<span class="items_count" style="float:right;"><?php echo $sa_items_count ?: '0'; ?></span>
				</div>

				<br style="clear:both;" /><br />

				<div data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

					<?php
					// let's process session sa_options if any
					$options_array =
						$this->session->sa_options
						? json_decode($this->session->sa_options, TRUE)
						: array()
					;
					$w_prices = @$options_array['w_prices'] ?: 'Y';
					$w_images = @$options_array['w_images'] ?: 'N';
					$linesheets_only = @$options_array['linesheets_only'] ?: 'N';
					?>

					<span>
						<input type="radio" class="sa_options" name="w_prices" value="Y" <?php echo $w_prices == 'Y' ? 'checked' : ''; ?> /> Yes
						<?php echo nbs(2); ?>
						<input type="radio" class="sa_options" name="w_prices" value="N" <?php echo $w_prices == 'N' ? 'checked' : ''; ?> /> No
						<?php echo nbs(3); ?> - Send with prices?
					</span>

					<br class="hide"/>

					<span id="span_e_prices" class="hide">
						<input type="radio" class="sa_options" name="e_prices" value="Y" /> Yes
						<?php echo nbs(2); ?>
						<input type="radio" class="sa_options" name="e_prices" value="N" checked="checked" /> No
						<?php echo nbs(3); ?> - Edit prices?
					</span>

					<br />

					<span id="span_w_images" class="tooltips" data-original-title="Currently unavailable" style="">
						<input type="radio" class="sa_options" name="w_images" value="Y" <?php echo $w_images == 'Y' ? 'checked' : ''; ?> disabled /> Yes
						<?php echo nbs(2); ?>
						<input type="radio" class="sa_options" name="w_images" value="N" <?php echo $w_images == 'N' ? 'checked' : ''; ?> disabled /> No
						<?php echo nbs(3); ?> - Attach Linesheets
					</span>

					<br />

					<span id="span_linesheets_only" class="tooltips" data-original-title="Currently unavailable" style="">
						<input type="radio" class="sa_options" name="linesheets_only" value="Y" <?php echo $linesheets_only == 'Y' ? 'checked' : ''; ?> disabled /> Yes
						<?php echo nbs(2); ?>
						<input type="radio" class="sa_options" name="linesheets_only" value="N" <?php echo $linesheets_only == 'N' ? 'checked' : ''; ?> disabled /> No
						<?php echo nbs(3); ?> - Send Linesheets only
					</span>

				</div>

			</div>

			<?php
			// -----------------------------------------
			// --> Thumbs Summary View
			$this->load->view('metronic/sales/cart_basket');
			?>

		</div> <!-- #summary_view_div -->

	</div>

	<br /><br />
