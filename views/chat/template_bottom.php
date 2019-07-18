        <!--[if lt IE 9]>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/excanvas.min.js"></script> 
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->

        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<?php echo @$page_level_plugins ?: ''; ?>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
		<?php echo @$page_level_scripts ?: ''; ?>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
		
		<?php
		/*********
		 * The chatboard script somehow stopped working because of some script 
		 * preventing it from working properly. Placing the script here
		 * enables it again
		 */
		?>
		<?php $this->load->view('chat/chatboard_script', $this->data); ?>
		
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
				// image hover effect
				$(".img-a").hover(
					function() {
						$(this).stop().animate({"opacity": "0"}, "slow");
					},
					function() {
						$(this).stop().animate({"opacity": "1"}, "slow");
					}
				);
				$('.thumb-tiles').on({
					mouseenter: function() {
						$(this).stop().animate({"opacity": "0"}, "slow");
					},
					mouseleave: function() {
						$(this).stop().animate({"opacity": "1"}, "slow");
					}
				}, '.thumb-tile .img-a');
            });
			<?php
			/*********
			 * Prevent browser from caching select options
			 */
			?>
			$(window).unload(function() {
				//$('select option').remove();
				$('select option').prop('selected', function(){ return this.defaultSelected});
			});
			<?php
			/*********
			 * This click event listener is a fix to dropdown menus to show on overflow
			 * while following datatable responsiveness relative position to cell.
			 */
			?>
			$(document).click(function(e) { 
				if(!$(e.target).closest('.dropdown-toggle').length) {
					$('.dropdown-wrap').addClass('dropdown-fix');
				}        
			})
			<?php
			/*********
			 * An auto remove script for those notices, growls, etc...
			 */
			?>
			window.setTimeout(function() {
				$(".auto-remove").fadeTo(500, 0).slideUp(500, function(){
					$(this).hide(); 
				});
			}, 7000);
			<?php 
			/*********
			 * Launch different modals on page load
			 */
			?>
        </script>
		
