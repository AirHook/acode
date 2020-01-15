<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends Sales_user_Controller {

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
	public function index($id = '', $remarks = '')
	{
		if ( ! $id OR ! $remarks)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/sales_orders','location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		switch ($remarks)
		{
			case 'exchange':
				$DB->set('remarks', '1');
			break;
			case 'scredit':
				$DB->set('remarks', '2');
			break;
			case 'refund':
				$DB->set('remarks', '3');
			break;
			case 'others':
				$DB->set('remarks', '4');
				if ($this->input->post('comments')) $DB->set('comments', $this->input->post('comments'));
			break;
			default:
				$DB->set('remarks', '0');
		}

		$DB->where('sales_order_id', $id);
		$DB->update('sales_orders');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('my_account/sales/sales_orders/details/index/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

}
