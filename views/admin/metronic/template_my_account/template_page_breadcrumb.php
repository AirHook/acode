<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo site_url($this->config->slash_item('admin_folder').'dashboard'); ?>">Home</a>
		<i class="fa fa-circle"></i>
	</li>

	<?php
	/**********
	 * Create breadcrumbs based on uri
	 */
	$admin_prefix = 'admin';
	$uri_segments = explode('/', $this->uri->uri_string());
	$cnt = count($uri_segments) - 1;
	$segments = $admin_prefix;
	$icnt = 1;
	foreach ($uri_segments as $key => $val)
	{
		// disregard first segment (admin)
		if ($key < $icnt) continue;

		// if last segment of uri
		if ($icnt == $cnt)
		{
			echo '<li class="active"> '.ucwords(str_replace('_', ' ', $val)).' </li>';
			continue;
		}

		// set the segmented href
		$segments .= '/'.$val;

		// 4th segment onwards are parameter passed on to function
		if ($icnt >= 3)
		{
			for ($icnti = $icnt; $icnti < $cnt; $icnti++)
			{
				$segments .= '/'.$uri_segments[$icnti + 1];
			}

			// if 3rd segement is 'edit', then 5th segment is always the id param
				echo '
					<li>
						<a href="'.site_url($segments).'" data-test="true">'.ucwords(str_replace('_', ' ', $val)).'</a>
						<i class="fa fa-circle"></i>
					</li>
				';
		}
		else
		{
			// otherwise, lets create the linked breadcrumb
			// NOTE: need to type with the line breaks for the correct spacing to occur

			// if 3rd segement is 'edit', then 5th segment is always the id param
			if ($val == 'edit')
			{
				echo '
					<li>
						<a href="'.site_url($segments.'/index/'.$uri_segments[$icnt + 2]).'">'.ucwords(str_replace('_', ' ', $val)).'</a>
						<i class="fa fa-circle"></i>
					</li>
				';
			}
			else
			{
				echo '
					<li>
						<a href="'.site_url($segments).'">'.ucwords(str_replace('_', ' ', $val)).'</a>
						<i class="fa fa-circle"></i>
					</li>
				';
			}
		}

		$icnt++;
	}
	?>
</ul>