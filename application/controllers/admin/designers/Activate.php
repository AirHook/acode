<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate extends Admin_Controller {

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
	 * Index - Activate Account
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
			redirect($this->config->slash_item('admin_folder').'designers');
		}
		
		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('view_status', 'Y');
		$DB->where('des_id', $id);
		$DB->update('designer');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'designers');
	}
	
	// ----------------------------------------------------------------------
	
}