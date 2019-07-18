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
	 * Index - Suspend/Deactivate Account
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
			redirect($this->config->slash_item('admin_folder').'users/consumer');
		}
		
		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('is_active', '0');
		$DB->where('user_id', $id);
		$DB->update('tbluser_data');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}
	
	// ----------------------------------------------------------------------
	
}