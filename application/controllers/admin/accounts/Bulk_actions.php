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
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$DB->set('account_status', '1');
			break;
			
			case 'su':
				$DB->set('account_status', '0');
			break;
		}
		
		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('account_id', $id);
			else $DB->or_where('account_id', $id);
		}
		
		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			$DB->delete('accounts');
			
			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('accounts');
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'accounts');
	}
	
	// ----------------------------------------------------------------------
	
}