                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

                                        <?php
										/***********
										 *	Notifications
										 */
										?>
                                        <div class="notifcations">
                                            <?php if ($this->session->flashdata('error') == 'sales_package_invalid_link') { ?>
											<div class="alert alert-danger">
												The link is not valid.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
											<div class="alert alert-danger auto-remove">
												<strong>Ooops!</strong>&nbsp; Something went wrong. Please try again.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'without_stocks') { ?>
											<div class="alert alert-danger auto-remove">
												<strong>Ooops!</strong>&nbsp; Hmmm... The product seems to be not available at this time.
											</div>
											<?php } ?>
                                        </div>

                                        <div class="portfolio-content portfolio-3 margin-top-30">

                                            <?php
    										/***********
    										 *	Portfolio Grid Nav // currently hidden
    										 */
    										?>
											<!-- DOC: Apply/remove class "hide" to show/hide element -->
                                            <div class="clearfix hide">
												<!-- DOC: Apply/remove class "hide" to show/hide element -->
                                                <div id="js-filters-lightbox-gallery1" class="cbp-l-filters-dropdown cbp-l-filters-dropdown-floated hide">
                                                    <div class="cbp-l-filters-dropdownWrap border-grey-salsa">
                                                        <div class="cbp-l-filters-dropdownHeader uppercase">Sort Gallery</div>
                                                        <div class="cbp-l-filters-dropdownList">
                                                            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item uppercase"> All (
                                                                <div class="cbp-filter-counter"></div> items) </div>
                                                            <div data-filter=".identity" class="cbp-filter-item uppercase"> Identity (
                                                                <div class="cbp-filter-counter"></div> items) </div>
                                                            <div data-filter=".web-design" class="cbp-filter-item uppercase"> Web Design (
                                                                <div class="cbp-filter-counter"></div> items) </div>
                                                            <div data-filter=".print" class="cbp-filter-item uppercase"> Print (
                                                                <div class="cbp-filter-counter"></div> items) </div>
                                                        </div>
                                                    </div>
                                                </div>

												<!-- DOC: Apply/remove class "hide" to show/hide element -->
                                                <div id="js-filters-lightbox-gallery2" class="cbp-l-filters-button cbp-l-filters-left hide">
                                                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">All</div>

													<?php
													$des_ary = array();
													foreach ($designers as $designer)
													{
														if (
															(
																$designer->url_structure !== 'instylenewyork'
																OR $designer->url_structure !== 'shop7thavenue'
															)
															&& $designer->with_products == '1'
														)
														{ ?>

                                                    <div data-filter=".<?php echo $designer->url_structure; ?>" class="cbp-filter-item btn dark btn-outline uppercase"><?php echo $designer->designer; ?></div>
															<?php
															array_push($des_ary, $designer->des_id);
														}
													} ?>

													<!-- DOC: for reference purposes...
                                                    <div data-filter=".graphic" class="cbp-filter-item btn blue btn-outline uppercase">Graphic</div>
                                                    <div data-filter=".logos" class="cbp-filter-item btn blue btn-outline uppercase">Logo</div>
                                                    <div data-filter=".motion" class="cbp-filter-item btn blue btn-outline uppercase">Motion</div>
													-->
                                                </div>
                                            </div>

                                            <?php
    										/***********
    										 *	Portfolio Grid
    										 */
    										?>
                                            <div id="js-grid-lightbox-gallery" class="cbp">

												<?php
												$cbp_a_link = array();
												$ic = 1;
												foreach ($categories as $category)
												{
													// let's get the correct icon image
													// grab linked designers and respective icon images and descriptions
													$ld = json_decode($category->d_url_structure , TRUE);
													$linked_designers =
														json_last_error() === JSON_ERROR_NONE
														? $ld
														: explode(',', $category->d_url_structure)
													;
													$ii = json_decode($category->icon_image , TRUE);
													$icon_images =
														json_last_error() === JSON_ERROR_NONE
														? $ii
														:	explode(',', $category->icon_image)
													;
													$desc = json_decode($category->description , TRUE);
													$descriptions =
														json_last_error() === JSON_ERROR_NONE
														? $desc
														: explode('|', $category->description)
													;

													// get the designer key index if not hub sites
													if (
														@$this->webspace_details->options['site_type'] != 'hub_site'
													)
													{
														$key = array_search($this->webspace_details->slug, $linked_designers) + 1;

														// get the pertinent info
														@$image = array_key_exists($key, $icon_images) ? $icon_images[$key] : $icon_images[$this->webspace_details->slug];
														@$description = array_key_exists($key, $descriptions) ? $descriptions[$key] : $descriptions[$this->webspace_details->slug];
													}
													else
													{
														// key index 0 is the item for general designers
														@$image = array_key_exists(0, $icon_images) ? $icon_images[0] : $icon_images['general'];
														@$description = array_key_exists(0, $descriptions) ? $descriptions[0] : $descriptions['general'];
													}

													// get category linked designer slugs
													$slugs = $this->categories_tree->get_linked_designers($category->category_id, $des_ary);

													// for links, let do first row...
													if ($ic == 1)
													{
														// create link
														$li_a_link = array($category->category_slug);
													}

													// if same category level, close previous </li> and open another one
													if ($category->category_level == @$prev_level)
													{
														// create new link
														$pop = array_pop($li_a_link);
														array_push($li_a_link, $category->category_slug);
													}

													// NOTE: next greater level is always greater by only 1 level
													// if so, create new open list <ul>
													if ($category->category_level == @$prev_level + 1)
													{
														// append to previous link
														array_push($li_a_link, $category->category_slug);
													}

													// if next category level is lower, close previous </li></ul> and open another one
													// dont forget to count the depth of levels
													if ($category->category_level < @$prev_level)
													{
														for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
														{
															//echo '</li></ul>';

															// update link
															$pop = array_pop($li_a_link);
														}

														// append to link
														array_push($li_a_link, $category->category_slug);
													}

													if (
														$category->with_products > 0
														&& (
															$category->category_level != '0'
															&& $category->category_level != '1'
														)
													)
													{ ?>

                                                <div class="cbp-item <?php echo @implode(' ', @$slugs); ?> clearfix" style="height:345px;">
                                                    <a href="<?php echo site_url('shop/'.implode('/', $li_a_link)); ?>" class="cbp-caption cbp-singlePageInline_" data-title="<?php echo $category->category_name; ?><br><?php echo $description; ?>" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
                                                            <img src="<?php echo $image ? $this->config->slash_item('PROD_IMG_URL').'images/subcategory_icon/thumb/'.$image : base_url().'images/subcategory_icon/thumb/default-designer-icon.jpg'; ?>" alt="<?php echo $category->category_name; ?>" alt="" />
														</div>
                                                        <div class="cbp-caption-activeWrap">
                                                            <div class="cbp-l-caption-alignLeft">
                                                                <div class="cbp-l-caption-body">
                                                                    <div class="cbp-l-caption-title"><?php echo $category->category_name; ?></div>
                                                                    <div class="cbp-l-caption-desc"><?php echo $description; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="cbp-l-grid-projects-title text-center"><?php echo $category->category_name; ?></div>
                                                    <div class="cbp-l-grid-projects-desc text-center hidden-lg"><?php echo $description ?: '&nbsp;'; ?></div>
                                                </div>
														<?php
													}

													// save as previous level
													$prev_level = $category->category_level;

													$ic++;
                                                }

                                                if ($this->webspace_details->slug !== 'junnieleigh')
                                                { ?>

                                                <div class="cbp-item on-sale-general clearfix" style="height:345px;">
                                                    <a href="<?php echo site_url('shop/womens_apparel'); ?>?filter=&availability=onsale" class="cbp-caption cbp-singlePageInline_" data-title="Womens Apparel<br>On Sale Items" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
                                                            <img src="<?php echo base_url().'images/subcategory_icon/thumb/special_sale_icon.jpg'; ?>" alt="" />
														</div>
                                                        <div class="cbp-caption-activeWrap">
                                                            <div class="cbp-l-caption-alignLeft">
                                                                <div class="cbp-l-caption-body">
                                                                    <div class="cbp-l-caption-title"> Womens Apparel </div>
                                                                    <div class="cbp-l-caption-desc"> On sale items </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="cbp-l-grid-projects-title text-center hidden-xs hidden-sm hidden-md"> On Sale Items </div>
                                                    <div class="cbp-l-grid-projects-title text-center hidden-lg"> Womens Apparel </div>
                                                    <div class="cbp-l-grid-projects-desc text-center hidden-lg"> On sale items </div>
                                                </div>

                                                <?php
                                            } ?>

                                            </div>
											<!-- DOC: Apply/remove class "hide" to show/hide element -->
                                            <div id="js-loadMore-lightbox-gallery" class="cbp-l-loadMore-button hide">
                                                <a href="../assets/global/plugins/cubeportfolio/ajax/loadMore3.html" class="cbp-l-loadMore-link btn grey-mint btn-outline" rel="nofollow">
                                                    <span class="cbp-l-loadMore-defaultText">LOAD MORE</span>
                                                    <span class="cbp-l-loadMore-loadingText">LOADING...</span>
                                                    <span class="cbp-l-loadMore-noMoreLoading">NO MORE WORKS</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
