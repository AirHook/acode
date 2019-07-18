<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_variant_options extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('odoo');

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index()
	{
		if ($_POST)
		{
			// initialize certain properties
			$this->product_details->initialize(array('tbl_product.prod_id'=>$_POST['prod_id']));

			// update stock record
			$this->DB->set($_POST);
			$this->DB->where('st_id', $_POST['st_id']);
			$q = $this->DB->update('tbl_stock');

			$post_ary = $_POST;
			$post_ary['prod_id'] = $_POST['prod_id'];
			$post_ary['designer_slug'] = $this->product_details->d_url_structure;

			// update product stock to odoo
			/* *
			if (
				ENVIRONMENT !== 'development'
				&& $this->product_details->d_url_structure === 'basixblacklabel'
			)
			{
				//$this->_update_stock_to_odoo($post_ary);
				$odoo_response = $this->odoo->post_data($post_ary, 'products', 'edit');
			}
			// */

			//echo $odoo_response;
			echo 'Success';
		}
		else echo 'Uh oh...';
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function facets()
	{
		if ($_POST)
		{
			// initialize certain properties
			$this->product_details->initialize(array('tbl_product.prod_id'=>$_POST['prod_id']));

			// update stock record
			$this->DB->set($_POST);
			$this->DB->where('prod_id', $_POST['prod_id']);
			$q = $this->DB->update('tbl_product');

			$post_ary = $_POST;
			$post_ary['prod_id'] = $prod_id;

			// update product stock to odoo
			/* *
			if (
				ENVIRONMENT !== 'development'
				&& $this->product_details->d_url_structure === 'basixblacklabel'
			)
			{
				//$this->_update_stock_to_odoo($post_ary);
				$this->odoo->post_data($post_ary, 'products', FALSE);
			}
			// */

			echo 'Done';
		}
		else echo 'Uh oh...';
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Product Stock To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_stock_to_odoo($data_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/product/'.$prod_id;
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to data_ary
			$data_ary['client_api_key'] = $api_key;

			// set post fields
			$post = $data_ary;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);

			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));

				redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}

	// ----------------------------------------------------------------------

}
