<div id="content" role="main">
    <div class="page-header dark larger larger-desc">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Category List <small class="hidden-xs">(Both Sidebar)</small></h1>
                    <p class="page-header-desc">Check out the this specific category.</p>
                </div><!-- End .col-md-6 -->
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li class="active">Category</li>
                    </ol>
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="container">
        <div class="row">

            <aside class="col-md-3 sidebar">

                <div class="widget">
                    <h3>Categories</h3>

                </div><!-- End .widget -->

                <div class="widget">
                    <h3>Short Video</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" width="560" height="315" src="//www.youtube.com/embed/sOKC_e1Ygvc" allowfullscreen></iframe>
                    </div><!-- End .embed-responsive -->
                </div><!-- End .widget -->

            </aside>

            <div class="col-md-6">
                <div class="filter-row clearfix">
                    <div class="filter-row-left">
                        <span class="filter-row-label">Sort By:</span>
                        <div class="small-selectbox clearfix">
                            <select id="sort" name="sort" class="selectbox">
                                <option value="Rating">Rating</option>
                                <option value="Color">Color</option>
                                <option value="Size">Size</option>
                                <option value="Price">Price</option>
                            </select>
                        </div><!-- End .normal-selectbox-->
                    </div><!-- End .filter-row-left -->
                    <div class="filter-row-left">
                        <span class="filter-row-label">Show:</span>
                        <div class="small-selectbox clearfix">
                            <select id="count" name="count" class="selectbox">
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                                <option value="60">60</option>
                            </select>
                        </div><!-- End .normal-selectbox-->
                    </div><!-- End .filter-row-left -->
                    <div class="filter-row-right">
                        <a href="category.html" class="btn btn-layout btn-border add-tooltip" data-placement="top" title="Category Grid"><i class="fa fa-th"></i></a>
                        <a href="category-list.html" class="btn btn-layout btn-border add-tooltip active" data-placement="top" title="Category List"><i class="fa fa-th-list"></i></a>
                        <a href="compare.html" class="btn btn-compare btn-dark">Compare</a>

                    </div><!-- End .filter-row-right -->
                </div><!-- End .filter-row -->
         
                    <div class="product">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="product-top">
                                    <span class="product-box new-box new-box-border top-right">-New</span>
                                    <div class="ratings-container">
                                        <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                            <span class="ratings" style="width:75%" >
                                                <span class="ratings-text sr-only">81 Rating</span>
                                            </span><!-- End .ratings -->
                                        </a><!-- End .product-ratings -->
                                    </div><!-- End .ratings-container -->
                                    <figure>
                                        <a href="product.html" title="Product Name">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product3.jpg" alt="Product image" class="product-image">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product3-hover.jpg" alt="Product image" class="product-image-hover">
                                        </a>
                                    </figure>
                                    <div class="product-action-container vertical product-action-animate">
                                        <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                        <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                        <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                                    </div><!-- end .product-action-container -->
                                </div><!-- End .product-top -->
                            </div><!-- End .col-sm-4 -->

                            <div class="mb20 visible-xs"></div><!-- space -->

                            <div class="col-sm-8">
                                <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                                <div class="product-price-container">
                                    <span class="product-price">$199.99</span> 
                                </div><!-- End .product-price-container -->

                                <p>Aenean ex erat, bibendum ut posuere quis, semper vitae tortor. Mauris at iaculis nulla, aliquam facilisis odio. Nam orci dolor, porttitor quis tristique vel, scelerisque non enim.</p>

                                <a href="#" class="btn btn-custom3 btn-border add-to-cart">Add to Cart</a>
                            </div><!-- End .col-sm-8 -->

                        </div><!-- End .row -->
                    </div><!-- End .product -->

                    <div class="product">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="product-top">
                                    <div class="ratings-container">
                                        <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                            <span class="ratings" style="width:75%" >
                                                <span class="ratings-text sr-only">81 Rating</span>
                                            </span><!-- End .ratings -->
                                        </a><!-- End .product-ratings -->
                                    </div><!-- End .ratings-container -->
                                    <figure>
                                        <a href="product.html" title="Product Name">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product4.jpg" alt="Product image" class="product-image">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product4-hover.jpg" alt="Product image" class="product-image-hover">
                                        </a>
                                    </figure>
                                    <div class="product-action-container vertical product-action-animate">
                                        <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                        <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                        <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                                    </div><!-- end .product-action-container -->
                                </div><!-- End .product-top -->
                            </div><!-- End .col-sm-4 -->

                            <div class="mb20 visible-xs"></div><!-- space -->

                            <div class="col-sm-8">
                                <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                                <div class="product-price-container">
                                    <span class="product-price">$1100</span> 
                                </div><!-- End .product-price-container -->

                                <p>Aenean ex erat, bibendum ut posuere quis, semper vitae tortor. Mauris at iaculis nulla, aliquam facilisis odio. Nam orci dolor, porttitor quis tristique vel, scelerisque non enim.</p>

                                <a href="#" class="btn btn-custom3 btn-border add-to-cart">Add to Cart</a>
                            </div><!-- End .col-sm-8 -->

                        </div><!-- End .row -->
                    </div><!-- End .product -->

                    <div class="product">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="product-top">
                                    <div class="ratings-container">
                                        <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                            <span class="ratings" style="width:75%" >
                                                <span class="ratings-text sr-only">81 Rating</span>
                                            </span><!-- End .ratings -->
                                        </a><!-- End .product-ratings -->
                                    </div><!-- End .ratings-container -->
                                    <figure>
                                        <a href="product.html" title="Product Name">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product5.jpg" alt="Product image" class="product-image">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product5-hover.jpg" alt="Product image" class="product-image-hover">
                                        </a>
                                    </figure>
                                    <div class="product-action-container vertical product-action-animate">
                                        <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                        <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                        <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                                    </div><!-- end .product-action-container -->
                                </div><!-- End .product-top -->
                            </div><!-- End .col-sm-4 -->

                            <div class="mb20 visible-xs"></div><!-- space -->

                            <div class="col-sm-8">
                                <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                                <div class="product-price-container">
                                    <span class="product-old-price">$199.99</span>
                                    <span class="product-price">$99.99</span> 
                                </div><!-- End .product-price-container -->

                                <p>Aenean ex erat, bibendum ut posuere quis, semper vitae tortor. Mauris at iaculis nulla, aliquam facilisis odio. Nam orci dolor, porttitor quis tristique vel, scelerisque non enim.</p>

                                <a href="#" class="btn btn-custom3 btn-border add-to-cart">Add to Cart</a>
                            </div><!-- End .col-sm-8 -->

                        </div><!-- End .row -->
                    </div><!-- End .product -->

                    <div class="product">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="product-top">
                                    <div class="ratings-container">
                                        <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                            <span class="ratings" style="width:75%" >
                                                <span class="ratings-text sr-only">81 Rating</span>
                                            </span><!-- End .ratings -->
                                        </a><!-- End .product-ratings -->
                                    </div><!-- End .ratings-container -->
                                    <figure>
                                        <a href="product.html" title="Product Name">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product6.jpg" alt="Product image" class="product-image">
                                            <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product6-hover.jpg" alt="Product image" class="product-image-hover">
                                        </a>
                                    </figure>
                                    <div class="product-action-container vertical product-action-animate">
                                        <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                        <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                        <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                                    </div><!-- end .product-action-container -->
                                </div><!-- End .product-top -->
                            </div><!-- End .col-sm-4 -->

                            <div class="mb20 visible-xs"></div><!-- space -->

                            <div class="col-sm-8">
                                <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                                <div class="product-price-container">
                                    <span class="product-price">$49.50</span> 
                                </div><!-- End .product-price-container -->

                                <p>Aenean ex erat, bibendum ut posuere quis, semper vitae tortor. Mauris at iaculis nulla, aliquam facilisis odio. Nam orci dolor, porttitor quis tristique vel, scelerisque non enim.</p>

                                <a href="#" class="btn btn-custom3 btn-border add-to-cart">Add to Cart</a>
                            </div><!-- End .col-sm-8 -->

                        </div><!-- End .row -->
                    </div><!-- End .product -->

                <div class="mb30"></div><!-- space -->

                <nav class="pagination-container text-center">
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                            </a>
                        </li>
                        <li  class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div><!-- End .col-md-6 -->

            <div class="mb60 visible-sm visible-xs"></div><!-- space -->

            <aside class="col-md-3 sidebar">

                <div class="widget">

                    <div class="filter-group-widget">
                        <div class="panel-group" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-border-tb">
                                <div class="panel-heading" role="tab" id="priceFilter-header">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#priceFilter" aria-expanded="true" aria-controls="priceFilter">
                                            Price Filter
                                            <span class="panel-icon"></span>
                                        </a>
                                    </h4>
                                </div><!-- End .panel-heading -->
                                <div id="priceFilter" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="priceFilter-header">
                                    <div class="panel-body">
                                        <div class="filter-price">
                                            <div id="price-range"></div><!-- End #price-range -->
                                            <div id="filter-range-details" class="row">
                                                <div class="col-xs-6">
                                                    <div class="filter-price-label">from - $</div>
                                                    <input type="text" id="price-range-low" class="form-control">
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="filter-price-label">to- $</div>
                                                    <input type="text" id="price-range-high" class="form-control">
                                                </div>
                                            </div><!-- End #filter-range-details -->
                                            <div class="filter-price-action">
                                                <a href="#" class="btn btn-custom btn-sm">Filter</a>
                                                <a href="#" class="btn btn-custom3 btn-sm">Reset</a>
                                            </div><!-- End #filter-price-action -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .panel-body -->
                                </div><!-- End .panel-collapse -->
                            </div><!-- End .panel -->
                            <div class="panel panel-border-tb">
                                <div class="panel-heading" role="tab" id="colorFilter-header">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#colorFilter" aria-expanded="true" aria-controls="colorFilter">
                                            Color Filter
                                            <span class="panel-icon"></span>
                                        </a>
                                    </h4>
                                </div><!-- End .panel-heading -->
                                <div id="colorFilter" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="colorFilter-header">
                                    <div class="panel-body">
                                        <div class="filter-color-container">
                                            <div class="row">
                                                <a href="#" data-bgcolor="#eaeaea" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#009688" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#2196f3" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#ffc107" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#d4e157" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#c5c8f4" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#9e9e9e" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#607d8b" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#795548" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#8fdfa6" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#d8ea9f" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#79a762" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#fed5d4" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#fe8482" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#00acc1" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#b39ddb" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#0277bd" class="filter-color-box"></a>
                                                <a href="#" data-bgcolor="#000000" class="filter-color-box"></a>
                                            </div><!-- End .row -->
                                        </div><!-- End .filter-color-container -->
                                    </div><!-- End .panel-body -->
                                </div><!-- End .panel-collapse -->
                            </div><!-- End .panel -->
                            <div class="panel panel-border-tb">
                                <div class="panel-heading" role="tab" id="sizeFilter-header">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#sizeFilter" aria-expanded="true" aria-controls="sizeFilter">
                                            Size Filter
                                            <span class="panel-icon"></span>
                                        </a>
                                    </h4>
                                </div><!-- End .panel-heading -->
                                <div id="sizeFilter" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="sizeFilter-header">
                                    <div class="panel-body">
                                        <div class="filter-color-container">
                                            <div class="row">
                                                <a href="#" class="filter-size-box active">6</a>
                                                <a href="#" class="filter-size-box">4</a>
                                                <a href="#" class="filter-size-box">6</a>
                                                <a href="#" class="filter-size-box">8</a>
                                                <a href="#" class="filter-size-box">10</a>
                                                <a href="#" class="filter-size-box">12</a>
                                                <a href="#" class="filter-size-box">xs</a>
                                                <a href="#" class="filter-size-box">s</a>
                                                <a href="#" class="filter-size-box">m</a>
                                                <a href="#" class="filter-size-box">ml</a>
                                                <a href="#" class="filter-size-box">l</a>
                                                <a href="#" class="filter-size-box">xl</a>
                                            </div><!-- End .row -->
                                        </div><!-- End .filter-color-container -->
                                    </div><!-- End .panel-body -->
                                </div><!-- End .panel-collapse -->
                            </div><!-- End .panel -->
                            <div class="panel panel-border-tb">
                                <div class="panel-heading" role="tab" id="brandFilter-header">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#brandFilter" aria-expanded="true" aria-controls="brandFilter">
                                            Brand Filter
                                            <span class="panel-icon"></span>
                                        </a>
                                    </h4>
                                </div><!-- End .panel-heading -->
                                <div id="brandFilter" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="brandFilter-header">
                                    <div class="panel-body">
                                        <ul class="filter-brand-list">
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Yikes &amp; Sports <span>(11)</span></a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Smittzy &amp; Jane <span>(7)</span></a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Helena's Secrets <span>(10)</span></a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Vestel's Shoes <span>(26)</span></a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Puma &amp; Cougar <span>(14)</span></a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Jane Shirts <span>(9)</span></a></li>
                                        </ul>
                                    </div><!-- End .panel-body -->
                                </div><!-- End .panel-collapse -->
                            </div><!-- End .panel -->
                        </div><!-- End .panel-group -->
                    </div><!-- End .filter-widget -->
                </div><!-- End .widget -->

            </aside>
        </div><!-- End .row -->

    </div><!-- End .container -->

    <div class="mb40 hidden-xs hidden-sm"></div><!-- space -->

</div><!-- End #content -->

