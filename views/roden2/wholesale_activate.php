<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td>
	<div id="bodycontent">
	<h3>ACTIVATION</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border:0px solid #999;height:450px;">
			<tr><td style="vertical-align:baseline;">
				<br />
				Dear <?php echo @$this->wholesale_user_details->fname 
					? $this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname 
					: 'Wholesale User'; ?>,
				<br />
				<br />
				<?php
				if (@$view == 'inactive')
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
					echo form_hidden('email', @$this->wholesale_user_details->email);
					echo form_hidden('site_referrer', @$site_referrer);
					echo form_hidden('status','inactive');
					?>
					<input class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" type="submit" value="Request to activate account!" name="submit" />
					<?php echo form_close();
				}
				elseif (@$view == 'suspended')
				{ ?>
					We are unable to log you in due to: "Invalid Email Address or Password".
					<br />
					<br />
					To reset your account, please complete the form below.<br />
					<br />
					<br />
					<?php
					echo form_open('wholesale/activation');
					echo form_hidden('email', @$this->wholesale_user_details->email);
					echo form_hidden('site_referrer', @$site_referrer);
					echo form_hidden('status','suspended');
					?>
					NAME: <?php echo @$this->wholesale_user_details->fname 
						? $this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname 
						: 'Wholesale User'; ?><br />
					STORE NAME: <?php echo @$this->wholesale_user_details->store_name ?: 'Store Name'; ?><br />
					EMAIL: <?php echo @$this->wholesale_user_details->email ?: 'Email'; ?><br />
					<br />
					Name of your sales representative: &nbsp; <input type="text" value="" name="admin_sales_name" style="width:200px;" />
					<br />
					<br />
					Have you purchased from us before? <input type="radio" name="prev_buyer" value="Y" /> Yes &nbsp; <input type="radio" name="prev_buyer" value="N" /> No
					<br />
					<br />
					<input class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" type="submit" value="Request to reset account!" name="submit" />
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
