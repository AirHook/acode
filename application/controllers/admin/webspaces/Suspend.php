<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suspend extends Admin_Controller {

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
	public function index($id = '')
	{
		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('webspace_status', '0');
		$DB->where('webspace_id', $id);
		$DB->update('webspaces');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'webspaces');
	}
	
	// ----------------------------------------------------------------------
	
}