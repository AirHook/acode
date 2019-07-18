<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Top tabs control
	*/
	$by_category = 2; // --> 2 means active
	if ($this->uri->segment(2) == 'product_linesheet_summary' OR $this->uri->segment(2) == 'send_product_linesheet' OR $this->uri->segment(2) == 'search_products')
		$seg_cat = $this->uri->segment(1).'/apparel';
	else if ($this->uri->segment(2) == 'clearance') $seg_cat = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
	else $seg_cat = $this->uri->segment(1).'/'.$this->uri->segment(2);
?>

<!--bof form==================================================================================-->
<?php echo form_open('sales/view_send_package'); ?>

<input type="hidden" id="w_prices" name="w_prices" value="Y" />
<input type="hidden" id="w_images" name="w_images" value="N" />
<input type="hidden" id="linesheets_only" name="linesheets_only" value="<?php echo $this->sales_user_details->access_level == '1' ? 'Y' : 'N'; ?>" />

<table border="0" cellspacing="0" cellpadding="0" width="100%">

	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar top tabs
	*/
	if ($this->uri->segment(1) != 'clearance')
	{ ?>
		<tr>
			<?php
			// -----------------------------------------
			// --> Browse by Category
			?>
			<td style="width: 70px;">
				<a href="<?php echo $seg_cat; ?>">
					<img src="<?php echo base_url('assets/default'); ?>/images/bu_cat1_2.gif" />
				</a>
			</td>
			<?php
			// -----------------------------------------
			// --> CART Summary
			?>
			<td colspan="2" align="center" style="background:#000;padding:10px 0 0;">
				<div id="sa_cart_sidebar_link">
				
					<?php
					if (
						isset($this->sales_user_details->options['selected']) 
						&& count($this->sales_user_details->options['selected']) > 0
					) {
					?>
					
					<a href="<?php echo site_url('sales/view_summary'); ?>" style="color:white;">
						<img src="<?php echo base_url('assets/default'); ?>/images/item_icon.gif" style="vertical-align:middle;" />
						<?php echo '&nbsp; ('.((isset($this->sales_user_details->options['selected']) && count($this->sales_user_details->options['selected']) > 0) ? count($this->sales_user_details->options['selected']) : 0).') view items'.(ENVIRONMENT === 'development' ? '_'.$this->sales_user_details->access_level : ''); ?>
					</a>
					
					<?php } else { ?>
					
					<img src="<?php echo base_url('assets/default'); ?>/images/item_icon.gif" style="vertical-align:middle;" />
					<?php echo '&nbsp; ('.((isset($this->sales_user_details->options['selected']) && count($this->sales_user_details->options['selected']) > 0) ? count($this->sales_user_details->options['selected']) : 0).') view items'.(ENVIRONMENT === 'development' ? '_'.$this->sales_user_details->access_level : ''); ?>
					
					<?php } ?>
					
				</div>
			</td>
		</tr>
		<?php
	}
	else
	{ ?>
		<tr>
			<td colspan="3" style="background:white;color:red;height:30px;">CLEARANCE CATEGORIES</td>
		</tr>
		<?php
	}
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar upper mid nav contents (form info)
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding:12px 12px 5px 12px;">
			<?php
			/***********
			 * User ingo
			 */
			?>
			<br />
			Logged in as: <?php echo $this->sales_user_details->fname ?: ucfirst($this->session->userdata('admin_sales_user')); ?>
			<br /><br />
			
			<?php
			/***********
			 * Steps Hints
			 */
			?>
			<?php if ($file == 'dashboard') { ?>
			<span class="notify"><b>STEP 1:<br />Select category...</b></span>
			<?php } ?>
			
			<?php if ($file == 'product_thumbs') { ?>
			<span class="notify"><b>STEP 1:</b><br />Select category<br /><b>Check box to select items,<br />Uncheck to deselect...</b></span>
			<?php } ?>
			
			<?php if ($file == 'summary_view') { ?>
			<span class="notify"><b>STEP <?php echo $this->sales_user_details->access_level !== '1' ? '2' : '1';?>:<br />View summary,<br />Check options...</b></span>
			<?php } ?>
			
			<?php if ($file == 'send_view') { ?>
			<span class="notify"><b>STEP <?php echo $this->sales_user_details->access_level !== '1' ? '3' : '2';?>:<br />Fill up form and<br />click on SEND...</b></span>
			<?php } ?>
			
			<?php if ($file == 'sent') { ?>
			<span class="notify"><b><br />Package or Linesheet<br />sending complete.</b></span>
			<?php } ?>
			
			<br /><br />
		</td>
	</tr>
	
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar mid nav contents where categories and subcats are displayed
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding: 5px 12px 30px 12px;">
		
			<?php $this->load->view('default/sales/sidebar_categories'); ?>
			
		</td>
	</tr>
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar bottom nav buttons
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding: 5px 12px 12px 12px;">
		
			<?php
			if ($file == 'product_thumbs')
			{ 
				if (
					isset($this->sales_user_details->options['selected']) 
					&& count($this->sales_user_details->options['selected']) > 0
				) $continue = '';
				else $continue = 'display:none;';
				?>
				
				<input id="sidebar_continue_button" type="button" class="search_head submit" value="CONTINUE >>" style="color:red;width:175px;text-align:center;cursor:pointer;<?php echo $continue; ?>" onclick="window.location='<?php echo site_url('sales/view_summary'); ?>';" />
				<br />
				<br />
				
				<?php if (isset($search_term)) { ?>
				
				<input type="button" class="search_head submit" value="ADD MORE ITEMS" style="width:175px;text-align:center;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sales/dashboard'); ?>';" />
				<br />
				<br />
				
					<?php
				}
			}
			elseif ($file == 'summary_view' OR $file == 'send_view')
			{
				if ($this->uri->segment(2) != 'sent' && $this->uri->segment(2) != 'clear_items')
				{
					if (
						($this->uri->segment(2) != 'send_product_linesheet' && $this->uri->segment(2) != 'send')
						&& $file == 'summary_view'
						&& (
							isset($this->sales_user_details->options['selected']) && 
							! empty($this->sales_user_details->options['selected'])
						)
					)
					{ ?>
						<input type="submit" class="search_head submit" id="send_linesheet" value="SEND LINESHEET PACKAGE" style="color:red;width:175px;text-align:center;cursor:pointer;" />
						<?php
						//onclick="window.location.href='<?php echo site_url('sa/send_product_linesheet'); ';" 
					} ?>
					<br />
					<br />
					<input type="button" class="search_head submit" value="ADD MORE ITEMS" style="width:175px;text-align:center;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sales/dashboard'); ?>';" />
					<br />
					<br />
					<input type="button" class="search_head submit" value="CLEAR ALL ITEMS" style="width:175px;text-align:center;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sales/clear_items'); ?>';" />
					<br />
					<br />
					<?php
				}
			} ?>
			
			<input type="button" class="search_head submit" name="logout" value="LOG OUT" style="color:red;width:175px;text-align:center;font-weight:bold;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sales/logout'); ?>';" />
		</td>
	</tr>
</table>

<?php
	echo form_close();
	echo '<!--eof form==================================================================================-->';
