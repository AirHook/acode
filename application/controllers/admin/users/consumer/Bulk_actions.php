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
			case 'ac':
				$DB->set('is_active', '1');
			break;
			case 'in':
				$DB->set('is_active', '0');
			break;
			case 'su':
				$DB->set('is_active', '2');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('user_id', $id);
			else $DB->or_where('user_id', $id);
		}

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			$DB->delete('tbluser_data');

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('tbluser_data');

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}

	// ----------------------------------------------------------------------

}
