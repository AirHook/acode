                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<?php
										// for specific designers
										// in case of url ensuing designer specific items
										if ($this->uri->segment(3))
										{
											$designer = $this->designer_details->initialize(array('url_structure'=>$this->uri->segment(3)));
											?>

										<h3 class="form-section" data-d_url_structure="<?php echo $designer->slug; ?>" style="padding-bottom:5px;border-bottom:1px solid #e7ecf1;">
											<?php echo $designer->name; ?> &nbsp; <small class="small"> <?php echo $designer->description; ?> </small>
										</h3>

                                        <div class="portfolio-content portfolio-3 margin-top-30">

                                            <div id="js-grid-lightbox-gallery-<?php echo $designer->url_structure; ?>" class="cbp">

												<?php
												$des_subcats = $this->categories_tree->treelist(
													array(
														'd_url_structure' => $designer->slug
													)
												);

												$cbp_a_link = array();
												$ic = 1;
												foreach ($des_subcats as $category)
												{
													// let's get the correct icon image
													// grab linked designers and respective icon images and descriptions
													//$linked_designers = explode(',', $category->d_url_structure);
													//$icon_images = explode(',', $category->icon_image);
													//$descriptions = explode('|', $category->description);
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
													$key = array_search($designer->slug, $linked_designers);

													// get the pertinent info
													// key index 0 is the item for general designers
													//@$image = $icon_images[$key];
													//@$description = $descriptions[$key];
													@$image = array_key_exists($key, $icon_images) ? $icon_images[$key] : $icon_images[$this->webspace_details->slug];
													@$description = array_key_exists($key, $descriptions) ? $descriptions[$key] : $descriptions[$this->webspace_details->slug];

													// get category linked designer slugs
													//$slugs = $this->categories_tree->get_linked_designers($category->category_id, $des_ary);

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

                                                <div class="cbp-item clearfix" style="height:345px;" data-category_level="<?php echo $category->category_level; ?>">
                                                    <a href="<?php echo site_url('shop/'.$designer->slug.'/'.implode('/', $li_a_link)); ?>" class="cbp-caption cbp-singlePageInline_" data-title="<?php echo $category->category_name; ?><br><?php echo $description; ?>" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
															<!-- <?php echo $image; ?> -->
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

                                                if ($designer->slug !== 'junnieleigh')
                                                { ?>

                                                <div class="cbp-item on-sale-general clearfix" style="height:345px;">
                                                    <a href="<?php echo site_url('shop/'.$designer->slug.'/womens_apparel'); ?>?filter=&availability=onsale" class="cbp-caption cbp-singlePageInline_" data-title="Womens Apparel<br>On Sale Items" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
                                                            <img src="<?php echo base_url().'images/subcategory_icon/thumb/special_sale_icon.jpg'; ?>" alt="" />
														</div>
                                                        <div class="cbp-caption-activeWrap">
                                                            <div class="cbp-l-caption-alignLeft">
                                                                <div class="cbp-l-caption-body">
                                                                    <div class="cbp-l-caption-title"> <?php echo $designer->name; ?> <br />Womens Apparel </div>
                                                                    <div class="cbp-l-caption-desc"> On sale items </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="cbp-l-grid-projects-title text-center"> Special Sale </div>
                                                    <div class="cbp-l-grid-projects-desc text-center hidden-lg"> On sale items </div>
                                                </div>

                                                    <?php
                                                } ?>

                                            </div>
                                        </div>
											<?php
										}
										else
										{
											$des_ary = array();
											foreach ($designers as $designer)
											{
												// for each of all designers...
												// show the designer label, then the designer subcats
												if (
													(
														$designer->url_structure !== 'instylenewyork'
														OR $designer->url_structure !== 'shop7thavenue'
													)
													&& $designer->with_products == '1'
												)
												{ ?>

										<h3 class="form-section" data-d_url_structure="<?php echo $designer->url_structure; ?>" style="padding-bottom:5px;border-bottom:1px solid #e7ecf1;">
											<?php echo $designer->designer; ?> &nbsp; <small class="small"> <?php echo $designer->description; ?> </small>
										</h3>

                                        <div class="portfolio-content portfolio-3 margin-top-30">
                                            <div id="js-grid-lightbox-gallery-<?php echo $designer->url_structure; ?>" class="cbp">

													<?php
													$des_subcats = $this->categories_tree->treelist(
														array(
															'd_url_structure' => $designer->url_structure
														)
													);

													$cbp_a_link = array();
													$ic = 1;
													foreach ($des_subcats as $category)
													{
														// let's get the correct icon image
														// grab linked designers and respective icon images and descriptions
														//$linked_designers = explode(',', $category->d_url_structure);
														//$icon_images = explode(',', $category->icon_image);
														//$descriptions = explode('|', $category->description);
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
														$key = array_search($designer->url_structure, $linked_designers);

														// get the pertinent info
														// key index 0 is the item for general designers
														//@$image = $icon_images[$key];
														//@$description = $descriptions[$key];
														@$image = array_key_exists($key, $icon_images) ? $icon_images[$key] : $icon_images[$this->webspace_details->slug];
														@$description = array_key_exists($key, $descriptions) ? $descriptions[$key] : $descriptions[$this->webspace_details->slug];

														// get category linked designer slugs
														//$slugs = $this->categories_tree->get_linked_designers($category->category_id, $des_ary);

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

                                                <div class="cbp-item clearfix" style="height:345px;" data-category_level="<?php echo $category->category_level; ?>">
                                                    <a href="<?php echo site_url('shop/'.$designer->url_structure.'/'.implode('/', $li_a_link)); ?>" class="cbp-caption cbp-singlePageInline_" data-title="<?php echo $category->category_name; ?><br><?php echo $description; ?>" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
															<!-- <?php echo $image; ?> -->
                                                            <img src="<?php echo $image ? base_url().'images/subcategory_icon/thumb/'.$image : base_url().'images/subcategory_icon/thumb/default-designer-icon.jpg'; ?>" alt="<?php echo $category->category_name; ?>" />
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
													} ?>

                                                <div class="cbp-item on-sale-general clearfix" style="height:345px;">
                                                    <a href="<?php echo site_url('shop/'.$designer->url_structure.'/womens_apparel'); ?>?filter=&availability=onsale" class="cbp-caption cbp-singlePageInline_" data-title="Womens Apparel<br>On Sale Items" rel="nofollow">
                                                        <div class="cbp-caption-defaultWrap">
                                                            <img src="<?php echo base_url().'images/subcategory_icon/thumb/special_sale_icon.jpg'; ?>" alt="" />
														</div>
                                                        <div class="cbp-caption-activeWrap">
                                                            <div class="cbp-l-caption-alignLeft">
                                                                <div class="cbp-l-caption-body">
                                                                    <div class="cbp-l-caption-title"> <?php echo $designer->designer; ?> <br />Womens Apparel </div>
                                                                    <div class="cbp-l-caption-desc"> On sale items </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="cbp-l-grid-projects-title text-center"> Special Sale </div>
                                                    <div class="cbp-l-grid-projects-desc text-center hidden-lg"> On sale items </div>
                                                </div>

                                            </div>
                                        </div>
												<?php
												//array_push($des_ary, $designer->des_id);
												}
											}
										} ?>

                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
