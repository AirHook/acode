                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<?php
										/***********
										 *	Notifications
										 */
										?>
										<div class="notifcations">

											<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
											<div class="alert alert-danger auto-remove">
												<strong>Ooops!</strong>&nbsp; Something went wrong. Please try again.
											</div>
											<?php } ?>

                                            <?php if ($this->session->flashdata('flashMsg') == 'zero_search_result') { ?>
                                            <div class="note note-warning">
    											Search did not find anything. Please try searching from all products.
    										</div>
    										<?php } ?>

										</div>

										<div class="m-grid">
											<div class="m-grid-row">

												<?php
												/**********
												 * SIDEBAR
												 */
												?>
												<!-- BEGIN PRODUCT THUMBS SIDEBAR -->
												<div class="m-grid-col m-grid-col-md-2 bg-white hidden-xs hidden-sm">

													<?php $this->load->view('metronic/product_thumbs_sidebar'); ?>

												</div>
												<!-- END PRODUCT THUMBS SIDEBAR -->

												<?php
												/**********
												 * THUMBS BODY
												 */
												?>
												<!-- BEGIN THUMBS BODY -->
												<div class="m-grid-col m-grid-col-md-10 m-grid-col-xs-12 bg-white">

													<hr class="hidden-xs" style="margin:30px 0 0;border-color:transparent;" />

													<!-- BEGIN PRODUCT THUMBS Portlet PORTLET -->
													<div class="portlet light" style="margin-bottom:0px;padding-bottom:0px;">

														<div class="portlet-body">

															<!-- BEGIN THUMBS WRAPPER CONTAINER -->
															<div class="browse_thumbs clearfix" data-count_all="<?php echo $this->products_list->count_all; ?>" data-items_per_page="<?php echo @$this->webspace_details->options['items_per_page']; ?>" data-row_count="<?php echo $this->products_list->row_count; ?>" data-thumbs_uri_string="<?php echo $this->session->thumbs_uri_string; ?>">

																<?php
																if (@$this->suggested_products)
																{ ?>
																<div class="note note-warning">
																	<p> We didn't find any products from your query. However, you may want to look at the following suggestions. </p>
																</div>
																	<?php
																} ?>

																<?php
																if ($this->products_list->row_count > 0)
																{ ?>

																	<?php
																	/**********
																	 * The THUMB with hover effect
																	 */
																	?>
																	<?php
																	$ipadding = 1; // padding settings & product query row#
																	$multiplier = $this->session->view_list_number ?: 99;
																	$prod_qry_row_no = $this->num > 1 ? ((($this->num - 1) * $multiplier) + 1) : $this->num;
																	$i_prod_no = 0; // prod_no check
																	foreach ($view_pane_sql as $thumb)
																	{
																		$subcat_name = $thumb->subcat_name;

                                                                        // some show item conditions
                                                                        // by default, wholesale users are not allowed to see
                                                                        // CLEARANCE or ON SALE items
                                                                        $show_item = TRUE;

																		if (@$grouped_products) // -> from Shop_Controller class
																		{
																			// since thumbs are grouped by prod_no, we can now query available colors for
																			// swatches and hover effect
																			//$colors = $this->query_category->get_available_colors($thumb->prod_no, '0');
																			$this->product_details->initialize(array('tbl_product.prod_no'=>$thumb->prod_no));
																			$colors = $this->product_details->available_colors();

																			// let store current prod_no and check it with next current prod_no
																			// if the same, continue with the loop
																			if ($i_prod_no >= 1 && $temp_prod_no == $thumb->prod_no) continue;
																			else $i_prod_no = 0;

																			if ($i_prod_no == 0)
																			{
																				$temp_prod_no = $thumb->prod_no;
																			}
																			$i_prod_no++;
																		}
																		else $colors = FALSE;

																		// set image paths
																		// old folder structure system (for depracation)
                                                                        $pre_url =
            																$this->config->item('PROD_IMG_URL')
            																.'product_assets/WMANSAPREL/'
            																.$this->product_details->d_url_structure.'/'
            																.$this->product_details->sc_url_structure
            															;
            															$img_front_pre = $pre_url.'/product_front/thumbs/';
            															$img_back_pre = $pre_url.'/product_back/thumbs/';
            															$img_side_pre = $pre_url.'/product_side/thumbs/';
                                                                        $color_icon_pre = $pre_url.'/product_coloricon//';
																		// the image filename
                                                                        // the old ways dependent on category and folder structure
                                                                        $image = $thumb->prod_no.'_'.$thumb->color_code.'_3.jpg';
                                                                        $color_icon = $thumb->prod_no.'_'.$thumb->color_code.'.jpg';
            															// the new way relating records with media library
            															$new_pre_url = $this->config->item('PROD_IMG_URL').$thumb->media_path.$thumb->media_name;
            															$img_front_new = $new_pre_url.'_f.jpg';
            															$img_back_new = $new_pre_url.'_b.jpg';
            															$img_side_new = $new_pre_url.'_s.jpg';
                                                                        $img_linesheet = $new_pre_url.'_linesheet.jpg';
                                                                        $img_coloricon = $new_pre_url.'_c.jpg';

																		// set the product details link
																		$seg =
																			'shop/details/'
																			.$thumb->d_url_structure . '/'
																			. $thumb->prod_no. '/'
																			. str_replace(' ','-',strtolower(trim($thumb->color_name))). '/'
																			. str_replace(' ','-',strtolower(trim(($thumb->prod_name ?: $thumb->prod_no)))). '/'
																			. $prod_qry_row_no.'of'.$this->products_list->count_all
																		;

																		// in the beginning
																		//if ($ipadding == 1) echo '<div class="m-grid-row">';

																		// some container css styles fixes for left most and right most image for desktop view
																		if ( ! $this->agent->is_mobile())
																		{
																			// middle thumbs
																			//$wrapper_thumbs = 'padding-left:7px;padding-right:7px;';
                                                                            $wrapper_thumbs = 'padding-left:5px;padding-right:5px;';
																			// left thumbs
																			if (fmod($ipadding, 3) == 1)
																			{
																				//$wrapper_thumbs = 'padding-right:7px;';
                                                                                $wrapper_thumbs = 'padding-right:5px;';
																				//echo '<div class="cleafix"></div>';
																				//if ($ipadding > 1) echo '</div> <!-- class="row" -->';
																				//echo '<div class="row">';
																			}
																			// right thumbs
																			if (fmod($ipadding, 3) == 0)
																			{
																				//$wrapper_thumbs = 'padding-left:7px;';
                                                                                $wrapper_thumbs = 'padding-left:5px;';
																			}

																			// overriding wrapper_thumbs for desktop view
																			$wrapper_thumbs = '';
                                                                            $wrapper_thumbs = 'padding-left:7px;padding-right:7px;';
                                                                            $mobile = 'not-mobile';
																		}
																		else
																		{
                                                                            if ($this->agent->mobile())
                                                                            $thumbs_per_row = $this->agent->mobile() == 'iPad' ? '3' : '2';
																			$wrapper_thumbs = '';

																			if (fmod($ipadding, $thumbs_per_row) == 1) // left thumbs
																			{
																				$wrapper_thumbs = 'padding-left:0px;padding-right:7px;';
																				//echo '<div class="cleafix"></div>';
																				//if ($ipadding > 1) echo '</div> <!-- class="row" -->';
																				//echo '<div class="row">';
																			}
																			elseif (fmod($ipadding, $thumbs_per_row) == 0) // right thumbs
																			{
																				$wrapper_thumbs = 'padding-left:7px;padding-right:0px;';
																			}
                                                                            else
                                                                            {
                                                                                $wrapper_thumbs = 'padding-left:4px;padding-right:3px;';
                                                                            }

                                                                            $mobile = 'is-mobile';
																		}

                                                                        if ($show_item)
                                                                        { ?>

                                                                <div class="row">

                                                                    <div class="col-xs-12" style="padding-left:7px;">
                                                                        <h3> <?php echo $thumb->prod_no.' '.$thumb->color_name; ?> </h3>
                                                                    </div>

                                                                    <?php
    																/**********
    																 * Thumb Wrapper .wrapper_thumbs
    																 */
    																?>
                                                                    <div class="col col-center col-xs-4 mt-element-ribbon" style="margin-bottom:0px;<?php echo $wrapper_thumbs; ?>">

                                                                        <?php
    																	/**********
    																	 * Ribbon
    																	 */
    																	?>
                                                                        <div class="ribbon ribbon-right uppercase" style="background-color:black;color:white;">
                                                                            <a href="<?php echo $img_front_new; ?>" download style="color:white;text-decoration:none;">
                                                                                <i class="fa fa-download"></i> Download
                                                                            </a>
                                                                        </div>

                                                                        <?php
    																	/**********
    																	 * Thumb Container
    																	 */
    																	?>
    																	<!-- image <?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?> -->
    																	<!-- link <?php echo site_url($seg); ?> -->
    																	<div class="container-thumbs" style="width:100%;height:auto;position:relative;">

																			<img src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" width="100%" />

                                                                            <img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>');" style="position:absolute;left:0px;top:0px;" width="100%" />

    																	</div>

    																</div>

                                                                    <div class="col col-center col-xs-4 mt-element-ribbon" style="margin-bottom:0px;<?php echo $wrapper_thumbs; ?>">

                                                                        <?php
    																	/**********
    																	 * Ribbon
    																	 */
    																	?>
                                                                        <div class="ribbon ribbon-right uppercase" style="background-color:black;color:white;">
                                                                            <a href="<?php echo $img_side_new; ?>" download style="color:white;text-decoration:none;">
                                                                                <i class="fa fa-download"></i> Download
                                                                            </a>
                                                                        </div>

                                                                        <?php
    																	/**********
    																	 * Thumb Container
    																	 */
    																	?>
    																	<!-- image <?php echo $thumb->primary_img ? $img_side_new : $img_side_pre.$image; ?> -->
    																	<!-- link <?php echo site_url($seg); ?> -->
    																	<div class="container-thumbs" style="width:100%;height:auto;position:relative;">

																			<img src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" width="100%" />

                                                                            <img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $thumb->primary_img ? $img_side_new : $img_side_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>');" style="position:absolute;left:0px;top:0px;" width="100%" />

    																	</div>

    																</div>

                                                                    <div class="col col-center col-xs-4 mt-element-ribbon" style="margin-bottom:0px;<?php echo $wrapper_thumbs; ?>">

                                                                        <?php
    																	/**********
    																	 * Ribbon
    																	 */
    																	?>
                                                                        <div class="ribbon ribbon-right uppercase" style="background-color:black;color:white;">
                                                                            <a href="<?php echo $img_back_new; ?>" download style="color:white;text-decoration:none;">
                                                                                <i class="fa fa-download"></i> Download
                                                                            </a>
                                                                        </div>

                                                                        <?php
    																	/**********
    																	 * Thumb Container
    																	 */
    																	?>
    																	<!-- image <?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?> -->
    																	<!-- link <?php echo site_url($seg); ?> -->
    																	<div class="container-thumbs" style="width:100%;height:auto;position:relative;">

																			<img src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" width="100%" />

                                                                            <img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>');" style="position:absolute;left:0px;top:0px;" width="100%" />

    																	</div>

    																</div>

                                                                    <div class="col col-center col-xs-12 mt-element-ribbon" style="<?php echo $wrapper_thumbs; ?>">

                                                                        <?php
    																	/**********
    																	 * Ribbon
    																	 */
    																	?>
                                                                        <div class="ribbon ribbon-right uppercase" style="background-color:black;color:white;top:60px;">
                                                                            <a href="<?php echo $img_linesheet; ?>" download style="color:white;text-decoration:none;">
                                                                                <i class="fa fa-download"></i> Download
                                                                            </a>
                                                                        </div>

                                                                        <?php
    																	/**********
    																	 * Thumb Container
    																	 */
    																	?>
    																	<div class="container-thumbs" style="width:100%;height:auto;position:relative;top:-50px;">

                                                                            <img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $img_linesheet; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $img_linesheet; ?>');" width="100%" />

    																	</div>

    																</div>

                                                                </div>
                                                                            <?php
                                                                        }

																		// need to close the m-grid-row in case $ipadding is not exacting to
																		// the number of columns
																		//if ($ipadding == $this->products_list->row_count) echo '</div> <!-- class="row" -->';

																		$prod_qry_row_no++;
																		$ipadding++;
																	}
																}
																?>

															</div>
															<!-- END THUMBS WRAPPER CONTAINER -->

														</div>

													</div>
													<!-- END PRODUCT THUMBS Portlet PORTLET -->

												</div>
												<!-- END THUMBS BODY -->
											</div>
											<!-- /.m-grid-row -->
										</div>
										<!-- /.m-grid -->

                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
