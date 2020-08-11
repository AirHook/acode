<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_multiple extends MY_Controller {

	/**
	 * Propery post array checked
	 *
	 * @params	boolean/int
	 */
	protected $post_ary_checked = 0;

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
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/admin_user_details');

		// get admin login details
		if ($this->session->admin_loggedin)
		{
			$this->admin_user_details->initialize(
				array(
					'admin_id' => $this->session->admin_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		if ( ! $this->input->post())
		{
			//echo 'uh oh<br />';
			//echo '<pre>';
			//print_r($this->input->post());
			//die();
			echo 'error';
			exit;
		}

		// grab the input posts
		$post_ary = $this->input->post();
		$prod_no = array_map('strtoupper', array_filter($post_ary['style_ary']));
		$page = $this->input->post('page');

		/* *
		$prod_no = array(
			'D9154L',
			'D9977L',
			'D9979L',
			'D9905L',
			'D9611L'
		);
		// */

		// get the items if any
		// set the items array
		$items_array =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;

		// search published items only (public and private)
		// don't show clearance cs only items
		$con_published = '(tbl_product.publish = \'1\' OR tbl_product.publish = \'11\' OR tbl_product.publish = \'12\' OR tbl_product.publish = \'2\')';
		$con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
		$where['condition'] = $con_published.' AND '.$con_clearance_cs_only;

		// NOTE: we need to consider the designer slug so as not to mix products

		// consider input prod_no
		if (is_array($prod_no))
		{
			$where['prod_no'] = $prod_no;
		}
		else
		{
			$where_more['designer.url_structure'] = $this->session->admin_so_des_slug;
			$where_more['tbl_product.prod_no'] = $prod_no;
			$where = $where_more;
		}

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			// where conditions
			$where,
			// sorting conditions
			array(
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			// limit
			'',
			// search
			TRUE
		);
		$products_count = $this->products_list->row_count;

		// need to show loading at start
		$search_string = implode(',', $prod_no);

		$html = '<div class="thumb-tiles">';

		if ($search_string)
		{
			$html.= '<h1 style="word-wrap:break-word;"><small><em>Search results for:</em></small> "'.$search_string.'"</h1><br />';
		}

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
				// set ribbon for PRIVATE & UNPUBLISH items
				$classes.= $product->publish != '1' ? 'mt-element-ribbon' : '';

				// let set the css style...
				$styles = $dont_display_thumb;
				//$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';

				// ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
				//$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
				//$tooltip = $product->publish == '3' ? 'Pending' : (($product->publish == '0' OR $product->view_status == 'N') ? 'Unpubished' : 'Private');

				// due to showing of all colors in thumbs list, we now consider the color code
				// we check if item has color_code. if it has only product number use the primary image instead
				$checkbox_check = '';
				if (isset($items_array[$style_no]))
				{
					$classes.= 'selected';
					$checkbox_check = 'checked';
				}

				// get options if any
				$color_options = json_decode($product->color_options, TRUE);

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
					.'$'.$product->wholesale_price
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
			if ($search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
			else $txt1 = 'NO PRODUCTS TO LOAD...';
			$html.= '<button class="btn default btn-block btn-lg"> '.$txt1.' </button>';
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
