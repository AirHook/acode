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
	 * Index - Activate Item
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/marketing/carousels', 'location');
		}

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('status', '0');
		$DB->where('carousel_id', $id);
		$DB->update('carousels');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'categories');
	}

	// ----------------------------------------------------------------------

}
