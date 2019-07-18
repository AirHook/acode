<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr><td>

	<table style="border: 1px solid #aaa;" cellspacing="0" cellpadding="0" width="100%">
		<tr><td width="100%" class="top" style="background:#F0F0F0;">
			<br /><br />
			
			<table width="80%" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td style="padding-bottom: 10px;">
						<?php if ($this->session->flashdata('flashMsg')): ?>
						<div class="center notice" style="<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:#ffcccc;'; ?>padding:20px;">
							<?php echo $this->session->flashdata('flashMsg'); ?>
						</div>
						<?php endif; ?>
						<?php echo validation_errors() ? '<div class="errorMsg">'.validation_errors().'</div>' : ''; ?>
					</td>
				</tr>
				<tr>
					<td class="table_title" style="background: #000000; color: #FFFFFF; font-size:24px; padding:5px 5px 5px 10px;"> <span style="font-family:'Arial Narrow';font-weight:normal;">SIGN IN</span></td>
				</tr>
				<tr>
					<td valign="middle">
					
						<!--
						| Sign in
						-->
						<!--bof form===========================================================================-->
						<?php echo form_open('resource'); ?>
						
						<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
							<tr>
								<td colspan="3" style="font-size:16px;font-weight:bold; padding-left:10px;">
									<strong>REGISTERED ADMIN SALES</strong>
								</td>
							</tr>
							<tr>
								<td colspan="3" style="padding-left:10px;">
									<br />
								</td>
							</tr>
							<tr>
								<td width="22%" style="padding-left:10px;">Enter your email </td>
								<td width="60%"><input type="text" value="<?php echo set_value('field name'); ?>" name="username"  id="user_id" maxlength="35" size="35"  style="height:18px; width:250px; font-size:9px;" /></td>
								<td width="18%">&nbsp;</td>
							</tr>
							<tr>
								<td style="padding-left:10px;">Enter your password </td>
								<td><input type="password" name="password" id="user_pwd" maxlength="35" size="35" value="" style="height:18px; width:250px;" /></td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" name="sub" value="" class="bottonlook2" style="width:148px;height:23px;background:url(<?php echo base_url('assets/default/'); ?>images/signinnow.gif) no-repeat; border:0px; cursor:pointer;"/>
									&nbsp; &nbsp; &nbsp;
									<input type="button" name="forge_password" value="" class="bottonlook2" style="width:148px;height:23px;background:url(<?php echo base_url('assets/default/'); ?>images/forgotpassword.gif) no-repeat; border:0px; cursor:pointer;"/>
								</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3" style="font-size:1px;">&nbsp;</td>
							</tr>
						</table>
						
						<?php echo form_close(); ?>
						<!--eof form===========================================================================-->
					   
					</td>
				</tr>
				
				<tr>
					<td valign="middle" style="display:none;">
					
						<!--
						| Forget Password
						-->
						<!--bof form===========================================================================-->
						<?php echo form_open('resource/forget_password'); ?>
						
						<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
							<tr>
								<td colspan="3" style="font-size:16px;font-weight:bold; padding-left:10px;">
									<strong>REGISTERED ADMIN SALES</strong>
								</td>
							</tr>
							<tr>
								<td colspan="3" style="padding-left:10px;">
									<br />
								</td>
							</tr>
							<tr>
								<td width="22%" style="padding-left:10px;">Enter your email </td>
								<td width="60%"><input type="text" value="<?php echo set_value('field name'); ?>" name="username"  id="user_id" maxlength="35" size="35"  style="height:18px; width:250px; font-size:9px;" /></td>
								<td width="18%">&nbsp;</td>
							</tr>
							<tr>
								<td style="padding-left:10px;">Enter your password </td>
								<td><input type="password" name="password" id="user_pwd" maxlength="35" size="35" value="" style="height:18px; width:250px;" /></td>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" name="sub" value="" class="bottonlook2" style="width:148px;height:23px;background:url(<?php echo base_url('assets/default/'); ?>images/signinnow.gif) no-repeat; border:0px; cursor:pointer;"/>
									&nbsp; &nbsp; &nbsp;
									<input type="button" name="forge_password" value="" class="bottonlook2" style="width:148px;height:23px;background:url(<?php echo base_url('assets/default/'); ?>images/forgotpassword.gif) no-repeat; border:0px; cursor:pointer;"/>
								</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3" style="font-size:1px;">&nbsp;</td>
							</tr>
						</table>
						
						<?php echo form_close(); ?>
						<!--eof form===========================================================================-->
					   
					</td>
				</tr>
			</table>
		  
			<br /><br />
		</td></tr>
	</table>
 
</td></tr>
</table>
