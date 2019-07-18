<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td>
	<div id="bodycontent">
	<h3>ACTIVATION</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border:0px solid #999;height:350px;">
			<tr><td>
				<br />
				Dear <?php echo @$name ?: 'Name'; ?>,
				<br />
				<br />
				<?php
				if ($view == 'request')
				{ ?>
					Your account is inactive at the moment.
					<br />
					<br />
					To request for activation, please click the button below.<br />
					You will either get an activation email, and/or, our staff will get back at you as soon possible.
					<br />
					<br />
					<?php
					echo form_open('wholesale/activation');
					echo form_hidden('email', $email);
					echo form_hidden('site_referrer', $site_referrer);
					echo form_hidden('status','inactive');
					?>
					<input class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" type="submit" value="Request to activate account!" name="submit" />
					<?php echo form_close();
				}
				else if ($view == 'suspended')
				{ ?>
					We are unable to log you in due to: "Invalid Email Address or Password".
					<br />
					<br />
					To reset your account, please complete the form below.<br />
					<br />
					<br />
					<?php
					echo form_open('wholesale/activation');
					echo form_hidden('email', $email);
					echo form_hidden('site_referrer', $site_referrer);
					echo form_hidden('status','suspended');
					?>
					NAME: <?php echo $name; ?><br />
					STORE NAME: <?php echo $store_name; ?><br />
					EMAIL: <?php echo $email; ?><br />
					<br />
					Name of your sales representative: &nbsp; <input type="text" value="" name="admin_sales_name" style="width:200px;" />
					<br />
					<br />
					Have you purchased from us before? <input type="radio" name="prev_buyer" value="Y" /> Yes &nbsp; <input type="radio" name="prev_buyer" value="N" /> No
					<br />
					<br />
					<input type="submit" value="Request to reset account!" name="submit" />
					<?php echo form_close();
				}
				else
				{ ?>
					Your request has been sent.
					<br />
					<br />
					Thank you very much.
					<?php
				} ?>
			</td></tr>
		</table>
	</p>	
	</div>
	</td>
</tr>
</table>
