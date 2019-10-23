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

												<div class="col-xs-12 margin-bottom-20">
													<?php if ( ! @$search_result)
													{ ?>

													<!-- BEGIN THUMBS BREADCRUMBS -->
													<ul class="page-breadcrumb breadcrumb breadcrumb-thumbs margin-bottom-10" style="padding-right:20px;display:inline-block;">

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
																<?php echo $d_last ? '' : '<strong>'; ?>
																	<?php echo $d_name; ?>
																<?php echo $d_last ? '' : '</strong>'; ?>
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

														</div>.
														<!--<div id="panzoom4" class=""><img src="<?php echo $img_front_thumb; ?>" style="width:100%;" /></div>-->
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
																		? $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_f3.jpg'
																		: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code.'_3.jpg'
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
														<h5 class="prod_info_title prod-title prod-subtitle prod-name" style="<?php echo $this->session->userdata('user_cat') === 'wholesale' ? 'margin:5px 0;' : ''; ?>"><?php echo strtoupper($this->product_details->prod_name); ?></h5>
														<h5 class="prod_info_title prod-title prod-subtitle">PRICE: &nbsp;

															<?php
															/**********
															 * The PRICE
															 */

                                                            if ( $this->session->userdata('user_cat') === 'wholesale')
                                                            {
    															/**********
    															 * Wholeslae price
    															 */
    															$price = $this->product_details->wholesale_price; // --> wholesale price

    															/**********
    															 * If item is on SPEICAL SALE
    															 * We stil need to show the wholesale price with strikethrough line
    															 * and get the wholesale clearance price
    															 */
    															if ($this->product_details->custom_order === '3')
    															$price = $this->product_details->wholesale_price_clearance; // --> retail price

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
															elseif ($this->product_details->custom_order === '3')
                                                            {
    															/**********
    															 * Sale price
    															 *
    															 * If item is on standard sale
    															 * price is set OUR SALE PRICE (catalogue_price)
    															 */
    															$price = $this->product_details->retail_sale_price; // --> sale price

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
    															/**********
    															 * Retail price
    															 */
    															$price = $this->product_details->retail_price; // --> retail price
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
																//$url 	   = explode('/',get_full_breadcrumb_url());
																$url	   = explode('/',$this->uri->uri_string());
																$uri_count = count($url)-3;

																for ($i = 0; $i < $uri_count; $i++)
																{
																	@$new_url .= $url[$i].'/';
																}

																///if ($get_color_list->num_rows() > 0)
																if ($get_color_list)
																{
																	$i = 0;
																	//foreach ($get_color_list->result() as $color)
																	foreach ($get_color_list as $color)
																	{
																		/*
																		// hide items with no stocks at all
																		if ( ! $color->with_stocks)
																		{
																			$i++;
																			continue;
																		}
																		*/

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
																			if ($i != 0) echo nbs().' | '.nbs();
																			?>

																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).'/'.$url[6]); ?>" class="pdp--color-name tooltips" data-original-title="<?php echo $color->color_name; ?>" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>" data-with-stocks="<?php echo $color->with_stocks; ?>" <?php echo $link_txt; ?>>
																	<?php echo $color->color_name; ?>
																</a>

																			<?php
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

																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).'/'.$url[6]); ?>" class="pdp--color-name tooltips <?php echo $link_txt; ?>" data-original-title="<?php echo $color->color_name; ?>" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>">
																	<?php echo $color->color_name; ?>
																</a>

																			<?php
																		}

																		$i++;
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
														/**********
														 * Coloricons
														 */
														?>
														<?php
														if ($get_color_list)
														{
															//foreach ($get_color_list->result() as $color)
															foreach ($get_color_list as $color)
															{
																/**********
																 * On regular pages, show only regular items
																 */
																if ($color->custom_order !== '3'):

																$id3 = $this->product_details->prod_no.'_'.$color->color_code;
																$java5 = "showObj('".$id3."',this)";
																$java6 = "closetime()";

																$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
																echo anchor(
																	$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).'/'.$url[6],
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

																/**********
																 * On special sale pages...
																 */
																else:

																$id3 = $this->product_details->prod_no.'_'.$color->color_code;
																$java5 = "showObj('".$id3."',this)";
																$java6 = "closetime()";

																$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
																echo anchor(
																	$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)).'/'.$url[6],
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

																endif;
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
																'cart/add_cart/wholesale',
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
																<input type="hidden" name="price" value="<?php echo $price; ?>" />
																<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />

																<input type="hidden" name="color_code" value="<?php echo $this->product_details->color_code; ?>" />
																<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>" />
																<input type="hidden" name="label_color" value="<?php echo $this->product_details->color_name; ?>" />

                                                                <input type="hidden" name="prod_image" value="<?php echo $img_front; ?>" />
																<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />

																<?php
																// new image url system
																echo form_hidden(
																	'prod_image_url',
																	(
																		$this->product_details->primary_img
																		? $this->product_details->media_path.$this->product_details->media_name.'_f1.jpg'
																		: ''
																	)
																);
																?>

																<input type="hidden" name="size_mode" value="<?php echo $this->product_details->size_mode; ?>" />

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
                                                                    $count = count($size_names);
                                                                    $skey = 1;
                                                                    foreach ($size_names as $size_label => $size)
                                                                    {
                                                                        if (
                                                                            $size != 'XXL'
                                                                            && $size != 'XL1'
                                                                            && $size != 'XL2'
                                                                        )
                                                                        {
                                                                            if (
                                                                                $skey == 1
                                                                                OR $skey == 5
                                                                                OR $skey == 9
                                                                            )
                                                                            {
                                                                                if ($skey == 5 OR $skey == 9) echo '</div>';
                                                                                echo '
                                                                                <div class="col-md-4">

                                                                                    <div class="row '.(($skey == 4 OR $skey == 8) ? 'hidden-xs hidden-sm' : '').'">
                                                                                        <div class="col-xs-4">
                                                                                            <strong>SIZES:</strong>
                                                                                        </div>
                                                                                        <div class="col-xs-8">
                                                                                            QUANITY:
                                                                                        </div>
                                                                                    </div>
                                                                                ';
                                                                            }

                                                                            $qty = $this->product_details->$size_label;

                                                                            if ($size_label == 'size_ssm') $size_class = 's_sm';
                                                                            elseif ($size_label == 'size_sml') $size_class = 's_ml';
                                                                            elseif ($size_label == 'size_sprepack1221') $size_class = 's_prepak';
                                                                            elseif ($size_label == 'size_sonesizefitsall') $size_class = 's_onesize';
                                                                            else $size_class = '';

                                                                            if ($size_label == 'size_sprepack1221') $size_html = 'PRE<br />PACK';
                                                                            elseif ($size_label == 'size_sonesizefitsall') $size_html = 'ONE<br />SIZE';
                                                                            else $size_html = $size;
                                                                            ?>

                                                                        <div class="row" onmouseover="$(this).find('span.details.unavailable').show();" onmouseout="$(this).find('span.details.unavailable').hide();">

                                                                            <?php
                    														/**********
                    														 * Size Col
                    														 */
                    														?>
                                                                            <div class="col-xs-4">
                                                                                <div class="hoverable product-form__list-item">
                                                                                    <a href="javascript:void();" class="input-control parent-select product-form__product-size unavailable product-form__product-size--out-of-stock product_details-size_box <?php echo $size_class; ?>" style="z-index:10;" data-size_key="<?php echo $skey; ?>" data-dsize="<?php echo $size; ?>" data-available_qty="<?php echo $qty ?: 30; ?>">
        																				<span>
                                                                                            <?php echo $size_html; ?>
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
                                                                        }

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

																<?php if ($this->webspace_details->options['site_type'] === 'sat_site') { ?>
																<a href="#how-to-oder" class="btn dark btn-block how-to-oder" data-toggle="modal">HOW TO ORDER</a>
																<?php } else { ?>
																<button type="submit" class="btn dark btn-block size-qty-submit-wholesale">ADD TO INQUIRY</button>
																<?php } ?>

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

												<!-- DELETE ITEM -->
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
