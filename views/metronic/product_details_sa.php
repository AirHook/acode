                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="product-details-wrapper">

                                            <!-- BEGIN TOP ROW FOR BREADCRUMBS AND OTHER UTILIZTIES -->
											<div class="row">

												<hr class="hidden-xs" style="margin:30px 0 0;border-color:transparent;" />

												<?php
												/***********
												 * Noification area
												 */
												?>
												<div>
													<div class="alert alert-danger display-hide">
														<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
													<div class="alert alert-success display-hide">
														<button class="close" data-close="alert"></button> Your form validation is successful! </div>
													<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
													<div class="alert alert-danger auto-remove">
														<button class="close" data-close="alert"></button> An error occured. Please try again.
													</div>
													<?php } ?>
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
												</div>

                                                <!-- BEGIN BREADCRUMBS AND CUSTOM PAGINATION -->
												<div class="col-xs-12 margin-bottom-20">

													<!-- BEGIN THUMBS BREADCRUMBS -->
													<ul class="page-breadcrumb breadcrumb breadcrumb-thumbs margin-bottom-10" style="padding-right:20px;display:inline-block;">

                                                        <?php
                                                        $sa_link = site_url('sales_package/link/index/'.$this->session->userdata('sales_package_id').'/'.$this->session->userdata('user_id').'/'.$this->session->userdata('sales_package_tc'));
                                                        ?>
                                                        <li>
															<a href="<?php echo site_url(@$sa_link); ?>">
                                                                <strong> Sales Package </strong>
															</a>
															<i class="fa fa-angle-right"></i>
														</li>
                                                        <li>
															<a href="<?php echo site_url($sa_link); ?>">
                                                                <?php echo @$this->sales_package_details->sales_package_name; ?>
															</a>
														</li>

													</ul>
													<!-- END THUMBS BREADCRUMBS -->

												</div>
                                                <!-- END BREADCRUMBS AND CUSTOM PAGINATION -->

											</div>
                                            <!-- END TOP ROW FOR BREADCRUMBS AND OTHER UTILIZTIES -->

                                            <?php
                                            //foreach ($view_pane_sql as $item)
                                            foreach ($this->sales_package_details->items as $item)
                                            {
                                                // get product details
                                                $product = $this->product_details->initialize(array('tbl_product.prod_no'=>$item));

                                                if ( ! $product)
                                                {
                                                    $exp = explode('_', $item);
                                                    $product = $this->product_details->initialize(
                                                        array(
                                                            'tbl_product.prod_no' => $exp[0],
                                                            'color_code' => $exp[1]
                                                        )
                                                    );

                                                }

                                                // set image paths
                                                // the new way relating records with media library
                                                $style_no = $product->prod_no.'_'.$product->color_code;
                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                $img_front_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';

                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                                $img_side_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg';
                                                $img_coloricon = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_c.jpg';

                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
                                                $img_video_mp4 = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'.mp4';
                                                ?>

                                            <!-- BEGIN PRODUCT DETAILS SECTION -->
											<div class="row row-product_detail" style="margin-bottom:50px;">

                                                <div class="col-md-12">
                                                    <?php
                                                    $class = 'display-hide';
                                                    foreach ($this->cart->contents() as $item)
                                                    {
                                                        if ($item['id'] === $style_no)
                                                        {
                                                            $class = '';
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="alert alert-danger present-in-cart-notice <?php echo $class; ?>">
                                                        <button class="close" data-close="alert"></button> An item <?php echo $style_no; ?> below is already in your inquiry bag. View cart <a href="<?php echo site_url('cart'); ?>">here</a>.
                                                    </div>
                                                </div>

                                                <!-- BEGIN IMAGE VIEW PANE -->
												<div class="col-sm-5">

													<!-- BEGIN MOBILE MAIN IMAGE AND OTHER VIEW SLIDER -->
													<div id="product-image-mobile-swiper" class="product-image-mobile-swipe mobile-view hidden-sm hidden-md hidden-lg" style="margin-bottom:30px;">

														<style>
														.slick-dotted.slick-slider {
															margin-bottom: 60px;
														}
														.slick-dots { bottom: -40px; }
														</style>

														<div class="slick-swipe" style="display:table;table-layout:fixed;width:100%;">

															<?php
															/**********
															 * Other MAIN image views
															 */
															?>
															<div id="panzoom1" class=""><img src="<?php echo $img_front_new; ?>" style="width:100%;" /></div>
															<div id="panzoom2" class=""><img src="<?php echo $img_back_new; ?>" style="width:100%;" /></div>
															<div id="panzoom3" class=""><img src="<?php echo $img_side_new; ?>" style="width:100%;" /></div>

														</div>.

														<div class="mobile-product-details-utilities text-center" style="">
															<span style="display:inline-block;text-align:center;">
																<i class="fa fa-2x fa-heart-o"></i> <br />
																FAVORITE
															</span>
															<!--
																&nbsp; &nbsp; &nbsp;
															<span class="zoom-in" style="display:inline-block;text-align:center;">
																<i class="fa fa-2x fa-search-plus"></i> <br />
																ZOOM IN
															</span>
																&nbsp; &nbsp; &nbsp;
															<a class="reset" style="display:inline-block;text-align:center;">
																<i class="fa fa-2x fa-search-minus"></i> <br />
																ZOOM OUT
															</a>
															-->
														</div>
													</div>
													<!-- END MOBILE MAIN IMAGE AND OTHER VIEW SLIDER -->

													<!-- BEGIN DESKTOP MAIN IMAGE VIEW WITH ZOOM EFFECT -->
													<div class="product-image-cloud-zoom desktop-view hidden-xs" style="float:left;position:relative;">

														<?php
														/**********
														 * MAIN image <a> tag container with cloud-zoom
														 */
														?>
														<a href="<?php echo $img_front_large; ?>" id="zoom1" class="cloud-zoom" rel="zoomWidth:800,zoomHeight:637,adjustX:0,adjustY:0">
															<img alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_new; ?>" width="100%" />
														</a>

														<?php
														/**********
														 * Other MAIN image views
														 */
														?>
														<img class="other-main-views" id="main-front-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_front_new; ?>" />
														<img class="other-main-views" id="main-back-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_back_new; ?>" />
														<img class="other-main-views" id="main-side-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_side_new; ?>" />

														<?php
														/**********
														 * MAIN Video
														 */
														?>
														<video class="other-main-views" id="main-video-<?php echo $this->product_details->prod_no; ?>" width="425" height="637.5" style="display:inline;" autoplay loop>
															<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('video').hide();">
															Your browser does not support the video tag.
														</video>

													</div>
													<!-- END DESKTOP MAIN IMAGE VIEW WITH ZOOM EFFECT -->

												</div>
                                                <!-- END IMAGE VIEW PANE -->

												<!-- BEGIN DESKTOP PRODUCT DETAILS INFO -->
												<div class="col-sm-7">

													<div class="product-details-info">

														<?php
														/**********
														 * MAIN Product Name and Style Number
														 */
														?>
														<h3 class="prod_info_title prod-title"><?php echo $product->designer_name; ?></h3>
														<h4 class="prod_info_title prod-title"><?php echo $product->prod_no; ?></h4>
														<h5 class="prod_info_title prod-title prod-subtitle prod-name" style="<?php echo $this->session->userdata('user_cat') === 'wholesale' ? 'margin:5px 0;' : ''; ?>"><?php echo strtoupper($product->prod_name); ?></h5>
														<h5 class="prod_info_title prod-title prod-subtitle">PRICE: &nbsp;

															<?php
															/**********
															 * The PRICE
															 */

															/**********
															 * Wholesale price by default
                                                             * Check for edited price for sales packages
															 */
                                                            // retrieve sa_options for possible changes to 'e_prices'
                                                            $options_array = $this->sales_package_details->options;
															$price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;
                                                            ?>

															<span itemprop="price" <?php echo $this->product_details->custom_order === '3' ? 'style="text-decoration:line-through;"' : ''; ?>>
                                                                [WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($price, 2); ?>
                                                            </span>&nbsp;

														</h5>

														<hr style="margin:10px 0 15px;" />

														<?php
														/**********
														 * Color
														 */
														?>
														<div class="prdname product-form__label" style="margin: 0px 0 10px;">
															<strong> COLOR: </strong>
															<span class="style1" style="margin-left:30px;">

                                                                <a href="javascript:;" class="pdp--color-name tooltips" data-original-title="<?php echo $product->color_name; ?>" style="text-decoration:underline;">
																	<?php echo $product->color_name; ?>
																</a>

															</span>
														</div>

                                                        <?php
														/**********
														 * Coloricon
														 */
														?>

                                                        <a href="javascript:;">
                                                            <img src="<?php echo $img_coloricon; ?>" alt="<?php echo $product->color_name; ?>" class="tooltips" data-original-title="<?php echo $product->color_name; ?>" style="border:1px solid #333;padding:2px;width:20px;" />
                                                        </a>

														<hr style="margin:20px 0 10px;" />

														<?php
														/**********
														 * Size and Qty
														 */
														?>
														<div class="add-to-cart-form">

															<!--bof form========================================================================-->
															<?php echo form_open(
																'cart/add_cart/wholesale',
																array(
																	'class'=>'frmCart',
																	'method'=>'POST'
																)
															); ?>

																<input type="hidden" name="wholesale_order" value="0" />
																<input type="hidden" name="package_details" value="1" />
																<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />

																<input type="hidden" name="cat_id" value="<?php echo $product->cat_id; ?>" />
																<input type="hidden" name="subcat_id" value="<?php echo $product->subcat_id; ?>" />
																<input type="hidden" name="des_id" value="<?php echo $product->des_id; ?>" />
																<input type="hidden" name="prod_no" value="<?php echo $product->prod_no; ?>" />
																<input type="hidden" name="prod_name" value="<?php echo $product->prod_name; ?>" />
																<input type="hidden" name="price" value="<?php echo $price; ?>" />
																<input type="hidden" name="label_designer" value="<?php echo $product->designer_name; ?>" />

																<input type="hidden" name="color_code" value="<?php echo $product->color_code; ?>" />
																<input type="hidden" name="prod_sku" value="<?php echo $style_no; ?>" />
																<input type="hidden" name="label_color" value="<?php echo $product->color_name; ?>" />

                                                                <input type="hidden" name="prod_image" value="<?php echo $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f1.jpg'; ?>" />
																<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />

																<?php
																// new image url system
																echo form_hidden(
																	'prod_image_url',
																	(
																		$product->primary_img
																		? $product->media_path.$style_no.'_f1.jpg'
																		: ''
																	)
																);
																?>

																<input type="hidden" name="size_mode" value="<?php echo $product->size_mode; ?>" />

                                                                <div class="product_details_wholesale row clearfix" style="margin-bottom:5px;">

                                                                    <style>
                                                                        .product_details_wholesale .product-form__list-item {
                                                                            margin: 0 0 5px 0;
                                                                            width: 34px;
                                                                        }
                                                                        .product_details_wholesale .product-form__list-item a {
                                                                            width: 34px;
                                                                            height: 34px;
                                                                        }
                                                                        .product_details_wholesale .product-form__list-item .diagonal-line {
                                                                            width: 133%;
                                                                            height: 100%;
                                                                            position: absolute;
                                                                            top: -12px;
                                                                            left: -17px;
                                                                        }
                                                                        .product_details_wholesale .product-form__list-item .details.unavailable {
                                                                            left: 0;
                                                                            bottom: 34px;
                                                                        }
                                                                        .s_prepak, .s_onesize {
                                                                            line-height: 12px;
                                                                        }
                                                                        .s_prepak span {
                                                                            position: relative;
                                                                            left: -6px;
                                                                            top: 5px;
                                                                        }
                                                                        .s_onesize span {
                                                                            position: relative;
                                                                            left: -4px;
                                                                            top: 5px;
                                                                        }
                                                                        .s_sm span {
                                                                            position: relative;
                                                                            left: -1px;
                                                                        }
                                                                        .a-bg-color {
                                                                            background-color: #ccc;
                                                                        }
                                                                    </style>

                                                                    <?php
                                                                    // assumptions: max # of sizes is 12 (ref: size mode 1)
                                                                    $skey = 1;
                                                                    for($si=0;$si<=22;$si=$si+2)
                                                                    {
                                                                        if (
                                                                            $si == 0
                                                                            OR $si == 8
                                                                            OR $si == 16
                                                                        )
                                                                        {
                                                                            if ($si == 8 OR $si == 16) echo '</div>';
                                                                            echo '
                                                                            <div class="col-md-4">

                                                                                <div class="row '.(($si == 8 OR $si == 16) ? 'hidden-xs hidden-sm' : '').'">
                                                                                    <div class="col-xs-4">
                                                                                        <strong>SIZES:</strong>
                                                                                    </div>
                                                                                    <div class="col-xs-8">
                                                                                        QUANITY:
                                                                                    </div>
                                                                                </div>
                                                                            ';
                                                                        }

                                                                        switch ($product->size_mode)
                                                                        {
                                                                            case '0':
                                                                                $size_class = '';
                                                                                $size =
                                                                                    $si == 0
                                                                                    ? 'S'
                                                                                    : (
                                                                                        $si == 2
                                                                                        ? 'M'
                                                                                        : (
                                                                                            $si == 4
                                                                                            ? 'L'
                                                                                            : (
                                                                                                $si == 8
                                                                                                ? 'XL'
                                                                                                : ''
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                ;
                                                                                $size_html = $size;
                                                                                $size_key = 's'.strtolower($size);
                                                                                $qty = $product->size_.$size_key;
                                                                            break;
                                                                            case '2':
                                                                                $size_class = $si == 0 ? 's_prepak' : '';
                                                                                $size = $si == 0 ? 'PRE PACK' : '';
                                                                                $size_html = $si == 0 ? 'PRE<br />PACK' : '';
                                                                                $size_key = $si == 0 ? 'sprepack1221' : '';
                                                                                $qty = $si == 0 ? $product->size_sprepack1221 : 0;
                                                                            break;
                                                                            case '3':
                                                                                $size_class = $si == 0 ? 's_sm' : ($si == 2 ? 's_ml' : '');
                                                                                $size = $si == 0 ? 'S-M' : ($si == 2 ? 'M-L' : '');
                                                                                $size_html = $si == 0 ? 'S-M' : ($si == 2 ? 'M-L' : '');
                                                                                $size_key = $si == 0 ? 'ssm' : ($si == 2 ? 'sml' : '');
                                                                                $qty =
                                                                                    $si == 0
                                                                                    ? $product->size_ssm
                                                                                    : ($si == 2 ? $product->size_sml : '')
                                                                                ;
                                                                            break;
                                                                            case '4':
                                                                                $size_class = $si == 0 ? 's_onesize' : '';
                                                                                $size = $si == 0 ? 'ONE SIZE' : '';
                                                                                $size_html = $si == 0 ? 'ONE<br />SIZE' : '';
                                                                                $size_key = $si == 0 ? 'sonesizefitsall' : '';
                                                                                $qty = $si == 0 ? $product->size_sonesizefitsall : 0;
                                                                            break;
                                                                            case '1':
                                                                            default:
                                                                                $size_class = '';
                                                                                $size = $si;
                                                                                $size_html = $si;
                                                                                $size_key = $si;
                                                                                $prod_size_property = 'size_'.$si;
                                                                                $qty = $product->$prod_size_property;
                                                                            break;
                                                                        } ?>

                                                                        <div class="row size-qty-row" onmouseover="$(this).find('span.details.unavailable').show();" onmouseout="$(this).find('span.details.unavailable').hide();">

                                                                            <?php
                    														/**********
                    														 * Size Col
                    														 */
                    														?>
                                                                            <div class="col-xs-4">
                                                                                <div class="hoverable product-form__list-item">
                                                                                    <a href="javascript:void();" class="input-control parent-select product-form__product-size unavailable product-form__product-size--out-of-stock product_details-size_box <?php echo $size_class; ?>" style="z-index:10;" data-size_key="<?php echo $skey; ?>" data-dsize="<?php echo $size; ?>" data-available_qty="<?php echo $qty ?: 30; ?>">
        																				<span>
                                                                                            <?php echo $size; ?>
                                                                                        </span>
        																			</a>
        																			<span class="ico"></span>
                                                                                    <?php if ($qty == '0')
                                                                                    { ?>
                                                                                    <span class="diagonal-line"></span>
        																			<span class="details unavailable" style="text-align:left;color:red;">
        																				<span class="pointer"></span>
        																				Pre-Order<br />
        																				Size Not In-Stock<br />
        																				Delivery is <?php echo @$product_stock_status ? $product_stock_status : '14-16'; ?> Weeks<br />
        																				From Order Date
        																			</span>
                                                                                    <input type="hidden" name="custom_order[<?php echo $skey; ?>]" value="1" />
                                                                                        <?php
                                                                                    } ?>
                                                                                </div>
                                                                                <input type="hidden" class="size_key" name="size[<?php echo $skey; ?>]" value="" />
                                                                            </div>

                                                                            <?php
                    														/**********
                    														 * QTY Col
                    														 */
                    														?>
                                                                            <div class="col-xs-8">
                                                                                <div class="row">
                                                                                    <div class="col-md-10 product-form__qty tooltips" <?php echo $qty ? 'data-original-title="Max in-stock qty is '.$qty.'"' : ''; ?>>
                                                                                        <select class="bs-select form-control product_details-qty_box input-sm" name="qty[<?php echo $skey; ?>]" data-size="6" data-max_qty="<?php echo $qty; ?>" data-dsize="<?php echo $size; ?>" data-size_key="<?php echo $skey; ?>">
                                                                                            <option class="opt_zeroval">0</option>
                                                                                            <?php
                                                                                            $this_qty = 30; //$qty ?: 30;
                                                                                            for ($i = 1; $i <= $this_qty; $i++)
                                                                                            {
                                                                                                echo '<option class="opt_val" value="'.$i.'">'.$i.'</option>';
                                                                                            } ?>
                                                                                        </select>
                    																</div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <?php
                                                                        $skey++;
                                                                    }

                                                                    echo '</div>';
                                                                    ?>

                                                                </div>

																<?php
																/*
																| ------------------------------------------------------------------------------------
																| ORDER button
																*/
																?>
																<style>
																.button.pre-order {
																	background-color: black;
																	border: 1px solid #fff;
																	box-shadow: 0 0 0 5px black;
																}
																.button.pre-order:hover {
																	color: grey;
																}
																</style>

																<button type="button" class="btn dark btn-block size-qty-submit-wholesale">ADD TO INQUIRY</button>

															<?php
															echo form_close();
															?>
															<!--eof form========================================================================-->

														</div>

														<?php
														/**********
														 * Description Accordion
														 */
														?>
                                                        <div class="description-accordion panel-group accordion margin-top-10" id="accordion3">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h5 class="panel-title">
                                                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#desc_and_details"> Description &amp; Details </a>
                                                                    </h5>
                                                                </div>
                                                                <div id="desc_and_details" class="panel-collapse collapse">
                                                                    <div class="panel-body">

																		<p> <?php echo $product->prod_desc; ?> </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#view_size_chart"> View Size Chart </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="view_size_chart" class="panel-collapse collapse">
                                                                    <div class="panel-body">

																		<img src="<?php echo base_url('images/designer_icon/thumb/'.$product->size_chart); ?>" style="width:100%;" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#shipping_and_returns"> Shipping &amp; Returns </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="shipping_and_returns" class="panel-collapse collapse">
                                                                    <div class="panel-body">

																		<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy'); ?>
																		<?php $this->load->view($this->webspace_details->options['theme'].'/shipping'); ?>

                                                                    </div>
                                                                </div>
                                                            </div>
														</div>

														<?php
														/**********
														 * Other Views Thumbs
														 */
                                                        $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                        $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                                        $img_side_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg';

                                                        $img_front_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
                                                        $img_back_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b.jpg';
                                                        $img_side_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s.jpg';

                                                        $img_front_thumb = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f1.jpg';
                                                        $img_back_thumb = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b1.jpg';
                                                        $img_side_thumb = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s1.jpg';

                                                        $img_video_mp4 = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'.mp4';
														?>
														<div class="other-views hidden-xs hidden-sm" style="position:absolute;bottom:0px;">

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_front_large; ?>' class="cloud-zoom-gallery" title="Front view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_front_thumb; ?>'" onmouseover="showObj('main-front-<?php echo $product->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_front_thumb; ?>" alt="Front View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_back_large; ?>' class="cloud-zoom-gallery" title="Back view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_back_thumb; ?>'" onmouseover="showObj('main-back-<?php echo $product->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_back_thumb; ?>" alt="Back View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_side_large; ?>' class="cloud-zoom-gallery" title="Side view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_side_thumb; ?>'" onmouseover="showObj('main-side-<?php echo $product->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_side_thumb; ?>" alt="Side View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;" onmouseover="showObj('main-video-<?php echo $product->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#zoom1').append('<video width=\'425\' height=\'637.5\' id=\'the-product_video\' style=\'border:1px solid #333;background:black;display:inline;position:absolute;top:0px;\' autoplay loop ><source src=\'<?php echo $img_video_mp4; ?>\' type=\'video/mp4\'>Your browser does not support the video tag.</video>');">
																<video width="60" height="90" style="border:1px solid #333;background:black;display:inline;" autoplay loop >
																	<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('div').hide();">
																	<!--
																	<source src="<?php echo $img_video_ogv; ?>" type="video/ogg" onerror="$(this).closest('div').hide();">
																	<source src="<?php echo $img_video_webm; ?>" type="video/webm" onerror="$(this).closest('div').hide();">
																	-->
																	Your browser does not support the video tag.
																</video>
															</div>

														</div>

													</div>
													<!-- /product-details-info -->

												</div>
												<!-- /col-sm-7 -->
												<!-- END DESKTOP PRODUCT DETAILS INFO -->

												<!-- HOW TO ORDER -->
												<div class="modal fade bs-modal-lg" id="how-to-oder" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Order Inquiry Form</h4>
															</div>
															<div class="modal-body">
                            									<?php
                            									$pass_data = array(
                            										'image' => $img_front_3,
                            										'img_inquiry' => $img_inquiry,
                            										'return_url' => $this->uri->uri_string(),
                            										'prod_no' => $product->prod_no,
                            										'color_code' => $product->color_code
                            										//'no_stocks_at_all' => $no_stocks_at_all
                            									);
                            									//$this->load->view($this->webspace_details->options['theme'].'/about_this_product', $pass_data);
                            									$this->load->view('metronic/about_this_product', $pass_data);
                            									?>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->

											</div>
                                            <!-- END PRODUCT DETAILS SECTION -->

                                                <?php
                                            } ?>

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
