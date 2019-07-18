<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setprimary extends Admin_Controller {

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
		// initialize certain properties
		$this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id));

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// get variant details
		$variant_details = $DB->get_where('tbl_stock', array('st_id'=>$st_id));
		$media_ref_id = $variant_details->row()->image_url_path;

		// update main record
		$DB->set('primary_img_id', $color_code);
		$DB->set('primary_img', $media_ref_id);
		$DB->where('prod_id', $prod_id);
		$qprod = $DB->update('tbl_product');

		// this set as primary color is not needed at odoo
		/*
		// pass data to odoo
		if (
			ENVIRONMENT !== 'development'
			&& $this->product_details->d_url_structure === 'basixblacklabel'
		)
		{
			$this->_update_product_to_odoo(array('primary_img_id'=>$color_code), $prod_id);
		}
		*/

		// update stock record
		// lets remove primary by setting all colors to not primary
		$DB->set('primary_color', '0');
		$DB->where('prod_id', $prod_id);
		$DB->or_where('prod_no', $this->product_details->prod_no);
		$qremove = $DB->update('tbl_stock');
		// lets set the new primary color
		$DB->set('primary_color', '1');
		$DB->where('st_id', $st_id);
		$qsetnew = $DB->update('tbl_stock');

		// this set as primary color is not needed at odoo
		/*
		// pass data to odoo
		if (
			ENVIRONMENT !== 'development'
			&& $this->product_details->d_url_structure === 'basixblacklabel'
		)
		{
			$this->_update_primary_color_to_odoo($st_id, $prod_id);
		}
		*/

		// set flash data
		$this->session->set_flashdata('primary_color_updated', TRUE);

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

	/**
	 * Update Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_primary_color_to_odoo($st_id, $prod_id)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/product/'.$prod_id;
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to post_ary
			$post_ary['client_api_key'] = $api_key;
			$post_ary['prod_id'] = $prod_id;
			$post_ary['st_id'] = $st_id;
			$post_ary['primary_color'] = '1';
			$post_ary['notes'] = 'Set this st_id to primary by setting primary_color = "1", but do not forget to set all colors to primary_color = "0" first.';

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
