<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_active_tab extends Admin_Controller {

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
	public function index($tab_name = '')
	{
		echo 'Processing...<br />';
		
		if ( ! $tab_name)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories');
		}
		
		// set flash data
		$this->session->set_userdata('active_facet_tab', $tab_name);
		
		exit;
	}
	
	// ----------------------------------------------------------------------
	
}