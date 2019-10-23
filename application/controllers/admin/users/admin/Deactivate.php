<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deactivate extends Admin_Controller {

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
	public function index($id = '', $page = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/users/admin/'.$page, 'location');
		}

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('is_active', '0');
		$DB->where('admin_id', $id);
		$DB->update('tbladmin');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/users/admin/'.$page, 'location');
	}

	// ----------------------------------------------------------------------

}
