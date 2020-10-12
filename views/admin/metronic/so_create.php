                    <!-- BEGIN PAGE CONTENT BODY -->
                    <?php
                    $url_pre = @$role == 'sales' ? 'my_account/sales' : 'admin';
                    ?>

                    <div class="row">

                        <?php
                        /***********
                         * Left Section
                         */
                        ?>
                        <div class="col col-md-6 form-horizontal" role="form">

							<div class="form-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div class="notifications">
                                    <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                                    <div class="alert alert-danger ">
                                        <button class="close" data-close="alert"></button> An error occured. Please try again.
                                    </div>
                                    <?php } ?>
								</div>

                                <style>
                                    .help-block-error {
                                        font-size: 0.8em;
                                        font-style: italic;
                                    }
                                    .form-group-badge > label.control-label {
                                        text-align: left;
                                    }
                                    .badge-label {
                                        padding-left: 10px;
                                    }
                                    .badge.custom-badge {
                                        height: 30px;
                                        width: 30px;
                                        background-color: #E5E5E5; /* #E5E5E5, grey */
                                        position: relative;
                                        top: -7px;
                                        padding-top: 10px;
                                        border-radius: 18px !important;
                                        color: black;
                                    }
                                    .badge.custom-badge.active {
                                        background-color: black;
                                        color: white;
                                    }
                                    .badge.custom-badge.done {
                                        background-color: grey;
                                        color: white;
                                    }
                                </style>

                                <?php
								/***********
								 * Dropdown and Options
								 */
								?>
                                <!-- Select Designer -->
                                <div class="form-group form-group-badge select-designer-dropdown">
                                    <label class="control-label col-md-5">
                                        <span class="badge custom-badge pull-left step-select-designer step1 active"> 1 </span>
                                        <span class="badge-label"> Select Designer </span>
                                    </label>
                                    <div class="col-md-7">
                                        <select class="bs-select form-control" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
                                            <option class="option-placeholder" value="">Select Designer...</option>
                                            <?php
                                            if (@$designers)
                                            {
                                                foreach ($designers as $designer)
                                                {
                                                    if (@$rolw == 'sales')
                                                    {
                                                        $selected = $designer->url_structure == $this->session->so_des_slug ? 'selected="selected"' : '';
                                                    }
                                                    else
                                                    {
                                                        $selected = $designer->url_structure == $this->session->admin_so_des_slug ? 'selected="selected"' : '';
                                                    }
                                                    ?>

                                            <option value="<?php echo $designer->url_structure; ?>" data-subtext="<em><?php echo $designer->domain_name; ?></em>" data-des_slug="<?php echo $designer->url_structure; ?>" data-des_id="<?php echo $designer->des_id; ?>" <?php echo $selected; ?>>
                                                <?php echo ucwords(strtolower($designer->designer)); ?>
                                            </option>

                                                    <?php
                                                }
                                            } ?>
                                        </select>
                                        <input type="hidden" id="des_id" name="des_id" value="<?php echo @$des_id; ?>" />
                                    </div>
                                </div>
                                <!-- Filter Products --
                                <div class="form-group form-group-badge hide">
                                    <label class="col-md-4 control-label">
                                        <span class="badge custom-badge pull-left step2 <?php echo (@$role == 'sales' ? $this->session->so_des_slug : $this->session->admin_so_des_slug) ? 'active' : ''; ?>"> 2 </span>
                                        <span class="badge-label"> Filter Products By Status </span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="mt-checkbox-inline" style="padding-bottom:0px;">
                                            <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom:0px;font-size:12px;">
                                                <input type="checkbox" class="filter-products-checkbox" name="instock" value="1"> Instock
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom:0px;font-size:12px;">
                                                <input type="checkbox" class="filter-products-checkbox" name="preorder" value="1"> Pre Order
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom:0px;font-size:12px;">
                                                <input type="checkbox" class="filter-products-checkbox" name="publish" value="0"> Unpublished
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Select Products -->
								<div class="form-group form-group-badge">
                                    <label class="control-label col-md-5">
                                        <span class="badge custom-badge pull-left step2 <?php echo (@$role == 'sales' ? $this->session->so_des_slug : $this->session->admin_so_des_slug) ? 'active' : ''; ?>"> 2 </span>
                                        <span class="badge-label"> Select / Search Products </span>
                                    </label>
                                    <div class="col-md-7">
                                        <cite class="help-block font-red" style="padding-top:3px;">
                                            Select From Options below
                                        </cite>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:;" class="btn dark btn-md select-product-options thumbs-grid-view col-md-6" style="<?php echo (@$role == 'sales' ? $this->session->so_des_slug : $this->session->admin_so_des_slug) ? 'background-color:#696969;' : ''; ?>" data-original-title="Select a designer first">
                                            Select From Thumbnails
                                        </a>
                                        <a href="javascript:;" class="btn dark btn-md select-product-options search-multiple-form col-md-6" data-original-title="Select a designer first">
                                            Multi Style Search
                                        </a>
                                        <!-- DOC: Add data-modal-id="modal-unlisted_style_no" attribute to make the button work -->
                                        <a href="javascript:;" data-toggle="modal" class="btn dark btn-md select-product-options_ add-unlisted-style-no col-md-4 tooltips hide" data-original-title="Under Construction">
                                            Add New Product
                                        </a>
                                    </div>
                                </div>

                                <hr />

                                <?php
                                /***********
                                 * THUMBS GRID VIEW
                                 * With Style adapted from main style for tiles
                                 */
                                ?>
                                <div class="thumbs-grid">

                                    <?php
                                    /***********
                                     * Select Category
                                     */
                                    ?>
                                    <div class="input-group categories-tree-wrapper">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn dark dropdown-toggle select-category-button" data-toggle="dropdown" aria-expanded="false">
                                                Select Category <i class="fa fa-angle-down"></i>
                                            </button>
                                            <style>
                                                .categories-tree {
                                                    /*min-width: 250px;*/
                                                    margin-top: 0px;
                                                    padding: 15px 30px 15px 10px;
                                                }
                                                .categories-tree a {
                                                    font-size: 0.8em;
                                                    color: #6f6f6f;
                                                }
                                                .categories-tree li.bold > a {
                                                    font-weight: bold;
                                                }
                                                .categories-tree li > a {
                                                    padding: 2px 16px;
                                                }
                                                .categories-tree li:hover,
                                                .categories-tree li.active {
                                                    background: #f6f6f6;
                                                }
                                                .categories-tree li.active a {
                                                    text-decoration: underline;
                                                }
                                            </style>

                                            <ul class="categories-tree dropdown-menu">

                                                <?php
                                                if (@$des_subcats)
                                                {
                                                    // set or check active slug
                                            		$slug_segs = @$slug_segs ?: array();
                                            		$cnt_slug_segs = count($slug_segs) - 1;

                                            		// designer top level list is always active
                                            		// ergo, set as first slugs_link
                                            		$slugs_link = array($designer_details->url_structure);
                                                    $slugs_link_name = array($designer_details->designer);
                                                    $active = 'bold';
                                                    ?>

                                                <li class="<?php echo $active; ?> designer-level" data-slug="<?php echo $designer_details->url_structure; ?>">
                                                    <a href="javascript:;" data-des_slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
                                                        <?php echo $designer_details->designer; ?>
                                                    </a>
                                                </li>

                                                    <?php
                                                    /**********
                                                     * Cateogry tree list
                                                     */
                                                    $ic = 1;
                                                    $marg = 15;
                                                    $first_max_level = $max_level;
                                                    $p_slug_segs = '';
                                                    $p_slug_segs_name = '';
                                                    $last = '';
                                                    foreach ($des_subcats as $category)
                                                    {
                                                        // set margin
                                                        $margin = 'padding-left:'.($marg * ($category->category_level + 2)).'px;';

                                                        // if there is no slug_segs
                                            			if ( ! $slug_segs OR empty($slug_segs))
                                            			{
                                                            if ($first_max_level > $max_level) $active = '';
                                            				else
                                            				{
                                            					if ($category->category_level < $first_max_level) $active = 'bold';
                                            					if ($category->category_level == $first_max_level)
                                            					{
                                            						$active = 'bold active';
                                            						$first_max_level++;
                                            					}
                                            				}
                                            			}
                                            			else
                                            			{
                                            				// set active where necessary
                                            				if (in_array($category->category_slug, $slug_segs))
                                            				{
                                            					$active = $cnt_slug_segs == $category->category_level ? 'bold active' : 'bold';
                                            				}
                                                            else $active = '';
                                            			}

                                                        // if first row...
                                                        if ($ic == 1)
                                                        {
                                                            // create link
                                                            array_push($slugs_link, $category->category_slug);

                                                            // get active category names
                                                            if ($active == 'bold' OR $active == 'bold active')
                                                            {
                                                                array_push($slugs_link_name, $category->category_name);
                                                            }

                                                            // save as previous level
                                                            // always starts at 0
                                                            $prev_level = $category->category_level;
                                                        }
                                                        else
                                                        {
                                                            // if same category level
                                                            if ($category->category_level == $prev_level)
                                                            {
                                                                // capture the active slugs before next same level iteration
                                                                $slug_segs = @$slug_segs ?: $slugs_link;

                                                                // create new link
                                                                $pop = array_pop($slugs_link); // remove previous last seg
                                                                array_push($slugs_link, $category->category_slug); // replace with new one

                                                                // get active category names
                                                                if ($active == 'bold' OR $active == 'bold active')
                                                                {
                                                                    array_push($slugs_link_name, $category->category_name);
                                                                }
                                                            }

                                                            // NOTE: next greater level is always greater by only 1 level
                                                            if ($category->category_level == $prev_level + 1)
                                                            {
                                                                // append to previous link
                                                                array_push($slugs_link, $category->category_slug);

                                                                // get active category names
                                                                if ($active == 'bold' OR $active == 'bold active')
                                                                {
                                                                    array_push($slugs_link_name, $category->category_name);
                                                                }
                                                            }

                                                            // if next category level is lower
                                                            if ($category->category_level < $prev_level)
                                                            {
                                                                // capture the active slugs before next level iteration
                                                                $slug_segs = @$slug_segs ?: $slugs_link;

                                                                for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
                                                                {
                                                                    // update link
                                                                    $pop = array_pop($slugs_link);
                                                                }

                                                                // append to link
                                                                array_push($slugs_link, $category->category_slug);

                                                                // get active category names
                                                                if ($active == 'bold' OR $active == 'bold active')
                                                                {
                                                                    array_push($slugs_link_name, $category->category_name);
                                                                }

                                                            }

                                                            // if this is last row, set slug segs
                                                            if ($ic == $row_count)
                                                            {
                                                                $last = 'last';
                                                                // capture the active slugs before next level iteration
                                                                $slug_segs = @$slug_segs ?: $slugs_link;
                                                                $slug_segs_name = @$slug_segs_name ?: $slugs_link_name;
                                                                $p_slug_segs = 'data-slug_segs="'.implode('/', $slug_segs).'" ';
                                            					$p_slug_segs_name = 'data-slug_segs_name="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" ';
                                                            }
                                                        }

                                                        // first row is usually the top main category...
                                                        echo '<li class="category_list '
                                                            .$active
                                                            .' level-1 '
                                                            .$last
                                                            .'" data-category_id="'
                                                            .$category->category_id
                                                            .'" data-parent_category="'
                                                            .$category->parent_category.
                                                            '" data-category_slug="'
                                                            .$category->category_slug
                                                            .'" data-category_name="'
                                                            .$category->category_name
                                                            .'" data-category_level="'
                                                            .$category->category_level
                                                            .'" data-slug="'
                                                            .$category->category_slug
                                                            .'" '
                                                            .$p_slug_segs
                                                            .$p_slug_segs_name
                                                            .'>'
                                                            .'<a href="javascript:;" style="font-size:0.8em;'
                                                            .$margin
                                                            .'" data-slugs_link="'
                                                            .implode('/', $slugs_link)
                                                            .'" data-des_slug="'
                                                            .$designer_details->url_structure
                                                            .'">'
                                                            .$category->category_name
                                                            .'</a></li>'
                                                        ;

                                                        $prev_level = $category->category_level;
                                                        $ic++;
                                                    }
                                                }
                                                else
                                                { ?>

                                                <li style="margin-top:15px;margin-bottom:15px;padding-left:15px;">
                                                    Please select a designer...
                                                </li>

                                                    <?php
                                                }?>

                                            </ul>

                                        </div>
                                        <!-- /btn-group -->
                                        <div class="form-control cat_crumbs" style="font-style:italic;font-size:0.8em;">
                                            <?php echo @$slug_segs ? implode(' &nbsp;&raquo;&nbsp; ', @$slug_segs_name) : ''; ?>
                                        </div>
                                    </div>
                                    <!-- /input-group -->

                                    <?php if ( ! @$products) { ?>
                                    <h3 class="blank-grid-text <?php echo (@$role == 'sales' ? $this->session->so_des_slug : $this->session->admin_so_des_slug) ? 'display-none' : ''; ?>">
                                        <em class="select-vendor">Select a designer...</em>
                                    </h3>
                                    <?php } ?>

                                    <?php
                                    /***********
                                     * Thumbs
                                     */
                                     // calc width and height (2/3 = w/h)
                                    $imgw = '160';
                                    $imgh = (3*$imgw)/2;
                                    ?>
                                    <style>
                                        .thumb-tiles {
                                            position: relative;
                                            margin-right: -10px;
                                        }
                                        .thumb-tiles .thumb-tile {
                                            display: block;
                                            float: left;
                                            width: <?php echo $imgw; ?>px !important; /*140px */
                                            height: <?php echo $imgh; ?>px; /*210px;*/
                                            cursor: pointer;
                                            text-decoration: none;
                                            color: #fff;
                                            position: relative;
                                            font-weight: 300;
                                            font-size: 12px;
                                            letter-spacing: .02em;
                                            line-height: 20px;
                                            /*overflow: hidden;*/	/* to show the checkbox at bottom */
                                            border: 4px solid transparent;
                                            margin: 0 5px 30px 0; /* from 10 to 30 add margin to bottom */
                                        }
                                        .thumb-tiles .thumb-tile.selected .corner::after {
                                            content: "";
                                            display: inline-block;
                                            border-left: 30px solid transparent;
                                            border-bottom: 30px solid transparent;
                                            border-right: 30px solid #67809F;
                                            position: absolute;
                                            top: -3px;
                                            right: -3px;
                                            z-index: 100;
                                        }
                                        .thumb-tiles .thumb-tile.selected .check::after {
                                            font-family: FontAwesome;
                                            font-size: 12px;
                                            content: "\f00c";
                                            color: white;
                                            position: absolute;
                                            top: -3px;
                                            right: 0px;
                                            z-index: 101;
                                        }
                                        .thumb-tiles .thumb-tile.image .tile-body {
                                            padding: 0 !important;
                                        }
                                        .thumb-tiles .thumb-tile .tile-body {
                                            height: 100%;
                                            vertical-align: top;
                                            padding: 10px;
                                            overflow: hidden;
                                            position: relative;
                                            font-weight: 400;
                                            font-size: 12px;
                                            color: #fff;
                                            margin-bottom: 5px; /* from 10 to 5 reduce to bring checkbox closer */
                                        }
                                        .thumb-tiles .thumb-tile.image .tile-body > img {
                                            width: 100%;
                                            height: auto;
                                            min-height: 100%;
                                            max-width: 100%;
                                        }
                                        .thumb-tiles .thumb-tile .tile-body img {
                                            margin-right: 10px;
                                        }
                                        .thumb-tiles .thumb-tile .tile-object {
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            right: 0;
                                            min-height: 30px;
                                            background-color: transparent;
                                        }
                                        .thumb-tiles .thumb-tile .tile-object > .name {
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            margin-bottom: 5px;
                                            margin-left: 10px;
                                            margin-right: 15px;
                                            font-weight: 400;
                                            font-size: 13px;
                                            color: #fff;
                                        }
                                        .img-a, .img-a_ {
                                            position: absolute;
                                            left: 0;
                                            top: 0;
                                        }
                                        .img-b, .img-b_ {
                                            position: absolute;
                                            left: 0;
                                            top: 0;
                                        }
                                    </style>
                                    <div class="thumb-tiles-wrapper margin-top-20 <?php echo @$des_subcats ? '' : 'display-none'; ?>" data-row-count="<?php echo @$products_count; ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

        								<?php if ($search_string) { ?>
        	                            <h3 style="word-wrap:break-word;"><small><em>Search results for:</em> &nbsp; "<?php echo $search_string; ?>"</small></h3>
        	                            <br />
        	                            <?php } ?>

        								<div class="thumb-tiles">

        									<?php
        									if (@$products)
        									{
        										$dont_display_thumb = '';
        										$batch = '';
        										$unveil = FALSE;
        										$cnti = 0;
        										foreach ($products as $product)
        										{
        											// set image paths
        											// the image filename
        											$image = $product->prod_no.'_'.$product->primary_img_id.'_f3.jpg';
        											$style_no = $product->prod_no.'_'.$product->color_code;
        											// the new way relating records with media library
        											$path_to_image = $product->media_path.$style_no.'_f3.jpg';
        											$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
        											$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                                    $img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';

        											// after the first batch, hide the images
        											if ($cnti > 0 && fmod($cnti, 100) == 0)
        											{
        												$dont_display_thumb = 'display:none;';
        												$batch = 'batch-'.($cnti / 100);
        												if (($cnti / 100) > 1) $unveil = TRUE;
        											}

        											// let set the classes and other items...
        											$classes = $product->prod_no.' ';
        											$classes.= $style_no.' ';
        											$classes.= $batch.' ';
        											$classes.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') ? 'mt-element-ribbon ' : '';

        											// let set the css style...
        											$styles = $dont_display_thumb;
        											$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';

                                                    // ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
                                    				$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
                                    				$tooltip = $product->publish == '3' ? 'Pending' : (($product->publish == '0' OR $product->view_status == 'N') ? 'Unpubished' : 'Private');

                                                    // check if item is on sale
                									$onsale = (@$product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

        											// due to showing of all colors in thumbs list, we now consider the color code
        											// we check if item has color_code. if it has only product number use the primary image instead
        											$checkbox_check = '';
                                                    if (isset($so_items[$style_no]))
        											{
        												$classes.= 'selected';
        												$checkbox_check = 'checked';
        											}
        											?>

        									<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

        										<!--<a href="<?php echo $img_large; ?>" class="fancybox tooltips" data-original-title="Click to zoom">-->
                                                <a href="javascript:;" class="package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>">

                                                    <?php if ($product->with_stocks == '0') { ?>
        											<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="bottom" data-container="body" data-original-title="Pre Order" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
        												<i class="fa fa-ban"></i>
        											</div>
        											<?php } ?>

        											<div class="corner"> </div>
        											<div class="check"> </div>
        											<div class="tile-body">
        												<img class="img-b_ img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
        												<img class="img-a_ img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
        												<noscript>
        													<img class="img-b_" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
        													<img class="img-a_" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
        												</noscript>
        											</div>
        											<div class="tile-object">
        												<div class="name">
        													<?php echo $product->prod_no; ?> <br />
        													<?php echo $product->color_name; ?> <br />
                                                            <span style="<?php echo $onsale ? 'text-decoration:line-through;' : ''; ?>">
                                                                $<?php echo $product->wholesale_price; ?>
                                                            </span>
                                                            <span style="color:pink;<?php echo $onsale ? '' : 'display:none;'; ?>">
                                                                &nbsp;$<?php echo $product->wholesale_price_clearance; ?>
                                                            </span>
        												</div>
        											</div>

        										</a>

        										<div class="" style="color:red;font-size:1rem;">
                                                    <i class="fa fa-plus package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="background:#ddd;line-height:normal;padding:1px 2px;margin-right:3px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
                                                    <span class="text-uppercase package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"> Add to Sales Order </span>
        										</div>

        									</div>

        										<?php
        										$cnti++;
        										}
        									}
        									else
        									{
        										if ($search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
        										else $txt1 = 'NO PRODUCTS TO LOAD FOR...';
        										echo '<button class="btn default btn-lg hide"> '.$txt1.' </button>';
        									} ?>

        								</div>

        								<?php
        								if (@$cnti > 100)
        								{
        									echo '
        										<button class="btn default btn-block btn-lg load-more-btn" onclick="$(\'img\').unveil();$(\'.batch-2 .img-unveil\').trigger(\'unveil\');$(\'.btn-2, .batch-1\').show();$(this).hide();"> LOAD MORE... </button>
        									';

        									for ($batch_it = 2; $batch_it <= ($cnti / 100); $batch_it++)
        									{
        										echo '<button class="btn default btn-block btn-lg btn-'.$batch_it.' load-more-btn" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();'.(($batch_it + 1) > ($cnti / 100) ? '$(\'.no-more-to-load\').show()' : '').'" style="display:none;"> LOAD MORE..... </button>';
        									}

        									echo '<button class="btn default btn-block btn-lg load-more-btn no-more-to-load" style="display:none;"> NO MORE TO LOAD... </button>';
        								}

        								// a fix for the float...
        								echo '<button class="btn default btn-block btn-lg display-none" style="margin-right:0px;"> NO MORE TO LOAD... </button>';
        								?>

                                    </div>

                                </div>

                                <?php
								/***********
								 * SEARCH MULTIPLE ITEMS
								 */
								?>
                                <div class="form-group search-multiple-items-wrapper display-none">
                                    <div class="col-md-12 search-multiple-items">

                                        <h3 style="margin-top:0px;">SEARCH MULTIPLE ITEMS</h3>

                                        <?php
                                        /***********
                                         * Noification area
                                         */
                                        ?>
                                        <div class="notifications">
                                        	<?php if (validation_errors()) { ?>
                                        	<div class="alert alert-danger">
                                        		<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                        	</div>
                                        	<?php } ?>
                                        </div>

                                        <div style="position:relative;">
                                        	Please enter one STYLE NUMBER per box or as many as 40 items. <span style="color:red;font-style:italic;">(Style Numbers only please.)</span>
                                        	<br /><br />

                                        	<!--bof form==========================================================================-->
                                        	<?php echo form_open(
                                        		$url_pre.'/sales_orders/search_multiple',
                                        		array(
                                                    'class' => 'sa-multi-search-form', // need this for the styling
                                                    'id' => 'so-multi-search-form'
                                        		)
                                        	); ?>

                                                <style>
                                                    .multi-search-form-control.search_by_style {
                                                        width: 99%;
                                                        height: 30px;
                                                        border: 1px solid #ccc;
                                                        text-transform: uppercase;
                                                    }
                                                </style>

                                                <input type="hidden" name="page" value="create" />

                                        		<div class="m-grid m-grid-responsive-sm">
                                                    <div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 1. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 2. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 3. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 4. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 5. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 6. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 7. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 8. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 9. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 10. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 11. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 12. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 13. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 14. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 15. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 16. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 17. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 18. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 19. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 20. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 21. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 22. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 23. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 24. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 25. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 26. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 27. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 28. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 29. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 30. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 31. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 32. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 33. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 34. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 35. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 36. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        			<div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 37. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 38. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                        				<div class="m-grid-col m-grid-col-middle">
                                        					<span class="multi-search-item-no"> 39. </span>
                                        					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                        				</div>
                                                    </div>
                                        		</div>

                                        		<br />
                                        		<div class="row">
                                        			<div class="col-md-3">
                                        				<button type="submit" class="btn dark btn-block"> SEARCH ITEMS </button>
                                        			</div>
                                        		</div>

                                        	<?php echo form_close(); ?>
                                        	<!--eof form==========================================================================-->

                                        </div>
                                    </div>
                                </div>

							</div>

                        </div>

                        <?php
                        /***********
                         * Right Section
                         */
                        ?>
                        <div class="col col-md-6 right-section" style="border:1px solid #ccc;min-height:500px;" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                            <div class="row">

                                <div class="col">
                                    <div class="form-group form-group-badge">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left step3 <?php echo $items_count > 0 ? 'active' : ''; ?>"> 3 </span>
                                            <span class="badge-label"> Refine Sales Order </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Selected items will show in this SOs.
                                            </cite>
                                        </div>
                                    </div>

                                </div>

                                <!-- BEGIN FORM =======================================================-->
                                <?php echo form_open(
                                    $url_pre.'/sales_orders/'.($role == 'sales' ? 'new_order' : 'create'),
                                    array(
                                        'class' => 'form-horizontal',
                                        'id' => 'form-so_create_summary_review'
                                    )
                                ); ?>

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications col-sm-12 clearfix">
                                    <hr style="margin:0;" />
                                    <div class="alert alert-danger display-hide" data-test="test">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <div class="alert alert-success item-added display-none">
										<button class="close" data-close="alert"></button> Item ADDED!
									</div>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Sales Order successfully sent
                                    </div>
                                    <?php } ?>
                                </div>

                                <input type="hidden" name="so_number" value="<?php echo @$so_number; ?>" />
                                <input type="hidden" name="so_date" value="<?php echo date('Y-m-d', time()); ?>" />

                                <!-- indicates order is create via sales order create -->
                                <input type="hidden" name="options[sales_order]" value="1" />
                                <input type="hidden" name="c" value="ws" />

                                <?php
                                /***********
                                 * SO Number
                                 */
                                ?>
                                <div class="col-sm-12 so-summary-number">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12">
                                            <h3>
                                                SALES ORDER #<?php echo $so_number; ?> <br />
                                                <small> Date: <?php echo date('Y-m-d', time()); ?> </small>
                                            </h3>
                                            <div class="row hide">
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div>
                                                        <input type="text" name="options[ref_so_no]" value="" class="form-control input-sm" />
                                                        <span class="help-block small">[Optional]: <cite>Reference manual SO#.</cite></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="row margin-top-20">
                                                <div class="col-xs-5 col-sm-3 name small"> Role: </div>
                                                <div class="col-xs-7 col-sm-9 value"> Wholesale </div>
                                                <!-- DOC: remove 'hide' class to show -->
                                                <div class="col-xs-5 col-sm-3 name small hide"> Payment: </div>
                                                <div class="col-xs-7 col-sm-9 value hide">
                                                    <select name="options[payment_method]" style="border:1px solid #c2cad8;">
                                                        <option>Credit Card</option>
                                                        <option>Money Transfer</option>
                                                        <option>Check</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                /***********
                                 * Bill To / Ship To
                                 */
                                ?>
                                <div class="col-sm-12 po-summary-addresses margin-top-30">
                                    <div class="row">

                                        <div class="col-sm-12 hide">
                                            <em class="small">Bill To / Ship To Options:</em>
                                            &nbsp;
                                            <a href="#modal-select_store" data-toggle="modal" class="btn btn-xs grey-gallery" type="button">Select Store</a>
                                            <button class="btn btn-xs grey-gallery hide" type="button">Select Consumer</button>
                                            <a href="#modal-enter_manual_info" data-toggle="modal" class="btn btn-xs grey-gallery" type="button">Enter Manual Info</a>
                                        </div>

                                        <div class="col-sm-6">

                                            <h5> BILL TO </h5>

                                            <p class="bill-to-options <?php echo @$user_id ? 'display-none' : ''; ?>">
                                                <a href="#modal-select_store" data-toggle="modal" class="btn btn-xs grey-gallery" type="button" style="margin-bottom:5px;">Select Store</a> <br />
                                                <a href="#modal-enter_manual_info" data-toggle="modal" class="btn btn-xs grey-gallery" type="button" style="margin-bottom:5px;">Enter Manual Info</a>
                                            </p>

                                            <p class="customer-billing-address <?php echo @$user_id ? '' : 'display-none'; ?>">
                                                <?php echo @$store_details->store_name ?: 'CUSTOMER NAME'; ?> <br />
                                                <?php echo @$store_details->address1 ?: 'Address1'; ?> <br />
                                                <?php echo @$store_details->address2 ? $store_details->address2.'<br />' : (@$store_details->store_name ? '' : 'Address2<br />'); ?>
                                                <?php echo @$store_details->city ?: 'City'; ?>, <?php echo @$store_details->state ?: 'State'; ?> <br />
                                                <?php echo @$store_details->country ?: 'Country'; ?> <br />
                                                <?php echo @$store_details->telephone ?: 'Telephone'; ?> <br />
                                                ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : 'Contact Name'; ?> <?php echo @$store_details->email ? '('.$store_details->email.')': '(email)'; ?>
                                            </p>

                                            <!-- DOC: remove 'hide' class to show -->
                                            <div class="shipmethod hide">
                                                <h5> SHIPPING METHOD </h5>
                                                <p class="shipmethod-usa-only" style="margin-bottom:10px;">
                                                    USA Only
                                                    <?php
                                                    if ($ship_methods)
                                                    {
                                                        foreach ($ship_methods as $shipmethod)
                                                        { ?>

                                                    <span style="display:table-row;">
                                                        <input style="dispaly:table-cell;vertical-align:top;" value="<?php echo $shipmethod->ship_id; ?>" name="shipmethod" type="radio" <?php echo set_select('shipmethod', $shipmethod->ship_id); ?> data-amount="<?php echo $shipmethod->fix_fee; ?>" data-courier="<?php echo $shipmethod->courier; ?>" data-error-container="shipmethod_error_container" />
                                                        <span class="small" style="display:table-cell;padding-left:5px;padding-top:3px;vertical-align:top;">
                                                            <?php echo $shipmethod->ship_id.' - '.$shipmethod->courier.' ('.$shipmethod->fee.')'; ?>
                                                        </span>
                                                    </span>

                                                            <?php
                                                        }
                                                    } ?>
                                                </p>
                                            </div>

                                            <a href="<?php echo site_url('admin/sales_orders/reset_billto_shipto'); ?>" class="btn btn-xs grey-gallery btn-reset-billto-shipto <?php echo @$user_id ? '' : 'display-none'; ?>" type="button" style="margin-bottom:5px;">Reset "Bill To / Ship To" addresses</a>

                                            <input type="hidden" name="user_id" value="<?php echo @$user_id; ?>" data-error-container="user_id_error_container" />
                                            <span id="user_id_error_container" class="help-block has-block-error has-error"></span>
                                            <span id="shipmethod_error_container" class="help-block has-block-error has-error"></span>

                                        </div>

                                        <div class="col-sm-6">

                                            <h5> SHIP TO </h5>

                                            <p class="ship-to-options <?php echo (@$user_id) ? (@$ship_to ? 'display-none' : '') : 'display-none'; ?>">
                                                <button class="btn btn-xs grey-gallery btn-use_same_bill_to_address" type="button" style="margin-bottom:5px;">Use same as "Bill To" address</button> <br />
                                                <a href="#modal-enter_different_ship_to_address" data-toggle="modal" class="btn btn-xs grey-gallery" type="button" style="margin-bottom:5px;">Enter different "Ship To" address</a>
                                            </p>

                                            <p class="customer-shipping-address <?php echo @$ship_to ? '' : 'display-none'; ?>">
                                                <?php echo @$sh_store_name ?: (@$store_details->store_name ?: 'CUSTOMER NAME'); ?> <br />
                                                <?php echo @$sh_address1 ?: (@$store_details->address1 ?: 'Address1'); ?> <br />
                                                <?php echo @$sh_address2 ?: (@$store_details->address2 ? $store_details->address2.'<br />' : ''); ?>
                                                <?php echo @$sh_city ?: (@$store_details->city ?: 'City'); ?>, <?php echo @$sh_state ?: (@$store_details->state ?: 'State'); ?> <br />
                                                <?php echo @$sh_country ?: (@$store_details->country ?: 'Country'); ?> <br />
                                                <?php echo @$sh_telephone ?: (@$store_details->telephone ?: 'Telephone'); ?> <br />
                                                ATTN: <?php echo @$sh_fname ? $sh_fname.' '.@$sh_lname : (@$store_details->fname ? $store_details->fname.' '.@$store_details->lname : 'Contact Name'); ?> <?php echo @$sh_email ? '('.$sh_email.')' : (@$store_details->email ? '('.$store_details->email.')': '(email)'); ?>
                                            </p>

                                            <!-- DOC: remove 'hide' class to show -->
                                            <div class="shipmethod hide">
                                                <h5> &nbsp </h5>
                                                <p class="shipmethod-international">
                                                    International
                                                    <span style="display:table-row;">
                                                        <input style="dispaly:table-cell;vertical-align:top;" value="0" name="shipmethod" type="radio" <?php echo set_select('shipmethod', '0'); ?> data-amount="<?php echo '0'; ?>" data-courier="DHL International (DHL rates apply)" data-error-container="shipmethod_error_container" />
                                                        <span class="small" style="display:table-cell;padding-left:5px;padding-top:3px;vertical-align:top;">
                                                            DHL - International
                                                        </span>
                                                    </span>
                                                    <cite style="display:block;font-size:8px;line-height:10px;margin-top:5px;">Currently only DHL is used to ship for countries other than USA.</cite>
                                                </p>
                                            </div>

                                            <!-- DOC: 1 - use same address, 2 - enter manual info, data fed by jquery -->
                                            <input type="hidden" name="ship_to" value="<?php echo @$ship_to ?: ''; ?>" data-error-container="ship_to_error_container" />
                                            <input type="hidden" name="test_id" value="" data-error-container="ship_to_error_container" />
                                            <span id="ship_to_error_container" class="help-block has-block-error has-error"></span>

                                        </div>

                                    </div>
                                </div>

                                <?php
                                /***********
                                 * Ship method
                                 */
                                ?>
                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options1">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Ship Method (optional): </h6>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-sm-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[shipmethod_text]" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                /***********
                                 * Sales User / Author Info
                                 */
                                ?>
                                <div class="col-sm-12 sales_user_details">
                                    <p style="margin:10px 0px;">
                                        Sales Person: &nbsp;<?php echo @$author_name ?: 'In-House'; ?> (<?php echo safe_mailto(@$author_email ?: $this->webspace_details->info_email); ?>)
                                    </p>
                                    <input type="hidden" name="author" value="<?php echo $author_id ?: '1'; ?>" /> <!-- defaults to '1' for In-House -->
                                </div>

                                <?php
                                /***********
                                 * Ref Checkout Number
                                 */
                                ?>
                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options1">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Ref Customer Order# (if any): </h6>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-sm-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[ref_checkout_no]" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                /***********
                                 * SO Options 2
                                 *
                                ?>
                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options2 hide">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Ship By Date: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline date-picker" type="text" value="<?php echo $this->session->admin_so_dely_date; ?>" name="delivery_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                    <span class="help-block small" style="font-size:0.8em;"> Click to Select date </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> Ship Via: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[ship_via]" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> F.O.B: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[fob]" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> Terms: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[terms]" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php // */; ?>

                                <?php
                                /***********
                                 * Items Table
                                 */
                                ?>
                                <div class="col-sm-12 cart_basket_wrapper">

                                    <div class="clearfix">
                                        <h4> Details: </h4>
                                    </div>

                                    <div class="cart_basket">

                                        <hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

                                        <div class="table-scrollable table-scrollable-borderless">

                                            <style>
                                                .cart_basket_wrapper .cart_basket .table th {
                                                    font-size: 0.8em;
                                                }
                                                .cart_basket_wrapper .cart_basket .table td {
                                                    font-size: 0.7em;
                                                }
                                                .cart_basket_wrapper .cart_basket .table.table-light > tbody > tr {
                                                    height: 107px;
                                                }
                                                .size-and-qty-wrapper .sizes {
                                                    font-size: 8px;
                                                }
                                                .size-and-qty-wrapper .this-total-qty {
                                                    font-size: 10px;
                                                }
                                                .stock-select,
                                                .size-select {
                                                    border: 0;
                                                    font-size: 12px;
                                                    width: 40px;
                                                   -webkit-appearance: none;
                                                    -moz-appearance: none;
                                                    appearance: none;
                                                }
                                                .stock-select:after,
                                                .size-select:after {
                                                    content: "\f0dc";
                                                    font-family: FontAwesome;
                                                    color: #000;
                                                }
                                            </style>

                                            <table class="table table-striped table-hover table-light " data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                                <thead>
                                                    <tr>
                                                            <!--
                                                            <th class="text-center hide" style="width:25px;vertical-align:bottom;"> Req'd </th>
                                                            <th class="text-center hide" style="width:25px;vertical-align:bottom;"> Ship'd </th>
                                                            <th class="text-center hide" style="width:25px;vertical-align:bottom;border-right:1px solid #F2F5F8;"> B.O. </th>
                                                            -->
                                                        <th style="vertical-align:bottom;"> Items (<span class="items_count"><?php echo $items_count; ?></span>) </th>
                                                        <th style="vertical-align:bottom;"> Prod No </th>
                                                        <th style="vertical-align:bottom;"> Size </th>
                                                        <th style="vertical-align:bottom;"> Color </th>
                                                        <th style="vertical-align:bottom;"> Qty </th>
                                                        <th style="vertical-align:bottom;width:60px;border-left:1px solid #F2F5F8;" class="text-center">
                                                            Regular<br />Price
                                                        </th>
                                                        <th style="vertical-align:bottom;width:60px;border-right:1px solid #F2F5F8;" class="text-center">
                                                            Discounted<br />Price
                                                        </th>
                                                            <!--
                                                            <th style="vertical-align:bottom;width:50px;" class="text-right hide"> Disc </th>
                                                            -->
                                                        <th style="vertical-align:bottom;width:60px;" class="text-right"> Extended<br />Price </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if ( ! empty($so_items))
                                                    {
                                                        $overall_qty = 0;
                                                        $overall_total = 0;
                                                        $i = 1;
                                                        foreach ($so_items as $item => $options)
                                                        {
                                                            // just a catch all error suppression
                                                            if ( ! $item) continue;

                                                            // get product details
                                                            // NOTE: some items may not be in product list
                                                            $exp = explode('_', $item);
                                                            $product = $this->product_details->initialize(
                                                                array(
                                                                    'tbl_product.prod_no' => $exp[0],
                                                                    'color_code' => $exp[1]
                                                                )
                                                            );

                                                            // set image paths
                                                            $style_no = $item;
                                                            $prod_no = $exp[0];
                                                            $color_code = $exp[1];
                                                            $temp_size_mode = 1; // default size mode

                                                            // price can be...
                                                            // onsale price (retail_sale_price or wholesale_price_clearance)
                                                            // regular price (retail_price or wholesale_price)
                                                            // sales order is for wholeasle users only
                                                            // new pricing scheme
                                                            $orig_price = @$product->wholesale_price ?: 0;
                                                            $price =
                                                                @$product->custom_order == '3'
                                                                ? (@$product->wholesale_price_clearance ?: 0)
                                                                : $orig_price
                                                            ;

                                                            if ($product)
                                                            {
                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
                                                                $img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
                                                                $size_mode = $product->size_mode;
                                                                $color_name = $product->color_name;

                                                                // take any existing product's size mode
                                                                $temp_size_mode = $product->size_mode;
                                                            }
                                                            else
                                                            {
                                                                $image_new = 'images/instylelnylogo_3.jpg';
                                                                $img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
                                                                $img_linesheet = '';
                                                                $img_large = '';
                                                                $size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
                                                                $color_name = $this->product_details->get_color_name($color_code);
                                                            }

                                                            // get size names
                                                            $size_names = $this->size_names->get_size_names($size_mode);
                                                            foreach ($options as $size_label => $qty)
                                                            {
                                                                if ($size_label == 'discount') continue;

                                                                $this_size_qty = $qty[0];
                                                                $s = $size_names[$size_label];

                                                                // calculate available stocks
                                                                // and check for on sale items
                                                                if ($product)
                                                                {
                                                                    if ($product->$size_label == '0')
                                                                    {
                                                                        $preorder = TRUE;
                                                                        $partial_stock = FALSE;
                                                                    }
                                                                    elseif ($qty[0] <= $product->$size_label)
                                                                    {
                                                                        $preorder = FALSE;
                                                                        $partial_stock = FALSE;
                                                                    }
                                                                    elseif ($qty[0] > $product->$size_label)
                                                                    {
                                                                        $preorder = TRUE;
                                                                        $partial_stock = TRUE;
                                                                    }
                                                                    else
                                                                    {
                                                                        $preorder = FALSE;
                                                                        $partial_stock = FALSE;
                                                                    }
                                                                    $onsale =
                                                                        $product->custom_order == '3'
                                                                        ? TRUE
                                                                        : FALSE
                                                                    ;
                                                                }
                                                                else
                                                                {
                                                                    // item not in product list
                                                                    $preorder = FALSE;
                                                                    $partial_stock = FALSE;
                                                                    $onsale = FALSE;
                                                                }

                                                                if (
                                                                    isset($options[$size_label])
                                                                    && $s != 'XL1' && $s != 'XL2'
                                                                )
                                                                {
                                                            ?>

                                                    <tr class="summary-item-container <?php echo $item.' '.$size_label; ?>" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>">

                                                        <?php
                                                        /**********
                                                         * Quantities
                                                         */
                                                        ?>
                                                        <!--
                                                        <td class="text-center hide" style="vertical-align:top;">
                                                            <?php echo $qty[0]; ?>
                                                            <br />
                                                            <i class="fa fa-pencil small tooltips font-grey-silver modal-edit_quantity" data-original-title="Edit Qty" data-placement="bottom" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>"></i>
                                                        </td>
                                                        <td class="text-center hide" style="vertical-align:top;"><?php echo $qty[1]; ?></td>
                                                        <td class="text-center hide" style="vertical-align:top;"><?php echo $qty[2]; ?></td>
                                                        -->

                                                        <?php
                                                        /**********
                                                         * Items' IMAGE and Descriptions
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;">
                                                            <!-- DOC: add 'pull-left' class to float left -->
                                                            <a href="<?php echo $img_large ?: 'javascript:;'; ?>" class="<?php echo $img_large ? 'fancybox' : ''; ?>">
                                                                <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL'); ?>images/instylelnylogo_3.jpg');" />
                                                            </a>
                                                            <button type="button" class="btn btn-link btn-xs summary-item-remove tooltips pull-right" data-original-title="Remove Item" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>" data-size_label="<?php echo $size_label; ?>" style="margin-right:0px;position:relative;top:-5px;">
                                                                <i class="fa fa-close small" style="color:#8896a0;"></i> <cite class="small hide">rem</cite>
                                                            </button>
                                                            <!-- DOC: remove 'hide' class to show -->
                                                            <div class="shop-cart-item-details hide" style="margin-left:65px;">
                                                                <h4 style="margin:0px;">
                                                                    <button type="button" class="btn btn-link btn-xs summary-item-remove tooltips pull-right" data-original-title="Remove Item" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>" data-size_label="<?php echo $size_label; ?>" style="margin-right:0px;position:relative;top:-5px;">
                                                                        <i class="fa fa-close small" style="color:#8896a0;"></i> <cite class="small hide">rem</cite>
                                                                    </button>
                                                                    <?php echo $prod_no; ?>
                                                                </h4>
                                                                <p style="margin:0px;">
                                                                    <span style="color:#999;">Style#:&nbsp;<?php echo $item; ?></span><br />
                                                                    Color: &nbsp; <?php echo $color_name; ?>
                                                                    <?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
                                                                    <?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
                                                                </p>
                                                                <?php if ($onsale) { ?>
                                                                <span class="badge bg-red-mint badge-roundless display-block"> On Sale </span>
                                                                <?php } ?>
                                                                <?php if ($preorder) { ?>
                                                                <span class="badge badge-danger badge-roundless display-block"> Pre Order </span>
                                                                <?php } ?>
                                                                <?php if ($partial_stock) { ?>
                                                                <span class="badge badge-warning badge-roundless display-block"> Parial Stock </span>
                                                                <?php } ?>
                                                            </div>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Prod No
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;">
                                                            <?php echo $prod_no; ?>
                                                            <?php echo $onsale ? '<br /><cite class="small font-red">On Sale</cite>' : ''; ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Size
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;text-align:center;">
                                                            <?php echo $s; ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Color
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;">
                                                            <?php echo $color_name; ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Qty
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;text-align:center;">
                                                            <?php echo $qty[0] ?: $qty; ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Reg Price
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;<?php echo $orig_price == $price ?: 'text-decoration:line-through;'; ?>" class="text-right unit-price-wrapper <?php echo $item.' '.$prod_no; ?>" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>">
                                                            $ <?php echo number_format($orig_price, 2); ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Discount - onsale/clearance
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;<?php echo $orig_price == $price ?: 'color:red;'; ?>" class="text-right unit-price-wrapper <?php echo $item.' '.$prod_no; ?>" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>">
                                                            <?php echo $orig_price == $price ? '--' : '$ '.number_format($price, 2); ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Discount - hiding editable discount cell
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;" class="text-right discount-wrapper <?php echo $item.' '.$prod_no; ?> hide">
                                                            <?php
                                                            // the $disc ($options['discount']) was inteded for putting discounts
                                                            // on prices which is currently hidden as price is now using direct discounted amounts
                                                            // like the retail onsale price and wholesale clearance price
                                                            // keeping it here as discounts may be used again...
                                                            $disc = @$options['discount'] ?: 0;
                                                            if ($disc == '0') echo '---';
                                                            else echo number_format($disc, 2);
                                                            ?>
                                                            <br />
                                                            <i class="fa fa-pencil small tooltips font-grey-silver modal-add_discount" data-original-title="Add Discount" data-placement="bottom" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>"></i>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Extended
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;" class="text-right order-subtotal <?php echo $item.' '.$prod_no; ?>">
                                                            <?php
                                                            $this_size_total = $this_size_qty * ($price - $disc);
                                                            ?>
                                                            $ <?php echo number_format($this_size_total, 2); ?>
                                                        </td>

                                                        <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />
                                                    </tr>
                                                                    <?php
                                                                }

                                                                $overall_qty += $this_size_qty;
                                                                $overall_total += $this_size_total;
                                                            }

                                                            $i++;
                                                        } ?>

                                                        <input type="hidden" class="hidden-overall_qty_" name="overall_qty" value="<?php echo $overall_qty; ?>" />
                                                        <input type="hidden" class="hidden-overall_total_" name="overall_total" value="<?php echo $overall_total; ?>" />

                                                        <?php
                                                    } ?>

                                                </tbody>
                                            </table>

                                        </div>

                                        <hr />

                                    </div>
                                </div>

                                <?php
                                /***********
                                 * Remarks and Totals Section
                                 */
                                ?>
                                <div class="col-sm-12 status-with-items <?php echo empty($so_items) ? 'display-none' : ''; ?>">
                                    <div class="row">

                                        <div class="col-sm-7">
                                            <label class="control-label">Remarks/Instructions:
                                            </label>
                                            <textarea name="remarks" class="form-control summernote" id="summernote_1" data-error-container="email_message_error"></textarea>
                                            <div id="email_message_error"> </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <!-- Spacer -->
                                        </div>

                                        <div class="col-sm-4">
                                            <table class="table table-condensed cart-summary">
                                                <tr>
                                                    <td> Quantity Total </td>
                                                    <td class="overall-qty text-right">
                                                        <?php echo @$overall_qty ?: 0; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Order Total </td>
                                                    <td class="text-right order-total">
                                                        <?php
                                                        echo '$ '.number_format(@$overall_total, 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                    </td>
                                                </tr>
                                            </table>

                                            <div>
                                                <!-- DOC: add class "submit-po_summary_review" to execute script to send form -->
                                                <button class="btn dark btn-sm btn-block mt-bootbox-new submit-po_summary_review hidden-xs hidden-sm"> Create Sales Order </button>
                                                <button class="btn dark btn-sm btn-block mt-bootbox-new submit-po_summary_review hidden-md hidden-lg"> Create PO </button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 no-item-notification <?php echo empty($so_items) ? '' : 'display-none'; ?>">
                                    <h4 class="text-center" style="margin:85px auto 150px;"> There are no items in your sales order </h4>
                                </div>

                                </form>
                                <!-- END FORM =======================================================-->

                                <div class="col-sm-12 steps">

                                    <hr />
                                    <div class="form-group form-group-badge clearfix" style="margin-bottom:0px;">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left <?php echo @$overall_qty ? 'active' : ''; ?> step4"> 4 </span>
                                            <span class="badge-label"> Create Sales Order </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Sales Order will be created and submitted pending.
                                            </cite>
                                        </div>
                                    </div>

                                    <hr style="margin-top:0px;" />
                                    <a href="<?php echo site_url($url_pre.'/sales_orders/reset'); ?>" style="color:#333;">
                                        <div class="form-group form-group-badge form-group-badge-step5 clearfix">
                                            <label class="control-label col-md-5" style="cursor:pointer;">
                                                <span class="badge custom-badge pull-left step5"> 5 </span>
                                                <span class="badge-label"> Clear Sales Order </span>
                                            </label>
                                            <div class="col-md-7">
                                                <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                    Sales Order will be reset and all items cleared.
                                                </cite>
                                            </div>
                                        </div>
                                    </a>

                                </div>

                            </div>
                        </div>

                        <!-- ADD STYLE NUMBERS NOT YET UPLOADED -->
                        <div class="modal fade" id="modal-unlisted_style_no" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Add STYLE NUMBERS not on product list </h4>
                                    </div>

                                    <!-- BEGIN FORM-->
                                    <!-- FORM =======================================================================-->
                                    <form id="form-add_unlisted_style_no" class="form-horizontal" action="" method="POST" accept-charset="utf-8" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <input type="hidden" name="action" value="add_item" />

                                    <div class="modal-body">

                                        <div class="form margin-bottom-30">

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Style Number:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control facet_name" name="prod_no" value="" style="text-transform:uppercase;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Color Code:
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <select class="form-control bs-select" name="color_code" data-live-search="true" data-size="8" data-show-subtext="true">
                                                        <option value="" selected disabled> - Select a color - </option>

                                                        <?php
                                                        if ($colors)
                                                        {
                                                            foreach ($colors as $color)
                                                            { ?>

                                                        <option value="<?php echo $color->color_code; ?>" data-subtext="<cite>(<?php echo $color->color_code; ?>)</cite>" data-color_name="<?php echo $color->color_name; ?>">
                                                            <?php echo ucwords(strtolower($color->color_name)); ?>
                                                        </option>

                                                                <?php
                                                            }
                                                        } ?>

                                                    </select>
                                                    <input type="hidden" name="color_name" value="" />
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Close</button>
                                        <button type="submit" class="btn dark"> Submit </button>
                                    </div>

                                    </form>
                                    <!-- END FORM ===================================================================-->
                                    <!-- END FORM-->

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- EDIT VENDOR PRICE -->
                        <div id="modal-edit_vendor_price" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Vendor Price</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="evp-modal-item"><?php echo @$item; ?></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">New Price
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="vendor_price" data-required="1" class="form-control input-sm modal-input-vendor-price" value="" size="2" data-prod_no="" data-item="" data-page="create" />
                                            </div>
                                        </div>

                                        <div class="alert alert-danger">
                                            <button class="close hide" data-close="alert"></button> NOTE: this changes the price of all variants of this product item
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark edit_vendor_prices" data-prod_no="<?php echo @$item; ?>">Apply changes</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- ADD DISCOUNT -->
                        <div id="modal-add_discount" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add Discount</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="evp-modal-item"><?php echo @$item; ?></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">Discount
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="discount" class="form-control input-sm modal-input-discount" value="" data-size_label="" data-prod_no="" data-item="" data-page="create" />
                                            </div>
                                        </div>

                                        <div class="alert alert-danger">
                                            <button class="close hide" data-close="alert"></button> NOTE: this adds the discount of all variants of this product item
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark add_discount">Add Discount</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- EDIT QTY -->
                        <div id="modal-edit_quantity" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Quantity</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="evp-modal-item"><?php echo @$item; ?></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">New Quantity
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="qty" class="form-control input-sm modal-input-discount" value="" data-size_label="" data-prod_no="" data-item="" data-page="create" />
                                            </div>
                                        </div>

                                        <div class="alert alert-danger">
                                            <button class="close hide" data-close="alert"></button> NOTE: this adds the discount of all variants of this product item
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark edit_quantity">Submit New Qty</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- SELECT STORE -->
                        <div id="modal-select_store" class="modal fade bs-modal-md in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Bill To / Ship To Address</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="send_to_current_user">

        									<div class="form-body">

        										<h4> <cite>CURRENT USERS:</cite> </h4>

                                                <div class="alert alert-warning display-none">
        											<button class="close" data-close="alert"></button>
        											Select only one user
        										</div>

                                                <div class="row">
        				                            <div class="col-md-9 margin-bottom-10">

        				                                <!-- BEGIN FORM-->
        				                                <!-- FORM =======================================================================-->
        				                                <?php
                                                        //echo form_open(
                                                            //$url_pre.'/sales_orders/search_current_user',
                                                            //array(
                                                            //    'class'=>'form-horizontal',
                                                            //    'id'=>'form-wholesale_user_list_search'
                                                            //)
                                                        //);
                                                        ?>

        				                                <div class="input-group">
        				                                    <input class="form-control select-user-search" placeholder="Search for Email or Store Name..." name="search_string" type="text" data-role="<?php echo @$role ?: ''; ?>" />
        				                                    <span class="input-group-btn">
        				                                        <button class="btn-search-current-user btn dark uppercase bold" type="button">Search</button>
        				                                    </span>
        													<span class="input-group-btn">
        				                                        <button class="btn-reset-search-current-user btn default uppercase bold tooltips" data-original-title="Reset list" type="button" data-end_cur="<?php echo @$number_of_pages; ?>"><i class="fa fa-refresh"></i></button>
        				                                    </span>
        				                                </div>

        				                                <!--</form>
        				                                <!-- End FORM =======================================================================-->
        				                                <!-- END FORM-->

        				                            </div>
        				                        </div>

        										<div class="form-group">

                                                    <h4 class="caption search display-none">
        												Search result for: "<strong class="search_string"></strong>"
        											</h4>

        											<label>My Users:<span class="required"> * </span>
        											</label>
        											<div class="form-control height-auto">
        												<div class="scroller" style="height:300px;" data-always-visible="1">

        													<div id="email_array_error"> </div>
        													<div class="mt-checkbox-list select-users-list">

        														<?php
                                                                if (@$users)
                                                                {
                                                                    foreach ($users as $user)
            														{
                                                                        $checked =
                                                                            @$user_id == $user->user_id
                                                                            ? 'checked="checked"'
                                                                            : ''
                                                                        ;
                                                                        ?>

                                                                <label class="mt-checkbox mt-checkbox-outline">
        															<?php echo ucwords($user->store_name); ?> <br />
        															<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)).' <cite class="small">('.$user->email.')</cite> '; ?>
                                                                    <input type="checkbox" class="send_to_current_user list" name="email[]" value="<?php echo $user->user_id; ?>" data-error-container="email_array_error" <?php echo $checked; ?> />
                                                                    <span></span>
                                                                </label>

            															<?php
                                                                    }
        														} ?>

                                                            </div>

        												</div>
        											</div>
        										</div>

        										<hr />

        									</div>

        								</div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark select-store hide">Select</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- ENTER MANUAL INFO FOR STORE -->
                        <div id="modal-enter_manual_info" class="modal fade bs-modal-md in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Bill To / Ship To Address</h4>
                                    </div>
                                    <div class="modal-body clearfix">

                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="btn-group btn-group-justified">
                                                    <a href="javascript:;" class="btn dark enter-user ws" data-user="ws"> WHOLESALE USER </a>

                                                    <?php if ( ! $this->session->admin_sales_loggedin)
                                                    { ?>

                                                    <a href="javascript:;" class="btn dark btn-outline enter-user cs hide" data-user="cs"> CONSUMER USER </a>

                                                        <?php
                                                    } ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="send_to_new_user form-body">

                                            <!-- BEGIN FORM =======================================================-->
                                            <?php echo form_open(
                                                $url_pre.'/sales_orders/add_new_user',
                                                array(
                                                    'class' => 'enter-user-form ws clearfix',
                                                    'id' => 'form-so_add_new_user_ws'
                                                )
                                            ); ?>

                                            <div class="alert alert-danger display-hide" data-test="test">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

        									<div class="form-body">

                                                <h4> <cite>NEW WHOLESALE USER:</cite> </h4>

                                                <input type="hidden" name="user_cat" value="ws" />
        										<input type="hidden" name="reference_designer" class="send_to_new_user" value="<?php echo $this->webspace_details->slug; ?>" />
        										<input type="hidden" name="admin_sales_email" class="send_to_new_user" value="<?php echo $this->webspace_details->info_email; ?>" />
        										<input type="hidden" name="admin_sales_id" class="send_to_new_user" value="1" />

        										<div class="form-group">
        											<label>Email<span class="required"> * </span>
        											</label>
        											<div class="input-group">
        												<span class="input-group-addon">
        													<i class="fa fa-envelope"></i>
        												</span>
        												<input type="email" name="email" class="form-control send_to_new_user" value="<?php echo set_value('email'); ?>" />
        											</div>
        										</div>
        										<div class="form-group">
        											<label>First Name<span class="required"> * </span>
        											</label>
        											<input name="firstname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('firstname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Last Name<span class="required"> * </span>
        											</label>
        											<input name="lastname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('lastname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Store Name<span class="required"> * </span>
        											</label>
        											<input name="store_name" type="text" class="form-control send_to_new_user" value="<?php echo set_value('store_name'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Fed Tax ID
        											</label>
        											<input name="fed_tax_id" type="text" class="form-control send_to_new_user" value="<?php echo set_value('fed_tax_id'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Telephone<span class="required"> * </span>
        											</label>
        											<input name="telephone" type="text" class="form-control send_to_new_user" value="<?php echo set_value('telephone'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 1<span class="required"> * </span>
        											</label>
        											<input name="address1" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address1'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 2
        											</label>
        											<input name="address2" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address2'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>City<span class="required"> * </span>
        											</label>
        											<input name="city" type="text" class="form-control send_to_new_user" value="<?php echo set_value('city'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>State<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="state" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_states() as $state) { ?>
        												<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Country<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="country" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_countries() as $country) { ?>
        												<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Zip Code<span class="required"> * </span>
        											</label>
        											<input name="zipcode" type="text" class="form-control send_to_new_user" value="<?php echo set_value('zipcode'); ?>" />
        										</div>

        										<hr />

                                                <button type="submit" class="btn dark enter-user-manually pull-right" data-user_cat="ws">Submit</button>
        									</div>

                                            </form>
                                            <!-- END FORM =========================================================-->

                                            <!-- BEGIN FORM =======================================================-->
                                            <?php echo form_open(
                                                $url_pre.'/sales_orders/add_new_user',
                                                array(
                                                    'class' => 'enter-user-form cs clearfix hide',
                                                    'id' => 'form-so_add_new_user_cs'
                                                )
                                            ); ?>

                                            <div class="alert alert-danger display-hide" data-test="test">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

                                            <div class="form-body">

                                                <h4> <cite>NEW CONSUMER USER:</cite> </h4>

                                                <input type="hidden" name="user_cat" value="cs" />
        										<input type="hidden" name="reference_designer" class="send_to_new_user" value="<?php echo @$this->sales_user_details->designer ?: $this->webspace_details->slug; ?>" />
        										<input type="hidden" name="admin_sales_email" class="send_to_new_user" value="<?php echo @$this->sales_user_details->email ?: $this->webspace_details->info_email; ?>" />

        										<div class="form-group">
        											<label>Email<span class="required"> * </span>
        											</label>
        											<div class="input-group">
        												<span class="input-group-addon">
        													<i class="fa fa-envelope"></i>
        												</span>
        												<input type="email" name="email" class="form-control send_to_new_user" value="<?php echo set_value('email'); ?>" />
        											</div>
        										</div>
        										<div class="form-group">
        											<label>First Name<span class="required"> * </span>
        											</label>
        											<input name="firstname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('firstname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Last Name<span class="required"> * </span>
        											</label>
        											<input name="lastname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('lastname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Company
        											</label>
        											<input name="company" type="text" class="form-control send_to_new_user" value="<?php echo set_value('company'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Telephone<span class="required"> * </span>
        											</label>
        											<input name="telephone" type="text" class="form-control send_to_new_user" value="<?php echo set_value('telephone'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 1<span class="required"> * </span>
        											</label>
        											<input name="address1" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address1'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 2
        											</label>
        											<input name="address2" type="text" class="form-control send_to_new_user" value="<?php echo set_value('address2'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>City<span class="required"> * </span>
        											</label>
        											<input name="city" type="text" class="form-control send_to_new_user" value="<?php echo set_value('city'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>State<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="state_province" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_states() as $state) { ?>
        												<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state_province', $state->state_name); ?>><?php echo $state->state_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Country<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="country" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_countries() as $country) { ?>
        												<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Zip Code<span class="required"> * </span>
        											</label>
        											<input name="zip_postcode" type="text" class="form-control send_to_new_user" value="<?php echo set_value('zip_postcode'); ?>" />
        										</div>

        										<hr />

                                                <button type="submit" class="btn dark enter-user-manually pull-right" data-user_cat="cs">Submit</button>
        									</div>

                                            </form>
                                            <!-- END FORM =========================================================-->

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- ENTER DIFFERENT SHIP TO ADDRESS -->
                        <div id="modal-enter_different_ship_to_address" class="modal fade bs-modal-md in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Different Ship To Address</h4>
                                    </div>
                                    <div class="modal-body clearfix">

                                        <div class="send_to_new_user form-body">

                                            <!-- BEGIN FORM =======================================================-->
                                            <?php echo form_open(
                                                $url_pre.'/sales_orders/diff_ship_to',
                                                array(
                                                    'class' => 'enter-user-form ws clearfix',
                                                    'id' => 'form-so_diif_ship_to'
                                                )
                                            ); ?>

                                            <div class="alert alert-danger display-none" data-test="test">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-none">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

        									<div class="form-body">

                                                <h4> <cite>NEW SHIP TO ADDRESS:</cite> </h4>

        										<div class="form-group">
        											<label>Email<span class="required"> * </span>
        											</label>
        											<div class="input-group">
        												<span class="input-group-addon">
        													<i class="fa fa-envelope"></i>
        												</span>
        												<input type="email" name="sh_email" class="form-control send_to_new_user" value="<?php echo set_value('sh_email'); ?>" />
        											</div>
        										</div>
        										<div class="form-group">
        											<label>First Name<span class="required"> * </span>
        											</label>
        											<input name="sh_fname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_fname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Last Name<span class="required"> * </span>
        											</label>
        											<input name="sh_lname" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_lname'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Store Name<span class="required"> * </span>
        											</label>
        											<input name="sh_store_name" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_store_name'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Fed Tax ID
        											</label>
        											<input name="sh_fed_tax_id" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_fed_tax_id'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Telephone<span class="required"> * </span>
        											</label>
        											<input name="sh_telephone" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_telephone'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 1<span class="required"> * </span>
        											</label>
        											<input name="sh_address1" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_address1'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>Address 2
        											</label>
        											<input name="sh_address2" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_address2'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>City<span class="required"> * </span>
        											</label>
        											<input name="sh_city" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_city'); ?>" />
        										</div>
        										<div class="form-group">
        											<label>State<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="sh_state" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_states() as $state) { ?>
        												<option value="<?php echo $state->state_name; ?>" <?php echo set_select('sh_state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Country<span class="required"> * </span>
        											</label>
        											<select class="form-control bs-select send_to_new_user" name="sh_country" data-live-search="true" data-size="8">
        												<option class="option-placeholder" value="">Select...</option>
        												<?php foreach (list_countries() as $country) { ?>
        												<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('sh_country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
        												<?php } ?>
        											</select>
        										</div>
        										<div class="form-group">
        											<label>Zip Code<span class="required"> * </span>
        											</label>
        											<input name="sh_zipcode" type="text" class="form-control send_to_new_user" value="<?php echo set_value('sh_zipcode'); ?>" />
        										</div>

                                                <div class="alert alert-danger display-none" data-test="test">
                                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                                <div class="alert alert-success display-none">
                                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>

        										<hr />

                                                <button type="submit" class="btn dark enter-different-ship-to pull-right" data-user_cat="ws">Submit</button>
        									</div>

                                            </form>
                                            <!-- END FORM =========================================================-->

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- ITEM SELECT SIZE AND QTY -->
                        <div class="modal fade" id="modal-size_qty" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Select Size and Quantity </h4>
                                    </div>

                                    <!-- BEGIN FORM =======================================================-->
                                    <?php echo form_open(
                                        $url_pre.'/sales_orders/create',
                                        array(
                                            'class' => '',
                                            'id' => 'form-size_qty_select'
                                        )
                                    ); ?>

                                    <div class="modal-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                        <div class="form modal-body-cart_basket_wrapper margin-bottom-30">
                                            <?php // item contents go in here... ?>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline modal-size_qty_cancel" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="submit" class="btn dark modal-size_qty_submit"> Add To Sales Order </button>
                                    </div>

                                    </form>
                                    <!-- END FORM =========================================================-->

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>
                    <!-- END PAGE CONTENT BODY -->
