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
	public function index($tab_name = '', $id = '')
	{
		if ($tab_name)
		{
			// set flash data
			$this->session->set_userdata('active_tab', $tab_name);
		}
		
		if ($id)
		{
			// redirect user
			redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$id);
		}
		
		exit;
	}
	
	// ----------------------------------------------------------------------
	
}