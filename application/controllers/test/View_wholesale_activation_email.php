<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class View_wholesale_activation_email extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		// get privay Policy
		$DB->select('text');
		$DB->where('title_code', 'wholesale_privacy_notice');
		$q = $DB->get('pages')->row();
		$data['privacy_policy'] = $q->text;

		// let's get some thumbs
		$data['instock_products'] = $this->_get_thumbs('instock');

		// load the view
		$message = $this->load->view('templates/activation_email', $data, TRUE);

		echo $message;
	}

	// --------------------------------------------------------------------

	/**
	 * Get activation emai product thumbs suggestion
	 *
	 * @params	string
	 * @return	array
	 */
	private function _get_thumbs($str)
	{
		// load pertinent library/model/helpers
		$this->load->library('products/products_list');
		$this->load->library('products/product_details');

		// primary item that is changed for the preset salespackages
    	$params['facets'] = array('availability'=>$str);

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = $params == 'instock' ? TRUE : FALSE;
		$params['group_products'] = TRUE;
		// others
		$this->products_list->initialize($params);
		$products = $this->products_list->select(
			array(
				'designer.url_structure' => $this->wholesale_user_details->reference_designer
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.categories' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
		);

		// capture product numbers and set items array
		if ($products)
		{
			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				array_push($items_array, $product->prod_no.'_'.$product->color_code);
			}

			return $items_array;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
