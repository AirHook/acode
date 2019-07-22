<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends Admin_Controller {

	/**
	 * DB Object
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
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// ser posts params
		$post_ary = $this->input->post();
		unset($post_ary['vendor_id']);
		unset($post_ary['vendor_type_slug']);
		
		// set id of vendor type slug
		$this->load->library('users/vendor_types_list');
		$post_ary['vendor_type_id'] = $this->vendor_types_list->get_vendor_id($this->input->post('vendor_type_slug'));
		
		if ($this->input->post('vendor_id'))
		{
			// update record
			$this->DB->where('vendor_id', $this->input->post('vendor_id'));
			$this->DB->update('vendors', $post_ary);
			
			// process some data before sending to odoo
			$odoo_post_ary = $post_ary;
			$odoo_post_ary['vendor_type_slug'] = $this->input->post('vendor_type_slug');
			$odoo_post_ary['vendor_id'] = $this->input->post('vendor_id');
			if (ENVIRONMENT !== 'development') $this->_update_vendor_to_odoo($odoo_post_ary);
		}
		else
		{
			// insert record
			$this->DB->set($post_ary);
			$this->DB->insert('vendors');
			$insert_id = $this->DB->insert_id();
			
			// process some data before sending to odoo
			$odoo_post_ary = $post_ary;
			$odoo_post_ary['vendor_type_slug'] = $this->input->post('vendor_type_slug');
			$odoo_post_ary['vendor_id'] = $insert_id;
			if (ENVIRONMENT !== 'development') $this->_add_vendor_to_odoo($odoo_post_ary);
			
			echo $insert_id;
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Activate Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _add_vendor_to_odoo($post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		// 
		$api_url = 'http://70.32.74.131:8069/api/create/vendors'; // base_url('test/test_ajax_post_to_odoo')
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post = array(
				"client_api_key" => $api_key,
				"vendor_id" => $odoo_post_ary['vendor_id'],
				"vendor_name" => $odoo_post_ary['vendor_name'],
				"vendor_email" => $odoo_post_ary['vendor_email'],
				"vendor_code" => $odoo_post_ary['vendor_code'],
				"contact_1" => $odoo_post_ary['contact_1'],
				"contact_email_1" => $odoo_post_ary['contact_email_1'],
				"contact_2" => $odoo_post_ary['contact_2'],
				"contact_email_2" => $odoo_post_ary['contact_email_2'],
				"contact_3" => $odoo_post_ary['contact_3'],
				"contact_email_3" => $odoo_post_ary['contact_email_3'],
				"address1" => $odoo_post_ary['address1'],
				"address2" => $odoo_post_ary['address2'],
				"city" => $odoo_post_ary['city'],
				"state" => $odoo_post_ary['state'],
				"country" => $odoo_post_ary['country'],
				"zipcode" => $odoo_post_ary['zipcode'],
				"telephone" => $odoo_post_ary['telephone'],
				"fax" => $odoo_post_ary['fax'],
				"reference_designer" => $odoo_post_ary['reference_designer'],
				"vendor_type_id" => $odoo_post_ary['vendor_type_id'],
				"vendor_type" => $odoo_post_ary['vendor_type_slug'],
				"is_acitve" => $odoo_post_ary['is_active']
			);
			
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
				
				redirect($this->config->slash_item('admin_folder').'users/vendor');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Activate Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_vendor_to_odoo($odoo_post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		// 
		$api_url = 'http://70.32.74.131:8069/api/update/vendor/'.$odoo_post_ary['vendor_id'];
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post = array(
				"client_api_key" => $api_key,
				"vendor_id" => $odoo_post_ary['vendor_id'],
				"vendor_name" => $odoo_post_ary['vendor_name'],
				"vendor_email" => $odoo_post_ary['vendor_email'],
				"vendor_code" => $odoo_post_ary['vendor_code'],
				"contact_1" => $odoo_post_ary['contact_1'],
				"contact_email_1" => $odoo_post_ary['contact_email_1'],
				"contact_2" => $odoo_post_ary['contact_2'],
				"contact_email_2" => $odoo_post_ary['contact_email_2'],
				"contact_3" => $odoo_post_ary['contact_3'],
				"contact_email_3" => $odoo_post_ary['contact_email_3'],
				"address1" => $odoo_post_ary['address1'],
				"address2" => $odoo_post_ary['address2'],
				"city" => $odoo_post_ary['city'],
				"state" => $odoo_post_ary['state'],
				"country" => $odoo_post_ary['country'],
				"zipcode" => $odoo_post_ary['zipcode'],
				"telephone" => $odoo_post_ary['telephone'],
				"fax" => $odoo_post_ary['fax'],
				"reference_designer" => $odoo_post_ary['reference_designer'],
				"vendor_type_id" => $odoo_post_ary['vendor_type_id'],
				"vendor_type" => $odoo_post_ary['vendor_type_slug'],
				"is_acitve" => $odoo_post_ary['is_active']
			);
			
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
				
				redirect($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}
	
	// ----------------------------------------------------------------------
	
}