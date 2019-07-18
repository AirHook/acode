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
	public function index()
	{
		if ( ! $this->input->post())
		{
			echo 'Fail!';
			exit;
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		$DB->set('status', $this->input->post('status'));
		$DB->where('sales_order_id', $this->input->post('sales_order_id'));
		$DB->update('sales_orders');

		echo 'Success';
		exit;
	}

	// ----------------------------------------------------------------------

	/**
	 * Update
	 *
	 * @return	void
	 */
	public function update($sales_order_id = '', $status = '')
	{
		if ($sales_order_id == '' OR $status == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		$DB->set('status', $status);
		$DB->where('sales_order_id', $sales_order_id);
		$DB->update('sales_orders');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('sales/sales_orders', 'location');
	}

	// ----------------------------------------------------------------------

}
