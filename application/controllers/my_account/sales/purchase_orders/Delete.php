<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Sales_user_Controller {

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
			redirect('my_account/sales/purchase_orders', 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// delete item from records
		$DB->where('po_id', $id);
		$DB->delete('purchase_orders');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('my_account/sales/purchase_orders', 'location');
	}

	// ----------------------------------------------------------------------

}
