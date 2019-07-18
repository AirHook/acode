	<h2 style="color:red;"><?php echo strtoupper($page_title); ?></h2>
	<br />
	<br />
	<br />
	<div align="left" style="font-size:14px;color:red;"><u>SALES PACKAGE OR PRODUCT LINE SHEET SENT</u></div>
	<br />
	<br />
	Please select items again.
	<br />
	<input type="button" class="search_head submit" value="SELECT NEW ITEMS" style="width:175px;text-align:center;" onclick="window.location.href='<?php echo site_url('sales/dashboard'); ?>';" />
	<?php
	if ($this->session->userdata('admin_super_sales'))
	{ ?>
		<br />
		<input type="button" class="search_head submit" name="select_another_designer" value="SELECT ANOTHER DESIGNER" style="width:175px;text-align:center;cursor:pointer;margin-top:3px;" onclick="window.location.href='<?php echo site_url('sa'); ?>';" />
		<?php
	}
