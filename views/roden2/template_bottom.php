			<?php
			/*****
			 * Using unminified site.js (from site-min.js) because of some script modifications
			 */
			?>
			<script src="<?php echo base_url(); ?>assets/themes/roden2/js/lib-min.js"></script>
			<script src="<?php echo base_url(); ?>assets/themes/roden2/js/site.js"></script>
				
			<script type="text/javascript" charset="utf-8">
				//<![CDATA[
					function toggleReadMore(num, closeText, openText){
						$('.readMore' + num).slideToggle(function(){
							 $('.toggleStory').text($(this).is(':visible') ? openText : closeText);
						});
					}
				//]]>
			</script>
			
			<?php if ($this->session->popup_ws_lapse_dialog) { ?>
			<script type="text/javascript" charset="utf-8">
			$( document ).ready(function() {
				$('#ws-lapse-dialog').show();
			});
			</script>
			<?php } ?>
			
			<?php
			/*****
			 * SSL Veri-seal
			 */
			?>
			<?php if ($this->webspace_details->slug === 'shop7thavenue') { ?>
			<div style="text-align:center;">
				<span id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=xvkh4xwEIsPAE7rVuxHgwIark5ps1VnHdD6kmPqo0Nk5DLrUI8KGhjAKdsh7"></script></span>
			</div>
			<?php } ?>
		
		</div>
		
		<a name="body-tag-bottom"></a>
        <ul class="sub-footer" style="padding: 10px 0;margin-top: 10px;">
            <li data-ipv4-name="<?php echo gethostbyname('www.'.$this->webspace_details->site); ?>">
				<span class=" "><?php echo @date('Y', @time()); ?> &copy; <?php echo $this->webspace_details->name; ?></span></li>
			<!--
            <li><a href="<?php echo str_replace('https', 'http', site_url()); ?>">Terms of Use</a></li>
            <li><a href="<?php echo str_replace('https', 'http', site_url('privacy_notice')); ?>">Privacy Policy</a></li>
			-->
        </ul>
		
		<?php 
		if (
			$this->session->user_loggedin 
			&& $this->session->user_cat == 'wholesale'
		)
			$this->load->view('chat/box'); 
		?>

    </body>
</html>

