<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Admin_Controller {

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
	 * Index - Delete Account
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		
		// get and set item details for odoo and recent items
		$this->wholesale_user_details->initialize(array('user_id'=>$id));

		// remove from sidebar recent items
		// update recent list for edited vendor users
		$this->webspace_details->update_recent_users(
			array(
				'user_type' => 'wholesale_users',
				'user_id' => $id,
				'user_name' => $this->wholesale_user_details->store_name
			),
			'remove'
		);

		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('user_id', $id);
		$DB->delete('tbluser_data_wholesale');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/wholesale');
	}

	// ----------------------------------------------------------------------

}
