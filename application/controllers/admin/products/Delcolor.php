<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delcolor extends Admin_Controller {

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
	 * @return	void
	 */
	public function index($color_code, $color_name, $st_id, $prod_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/del_unlink_prod');

		// initialize certain properties
		$this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id));

		// update available colors
		$colors = explode('-', $this->product_details->colors);
		if (($key = array_search($color_name, $colors)) !== false) {
			unset($colors[$key]);
		}
		$new_colors = implode('-', $colors);

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		$DB->set('colors', $new_colors);
		$DB->where('prod_id', $prod_id);
		$qprod = $DB->update('tbl_product');

		// initialize delet and unlink product class
		$config['prod_id'] = $prod_id;
		$config['st_id'] = $st_id; // if this is present, only the color variant will be deleted
		$this->del_unlink_prod->initialize($config);
		$this->del_unlink_prod->delunlink();

		// set flash data
		$this->session->set_flashdata('color_deleted', TRUE);

		// redirect user
		redirect(site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id), 'location');
	}


	// ----------------------------------------------------------------------

	/**
	 * Update Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_product_to_odoo($post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/product/'.$post_ary['prod_id'];
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to post_ary
			$post_ary['client_api_key'] = $api_key;

			// set post fields
			$post = $post_ary;

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

	/**
	 * Add Product Stock To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _del_stock_to_odoo($data_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/product/'.$data_ary['prod_id'];
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to data_ary
			$data_ary['client_api_key'] = $api_key;
			$data_ary['notes'] = 'This color item is for deletion.';

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
