<?php
if ($categories)
{
	$cnt = 1;
	foreach ($categories as $category)
	{
		if ($category->category_id !== '1')
		{
			$key = array_search($this->sales_user_details->designer, explode(',', $category->d_url_structure));
			$icon_images = explode(',', $category->icon_image);
			?>
			
			<?php
			/***********
			 * The thumb
			 */
			?>
			<div style="width:170px; margin:2px 5px 5px 15px; float:left; text-align:left;">
				<a href="<?php echo site_url('sales/select_items/index/'.$category->category_id); ?>">
					<img src="<?php echo $this->config->item('PROD_IMG_URL').'images/subcategory_icon/thumb/'.$icon_images[$key + 1]; ?>" style="width:100%;" />
				</a>
				<br /><strong><?php echo $category->category_name; ?></strong>
				<br /><br /><br />
			</div>
		
			<?php
			if (fmod($cnt, 4) == 0) echo '<div style="clear:both;"></div>';
			$cnt++;
		}
	}
	
	if ($this->sales_user_details->access_level == '2')
	{ ?>

			<div id="dashboard_icon_slect_recent" style="width:170px;margin:2px 5px 5px 15px;float:left;" data-sales_user_designer="<?php echo $this->sales_user_details->designer; ?>">
				<a href="javascript:;">
					<div style="width:120px;height:110px;background-color:red;color:white;padding:30px 25px;font-size:2em;">
						send last<br />
						30 items<br />
						loaded<br />
						to website<br />
					</div>
				</a>
				<br />&nbsp;
				<br /><br /><br />
			</div>

		<?php
	}
	
	echo '<div style="clear:both;">&nbsp;</div>';
}
else
{
	echo 'No category return.<br /><br />';
}

if ($file != 'page')
{
	echo form_close();
	echo '<!--eof form==================================================================================-->';
}

if (isset($this->sales_user_details->options['selected']) && ! empty($this->sales_user_details->options['selected']))
{
	$count = count($this->sales_user_details->options['selected']);
}
else $count = 0;
?>
	
<script type="text/javascript">
	$('#dashboard_icon_slect_recent').click(function(){
		if (<?php echo $count; ?> > 0){
			var r = confirm('This will load recent items to your selection.' + '\n' + 'Any previous selected items will be removed.' + '\n\n' + 'Continue?');
			if (r) window.location.href='<?php echo site_url('sales/select_items/recent'); ?>';
			else return false;
		}else{
			window.location.href='<?php echo site_url('sales/select_items/recent'); ?>';
		}
	});
</script>