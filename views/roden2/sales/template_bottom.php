			<?php
			/*****
			 * Using unminified site.js (from site-min.js) because of some script modifications
			 *
			 * Hiding the lib-min.js as of 20170122 so that autocomplete on search top bar would work
			 * Search autocomplete script using jquery ui
			<script src="<?php echo base_url(); ?>assets/themes/roden2/js/lib-min.js"></script>
			 */
			?>
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
		
		</div>
		
		<a name="body-tag-bottom"></a>
        <ul class="sub-footer" style="padding: 10px 0;margin-top: 10px;">
            <li><span class=" "><?php echo @date('Y', time()); ?> &copy; <?php echo $this->webspace_details->name; ?></span></li>
			<!--
            <li><a href="<?php echo str_replace('https', 'http', site_url()); ?>">Terms of Use</a></li>
            <li><a href="<?php echo str_replace('https', 'http', site_url('privacy_notice')); ?>">Privacy Policy</a></li>
			-->
        </ul>

		<?php
		/*
		| -------------------------------------------------
		| ---> Loader GIF image
		| used on as need basis
		| for example: go_spin();
		*/
		?>
		<div style="display:none" id="div_loader"></div>
		<div style="display:none" id="img_loader">
			<span>
				<img src="<?php echo base_url(); ?>images/loadingAnimation.gif" />
				<p>Processing request...</p>
			</span>
		</div>

    </body>
</html>

