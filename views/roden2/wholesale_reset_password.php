<table border="0" cellspacing="0" cellpadding="0">
<tr><td>

	<div id="bodycontent">
	<h3>RECOVER PASSWORD</h3>
	<p>
				
		<?php
		if ($control == 'reset')
		{ ?>
		
			<!--bof form===========================================================================-->
			<?php echo form_open('wholesale/reset_password'); ?>
			<?php echo form_hidden('password', 'reset_password'); ?>
			<?php echo form_hidden('site_referrer', $this->config->item('site_domain')); ?>
		
			<br /><br />
			<strong>ENTER EMAIL ADDRESS</strong>
			<br /><br />
			Please enter your email address to retrieve <br/>your forgotten password. <!--You will receive a link to reset your password by email. --><br><br>
			If you do not receive your email please be sure<br/> to check your spam or junk folder or call <?php echo $this->config->item('site_phone'); ?> <br>
			
			<?php if ($this->session->flashdata('flashMsg')): ?>
			<div class="center" style="background:pink;padding:20px;">
				<?php echo $this->session->flashdata('flashMsg'); ?>
			</div>
			<?php endif; ?>

			<br />
			Email Address
			<input type="email" value="" placeholder="Enter your email here..." name="email"  id="user_id" maxlength="35" size="35"  style="height:26px;width:250px;font-size:12px;"/>
			<br /><br />
			<input type="submit" name="sub" value="Recover Password" class="bottonlook2" />
			
			<?php echo form_close(); ?>
			<!--eof form===========================================================================-->
			<?php
		}
		else
		{ ?>
		
			<strong>PASSWORD RECOVERED</strong>
			<br /><br />
			Your password has been sent to your email address. <br><br><br><br><br><br>
		
			<?php
		} ?>
		<br><br>
		
	</td></tr>
	</table>
	
</td></tr>
</table>

