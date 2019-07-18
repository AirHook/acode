<a href="#top" id="scroll-top" title="Back to Top"><i class="fa fa-angle-up"></i></a>
<!-- END -->

<!-- Smoothscroll -->
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/smoothscroll.js"></script>

<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.hoverIntent.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.nicescroll.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/waypoints.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/waypoints-sticky.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.debouncedresize.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/retina.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jflickrfeed.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/twitter/jquery.tweet.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/skrollr.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.countTo.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/wow.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/contact.js"></script>
<script src="<?php echo base_url('assets/themes/GI3'); ?>/js/main.js"></script>

<script>
    //declared array variables for the desktop and mobile images

    var desktop_images = ["<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/1.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/2.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/3.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/4.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/5.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/6.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/7.jpg"];
    var mobile_images = ["<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/topnarrow1.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/rcp3-vert1.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/topnarrow4.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/rcp3-vert2.jpg",
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/topnarrow3.jpg",
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/rcp3-vert3.jpg", 
        "<?php echo base_url('assets/themes/GI3'); ?>/images/_custom/slides/rcp3-vert4.jpg"];

    $(function () {
        "use strict";
        //here 

        //initilizing the slider
        var revapi = jQuery('#revslider').revolution({delay: 8000, startwidth: 1170, startheight: 500, fullWidth: "on", fullScreen: "on", hideTimerBar: "off", spinner: "spinner4", navigationStyle: "preview4", soloArrowLeftHOffset: 20, soloArrowRightHOffset: 20});
        
        //change next image during slider transition
        revapi.bind("revolution.slide.onbeforeswap", function (e) {
            efs(1);
        });
        //change next image during resize
        jQuery(window).resize(function () {
            efs(2);
        });

        function efs(type) {
            //get current active list (index)
            var current_index = revapi.revcurrentslide();
            
            //for resize
            if (type === 2)
            {   
                 
                if (jQuery(".dClass").css("float") === "none") {
                    for (var x = 0; x < desktop_images.length; x++) {

                        var newImage = mobile_images[x]; // url of new image
                        jQuery('#revslider').find('ul li:nth-child(' + (x + 1) + ') div.tp-bgimg', revapi)
                                .css('background-image', 'url("' + newImage + '")')
                                .attr('src', newImage)
                                .data('src', newImage);
                    }
                } else {

                    for (var x = 0; x < desktop_images.length; x++) {

                        var newImage = desktop_images[x]; // url of new image
                        jQuery('#revslider').find('ul li:nth-child(' + (x + 1) + ') div.tp-bgimg', revapi)
                                .css('background-image', 'url("' + newImage + '")')
                                .attr('src', newImage)
                                .data('src', newImage);
                    }
                }
            } else {

                if (jQuery(".dClass").css("float") === "none")
                    var newImage = mobile_images[current_index + 1]; // url of new image
                else
                    var newImage = desktop_images[current_index + 1]; // url of new image

                jQuery('#revslider').find('ul li:nth-child(' + (current_index + 2) + ') div.tp-bgimg', revapi)
                        .css('background-image', 'url("' + newImage + '")')
                        .attr('src', newImage)
                        .data('src', newImage);
            }
        }

    }());


</script>
<span class="dClass"></span>


</body>
</html>