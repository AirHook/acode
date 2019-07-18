<?php
/* * ****************************
 * We pretty much know this theme
 * So, let's define it ahead
 */
define('THEME', 'GI3');

/* * ****************************
 * We shall then determine if this is being previewed
 * or, has been applied to a web space. We then
 * apply the correct base url path to use for links to pages
 */
//define('BASEURL', (@$webspace_details ? base_url() : theme_url(THEME . '/')));

?>
<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo (isset($meta->title)) ? $meta->title : THEME . ' | ' . ucfirst($file); ?></title>
        <meta name="description" content="<?php echo (isset($meta->description)) ? $meta->description : THEME . ' | ' . ucfirst($file); ?>">
        <meta name="keyword" content="<?php echo (isset($meta->keyword)) ? $meta->keyword : THEME . ' | ' . ucfirst($file); ?>">
        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700,900,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,400italic,600italic,700italic,600,800,300,700,800italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
        <!-- Google Fonts -->

        <link rel="stylesheet" href="<?php echo base_url('assets/themes/GI3'); ?>/css/animate.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/themes/GI3'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/themes/GI3'); ?>/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/themes/GI3'); ?>/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/themes/GI3'); ?>/css/revslider/revslider-index.css">
        <link rel="stylesheet" id="color-scheme" href="<?php echo base_url('assets/themes/GI3'); ?>/css/colors/gold.css">

        <!-- Favicon and Apple Icons -->
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/themes/GI3'); ?>/images/icons/favicon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url('assets/themes/GI3'); ?>/images/icons/faviconx57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets/themes/GI3'); ?>/images/icons/faviconx72.png">

        <!-- Modernizr -->
        <script src="<?php echo base_url('assets/themes/GI3'); ?>/js/modernizr.js"></script>

        <!--- jQuery -->
        <script src="<?php echo base_url('assets/themes/GI3'); ?>/js/jquery.min.js"></script>

        <!-- Queryloader -->
        <script src="<?php echo base_url('assets/themes/GI3'); ?>/js/queryloader2.min.js"></script>

        <style type="text/css">
            #features:before{
                margin-top: -55px;
                height: 55px;
                display: block; 
                visibility: hidden; 
                content: " "; 
            }
            #portfolio:before{
                margin-top: -60px;
                height: 60px;
                display: block; 
                visibility: hidden; 
                content: " ";
            }

            .dClass {float:left;}
            @media only screen and (max-width: 760px){
                .dClass {float:none;}
            }
        </style>

    </head>
    <body>
        <div class="boss-loader-overlay"></div><!-- End .boss-loader-overlay -->
        <div id="wrapper">
            <header id="header" role="banner">
                <div class="collapse navbar-white special-for-mobile" id="header-search-form">
                    <div class="container">
                        <form class="navbar-form animated fadeInDown">
                            <input type="search" id="s" name="s" class="form-control" placeholder="Search in here...">
                            <button type="submit" class="btn-circle" title="Search"><i class="fa fa-search"></i></button>
                        </form>
                    </div><!-- End .container -->
                </div><!-- End #header-search-form -->
                <nav class="navbar navbar-white <?php echo ($file == "index") ? "navbar-transparent" : ""; ?> animated-dropdown ttb-dropdown" role="navigation">

                    <div class="navbar-top clearfix">
                        <div class="container">
                            <div class="pull-left">
                                <ul class="navbar-top-nav clearfix hidden-sm hidden-xs">
                                    <li><a href="#"><i class="fa fa-user"></i>My Account</a></li>
                                    <li><a href="<?php echo site_url('login'); ?>"><i class="fa fa-external-link"></i>Login</a></li>
                                    <!-- <li><a href="<?php echo site_url('register'); ?>"><i class="fa fa-terminal"></i>Register</a></li> -->
                                    <!-- <li><a href="#"><i class="fa fa-gift"></i>My Wishlist</a></li> -->
                                </ul>
                                <div class="dropdown account-dropdown visible-sm visible-xs">
                                    <a class="dropdown-toggle" href="#" id="account-dropdown" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-user"></i>My Account
                                        <span class="angle"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="account-dropdown">
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user"></i>My Account</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('login'); ?>"><i class="fa fa-external-link"></i>Login</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('register'); ?>"><i class="fa fa-terminal"></i>Register</a></li>
                                        <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-gift"></i>My Wishlist</a></li> -->
                                    </ul>
                                </div><!-- End .account-dropdown -->
                            </div><!-- End .pull-left -->

                            <div class="pull-right">
                                <div class="social-icons pull-right hidden-xs">
                                    <a href="https://www.instagram.com/rcpixel/?hl=en" target="_blank" class="social-icon icon-instagram" title="Instagram">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-youtube" title="Youtube">
                                        <i class="fa fa-youtube"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-pinterest" title="Pinterest">
                                        <i class="fa fa-pinterest"></i>
                                    </a>
                                </div><!-- End .social-icons -->

                                <div class="dropdowns-container pull-right clearfix">
                                    <!-- <div class="dropdown currency-dropdown pull-right">
                                        <a class="dropdown-toggle" href="#" id="currency-dropdown" data-toggle="dropdown" aria-expanded="true">
                                            Currency
                                            <span class="angle"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="currency-dropdown">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Us Dollar</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Euro</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Turkish TL</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Pound</a></li>
                                        </ul>
                                    </div> --><!-- End .currency-dropdown -->

                                    <div class="dropdown language-dropdown pull-right">
                                        <a class="dropdown-toggle" href="#" id="language-dropdown" data-toggle="dropdown" aria-expanded="true">
                                            Languages
                                            <span class="angle"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="language-dropdown">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">English</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Spanish</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Turkish</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">German</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Italian</a></li>
                                        </ul>
                                    </div><!-- End .curreny-dropdown -->
                                </div><!-- End. dropdowns-container -->

                            </div><!-- End .pull-right -->
                        </div><!-- End .container -->
                    </div><!-- End .navbar-top -->

                    <?php if ($file == "index") { ?> 
                        <div class="sticky-wrapper">
                            <div class="navbar-inner sticky-menu">
                            <?php } else { ?>
                                <div class="navbar-inner sticky-menu"></div>
                            <?php } ?>        
                            <div class="container">
                                <div class="navbar-header">

                                    <button type="button" class="navbar-toggle btn-circle pull-right collapsed" data-toggle="collapse" data-target="#main-navbar-container">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                    </button>

                                    <a class="navbar-brand text-uppercase" href="<?php echo site_url('home'); ?>" title="RCPIXEL PREMIUM WEB FRONT ENDS"><?php echo @$webspace_details ? $webspace_details->webspace_slug : ucfirst($file) . ' page'; ?></a>

                                    <button type="button" class="navbar-btn btn-icon btn-circle pull-right last visible-sm visible-xs" data-toggle="collapse" data-target="#header-search-form"><i class="fa fa-search"></i></button>

                                    <div class="dropdown cart-dropdown visible-sm visible-xs pull-right">
                                        <button type="button" class="navbar-btn btn-icon btn-circle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i></button>
                                        <div class="dropdown-menu cart-dropdown-menu" role="menu">
                                            <p class="cart-dropdown-desc"><i class="fa fa-cart-plus"></i>You have 2 product(s) in your cart:</p>
                                            <hr>
                                            <div class="product clearfix">
                                                <a href="#" class="remove-btn" title="Remove"><i class="fa fa-close"></i></a>
                                                <figure>
                                                    <a href="<?php echo site_url('products'); ?>" title="Product Name"><img class="img-responsive" src="<?php echo base_url('assets/themes/GI3') ?>/images/products/thumbs/product1.jpg" alt="Product image"></a>
                                                </figure>
                                                <div class="product-meta">
                                                    <h4 class="product-name"><a href="<?php echo site_url('products'); ?>">Seamsun 3d Smart Tv</a></h4>
                                                    <div class="product-quantity">x 2 piece(s)</div><!-- End .product-quantity -->
                                                    <div class="product-price-container">
                                                        <span class="product-price">$80.50</span>
                                                        <span class="product-old-price">$120.50</span>
                                                    </div><!-- End .product-price-container -->
                                                </div><!-- End .product-meta -->
                                            </div><!-- End .product -->
                                            <div class="product clearfix">
                                                <a href="#" class="remove-btn" title="Remove"><i class="fa fa-close"></i></a>
                                                <figure>
                                                    <a href="<?php echo site_url('products'); ?>" title="Product Name"><img class="img-responsive" src="<?php echo base_url('assets/themes/GI3') ?>/images/products/thumbs/product1.jpg" alt="Product image"></a>
                                                </figure>
                                                <div class="product-meta">
                                                    <h4 class="product-name"><a href="products.html">Banana Smart Watch</a></h4>
                                                    <div class="product-quantity">x 1 piece(s)</div><!-- End .product-quantity -->
                                                    <div class="product-price-container">
                                                        <span class="product-price">$120.99</span>
                                                    </div><!-- End .product-price-container -->
                                                </div><!-- End .product-meta -->
                                            </div><!-- End .product -->
                                            <hr>
                                            <div class="cart-action">
                                                <div class="pull-left cart-action-total">
                                                    <span>Total:</span> $281.99
                                                </div><!-- End .pull-left -->
                                                <div class="pull-right">
                                                    <a href="#" class="btn btn-custom ">Go to Cart</a>
                                                </div>
                                            </div><!-- End .cart-action -->
                                        </div><!-- End .dropdown-menu -->
                                    </div><!-- End .cart-dropdown -->


                                </div><!-- End .navbar-header -->

                                <div class="collapse navbar-collapse" id="main-navbar-container">
                                    <ul class="nav navbar-nav">
                                        <li <?php echo $file == 'packages' ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo site_url('packages'); ?>">PACKAGES</a>
                                        </li>
                                        <li <?php echo $file == 'features' ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo site_url('features'); ?>">FEATURES</a>
                                        </li>
                                        <li <?php echo $file == 'portfolio' ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo site_url('portfolio'); ?>">PORTFOLIO</a>
                                        </li>
                                        <li class="">
                                            <a href="<?php echo site_url('photography'); ?>">PHOTOGRAPHY</a>
                                        </li>
                                        <li class="">
                                            <a href="<?php echo site_url('multimedia'); ?>">MULTIMEDIA</a>
                                        </li>
                                        <li <?php echo $file == 'contact' ? 'class="active"' : ''; ?>>
                                            <a href="<?php echo site_url('contact'); ?>">CONTACT US</a>
                                        </li>
                                    </ul>

                                    <button type="button" class="navbar-btn btn-icon btn-circle navbar-right last  hidden-sm hidden-xs" data-toggle="collapse" data-target="#header-search-form"><i class="fa fa-search"></i></button>

                                    <div class="dropdown cart-dropdown navbar-right hidden-sm hidden-xs">
                                        <button type="button" class="navbar-btn btn-icon btn-circle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i></button>
                                        <div class="dropdown-menu cart-dropdown-menu" role="menu">
                                            <p class="cart-dropdown-desc"><i class="fa fa-cart-plus"></i>You have 2 product(s) in your cart:</p>
                                            <hr>
                                            <div class="product clearfix">
                                                <a href="#" class="remove-btn" title="Remove"><i class="fa fa-close"></i></a>
                                                <figure>
                                                    <a href="<?php echo site_url('products'); ?>" title="Product Name"><img class="img-responsive" src="<?php echo base_url('assets/themes/GI3') ?>/images/products/thumbs/product1.jpg" alt="Product image"></a>
                                                </figure>
                                                <div class="product-meta">
                                                    <h4 class="product-name"><a href="<?php echo site_url('products'); ?>">Seamsun 3d Smart Tv</a></h4>
                                                    <div class="product-quantity">x 2 piece(s)</div><!-- End .product-quantity -->
                                                    <div class="product-price-container">
                                                        <span class="product-price">$80.50</span>
                                                        <span class="product-old-price">$120.50</span>
                                                    </div><!-- End .product-price-container -->
                                                </div><!-- End .product-meta -->
                                            </div><!-- End .product -->
                                            <div class="product clearfix">
                                                <a href="#" class="remove-btn" title="Remove"><i class="fa fa-close"></i></a>
                                                <figure>
                                                    <a href="<?php echo site_url('products'); ?>" title="Product Name"><img class="img-responsive" src="<?php echo base_url('assets/themes/GI3') ?>/images/products/thumbs/product1.jpg" alt="Product image"></a>
                                                </figure>
                                                <div class="product-meta">
                                                    <h4 class="product-name"><a href="<?php echo site_url('products'); ?>">Banana Smart Watch</a></h4>
                                                    <div class="product-quantity">x 1 piece(s)</div><!-- End .product-quantity -->
                                                    <div class="product-price-container">
                                                        <span class="product-price">$120.99</span>
                                                    </div><!-- End .product-price-container -->
                                                </div><!-- End .product-meta -->
                                            </div><!-- End .product -->
                                            <hr>
                                            <div class="cart-action">
                                                <div class="pull-left cart-action-total">
                                                    <span>Total:</span> $281.99
                                                </div><!-- End .pull-left -->
                                                <div class="pull-right">
                                                    <a href="#" class="btn btn-custom ">Go to Cart</a>
                                                </div>
                                            </div><!-- End .cart-action -->
                                        </div><!-- End .dropdown-menu -->
                                    </div><!-- End .cart-dropdown -->
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container -->
                            <?php if ($file == "index") { ?> 
                            </div>
                        </div><!-- End .navbar-inner -->
                    <?php } else { ?>
                        </div>
                    <?php } ?>          

                </nav>
            </header>