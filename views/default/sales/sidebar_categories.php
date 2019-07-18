<?php
if ($categories)
{
	foreach ($categories as $category)
	{ 
		if ($category->category_id !== '1') 
		{ ?>
		
			<div>
				<a href="<?php echo site_url('sales/select_items/index/'.$category->category_id); ?>" class="<?php echo $this->uri->uri_string() == 'sales/select_items/index/'.$category->category_id ? 'active' : ''; ?>">
					<?php echo $category->category_name; ?>
				</a>
			</div>
	
			<?php
		}
	}
}
else
{
	echo 'No category return.';
}

