	<?php
	/***********
	 * Level 1 users has only 2 steps (Select Items and Send Linesheet)
	 * Level 2 users has 3 steps
	 */
	?>
	<div id="sa_steps_breadcrumb">
	
		<div class="sa_steps" id="step_1" style="background:<?php echo ($file == 'summary_view' OR $file == 'send_view' OR $file == 'sent') ? 'black' : '#d9d9d9'; ?>;">
			<span class="item_number">1.</span>
			<a href="<?php echo site_url('sales/dashboard'); ?>">
				<span class="item_text">Select Items</span>
			</a>
		</div>
		
		<?php if (
			$this->session->userdata('access_level') !== '1'
			&& $this->sales_user_details->access_level !== '1'
		) { ?>
		
			<?php
			if ($file == 'dashboard' OR $file == 'product_thumbs' OR $file == 'multi_search')
			{
				$step2_bg_color = 'none';
				if (
					isset($this->sales_user_details->options['selected']) 
					&& count($this->sales_user_details->options['selected']) > 0
				) $step2_process_class = '';
				else $step2_process_class = 'inactive';
			}
			elseif ($file == 'send_view' OR $file == 'sent')
			{
				$step2_bg_color = 'black';
				$step2_process_class = '';
			}
			else
			{
				$step2_bg_color = '#d9d9d9';
				$step2_process_class = '';
			}
			?>
		
		<div class="sa_steps <?php echo $step2_process_class; ?>" id="step_2" style="background:<?php echo $step2_bg_color; ?>;">
			<span class="item_number">2.</span>
			<?php if (
				isset($this->sales_user_details->options['selected']) 
				&& count($this->sales_user_details->options['selected']) > 0
			) {
				$step_2_active_link_display = '';
				$step_2_inactive_link_display = 'display:none';
			} 
			else
			{
				$step_2_active_link_display = 'display:none';
				$step_2_inactive_link_display = '';
			} ?>
			<a id="step_2_active_link" href="<?php echo site_url('sales/view_summary'); ?>" style="<?php echo $step_2_active_link_display; ?>">
				<span class="item_text">Summary &amp; Options</span>
			</a>
			<span id="step_2_inactive_link" class="item_text" style="<?php echo $step_2_inactive_link_display; ?>">Summary &amp; Options</span>
		</div>
		
		<?php } ?>
		
		<?php
		if (
			$file == 'send_view'
			OR (
				$file == 'summary_view'
				&& $this->sales_user_details->access_level === '1'
			)
		) 
		{
			$step_process_bg_color = '#d9d9d9';
			$step_process_class = '';
		}
		elseif ($file == 'sent') 
		{
			$step_process_bg_color = 'black';
			$step_process_class = '';
		}
		else
		{
			$step_process_bg_color = 'none';
			$step_process_class = 'inactive';
		}
		?>
		
		<div class="sa_steps <?php echo $step_process_class; ?>" id="step_3" style="background:<?php echo $step_process_bg_color; ?>;">
			<?php if ($this->session->userdata('access_level') !== '1' && $this->sales_user_details->access_level !== '1') { ?>
			<span class="item_number">3.</span>
				<span class="item_text">Send Package</span>
			<?php } else { ?>
			<span class="item_number">2.</span>
				<span class="item_text">Send Yourself Linesheets</span>
			<?php } ?>
		</div>
		
	</div>
