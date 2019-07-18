<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remove_images extends Admin_Controller {

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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($des_id = '', $field = '')
	{
		$field = strtolower($field);
		
		// initialize certain properties
		$this->load->library('designers/designer_details');
		
		// initialize properties
		if ( ! $this->designer_details->initialize(array('des_id' => $des_id)))
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			redirect($this->config->slash_item('admin_folder').'designers');
		}
		
		// unlink images
		unlink($this->designer_details->$field);
		
		// update record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set($field, '');
		$DB->where('des_id', $des_id);
		$q = $DB->update('designer');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'designers/edit/index/'.$this->designer_details->des_id);
	}
	
	// ----------------------------------------------------------------------
	
}