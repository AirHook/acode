<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Del extends Admin_Controller {

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
	public function index($user_id = '')
	{
		if ($user_id)
		{
			// update record
			$this->DB->where('vendor_id', $user_id);
			$this->DB->delete('vendors');

			//if (ENVIRONEMENT !== 'development') $this->_delete_vendor_to_odoo($user_id);

			echo 'Deleted';
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Suspend Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _delete_vendor_to_odoo($id)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/delete/vendor/'.$id; // base_url('test/test_ajax_post_to_odoo')
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post = array(
				"client_api_key" => $api_key,
				"vendor_id" => $id
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
