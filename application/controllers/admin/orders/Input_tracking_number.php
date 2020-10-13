<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_tracking_number extends Admin_Controller {

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
			redirect($this->config->slash_item('admin_folder').'orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// get options
		$DB->where('order_log_id', $id);
		$q1 = $DB->get('tbl_order_log');
		$r1 = $q1->row();
		$order_options = json_decode($r1->options, TRUE);

		// add tracking number as option
		$order_options['tracking_number'] = $this->input->post('tracking_number');

		// update records
		$DB->set('options', json_encode($order_options));
		$DB->where('order_log_id', $id);
		$DB->update('tbl_order_log');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/orders/details/index/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

}
