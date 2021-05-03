                    <?php
                    // let's set the role for sales user my account
                    $pre_link =
                        @$role == 'sales'
                        ? 'my_account/sales'
                        : 'admin/campaigns'
                    ;
					// hiding linesheet options for level 2 users
					if (@$role == 'sales' && @$this->sales_user_details->access_level == '2')
					{
						$hide_attach_linesheets = 'display-none';
						$hide_send_linesheets_only = 'display-none'; // also used at the items table print barcode link
					}
					else
					{
						$hide_attach_linesheets = '';
						$hide_send_linesheets_only = '';
					}
					?>
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row body-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

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
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
									<div class="alert alert-success item-added">
										<button class="close" data-close="alert"></button> Item ADDED!
									</div>
									<?php } ?>
									<?php if (validation_errors()) { ?>
									<div class="alert alert-danger">
										<button class="close" data-close="alert"></button> There was a problem with the form. Please check and try again. <br />
                                        <?php echo validation_errors(); ?>
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

                                <?php
								/***********
								 * Dropdowns and Options
								 */
								?>
                                <div class="form-group form-group-badge select-designer-dropdown">
                                    <label class="control-label col-md-5">
                                        <span class="badge custom-badge pull-left step-select-designer step1 active"> 1 </span>
                                        <span class="badge-label"> Designer / Webspace </span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" name="reference_designer" data-required="1" class="form-control input-sa_info clear-readonly" value="<?php echo @$designer; ?>" readonly />
                                    </div>
                                </div>
                                <div class="form-group form-group-badge select-vendor-dropdown">
                                    <label class="control-label col-md-5">
                                        <span class="badge custom-badge pull-left step-select_items step2 active"> 2 </span>
                                        <span class="badge-label"> Select / Search Products </span>
                                    </label>
                                    <div class="col-md-7">
                                        <cite class="help-block font-red" style="padding-top:3px;">
                                            Select From Options below
                                        </cite>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:;" class="btn dark btn-md select-product-options thumbs-grid-view col-md-4" style="<?php echo $this->session->admin_lb_mod_slug_segs ? 'background-color:#696969;' : ''; ?>">
                                            Select From Thumbnails
                                        </a>
                                        <a href="javascript:;" class="btn dark btn-md select-product-options search-multiple-form col-md-4">
                                            Multi Style Search
                                        </a>
                                        <!-- DOC: Add data-modal-id="modal-unlisted_style_no" attribute to make the button work -->
                                        <a href="javascript:;" data-toggle="modal" data-modal-id="modal-unlisted_style_no" class="btn dark btn-md select-product-options_ add-unlisted-style-no col-md-4 tooltips" data-original-title="Under Construction">
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
                                            <button type="button" class="btn dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Select Category
                                                <i class="fa fa-angle-down"></i>
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
                                                    <a href="javascript:;" data-des_slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>" data-page="modify">
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
                                                            .'" data-page="modify" data-des_slug="'
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

                                    <h3 class="blank-grid-text <?php echo @$slug_segs ? 'display-none' : ''; ?>">
                                        <em class="select-vendor">Select a category...</em>
                                    </h3>

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
                                        .ribbon.ribbon-color-danger {
                                            background-color: #ed6b75;
                                            color: #fff;
                                        }
                                        .ribbon.ribbon-color-info {
                                            background-color: #5c9bd1;
                                            color: #fff;
                                        }
                                        .ribbon.ribbon-vertical-right {
                                            clear: none;
                                            float: right;
                                            margin: -2px 10px 0 0;
                                            padding-top: 1em;
                                            padding-bottom: 1em;
                                            width: 41px;
                                            text-align: center;
                                        }
                                        .ribbon.ribbon-vertical-left {
                                            clear: none;
                                            float: right;
                                            margin: -2px 10px 0 0;
                                            padding-top: 1em;
                                            padding-bottom: 1em;
                                            width: 41px;
                                            text-align: center;
                                        }
                                        .ribbon {
                                            padding: .5em 1em;
                                                padding-top: 0.5em;
                                                padding-bottom: 0.5em;
                                            z-index: 5;
                                            float: left;
                                            margin: 10px 0 0 -2px;
                                            clear: left;
                                            position: relative;
                                        }
                                    </style>
                                    <div class="thumb-tiles-wrapper margin-top-20 <?php echo @$des_subcats ? '' : 'display-none'; ?>" data-row-count="<?php echo @$products_count; ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

        								<?php if (@$search_string) { ?>
        	                            <h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
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
                                                    // set ribbon for PRIVATE & UNPUBLISH items
                                                    $classes.= $product->publish != '1' ? 'mt-element-ribbon ' : '';

        											// let set the css style...
        											$styles = $dont_display_thumb;
        											//$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';

                                                    // ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
                                                    $ribbon_color = $product->publish == '0' ? 'danger' : 'info';
                                                    $tooltip = $product->publish == '3' ? 'Pending' : ($product->publish == '0' ? 'Unpubished' : 'Private');

        											// due to showing of all colors in thumbs list, we now consider the color code
        											// we check if item has color_code. if it has only product number use the primary image instead
        											$checkbox_check = '';
                                                    if (isset($sa_items[$style_no]))
        											{
        												$classes.= 'selected';
        												$checkbox_check = 'checked';
        											}

                                                    // check if item is on sale
                									$onsale = (@$product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

                                                    // get options if any
                                                    $color_options = json_decode($product->color_options, TRUE);
        											?>

        									<div class="thumb-tile image bg-blue-hoki <?php echo $classes.' '.$product->new_color_publish; ?> " style="<?php echo $styles; ?>">

                                                <!--<a href="<?php echo $img_large; ?>" class="fancybox tooltips" data-original-title="Click to zoom">-->
                                                <a href="javascript:;" class="package_items" data-prod_no="<?php echo $product->prod_no; ?>" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>" data-page="modify" data-category_slug="<?php echo $category_slug; ?>" data-access_level="<?php echo @$this->sales_user_details->access_level ?: '0'; ?>">

                                                    <div style="position:absolute;top:-3px;">

                                                        <?php if ($product->color_publish == 'N') { // color variant private ?>
                                                        <div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-info uppercase tooltips" data-placement="top" data-container="body" data-original-title="Private" style="width:25px;padding:1em 0;margin-right:1px;">
                                                            <i class="fa fa-info-circle"></i>
                                                        </div>
                                                        <?php } ?>

                                                        <?php if ($product->with_stocks == '0') { // color variant private ?>
                                                        <div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-danger uppercase tooltips" data-placement="top" data-container="body" data-original-title="Pre Order" style="width:25px;padding:1em 0;;margin-right:1px;">
                                                            <i class="fa fa-ban"></i>
                                                        </div>
                                                        <?php } ?>

                                                    </div>

        											<div class="corner"> </div>
        											<div class="check"> </div>
        											<div class="tile-body">
        												<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
        												<img class="img-a img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
        												<noscript>
        													<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
        													<img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
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
                                                    <!-- Plusbox -->
                                                    <i class="fa fa-plus package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="position:relative;left:5px;background:#ddd;line-height:normal;padding:1px 2px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>" data-page="modify"></i> &nbsp;
                                                    <!-- Checkbox --
        											<input type="checkbox" class="package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" name="prod_no" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" <?php echo $checkbox_check; ?> data-page="modify" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>" /> &nbsp;
                                                    -->
                                                    <span class="text-uppercase package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>" data-page="modify"> Add to Package </span>
        										</div>

        									</div>

        										<?php
        										$cnti++;
        										}
        									}
        									else
        									{
        										if (@$search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
        										else $txt1 = 'NO PRODUCTS TO LOAD...'.$this->session->po_slug_segs;
        										echo '<button class="btn default btn-block btn-lg hide"> '.$txt1.' </button>';
        									} ?>

        								</div>

        								<?php
        								if (@$cnti > 100)
        								{
        									echo '
        										<button class="btn default btn-block btn-lg" onclick="$(\'img\').unveil();$(\'.batch-2 .img-unveil\').trigger(\'unveil\');$(\'.btn-2, .batch-1\').show();$(this).hide();"> LOAD MORE... </button>
        									';

        									for ($batch_it = 2; $batch_it <= ($cnti / 100); $batch_it++)
        									{
        										echo '<button class="btn default btn-block btn-lg btn-'.$batch_it.'" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();'.(($batch_it + 1) > ($cnti / 100) ? '$(\'.no-more-to-load\').show()' : '').'" style="display:none;"> LOAD MORE... </button>';
        									}

        									echo '<button class="btn default btn-block btn-lg no-more-to-load" style="display:none;"> NO MORE TO LOAD... </button>';
        								}

        								// a fix for the float...
        								echo '<button class="btn default btn-block btn-lg" style="visibility:hidden"> NO MORE TO LOAD... </button>';
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
                                        		(@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/sales_package/search_multiple',
                                        		array(
                                        			'class' => 'sa-multi-search-form', // need this for the styling
                                                    'id' => 'sa-multi-search-form'
                                        		)
                                        	); ?>

                                                <style>
                                                    .multi-search-form-control.search_by_style {
                                                        width: 99%;
                                                        height: 30px;
                                                        border: 1px solid #ccc;
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

                        <div class="col col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <div class="col">
                                    <div class="form-group form-group-badge">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left step-refine_sales_package step3 <?php echo @$sa_items ? 'active' : ''; ?>"> 3 </span>
                                            <span class="badge-label"> Refine Sales Package </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Items are shown in this Sales Package below.
                                            </cite>
                                        </div>
                                    </div>

                                </div>

                                <?php
                                /***********
                                 * Noification area
                                 */
                                ?>
                                <div class="notifications col-sm-12 clearfix">
                                    <hr />
                                    <div class="alert alert-danger display-hide" data-test="test">
                                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
                                    <div class="alert alert-success ">
                                        <button class="close" data-close="alert"></button> Purchase Order successfully sent
                                    </div>
                                    <?php } ?>
                                </div>

                                <!-- BEGIN FORM =======================================================-->
                                <?php echo form_open(
                                    (@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/lookbook/modify/index/'.$sa_details->lookbook_id,
                                    array(
                                        'class' => 'form-horizontal',
                                        'id' => 'form-sa_mod_summary_review'
                                    )
                                ); ?>

                                <input type="hidden" name="last_modified" value="<?php echo time(); ?>" />

                                <?php
                                /***********
                                 * Sales Package Info
                                 */
                                ?>
                                <div class="col-sm-12 sa-info">

                                    <div class="form-body sa_info">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Package Name
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="lookbook_name" data-required="1" class="form-control input-sa_info" value="<?php echo $sa_details->lookbook_name; ?>" placeholder="Sales Package Name" <?php echo @$sa_options['product_clicks'] ? 'readonly' : ''; ?> />
                                                <cite class="help-block small"> A a user friendly name to identify this package as reference. </cite>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date Created
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="date_create" class="form-control input-sa_info" value="<?php echo is_numeric($sa_details->date_create) ? @date('Y-m-d', $sa_details->date_create) : $sa_details->date_create; ?>" readonly />
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email Subject
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="email_subject" data-required="1" class="form-control input-sa_info" value="<?php echo $sa_details->email_subject; ?>" placeholder="Email Subject" />
                                                <cite class="help-block small"> Used as the subject for the email. </cite>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Message
                                            </label>
                                            <div class="col-md-9">
                                                <textarea name="email_message" class="form-control summernote input-sa_info" id="summernote_1" data-error-container="email_message_error"><?php echo $sa_details->email_message ?: 'Here are designs that are now available. Review them for your store.'; ?></textarea>
                                                <cite class="help-block small"> A short message to the users. HTML tags are accepted. </cite>
                                                <div id="email_message_error"> </div>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label class="col-md-2 control-label">Options</label>
                                            <div class="col-md-10">
                                                <div class="mt-radio-list">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_prices-Y" class="radio-options" type="radio" name="options[w_prices]" value="Y" data-page="modify" data-option="w_prices" <?php echo @$sa_options['w_prices'] == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_prices-N" class="radio-options" type="radio" name="options[w_prices]" value="N" data-page="modify" data-option="w_prices" <?php echo @$sa_options['w_prices'] == 'Y' ? '' : 'checked="checked"'; ?>> No
                                                            <span></span>
                                                        </label>
                                                        <label class="" style="margin-bottom:0px;">
                                                            - Show prices
                                                        </label>
                                                    </div>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_prices-Y" class="radio-options" type="radio" name="options[w_sizes]" value="Y" data-page="modify" data-option="w_sizes" <?php echo @$sa_options['w_sizes'] == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_prices-N" class="radio-options" type="radio" name="options[w_sizes]" value="N" data-page="modify" data-option="w_sizes" <?php echo @$sa_options['w_sizes'] == 'Y' ? '' : 'checked="checked"'; ?>> No
                                                            <span></span>
                                                        </label>
                                                        <label class="" style="margin-bottom:0px;">
                                                            - Show availalbe sizes
                                                        </label>
                                                    </div>
                                                    <div class="mt-radio-inline hide <?php echo $hide_attach_linesheets; ?>">
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_images-Y" class="radio-options" type="radio" name="options[w_images]" value="Y" data-page="modify" data-option="w_images" <?php echo @$sa_options['w_images'] == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="w_images-N" class="radio-options" type="radio" name="options[w_images]" value="N" data-page="modify" data-option="w_images" <?php echo @$sa_options['w_images'] == 'Y' ? '' : 'checked="checked"'; ?>> No
                                                            <span></span>
                                                        </label>
                                                        <label class="" style="margin-bottom:0px;">
                                                            - Attach Linesheets
                                                        </label>
                                                    </div>
                                                    <div class="mt-radio-inline hide <?php echo $hide_send_linesheets_only; ?>">
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="linesheets_only-Y" class="radio-options" type="radio" name="options[linesheets_only]" value="Y" data-page="modify" data-option="linesheets_only" <?php echo @$sa_options['linesheets_only'] == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio mt-radio-outline" style="margin-bottom:0px;">
                                                            <input id="linesheets_only-N" class="radio-options" type="radio" name="options[linesheets_only]" value="N" data-page="modify" data-option="linesheets_only" <?php echo @$sa_options['linesheets_only'] == 'Y' ? '' : 'checked="checked"'; ?>> No
                                                            <span></span>
                                                        </label>
                                                        <label class="" style="margin-bottom:0px;">
                                                            - Send Linesheets Only
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body user_details">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Author
                                            </label>
                                            <div class="col-md-9">
                                                <span class="form-control">
                                                    <?php echo $author_name; ?> <cite class="small">(<?php echo safe_mailto($author_email); ?>)</cite>
                                                </span>
                                                <input type="hidden" name="user_role" value="<?php echo $author; ?>" />
                                                <input type="hidden" name="user_id" value="<?php echo $author_id; ?>" />
                                                <input type="hidden" name="user_name" value="<?php echo $author_name; ?>" />
                                                <input type="hidden" name="user_email" value="<?php echo $author_email; ?>" />
                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                </div>

                                <div class="col-sm-12 cart_basket_wrapper" style="margin-bottom:70px;">
                                    <div class="cart_basket">

                                        <?php $this->load->view('admin/metronic/sa_lookbook_modify_items'); ?>

                                    </div>
                                </div>

                                <div class="col-sm-12 ">
                                    <button type="submit" class="btn dark">Save and Send Sales Package</button>
                                </div>

                                </form>
                                <!-- END FORM =======================================================-->

                                <div class="col-sm-12 steps">

                                    <hr />
                                    <div class="form-group form-group-badge clearfix" style="margin-bottom:0px;">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left step-save_and_send <?php echo @$overall_qty ? 'active' : ''; ?> step4"> 4 </span>
                                            <span class="badge-label"> Save and Send Package </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Package will be saved and can be sent to users.
                                            </cite>
                                        </div>
                                    </div>

                                    <hr style="margin-top:0px;" />
                                    <a href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin/campaigns').'/lookbook/reset/index/'.$sa_details->lookbook_id); ?>" style="color:#333;">
                                        <div class="form-group form-group-badge form-group-badge-step4 clearfix">
                                            <label class="control-label col-md-5" style="cursor:pointer;">
                                                <span class="badge custom-badge pull-left step5 step-reset"> 5 </span>
                                                <span class="badge-label"> Reset Sales Package </span>
                                            </label>
                                            <div class="col-md-7">
                                                <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                    Sales Package will be reset to saved package.
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
                                        <h4 class="modal-title"> Add STYLE NUMBERS not on productl ist </h4>
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
                                                        if (@$colors)
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
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
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
                        <div id="modal-edit_item_price" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Edit Item Price</h4>
                                    </div>
                                    <div class="modal-body">

                                        <span class="eip-modal-item"></span>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-5">New Price
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="item_price" data-required="1" class="form-control input-sm modal-input-item-price" value="" size="2" data-prod_no="" data-item="" data-page="modify" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="button" class="btn dark submit-edit_item_prices" data-item="" data-page="modify">Apply changes</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- ITEM SIZE AND QTY INFO -->
                        <div class="modal fade" id="modal-size_qty_info" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Select Size and Quantity </h4>
                                    </div>

                                    <!-- BEGIN FORM =======================================================-->
                                    <?php echo form_open(
                                        $pre_link.'/sales_package/modify',
                                        array(
                                            'class' => '',
                                            'id' => 'form-size_qty_select'
                                        )
                                    ); ?>

                                    <div class="modal-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                        <div class="form modal-body-size_qty_info modal-body-cart_basket_wrapper margin-bottom-30">
                                            <?php // item contents go in here... ?>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline modal-size_qty_cancel" data-dismiss="modal" tabindex="-1">Cancel</button>
                                        <button type="submit" class="btn dark modal-size_qty_submit"> Add To Package </button>
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
