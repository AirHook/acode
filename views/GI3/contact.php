<div id="content" role="main">
    <div class="page-header dark larger larger-desc" style="margin-bottom:0px;">
        <div class="container" data-0="opacity:1;" data-top="opacity:0;">
            <div class="row">
                <div class="col-md-6">
                    <h1>Contact Us</h1>
                    <p class="page-header-desc">Hello! Use the form below to get in touch with us.</p>
                </div><!-- End .col-md-6 -->
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Contact Us</li>
                    </ol>
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div id="map" class="larger"></div><!-- End #map -->

    <div class="container form-box-container">
        <div class="form-box" style="top: -700px;"><!-- Add "dark" class to make formbox dark -->
            <h2 class="title-underblock custom mb30">Get In Touch</h2>
            <form action="php/mail.php" method="post" id="contact-form">
                <div class="form-group">
                    <label for="contactname" class="input-desc">Name</label>
                    <input type="text" class="form-control" id="contactname" name="contactname" placeholder="Your Name" required>
                </div><!-- End .from-group -->
                <div class="form-group">
                    <label for="contactemail" class="input-desc">Email</label>
                    <input type="email" class="form-control" id="contactemail" name="contactemail" placeholder="Your Email" required>
                </div><!-- End .from-group -->
                <div class="form-group">
                    <label for="contacttel" class="input-desc">Telephone</label>
                    <input type="text" class="form-control" id="contacttel" name="contacttel" placeholder="Your Telephone" required>
                </div><!-- End .from-group -->
                <div class="form-group">
                    <label for="contactsubject" class="input-desc">Subject</label>
                    <input type="text" class="form-control" id="contactsubject" name="contactsubject" placeholder="Subject">
                </div><!-- End .from-group -->
                <div class="form-group">
                    <label for="contactmessage" class="input-desc">Message</label>
                    <textarea class="form-control" rows="6" id="contactmessage" name="contactmessage" placeholder="Your Message" required></textarea>
                </div><!-- End .from-group -->

                <div class="mb10"></div><!-- space -->

                <div class="form-group">
                    <input type="submit" class="btn btn-custom btn-block" data-loading-text="Sending..." value="Send Message">
                </div><!-- End .from-group -->
            </form>
        </div><!-- End .form-box -->
    </div><!-- End .container -->

    <div class="container">
        <div class="row">

            <div class="col-md-8 contact-text">
                <h2 class="title-underblock dark mb30">Why should I contact RCPIXEL.COM?</h2>
                <p>Companies in todays competitive environment are hard pressed to cover all angles of the marketing and sales spectrum with regard to their product or services on the Internet.</p>
                <p>For the last 25 years the principles at RCPIXEL have conducted deep targeted research on how consumers, wholesale buyers and internal company sales teams interact with the Internet tools to complete day to day tasks in their respective industries.</p>
                <p>We service these businesses by learning their sales process and identifying the changes we can recommend to help them achieve their sales objectives.</p>
                <p>We then program front end websites to bring these ideas into action and help achieve sales objectives in a cost effective manner.</p>
            </div><!-- End .col-md-8 -->

            <div class="mb20 visible-sm visible-xs"></div><!-- space -->

            <div class="col-md-4">
                <h3 class="mb20">Address</h3>
                <ul class="contact-list">
                    <li><strong>Studio:</strong> 230 West 38th Street, <br>New York, NY 10018 - USA</li>
                    <li><strong>Email:</strong> <a href="mailto:help@rcpixel.com">help@rcpixel.com</a></li>
                    <li><strong>Phone:</strong> 212 840 0846</li>
                </ul>

                <h4 class="mb20">Social Media</h4>
                <div class="social-icons">
                    <a href="#" class="social-icon icon-instagram add-tooltip first" data-placement="top" title="Instagram">
                        <i class="fa fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon icon-youtube add-tooltip" data-placement="top" title="Youtube">
                        <i class="fa fa-youtube"></i>
                    </a>
                    <a href="#" class="social-icon icon-pinterest add-tooltip" data-placement="top" title="Pinterest">
                        <i class="fa fa-pinterest"></i>
                    </a>
                </div><!-- End .social-icons -->
            </div><!-- End .col-md-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb50"></div><!--space -->

</div><!-- End #content -->


<!-- Google map javascript api v3 -->
<script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
    /* Map */
    (function () {
        "use strict";
        
        if (document.getElementById("map")) {
            var locations = [
                ['<div class="map-info-box"><ul class="contact-info-list"><li><span><i class="fa fa-home fa-fw"></i></span>230 West 38th Street, <br>New York, NY 10018 - USA</li><li><span><i class="fa fa-phone fa-fw"></i></span>212 840 0846</li></ul></div>', 40.7537979, -73.9900212, 9]
            ];

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: new google.maps.LatLng(40.7537979, -73.9900212),
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
            });

            var infowindow = new google.maps.InfoWindow();


            var marker, i;

            for (i = 0; i < locations.length; i++) {  
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: '<?php echo theme_assets_url("GI3") ?>/images/pin.png',
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
        }

    }());
</script>

