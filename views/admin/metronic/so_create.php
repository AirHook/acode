Discount                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">

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
								<div class="form-group form-group-badge">
                                    <label class="control-label col-md-4">
                                        <span class="badge custom-badge pull-left step1 active"> 1 </span>
                                        <span class="badge-label"> Select / Search Products </span>
                                    </label>
                                    <div class="col-md-8">
                                        <cite class="help-block font-red" style="padding-top:3px;">
                                            Select From Options below
                                        </cite>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:;" class="btn dark btn-md select-product-options thumbs-grid-view col-md-4" style="background-color:#696969;">
                                            Select From Thumbnails
                                        </a>
                                        <a href="javascript:;" class="btn dark btn-md select-product-options search-multiple-form col-md-4">
                                            Multi Style Search
                                        </a>
                                        <a href="javascript:;" data-toggle="modal" data-modal-id="modal-unlisted_style_no" class="btn dark btn-md select-product-options add-unlisted-style-no col-md-4">
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
                                    <div class="input-group categories-tree-wrapper ">
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
                                            <div class="categories-tree dropdown-menu">

                                                <?php
                                                $count_designers = count($designers);
                                                if ($designers)
                                                {
                                                    // set slug segs name to capture info
                                                    $slug_segs_name = array();

                                                    $descnt = 1;
                                                    foreach ($designers as $designer_details)
                                                    {
                                                        // get the designer category tree
                                        				$des_subcats = $this->categories_tree->treelist(
                                        					array(
                                        						'd_url_structure' => $designer_details->url_structure,
                                        						//'vendor_id' => $this->session->admin_po_vendor_id,
                                        						'with_products' => TRUE
                                        					)
                                        				);
                                        				$row_count = $this->categories_tree->row_count;
                                        				$max_level = $this->categories_tree->max_category_level;

                                                        if (@$des_subcats)
                                                        {
                                                            // set or check active slug
                                                            $slug_segs = @$slug_segs ?: array();
                                                            $cnt_slug_segs = count($slug_segs) - 2;

                                                            // generate designer slugs and name for link and front end
                                                            $slugs_link = array($designer_details->url_structure);
                                                            $slugs_link_name = array();

                                                            // designer level
                                                            // set active where necessary
                                                            if (strpos(implode('/', $slug_segs), $designer_details->url_structure) !== FALSE)
                                                            {
                                                                $active = 'bold';
                                                                array_push($slug_segs_name, $designer_details->designer);
                                                            }
                                                            else $active = '';

                                                            // get active category names
                                                            if ($active == 'bold' OR $active == 'bold active')
                                                            {
                                                                array_push($slugs_link_name, $designer_details->designer);
                                                            }
                                                            ?>

                                                <div style="display:inline-block;vertical-align:top;">
                                                    <ul class="designer-categories-tree list-unstyled">
                                                        <li class="<?php echo $active; ?> designer-level" data-slug="<?php echo $designer_details->url_structure; ?>" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
                                                            <a href="javascript:;" data-slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
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
                                                            foreach ($des_subcats as $category)
                                                            {
                                                                // set margin
                                                                $margin = 'padding-left:'.($marg * ($category->category_level + 2)).'px;';

                                                                // if first row...
                                                                if ($ic == 1)
                                                                {
                                                                    // create link
                                                                    array_push($slugs_link, $category->category_slug);

                                                                    // save as previous level
                                                                    // always starts at 0
                                                                    $prev_level = $category->category_level;
                                                                }
                                                                else
                                                                {
                                                                    // if same category level
                                                                    if ($category->category_level == $prev_level)
                                                                    {
                                                                        // create new link
                                                                        $pop = array_pop($slugs_link); // remove previous last seg
                                                                        array_push($slugs_link, $category->category_slug); // replace with new one
                                                                    }

                                                                    // NOTE: next greater level is always greater by only 1 level
                                                                    if ($category->category_level == $prev_level + 1)
                                                                    {
                                                                        // append to previous link
                                                                        array_push($slugs_link, $category->category_slug);
                                                                    }

                                                                    // if next category level is lower
                                                                    if ($category->category_level < $prev_level)
                                                                    {
                                                                        for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
                                                                        {
                                                                            // update link
                                                                            $pop = array_pop($slugs_link);
                                                                        }

                                                                        // append to link
                                                                        array_push($slugs_link, $category->category_slug);
                                                                    }
                                                                }

                                                                // if slug_segs
                                                                if ( ! empty($slug_segs))
                                                                {
                                                                    // set active where necessary
                                                                    if (strpos(implode('/', $slug_segs), implode('/', $slugs_link)) !== FALSE)
                                                                    {
                                                                        $active = $cnt_slug_segs == $category->category_level ? 'bold active' : 'bold';
                                                                        array_push($slug_segs_name, $category->category_name);
                                                                    }
                                                                    else $active = '';
                                                                }

                                                                // get active category names
                                                                if ($active == 'bold' OR $active == 'bold active')
                                                                {
                                                                    array_push($slugs_link_name, $category->category_name);
                                                                }

                                                                // if this is last row, set slug segs
                                                                $cat_crumbs = '';
                                                                if ($ic == $row_count)
                                                                {
                                                                    // capture the active slugs
                                                                    //$slug_segs = @$slug_segs ?: $slugs_link;
                                                                    //$slug_segs_name = $slug_segs_name ?: $slugs_link_name;
                                                                    $p_slug_segs = 'data-slug_segs="'.implode('/', $slug_segs).'" ';
                                                                    $p_slug_segs_name = 'data-slug_segs_name="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" ';

                                        							// need to show the category crumbs for use at front end
                                        							if ($descnt == $count_designers)
                                        							{
                                        								$cat_crumbs = '<input type="hidden" name="cat_crumbs" value="'.implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name).'" />';
                                        							}
                                                                }

                                                                // first row is usually the top main category...
                                                                echo '<li class="category_list '
                                                                    .$active
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
                                                                    .'" data-slugs_link="'
                                                                    .implode('/', $slugs_link)
                                                                    .'">'
                                                                    .'<a href="javascript:;" style="font-size:0.8em;'
                                                                    .$margin
                                                                    .'" data-slugs_link="'
                                                                    .implode('/', $slugs_link)
                                                                    .'" data-des_slug="'
                                                                    .$designer_details->url_structure
                                                                    .'">'
                                                                    .$category->category_name
                                                                    .'</a>'
                                        							.$cat_crumbs
                                        							.'</li>'
                                                                ;

                                                                $prev_level = $category->category_level;
                                                                $ic++;
                                                            }

                                                            echo '</ul></div>';
                                                        }

                                                        $descnt++;
                                                    }
                                                } ?>

                                            </div>
                                        </div>
                                        <!-- /btn-group -->
                                        <div class="form-control cat_crumbs" style="font-style:italic;font-size:0.8em;">
                                            <?php echo implode(' &nbsp;&raquo;&nbsp; ', $slug_segs_name); ?>
                                        </div>
                                    </div>
                                    <!-- /input-group -->

                                    <?php if ( ! @$products) { ?>
                                    <h3 class="blank-grid-text <?php echo $this->session->admin_so_vendor_id ? 'display-none' : ''; ?>">
                                        <em class="select-vendor">Select a category...</em>
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
        											$classes.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') ? 'mt-element-ribbon ' : '';

        											// let set the css style...
        											$styles = $dont_display_thumb;
        											$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';

                                                    // ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
                                    				$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
                                    				$tooltip = $product->publish == '3' ? 'Pending' : (($product->publish == '0' OR $product->view_status == 'N') ? 'Unpubished' : 'Private');

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

        										<a href="<?php echo $img_large; ?>" class="fancybox tooltips" data-original-title="Click to zoom">

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
        													<?php echo $product->color_name; ?>
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
                                        		'admin/sales_orders/search_multiple',
                                        		array(
                                                    'class' => 'sa-multi-search-form', // need this for the styling
                                                    'id' => 'so-multi-search-form'
                                        		)
                                        	); ?>

                                                <style>
                                                    .multi-search-form-control.search_by_style {
                                                        width: 190px;
                                                    }
                                                </style>

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
                                            <span class="badge custom-badge pull-left step2 <?php echo $items_count > 0 ? 'active' : ''; ?>"> 2 </span>
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
                                    'admin/sales_orders/create',
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

                                <?php
                                /***********
                                 * SO Number
                                 */
                                ?>
                                <div class="col-sm-12 so-summary-number">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>
                                                SALES ORDER #<?php echo @$this->session->so_number ?: @$so_number; ?> <br />
                                                <small> Date: <?php echo date('Y-m-d', time()); ?> </small>
                                            </h3>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div>
                                                        <input type="text" name="options[ref_so_no]" value="" class="form-control input-sm" />
                                                        <span class="help-block small">[Optional]: <cite>Reference manual SO#.</cite></span>
                                                    </div>
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

                                        <div class="col-sm-12">
                                            <em class="small">Bill To / Ship To Options:</em>
                                            &nbsp;
                                            <a href="#modal-select_store" data-toggle="modal" class="btn btn-xs grey-gallery" type="button">Select Store</a>
                                            <button class="btn btn-xs grey-gallery hide" type="button">Select Consumer</button>
                                            <a href="#modal-enter_manual_info" data-toggle="modal" class="btn btn-xs grey-gallery" type="button">Enter Manual Info</a>
                                        </div>

                                        <div class="col-sm-6">

                                            <h5> BILL TO </h5>

                                            <p class="customer-billing-address">
                                                <?php echo @$store_details->store_name ?: 'CUSTOMER NAME'; ?> <br />
                                                <?php echo @$store_details->address1 ?: 'Address1'; ?> <br />
                                                <?php echo @$store_details->address2 ? $store_details->address2.'<br />' : 'Address2<br />'; ?>
                                                <?php echo @$store_details->city ?: 'City'; ?>, <?php echo @$store_details->state ?: 'State'; ?> <br />
                                                <?php echo @$store_details->country ?: 'Country'; ?> <br />
                                                <?php echo @$store_details->telephone ?: 'Telephone'; ?> <br />
                                                ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : 'Contact Name'; ?> <?php echo @$store_details->email ? '('.safe_mailto($store_details->email).')': '(email)'; ?>
                                            </p>

                                            <span id="user_id_error_container" class="help-block has-block-error has-error"></span>

                                        </div>
                                        <div class="col-sm-6">

                                            <h5> SHIP TO </h5>

                                            <p class="customer-shipping-address">
                                                <?php echo @$store_details->store_name ?: 'CUSTOMER NAME'; ?> <br />
                                                <?php echo @$store_details->address1 ?: 'Address1'; ?> <br />
                                                <?php echo @$store_details->address2 ? $store_details->address2.'<br />' : 'Address2<br />'; ?>
                                                <?php echo @$store_details->city ?: 'City'; ?>, <?php echo @$store_details->state ?: 'State'; ?> <br />
                                                <?php echo @$store_details->country ?: 'Country'; ?> <br />
                                                <?php echo @$store_details->telephone ?: 'Telephone'; ?> <br />
                                                ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : 'Contact Name'; ?> <?php echo @$store_details->email ? '('.safe_mailto($store_details->email).')': '(email)'; ?>
                                            </p>

                                        </div>

                                        <input type="hidden" name="user_id" value="<?php echo $this->session->admin_so_user_id; ?>" data-error-container="user_id_error_container" />

                                    </div>
                                </div>

                                <?php
                                /***********
                                 * Sales User / Author Info
                                 */
                                ?>
                                <div class="col-sm-12 sales_user_details">
                                    <p>
                                        Sales Person: &nbsp;<?php echo @$author_name ?: 'In-House'; ?> (<?php echo safe_mailto(@$author_email ?: $this->webspace_details->info_email); ?>)
                                    </p>
                                    <input type="hidden" name="author" value="1" /> <!-- defaults to '1' for In-House -->
                                    <input type="hidden" name="c" value="1" /> <!-- 1-admin, 2-sales -->
                                </div>

                                <?php
                                /***********
                                 * SO Options 1
                                 */
                                ?>
                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options1">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Ref Check Out Order# (if any): </h6>
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
                                 */
                                ?>
                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options2">
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
                                                .size-select {
                                                    border: 0;
                                                    font-size: 10px;
                                                    width: 30px;
                                                   -webkit-appearance: none;
                                                    -moz-appearance: none;
                                                    appearance: none;
                                                }
                                                .size-select:after {
                                                    content: "\f0dc";
                                                    font-family: FontAwesome;
                                                    color: #000;
                                                }
                                            </style>

                                            <table class="table table-striped table-hover table-light " data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center" style="padding:unset;border-bottom:none;border-right:1px solid #F2F5F8;"> Qty </th>
                                                        <th colspan="6" style="border-bottom:none;"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" style="width:25px;vertical-align:top;"> Req'd </th>
                                                        <th class="text-center" style="width:25px;vertical-align:top;"> Ship'd </th>
                                                        <th class="text-center" style="width:25px;vertical-align:top;border-right:1px solid #F2F5F8;"> B.O. </th>
                                                        <th style="vertical-align:top;"> Items (<span class="items_count"><?php echo $items_count; ?></span>) </th>
                                                        <th style="vertical-align:top;"> Desc </th>
                                                        <th></th> <!-- Remove button -->
                                                        <th style="vertical-align:top;width:60px;" class="text-right">
                                                            Unit Price
                                                        </th>
                                                        <th style="vertical-align:top;width:50px;" class="text-right"> Disc </th>
                                                        <th style="vertical-align:top;width:60px;" class="text-right"> Extended </th>
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
                                                            if (@$product->custom_order == '3')
                                                            {
                                                                $price =
                                                                    $this->session->admin_so_user_cat == 'ws'
                                                                    ? (@$product->wholesale_price_clearance ?: 0)
                                                                    : (@$product->retail_sale_price ?: 0)
                                                                ;
                                                            }
                                                            else
                                                            {
                                                                $price =
                                                                    $this->session->admin_so_user_cat == 'ws'
                                                                    ? (@$product->wholesale_price ?: 0)
                                                                    : (@$product->retail_price ?: 0)
                                                                ;
                                                            }

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
                                                        <td class="text-center" style="vertical-align:top;">
                                                            <?php echo $qty[0]; ?>
                                                            <br />
                                                            <i class="fa fa-pencil small tooltips font-grey-silver modal-edit_quantity" data-original-title="Edit Qty" data-placement="bottom" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>"></i>
                                                        </td>
                                                        <td class="text-center" style="vertical-align:top;"><?php echo $qty[1]; ?></td>
                                                        <td class="text-center" style="vertical-align:top;"><?php echo $qty[2]; ?></td>

                                                        <?php
                                                        /**********
                                                         * Item Number
                                                         */
                                                        ?>
                                                        <td style="vertical-align:top;">
                                                            <?php echo $prod_no; ?><br />
                                                            <?php echo $color_name; ?><br />
                                                            <?php echo 'Size '.$s; ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * IMAGE and Descriptions
                                                         */
                                                        ?>
                                                        <td>
                                                            <a href="<?php echo $img_large ?: 'javascript:;'; ?>" class="<?php echo $img_large ? 'fancybox' : ''; ?> pull-left">
                                                                <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL'); ?>images/instylelnylogo_3.jpg');" />
                                                            </a>
                                                            <div class="shop-cart-item-details" style="margin-left:65px;">
                                                                <h4 style="margin:0px;">
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
                                                         * Remove button
                                                         */
                                                        ?>
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-link btn-xs summary-item-remove tooltips" data-original-title="Remove Item" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>" data-size_label="<?php echo $size_label; ?>">
                                                                <i class="fa fa-close"></i> <cite class="small hide">rem</cite>
                                                            </button>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Unit Price
                                                         */
                                                        ?>
                                                        <td class="text-right unit-price-wrapper <?php echo $item.' '.$prod_no; ?>" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>">
                                                            $ <?php echo number_format($price, 2); ?>
                                                        </td>

                                                        <?php
                                                        /**********
                                                         * Discount
                                                         */
                                                        ?>
                                                        <td class="text-right discount-wrapper <?php echo $item.' '.$prod_no; ?>">
                                                            <?php
                                                            $disc = @$options['discount'] ?: 0;
                                                            if ($disc == '0') echo '-';
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
                                                        <td class="text-right order-subtotal <?php echo $item.' '.$prod_no; ?>">
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

                                                        <input type="hidden" class="hidden-overall_qty" value="<?php echo $overall_qty; ?>" />
                                                        <input type="hidden" class="hidden-overall_total" value="<?php echo $overall_total; ?>" />

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
                                            <span class="badge custom-badge pull-left <?php echo @$overall_qty ? 'active' : ''; ?> step3"> 3 </span>
                                            <span class="badge-label"> Create Sales Order </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Sales Order will be created and submitted pending.
                                            </cite>
                                        </div>
                                    </div>

                                    <hr style="margin-top:0px;" />
                                    <a href="<?php echo site_url('admin/sales_orders/reset'); ?>" style="color:#333;">
                                        <div class="form-group form-group-badge form-group-badge-step4 clearfix">
                                            <label class="control-label col-md-5" style="cursor:pointer;">
                                                <span class="badge custom-badge pull-left step4"> 4 </span>
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

                                                <div class="alert alert-warning hide">
        											<button class="close" data-close="alert"></button>
        											Select only one user
        										</div>

        										<div class="form-group">
        											<label>My Users:<span class="required"> * </span>
        											</label>
        											<div class="form-control height-auto">
        												<div class="scroller" style="height:300px;" data-always-visible="1">

        													<div id="email_array_error"> </div>
        													<div class="mt-checkbox-list">

        														<?php foreach ($users as $user)
        														{
                                                                    $checked =
                                                                        $this->session->admin_so_user_id == $user->user_id
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

                        <!-- ENTER MANUAL INFO -->
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
                                                    <a href="javascript:;" class="btn dark btn-outline enter-user cs" data-user="cs"> CONSUMER USER </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="send_to_new_user form-body">

                                            <!-- BEGIN FORM =======================================================-->
                                            <?php echo form_open(
                                                'admin/sales_orders/add_new_user',
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
        										<input type="hidden" name="reference_designer" class="send_to_new_user" value="<?php echo @$this->sales_user_details->designer ?: $this->webspace_details->slug; ?>" />
        										<input type="hidden" name="admin_sales_email" class="send_to_new_user" value="<?php echo @$this->sales_user_details->email ?: $this->webspace_details->info_email; ?>" />
        										<input type="hidden" name="admin_sales_id" class="send_to_new_user" value="<?php echo @$this->sales_user_details->admin_sales_id ?: '1'; ?>" />

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
                                                'admin/sales_orders/add_new_user',
                                                array(
                                                    'class' => 'enter-user-form cs clearfix display-none',
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

                        <!-- ITEM SELECT SIZE AND QTY -->
                        <div class="modal fade" id="modal-size_qty" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Select Item's Size and Quantity </h4>
                                    </div>
                                    <div class="modal-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                        <div class="form modal-body-cart_basket_wrapper margin-bottom-30">
                                            <?php // item contents go in here... ?>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline modal-size_qty_cancel" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn dark hide"> Submit </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>
                    <!-- END PAGE CONTENT BODY -->
