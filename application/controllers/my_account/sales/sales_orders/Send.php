<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends Sales_user_Controller {

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
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index($id = '', $from = 'details')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			$this->_redirect($from);
		}

		/***********
		 * Send po email confirmation with PDF attachment
		 */
		$this->load->library('sales_orders/sales_order_sending');
		$this->sales_order_sending->send($id);

		// set flash data
		$this->session->set_flashdata('success', 'sent');

		// redirect user
		$this->_redirect($from, $id);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _redirect($from, $id)
	{
		// redirect user
		if ($from == 'details')
		{
			redirect('my_account/sales/sales_orders/details/index/'.$id, 'location');
		}
		else
		{
			redirect('my_account/sales/sales_orders');
		}
	}

	// ----------------------------------------------------------------------

}
