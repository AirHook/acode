<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate extends Admin_Controller {

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
	 * Index - Activate Account
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

		// get and set item details for odoo
		$this->wholesale_user_details->initialize(array('user_id'=>$id));

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('active_date', date('Y-m-d', time()));
		$DB->set('is_active', '1');
		$DB->where('user_id', $id);
		$DB->update('tbluser_data_wholesale');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/wholesale');
	}

	// ----------------------------------------------------------------------

}
