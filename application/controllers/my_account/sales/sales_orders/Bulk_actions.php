<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Sales_user_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ca':
				$DB->set('status', '8');
			break;
			case 'pe':
				$DB->set('status', '4');
			break;
			case 're':
				$DB->set('status', '3');
			break;
			case 'ho':
				$DB->set('status', '2');
			break;
			case 'co':
				$DB->set('status', '1');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('sales_order_id', $id);
			else $DB->or_where('sales_order_id', $id);
		}

		$DB->update('sales_orders');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('my_account/sales/sales_orders', 'location');
	}

	// ----------------------------------------------------------------------

}
