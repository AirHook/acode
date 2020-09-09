                        <!-- BEGIN HEADER MENU -->
                        <div class="page-header-menu">
							<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                            <div class="container">

                                <!-- BEGIN MEGA MENU -->
                                <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                                <div class="hor-menu  ">
                                    <ul class="nav navbar-nav">

										<?php
										/**********
										 * Hub Site
										 * DESIGNERS
										 * Main menu item that drops down list of designers and it's major subcats
                                         * Doesn't not show on satellite sites
										 */
										if ($this->webspace_details->options['site_type'] == 'hub_site_')
										{ ?>

										<!-- DOC: Apply "mega-menu-dropdown" class to utilize mega menu drop down -->
										<!-- DOC: Apply "classic-menu-dropdown" class for the classic list type menu drop down -->
                                        <!-- DOC: Acc class "mega-menu-full" after "mega-menu-dropdown" to make drop down full width -->
										<li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown  hide">

											<!-- Desktop Item -->
                                            <a class="hidden-xs" href="<?php echo site_url('shop/designers'); ?>">
												All Designers
                                                <span class="arrow"></span>
                                            </a>
											<!-- Mobile Item -->
                                            <a class="hidden-sm hidden-md hidden-lg" href="javascript:;">
												Designers
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="min-width: 800px;">
												<li>
                                                    <div class="mega-menu-content">
                                                        <div class="row">

															<div class="col-md-12">
																<ul class="list-unstyled hide">
																	<li>
																		<a href="<?php echo site_url('shop/designers'); ?>" class="nav-link  ">
																			<strong>DESIGNERS</strong>
																		</a>
																	</li>
																</ul>

																<div class="row">

																	<?php
																	$des_array_icons = array();
																	foreach ($designers as $designer)
																	{
																		if ($designer->url_structure !== 'instylenewyork' && $designer->with_products == '1')
																		{
																			$des_array_icons[$designer->url_structure] = $designer->icon;
																			?>

																	<div class="col-md-3 margin-bottom-30">

																		<ul class="list-unstyled">
																			<li class="<?php echo $this->uri->uri_string() == 'shop/designers/'.$designer->url_structure ? 'active' : ''; ?>">
																				<a href="<?php echo site_url('shop/designers/'.$designer->url_structure); ?>" class="nav-link  " onmouseover="$('.hover-icon').fadeOut();$('.hover-icon.<?php echo $designer->url_structure; ?>').fadeIn();">
																					<strong> <?php echo strtoupper($designer->designer); ?> </strong>
																				</a>
																			</li>
																		</ul>
																		<ul class="mega-menu-submenu">

																			<?php
																			$des_subcats = $this->categories_tree->treelist(
																				array(
																					'd_url_structure' => $designer->url_structure,
																					'with_products' => TRUE,
																					'category_slug !=' => 'womens_apparel'
																				)
																			);
																			$des_number_of_categories = $this->categories_tree->row_count;
																			?>

																			<?php
																			if ($des_subcats)
																			{
																				foreach ($des_subcats as $des_subcat) // ---> start category tree
																				{
                                                                                    if ($des_subcat->category_level === '1')
                                                                                    {
                                                                                        $cat_level_1 = $des_subcat->category_slug;
                                                                                    }

																					if (
																						$des_subcat->view_status == '1'
																						&& $des_subcat->with_products > 0
																						&& $des_subcat->category_slug !== 'womens_apparel'
																						&& $des_subcat->category_level !== '1'
																					)
																					{
																						$ld = json_decode($des_subcat->d_url_structure , TRUE);
																						$linked_designers =
																							json_last_error() === JSON_ERROR_NONE
																							? $ld
																							: explode(',', $des_subcat->d_url_structure)
																						;
																						$ii = json_decode($des_subcat->icon_image , TRUE);
																						$icon_images =
																							json_last_error() === JSON_ERROR_NONE
																							? $ii
																							:	explode(',', $des_subcat->icon_image)
																						;
																						//$linked_designers = explode(',', $des_subcat->d_url_structure);
																						//$icon_images = explode(',', $des_subcat->icon_image);
																						if (array() === $linked_designers) $is_assoc = FALSE;
																						else $is_assoc = array_keys($linked_designers) !== range(0, count($linked_designers) - 1);
																						if ($is_assoc)
																						{
																							$key = array_search($designer->url_structure, $linked_designers);
																						}
																						else $key = array_search($designer->url_structure, $linked_designers) + 1;
																						$icon_image = @$icon_images[$key];
																						$des_array_icons[$designer->url_structure.'-'.$des_subcat->category_slug] =
																							$icon_image
																							? '/images/subcategory_icon/thumb/'.$icon_image
																							: 'assets/images/uploads/2018/09/bridal-basix-black-label.jpg'
																						;
																						?>

																			<li aria-haspopup="true" class="<?php echo $this->uri->uri_string() == 'shop/'.$designer->url_structure.'/womens_apparel/'.$des_subcat->category_slug ? 'active' : ''; ?>">
																				<a href="<?php echo site_url('shop/'.$designer->url_structure.'/womens_apparel/'.@$cat_level_1.'/'.$des_subcat->category_slug); ?>" class="nav-link " onmouseover="$('.hover-icon').fadeOut();$('.hover-icon.<?php echo $designer->url_structure.'-'.$des_subcat->category_slug; ?>').fadeIn();">
																					<?php echo $des_subcat->category_name; ?>
																				</a>
																			</li>
																						<?php
																					}
																				}
																			} ?>

																		</ul>

																	</div>
																			<?php
																		}
																	} ?>

																</div>

															</div>

															<div class="col-md-4 hidden-xs hide" style="text-align:right;position:relative;min-height:300px;">

																<img class="hover-icon" src="<?php echo base_url(); ?>assets/images/uploads/2018/09/bridal-basix-black-label.jpg" style="position:absolute;top:0px;right:15px;display:block;" />

																<?php
																if ( ! empty($des_array_icons))
																{
																	foreach ($des_array_icons as $key => $val)
																	{ ?>

																<img class="hover-icon <?php echo $key; ?>" src="<?php echo base_url().ltrim($val, '/'); ?>" style="position:absolute;top:0px;right:15px;display:none;" />
																		<?php
																	}
																} ?>

															</div>

														</div>
													</div>
												</li>

                                            </ul>
                                        </li>
											<?php
										} ?>

										<?php
										/**********
										 * General Sites
										 * WOMENS APPAREL
										 * Main menu item that drops down list of categories from the top tier category 'Womens Apparel'
										 */
										?>
                                        <?php if ($this->webspace_details->options['site_type'] == 'hub_site_') { ?>
                                        <!-- DOC: Acc class "mega-menu-full" after "mega-menu-dropdown" to make drop down full width -->
                                        <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown hide  <?php echo (in_array('womens_apparel', $this->uri->segment_array()) OR in_array('all', $this->uri->segment_array())) ? 'active' : ''; ?> ">
											<!-- Desktop Item -->
                                            <a class="hidden-xs" href="<?php echo site_url('shop/womens_apparel'); ?>"> Womens Apparel
                                                <span class="arrow"></span>
                                            </a>
											<!-- Mobile Item -->
                                            <a class="hidden-sm hidden-md hidden-lg" href="javascript:;"> Womens Apparel
                                                <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="min-width: ">
                                                <li>
                                                    <div class="mega-menu-content">
                                                        <div class="row">

															<div class="col-md-12">

																<!-- DOC: apply class "hide" to hide arrow from mobile menu -->
																<?php
																/**********
																 * List the general categories as SHOP BY CATEGORY
																 * Hidden for now
																 */
																?>
																<div class="col-md-2 margin-bottom-30 hide">
																	<ul class="mega-menu-submenu">

																		<li aria-haspopup="true" class=" ">
																			<a href="<?php echo site_url('shop/categories'); ?>" class="nav-link  ">
																				<strong>SHOP BY CATEGORY</strong>
																			</a>
																		</li>

																		<li aria-haspopup="true" class=" ">
																			<a href="<?php echo site_url('shop/womens_apparel'); ?>" class="nav-link  ">
																				Shop All
																			</a>
																		</li>
																		<li aria-haspopup="true" class=" ">
																			<a href="javascript:;" class="nav-link disabled-link disable-target ">
																				Best Sellers
																			</a>
																		</li>
																		<li aria-haspopup="true" class=" ">
																			<a href="javascript:;" class="nav-link disabled-link disable-target ">
																				New Arrivals
																			</a>
																		</li>

																		<?php
																		/**********
																		 * Sub Dynamic header mega menu navigatioin
																		 */
																		?>
																		<?php
																		if ($main_categories)
																		{
																			foreach ($main_categories as $main_category) // ---> start category tree
																			{
																				if ($main_category->view_status == '1' && $main_category->with_products > 0)
																				{ ?>

																		<li aria-haspopup="true" class="<?php echo in_array($main_category->category_slug, $this->uri->segment_array()) ? 'active' : ''; ?>">
																			<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug); ?>" class="nav-link ">
																				<?php echo $main_category->category_name; ?>
																			</a>
																		</li>
																					<?php
																				}
																			}
																		} ?>

																	</ul>
																</div>

																<?php
																/**********
																 * We list the 2nd level categories
																 * Then the children
																 * NOTE: current state is that category tree is only up to 3 levels
																 */
																?>

																<?php
																if ($main_categories)
																{
																	// set a general category icons array variable to hold all of the
																	// category icons images
																	$gen_cat_array_icons = array();

																	foreach ($main_categories as $main_category) // ---> start category tree
																	{
																		if ($main_category->view_status == '1' && $main_category->with_products > 0)
																		{ ?>

																<div class="col-md-2 margin-bottom-30 womens_apparel_main">
																	<ul class="mega-menu-submenu">

																		<?php
																		// get icon image and save as associative array
																		// check if general or designer specific icon is required
																		// for re-use on second category tree loop (level 1 category menu items)
																		@$icon[$main_category->category_slug] = $this->categories_tree->get_icon(
																			$main_category->category_id,
																			(
																				$this->webspace_details->options['site_type'] == 'hub_site'
																				? 'general'
																				: $this->webspace_details->slug
																			)
																		);
																		// save the icon images in the array
																		$gen_cat_array_icons[$main_category->category_slug] =
																			@$icon[$main_category->category_slug]
																			? '/images/subcategory_icon/thumb/'.@$icon[$main_category->category_slug]
																			: 'assets/images/icons/default-subcat-icon.jpg'
																		;
																		// then make the html element for the level 1 category...
																		?>

																		<li aria-haspopup="true" class=" ">
																			<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug); ?>" class="nav-link  " onmouseover="$('.gen-hover-icon').fadeOut();$('.gen-hover-icon.<?php echo $main_category->category_slug; ?>').fadeIn();">
																				<strong> <?php echo strtoupper($main_category->category_name); ?> </strong>
																			</a>
																		</li>

																		<?php
																		/**********
																		 * Start iteration of subcats
																		 * First get the category childres
																		 */
																		$category_children = $this->categories_tree->get_children($main_category->category_id);
																		if ($category_children)
																		{
																			foreach ($category_children as $subcat) // ---> start category tree
																			{
																				if ($subcat->view_status == '1' && $subcat->with_visible_products > 0)
																				{
																					// check linked designers to see if for non-hub_sites,
																					// if desinger site slug is in linked designers arra
																					//$linked_designers = explode(',', $subcat->d_url_structure);
																					$ld = json_decode($subcat->d_url_structure , TRUE);
																					$linked_designers =
																						json_last_error() === JSON_ERROR_NONE
																						? $ld
																						: explode(',', $subcat->d_url_structure)
																					;
																					// get icon image and save as associative array
																					// check if general or designer specific icon is required
																					@$icon[$subcat->category_slug] = $this->categories_tree->get_icon(
																						$subcat->category_id,
																						(
																							$this->webspace_details->options['site_type'] == 'hub_site'
																							? 'general'
																							: $this->webspace_details->slug
																						)
																					);
																					// save the icon images in the array
																					$gen_cat_array_icons[$subcat->category_slug] =
																						@$icon[$subcat->category_slug]
																						? '/images/subcategory_icon/thumb/'.@$icon[$subcat->category_slug]
																						: 'assets/images/icons/default-subcat-icon.jpg'
																					;

																					if (
																						$this->webspace_details->options['site_type'] !== 'hub_site'
																						&& in_array($this->webspace_details->slug, $linked_designers)
																					)
																					{ ?>

																		<li aria-haspopup="true" class="<?php echo in_array($subcat->category_slug, $this->uri->segment_array()) ? 'active' : ''; ?>">
																			<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug.'/'.$subcat->category_slug); ?>" class="nav-link " onmouseover="$('.gen-hover-icon').fadeOut();$('.gen-hover-icon.<?php echo $subcat->category_slug; ?>').fadeIn();">
																				<?php echo $subcat->category_name; ?>
																			</a>
																		</li>
																						<?php
																					}
																					else if ($this->webspace_details->options['site_type'] == 'hub_site')
																					{
																					?>

																		<li aria-haspopup="true" class="<?php echo in_array($subcat->category_slug, $this->uri->segment_array()) ? 'active' : ''; ?>">
																			<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug.'/'.$subcat->category_slug); ?>" class="nav-link " onmouseover="$('.gen-hover-icon').fadeOut();$('.gen-hover-icon.<?php echo $subcat->category_slug; ?>').fadeIn();">
																				<?php echo $subcat->category_name; ?>
																			</a>
																		</li>
																						<?php
																					}
																				}
																			}
																		} ?>

																	</ul>
																</div>
																			<?php
																		}
																	}
																} ?>

															</div>
															<!-- Icon Images -->
															<div class="col-md-4 hidden-xs hide" style="text-align:right;position:relative;min-height:300px;">

																<?php
																$womens_apparel_gen_icon = $this->categories_tree->get_icon(
																	'1',
																	(
																		$this->webspace_details->options['site_type'] == 'hub_site'
																		? 'general'
																		: $this->webspace_details->slug
																	)
																);
																if ($womens_apparel_gen_icon != '')
																{ ?>

																<img class="gen-hover-icon womens_apparel" src="<?php echo $this->config->slash_item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $womens_apparel_gen_icon; ?>" style="position:absolute;top:0px;right:15px;display:block;" />
																	<?php
																}
																else
																{ ?>

																<img class="gen-hover-icon womens_apparel" src="<?php echo base_url(); ?>assets/images/icons/default-subcat-icon.jpg" style="position:absolute;top:0px;right:15px;display:block;" />
																	<?php
																}
																?>

																<?php
																if ( ! empty($gen_cat_array_icons))
																{
																	foreach ($gen_cat_array_icons as $key => $val)
																	{ ?>

																<img class="gen-hover-icon <?php echo $key; ?>" src="<?php echo $this->config->slash_item('PROD_IMG_URL').ltrim($val, '/'); ?>" style="position:absolute;top:0px;right:15px;display:none;" />
																		<?php
																	}
																} ?>

															</div>

                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php } ?>

										<?php
                                        /**********
										 * Dynamic Nav
										 */
										if ($main_categories)
										{
											// set the array_icons variable
											$array_icons = array();
											$more_than_half = count($main_categories) / 2;
											$cnt = 1;

											foreach ($main_categories as $main_category) // ---> start category tree
											{
												if (
													$main_category->view_status == '1'
													&& $main_category->with_products > 0
													&& (
														$main_category->category_slug !== 'accessories'
														//&& $main_category->category_slug !== 'outerwear'
													)
												)
												{
													// lets set the group's category array to store icons
													$array_icons[$main_category->category_slug] = array();
													?>

                                        <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown ">

											<!-- NAVBAR Item -->
											<!-- Desktop Item -->
                                            <a class="hidden-xs" href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug); ?>"> <?php echo $main_category->category_name; ?>
                                                <span class="arrow"></span>
                                            </a>
											<!-- Mobile Item -->
                                            <a class="hidden-sm hidden-md hidden-lg" href="javascript:;"> <?php echo $main_category->category_name; ?>
                                                <span class="arrow"></span>
                                            </a>
											<!-- DROPDOWN Item --
                                            <ul class="dropdown-menu" style="min-width: 250px;<?php echo $cnt > $more_than_half ? 'right:0;' : '';?>">
                                            -->
                                            <ul class="dropdown-menu" style="min-width: 250px;">
												<li>
                                                    <div class="mega-menu-content">
                                                        <div class="row">
															<div class="col-md-12">
																<ul class="mega-menu-submenu">

																	<?php
																	// set the 1st level category icon on array
																	$array_icons[$main_category->category_slug][$main_category->category_slug] =
																		@$icon[$main_category->category_slug]
																		? '/images/subcategory_icon/thumb/'.@$icon[$main_category->category_slug]
																		: 'assets/images/icons/default-subcat-icon.jpg'
																	;
																	?>

																	<li aria-haspopup="true" class=" ">
																		<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug); ?>" class="nav-link  " onmouseover="$('.<?php echo $main_category->category_slug; ?>-hover-icon').fadeOut();$('.<?php echo $main_category->category_slug; ?>-hover-icon.<?php echo $main_category->category_slug; ?>').fadeIn();">
																			<strong> <?php echo strtoupper($main_category->category_name); ?> </strong>
																		</a>
																	</li>

																	<?php
																	/**********
																	 * Start iteration of subcats
																	 * First get the category childres
																	 */
																	$category_children = $this->categories_tree->get_children($main_category->category_id);
																	if ($category_children)
																	{
																		foreach ($category_children as $subcat) // ---> start category tree
																		{
																			if ($subcat->view_status == '1' && $subcat->with_visible_products > 0)
																			{
																				// check linked designers to see if for non-hub_sites,
																				// if desinger site slug is in linked designers arra
																				//$linked_designers = explode(',', $subcat->d_url_structure);
																				$ld = json_decode($subcat->d_url_structure , TRUE);
																				$linked_designers =
																					json_last_error() === JSON_ERROR_NONE
																					? $ld
																					: explode(',', $subcat->d_url_structure)
																				;
																				// get the previously saved icon images and set on the array
																				$array_icons[$main_category->category_slug][$subcat->category_slug] =
																					@$icon[$subcat->category_slug]
																					? '/images/subcategory_icon/thumb/'.@$icon[$subcat->category_slug]
																					: 'assets/images/icons/default-subcat-icon.jpg'
																				;

																				if (
																					$this->webspace_details->options['site_type'] !== 'hub_site'
																					&& in_array($this->webspace_details->slug, $linked_designers)
                                                                                    && $subcat->category_slug != 'prom_dresses'
																				)
																				{ ?>

																	<li aria-haspopup="true" class="<?php echo in_array($subcat->category_slug, $this->uri->segment_array()) ? 'active' : ''; ?> sat_site">
																		<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug.'/'.$subcat->category_slug); ?>" class="nav-link " onmouseover="$('.<?php echo $main_category->category_slug; ?>-hover-icon').fadeOut();$('.<?php echo $main_category->category_slug; ?>-hover-icon.<?php echo $subcat->category_slug; ?>').fadeIn();">
																			<?php echo $subcat->category_name; ?>
																		</a>
																	</li>
																					<?php
																				}
																				else if (
                                                                                    $this->webspace_details->options['site_type'] == 'hub_site'
                                                                                    && $subcat->category_slug != 'prom_dresses'
                                                                                )
																				{
																				?>

																	<li aria-haspopup="true" class="<?php echo in_array($subcat->category_slug, $this->uri->segment_array()) ? 'active' : ''; ?> hub_site">
																		<a href="<?php echo site_url('shop/womens_apparel/'.$main_category->category_slug.'/'.$subcat->category_slug); ?>" class="nav-link " onmouseover="$('.<?php echo $main_category->category_slug; ?>-hover-icon').fadeOut();$('.<?php echo $main_category->category_slug; ?>-hover-icon.<?php echo $subcat->category_slug; ?>').fadeIn();">
																			<?php echo $subcat->category_name; ?>
																		</a>
																	</li>
																					<?php
																				}
																			}
																		}
																	} ?>

                                                                    <?php
                                                                    /**********
																	 * Hardcoding Facets for Dresses
                                                                     * And hiding PROM DRESSES above
                                                                     * This will provide a link to all dresses that has PROM facets
                                                                     * via the PROM facet link
																	 */
                                                                    if (
                                                                        $main_category->category_slug == 'dresses'
                                                                        && $this->webspace_details->slug != 'tempoparis'
                                                                    )
                                                                    {
                                                                        foreach($occassion_ary as $occassion)
                                                                        {
                                                                            if (@$_GET['occassion'] && $_GET['occassion'] == $occassion)
                                                                            {
                                                                                $occassion_selected = 'active';
                                                                            }
                                                                            else $occassion_selected = '';
                                                                            ?>

                                                                    <li aria-haspopup="true" class="<?php echo $occassion_selected; ?>">
																		<a href="<?php echo base_url('shop/womens_apparel/'.$main_category->category_slug); ?>?occassion=<?php echo $occassion; ?>" class="nav-link  " onmouseover="$('.<?php echo $main_category->category_slug; ?>-hover-icon').fadeOut();$('.<?php echo $main_category->category_slug; ?>-hover-icon.<?php echo $main_category->category_slug; ?>').fadeIn();">
																			<?php echo ucfirst($occassion); ?>
																		</a>
																	</li>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

																</ul>
															</div>
															<!-- Icon Images -->
															<div class="col-md-7 hidden-xs hide" style="text-align:right;position:relative;min-height:300px;">

																<?php
																if (@$icon[$main_category->category_slug] != '')
																{ ?>

																<img class="<?php echo $main_category->category_slug; ?>-hover-icon <?php echo $main_category->category_slug; ?>" src="<?php echo $this->config->slash_item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo @$icon[$main_category->category_slug]; ?>" style="position:absolute;top:0px;right:15px;" />
																	<?php
																}
																else
																{ ?>

																<img class="<?php echo $main_category->category_slug; ?>-hover-icon <?php echo $main_category->category_slug; ?>" src="<?php echo base_url(); ?>assets/images/icons/default-subcat-icon.jpg" style="position:absolute;top:0px;right:15px;" />
																	<?php
																}
																?>

																<?php
																if ( ! empty($array_icons[$main_category->category_slug]))
																{
																	foreach ($array_icons[$main_category->category_slug] as $key => $val)
																	{ ?>

																<img class="<?php echo $main_category->category_slug; ?>-hover-icon <?php echo $key; ?>" src="<?php echo $this->config->slash_item('PROD_IMG_URL').ltrim($val, '/'); ?>" style="position:absolute;top:0px;right:15px;display:none;" />
																		<?php
																	}
																} ?>

															</div>
														</div>
													</div>
												</li>
                                            </ul>

										</li>
													<?php
												}

												$cnt++;
											}
										} ?>

                                        <!-- DOC: Apply "hide" class to hide element --
                                        <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown hide">
                                            <a href="<?php echo site_url(); ?>"> Home
                                                <span class="arrow hide"></span>
                                            </a>
                                        </li>
                                        <!-- -->

                                        <?php
                                        // use ON SALE for basixblacklabel
                                        // use CLEARANCE for shop7
                                        if (
                                            (
                                                $this->webspace_details->slug != 'tempoparis'
                                                //&& $this->webspace_details->slug != 'basixblacklabel'
                                            )
                                            && $this->session->user_cat != 'wholesale'
                                        )
                                        {
                                            $link_label = $this->webspace_details->slug == 'basixblacklabel' ? 'Sale' : 'Clearance';
                                            ?>

                                        <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                            <a class="margin-right-0 font-red" href="<?php echo ENVIRONMENT == 'development' ? base_url() : $this->config->item('PROD_IMG_URL'); ?>shop/<?php echo $this->webspace_details->options['site_type'] == 'sat_site' ? $this->webspace_details->slug.'/' : ''; ?>womens_apparel.html?filter=&availability=onsale" <?php echo $this->webspace_details->options['site_type'] == 'sat_site' ? 'target="_blank"' : ''; ?>> <?php echo $link_label; ?>
                                                <span class="arrow hide"></span>
                                            </a>
                                        </li>

                                            <?php
                                        } ?>

                                    </ul>
                                </div>
                                <!-- END MEGA MENU -->
                            </div>
                        </div>
                        <!-- END HEADER MENU -->
