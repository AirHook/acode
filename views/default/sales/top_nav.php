<div id="header_wrapper">
	<div id="header">
	
		<div style="float:right;margin-top:5px;">
				<!--bof form==========================================================================-->
				<form action="<?php echo site_url('sales/search_products'); ?>" method="POST" style="float:right;">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				
				<input type="text" name="style_no" id="search_by_style" class="search_by_prod_no" value="" style="width:102px;font-size:12px;background:white;" />
				
				<input type="image" src="<?php echo base_url('assets/default'); ?>/images/icon_go.jpg" alt="Go Icon" name="submit_search" value="SEARCH" height="23" style="position:relative;top:7px;" />
				</form>
				<!--eof form==========================================================================-->
		</div>
		
		<div style="float:right;padding:14px 5px 0 0;font-stretch:ultra-condensed;">
			SEARCH BY STYLE NUMBER
		</div>
	
		<div style="float:right;padding:14px 38px 0 0;font-stretch:ultra-condensed;">
			<a href="<?php echo site_url('sales/multi_search'); ?>" id="sa_searchmulti" style="color:white;">SEARCH MULTIPLE ITEMS</a>
		</div>
	
		<div style="color:white;font-size:24px;padding-top:8px;font-weight:normal;font-stretch:ultra-condensed;">
			SEND IMAGES AND PRICES TO CUSTOMERS
		</div>
		
	</div> <!--eof header-->
</div> <!--eof header_wrapper-->
