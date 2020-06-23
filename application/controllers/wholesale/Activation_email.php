<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Activation_email extends Frontend_Controller
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
	function index($user_id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('users/wholesale_user_details');

		/* */
		if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$user_id)))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('account');
		}
		// */

		// primary item that is changed for the preset salespackages
    	$params1['facets'] = array('availability'=>'instock');

		// get the products list
		$params1['show_private'] = TRUE; // all items general public (Y) - N for private
		$params1['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params1['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params1['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params1['with_stocks'] = TRUE;
		$params1['group_products'] = TRUE;
		// others
		$this->load->library('products/products_list', $params1, 'instock_products');
		$instock_products = $this->instock_products->select(
			array(
				'designer.url_structure' => (@$this->sales_user_details->designer ?: 'basixblacklabel')
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
		);

		// capture product numbers and set items array
		$cnt = 0;
		$instock_items_array = array();
		foreach ($instock_products as $product)
		{
			array_push($instock_items_array, $product->prod_no.'_'.$product->color_code);
		}

		$this->data['instock_products'] = $instock_items_array;

		// primary item that is changed for the preset salespackages
    	$params2['facets'] = array('availability'=>'preorder');

		// get the products list
		$params2['show_private'] = TRUE; // all items general public (Y) - N for private
		$params2['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params2['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params2['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params2['with_stocks'] = FALSE;
		$params2['group_products'] = TRUE;
		// others
		$this->load->library('products/products_list', $params2, 'preorder_products');
		$preorder_products = $this->preorder_products->select(
			array(
				'designer.url_structure' => (@$this->sales_user_details->designer ?: 'basixblacklabel')
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
		);

		// capture product numbers and set items array
		$cnt = 0;
		$preorder_items_array = array();
		foreach ($preorder_products as $product)
		{
			array_push($preorder_items_array, $product->prod_no.'_'.$product->color_code);
		}

		$this->data['preorder_products'] = $preorder_items_array;

		// primary item that is changed for the preset salespackages
    	$params2['facets'] = array('availability'=>'onsale');

		// get the products list
		$params2['show_private'] = TRUE; // all items general public (Y) - N for private
		$params2['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params2['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params2['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params2['with_stocks'] = FALSE;
		$params2['group_products'] = TRUE;
		// others
		$this->load->library('products/products_list', $params2, 'onsale_products');
		$onsale_products = $this->onsale_products->select(
			array(
				'designer.url_structure' => (@$this->sales_user_details->designer ?: 'basixblacklabel')
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
		);

		// capture product numbers and set items array
		$cnt = 0;
		$onsale_items_array = array();
		foreach ($onsale_products as $product)
		{
			array_push($onsale_items_array, $product->prod_no.'_'.$product->color_code);
		}

		$this->data['onsale_products'] = ''; //$onsale_items_array;


		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		// get privay Policy
		$DB->select('text');
		$DB->where('title_code', 'wholesale_privacy_notice');
		$q = $DB->get('pages')->row();
		$this->data['privacy_policy'] = $q->text;


		// let's set some data and get the message
		$this->data['username'] = ucwords(strtolower(trim($this->wholesale_user_details->fname).' '.trim($this->wholesale_user_details->lname)));
		$this->data['email'] = $this->wholesale_user_details->email;
		$this->data['password'] = $this->wholesale_user_details->password;
		$this->data['user_id'] = $this->wholesale_user_details->user_id;
		$this->data['admin_sales_id'] = $this->wholesale_user_details->admin_sales_id;
		$this->data['sales_rep'] = ucwords(strtolower(trim($this->wholesale_user_details->admin_sales_user).' '.trim($this->wholesale_user_details->admin_sales_lname)));
		$this->data['reference_designer'] = $this->wholesale_user_details->reference_designer;
		$this->data['designer'] = $this->wholesale_user_details->designer;
		$this->data['designer_site_domain'] = $this->wholesale_user_details->designer_site_domain;
		$this->data['designer_address1'] = $this->wholesale_user_details->designer_address1;
		$this->data['designer_address2'] = $this->wholesale_user_details->designer_address2;
		$this->data['designer_phone'] = $this->wholesale_user_details->designer_phone;
		$this->data['ws_access_level'] = $this->wholesale_user_details->access_level;

		// load the view
		$message = $this->load->view('templates/activation_email_v1', $this->data, TRUE);

		echo $message;
	}

	// --------------------------------------------------------------------

}
