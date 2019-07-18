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
	public function index($facet = '', $id = '')
	{
		echo 'Processing...';
		
		if ( ! $facet OR ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'facets');
		}
		
		// process some info
		$istr = substr($facet, 0, -1);
		
		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where($istr.'_id', $id);
		$DB->delete('tbl'.($istr === 'color' ? 'colors' : $istr));
		
		// memorize the last tab using session
		$this->session->set_userdata('active_facet', $facet);
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'facets');
	}
	
	// ----------------------------------------------------------------------
	
}