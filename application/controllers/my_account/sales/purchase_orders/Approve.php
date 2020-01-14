<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approve extends MY_Controller {

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
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/purchase_orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// statuses
		// 0 - pending
		// 1 - approved
		// 2 - email sent to vendor
		// 3 - vendor view email
		// 4 - on hold
		// 5 - in transit
		// 6 - complete

		$DB->set('status', '2'); // because we send po to vendor immediately after approval
		$DB->where('po_id', $id);
		$DB->update('purchase_orders');

		/***********
		 * Send po email confirmation with PDF attachment
		 */
		$this->load->library('purchase_orders/purchase_order_sending');
		$this->purchase_order_sending->send($id);

		// set flash data
		$this->session->set_flashdata('success', 'approved');

		// redirect user
		redirect('my_account/sales/purchase_orders/details/index/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

}
