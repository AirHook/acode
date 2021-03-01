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

		// grab the post data
		$page = $this->input->post('page');

		// set the items array and options array
		if ($page == 'create')
		{
			$items_array =
				$this->session->sa_items
				? json_decode($this->session->sa_items, TRUE)
				: array()
			;
			$sa_options =
				$this->session->sa_options
				? json_decode($this->session->sa_options, TRUE)
				: array()
			;
		}
		else
		{
			$items_array =
				$this->session->sa_mod_items
				? json_decode($this->session->sa_mod_items, TRUE)
				: array()
			;
			$sa_options =
				$this->session->sa_mod_options
				? json_decode($this->session->sa_mod_options, TRUE)
				: array()
			;
		}
		$sa_items_count = count($items_array);

		// set the items array
		/*
		$items_array =
			$this->session->sa_items
			? json_decode($this->session->sa_items, TRUE)
			: (
				$this->session->sa_mod_items
				? json_decode($this->session->sa_mod_items, TRUE)
				: array()
			)
		;
		$sa_items_count = count($items_array);
		$sa_options =
			$this->session->sa_options
			? json_decode($this->session->sa_options, TRUE)
			: (
				$this->session->sa_mod_options
				? json_decode($this->session->sa_mod_options, TRUE)
				: array()
			)
		;
		*/

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// iterate through the $items_array and generate HTML
		$html = '';
		if ( ! empty(@$items_array))
		{
			foreach ($items_array as $item)
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

				// the image filename
				if ($product)
				{
					$image = $product->media_path.$style_no.'_f3.jpg';
					$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
					$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
					$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
					$color_name = $product->color_name;

					// set price
					$price =
						@$sa_options['e_prices'][$item]
						?: (
							($product->clearance == '3' OR $product->custom_order == '3')
							? $product->wholesale_price_clearance
							: $product->wholesale_price
						)
					;
				}
				else
				{
					$image = 'images/instylelnylogo_3.jpg';
					$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
					$img_back_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
					$img_large = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
					$color_name = $this->product_details->get_color_name($color_code);

					// set price
					$price = @$sa_options['e_prices'][$item] ?: 0;
				}

				// check if item is on sale
				$onsale = ($product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

				// check if price is changed
				if ( ! isset($sa_options['w_prices']))
				{
					$display_prices = '';
				}
				else
				{
					$display_prices = $sa_options['w_prices'] == 'Y' ? '' : 'display-none';
				}

				$html.= '<div class="thumb-tile package image bg-blue-hoki '
					.$style_no
					.' selected" data-sku="'
					.$style_no
					.'" data-prod_no="'
					.$prod_no
					.'" data-prod_id="'
					.@$product->prod_id
					.'">'
				;

				$html.= '<a href="javascript:;">';

				$html.= '<div class="tile-body">'
					.'<img class="img-b img-unveil" src="'
					.$img_back_new
					.'" alt="">'
					.'<img class="img-a img-unveil" src="'
					.$img_front_new
					.'" alt=""></div>'
					.'<div class="tile-object"><div class="name hide">'
					.$prod_no
					.'<br />'
					.$color_name
					.'</div></div>'
				;

				$html.= '</a>';

				$html.= '<div class="" style="color:black;line-height:1.2em;">'
					.'<input type="checkbox" class="package_items tooltips" data-original-title="Remove item" name="prod_no[]"  data-page="'
					.($page ?: 'create')
					.'" value="'
					.$style_no
					.'" style="float:right;margin-top:0px;" checked />'
					.$prod_no
					.'<br />'
					.$color_name
					.'<br />'
					.'<div class="item_prices '
					.$style_no
					.' '
					.$display_prices
					.'">'
					.'<span class="e_prices" data-price="'
					.$price
					.'" style="'
					.($onsale ? 'text-decoration:line-through;' : '')
					.'">$'
					.number_format($price, 2)
					.'</span>'
					.'<span class="e_prices" data-price="'
					.$price
					.'" style="color:red;'
					.($onsale ? '' : 'display:none;')
					.'">&nbsp;$'
					.number_format($price, 2)
					.'</span>'
					.'<button type="button" data-item="'
					.$item
					.'" class="btn btn-link btn-xs btn-edit_item_price tooltips" data-original-title="Edit Price" style="position:relative;top:-2px;"><i class="fa fa-pencil small"></i></button>'
					.'</div></div>'
				;

				$html.= '</div>';
			}
		}
		else
		{
			$html.= '<input type="hidden" id="items_count" name="items_count" value="0" />'
				.'<h3 class="" style="margin-bottom:100px;"> <cite>Selected items will show here...</cite> </h3>'
			;
		}

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
