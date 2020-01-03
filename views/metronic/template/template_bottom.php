        <!--[if lt IE 9]>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
		<!-- BEGIN GLOBAL PLUGINS -->
		<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/custom/js/metronic/pages/scripts/components-search_typeahead.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/custom/js/metronic/pages/scripts/custom-global.js" type="text/javascript"></script>
        <!-- END GLOBAL PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<?php echo @$page_level_plugins ?: ''; ?>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>/assets/custom/jscript/unslider/unslider-min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
		<?php echo @$page_level_scripts ?: ''; ?>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout3/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function(){
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
				// image hover effect
				$(".img-a, .browse_thumbs .alt-image").hover(
					function() {
						$(this).stop().animate({"opacity": "0"}, "slow");
					},
					function() {
						$(this).stop().animate({"opacity": "1"}, "slow");
					}
				);
				// product thumbs unveil trigger
				$('.browse_thumbs .primary-img, .browse_thumbs .alt-image').unveil(1500);
				// thumbs sidebar nav expand/collapse click function
				$('body').on('click', '.nested-nav > li > .collapse, .nested-nav > li > .expand, .nested-nav > li > .category-list-heading-collapse, .nested-nav > li > .category-list-heading-expand', function(e) {
					e.preventDefault();
					// find children list
					var el = $(this).closest("li").children("ul");
					if ($(this).hasClass("collapse")||$(this).hasClass("category-list-heading-collapse")) {
						if($(this).hasClass("collapse")){
                            $(this).removeClass("collapse").addClass("expand");
                            $(this).siblings('a').removeClass("category-list-heading-collapse").addClass("category-list-heading-expand");
                        }
                        if($(this).hasClass("category-list-heading-collapse")){
                            $(this).removeClass("category-list-heading-collapse").addClass("category-list-heading-expand");
                            $(this).siblings('a').removeClass("collapse").addClass("expand");
                        }
						el.slideUp(200);
					} else {
						if($(this).hasClass("expand")){
                            $(this).removeClass("expand").addClass("collapse");
                            $(this).siblings('a').removeClass("category-list-heading-expand").addClass("category-list-heading-collapse");
                        }
                        if($(this).hasClass("category-list-heading-expand")){
                            $(this).removeClass("category-list-heading-expand").addClass("category-list-heading-collapse");
                            $(this).siblings('a').removeClass("expand").addClass("collapse");
                        }
						el.slideDown(200);
					}
				});
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
			 * This click event listener is a fix for dropdown menus to show on overflow
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
			 * Just add class "auto-remove"
			 * Set the delay here
			 */
			?>
			window.setTimeout(function() {
				$(".auto-remove").fadeTo(500, 0).slideUp(500, function(){
					$(this).hide();
				});
			}, 11000);
			$(window).on('load',function(){
                // run logo slider
                var sliderOne = $(".logo_slider").unslider({
					animation: "fade",
					autoplay: true,
					nav: false,
					arrows: false
				});
				$(".logo_slider").fadeIn(1000);
				<?php
				/*********
				 * Launch different modals on page load
				 */
				if ($this->uri->uri_string() == $this->config->slash_item('admin_folder').'products/add') { ?>
					$('#modal_add_product').modal('show');
				<?php } ?>
				<?php if ($this->uri->uri_string() == $this->config->slash_item('admin_folder').'campaigns/sales_package/create') { ?>
					$('#modal_create_sales_package').modal('show');
				<?php } ?>
				<?php if ($this->uri->uri_string() == $this->config->slash_item('admin_folder').'designers/add_') { ?>
					$('#modal-add_designer').modal('show');
				<?php } ?>
				<?php if ($this->session->flashdata('select_theme_after_add_webspace')) { ?>
					$('#select_theme_after_add_webspace').modal('show');
				<?php } ?>
				<?php if (@$show_loading) { ?>
					$('#loading-start').hide();
				<?php } ?>
			});
        </script>

		<div class="hide margin-top-30 margin-bottom-30">
			<?php
			/*********
			 * Developer information
			 *
			echo 'Webspace Slug - '.$this->webspace_details->slug;
			echo '<br />Options - ';
			print_r($this->webspace_details->options);
			// */
			?>
		</div>
