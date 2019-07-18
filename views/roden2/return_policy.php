<?php
	$DB = $this->load->database('instyle', TRUE);
	$get_page_1 = $DB->get_where('pages', array('title_code'=>($this->uri->segment(1) === 'special_sale' ? 'special_sale_' : '').'return_policy'));
	$row1 = $get_page_1->row();
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:15px 0;">
<tr>
	<td>
	<div style="margin:0 20px;">
	<h3><?php echo strtoupper($row1->title); ?></h3>
	<p><?php echo $row1->text; ?></p>
	</div>
	</td>
</tr>
</table>
