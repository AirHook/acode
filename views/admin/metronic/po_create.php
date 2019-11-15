                    <!-- BEGIN PAGE CONTENT BODY -->
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
                                </style>

                                <?php
								/***********
								 * Dropdown and Options
								 */
								?>
                                <div class="form-group form-group-badge select-vendor-dropdown">
                                    <label class="control-label col-md-4">
                                        <span class="badge custom-badge active pull-left step1"> 1 </span>
                                        <span class="badge-label"> Select Vendor </span>
                                    </label>
                                    <div class="col-md-8">
                                        <select class="bs-select form-control" name="vendor_id" data-live-search="true" data-size="5" data-show-subtext="true" data-vendor_id="<?php echo $this->session->admin_po_vendor_id; ?>">
                                            <?php if ( ! $this->session->admin_po_vendor_id) { ?>
                                            <option class="option-placeholder" value="">Select Vendor...</option>
                                            <?php } ?>
                                            <?php
                                            if (@$vendors)
                                            {
                                                foreach ($vendors as $vendor)
                                                { ?>

                                            <option value="<?php echo $vendor->vendor_id; ?>" data-subtext="<em><?php echo $vendor->designer; ?></em>" data-des_slug="<?php echo $vendor->url_structure; ?>" data-des_id="<?php echo $vendor->des_id; ?>" <?php echo $vendor->vendor_id === $this->session->admin_po_vendor_id ? 'selected="selected"' : ''; ?>>
                                                <?php echo ucwords(strtolower($vendor->vendor_name)).' ('.$vendor->vendor_code.')'; ?>
                                            </option>

                                                    <?php
                                                }
                                            } ?>
                                        </select>
                                        <input type="hidden" name="des_slug" value="<?php echo $this->session->admin_po_des_url_structure; ?>" />
                                        <input type="hidden" name="cur_vendor_id" value="<?php echo $this->session->admin_po_vendor_id; ?>" />
                                    </div>
                                </div>
								<div class="form-group form-group-badge">
                                    <label class="control-label col-md-4">
                                        <span class="badge custom-badge pull-left step2 <?php echo $this->session->admin_po_vendor_id ? 'active' : ''; ?>"> 2 </span>
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
                                        <a href="javascript:;" class="btn dark btn-md select-product-options thumbs-grid-view col-md-4" style="<?php echo $this->session->admin_po_vendor_id ? 'background-color:#696969;' : ''; ?>">
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
                                    <div class="input-group categories-tree-wrapper">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Select Category
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <style>
                                                .categories-tree {
                                                    min-width: 250px;
                                                }
                                                .categories-tree li.bold > a {
                                                    font-weight: bold;
                                                }
                                                .categories-tree li > a {
                                                    padding: 5px 16px;
                                                }
                                                .categories-tree li:first-child > a {
                                                    margin-top: 15px;
                                                }
                                                .categories-tree li:last-child > a {
                                                    margin-bottom: 15px;
                                                }
                                            </style>
                                            <ul class="categories-tree dropdown-menu">

                                                <?php
                                                if (@$des_subcats)
                                                {
                                                    // set or check active slug
                                            		$slug_segs = $slug_segs ?: array();
                                            		$cnt_slug_segs = count($slug_segs) - 1;

                                            		// designer top level list is always active
                                            		// ergo, set as first slugs_link
                                            		$slugs_link = array($designer_details->url_structure);
                                                    $slugs_link_name = array();
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
                                                    Please select a vendor...
                                                </li>

                                                    <?php
                                                }?>

                                            </ul>
                                        </div>
                                        <!-- /btn-group -->
                                        <div class="form-control cat_crumbs" style="font-style:italic;">
                                            <?php echo @$slug_segs ? implode(' &nbsp;&raquo;&nbsp; ', @$slug_segs_name) : ''; ?>
                                        </div>
                                    </div>
                                    <!-- /input-group -->

                                    <h3 class="blank-grid-text <?php echo $this->session->admin_po_vendor_id ? 'display-none' : ''; ?>">
                                        <em class="select-vendor">Select a vendor...</em>
                                    </h3>

                                    <?php
                                    /***********
                                     * Thumbs
                                     */
                                    ?>
                                    <style>
                                        .thumb-tiles {
                                            position: relative;
                                            margin-right: -10px;
                                        }
                                        .thumb-tiles .thumb-tile {
                                            display: block;
                                            float: left;
                                            <?php
                                            // calc width and height (2/3 = w/h)
                                            $imgw = '160';
                                            $imgh = (3*$imgw)/2;
                                            ?>
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
        									if ($products)
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

        											// due to showing of all colors in thumbs list, we now consider the color code
        											// we check if item has color_code. if it has only product number use the primary image instead
        											$checkbox_check = '';
                                                    if (isset($po_items[$style_no]))
        											{
        												$classes.= 'selected';
        												$checkbox_check = 'checked';
        											}
        											?>

        									<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

        										<a href="<?php echo $img_large; ?>" class="fancybox tooltips" data-original-title="Click to zoom">

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
                                                    <!-- Plusbox
                                                    <i class="fa fa-plus package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="position:relative;left:5px;background:#ddd;line-height:normal;padding:1px 2px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
                                                    -->
                                                    <!-- Checkbox -->
        											<input type="checkbox" class="package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" name="prod_no" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" <?php echo $checkbox_check; ?> /> &nbsp;
                                                    <span style="text-transform:uppercase;"> Add to Order </span>
        										</div>

        									</div>

        										<?php
        										$cnti++;
        										}
        									}
        									else
        									{
        										if ($search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
        										else $txt1 = 'NO PRODUCTS TO LOAD...'.$this->session->admin_po_slug_segs;
        										echo '<button class="btn default btn-block btn-lg"> '.$txt1.' </button>';
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
                                        		'admin/purcahse_orders/search_multiple',
                                        		array(
                                        			'class' => 'sa-multi-search-form', // need this for the styling
                                                    'id' => 'po-multi-search-form'
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

                        <div class="col col-md-6" style="border:1px solid #ccc;min-height:500px;">
                            <div class="row">

                                <div class="col">
                                    <div class="form-group form-group-badge">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left step3 <?php echo $items_count > 0 ? 'active' : ''; ?>"> 3 </span>
                                            <span class="badge-label"> Refine Purchase Order </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Selected items will show in this PO.
                                            </cite>
                                        </div>
                                    </div>

                                    <h3 class="col-md-12 blank-grid-text <?php echo $this->session->admin_po_vendor_id ? 'display-none' : ''; ?>">
                                        <em class="select-vendor">Select a vendor...</em>
                                    </h3>

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
                                    <div class="alert alert-success item-added" style="display:none;">
										<button class="close" data-close="alert"></button> Item ADDED!
									</div>
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

                                <div class="site-company-details hide">
                                    <span class="name"><?php echo $this->webspace_details->name; ?></span>
                                    <span class="address1"><?php echo $this->webspace_details->address1; ?></span>
                                    <span class="address2"><?php echo $this->webspace_details->address2; ?></span>
                                    <span class="city"><?php echo $this->webspace_details->city; ?></span>
                                    <span class="state"><?php echo $this->webspace_details->state; ?></span>
                                    <span class="zipcode"><?php echo $this->webspace_details->zipcode; ?></span>
                                    <span class="country"><?php echo $this->webspace_details->country; ?></span>
                                    <span class="telephone"><?php echo $this->webspace_details->phone; ?></span>
                                    <span class="contact"><?php echo $this->webspace_details->owner; ?></span>
                                    <span class="email"><?php echo $this->webspace_details->info_email; ?></span>
                                </div>

                                <div class="col-sm-8 po-summary-company clearfix">
                                    <div class="row">
                                        <div class="col-sm-12 company-details">

                                            <h3 class="company_name"> <?php echo @$company_name; ?> </h3>

                                            <p>
                                                <span class="company_address1"><?php echo @$company_address1; ?></span><br />
                                                <?php echo @$company_address2
                                                    ? '<span class="company_address2">'.$company_address2.'</span><br />'
                                                    : ''
                                                ; ?>
                                                <?php echo '<span class="company_city">'.@$company_city.'</span>, '
                                                    .'<span class="company_state">'.@$company_state.'</span> '
                                                    .'<span class="company_zipcode">'.@$company_zipcode.'</span>'
                                                ; ?><br />
                                                <span class="company_country"><?php echo @$company_country; ?></span><br />
                                                <span class="company_telephone"><?php echo @$company_telephone; ?></span>
                                            </p>

                                        </div>
                                    </div>
                                </div>

                                <!-- BEGIN FORM =======================================================-->
                                <?php echo form_open(
                                    'admin/purchase_orders/create',
                                    array(
                                        'class' => 'form-horizontal',
                                        'id' => 'form-po_create_summary_review'
                                    )
                                ); ?>

                                <input type="hidden" name="po_number" value="<?php echo @$po_number; ?>" />
                                <input type="hidden" name="po_date" value="<?php echo date('Y-m-d', time()); ?>" />
                                <input type="hidden" name="des_id" value="<?php echo @$des_id; ?>" />

                                <div class="col-sm-12 po-summary-number">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>
                                                PURCHASE ORDER #<?php echo @$this->session->po_number ?: @$po_number; ?> <br />
                                                <small> Date: <?php echo date('Y-m-d', time()); ?> </small>
                                            </h3>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div>
                                                        <input type="text" name="options[ref_po_no]" value="" class="form-control" />
                                                        <span class="help-block small">[Optional]: <cite>Reference manual PO#.</cite></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 po-summary-addresses">
                                    <div class="row">

                                        <div class="col-sm-6">

                                            <h5> TO (Vendor Details) </h5>

                                            <p class="vendor-address">
                                                <?php echo @$vendor_details->vendor_name ?: 'VENDOR NAME'; ?> <br />
                                                <?php echo @$vendor_details->address1 ?: 'Address1'; ?> <br />
                                                <?php echo @$vendor_details->address2 ? $vendor_details->address2.'<br />' : ''; ?>
                                                <?php echo @$vendor_details->city ?: 'City'; ?>, <?php echo @$vendor_details->state ?: 'State'; ?> <br />
                                                <?php echo @$vendor_details->country ?: 'Country'; ?> <br />
                                                <?php echo @$vendor_details->telephone ?: 'Telephone'; ?> <br />
                                                ATTN: <?php echo @$vendor_details->contact_1 ?: 'Contact Name'; ?> <?php echo @$vendor_details->vendor_email ? '('.safe_mailto($vendor_details->vendor_email).')': '(email)'; ?>
                                            </p>

                                        </div>
                                        <div class="col-sm-6">

                                            <h5> SHIP TO
                                                <span class="edit-reset-ship-to <?php echo $this->session->admin_po_vendor_id ?: 'display-none'; ?>">
                                                    <a href="javascript:;" class="reset-ship-to small"> <em>reset to defualt</em> </a>
                                                </span>
                                            </h5>

                                            <p class="ship-to-details">
                                                <?php echo @$store_details->store_name
                                                    ?: '<span class="company_name">'.@$company_name.'</span>'
                                                ; ?> <br />
                                                <?php echo @$store_details->address1
                                                    ?: '<span class="company_address1">'.@$company_address1.'</span>'
                                                ; ?> <br />
                                                <?php echo @$store_details->address2
                                                    ? $store_details->address2.'<br />'
                                                    : (
                                                        @$company_address2
                                                        ? '<span class="company_address2">'.$company_address2.'</span><br />'
                                                        : ''
                                                    )
                                                ; ?>
                                                <?php echo @$store_details->city ?: '<span class="company_city">'.@$company_city,'</span>'; ?>, <?php echo @$store_details->state ?: '<span class="company_state">'.@$company_state.'</span>'; ?> <?php echo @$store_details->zipcode ?: '<span class="company_zipcode">'.@$company_zipcode.'</span>'; ?> <br />
                                                <?php echo @$store_details->country
                                                    ?: '<span class="company_country">'.@$company_country.'</span>'
                                                ; ?> <br />
                                                <?php echo @$store_details->telephone
                                                    ?: '<span class="company_telephone">'.@$company_telephone.'</span>'
                                                ; ?> <br />
                                                ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : '<span class="company_contact_person">'.@$company_contact_person.'</span>'; ?> <?php echo @$store_details->email ? '('.safe_mailto($store_details->email).')' : '(<span class="company_contact_email">'.safe_mailto(@$company_contact_email).'</span>)'; ?>
                                            </p>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 sales_user_details">
                                    <p>
                                        Ordered by: &nbsp;<?php echo @$author_name; ?> (<?php echo safe_mailto(@$author_email); ?>)
                                    </p>
                                </div>

                                <div class="col-sm-12 m-grid m-grid-responsive-sm po-summary-options1">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Reference SO# (if any): </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline" size="16" type="text" value="" name="options[ref_so_no]" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> Store Name (optional): </h6>
                                            <div class="form-group row" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                                <div class="col-md-12">
                                                    <select class="bs-select form-control pull-right" name="options[po_store_id]" data-live-search="true" data-size="5" data-show-subtext="true" data-container="body">
                                                        <option class="option-placeholder" value="">Select Store...</option>
                                                        <?php
                                                        if (@$stores)
                                                        {
                                                            foreach ($stores as $store)
                                                            { ?>

                                                        <option value="<?php echo $store->user_id; ?>" data-subtext="<em><?php echo $store->email; ?></em>" data-des_slug="<?php echo $store->reference_designer; ?>" <?php echo set_select('user_id', $store->user_id, ($store->user_id === $this->session->admin_po_store_id)); ?>>
                                                            <?php echo ucwords(strtolower($store->store_name)); ?>
                                                        </option>

                                                                <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                    <input class="form-control form-control-inline" size="16" type="hidden" value="<?php echo $this->session->admin_po_store_id; ?>" name="po_store_id" readonly />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> For Stock Replenishment </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <input type="checkbox" name="options[stock_replenishment]" value="1" />
                                                            <span></span>
                                                        </span>
                                                        <input type="text" class="form-control" value="Stock Replenishment" readonly style="background-color:transparent;" />
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 m-grid m-grid-responsive-sm po-summary-options2">
                                    <div class="m-grid-row">
                                        <div class="m-grid-col">

                                            <h6> Start Date: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="" name="start_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                    <span class="help-block small" style="font-size:0.8em;"> Click to Select date </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> Cancel Date: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="" name="cancel_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                    <span class="help-block small" style="font-size:0.8em;"> Click to Select date </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-grid-col">

                                            <h6> Delivery Date: </h6>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="<?php echo set_value('delivery_date'); ?>" name="delivery_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
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

                                <div class="col-sm-12 cart_basket_wrapper">

                                    <div class="clearfix">
                                        <h4> Details: </h4>
                                    </div>

                                    <div class="cart_basket">

                                        <hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

                                        <div class="table-scrollable table-scrollable-borderless">

                                            <style>
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
                                                        <th style="vertical-align:top;"> Items (<span class="items_count"><?php echo $items_count; ?></span>) </th>
                                                        <th style="vertical-align:top;"> Size and Qty </th>
                                                        <th style="vertical-align:top;"> </th>
                                                        <th style="vertical-align:top;min-width:80px;" class="text-right">
                                                            Unit Price <br />
                                                        </th>
                                                        <th style="vertical-align:top;min-width:80px;" class="text-right"> Subtotal </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="1"></th>
                                                        <th colspan="3" class="text-right">
                                                            <cite class="small" style="font-weight:100;">show/edit unit price</cite>
                                                            <input type="checkbox" class="show_vendor_price" name="options[show_vendor_price]" value="1" <?php echo $this->session->admin_po_edit_vendor_price ? 'checked' : ''; ?> />
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if ( ! empty($po_items))
                                                    {
                                                        $overall_qty = 0;
                                                        $overall_total = 0;
                                                        foreach ($po_items as $item => $options)
                                                        {
                                                            // get product details
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
                                                            $vendor_price =
                                                                isset($options['vendor_price'])
                                                                ? $options['vendor_price']
                                                                : (@$product->vendor_price ?: 0)
                                                            ;
                                                            $temp_size_mode = 1; // default size mode

                                                            if ($product)
                                                            {
                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
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
                                                                $size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
                                                                $color_name = $this->product_details->get_color_name($color_code);
                                                            }

                                                            // get size names
                                                            $size_names = $this->size_names->get_size_names($size_mode);
                                                            ?>

                                                    <tr class="summary-item-container">
                                                        <?php
                                                        /**********
                                                         * Item IMAGE and Details
                                                         * Image links to product details page
                                                         */
                                                        ?>
                                                        <td>
                                                            <a href="<?php echo $img_linesheet ?: 'javascript:;'; ?>" class="<?php echo $img_linesheet ? 'fancybox' : ''; ?> pull-left">
                                                                <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL'); ?>images/instylelnylogo_3.jpg');" />
                                                            </a>
                                                            <div class="shop-cart-item-details" style="margin-left:65px;">
                                                                <h4 style="margin:0px;">
                                                                    <?php echo $item; ?>
                                                                </h4>
                                                                <p style="margin:0px;">
                                                                    <span style="color:#999;">Style#:&nbsp;<?php echo $item; ?></span><br />
                                                                    Color: &nbsp; <?php echo $color_name; ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <?php
                                                        /**********
                                                         * Size and Qty
                                                         */
                                                        ?>
                                                        <td class="size-and-qty-wrapper">

                                                            <?php
                                                            $this_size_qty = 0;
                                                            foreach ($size_names as $size_label => $s)
                                                            {
                                                                $size_qty =
                                                                    ! empty($options) && isset($options[$size_label])
                                                					? $options[$size_label]
                                                                    : 0
                                                                ;
                                                                $this_size_qty += $size_qty;
                                                                if ($s == 'XL1' OR $s == 'XL2') continue;
                                                                ?>

                                                            <div class="sizes" style="display:inline-block;" data-size_qty="<?php echo $this_size_qty; ?>">
                                                                <?php echo $s; ?> <br />
                                                                <select name="<?php echo $size_label; ?>" class="size-select" style="border:1px solid #<?php echo $size_qty > 0 ? '000' : 'ccc'; ?>;" data-page="create" data-prod_no="<?php echo $item; ?>" data-vendor_price="<?php echo $vendor_price; ?>">
                                                                    <?php
                                                                    for ($i=0;$i<31;$i++)
                                                                    {
                                                                        echo '<option value="'.$i.'" '.($i == $size_qty ? 'selected' : '').'>'.$i.'</option>';
                                                                    } ?>
                                                                </select>
                                                            </div>

                                                                <?php
                                                            } ?>

                                                            =

                                                            <div class="sizes" style="display:inline-block;">
                                                                Total <br />
                                                                <input tpye="text" class="this-total-qty <?php echo $item.' '.$prod_no; ?>" style="border:1px solid #ccc;width:30px;padding-left:5px;background-color:white;" value="<?php echo $this_size_qty; ?>" readonly />
                                                            </div>
                                                        </td>
                                                        <?php
                                                        /**********
                                                         * Remove button
                                                         */
                                                        ?>
                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-link btn-xs summary-item-checkbox tooltips" data-original-title="Remove Item" data-prod_no="<?php echo $item; ?>" onmouseover="$(this).css('text-decoration','none');">
                                                                <i class="fa fa-close"></i> <cite class="small">rem</cite>
                                                            </button>
                                                        </td>
                                                        <?php
                                                        /**********
                                                         * Unit Vendor Price
                                                         */
                                                        ?>
                                                        <td class="unit-vendor-price-wrapper" data-item="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>" data-vendor_price="<?php echo $this->session->admin_po_edit_vendor_price ?: 0; ?>">
                                                            <div class="edit_off" style="<?php echo $this->session->admin_po_edit_vendor_price === TRUE ? 'display:none;' : ''; ?>">
                                                                <!-- Always zero -->
                                                                <div class="zero-unit-vendor-price <?php echo $prod_no; ?> pull-right">
                                                                    $ 0.00
                                                                </div>
                                                            </div>
                                                            <div class="edit_on" style="<?php echo $this->session->admin_po_edit_vendor_price === TRUE ? '' : 'display:none;'; ?>">
                                                                <div class="clearfix">
                                                                    <div class="unit-vendor-price <?php echo $prod_no; ?> pull-right" style="height:27px;width:40px;border:1px solid #ccc;padding-top:4px;padding-right:4px;text-align:right;">
                                                                        <?php
                                                                        echo $vendor_price;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="button" data-prod_no="<?php echo $item; ?>" class="btn btn-link btn-xs btn-edit_vendor_price" style="padding-right:0;margin-right:0;"><i class="fa fa-pencil"></i> Edit</button>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <?php
                                                        /**********
                                                         * Subtotal
                                                         */
                                                        ?>
                                                        <td class="text-right order-subtotal <?php echo $item.' '.$prod_no; ?>">
                                                            <?php
                                                            $this_size_total =
                                                                $this->session->admin_po_edit_vendor_price === TRUE
                                                                ? $this_size_qty * $vendor_price
                                                                : 0
                                                            ;
                                                            ?>
                                                            $ <?php echo number_format($this_size_total, 2); ?>
                                                        </td>

                                                        <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />
                                                    </tr>
                                                            <?php
                                                            $i++;
                                                            $overall_qty += $this_size_qty;
                                                            $overall_total += $this_size_total;
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

                                <div class="col-sm-12 status-with-items <?php echo empty($po_items) ? 'display-none' : ''; ?>">
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
                                                <button class="btn dark btn-sm btn-block mt-bootbox-new submit-po_summary_review hidden-xs hidden-sm"> Create Purchase Order </button>
                                                <button class="btn dark btn-sm btn-block mt-bootbox-new submit-po_summary_review hidden-md hidden-lg"> Create PO </button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 no-item-notification <?php echo empty($po_items) ? '' : 'display-none'; ?>">
                                    <h4 class="text-center" style="margin:85px auto 150px;"> There are no items in your purchase order </h4>
                                </div>

                                </form>
                                <!-- END FORM =======================================================-->

                                <div class="col-sm-12 steps">

                                    <hr />
                                    <div class="form-group form-group-badge clearfix" style="margin-bottom:0px;">
                                        <label class="control-label col-md-5">
                                            <span class="badge custom-badge pull-left <?php echo @$overall_qty ? 'active' : ''; ?> step4"> 4 </span>
                                            <span class="badge-label"> Create Purchase Order </span>
                                        </label>
                                        <div class="col-md-7">
                                            <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                Purchase Order will be created and submitted pending approval.
                                            </cite>
                                        </div>
                                    </div>

                                    <hr style="margin-top:0px;" />
                                    <a href="<?php echo site_url('admin/purchase_orders/reset'); ?>" style="color:#333;">
                                        <div class="form-group form-group-badge form-group-badge-step5 clearfix">
                                            <label class="control-label col-md-5" style="cursor:pointer;">
                                                <span class="badge custom-badge pull-left step5"> 5 </span>
                                                <span class="badge-label"> Clear Purchase Order </span>
                                            </label>
                                            <div class="col-md-7">
                                                <cite class="help-block font-red" style="position:relative;top:-4px;">
                                                    Purchase Order will be reset and all items cleared.
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

                                        <span class="evp-modal-item"><?php echo $item; ?></span>

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

                    </div>
                    <!-- END PAGE CONTENT BODY -->
