<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

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
			case 'pe':
				$DB->set('status', '0');
				$DB->set('remarks', '0');
			break;
			case 'ho':
				$DB->set('status', '2');
				$DB->set('remarks', '0');
			break;
			case 'ca':
				$DB->set('status', '3');
				$DB->set('remarks', '0');
			break;
			case 're':
				$DB->set('status', '4');
				$DB->set('remarks', '0');
			break;
			case 'co':
				$DB->set('status', '1');
				$DB->set('remarks', '0');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('order_log_id', $id);
			else $DB->or_where('order_log_id', $id);
		}

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			$DB->delete('tbl_order_log');

			// we need to delete the transaction records as well
			$DB->where('order_log_id', $id);
			$DB->delete('tbl_order_log_details');

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('tbl_order_log');

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// redirect user
		redirect($this->config->slash_item('admin_folder').'orders', 'location');
	}

	// ----------------------------------------------------------------------

}
