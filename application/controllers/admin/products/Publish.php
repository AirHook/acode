<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publish extends Admin_Controller {

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
	public function index($param, $prod_id, $st_id = '')
	{
		// adding st_id as params for product lists that are not grouped products
		// color is used to update info

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// initialize certain properties
		if ($st_id)
		{
			if ( ! $this->product_details->initialize(array('tbl_stock.st_id'=>$st_id)))
			{
				// uh oh... no product on record???
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect($this->config->slash_item('admin_folder').'products');
			}
		}
		else
		{
			if ( ! $this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id)))
			{
				// uh oh... no product on record???
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect($this->config->slash_item('admin_folder').'products');
			}
		}

		// process "publish" state on product item level
		if ($param == '1')
		{
			$post_ary['publish'] = '1';
			$post_ary['public'] = 'Y';
			$post_ary['view_status'] = 'Y';

			$post_var['new_color_publish'] = '1';
		}
		elseif ($param == '11')
		{
			$post_ary['publish'] = '11';
			$post_ary['public'] = 'Y';
			$post_ary['view_status'] = 'Y1';

			$post_var['new_color_publish'] = '11';
		}
		elseif ($param == '12')
		{
			$post_ary['publish'] = '12';
			$post_ary['public'] = 'Y';
			$post_ary['view_status'] = 'Y2';

			$post_var['new_color_publish'] = '12';
		}
		elseif ($param == '2')
		{
			$post_ary['publish'] = '2';
			$post_ary['public'] = 'N';
			$post_ary['view_status'] = 'Y';

			$post_var['new_color_publish'] = '2';
		}
		else
		{
			$post_ary['publish'] = '0';
			$post_ary['public'] = 'N';
			$post_ary['view_status'] = 'N';

			$post_var['new_color_publish'] = '0';
		}

		if ($st_id)
		{
			// update record
			$DB->set($post_var);
			$DB->where('st_id', $st_id);
			$qprod = $DB->update('tbl_stock');

			if ($this->product_details->primary_color == '1')
			{
				// update record
				$DB->set($post_ary);
				$DB->where('prod_id', $prod_id);
				$qprod = $DB->update('tbl_product');
			}
		}
		else
		{
			// update record
			$DB->set($post_ary);
			$DB->where('prod_id', $prod_id);
			$qprod = $DB->update('tbl_product');
		}

		// pass data to odoo
		/* *
		if (
			ENVIRONMENT !== 'development'
			&& $this->product_details->d_url_structure === 'basixblacklabel'
		)
		{
			$this->_update_product_to_odoo($post_ary, $prod_id);
		}
		// */

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->config->slash_item('admin_folder').'products';

		// redirect user
		//redirect($this->config->slash_item('admin_folder').'products', 'location');
		redirect($referer, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_product_to_odoo($post_ary, $id)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/product/'.$id;
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to post_ary
			$post_ary['client_api_key'] = $api_key;
			$post_ary['prod_id'] = $id;

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

}
