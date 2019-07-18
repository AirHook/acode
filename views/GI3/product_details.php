<div id="content" role="main">
    <div class="page-header white larger larger-desc">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php echo @$webspace_details ? $product_detail->prod_name : 'Product Name'; ?></h1>
                    <p class="page-header-desc"><?php echo @$webspace_details ? $product_detail->prod_desc : 'Product single/details pages for products.'; ?></p>
                </div><!-- End .col-md-6 -->
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li><a href="<?php echo @$webspace_details ? site_url('shop/categories/' . $product_detail->c_url_structure) : BASEURL . 'categories.html'; ?>" title="Womens Apparel"><?php echo @$webspace_details ? 'Womens Apparel' : 'Apparel'; ?></a></li>
                        <li class="active"><?php echo @$webspace_details ? $product_detail->prod_name : 'Product Name'; ?></li>
                    </ol>
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <div class="container">
        <div class="row">

            <div class="col-md-9 col-md-push-3">
                <div class="row">
                    <div class="col-md-5">
                        <div class="product-gallery-container">
                            <div class="product-top">
                                <img id="product-zoom" src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product1.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product1-big.jpg" alt="Product image big"/>
                            </div><!-- End .product-top -->

                            <div class="product-gallery-wrapper">
                                <div class="owl-carousel product-gallery product-gallery-sm">
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product1.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product1-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product1-small.jpg" alt="product-small-1">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product2.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product2-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product2-small.jpg" alt="product-small-2">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product3.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product3-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product3-small.jpg" alt="product-small-3">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product4.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product4-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product4-small.jpg" alt="product-small-4">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product5.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product5-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product5-small.jpg" alt="product-small-5">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product6.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product6-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product6-small.jpg" alt="product-small-6">
                                    </a>
                                    <a href="#" data-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product7.jpg" data-zoom-image="<?php echo theme_assets_url('GI3') ?>/images/products/single/product7-big.jpg" class="product-gallery-item">
                                        <img src="<?php echo theme_assets_url('GI3') ?>/images/products/single/product7-small.jpg" alt="product-small-7">
                                    </a>
                                </div><!-- End .product-gallery -->
                            </div><!-- End #product-gallery-wrapper -->
                        </div><!-- End .product-gallery-container -->
                    </div><!-- End .col-md-5 -->

                    <div class="col-md-7">
                        <div class="product-details">
                            <h2 class="product-title"><?php echo $product_detail->prod_name; ?></h2>

                            <div class="product-price-container">

                                <span class="product-price">$<?php echo $product_detail->catalogue_price; ?></span>
                            </div><!-- End .product-price-container -->
                            <div class="product-ratings-container">
                                <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                    <span class="ratings" style="width:75%" >
                                        <span class="ratings-text sr-only">81 Rating</span>
                                    </span><!-- End .ratings -->
                                </a><!-- End .product-ratings -->
                                <span class="product-ratings-count">25 Review(s)</span>
                                <span class="separator">|</span> <a href="#" clasS="product-ratings-add">Add your review</a>
                            </div><!-- End .product-ratings-container -->

                            <div class="filter-size-container">
                                <label class="input-desc">Size:</label>
                                <div class="row">
                                    <a href="#" class="filter-size-box">xs</a>
                                    <a href="#" class="filter-size-box">s</a>
                                    <a href="#" class="filter-size-box">m</a>
                                    <a href="#" class="filter-size-box">ml</a>
                                    <a href="#" class="filter-size-box">l</a>
                                </div><!-- End .row -->
                            </div><!-- End .filter-size-container -->

                            <div class="filter-color-container">
                                <label class="input-desc">Color:</label>
                                <div class="row">
                                    <?php
                                    if (@$webspace_details):
                                        $colornames = unserialize($product_detail->colornames);

                                        foreach ($colornames as $color => $code):
                                            ?>
                                            <a href="#" data-bgcolor="<?php echo $color ?>" class="filter-color-box"></a>
                                        <?php endforeach; ?>
                                        <?php
                                    else:
                                        ?>
                                        <a href="#" data-bgcolor="#eaeaea" class="filter-color-box"></a>
                                        <a href="#" data-bgcolor="#009688" class="filter-color-box"></a>
                                        <a href="#" data-bgcolor="#2196f3" class="filter-color-box"></a>
                                        <a href="#" data-bgcolor="#ffc107" class="filter-color-box"></a>
                                        <a href="#" data-bgcolor="#d4e157" class="filter-color-box"></a>
                                    <?php endif ?>
                                </div><!-- End .row -->
                            </div><!-- End .filter-color-container -->

                            <div class="product-quantity-wrapper">
                                <div class="product-quantity">
                                    <label class="input-desc">Quantity:</label>
                                    <input type="text" value="10" class="horizontal-spinner">
                                </div><!-- End .product-quantity -->
                            </div><!-- End .product-quantity-wrapper -->

                            <div class="product-action">
                                <a href="#" class="btn btn-custom min-width add-to-cart no-radius" title="Add to Cart"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                <a href="#" class="btn btn-dark min-width no-radius" title="Add to Wishlist"><i class="fa fa-heart"></i>Add to Wishlist</a>
                            </div><!-- End .product-action -->

                            <div class="share-container">
                                <label class="input-desc">Share now:</label>
                                <div class="social-icons social-icons-bg social-icons-bg-hover social-icons-circle">
                                    <a href="#" class="social-icon icon-facebook" title="Facebook">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-twitter" title="Twitter">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-google-plus" title="Google Plus">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-dribbble" title="Dribbble">
                                        <i class="fa fa-dribbble"></i>
                                    </a>
                                    <a href="#" class="social-icon icon-skype" title="Skype">
                                        <i class="fa fa-skype"></i>
                                    </a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .share-container -->

                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-7 -->

                </div><!-- End .row -->

                <div class="product-tab-section">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab" data-toggle="tab"><i class="fa fa-home"></i>Description</a></li>

                            <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab"><i class="fa fa-user"></i>Reviews</a></li>

                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i>Messages</a></li>

                            <li role="presentation"><a href="#options" aria-controls="options" role="tab" data-toggle="tab"><i class="fa fa-cogs"></i>Options</a></li>
                        </ul>

                        <!-- Tab Panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="description">
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis eius officia, beatae recusandae nobis accusantium deserunt cum voluptate eum soluta, sapiente tempora amet neque reprehenderit labore, iste suscipit. Placeat, voluptates.</span><span>Ipsa eius quaerat amet dolorum doloribus cum hic cupiditate laboriosam sit rerum cumque, blanditiis, tempore esse, vero accusantium repellendus a libero repellat iusto aliquam natus velit corrupti incidunt. Quo, tenetur.</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos, vero iure tempora dicta! Quidem iusto saepe, debitis dicta nisi eligendi nulla odit, quasi enim. Quasi voluptatibus, nobis laborum quaerat ipsum.</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius beatae excepturi doloremque odit id possimus explicabo, nemo aliquid tenetur nisi mollitia aspernatur harum libero, eum aperiam voluptates minima. Architecto, eveniet.</span><span>Vitae, impedit aspernatur vel deleniti suscipit rem corporis dignissimos consequatur commodi sapiente, aliquid, reprehenderit architecto beatae. Numquam dolorum quod iusto, facere eaque accusamus dignissimos veritatis fugiat eum magni soluta rem.</span></p>
                            </div><!-- End .tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="reviews">
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error quae quod, magnam ad consequuntur. Amet molestiae atque quos sint, neque excepturi, esse magni fugit ducimus laudantium quasi? Praesentium, perspiciatis, reprehenderit.</span><span>Iure aperiam rem repellendus velit quis, voluptatem reprehenderit soluta rerum, tempora eos possimus nisi blanditiis, veritatis nostrum cumque hic laborum quod, placeat. Asperiores officiis veniam, ipsum consequatur laborum dolorem ducimus.</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus sequi, numquam quam nam fugiat quibusdam eveniet consequuntur ipsum alias aliquam, cum repudiandae rem, aut facere odit illum nostrum laboriosam nesciunt.</span><span>Rem necessitatibus officia provident soluta accusantium sint animi ipsum sed, deserunt facilis illo nihil ab repellat ad. Doloremque placeat, atque, necessitatibus, impedit itaque sit obcaecati sapiente reiciendis dolorum, culpa quod?</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum vel perspiciatis eligendi mollitia quas eum suscipit et quo inventore repellendus praesentium doloribus at quis obcaecati impedit distinctio, consequuntur odit atque.</span><span>Eveniet excepturi maiores, sint ullam numquam velit, ea facilis enim incidunt ipsum esse quas sunt nesciunt fugit rerum vel eius provident sit facere aspernatur ipsam obcaecati. Pariatur, iste, laborum. Dolore.</span></p>
                            </div><!-- End .tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="messages">
                                <p>
                                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum tempore placeat assumenda magni consequuntur nulla facilis itaque labore? Ducimus quis vero velit reprehenderit inventore in fugit enim deserunt ex optio.</span>
                                    <span>Unde quidem reiciendis cum atque culpa, ipsa blanditiis animi ducimus quaerat soluta, repudiandae quo natus commodi hic esse nam, dolores repellat. Suscipit minus hic laborum ipsum reiciendis cupiditate temporibus voluptates!</span>
                                    <span>Ex officiis quam laudantium placeat illum. Sequi voluptate vero molestiae saepe vitae optio eum sit esse ipsam tempora, magnam eius veritatis quae ratione, praesentium consectetur cupiditate aspernatur. Accusantium, sit, modi?</span>
                                </p>
                                <p>
                                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat reprehenderit omnis, consequatur magni eligendi, optio id qui ullam dignissimos, praesentium quam? At ea tenetur necessitatibus reiciendis veniam quam minima amet.</span>
                                    <span>Modi sapiente error enim totam veritatis repudiandae nostrum, non aliquam, neque placeat laboriosam cum. Alias aperiam iste autem ipsa et nisi quos, earum corrupti quam nesciunt ratione pariatur nobis at!</span>
                                    <span>Accusamus dolorum repellat, voluptate ipsum natus autem culpa sit error hic neque deserunt, at ipsa, assumenda nobis numquam reiciendis sunt ad sed id accusantium unde veritatis obcaecati vel. Impedit, at.</span>
                                </p>
                            </div><!-- End .tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="options">
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam fugiat deleniti impedit cumque, a libero provident assumenda. Id, nihil autem iste sint, odio libero sapiente quae commodi praesentium voluptatibus sequi.</span><span>Harum natus temporibus sequi, consequuntur commodi nesciunt adipisci, odio nobis ab sapiente eum doloribus eius quasi saepe at nostrum sunt voluptas quibusdam veritatis quisquam iste! Porro sapiente dicta, nobis voluptatibus.</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem quam hic, soluta dicta magni aliquam neque molestias. Libero, sit, ratione. Laudantium facilis minus ducimus, molestiae illo quam reiciendis quasi praesentium?</span><span>Iste adipisci vitae repudiandae iusto enim alias nemo, reprehenderit eveniet commodi! Enim ut, sed. Velit ea quidem ipsam sunt ratione est itaque ut, voluptate eius possimus, adipisci quia totam? Tempora!</span></p>
                                <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem cumque corrupti fugiat vel earum illo adipisci deleniti accusamus dicta, et, voluptatem. Incidunt molestias ipsa minima reprehenderit mollitia. Numquam, aliquam, provident.</span><span>Non laboriosam assumenda nihil, id est, harum animi repudiandae obcaecati ratione voluptatum alias nostrum eius, beatae rem ut illum quibusdam nulla distinctio voluptas. Perspiciatis a natus doloremque totam laboriosam delectus!</span></p>
                            </div><!-- End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- end role[tabpanel] -->
                </div><!-- End .product-tab-section -->

                <div class="mb50"></div><!-- space -->

                <h3 class="title-underblock custom mb80 text-center">Related Products</h3>
                <div class="owl-carousel related-products-carousel2 center-top-nav gray-nav">
                    <div class="product text-center">
                        <div class="product-top">
                            <span class="product-box new-box new-box-border">New</span>
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product6.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product6-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-old-price">$125.99</span>
                            <span class="product-price">$49.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->

                    <div class="product text-center">
                        <div class="product-top">
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product3.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product3-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-old-price">$200.99</span>
                            <span class="product-price">$88.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->

                    <div class="product text-center">
                        <div class="product-top">
                            <span class="product-box discount-box discount-box-border top-right">-20%</span>
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product7.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product7-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-old-price">$125.99</span>
                            <span class="product-price">$49.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->

                    <div class="product text-center">
                        <div class="product-top">
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product4.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product4-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-old-price">$125.99</span>
                            <span class="product-price">$49.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->

                    <div class="product text-center">
                        <div class="product-top">
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product2.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product2-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-price">$49.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->
                    <div class="product text-center">
                        <div class="product-top">
                            <span class="product-box new-box new-box-border">New</span>
                            <figure>
                                <a href="product.html" title="Product Name">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product1.jpg" alt="Product image" class="product-image">
                                    <img src="<?php echo theme_assets_url('GI3') ?>/images/products/product1-hover.jpg" alt="Product image" class="product-image-hover">
                                </a>
                            </figure>
                            <div class="product-action-container product-action-animate">
                                <a href="#" class="btn btn-dark add-to-favorite" title="Add to favorite"><i class="fa fa-heart"></i></a>

                                <a href="#" class="btn btn-dark add-to-wishlist" title="Add to wishlist"><i class="fa fa-gift"></i></a>

                                <a href="#" class="btn btn-dark quick-view" title="Quick View"><i class="fa fa-search-plus"></i></a>
                            </div><!-- end .product-action-container -->
                        </div><!-- End .product-top -->
                        <h3 class="product-title"><a href="product.html" title="Product Title">Clear - New Season Shirt</a></h3>
                        <div class="ratings-container">
                            <a href="#" class="product-ratings add-tooltip" title="3.75 Average">
                                <span class="ratings" style="width:75%" >
                                    <span class="ratings-text sr-only">81 Rating</span>
                                </span><!-- End .ratings -->
                            </a><!-- End .product-ratings -->
                        </div><!-- End .ratings-container -->
                        <div class="product-price-container">
                            <span class="product-old-price">$125.99</span>
                            <span class="product-price">$49.99</span>
                        </div><!-- End .product-price-container -->

                        <a href="#" class="btn btn-custom add-to-cart">Add to Cart</a>
                    </div><!-- End .product -->
                </div><!-- End .owl-carousel -->
            </div><!-- End .col-md-9 -->
         
            <div class="mb30 visible-sm visible-xs"></div><!-- space -->

            <aside class="col-md-3 col-md-pull-9 sidebar">

                <div class="widget">
                    <h3>Categories</h3>

                    <ul id="category-widget">
                        <li class="open"><a href="#">Women <span class="category-widget-btn"></span></a>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Clothing</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Accessories</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>sportswear</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Maternety</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Watches</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Men <span class="category-widget-btn"></span></a>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Suits</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Style</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Accessories</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Watches</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Make-up</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Girls <span class="category-widget-btn"></span></a>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Beauty</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Belts</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Make-up</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Watches</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Shoes</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- End .widget -->

                <div class="widget">
                    <h3>Short Video</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" width="560" height="315" src="//www.youtube.com/embed/sOKC_e1Ygvc" allowfullscreen></iframe>
                    </div><!-- End .embed-responsive -->
                </div><!-- End .widget -->

            </aside>

        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb20 hidden-xs hidden-sm"></div><!-- space -->

</div><!-- End #content -->

