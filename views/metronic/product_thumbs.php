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

													<?php if ( ! @$search_result)
													{ ?>

													<!-- BEGIN DESKTOP THUMBS BREADCRUMBS AND PAGINATION -->
                                                    <div class="m-grid produc-thumbs-filter hidden-xs clearfix" style="padding:12px 10px 15px;">

                                                        <!-- BEGIN PAGINATION -->
                                                        <div style="float:right;">
                                                            <?php $pagination = $this->pagination->create_links(); ?>
                                                            <?php echo $pagination; ?>
                                                        </div>
                                                        <!-- END PAGINATION -->

                                                        <!-- BEGIN BREADCRUMBS -->
    													<ul class="page-breadcrumb breadcrumb breadcrumb-thumbs" style="margin-left:0px;">
    														<?php
    														/**********
    														 * Process URL segments
    														 */
    														if (@$url_segs)
    														{
    															$d_link = '';
    															foreach ($url_segs as $key => $segment)
    															{
                                                                    // get current segment's name
                                                                    if (@$this->browse_by == 'sidebar_browse_by_designer' && $key == 2)
                                                                    {
                                                                        $d_name = $this->designers_list->get_des_name(array('url_structure'=>$segment));
                                                                    }
                                                                    else
                                                                    {
                                                                        $d_name = $this->categories_tree->get_name($segment);
                                                                    }

    																// store segment for the link
    																$d_link .= '/'.$segment;
    																$d_link = ltrim($d_link, '/');
    																// check if last segment
    																$d_last = $key == count($url_segs) ? TRUE : FALSE;

    																if ($key == 1) continue; // skips on first segment 'shop/'
    																?>

    														<li>
    															<?php echo $d_last ? '' : '<a href="'.site_url($d_link).'">'; ?>
    																<?php echo $d_last ? '' : '<strong>'; ?>
    																	<?php echo $d_name; ?>
    																<?php echo $d_last ? '' : '</strong>'; ?>
    															<?php echo $d_last ? '' : '</a>'; ?>
    															<?php echo $d_last ? '' : '<i class="fa fa-angle-right"></i>'; ?>
    														</li>
    																<?php
    															}
    														} ?>

    													</ul>
                                                        <!-- END BREADCRUMBS -->

                                                    </div>
													<!-- END DESKTOP THUMBS BREADCRUMBS AND PAGINATION -->
														<?php
													} ?>

													<!-- BEGIN PAGE SECTION HEADING -->
													<?php if (@$search_result)
                                                    { ?>

													<h3 class="text-center" style="margin:30px auto 10px;"> SEARCH RESULTS FOR "<?php echo $search_string; ?>" </h3>

                                                        <?php
                                                    }
                                                    else
                                                    { ?>

													<h3 class="text-center hidden-xs hide" style="margin:10px auto 10px;"> <?php echo strtoupper($this->category_details->category_name); ?> </h3>
													<h3 class="hidden-sm hidden-md hidden-lg hide" style="margin:15px auto 0px 18px;"> <?php echo strtoupper($this->category_details->category_name); ?> </h3>

                                                        <?php
                                                    } ?>
													<!-- END PAGE SECTION HEADING -->

													<!-- BEGIN DESKTOP PRODUCT FILTER -->
                                                    <!-- DOC: hiding this old filter system temporarity - for depracation --
													<div class="produc-thumbs-filter hidden-xs clearfix hide" style="padding:12px 20px 15px;">
                                                        <?php //if ( ! @$search_result) $this->load->view('metronic/product_thumbs_filter'); ?>
													</div>
                                                    -->

                                                    <?php if (@$this->filter_items_count > 0)
                                                    { ?>
                                                    <div class="row hidden-xs">
                                                        <div class="col-md-12" style="padding-left:25px;padding-right:25px;">
                                                            <a href="<?php echo site_url($this->uri->uri_string()); ?>" class="btn red-flamingo pull-right">RESET - CLEAR FILTERS</a>
                                                        </div>
                                                    </div>
                                                        <?php
                                                    } ?>

                                                    <div class="m-grid produc-thumbs-filter hidden-xs clearfix" style="padding:10px 10px 15px;">
                                                        <div class="m-grid-row">

                                                                <?php
                                                                // set dropdown background color here as universal item
                                                                $bg_color = 'background:#2f353b;color:white;';

                                                                if (@$size_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET" data-desc="size-top-desktop">

                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="size" value="<?php echo @$_GET['size']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['size'] ? $bg_color : ''; ?>" id="size-filter-desktop-top" <?php echo @$_GET['size'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['size']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>SIZE</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($size_array as $size)
                                                                            {
                                                                                if (@$_GET['size'] && $_GET['size'] == $size)
                                                                                {
                                                                                    $size_selected = 'selected="selected"';
                                                                                }
                                                                                else $size_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $size; ?>" <?php echo $size_selected; ?>><?php echo 'Size '.$size; ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if (@$styles_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="style" value="<?php echo @$_GET['style']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['style'] ? $bg_color : ''; ?>" id="style-filter-desktop-top" <?php echo @$_GET['style'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['style']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>STYLING</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($styles_array as $style)
                                                                            {
                                                                                if (@$_GET['style'] && $_GET['style'] == $style)
                                                                                {
                                                                                    $style_selected = 'selected="selected"';
                                                                                }
                                                                                else $style_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $style; ?>" <?php echo $style_selected; ?>><?php echo ucfirst($style); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="price" value="<?php echo @$_GET['price']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['price'] ? $bg_color : ''; ?>" id="price-filter-desktop-top" <?php echo @$_GET['price'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['price']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>PRICE</option>
                                                                            <?php } ?>

                                                                            <option value="asc" <?php echo @$_GET['price'] == 'asc' ? 'selected': '';?>>
                                                                                Low - High
                                                                            </option>
                                                                            <option value="desc" <?php echo @$_GET['price'] == 'desc' ? 'selected': '';?>>
                                                                                High - Low
                                                                            </option>
                                                                            <option value="default">
                                                                                Default
                                                                            </option>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>

                                                                <?php
                                                                if (@$color_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="color" value="<?php echo @$_GET['color']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['color'] ? $bg_color : ''; ?>" id="color-filter-desktop-top" <?php echo @$_GET['color'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['color']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>COLOR</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($color_array as $color)
                                                                            {
                                                                                if (@$_GET['color'] && $_GET['color'] == $color)
                                                                                {
                                                                                    $color_selected = 'selected="selected"';
                                                                                }
                                                                                else $color_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $color; ?>" <?php echo $color_selected; ?>><?php echo ucfirst($color); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if (@$occassion_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="occassion" value="<?php echo @$_GET['occassion']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['occassion'] ? $bg_color : ''; ?>" id="occassion-filter-desktop-top" <?php echo @$_GET['occassion'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['occassion']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>OCCASSION</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($occassion_array as $occassion)
                                                                            {
                                                                                if (@$_GET['occassion'] && $_GET['occassion'] == $occassion)
                                                                                {
                                                                                    $occassion_selected = 'selected="selected"';
                                                                                }
                                                                                else $occassion_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $occassion; ?>" <?php echo $occassion_selected; ?>><?php echo ucfirst($occassion); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                            <div class="m-grid-col m-grid-col-left">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="availability" value="<?php echo @$_GET['availability']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['availability'] ? $bg_color : ''; ?>" id="availability-filter-desktop-top" <?php echo @$_GET['availability'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['availability']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>AVAILABILITY</option>
                                                                            <?php } ?>

                                                                            <option value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'selected': '';?>>
                                                                                In Stock
                                                                            </option>
                                                                            <option value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'selected': '';?> class="hide">
                                                                                Pre Order
                                                                            </option>

                                                                            <option value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'selected': '';?>>
                                                                                On Sale
                                                                            </option>

                                                                        </select>

                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
													<!-- END DESKTOP PRODUCT FILTER -->

													<!-- BEGIN PRODUCT THUMBS Portlet PORTLET -->
													<div class="portlet light" style="margin-bottom:0px;padding-bottom:0px;">

														<div class="portlet-body">

															<!-- BEGIN DESKTOP THUMBS PAGE TOP UTILITIES SECTION -->
                                                            <!-- DOC: hiding this old sort and pagination temporarity - for depracation -->
															<div class="thumbs-utilities desktop hidden-xs clearfix hide">

																<!-- BEGIN Form ==============================================================-->
																<?php echo form_open(
																	'shop/sort_by',
																	array(
																		'id' => 'form-select-sort_by'
																	)
																); ?>

																	<input type="hidden" name="uri_string" value="<?php echo $this->uri->uri_string(); ?>" />
																	<label class="control-label">Sort By</label>
																	<select class="bs-select form-control input-small input-sm select-sort_by" name="sort_by" data-show-subtext="true">
																		<?php if (@$search_result) echo '<option class="font-size-12" value="">Bast Match</option>'; ?>
																		<option class="font-size-12" value="default" <?php echo $this->session->sort_by == 'default' ? 'selected' : ''; ?>>
																			Default</option>
																		<option class="font-size-12 hide" value="featured" <?php echo $this->session->sort_by == 'featured' ? 'selected' : ''; ?> disabled data-subtext="Not yet available">
																			Featured</option>
																		<option class="font-size-12 hide" value="best_sellers" <?php echo $this->session->sort_by == 'best_sellers' ? 'selected' : ''; ?> disabled data-subtext="Not yet available">
																			Best Sellers</option>
																		<option class="font-size-12 hide" value="top_rated" <?php echo $this->session->sort_by == 'top_rated' ? 'selected' : ''; ?> disabled data-subtext="Not yet available">
																			Top Rated</option>
																		<option class="font-size-12" value="newest" <?php echo $this->session->sort_by == 'newest' ? 'selected' : ''; ?>>
																			Newest</option>
																		<option class="font-size-12" value="low-high" <?php echo $this->session->sort_by == 'low-high' ? 'selected' : ''; ?>>
																			Price: Low to High</option>
																		<option class="font-size-12" value="high-low" <?php echo $this->session->sort_by == 'high-low' ? 'selected' : ''; ?>>
																			Price: High to Low</option>
																		<option class="font-size-12" value="onsale" <?php echo $this->session->sort_by == 'onsale' ? 'selected' : ''; ?>>
																			Sale First</option>
																	</select>

																	<div class="tools">
																		<ul class="list-inline thumbs-utilities-info" style="display:inline-block;">
																			<li>
																				<?php echo number_format($this->products_list->count_all); ?> &nbsp; Items
																			</li>
																			<li><span class="separator"></span></li>
																			<li>
																				View
																				<?php if (
																					$this->products_list->count_all < $this->session->view_list_number
																					OR $this->products_list->count_all < 99
																				)
																				{
																					echo 'ALL';
																				}
																				else
																				{ ?>
																				&nbsp; <?php echo $this->session->view_list_number == 33 ? '' : '<a href="'.site_url('shop/view_by/index/33').'" style="color:black;">33</a>'; ?>
																				&nbsp; <?php echo $this->session->view_list_number == 66 ? '' : '<a href="'.site_url('shop/view_by/index/66').'" style="color:black;">66</a>'; ?>
																				&nbsp; <?php echo $this->session->view_list_number ? '<a href="'.site_url('shop/view_by/index/99').'" style="color:black;">99</a>' : ''; ?>
																					<?php
																				} ?>
																			</li>
																			<li><span class="separator"></span></li>
																			<li>
																				<?php echo $this->num ?: 1; ?> &nbsp; of &nbsp; <?php echo ceil($this->products_list->count_all / 99); ?>
																			</li>
																			<li><span class="separator"></span></li>
																		</ul>
																		&nbsp;
																		<?php echo $this->products_list->count_all > $this->webspace_details->options['items_per_page'] ? $this->pagination->create_links() : ''; ?>
																	</div>

																</form>
																<!-- END Form ==============================================================-->

															</div>
															<!-- END DESKTOP THUMBS PAGE TOP UTILITIES SECTION -->

															<!-- BEGIN MOBILE THUMBS PAGE TOP UTILITIES FILTER/SORT SECTION -->
															<div class="thumbs-utilities mobile hidden-sm hidden-md hidden-lg clearfix">

                                                                <style>
                                                                .mobile-thumbs-pagination .pagination li a {
                                                                    padding: 3px 10px;
                                                                    margin-left: 5px;
                                                                }
                                                                </style>

																<div class="mobile-thumbs-pagination thumbs-count-all margin-bottom-10 text-center">
                                                                    <?php echo $this->products_list->count_all > $this->webspace_details->options['items_per_page'] ? $this->pagination->create_links() : ''; ?>
                                                                    <!--
																	<?php echo number_format($this->products_list->count_all); ?> &nbsp; Items
                                                                    -->
																</div>

                                                                <?php if (@$this->filter_items_count > 0)
                                                                { ?>
                                                                <div class="row hidden-xshidden-sm hidden-md hidden-lg margin-bottom-10">
                                                                    <div class="col-md-12">
                                                                        <a href="<?php echo site_url($this->uri->uri_string()); ?>" class="btn red-flamingo pull-right" style="font-size:12px;">RESET - CLEAR FILTERS.</a>
                                                                    </div>
                                                                </div>
                                                                    <?php
                                                                } ?>

																<div class="mobile-filter-sort-buttons m-grid" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

																	<div class="m-grid-row">
																		<div class="m-grid-col m-grid-col-left m-grid-col-xs-6" style="padding-right:7px;">

																			<div class="form-group hide">
																				<a href="#modal-mobile-filter" class="btn dark btn-block" data-toggle="modal" style="border:3px solid black;">
																					FILTER <?php echo @$this->filter_items_count ? '('.@$this->filter_items_count.')' : ''; ?>
																				</a>
																			</div>

                                                                            <?php
                                                                            // set dropdown background color here as universal item
                                                                            $bg_color = 'background:#2f353b;color:white;';

                                                                            if (@$size_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="size" value="<?php echo @$_GET['size']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['size'] ? $bg_color : ''; ?>" id="size-filter-mobile-top">

                                                                                        <?php if (@$_GET['size']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>SIZE</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($size_array as $size)
                                    													{
                                    														if (@$_GET['size'] && $_GET['size'] == $size)
                                    														{
                                    															$size_selected = 'selected="selected"';
                                    														}
                                    														else $size_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $size; ?>" <?php echo $size_selected; ?>><?php echo 'Size '.$size; ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <?php
                                                                            if (@$styles_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="style" value="<?php echo @$_GET['style']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['style'] ? $bg_color : ''; ?>" id="style-filter-mobile-top">

                                                                                        <?php if (@$_GET['style']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>STYLING</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($styles_array as $style)
                                    													{
                                                                                            if (@$_GET['style'] && $_GET['style'] == $style)
                                    														{
                                    															$style_selected = 'selected="selected"';
                                    														}
                                    														else $style_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $style; ?>" <?php echo $style_selected; ?>><?php echo ucfirst($style); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="price" value="<?php echo @$_GET['price']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['price'] ? $bg_color : ''; ?>" id="price-filter-mobile-top">

                                                                                        <?php if (@$_GET['price']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>PRICE</option>
                                                                                        <?php } ?>

                                                                                        <option value="asc" <?php echo @$_GET['price'] == 'asc' ? 'selected': '';?>>
                            																Low - High
                            															</option>
                            															<option value="desc" <?php echo @$_GET['price'] == 'desc' ? 'selected': '';?>>
                            																High - Low
                            															</option>
                            															<option value="default">
                            																Default
                            															</option>

                                                                                    </select>

                                                                                </form>

                                                                            </div>

																		</div>
																		<div class="m-grid-col m-grid-col-right m-grid-col-xs-6" style="padding-left:7px;">

																			<div class="form-group hide">
																				<a href="#modal-mobile-sort" class="btn btn-default btn-block" data-toggle="modal" style="border:3px solid black;">
																					SORT <?php echo ($this->session->sort_by && $this->session->sort_by !== 'default') ? '(1)' : ''; ?>
																				</a>
																			</div>

                                                                            <?php
                                                                            if (@$color_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="color" value="<?php echo @$_GET['color']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['color'] ? $bg_color : ''; ?>" id="color-filter-mobile-top">

                                                                                        <?php if (@$_GET['color']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>COLOR</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($color_array as $color)
                                    													{
                                    														if (@$_GET['color'] && $_GET['color'] == $color)
                                    														{
                                    															$color_selected = 'selected="selected"';
                                    														}
                                    														else $color_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $color; ?>" <?php echo $color_selected; ?>><?php echo ucfirst($color); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <?php
                                                                            if (@$occassion_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="occassion" value="<?php echo @$_GET['occassion']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['occassion'] ? $bg_color : ''; ?>" id="occassion-filter-mobile-top">

                                                                                        <?php if (@$_GET['occassion']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>OCCASSION</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($occassion_array as $occassion)
                                    													{
                                    														if (@$_GET['occassion'] && $_GET['occassion'] == $occassion)
                                    														{
                                    															$occassion_selected = 'selected="selected"';
                                    														}
                                    														else $occassion_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $occassion; ?>" <?php echo $occassion_selected; ?>><?php echo ucfirst($occassion); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="availability" value="<?php echo @$_GET['availability']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['availability'] ? $bg_color : ''; ?>" id="availability-filter-mobile-top">

                                                                                        <?php if (@$_GET['availability']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>AVAILABILITY</option>
                                                                                        <?php } ?>

                                                                                        <option value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'selected': '';?>>
                            																In Stock
                            															</option>
                            															<option value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'selected': '';?> class="hide">
                            																Pre Order
                            															</option>
                                                                                        <option value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'selected': '';?>>
                            																On Sale
                            															</option>

                                                                                    </select>

                                                                                </form>

                                                                            </div>

																		</div>
																	</div>
																</div>
															</div>
															<!-- END MOBILE THUMBS PAGE TOP UTILITIES FILTER/SORT SECTION -->

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
																				if ($ipadding > 1) echo '</div> <!-- class="row" -->';
																				echo '<div class="row">';
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
																				if ($ipadding > 1) echo '</div> <!-- class="row" -->';
																				echo '<div class="row">';
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

																<div class="col col-center col-xs-6 col-sm-4 wrapper_thumbs" style="<?php echo $wrapper_thumbs; ?>">

																	<!-- image <?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?> -->
																	<!-- link <?php echo site_url($seg); ?> -->
																	<div class="container-thumbs" style="width:100%;height:auto;position:relative;">

																		<a class="" href="<?php echo site_url($seg); ?>">

																			<img src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" width="100%" />

																			<?php if ($this->agent->is_mobile())
																			{ ?>

																			<img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>');" style="position:absolute;left:0px;top:0px;" width="100%" />

																				<?php
																			}
																			else
																			{ ?>

																			<img class="primary-img" src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" data-src="<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>');" style="position:absolute;left:0px;top:0px;" width="100%" />
																			<img class="alt-image alt-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>" data-src="<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php //echo $thumb->prod_name; ?>" style="position:absolute;left:0px;top:0px;" width="100%" />

																				<?php
																				/**********
																				 * Iterating through available colors in order to load other colors
																				 * product thumbs for swatch mouse over effect
																				 */
																				if ($colors)
																				{
																					foreach($colors as $color)
																					{
																						if ($color->color_code != $thumb->primary_img_id)
																						{
																							// set image paths
																							$sub_img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_front/thumbs/';
																							$sub_img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_back/thumbs/';
																							$sub_color_icon_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_coloricon/';
																							// the image filename
																							$sub_image = $thumb->prod_no.'_'.$color->color_code.'_3.jpg';
																							// the item coloricon / swatch
																							$sub_color_icon = $thumb->prod_no.'_'.$color->color_code.'.jpg';

																							// the new image url system
																							$sub_img_front_new = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_f3.jpg';
																							$sub_img_back_new = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_b3.jpg';
																							$sub_img_coloricon = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg';

																							$sub_seg = (($this->uri->segment(1) === 'special_sale') ? 'special_sale/' : 'shop/details/').$thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($thumb->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
																							?>

																			<img class="other-view-image alt-image-<?php echo $thumb->prod_no.'_'.$color->color_code; ?>" src="<?php echo $color->image_url_path ? $sub_img_front_new : $sub_img_front_pre.$sub_image; ?>" alt="<?php echo $thumb->prod_name; ?>" id="<?php echo $thumb->prod_no.'_'.$color->color_code; ?>" style="display:none;position:absolute;top:0;left:0;" width="100%" />

																						<?php
																						}
																					}
																				}
																			} ?>

																		</a>

																		<div class="caption text-center margin-bottom-10">

                                                                            <?php
																			/**********
																			 * PROD NO
                                                                             * PRICE
																			 */
																			?>
																			<p style="margin:8px 0px;font-size:0.8em;">
                                                                                <a class="" href="<?php echo site_url($seg); ?>">
                                                                                    <span style="font-size:1.2em;">
                                                                                        <?php echo $thumb->prod_name; ?>
                                                                                    </span>
                                                                                </a>
																				<br />

																				<?php echo $thumb->prod_no; ?>
																				<br />

																				<?php
                                                                                if (
                                                                                    $this->webspace_details->options['site_type'] == 'hub_site'
                                                                                    OR $this->session->user_role == 'wholesale'
                                                                                )
                                                                                {
    																				$price_class =
    																					@$this->webspace_details->options['show_product_price'] == '1'
    																					? ''
    																					: 'hidden'
    																				;
    																				?>

																				<span class="<?php echo $price_class; ?>" itemprop="price" <?php echo $thumb->custom_order === '3' ? 'style="text-decoration:line-through;"' : '';?>>
																					<!--&#36;<span>5</span>70.00-->
																					<?php
																					/**********
																					 * Wholeslae price
																					 */
																					if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($thumb->wholesale_price, 2);
																					/**********
																					 * Retail price
																					 */
																					else $price = number_format($thumb->less_discount, 2);
																					echo $this->config->item('currency').$price;
																					?>
																				</span>

                                                                                    <?php if ($thumb->custom_order === '3')
                                                                                    { ?>

																				<br />
																				<span class="<?php echo $price_class; ?>" itemprop="price" style="color:red;">
																					<?php
																					/**********
																					 * Wholeslae price clearance
																					 */
																					if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($thumb->wholesale_price_clearance, 2);
																					/**********
																					 * On Sale price consumer
																					 */
																					else $price = number_format($thumb->catalogue_price, 2);
																					echo $this->config->item('currency').$price;
																					?>
																				</span>

                                                                                        <?php
                                                                                    }
                                                                                } ?>

																			</p>

																			<?php
																			/**********
																			 * COLORICONS
																			 */
																			?>
																			<ul class="swatches list-unstyled clearfix">

																				<!-- MAIN COLOR -->
																				<li class="swatch active" style="display:inline;padding-right:7px;">
																					<a class="swatch-link parent-select acctive" href="<?php echo site_url($seg); ?>" title="<?php echo ucfirst(strtolower(trim($thumb->color_name))); ?>">
																						<img class="swatch-image margin-bottom-10" src="<?php echo ($thumb->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="20px">
																					</a>
																				</li>

																					<?php
																					if ($colors)
																					{
																						foreach($colors as $color)
																						{
																							if (
																								@$_GET['availability'] == 'preorder' && $color->with_stocks > 0
																								OR @$_GET['availability'] == 'instock' && $color->with_stocks == 0
																								OR @$_GET['availability'] == 'onsale' && $color->custom_order != '3'
																							)
																							{
																								continue;
																							}

																							if (
																								$color->color_code != $thumb->color_code
																							)
																							{
																								// the item coloricon / swatch
																								$sub_color_icon = $thumb->prod_no.'_'.$color->color_code.'.jpg';
																								// new image url system
																								$sub_img_coloricon = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg';

																								$sub_seg =
																									'shop/details/'
																									. $thumb->d_url_structure . '/'
																									. $thumb->prod_no. '/'
																									. str_replace(' ','-',strtolower(trim($color->color_name))). '/'
																									. str_replace(' ','-',strtolower(trim($thumb->prod_name))). '/'
																									. $prod_qry_row_no.'of'.$this->products_list->count_all
																								;
																								?>

																				<li class="swatch" style="display:inline;padding-right:7px;">
																					<a class="swatch-link parent-select" href="<?php echo site_url($sub_seg); ?>" title="<?php echo ucfirst(strtolower(trim($color->color_name))); ?>">
																						<img class="swatch-image margin-bottom-10" src="<?php echo ($color->image_url_path ? $sub_img_coloricon : $color_icon_pre.$sub_color_icon); ?>" onmouseover="$('#<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').show();" onmouseout="$('#<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').hide();" width="20px">
																					</a>
																				</li>

																							<?php
																							}
																						}
																					}
																					?>
																			</ul>

																		</div>

																	</div>

																</div>

                                                                            <?php
                                                                        }

																		// need to close the m-grid-row in case $ipadding is not exacting to
																		// the number of columns
																		if ($ipadding == $this->products_list->row_count) echo '</div> <!-- class="row" -->';

																		$prod_qry_row_no++;
																		$ipadding++;
																	}
																}
																?>

															</div>
															<!-- END THUMBS WRAPPER CONTAINER -->

															<!-- BEGIN DESKTOP THUMBS PAGE BOTTOM UTILITIES SECTION -->
                                                            <!-- DOC: hiding this old sort and pagination temporarity - for depracation -->
															<div class="thumbs-utilities desktop thumbs-utilities-info margin-top-30 hidden-xs clearfix hide">

																<div class="tools">
																	<ul class="list-inline thumbs-utilities-info" style="display:inline-block;">
																		<li>
																			<?php echo number_format($this->products_list->count_all); ?> &nbsp; Items
																		</li>
																		<li><span class="separator"></span></li>
																		<li>
																			View
																			<?php if (
																				$this->products_list->count_all < $this->session->view_list_number
																				OR $this->products_list->count_all < 99
																			)
																			{
																				echo 'ALL';
																			}
																			else
																			{ ?>
																			&nbsp; <?php echo $this->session->view_list_number == 33 ? '' : '<a href="'.site_url('shop/view_by/index/33').'" style="color:black;">33</a>'; ?>
																			&nbsp; <?php echo $this->session->view_list_number == 66 ? '' : '<a href="'.site_url('shop/view_by/index/66').'" style="color:black;">66</a>'; ?>
																			&nbsp; <?php echo $this->session->view_list_number ? '<a href="'.site_url('shop/view_by/index/99').'" style="color:black;">99</a>' : ''; ?>
																				<?php
																			} ?>
																		</li>
																		<li><span class="separator"></span></li>
																		<li>
																			<?php echo $this->num ?: 1; ?> &nbsp; of &nbsp; <?php echo ceil($this->products_list->count_all / 99); ?>
																		</li>
																		<li><span class="separator"></span></li>
																	</ul>
																	&nbsp;
																	<?php echo $this->products_list->count_all > $this->webspace_details->options['items_per_page'] ? $this->pagination->create_links() : ''; ?>
																</div>
															</div>
                                                            <!-- END DESKTOP THUMBS PAGE TOP UTILITIES SECTION -->

															<!-- BEGIN MOBILE THUMBS PAGE BOTTOM UTILITIES PAGINATION/NEXT SECTION -->
															<div class="thumbs-utilities margin-top-30 hidden-sm hidden-md hidden-lg clearfix">

																<div class="mobile-filter-sort-buttons m-grid" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

																	<div class="m-grid-row">
																		<div class="m-grid-col m-grid-col-left m-grid-col-xs-6" style="padding-right:7px;">

																			<div class="form-group hide">
																				<a href="#modal-mobile-filter" class="btn dark btn-block" data-toggle="modal" style="border:3px solid black;">
																					FILTER <?php echo @$this->filter_items_count ? '('.@$this->filter_items_count.')' : ''; ?>
																				</a>
																			</div>

                                                                            <?php
                                                                            // set dropdown background color here as universal item
                                                                            $bg_color = 'background:#2f353b;color:white;';

                                                                            if (@$size_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="size" value="<?php echo @$_GET['size']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['size'] ? $bg_color : ''; ?>" id="size-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['size']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>SIZE</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($size_array as $size)
                                    													{
                                    														if (@$_GET['size'] && $_GET['size'] == $size)
                                    														{
                                    															$size_selected = 'selected="selected"';
                                    														}
                                    														else $size_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $size; ?>" <?php echo $size_selected; ?>><?php echo 'Size '.$size; ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <?php
                                                                            if (@$styles_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="style" value="<?php echo @$_GET['style']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['style'] ? $bg_color : ''; ?>" id="style-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['style']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>STYLING</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($styles_array as $style)
                                    													{
                                                                                            if (@$_GET['style'] && $_GET['style'] == $style)
                                    														{
                                    															$style_selected = 'selected="selected"';
                                    														}
                                    														else $style_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $style; ?>" <?php echo $style_selected; ?>><?php echo ucfirst($style); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="price" value="<?php echo @$_GET['price']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['price'] ? $bg_color : ''; ?>" id="price-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['price']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>PRICE</option>
                                                                                        <?php } ?>

                                                                                        <option value="asc" <?php echo @$_GET['price'] == 'asc' ? 'selected': '';?>>
                            																Low - High
                            															</option>
                            															<option value="desc" <?php echo @$_GET['price'] == 'desc' ? 'selected': '';?>>
                            																High - Low
                            															</option>
                            															<option value="default">
                            																Default
                            															</option>

                                                                                    </select>

                                                                                </form>

                                                                            </div>

																		</div>
																		<div class="m-grid-col m-grid-col-right m-grid-col-xs-6" style="padding-left:7px;">

																			<div class="form-group hide">
																				<a href="#modal-mobile-sort" class="btn btn-default btn-block" data-toggle="modal" style="border:3px solid black;">
																					SORT <?php echo ($this->session->sort_by && $this->session->sort_by !== 'default') ? '(1)' : ''; ?>
																				</a>
																			</div>

                                                                            <?php
                                                                            if (@$color_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="color" value="<?php echo @$_GET['color']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['color'] ? $bg_color : ''; ?>" id="color-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['color']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>COLOR</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($color_array as $color)
                                    													{
                                    														if (@$_GET['color'] && $_GET['color'] == $color)
                                    														{
                                    															$color_selected = 'selected="selected"';
                                    														}
                                    														else $color_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $color; ?>" <?php echo $color_selected; ?>><?php echo ucfirst($color); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <?php
                                                                            if (@$occassion_array)
                                                                            { ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                        											<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="occassion" value="<?php echo @$_GET['occassion']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['occassion'] ? $bg_color : ''; ?>" id="occassion-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['occassion']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>OCCASSION</option>
                                                                                        <?php } ?>

                                                                                        <?php
                                    													foreach($occassion_array as $occassion)
                                    													{
                                    														if (@$_GET['occassion'] && $_GET['occassion'] == $occassion)
                                    														{
                                    															$occassion_selected = 'selected="selected"';
                                    														}
                                    														else $occassion_selected = '';
                                    														?>

                                                                                        <option value="<?php echo $occassion; ?>" <?php echo $occassion_selected; ?>><?php echo ucfirst($occassion); ?></option>

                                                                                            <?php
                                        												} ?>

                                                                                    </select>

                                                                                </form>

                                                                            </div>
                                                                                <?php
                                                                            } ?>
                                                                            <div class="form-group mobile-thumbs-filter">

                                                                                <form action="" method="GET">

                                                                                    <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                        											<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                        											<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                        											<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                        											<?php endif; ?>
                                                                                    <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                        											<input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                        											<?php endif; ?>
                                        											<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                        											<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                        											<?php endif; ?>

                                                                                    <input type="hidden" class="this-filter" name="availability" value="<?php echo @$_GET['availability']; ?>" />

                                                                                    <select class="form-control input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['availability'] ? $bg_color : ''; ?>" id="availability-filter-mobile-bottom">

                                                                                        <?php if (@$_GET['availability']) { ?>
                                                                                        <option value="all">All</option>
                                                                                        <?php } else { ?>
                                                                                        <option>AVAILABILITY</option>
                                                                                        <?php } ?>

                                                                                        <option value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'selected': '';?>>
                            																In Stock
                            															</option>
                            															<option value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'selected': '';?> class="hide">
                            																Pre Order
                            															</option>
                                                                                        <option value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'selected': '';?>>
                            																On Sale
                            															</option>

                                                                                    </select>

                                                                                </form>

                                                                            </div>

																		</div>
																	</div>
																</div>

                                                                <div class="mobile-thumbs-pagination thumbs-count-all margin-top-10 margin-bottom-10 text-center">
                                                                    <?php echo $this->products_list->count_all > $this->webspace_details->options['items_per_page'] ? $this->pagination->create_links() : ''; ?>
                                                                    <!--
																	<?php echo number_format($this->products_list->count_all); ?> &nbsp; Items
                                                                    -->
																</div>

                                                                <!-- HIDING this old pagination temporarily - for depracation
																<?php echo $this->num ?: 1; ?> &nbsp; of &nbsp; <?php echo ceil($this->products_list->count_all / 99); ?> &nbsp;
																<?php
																if (ceil($this->products_list->count_all / 99) > 1)
																{
																	if ($this->num > 1)
																	{
																		echo '<a href="'.site_url(implode('/', $url_segs).'/'.($this->num - 1)).'" class="btn btn-default"> &lt; Prev </a> &nbsp; ';
																	}
																	if ($this->num < ceil($this->products_list->count_all / 99))
																	{
																		echo '<a href="'.site_url(implode('/', $url_segs).'/'.($this->num + 1)).'" class="btn btn-default"> Next &gt; </a>';
																	}
																}
																?>
                                                                -->
															</div>
                                                            <!-- END MOBILE THUMBS PAGE BOTTOM UTILITIES PAGINATION/NEXT SECTION -->

														</div>

													</div>
													<!-- END PRODUCT THUMBS Portlet PORTLET -->

                                                    <!-- BEGIN DESKTOP PRODUCT FILTER -->
                                                    <div class="m-grid produc-thumbs-filter hidden-xs clearfix" style="padding:15px 10px 5px;">
                                                        <div class="m-grid-row">

                                                                <?php
                                                                // set dropdown background color here as universal item
                                                                $bg_color = 'background:#2f353b;color:white;';

                                                                if (@$size_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="size" value="<?php echo @$_GET['size']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['size'] ? $bg_color : ''; ?>" id="size-filter-desktop-bottom" <?php echo @$_GET['size'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['size']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>SIZE</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($size_array as $size)
                                                                            {
                                                                                if (@$_GET['size'] && $_GET['size'] == $size)
                                                                                {
                                                                                    $size_selected = 'selected="selected"';
                                                                                }
                                                                                else $size_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $size; ?>" <?php echo $size_selected; ?>><?php echo 'Size '.$size; ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if (@$styles_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="style" value="<?php echo @$_GET['style']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['style'] ? $bg_color : ''; ?>" id="style-filter-desktop-bottom" <?php echo @$_GET['style'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['style']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>STYLING</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($styles_array as $style)
                                                                            {
                                                                                if (@$_GET['style'] && $_GET['style'] == $style)
                                                                                {
                                                                                    $style_selected = 'selected="selected"';
                                                                                }
                                                                                else $style_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $style; ?>" <?php echo $style_selected; ?>><?php echo ucfirst($style); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="price" value="<?php echo @$_GET['price']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['price'] ? $bg_color : ''; ?>" id="price-filter-desktop-bottom" <?php echo @$_GET['price'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['price']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>PRICE</option>
                                                                            <?php } ?>

                                                                            <option value="asc" <?php echo @$_GET['price'] == 'asc' ? 'selected': '';?>>
                                                                                Low - High
                                                                            </option>
                                                                            <option value="desc" <?php echo @$_GET['price'] == 'desc' ? 'selected': '';?>>
                                                                                High - Low
                                                                            </option>
                                                                            <option value="default">
                                                                                Default
                                                                            </option>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>

                                                                <?php
                                                                if (@$color_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="color" value="<?php echo @$_GET['color']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['color'] ? $bg_color : ''; ?>" id="color-filter-desktop-bottom" <?php echo @$_GET['color'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['color']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>COLOR</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($color_array as $color)
                                                                            {
                                                                                if (@$_GET['color'] && $_GET['color'] == $color)
                                                                                {
                                                                                    $color_selected = 'selected="selected"';
                                                                                }
                                                                                else $color_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $color; ?>" <?php echo $color_selected; ?>><?php echo ucfirst($color); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if (@$occassion_array)
                                                                { ?>
                                                            <div class="m-grid-col m-grid-col-left" style="padding-right:7px;">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
                                                                        <input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="occassion" value="<?php echo @$_GET['occassion']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['occassion'] ? $bg_color : ''; ?>" id="occassion-filter-desktop-bottom" <?php echo @$_GET['occassion'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['occassion']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>OCCASSION</option>
                                                                            <?php } ?>

                                                                            <?php
                                                                            foreach($occassion_array as $occassion)
                                                                            {
                                                                                if (@$_GET['occassion'] && $_GET['occassion'] == $occassion)
                                                                                {
                                                                                    $occassion_selected = 'selected="selected"';
                                                                                }
                                                                                else $occassion_selected = '';
                                                                                ?>

                                                                            <option value="<?php echo $occassion; ?>" <?php echo $occassion_selected; ?>><?php echo ucfirst($occassion); ?></option>

                                                                                <?php
                                                                            } ?>

                                                                        </select>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                                    <?php
                                                                } ?>

                                                            <div class="m-grid-col m-grid-col-left">
                                                                <div class="form-group mobile-thumbs-filter">

                                                                    <form action="" method="GET">

                                                                        <?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
                                                                        <input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
                                                                        <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
                                                                        <input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['occassion'] AND $_GET['occassion'] !== 'all'): ?>
                                                                        <input type="hidden" name="occassion" value="<?php echo $_GET['occassion']; ?>" />
                                                                        <?php endif; ?>
                                                                        <?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
                                                                        <?php endif; ?>

                                                                        <input type="hidden" class="this-filter" name="availability" value="<?php echo @$_GET['availability']; ?>" />

                                                                        <select class="form-control bs-select input-sm select-mobile-thumbs-filter" style="<?php echo @$_GET['availability'] ? $bg_color : ''; ?>" id="availability-filter-desktop-bottom" <?php echo @$_GET['availability'] ? 'data-style="btn dark"' : ''; ?>>

                                                                            <?php if (@$_GET['availability']) { ?>
                                                                            <option value="all">All</option>
                                                                            <?php } else { ?>
                                                                            <option>AVAILABILITY</option>
                                                                            <?php } ?>

                                                                            <option value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'selected': '';?>>
                                                                                In Stock
                                                                            </option>
                                                                            <option value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'selected': '';?> class="hide">
                                                                                Pre Order
                                                                            </option>
                                                                            <option value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'selected': '';?>>
                                                                                On Sale
                                                                            </option>

                                                                        </select>

                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
													<!-- END DESKTOP PRODUCT FILTER -->

                                                    <?php if ( ! @$search_result)
													{ ?>

													<!-- BEGIN DESKTOP THUMBS BOTTOM PAGINATION -->
                                                    <div class="m-grid produc-thumbs-filter hidden-xs clearfix" style="padding:5px 10px 10px;">

                                                        <!-- BEGIN PAGINATION -->
                                                        <div style="float:right;">
                                                            <?php echo $pagination; ?>
                                                        </div>
                                                        <!-- END PAGINATION -->

                                                    </div>
													<!-- END DESKTOP THUMBS BOTTOM PAGINATION -->
														<?php
													} ?>

												</div>
												<!-- END THUMBS BODY -->
											</div>
											<!-- /.m-grid-row -->
										</div>
										<!-- /.m-grid -->

                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
