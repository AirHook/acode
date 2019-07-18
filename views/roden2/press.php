<!--
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php //$this->load->view('page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
-->
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p>
				<div align="left" style="font-size:14px;">CLICK ANY COVER TO VIEW ARTICLE</div>
				<br />
				<div align="left">
					For press inquiries, please email <a href="mailto:<?php echo $this->config->item('info_email'); ?>"><?php echo $this->config->item('info_email'); ?></a>.
				</div>
			</p>
			
			<div class="wl-grid">
			
			<?php
			$res = $this->db->query('SELECT * FROM tbl_press');
			
			if ($res->num_rows() > 0):
			
				foreach ($res->result_array() as $rows): ?>

					<div class="wl-grid col sm-col-6of12 col-3of12">
						<a class="press_group_1" href="<?php echo base_url(); ?>images/press/press_1/<?php echo $rows['img_1']?>" title="<?php echo $rows['title']?>">
							<img alt="<?php echo $rows['title']?>" src="<?php echo base_url(); ?>images/press/press_cover/thumb/<?php echo $rows['cover_img']?>" style="border:1px solid #666666;" />
						</a>
						<p><?php echo $rows['title']; ?></p>
					</div>
				
				<?php endforeach; ?>
				
			<?php endif; ?>
			
			</div>
			
<!--				
		</div>
	</td>
</tr>
</table>
-->