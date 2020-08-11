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
			$this->session->admin_sa_items
			? json_decode($this->session->admin_sa_items, TRUE)
			: (
				$this->session->admin_sa_mod_items
				? json_decode($this->session->admin_sa_mod_items, TRUE)
				: array()
			)
		;
		$sa_items_count = count($items_array);
		$sa_options =
			$this->session->admin_sa_options
			? json_decode($this->session->admin_sa_options, TRUE)
			: (
				$this->session->admin_sa_mod_options
				? json_decode($this->session->admin_sa_mod_options, TRUE)
				: array()
			)
		;

		// iterate through the $items_array and generate HTML
		$html = '';
		if ( ! empty(@$items_array))
		{
			foreach ($items_array as $item)
			{
				// get product details
				$exp = explode('_', $item);
				if (count($exp) == 2)
				{
					$params = array(
						'tbl_product.prod_no'=>$exp[0],
						'color_code'=>$exp[1]
					);
				}
				else $params = array('tbl_product.prod_no'=>$exp[0]);
				$product = $this->product_details->initialize($params);

				// check if price is changed
				$price = @$sa_options['e_prices'][$item] ?: $product->wholesale_price;
				if ( ! isset($sa_options['w_prices']))
				{
					$display_prices = '';
				}
				else
				{
					$display_prices = $sa_options['w_prices'] ? '' : 'display-none';
				}


				// the image filename
				$image = $product->prod_no.'_'.$product->primary_img_id.'_f3.jpg';
				$style_no = $product->prod_no.'_'.$product->color_code;
				// the new way relating records with media library
				$path_to_image = $product->media_path.$style_no.'_f3.jpg';
				$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
				$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
				$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';

				$html.= '<div class="thumb-tile package image bg-blue-hoki '
					.$product->prod_no.'_'.$product->primary_img_id
					.' selected" data-sku="'
					.$product->prod_no.'_'.$product->primary_img_id
					.'" data-prod_no="'
					.$product->prod_no
					.'" data-prod_id="'
					.$product->prod_id
					.'">'
				;

				$html.= '<a href="javascript:;">';

				$html.= '<div class="tile-body">'
					.'<img class="img-b img-unveil" src="'
					.($product->primary_img ? $img_back_new : $img_back_pre.$image)
					.'" alt="">'
					.'<img class="img-a img-unveil" src="'
					.($product->primary_img ? $img_front_new : $img_front_pre.$image)
					.'" alt=""></div>'
					.'<div class="tile-object"><div class="name hide">'
					.$product->prod_no
					.'<br />'
					.$product->color_name
					.'</div></div>'
				;

				$html.= '</a>';

				$html.= '<div class="" style="color:black;line-height:1.2em;">'
					.'<input type="checkbox" class="package_items tooltips" data-original-title="Remove item" name="prod_no[]"  data-page="'
					.($page ?: 'create')
					.'" value="'
					.$product->prod_no.'_'.$product->color_code
					.'" style="float:right;margin-top:0px;" checked />'
					.$product->prod_no
					.'<br />'
					.$product->color_name
					.'<br />'
					.'<div class="item_prices '
					.$product->prod_no.'_'.$product->color_code
					.' '
					.$display_prices
					.'">'
					.'<span class="e_prices" data-price="'
					.$price
					.'">$ '
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
