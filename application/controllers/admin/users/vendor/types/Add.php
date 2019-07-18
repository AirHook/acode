<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

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
	public function index()
	{
		echo 'Processing...';
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		$query1 = $DB->get_where('vendor_types', array('slug'=>$this->input->post('slug')));
		$exists = $query1->row();
		
		// information already existing..
		if (isset($exists))
		{
			// set flash data
			$this->session->set_flashdata('error', 'exists');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/vendor/types');
		}
		
		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		$post_ary['is_active'] = '1';
		// unset unneeded variables
		//unset($post_ary['table']);
		
		$query = $DB->insert('vendor_types', $post_ary);
		
		// set flash data
		$this->session->set_flashdata('success', 'add');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/vendor/types');
	}
	
	// ----------------------------------------------------------------------
	
}