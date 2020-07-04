<?php
// let's set the role for sales user my account
if (@$role == 'sales') $logo_pre_link = 'my_account/sales';
elseif (@$role == 'vendor') $logo_pre_link = 'my_account/vendors';
else 'admin';
?>
<a href="<?php echo site_url($logo_pre_link.'/dashboard'); ?>">
	<?php if (@$this->webspace_details->options['logo_light'])
	{ ?>

	<img src="<?php echo $this->config->item('PROD_IMG_URL').$this->webspace_details->options['logo_light']; ?>" alt="logo" class="logo-default" style="height:25px;margin-top:25px;" />

		<?php
	}
	else if (@$this->webspace_details->options['site_type'] == 'sat_site')
	{
		$designer_details = $this->designer_details->initialize(
			array(
				'designer.url_structure'=>$this->webspace_details->slug
			)
		);
		?>

	<img src="<?php echo $this->config->item('PROD_IMG_URL').$this->designer_details->logo_light; ?>" alt="logo" style="height:25px;margin-top:25px;" class="logo-default" />

		<?php
	}
	else
	{ ?>

	<!--<img src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" />-->
	<img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>-light.png" alt="logo" style="height:25px;margin-top:25px;" class="logo-default" />

		<?php
	} ?>
</a>
