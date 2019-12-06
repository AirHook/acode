<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends Admin_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($id = '', $status = '')
	{
		if ( ! $id OR ! $status)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		switch ($status)
		{
			case 'pending':
				$DB->set('status', '0');
			break;
			case 'on_hold':
				$DB->set('status', '2');
			break;
			case 'cancel':
				$DB->set('status', '3');
			break;
			case 'return':
				$DB->set('status', '4');
			break;
			case 'complete':
				$DB->set('status', '1');
			break;
		}

		$DB->set('remarks', '0');
		$DB->where('order_log_id', $id);
		$DB->update('tbl_order_log');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'orders', 'location');
	}

	// ----------------------------------------------------------------------

}
