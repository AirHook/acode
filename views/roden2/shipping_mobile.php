<?php
	$DB = $this->load->database('instyle', TRUE);
	$get_page_1 = $DB->get_where('pages', array('title_code'=>($this->uri->segment(1) === 'special_sale' ? 'special_sale_' : '').'shipping'));
	$row1 = $get_page_1->row();
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:15px 0;">
<tr>
	<td>
	<div style="margin:0 20px;">
	<h3><?php echo strtoupper($row1->title); ?></h3>
	<h5><a id="policy-toggle-switch" name="" style="cursor:pointer;" onclick="$('div#shipping-content').show();$(this).hide();">Read more...</a></h5>
	<div id="shipping-content" style="display:none;"><?php echo $row1->text; ?></div>
	</div>
	</td>
</tr>
</table>
