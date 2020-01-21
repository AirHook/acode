<ul class="page-breadcrumb breadcrumb ">

	<?php
	/**********
	 * Sales User My Account main page
	 */
	?>
	<li class="<?php echo $this->uri->uri_string() == 'my_account/sales/dashboard' ? 'active' : ''; ?>">
		<?php if ($this->uri->uri_string() == 'my_account/sales/dashboard') { ?>
			Dashboard
		<?php } else { ?>
			<a href="<?php echo site_url('my_account/sales/dashboard'); ?>">Dashboard</a>
			<i class="fa fa-circle"></i>
		<?php } ?>
	</li>

	<?php
	/**********
	 * Create breadcrumbs based on uri
	 */
	$uri_prefix = 'my_account/sales';
	$segments = $uri_prefix;
	$icnt = 1;
	foreach ($page_breadcrumb as $key => $val)
	{
		// if last segment of uri
		if ($icnt == count($page_breadcrumb))
		{
			echo '<li class="active"> '.$val.' </li>';
			continue;
		}

		// compound the segmented href
		$segments.= '/'.$key;

		echo '
			<li>
				<a href="'.site_url($segments).'">'.$val.'</a>
				<i class="fa fa-circle"></i>
			</li>
		';

		$icnt++;
	}
	?>
</ul>
