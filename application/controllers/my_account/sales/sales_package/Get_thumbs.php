<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_thumbs extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		//$designer = 'tempoparis';
		//$slug_segs = 'womens_apparel/tops/blouses';
		$designer = $this->input->post('des_slug');
		$slug_segs = $this->input->post('slugs_link');
		$style_ary = $this->input->post('style_ary');
		$page = $this->input->post('page');

		// get the items if any
		// set the items array
		$items_array =
			$this->session->sa_items
			? json_decode($this->session->sa_items, TRUE)
			: (
				$this->session->sa_mod_items
				? json_decode($this->session->sa_mod_items, TRUE)
				: array()
			)
		;

		if ($slug_segs)
		{
			// load pertinent library/model/helpers
			$this->load->library('categories/categories_tree');

			// get last category slug
			$the_slugs = explode('/', $slug_segs);
			$category_slug = end($the_slugs);
			$category_id = $this->categories_tree->get_id($category_slug);
			$designer_slug = reset($the_slugs);

			$where_more['tbl_product.categories LIKE'] = $category_id;
		}

		if ($designer) $where_more['designer.url_structure'] = $designer;
		else
		{
			if ($designer_slug && $designer_slug != 'shop7thavenue')
			{
				$where_more['designer.url_structure'] = $designer_slug;
			}
		}

		// if for search
		if ($style_ary)
		{
			// need to show search string
			$style_ary = array_map('strtoupper', array_filter($style_ary));
			$search_string = implode(', ', $style_ary);
			// marge all where's
			$where_more = array_merge($style_ary, $where_more);
		}
		else $search_string = '';

		// sales user is not allowed to see cs clearance only items
		$con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
		$where_more['condition'][] = $con_clearance_cs_only;

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		//$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		//$params['view_at_hub'] = TRUE; // all items general public at hub site
		//$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		//$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		//$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		//$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site

		// level 2 users show only items with stocks
		$params['with_stocks'] = TRUE; // TRUE shows instock items only

		$params['group_products'] = FALSE; // group per product number or per variant
		$params['special_sale'] = FALSE; // special sale items only
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			$where_more,
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			)
		);
		$products_count = $this->products_list->row_count;

		$html = '';
		if ($search_string)
		{
			$html.= '<h1><small><em>Search results for:</em></small> "'.$search_string.'"</h1><br />';
		}

		$html.= '<div class="thumb-tiles">';
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

				// ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
				$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
				$tooltip = $product->publish == '3' ? 'Pending' : (($product->publish == '0' OR $product->view_status == 'N') ? 'Unpubished' : 'Private');

				// due to showing of all colors in thumbs list, we now consider the color code
				// we check if item has color_code. if it has only product number use the primary image instead
				$checkbox_check = '';
				if (($key = array_search($style_no, $items_array)) !== FALSE)
				{
					$classes.= 'selected';
					$checkbox_check = 'checked';
				}

				// check if item is on sale
				$onsale = (@$product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

				// get options if any
				$color_options = json_decode($product->options, TRUE);

				$html.= '<div class="thumb-tile image bg-blue-hoki '
					.$classes
					.'" style="'
					.$styles
					.'">'
				;
				$html.= '<a href="javascript:;" class="package_items" data-item="'
					.$product->prod_no.'_'.$product->color_code
					.'" data-page="'
					.($page ?: 'create')
					.'">'
				;

				if ($product->with_stocks == '0_')
				{
					$html.= '<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="bottom" data-container="body" data-original-title="Pre Order" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
						<i class="fa fa-ban"></i>
					</div>'
					;
				}

				$html.= '<div class="corner"></div><div class="check"> </div><div class="tile-body"><img class="img-b_ img-unveil" '
					.(
						$unveil
						? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'
						: 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'
					)
					.' alt=""><img class="img-a_ img-unveil" '
					.(
						$unveil
						? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'
						: 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'
					)
					.' alt=""><noscript><img class="img-b_" src="'
					.($product->primary_img ? $img_back_new : $img_back_pre.$image)
					.'" alt=""><img class="img-a_" src="'
					.($product->primary_img ? $img_front_new : $img_front_pre.$image)
					.'" alt=""></noscript></div><div class="tile-object"><div class="name">'
					.$product->prod_no
					.' <br />'
					.$product->color_name
					.' <br />'
					.'<span style="'
					.($onsale ? 'text-decoration:line-through;' : '')
					.'">$'
					.$product->wholesale_price
					.'</span>'
					.'<span style="color:pink;'
					.($onsale ? '' : 'display:none;')
					.'">&nbsp;$'
					.$product->wholesale_price_clearance
					.'</span>'
					.'</div></div>'
				;

				$html.= '</a>';
				$html.= '<div class="" style="color:red;font-size:1rem;">'
					.'<i class="fa fa-plus package_items '
					.$product->prod_no.'_'.$product->color_code
					.'" style="position:relative;left:5px;background:#ddd;line-height:normal;padding:1px 2px;" data-item="'
					.$product->prod_no.'_'.$product->color_code
					.'" data-page="create"></i> '
					.'&nbsp;'
					.'<span class="text-uppercase" data-item="'
					.$product->prod_no.'_'.$product->color_code
					.'"> Add to Package </span>'
					.'</div>'
				;
				$html.= '</div>';

				$cnti++;
			}
		}
		else
		{
			if (@$search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
			else $txt1 = 'NO PRODUCTS TO LOAD...';
			$html.= '<button class="btn default btn-block btn-lg" data-slug_segs="'.$slug_segs.'"> '.$txt1.' </button>';
		}
		$html.= '</div>';

		if (@$cnti > 100)
		{
			$html.= '<button class="btn default btn-block btn-lg" onclick="$(\'img\').unveil();$(\'.batch-2 .img-unveil\').trigger(\'unveil\');$(\'.btn-2, .batch-1\').show();$(this).hide();"> LOAD MORE... </button>
			';

			for ($batch_it = 2; $batch_it <= ($cnti / 100); $batch_it++)
			{
				$html.= '<button class="btn default btn-block btn-lg btn-'
					.$batch_it
					.'" onclick="$(\'.batch-'
					.($batch_it + 1)
					.' .img-unveil\').trigger(\'unveil\');$(\'.btn-'
					.($batch_it + 1)
					.' ,.batch-'
					.$batch_it
					.'\').show();$(this).hide();'
					.(($batch_it + 1) > ($cnti / 100) ? '$(\'.no-more-to-load\').show()' : '')
					.'" style="display:none;"> LOAD MORE... </button>'
				;
			}

			$html.= '<button class="btn default btn-block btn-lg no-more-to-load" style="display:none;"> NO MORE TO LOAD... </button>';
		}

		// a fix for the float...
		$html.= '<button class="btn default btn-block btn-lg" style="visibility:hidden"> NO MORE TO LOAD... </button>';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
