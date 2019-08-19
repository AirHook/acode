                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">

                        <div class="col col-md-3">

							<!-- BEGIN FORM-->
							<!-- FORM =======================================================================-->
							<?php echo form_open(
                                'admin/sales_orders/review',
								array(
									'role' => 'form',
                                    'id' => 'form-so_create'
								)
							); ?>

							<div class="form-body" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div class="notifications">
									<div class="alert alert-danger display-hide">
										<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
									<div class="alert alert-success display-hide">
										<button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                    <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                                    <div class="alert alert-danger ">
                                        <button class="close" data-close="alert"></button> An error occured. Please try again.
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
									<div class="alert alert-success ">
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

                                <?php
								/***********
								 * FORM
								 */
								?>
                                <style>.help-block-error { font-size: 0.8em; font-style: italic; }</style>
								<div class="form-group">
                                    <select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
                                        <option value="">Select Designer...</option>
                                        <?php if ($designers)
                                        {
                                            foreach ($designers as $designer)
                                            {
                                                $options = json_decode($designer->options, TRUE);
                                                ?>

                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo set_select('designer', $designer->url_structure, ($designer->url_structure === $this->session->admin_so_designer)); ?> data-des_id="<?php echo $designer->des_id; ?>" data-des_slug="<?php echo $designer->url_structure; ?>" data-size_mode="<?php echo @$options['size_mode']; ?>">
                                            <?php echo $designer->designer; ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="bs-select form-control" name="vendor_id" data-live-search="true" data-size="5" data-show-subtext="true">
                                        <option value="">Select Vendor...</option>
                                        <?php
                                        if (@$vendors)
                                        {
                                            foreach ($vendors as $vendor)
                                            { ?>

                                        <option value="<?php echo $vendor->vendor_id; ?>" data-subtext="<em><?php echo $vendor->designer; ?></em>" data-des_slug="<?php echo $vendor->url_structure; ?>" <?php echo set_select('vendor_id', $vendor->vendor_id, ($vendor->vendor_id === $this->session->admin_so_vendor_id)); ?>>
                                            <?php echo ucwords(strtolower($vendor->vendor_name)).' ('.$vendor->vendor_code.')'; ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="bs-select form-control" name="store_id" data-live-search="true" data-size="5" data-show-subtext="true">
                                        <option value="">Select Wholesale User...</option>
                                        <?php if (@$users)
                                        {
                                            foreach ($users as $user)
                                            {
                                                $options = json_decode($user->options, TRUE);
                                                $subtext = '<em>'.ucwords(strtolower($user->firstname.' '.$user->lastname)).' ('.$user->email.')</em>';
                                                ?>

                                        <option value="<?php echo $user->user_id; ?>" data-subtext="<?php echo $subtext; ?>" <?php echo set_select('store_id', $user->user_id, ($user->user_id === $this->session->admin_so_store_id)); ?>>
                                            <?php echo ucwords(strtolower($user->store_name)); ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="barcode" value="" placeholder="Click here and scan a barcode..." autofocus />
                                </div>
                                <div class="form-group">
                                    <input class="form-control date-picker" size="16" type="text" value="<?php echo $this->session->admin_so_dely_date; ?>" name="delivery_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" placeholder="Delivery Date..."/>
                                </div>
                                <hr />
                                <style>
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
                                    .item-container.odd {
                                        background:#f3f3f3;
                                    }
                                </style>

                                <?php
								/***********
								 * CART BASKET
								 */
								?>
                                <div class="cart_basket_wrapper summary-item-container" style="border:1px solid #ccc;min-height:300px;">

                                    <?php
    								/***********
    								 * This cart basket is poppulated by ajax call
                                     * Or, by $so_items session
    								 */
    								?>

                                    <?php
                                    if ($so_items)
                                    {
                                        $iodd = 0;
                                        $overall_qty = 0;
                                        foreach ($so_items as $item => $size_qty)
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
                                            // the new way relating records with media library
                                            $style_no = $item;
                                            $prod_no = $exp[0];
                                            $color_code = $exp[1];
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

                                            // set some data
                                            $size_names = $this->size_names->get_size_names($size_mode);

                                            $this_size_qty = 0;
                                			foreach ($size_qty as $size_label => $qty)
                                			{
                                				$this_size_qty += $qty;
                                				$s = $size_names[$size_label];
                                                $odd_class = $iodd&1 ? '' : 'odd';

                                				if (
                                                    isset($so_items[$item][$size_label])
                                                    && $s != 'XXL' && $s != 'XL1' && $s != 'XL2' && $s != '22'
                                                )
                                				{
                                                    ?>

                                    <div class="item-container clearfix <?php echo $odd_class; ?>" style="padding:5px;" data-des_slug="<?php echo @$product->designer_slug; ?>" data-vendor_id="<?php echo @$product->vendor_id; ?>">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-link btn-xs summary-item-remove-btn tooltips font-grey-cascade" data-original-title="Remove" data-page="create" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </div>
                                        <a href="<?php echo @$img_linesheet ?: 'javascript:;'; ?>" class="<?php echo @$img_linesheet ? 'fancybox' : ''; ?> pull-left">
                                            <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:70px;height:auto;" onerror="$(this).attr('src','<?php echo base_url().'images/instylelnylogo_3.jpg'; ?>');" />
                                        </a>
                                        <div class="shop-cart-item-details" style="margin-left:80px;">
                                            <h5 style="margin:0px;">
                                                <?php echo $item; ?>
                                            </h5>
                                            <h6 style="margin:0px;">
                                                <span style="color:#999;">Product#: <?php echo $prod_no; ?></span><br />
                                                Color: &nbsp; <?php echo $color_name; ?><br />
                                                <?php echo @$product->category_names ? '<cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
                                            </h6>
                                            <div class="size-and-qty-wrapper margin-top-10" style="font-size:0.8em;">

                                                <label>Size <?php echo $s; ?></label>
                                                <input type="text" class="size_select" data-page="create" style="border:1px solid #ccc;width:30px;margin-left:10px;text-align:right;padding:5px" data-item="<?php echo $item; ?>" value="<?php echo $qty; ?>" readonly /> pcs.

                                                <input type="hidden" class="this-total-qty <?php echo $item.' '.$prod_no; ?>" value="<?php echo $this_size_qty; ?>" readonly />

                                            </div>
                                        </div>
                                    </div>

                                                    <?php
                                                }

                                                $iodd++;
                                            }

                                            $overall_qty += $this_size_qty;
                                        }

                                        echo '<input type="hidden" class="span-items_count" name="span-items_count" value="'.$iodd.'" />';
                                        echo '<input type="hidden" class="overall-qty" name="overall-qty" value="'.$overall_qty.'" />';
                                    }
                                    else
                                    { ?>

                                    <cite style="margin:30px 15px 0;display:block;">Items should show in here as soon as selected, or, searched and then selected, or, added as new item, or, after barcode scan...</cite>

                                        <?php
                                    } ?>

                                </div>
                                <span class="cart_items_count" style="font-size:0.8em;<?php echo $items_count ? '' : 'display:none'; ?>">items (<span class="items_count"><?php echo $items_count; ?></span>)</span>
                                <hr />
                                <div class="form-group">
                                    <button type="submit" class="btn dark btn-block">Review SO Summary</button>
                                </div>
							</div>

							</form>
							<!-- End FORM ===================================================================-->
							<!-- END FORM-->

                        </div>

                        <div class="col col-md-9" style="border:1px solid #ccc;min-height:570px;">
                            <div class="row">

                                <div class="col-md-12">

                                    <p>
                                        <a href="javascript:;" class="btn dark btn-sm search-multiple-form">
                                            <span style="color:red;">CLICK</span> HERE TO SEARCH MULTIPLE STYLE NUMBERS
                                        </a>
                                        <a href="javascript:;" class="btn dark btn-sm grid-view-button display-none">
                                            <span style="color:red;">CLICK</span> TO GO BACK TO THUMBS GRID VIEW
                                        </a>
                                        &nbsp; OR... <i class="fa fa-long-arrow-right"></i>
                                        <a href="#modal-unlisted_style_no" data-toggle="modal" class="btn grey btn-sm">
                                            <span style="color:red;">CLICK</span> HERE TO ADD STYLE NUMBERS NOT IN THE LIST
                                        </a>
                                        <a href="#modal-size_qty" data-toggle="modal" class="btn grey btn-sm">
                                            SIZE QTY MODAL
                                        </a>
                                    </p>

                                </div>

                                <h3 class="col-md-12 blank-grid-text <?php echo @$des_subcats ? 'display-none' : ''; ?>">
                                    <em class="select-both <?php echo @$designer_details ? 'display-none' : ''; ?>">Select a designer, and then, select a vendor...</em>
                                    <em class="select-vendor <?php echo @$designer_details ? '' : 'display-none'; ?>">Select a vendor...</em>
                                </h3>

                                <?php
								/***********
								 * Category TREE
								 */
								?>
                                <div class="col-md-3 col-lg-2 so-categories-wrapper margin-top-20">

                                    <style>
                                        .so-categories li.active > a {
                                            font-weight: bold;
                                        }
                                    </style>

                                    <div class="so-categories" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                        <ul class="list-unstyled nested-nav ">

                                            <?php
                                            if (@$des_subcats)
                                            {
                                                // set or check active slug
                                        		// designer top level list is always active
                                        		// ergo, set as first slugs_link
                                        		$slugs_link = array($designer_details->designer);
                                                $active = 'active';
                                                ?>

                                            <li class="<?php echo $active; ?> designer-level" data-slug="<?php echo $designer_details->url_structure; ?>">
                                                <a href="javascript:;" data-des_slug="<?php echo $designer_details->url_structure; ?>" style="font-size:0.8em;" data-slugs_link="<?php echo implode('/', $slugs_link); ?>">
                                                    <?php echo $designer_details->designer; ?>
                                                </a>

                                                <ul class="list-unstyled nested-nav" style="margin-left:15px;" data-row_count="<?php echo $row_count; ?>">

                                                    <!-- BEGIN LIST UNSTYLED -->
                                                    <?php
                                                    /**********
                                                     * Cateogry tree list
                                                     */
                                                    ?>

                                                    <?php
                                                    $ic = 1;
                                            		foreach ($des_subcats as $category)
                                                    {
                                                        // let do first row...
                                            			if ($ic == 1)
                                                        {
                                                            // create link
                                            				array_push($slugs_link, $category->category_slug);

                                                            // first row is usually the top main category...
                                            				echo '<li class="category_list '
                                            					.$active
                                            					.' level-1 '
                                            					.$category->category_id
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
                                            					.$active
                                            					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
                                            					.implode('/', $slugs_link)
                                            					.'" data-des_slug="'
                                            					.$designer_details->url_structure
                                            					.'">'
                                            					.$category->category_name
                                            					.'</a>'
                                            				;

                                            				// save as previous level
                                            				$prev_level = $category->category_level;

                                            				$ic++;
                                            				continue;
                                                        }

                                                        // if same category level, close previous </li> and open another one
                                            			if ($category->category_level == $prev_level)
                                            			{
                                            				// unset active
                                            				$active = '';
                                            				// capture the active slugs before next same level iteration
                                            				$slug_segs = @$slug_segs ?: $slugs_link;

                                            				// create new link
                                            				$pop = array_pop($slugs_link); // remove previous last seg
                                            				array_push($slugs_link, $category->category_slug); // replace with new one

                                            				echo '</li><li class="category_list '
                                            					.$active
                                            					.' level-'
                                            					.$ic
                                            					.' '
                                            					.$category->category_id
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
                                            					.$active
                                            					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
                                            					.implode('/', $slugs_link)
                                            					.'" data-des_slug="'
                                            					.$designer_details->url_structure
                                            					.'">'
                                            					.$category->category_name
                                            					.'</a>'
                                            				;
                                            			}

                                                        // NOTE: next greater level is always greater by only 1 level
                                            			// if so, create new open list <ul>
                                            			if ($category->category_level == $prev_level + 1)
                                            			{
                                            				// append to previous link
                                            				array_push($slugs_link, $category->category_slug);

                                            				echo '<ul class="list-unstyled '
                                            					.($category->category_level == '1' ? 'ul-first-level' : '')
                                            					.'" style="margin-left:15px;"><li class="category_list '
                                            					.$active
                                            					.' level-'
                                            					.$ic
                                            					.' '
                                            					.$category->category_id
                                            					.'" data-category_id="'
                                            					.$category->category_id
                                            					.'" data-parent_category="'
                                            					.$category->parent_category
                                            					.'" data-category_slug="'
                                            					.$category->category_slug
                                            					.'" data-category_name="'
                                            					.$category->category_name
                                            					.'" data-category_level="'
                                            					.$category->category_level
                                            					.'" data-slug="'
                                            					.$category->category_slug
                                            					.'" '
                                            					.$active
                                            					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
                                            					.implode('/', $slugs_link)
                                            					.'" data-des_slug="'
                                            					.$designer_details->url_structure
                                            					.'">'
                                            					.$category->category_name
                                            					.'</a>'
                                            				;
                                            			}

                                                        // if next category level is lower, close previous </li></ul> and open another one
                                            			// dont forget to count the depth of levels
                                            			if ($category->category_level < $prev_level)
                                            			{
                                            				// unset active
                                            				$active = '';
                                            				// capture the active slugs before next level iteration
                                            				$slug_segs = @$slug_segs ?: $slugs_link;

                                            				for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
                                            				{
                                            					echo '</li></ul>';

                                            					// update link
                                            					$pop = array_pop($slugs_link);
                                            				}

                                            				// append to link
                                            				array_push($slugs_link, $category->category_slug);

                                            				echo '<ul class="list-unstyled '
                                            					.($category->category_level == '1' ? 'ul-first-level' : '')
                                            					.'" style="margin-left:15px;"><li class="category_list '
                                            					.$active
                                            					.' level-'
                                            					.$ic
                                            					.' '
                                            					.$category->category_id
                                            					.'" data-category_id="'
                                            					.$category->category_id
                                            					.'" data-parent_category="'
                                            					.$category->parent_category
                                            					.'" data-category_slug="'
                                            					.$category->category_slug
                                            					.'" data-category_name="'
                                            					.$category->category_name
                                            					.'" data-category_level="'
                                            					.$category->category_level
                                            					.'" data-slug="'
                                            					.$category->category_slug
                                            					.'" '
                                            					.$active
                                            					.'><a href="javascript:;" style="font-size:0.8em;" data-slugs_link="'
                                            					.implode('/', $slugs_link)
                                            					.'" data-des_slug="'
                                            					.$designer_details->url_structure
                                            					.'">'
                                            					.$category->category_name
                                            					.'</a>'
                                            				;
                                            			}

                                                        // if this is last row, close it
                                            			// again, check count of depth of levels
                                            			if ($ic == $row_count)
                                            			{
                                            				// unset active
                                            				$active = '';
                                            				// capture the active slugs before next level iteration
                                            				$slug_segs = @$slug_segs ?: $slugs_link;

                                            				for ($deep = $category->category_level; $deep > 0; $deep--)
                                            				{
                                            					echo '</li data-row_count="'.$row_count.'"></ul>';
                                            				}
                                            				echo '</li>';
                                            			}

                                            			$prev_level = $category->category_level;
                                            			$ic++;
                                                    } ?>

                                                    </li>
                                                    <!-- END LIST UNSTYLED -->

                                                </ul>
                                                <span id="slug_segs" class="hidden"><?php echo implode('/', $slug_segs); ?></span>

                                            </li>

                                                <?php
                                            } ?>

                                        </ul>

                                    </div>

    							</div>

                                <?php
                                /*********
                                 * This style is adapted from the main style for tiles but changed
                                 * for this grid view
                                 */
                                ?>
                                <style>
                                    .tiles .tile {
                                        width: 140px !important;
                                        height: 210px;
                                    }
                                    .thumb-tiles {
                                        position: relative;
                                        margin-right: -10px;
                                    }
                                    .thumb-tiles .thumb-tile {
                                        display: block;
                                        float: left;
                                        width: 110px !important; /*140px */
                                        height: 165px; /*210px;*/
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
                                    .img-a {
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                    }
                                    .img-b {
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                    }
                                </style>

                                <?php
								/***********
								 * THUMBS GRID VIEW
								 */
								?>
                                <div class="col-md-9 col-lg-10 thumb-tiles-wrapper margin-top-20" data-row-count="<?php echo @$products_count; ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

    								<?php if ($search_string) { ?>
    	                            <h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
    	                            <br />
    	                            <?php } ?>

    								<div class="thumb-tiles">

    									<?php
                                        if (@$des_subcats)
                                        {
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
        											$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';

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

        											// set class selected for if items has already been selected for the sales package
        											//$classes.= in_array($product->prod_no, $sa_items) ? 'selected ' : '';
        											?>

    									<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

    										<a href="<?php echo $img_linesheet; ?>" class="fancybox">

    											<?php if ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') { ?>
    											<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-<?php echo $ribbon_color; ?> uppercase tooltips" data-placement="top" data-container="body" data-original-title="<?php echo $tooltip; ?>" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
    												<i class="fa fa-ban"></i>
    											</div>
    											<?php } ?>

    											<?php if ($product->with_stocks == '0') { ?>
    											<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="top" data-container="body" data-original-title="Pre Order" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
    												<i class="fa fa-ban"></i>
    											</div>
    											<?php } ?>

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
    													<?php echo $product->color_name; ?>
    												</div>
    											</div>

    										</a>

    										<div class="" style="color:red;font-size:0.9rem;">
    											<span> Add to Sales Order: </span>
                                                <i class="fa fa-plus package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="position:relative;left:5px;background:#ddd;line-height:normal;padding:1px 2px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
                                                <!--
    											<input type="checkbox" class="package_items <?php echo $product->prod_no.'_'.$product->color_code; ?>" name="prod_no[]" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" style="float:right;" <?php echo $checkbox_check; ?> />
                                                -->
    										</div>

    									</div>

        										<?php
        										$cnti++;
        										}
        									}
        									else
        									{
        										if ($search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
        										else $txt1 = 'NO PRODUCTS TO LOAD...';
        										echo '<button class="btn default btn-block btn-lg"> '.$txt1.' </button>';
        									}
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

                                <div class="col-md-12 search-multiple-items margin-bottom-30 display-none">

                                    <h3>SEARCH MULTIPLE ITEMS</h3>

                                    <?php
                                    /***********
                                     * Noification area
                                     */
                                    ?>
                                    <div class="margin-top-20">
                                    	<?php if (validation_errors()) { ?>
                                    	<div class="alert alert-danger">
                                    		<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                    	</div>
                                    	<?php } ?>
                                    </div>

                                    <div style="position:relative;">
                                    	Please enter one STYLE NUMBER per box for as many as 40 items only. <span style="color:red;font-style:italic;">(Sylte Numbers only please.)</span>
                                    	<br /><br />

                                    	<!--bof form==========================================================================-->
                                    	<?php echo form_open(
                                    		'admin/sales_orders/search_multiple',
                                    		array(
                                    			'class' => 'sa-multi-search-form', // need this for the styling
                                                'id' => 'so-multi-search-form'
                                    		)
                                    	); ?>

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
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 4. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 5. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 6. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 7. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 8. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 9. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
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
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 16. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 17. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 18. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 19. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 20. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 21. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
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
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 28. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 29. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 30. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 31. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 32. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
                                                </div>
                                    			<div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 33. </span>
                                    					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
                                    				</div>
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
                                    				<div class="m-grid-col m-grid-col-middle">
                                    					<span class="multi-search-item-no"> 40. </span>
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
                                    <?php echo form_open(
                                        'admin/sales_orders/addrem_excluded',
                                        array(
                                            'class' => 'form-horizontal'
                                        )
                                    ); ?>

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
