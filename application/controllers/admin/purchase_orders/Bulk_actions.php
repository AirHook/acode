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
			break;

			case 'ho':
				$DB->set('status', '1');
			break;

			case 'co':
				$DB->set('status', '5');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('po_id', $id);
			else $DB->or_where('po_id', $id);
		}

		// update records
		//$DB->update('purchase_orders');

		// update stocks for completed PO
		if ($this->input->post('bulk_action') == 'co')
		{
			$this->_update_stocks($id);
		}

		die();

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'purchase_orders', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Stocks
	 *
	 * @return	void
	 */
	private function _update_stocks($po_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('inventory/update_stocks');
		$this->update_stocks->po_completed($po_id);
	}

	// ----------------------------------------------------------------------

}
