<!--<table border="0" cellspacing="0" cellpadding="0" width="975" height="500" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php //$this->load->view($this->config->slash_item('template').'page_left_menu'); ?>
	</td>
	<td>
	-->
	<div id="bodycontent">
		<h3>NEWS &amp; UPCOMING EVENTS </h3>
		<p>
			<?php echo $this->config->item('site_name'); ?> is present in many global trade shows and fashion venues. See schedule below.
		</p>
		<hr />
		
		<?php if ($view_events->num_rows() > 0): ?>

			<table cellpadding="0" cellspacing="0" border="0">
				
				<?php foreach ($view_events->result() as $event): ?>

				<tr>
					<td style="padding:30px 0;">
						<?php echo nl2br(strip_tags($event->n_text)); ?><br />
					</td>
				</tr>
					
				<?php endforeach; ?>
					
			</table>
		
		<?php else: ?>

			<p style="text-transform:uppercase;font-size:1.15em;margin:50px 0;">
				There are currently no scheduled events for <?php echo $this->config->item('site_name'); ?>.
			</p>
			
		<?php endif; ?>

	</div>
	<!--
	</td>
</tr>
</table>-->