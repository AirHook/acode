                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="product-details-wrapper">
											<div class="row">

												<hr class="hidden-xs" style="margin:30px 0 0;border-color:transparent;" />

												<?php
												/***********
												 * Noification area
												 */
												?>
												<div class="notifications col-md-12">
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

                                                    <?php if (
                                                        $this->input->get('type') == 'Consumer'
                                                        && $this->input->get('form') == 'inquiry'
                                                        && (time() - $this->input->get('tc')) <= (24*60*60)
                                                        && @$this->product_details->stocks_options['clearance_consumer_only'] == '1'
                                                    )
                                                    {
                                                        // setting a variable here for us on the size stock level for items that are 'admin_stocks_only'
                                                        $from_how_to_order = TRUE;
                                                        ?>
                                                    <div class="alert alert-danger text-center" style="background:red;font-size:1.8em;color:white;">
                                                        <strong>SPECIAL SALE - CLEARANCE PRICE - VALID FOR 24 HOURS</strong>
                                                    </div>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        $from_how_to_order = FALSE;
                                                    } ?>

                                                    <?php if (@$this->product_details->stocks_options['admin_stocks_only'] === '1_')
                                                    { ?>
                                                    <div class="alert alert-danger text-center" style="background:red;font-size:1.8em;color:white;">
                                                        <strong>SPECIAL SALE - CLEARANCE PRICE - ON LIMITED SIZES</strong>
                                                    </div>
                                                        <?php
                                                        $url	   = explode('/',$this->uri->uri_string());
                                                    } ?>

												</div>

												<div class="col-xs-12 margin-bottom-20">

													<?php if ( ! @$search_result)
													{ ?>

													<!-- BEGIN THUMBS BREADCRUMBS -->
													<ul class="page-breadcrumb breadcrumb breadcrumb-thumbs margin-bottom-10" style="padding-right:20px;display:inline-block;margin-left:0px;">

														<?php
														/**********
														 * Process URL segments
														 */
														if (@$url_segs)
														{
															$d_link = '';
															$cnt = 1;
															foreach ($url_segs as $key => $segment)
															{
																if ($cnt == 1) $d_link = 'shop';
																// get current segment's name
																$d_name = $segment[0];
																// store segment for the link
																$d_link .= '/'.$segment[1];
																$d_link = ltrim($d_link, '/');
																// check if last segment
																$d_last = $cnt == count($url_segs) ? TRUE : FALSE;
																?>

														<li>
															<a href="<?php echo site_url($d_link); ?>">
																<strong>
																	<?php echo $d_name; ?>
																</strong>
															</a>
															<?php echo $d_last ? '' : '<i class="fa fa-angle-right"></i>'; ?>
														</li>
																<?php
																$cnt++;
															}
														} ?>

													</ul>
													<!-- END THUMBS BREADCRUMBS -->

														<?php
													} ?>

                                                    <?php
                                                    $url_check = explode('/',$this->uri->uri_string());
                                                    if (@$url_check[6])
                                                    { ?>

													<br class="hidden-sm hidden-md hidden-lg" />

													<?php if (@$total_products_in_list)
													{
														echo @$nth_prod; ?> &nbsp; of &nbsp; <?php echo @$total_products_in_list; ?>
														<?php if (@$nth_prod > 1)
														{ ?>
													 &nbsp; | &nbsp;
													<a href="<?php echo @$prev_link ? site_url($prev_link) : 'javascript:;'; ?>" style="color:black;"> &lt; Prev </a>
															<?php
														}
														if (@$nth_prod < @$total_products_in_list)
														{
															if (@$nth_prod > 1)
															{ ?>
													 &nbsp;
																<?php
															}
															else
															{ ?>
													 &nbsp; | &nbsp;
																<?php
															} ?>
													<a href="<?php echo @$next_link ? site_url($next_link) : 'javascript:;'; ?>" style="color:black;"> Next &gt; </a>
															<?php
														}
													}
													else echo $this->product_details->prod_no;
													?>

												</div>

                                                    <?php
                                                } ?>

											</div>

											<div class="row">

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
															<div id="panzoom1" class=""><img src="<?php echo $img_front_thumb; ?>" style="width:100%;" /></div>
															<div id="panzoom2" class=""><img src="<?php echo $img_back_thumb; ?>" style="width:100%;" /></div>
															<div id="panzoom3" class=""><img src="<?php echo $img_side_thumb; ?>" style="width:100%;" /></div>

														</div>
														<!--<div id="panzoom4" class=""><img src="<?php echo $img_front_thumb; ?>" style="width:100%;" /></div>-->
                                                        <!--
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
															--
														</div>
                                                        -->
													</div>
													<!-- END MOBILE MAIN IMAGE AND OTHER VIEW SLIDER -->

													<!-- BEGIN DESKTOP MAIN IMAGE VIEW WITH ZOOM EFFECT -->
													<div class="product-image-cloud-zoom desktop-view hidden-xs" style="float:left;position:relative;">

														<?php
														/**********
														 * MAIN image <a> tag container with cloud-zoom
														 */
														?>
														<a href="<?php echo $img_front_large; ?>" id="zoom1" class="cloud-zoom" rel="zoomWidth:800,zoomHeight:767,adjustX:0,adjustY:0">
															<img alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>" width="100%" />
														</a>

														<?php
														/**********
														 * Other MAIN image views
														 */
														?>
														<img class="other-main-views" id="main-front-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_front_thumb; ?>" />
														<img class="other-main-views" id="main-back-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_back_thumb; ?>" />
														<img class="other-main-views" id="main-side-<?php echo $this->product_details->prod_no; ?>" src="<?php echo $img_side_thumb; ?>" />

														<?php
														/**********
														 * Available colors MAIN image views
														 */
														?>
														<?php if ($get_color_list)
														{
															foreach ($get_color_list as $color)
															{
																/**********
																 * On regular pages...
																 * To avoid duplicity, the image name must not be the same current product number
																 * To avoid showing special sale, product custom_order !== '3'
																 */
																if ($img_name !== $this->product_details->prod_no.'_'.$color->color_code)
																{
																	$this_color_image =
																		$color->image_url_path
																		? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_f.jpg'
																		: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code.'_4.jpg'
																	;
																	?>

														<img class="other-main-views" id="<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" src="<?php echo $this_color_image; ?>" />

																	<?php
																}
															}
														}
														?>

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

												<!-- BEGIN DESKTOP PRODUCT DETAILS INFO -->
												<div class="col-sm-7">

													<div class="product-details-info">

														<?php
														/**********
														 * MAIN Product Name and Style Number
														 */
														?>
														<h3 class="prod_info_title prod-title"><?php echo $this->product_details->designer_name; ?></h3>
														<h4 class="prod_info_title prod-title"><?php echo $this->product_details->prod_no; ?></h4>
														<h5 class="prod_info_title prod-title prod-subtitle prod-name"><?php echo strtoupper($this->product_details->prod_name); ?></h5>

                                                        <?php
														/**********
														 * Basix (satellite site) will not show price
														 */
														?>
                                                        <?php
                                                        if (
                                                            $this->webspace_details->slug != 'basixblacklabel'
                                                        )
                                                        { ?>

														<h5 class="prod_info_title prod-title prod-subtitle">PRICE: &nbsp;

															<?php
															/**********
															 * The PRICE
															 */

                                                            if ( $this->session->userdata('user_cat') === 'wholesale')
                                                            {
                                                                // compensating for HOW TO ORDER options['custom_order'] parameter
                                                                // as seen on second elsif statement
                                                                $hto_customer_order = '0';

                                                                /**********
                                                                 * Admin Stocks Only variable
                                                                 */
                                                                $admin_stocks_only = '0';

    															/**********
    															 * Wholeslae price
    															 */
    															$price = $this->product_details->wholesale_price; // --> wholesale price
                                                                $orig_price = $this->product_details->wholesale_price;

    															/**********
    															 * If item is on SPEICAL SALE
    															 * We stil need to show the wholesale price with strikethrough line
    															 * and get the wholesale clearance price
    															 */
    															if ($this->product_details->custom_order === '3')
                                                                {
                                                                    $price = $this->product_details->wholesale_price_clearance; // --> ws clearance price
                                                                }

                                                                if (@$this->webspace_details->options['show_product_price'] == '0')
                                                                { ?>

															<span itemprop="price">
                                                                <a href="#how-to-oder" class="how-to-oder" data-toggle="modal"> [CLICK HERE FOR PRICING] </a>
                                                            </span>

                                                                    <?php
                                                                }
                                                                else
                                                                { ?>

															<span itemprop="price" <?php echo $this->product_details->custom_order === '3' ? 'style="text-decoration:line-through;"' : ''; ?>>[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($this->product_details->wholesale_price, 2); ?></span>&nbsp;

    																<?php if ($this->product_details->custom_order === '3')
                                                                    { ?>

															&nbsp; <span itemprop="price" style="color:red;">
																[CLEARANCE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($price, 2); ?>
    															</span>

                                                                    <?php
                                                                    }
                                                                }
                                                            }
															elseif (
                                                                $this->product_details->custom_order === '3'
                                                                // cs sale price is for logged in cs or cs from how to order
                                                                // and if item is makred cs clearance only
                                                                OR $from_how_to_order == TRUE
                                                                OR (
                                                                    // logged in consumer
                                                                    // and item is admin_stocks_only
                                                                    @$this->product_details->stocks_options['admin_stocks_only'] === '1'
                                                                    && $this->session->user_loggedin == '1'
                                                                    && $this->session->user_role == 'consumer'
                                                                )
                                                            )
                                                            {
                                                                /**********
    															 * If item is on HOW TO ORDER SALE
    															 * set a variable to make the options['custom_order'] value to 3
                                                                 * for the checkout process to set correct price
                                                                 * NOTE: only if item is marked cs clearance only
    															 */
                                                                if ($from_how_to_order == TRUE)
                                                                {
                                                                    $hto_customer_order = '3';
                                                                }
                                                                else $hto_customer_order = '0';

                                                                /**********
                                                                 * Admin Stocks Only variable
                                                                 */
                                                                if (
                                                                    $from_how_to_order == TRUE
                                                                    OR (
                                                                        // logged in consumer
                                                                        // and item is admin_stocks_only
                                                                        @$this->product_details->stocks_options['admin_stocks_only'] === '1'
                                                                        && $this->session->user_loggedin == '1'
                                                                        && $this->session->user_role == 'consumer'
                                                                    )
                                                                )
                                                                {
                                                                    $admin_stocks_only = '1';
                                                                }
                                                                else $admin_stocks_only = '0';

    															/**********
    															 * Sale price
    															 *
    															 * If item is on standard sale
    															 * price is set OUR SALE PRICE (catalogue_price)
    															 */
    															$price = $this->product_details->retail_sale_price; // --> sale price
                                                                $orig_price = $this->product_details->retail_price;

    															/**********
    															 * If item is on SPEICAL SALE
    															 * We stil need to show the retail price with strikethrough line
    															 */
    															//$price = number_format($this->product_details->retail_price, 2); // --> retail price

                                                                if (@$this->webspace_details->options['show_product_price'] == '0')
                                                                { ?>

															<span itemprop="price">
                                                                <a href="#how-to-oder" class="how-to-oder" data-toggle="modal"> [CLICK HERE FOR PRICING] </a>
                                                            </span>

                                                                    <?php
                                                                }
                                                                else
                                                                { ?>

															<span itemprop="price" style="text-decoration:line-through;">
																<?php echo $this->config->item('currency').' '.number_format($this->product_details->retail_price, 2); ?>
															</span> &nbsp;
															<span itemprop="price" style="color:red;">
																[ON SALE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($price, 2); ?>
															</span>

    															    <?php
                                                                }
                                                            }
															else
                                                            {
                                                                // compensating for HOW TO ORDER options['custom_order'] parameter
                                                                // as seen on second elsif statement
                                                                $hto_customer_order = '0';

                                                                /**********
                                                                 * Admin Stocks Only variable
                                                                 */
                                                                $admin_stocks_only = '0';

    															/**********
    															 * Retail price
    															 */
    															$price = $this->product_details->retail_price; // --> retail price
                                                                $orig_price = $this->product_details->retail_price;
                                                                if (@$this->webspace_details->options['show_product_price'] == '0')
                                                                { ?>

															<span itemprop="price">
                                                                <a href="#how-to-oder" class="how-to-oder" data-toggle="modal"> [CLICK HERE FOR PRICING] </a>
                                                            </span>

                                                                    <?php
                                                                }
                                                                else
                                                                { ?>

															<span itemprop="price"><?php echo $this->config->item('currency').' '.number_format($price, 2); ?></span>

        															<?php
                                                                }
                                                            } ?>

														</h5>

                                                            <?php
                                                        }
                                                        else
                                                        { ?>

                                                            <a href="#how-to-oder" class="how-to-oder" data-toggle="modal">
                                                                CLICK FOR PRICING</a>

                                                            <?php
                                                        }?>

														<hr style="margin:10px 0 15px;" />

														<?php
														/**********
														 * Available Colors
														 */
														?>
														<div class="prdname product-form__label" style="margin: 0px 0 10px;">
															<strong> AVAILABLE COLORS: </strong>
															<span class="style1" style="margin-left:30px;">
																<?php
                                                                // use cases
                                                                // default/general pages:
                                                                // at hub, show public items only
                                                                // at sat site, public at sat_site only
                                                                // wholesale pages use product_details_wholesale
                                                                // so need to worry on that
                                                                // sales packages use product_details_sa
																$url	   = explode('/',$this->uri->uri_string());
																$uri_count = count($url)-3;

																for ($i = 0; $i < $uri_count; $i++)
																{
																	@$new_url .= $url[$i].'/';
																}

																if ($get_color_list)
																{
																	$i = 0;
																	foreach ($get_color_list as $color)
																	{
																		/* *
																		// hide items with no stocks at all
																		if ( ! $color->with_stocks)
																		{
																			$i++;
																			continue;
																		}
																		// */

                                                                        // show only public variants
                                                                        if (
                                                                            $color->new_color_publish != '0'
                                                                            && $color->new_color_publish != '2'
                                                                            && $color->new_color_publish != '3'
                                                                            && $color->color_publish != 'N'
                                                                        )
                                                                        {
    																		/**********
    																		 * On regular pages, show only regular items
    																		 */
    																		if (
    																			$this->uri->segment(1) !== 'special_sale'
    																			OR $color->custom_order !== '3'
    																		)
    																		{
    																			$id2 = $this->product_details->prod_no.'_'.$color->color_code;
    																			$java3 = "showObj('".$id2."',this)";
    																			$java4 = "closetime()";

    																			$link_txt = $this->product_details->color_code == $color->color_code ? 'style="text-decoration:underline;"' : '';

                                                                                // AND
                                                                                // show item conditions
                                                                                // 1. dont show variants with no stocks at all for item below $695
                                                                                // 2. at $695 and above, consumers get to see preorder items
                                                                                if (
                                                                                    $this->product_details->retail_price >= 695
                                                                                    OR (
                                                                                        $this->product_details->retail_price < 695
                                                                                        && $color->with_stocks != '0'
                                                                                    )
                                                                                )
                                                                                {
                                                                                    if ($i != 0) echo nbs().' | '.nbs();
    																			?>

																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).(@$url[6] ? '/'.$url[6] : '')); ?>" class="pdp--color-name" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>" data-with-stocks="<?php echo $color->with_stocks; ?>" <?php echo $link_txt; ?> data-publish="<?php echo $color->custom_order; ?>">
																	<?php echo $color->color_name; ?>
																</a>

                                                                                    <?php
                                                                                }

    																		/**********
    																		 * On special sale pages...
    																		 */
    																		}
    																		else
    																		{

    																			$id2 = $this->product_details->prod_no.'_'.$color->color_code;
    																			$java3 = "showObj('".$id2."',this)";
    																			$java4 = "closetime()";

    																			$link_txt = $this->product_details->color_code == $color->color_code ? 'txt_page_black' : 'normal_txtn';
    																			if ($i != 0) echo nbs().' | '.nbs();
    																			?>

																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).(@$url[6] ? '/'.$url[6] : '')); ?>" class="pdp--color-name <?php echo $link_txt; ?>" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>" data-publish="<?php echo $color->custom_order; ?>">
																	<?php echo $color->color_name; ?>
																</a>

                                                                                <?php
                                                                            }

                                                                            $i++;
																		}
																	}
																}
																else
																{ ?>
																	Out of Stock
																	<?php
																} ?>
															</span>
														</div>

														<!-- DOC: Apply/Remove class "hide" to show/hide element -->
														<span class="midtxt hide">[ <span class="hide-on-mobile">Mouse over color icons to view colors / </span>Click any icon to change color ]</span>

														<?php
														if ($get_color_list)
														{
															foreach ($get_color_list as $color)
															{
                                                                /* *
                                                                // hide items with no stocks at all
                                                                if ( ! $color->with_stocks)
                                                                {
                                                                    $i++;
                                                                    continue;
                                                                }
                                                                // */

                                                                // show only public variants
                                                                // AND
                                                                // show item conditions
                                                                // 1. dont show variants with no stocks at all for item below $695
                                                                // 2. at $695 and above, consumers get to see preorder items
                                                                if (
                                                                    $color->new_color_publish != '0'
                                                                    && $color->new_color_publish != '2'
                                                                    && $color->new_color_publish != '3'
                                                                    && $color->color_publish != 'N'
                                                                    //&& $color->with_stocks != '0' // show item condition
                                                                )
                                                                {
    																/**********
    																 * On regular pages, show only regular items
    																 */
    																if ($color->custom_order !== '3')
                                                                    {
        																$id3 = $this->product_details->prod_no.'_'.$color->color_code;
        																$java5 = "showObj('".$id3."',this)";
        																$java6 = "closetime()";

        																$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';

                                                                        // AND
                                                                        // show item conditions
                                                                        // 1. dont show variants with no stocks at all for item below $695
                                                                        // 2. at $695 and above, consumers get to see preorder items
                                                                        if (
                                                                            $this->product_details->retail_price >= 695
                                                                            OR (
                                                                                $this->product_details->retail_price < 695
                                                                                && $color->with_stocks != '0'
                                                                            )
                                                                        )
                                                                        {
            																echo anchor(
            																	$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).(@$url[6] ? '/'.$url[6] : ''),
            																	img(
            																		array(
            																			'src'=>(
            																				$color->image_url_path
            																				? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg'
            																				: $this->config->item('PROD_IMG_URL').$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
            																			),
            																			'width'=>'20',
            																			'alt'=>$color->color_name,
            																			'class'=>'tooltips',
            																			'data-original-title'=>$color->color_name,
            																			'style'=>$swatch_style
            																		)
            																	),
            																	array('onmouseover'=>$java5,'onmouseout'=>$java6)
            																).nbs(7);
                                                                        }
                                                                    }
    																/**********
    																 * On special sale pages...
    																 */
    																else
                                                                    {
        																$id3 = $this->product_details->prod_no.'_'.$color->color_code;
        																$java5 = "showObj('".$id3."',this)";
        																$java6 = "closetime()";

        																$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
        																echo anchor(
        																	$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).(@$url[6] ? '/'.$url[6] : ''),
        																	img(
        																		array(
        																			'src'=>(
        																				$color->image_url_path
        																				? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg'
        																				: $this->config->item('PROD_IMG_URL').$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
        																			),
        																			'width'=>'20',
        																			'alt'=>$color->color_name,
        																			'class'=>'tooltips',
        																			'data-original-title'=>$color->color_name,
        																			'style'=>$swatch_style
        																		)
        																	),
        																	array('onmouseover'=>$java5,'onmouseout'=>$java6)
        																).nbs(7);
    																}
                                                                }
															}
														}
														?>

														<hr style="margin:20px 0 10px;" />

														<?php
														/**********
														 * Size and Qty
														 */
														?>
														<div class="add-to-cart-form">

															<!--bof form========================================================================-->
															<?php echo form_open(
																'cart/add_cart',
																array(
																	'name'=>'frmCart',
																	'method'=>'POST'
																)
															); ?>

																<input type="hidden" name="wholesale_order" value="0" />
																<input type="hidden" name="package_details" value="0" />
																<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />

																<input type="hidden" name="cat_id" value="<?php echo $this->product_details->cat_id; ?>" />
																<input type="hidden" name="subcat_id" value="<?php echo $this->product_details->subcat_id; ?>" />
																<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
																<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
																<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
																<input type="hidden" name="price" value="<?php echo @$price ?: $this->product_details->retail_price; ?>" />
																<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />
                                                                <input type="hidden" name="orig_price" value="<?php echo @$orig_price; ?>" />

																<input type="hidden" name="color_code" value="<?php echo $this->product_details->color_code; ?>" />
																<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>" />
																<input type="hidden" name="label_color" value="<?php echo $this->product_details->color_name; ?>" />

                                                                <input type="hidden" name="admin_stocks_only" value="<?php echo @$admin_stocks_only ?: 0; ?>" />

																<?php
																/*
																<input type="hidden" name="prod_image" value="<?php echo $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'; ?>" />
																<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
																*/
																echo form_hidden('prod_image', $img_front);
																echo form_hidden('current_url', current_url());
																// new image url system
																echo form_hidden(
																	'prod_image_url',
																	(
																		$this->product_details->primary_img
																		? $this->product_details->media_path.$this->product_details->media_name.'_f2.jpg'
																		: ''
																	)
																);
																?>

																<input type="hidden" name="size_mode" value="<?php echo $this->product_details->size_mode; ?>" />

																<?php
																/*
																| ------------------------------------------------------------------------------------
																| Size
																*/
																?>
                                                                <?php if ($this->webspace_details->slug != 'basixblacklabel')
                                                                { ?>
																<span class="prdname product-form__label" style="margin-top:5px;"><strong>AVAILABLE SIZES:</strong> <?php echo $this->webspace_details->slug != 'basixblacklabel' ? 'Please select a size' : ''; ?></span>
                                                                    <?php
                                                                }
                                                                else
                                                                { ?>
                                                                <a href="#how-to-oder" class="how-to-oder" data-toggle="modal">
                                                                    AVAILABLE SIZES </a>
                                                                    <?php
                                                                } ?>

																<input type="hidden" id="size" name="size" value="" />

																<style>
                                                                    .product-form__list-item a:hover {
                                                                        background-color: #ccc;
                                                                    }
																</style>

                                                                <!-- Size boxes -->
																<div class="product-form__sizes  display-dependency clearfix" style="margin-bottom:5px;">
																	<ul class="list-unstyled list-inline product-form__list" style="margin-bottom:0px;">

																		<?php
                                                                        // get the color variant options
                                                                        $options = $this->product_details->stocks_options;

																		/**********
																		 * Let's get the sizes and it's availablity through stock qty
																		 * according to size mode system

																		$get_size = $this->query_category->get_size_by_mode($this->product_details->cat_id, $this->product_details->size_mode);
																		$check_stock = $this->query_product->check_stock($this->product_details->prod_no, $this->product_details->color_name);
																		 */
																		$get_size = $this->get_sizes_by_mode->get_sizes($this->product_details->size_mode);
																		$check_stock = $this->get_product_stocks->get_stocks($this->product_details->prod_no, $this->product_details->color_name);

																		if ($get_size)
																		{
																			foreach ($get_size as $size)
																			{
                                                                                // we need to set the prefix for the size lable
																				if($size->size_name == 'XS' || $size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2' || $size->size_name == 'S-M' || $size->size_name == 'M-L' || $size->size_name == 'ONE-SIZE-FITS-ALL')
																				{
																					$size_stock = 'available_s'.strtolower($size->size_name);
                                                                                    $admin_size_stock = 'admin_s'.strtolower($size->size_name);
																				}
																				else
																				{
																					$size_stock = 'available_'.$size->size_name;
                                                                                    $admin_size_stock = 'admin_'.$size->size_name;
																				}

																				if ($size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2') $hide_size_xxl_xl2 = 'style="display:none;"';
																				else $hide_size_xxl_xl2 = '';

																				if (
                                                                                    // removing other sizes not used
																					$size_stock != 'size_fs' // for size mode 1
																					&& $size_stock != 'size_ss-m' // for size mode 0
																					&& $size_stock != 'size_sm-l'
																					&& $size_stock != 'size_sone-size-fits-all'
																				)
																				{
                                                                                    // set max available stocks
                                                                                    // default is as per regular stocks only
                                                                                    // alt is when 'admin_stocks_only' is set,
                                                                                    // regulat stocks plus admin stocks
                                                                                    // but the alt is only for:
                                                                                    // logged in consumer user and from how-to-order
                                                                                    $max_available =
                                                                                        (
                                                                                            // admin_stocks_only
                                                                                            // and either from how_to_order
                                                                                            // or consumer logged in
                                                                                            @$options['admin_stocks_only'] === '1'
                                                                                            && @$check_stock[$admin_size_stock]
                                                                                            && (
                                                                                                $from_how_to_order == TRUE
                                                                                                OR (
                                                                                                    $this->session->user_loggedin == '1'
                                                                                                    && $this->session->user_role == 'consumer'
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                        ? $check_stock[$size_stock] + $check_stock[$admin_size_stock]
                                                                                        : $check_stock[$size_stock]
                                                                                    ;

                                                                                    // general stocks
                                                                                    // show only with stocks using $availability
																					//if ($check_stock[$size_stock] > 0)
                                                                                    if ($max_available > 0)
																					{
																						$a_class = 'input-control parent-select product-form__product-size instock';
																						$availability = 'availability--instock';
																					}
																					else
																					{
																						$a_class = 'input-control parent-select product-form__product-size unavailable product-form__product-size--out-of-stock';
																						$availability = 'availability--preorder';
																					}

																					if ($this->uri->segment(1) !== 'special_sale')
																					{
                                                                                        // show item conditions
                                                                                        // 1. wholesale users gets to see everything
                                                                                        // 2. consumer to see items that has stock
                                                                                        // 3. at below $695, consumer will not see preorder
                                                                                        // 3. at $695 and above, consumers get to see preorder
                                                                                        //
                                                                                        // override:
                                                                                        // only items in stock will use sale/clearance price
                                                                                        // all pre orders must use retail price
                                                                                        //
                                                                                        // 20201124 need to show preorder items
                                                                                        //if (
                                                                                        //    $availability != 'availability--preorder'
                                                                                        //    //OR $this->product_details->retail_price >= '695'
                                                                                        //)
                                                                                        //{
                                                                                            ?>

                                                                        <?php if ($this->webspace_details->slug != 'basixblacklabel')
                                                                        { ?>

                                                                        <li class="hoverable product-form__list-item" <?php echo $hide_size_xxl_xl2; ?> onmouseover="$('#<?php echo $size_stock; ?>.details.unavailable').show();$('.<?php echo $size_stock; ?>.details.admin-stocks-only').show();" onmouseout="$('#<?php echo $size_stock; ?>.details.unavailable').hide();$('.<?php echo $size_stock; ?>.details.admin-stocks-only').hide();$('span#diagonal-line-<?php echo $size_stock; ?>').show();" onclick="
    																		$('span.availability').hide();
    																		$('span.availability.<?php echo $availability; ?>').show();
    																		$('.size-qty-submit').html('<?php echo $max_available == 0 ? 'ADD TO BAG (AS PRE ORDER)' : 'ADD TO BAG'; ?>');
    																		$('input#size').val('<?php echo $size->size_name; ?>');
                                                                            $('input[name=\'qty\']').val('1');
    																		$('input[name=\'qty\']').attr('max', '<?php echo $max_available ?: '30'; ?>');
                                                                            $('input[name=\'qty\']').trigger('touchspin.updatesettings', {max:'<?php echo $max_available ?: '30'; ?>'});
    																		$('input[name=\'custom_order\']').val('<?php echo $max_available == 0 ? '1' : (($hto_customer_order OR $admin_stocks_only) ? '3' : $this->product_details->custom_order); ?>');
    																		$('.hoverable.product-form__list-item').css('background-color','transparent');
    																		$(this).css('background-color','#ccc');
    																	">

                                                                            <?php if ($this->session->userdata('user_cat') == 'wholesale')
                                                                            { ?>

                                                                            <span class="tooltips" data-original-title="Available Stock" style="display:inline-block;float:right;position:relative;top:7px;color:red;margin-left:7px;">
                                                                                ( <?php echo $max_available; ?> )
                                                                            </span>

                                                                                <?php
                                                                            } ?>

    																		<a href="javascript:void();" class="<?php echo $a_class; ?>" style="z-index:10;">
    																			<span><?php echo $size->size_name; ?></span>
    																		</a>
    																		<span class="ico"></span>

    																		<?php
    																		if ($max_available == 0):

    																			if ($this->product_details->d_folder === 'junnieleigh')
    																			{
    																				$product_stock_status = '5-12';
    																			}
    																		?>

    																		<span id="diagonal-line-<?php echo $size_stock; ?>" class="diagonal-line"></span>
    																		<span id="<?php echo $size_stock; ?>" class="details unavailable" style="text-align:left;color:red;">
    																			<span class="pointer"></span>
    																			Pre-Order<br />
    																			Size Not In-Stock<br />
    																			Delivery is <?php echo @$product_stock_status ? $product_stock_status : '14-16'; ?> Weeks<br />
    																			From Order Date
    																		</span>

    																		<?php endif; ?>

    																	</li>

                                                                            <?php
                                                                        }
                                                                        else
                                                                        { ?>

                                                                        <li class="hoverable product-form__list-item basix-only" <?php echo $hide_size_xxl_xl2; ?>>
																			<a href="#how-to-oder" class="<?php echo $a_class; ?>" data-toggle="modal" style="z-index:10;">
																				<span><?php echo $size->size_name; ?></span>
																			</a>
																			<span class="ico"></span>
																		</li>

                                                                            <?php
                                                                        } ?>

                                                                                            <?php
                                                                                        //}
																					}
																				}
																			}
																		} else echo 'No available sizes';
																		?>

																	</ul>

																	<?php
																	/**********
                                                                     * This is set to product's custom order value whic is either (0-default, 3-onsale)
																	 * Script on click of size box changes this to 1 for pre-order sizes
																	 */
																	?>
																	<input type="hidden" id="custom_order-<?php echo $this->product_details->color_code; ?>" name="custom_order" value="<?php echo @($hto_customer_order OR $admin_stocks_only) ? '3' : $this->product_details->custom_order; ?>" />

																</div>

																<?php
																/*
																| ------------------------------------------------------------------------------------
																| Quantity
																*/
																?>
                                                                <?php
                                                                if (
                                                                    $this->webspace_details->slug != 'basixblacklabel'
                                                                )
                                                                { ?>

                                                                <span class="key  product-form__label  product-form__label--alt  uppercase"><strong>SELECT QUANTITY:</strong></span>
																<div class="product-form__qty" style="width:100px;margin-bottom:25px;">
																	<input id="touchspin_5" type="text" value="0" name="qty" class="center text-center" required="required" />
																</div>

                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    echo '<br /><br /><br /><br /><br /><br />';
                                                                } ?>

																<?php
																/*
																| ------------------------------------------------------------------------------------
																| Availability
																*/
																?>
																<!-- DOC: Apply/Remove class "hide" to show/hide element -->
																<div class="product-form__label hide" style="margin:10px 0 0;height:51.45px;">
																	<strong>AVAILABILITY:</strong>
																	<br class="hidden-on-desktop"/>
																	<span class="availability availability--default">
																		SELECT YOUR SIZE FOR SHIPPING AVAILABILITY
																	</span>
																	<span class="availability availability--instock" style="display:none;">
																		SHIPS WITHIN 5-7 BUSINESS DAYS
																	</span>
																	<span class="availability availability--preorder" style="display:none;color:red;">
																		Item ships approximately 14-16 weeks from date of order
																	</span>
																	<br class="hidden-on-desktop"/>
																	<span class="availability" style="color:red;">[We ship globally]</span>
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

																<?php if ($this->webspace_details->options['site_type'] === 'sat_site') { ?>
																<a href="#how-to-oder" class="btn dark btn-block how-to-oder" data-toggle="modal">HOW TO ORDER</a>
																<?php } else { ?>
																<button type="submit" class="btn dark btn-block size-qty-submit" onclick="return checkSizeQty();">ADD TO BAG</button>
																<?php } ?>
                                                                <!--
                                                                <button type="button" class="btn btn-default btn-block add-to-favorites-submit hide"><i class="icon icon-heart"></i> ADD TO FAVORITES</button>
                                                                -->

																<script>
																function checkSizeQty(){
																	var size = document.getElementById('size').value;
																	var qty = document.getElementById('touchspin_5').value;
																	if (size == ''){
																		alert('Please select a size.');
																		return false;
																	}
																	if (qty == 0){
																		alert('Quantity must be more than 1.');
																		return false;
																	}
																	return true;
																}
																</script>

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

																		<p> <?php echo $this->product_details->prod_desc; ?> </p>

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

																		<img src="<?php echo base_url('images/designer_icon/thumb/'.$this->product_details->size_chart); ?>" style="width:100%;" />

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
														?>
														<div class="other-views hidden-xs hidden-sm" style="position:absolute;bottom:0px;">

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_front_large; ?>' class="cloud-zoom-gallery" title="Front view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_front_thumb; ?>'" onmouseover="showObj('main-front-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_front; ?>" alt="Front View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_back_large; ?>' class="cloud-zoom-gallery" title="Back view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_back_thumb; ?>'" onmouseover="showObj('main-back-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_back; ?>" alt="Back View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
																<a href='<?php echo $img_side_large; ?>' class="cloud-zoom-gallery" title="Side view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_side_thumb; ?>'" onmouseover="showObj('main-side-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
																	<img src="<?php echo $img_side; ?>" alt="Side View" style="border:1px solid #333;width:60px;height:auto;" onerror="$(this).closest('div').hide();" />
																</a>
															</div>

															<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;" onmouseover="showObj('main-video-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#zoom1').append('<video width=\'425\' height=\'637.5\' id=\'the-product_video\' style=\'border:1px solid #333;background:black;display:inline;position:absolute;top:0px;\' autoplay loop ><source src=\'<?php echo $img_video_mp4; ?>\' type=\'video/mp4\'>Your browser does not support the video tag.</video>');">
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
															<div class="modal-header hide">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Order Inquiry Form</h4>
															</div>
															<div class="modal-body">

                            									<?php
                            									$pass_data = array(
                            										'image' => $img_front_3,
                            										'img_inquiry' => $img_inquiry,
                                                                    'img_front_large' => $img_front_large,
                            										'return_url' => $this->uri->uri_string(),
                            										'prod_no' => $this->product_details->prod_no,
                            										'color_code' => $this->product_details->color_code
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
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
