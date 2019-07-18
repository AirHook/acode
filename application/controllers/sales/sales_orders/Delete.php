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
			redirect('salse/sales_orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// delete item from records
		$DB->where('sales_order_id', $id);
		$DB->delete('sales_orders');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('salse/sales_orders');
	}

	// ----------------------------------------------------------------------

}
