<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_items extends MY_Controller {

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
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('users/admin_user_details');
		$this->load->library('categories/categories_tree');

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

		// grab the post data
		$page = $this->input->post('page');

		// set the items array
		$items_array =
			$page == 'create'
			? (
				$this->session->admin_lb_items
				? json_decode($this->session->admin_lb_items, TRUE)
				: array()
			)
			: (
				$this->session->admin_lb_mod_items
				? json_decode($this->session->admin_lb_mod_items, TRUE)
				: array()
			)
		;
		$lb_items_count = count($items_array);
		/* */
		$lb_options =
			$page == 'create'
			? (
				$this->session->admin_lb_options
				? json_decode($this->session->admin_lb_options, TRUE)
				: array()
			)
			: (
				$this->session->admin_lb_mod_options
				? json_decode($this->session->admin_lb_mod_options, TRUE)
				: array()
			)
		;
		// */

		// iterate through the $items_array and generate HTML
		$html = '';
		if ( ! empty(@$items_array))
		{
			$i = 2;
			foreach ($items_array as $item => $options)
			{
				// get product details
				$exp = explode('_', $item);
				$product = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => $exp[0],
						'color_code' => $exp[1]
					)
				);

				if ( ! $product)
				{
					// a catch all system
					continue;
				}

				// set image paths
				// the new way relating records with media library
				$style_no = $item;
				$prod_no = $exp[0];
				$color_code = $exp[1];
				$color_name = $this->product_details->get_color_name($color_code);

				// the image filename
				$image = $product->media_path.$style_no.'_f3.jpg';
				$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
				if (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg'))
				{
					$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
				}
				elseif (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg'))
				{
					$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg';
				}
				else $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';

				// set product logo
				if ( ! @getimagesize($this->config->item('PROD_IMG_URL').$product->designer_logo))
				{
					// get default logo folder
					$logo = base_url().'assets/images/logo/logo-'.$product->designer_slug.'.png';
				}
				else
				{
					$logo = $this->config->item('PROD_IMG_URL').$product->designer_logo;
				}

				// set some data
				$price = @$options[2] ?: 0;
				$size_names = $this->size_names->get_size_names($product->size_mode);
				$category = $this->categories_tree->get_name($options[1]); // get category name of category slug

				$show_price = @$lb_options['w_prices'] == 'Y' ? '' : "display-none";
				$show_sizes = @$lb_options['w_sizes'] == 'Y' ? '' : "display-none";

				$html.= '<div class="lookbook-item" style="padding:3%;border:1px solid #ccc;margin: 0 3px 8px;background:white;">';
				$html.= '<div class="pull-left" style="width:48%;position:relative;">';

				$html.= '<img src="'
					.$img_front_new
					.'" style="width:100%;" />'
				;
				$html.= '<img src="'
					.$logo
					.'" style="position:absolute;top:5px;left:5px;width:100px;height:auto;" />'
				;
				$html.= '<p style="color:white;position:absolute;top:83%;left:6px;font-size:90%;transform-origin: 0 0;transform:rotate(270deg);">'
					.strtoupper($category)
					.'</p>'
				;
				$html.= '<p style="color:white;position:absolute;bottom:-10px;left:10px;font-size:60%;">'
					.$prod_no
					.' &nbsp; &nbsp; '
					.$color_name
					.' &nbsp; &nbsp; <span class="lb-items-w_prices '
					.$show_price
					.'">$'
					.$price
					.'</span>'
				;

				$i = 0;
				$span_size = FALSE; // assume initially there is no available sizes
				foreach ($size_names as $size_label => $s)
				{
					// do not show zero stock sizes
					if ($product->$size_label === '0') continue;

					// it is now assumed that this next size after is with stocks
					//<br />
					//Sizes: 0(2) 2(2) 4(6) 6(2) 12(2)
					if ($i === 0)
					{
						// this means there is a size with stock
						$html.= '<br class="lb-items-w_sizes '.$show_sizes.'" /><span class="lb-items-w_sizes '.$show_sizes.'">Sizes: ';
						$span_size = TRUE;
					}

					$html.= $s.'('.$product->$size_label.') ';

					$i++;
				}
				if ($span_size) $html.= '</span>';

				$html.= '</p>';

				$html.= '</div>';
				$html.= '<div class="pull-right" style="width:48%;position:relative;">';

				$html.= '<img src="'
					.$img_back_new
					.'" style="width:100%;" />'
				;
				$html.= '<p style="color:white;position:absolute;bottom:-10px;right:10px;font-size:60%;">'
					.$i
					.'</p>'
				;
				$html.= '<p class="tooltips" data-original-title="Remove Item" data-placement="left" style="color:black;position:absolute;top:-12px;right:5px;cursor:pointer;">'
					.'<i class="fa fa-2x fa-times-circle package_items" data-prod_no="'
					.$prod_no
					.'" data-item="'
					.$item
					.'" data-category_slug="'
					.$options[1]
					.'" data-style_no="'
					.$item
					.'" data-sku="'
					.$style_no
					.'" data-page="'
					.$page
					.'"></i>'
					.'</p>'
				;

				$html.= '</div>';
				$html.= '<div class="clearfix"></div>';

				$html.= '<a href="javascript:;">';
				$html.= '</div>';

				$i = $i + 2;
			}

			$html.= '<input type="hidden" id="items_count" name="items_count" value="'.$lb_items_count.'" />';
		}
		else
		{
			$html.= '<input type="hidden" id="items_count" name="items_count" value="0" />'
				.'<h3 class="" style="margin-bottom:200px;"> <cite>Selected items will show here...</cite> </h3>'
			;
		}

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
