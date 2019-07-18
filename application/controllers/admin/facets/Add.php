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
		
		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// unset unneeded variables
		unset($post_ary['table']);
		unset($post_ary['facet']);
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		$query = $DB->insert($this->input->post('table'), $post_ary);
		
		// set flash data
		$this->session->set_userdata('active_facet', $this->input->post('facet'));
		$this->session->set_flashdata('success', 'add');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'facets');
	}
	
	// ----------------------------------------------------------------------
	
}