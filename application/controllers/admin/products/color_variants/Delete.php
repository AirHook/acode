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
	public function index($id = '')
	{
		echo 'Processing...';
		
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'products/color_variants');
		}
		
		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('color_id', $id);
		$DB->delete('tblcolor');
		
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/color_variants');
	}
	
	// ----------------------------------------------------------------------
	
}