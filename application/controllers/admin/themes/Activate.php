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
	 * Index - main class function
	 *
	 * @return	void
	 */
	public function index($id = '', $theme = '')
	{
		if ( ! $id OR ! $theme)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'themes');
		}
		
		// set theme option
		$this->webspace_details->options['theme'] = $theme;
		$post_ary['webspace_options'] = json_encode($this->webspace_details->options);
		
		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('webspace_id', $id);
		$query = $DB->update('webspaces', $post_ary);
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'themes');
	}
	
	// ----------------------------------------------------------------------
	
}