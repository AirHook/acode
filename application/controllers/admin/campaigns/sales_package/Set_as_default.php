<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_as_default extends Admin_Controller {

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
	 * Index - Set As Default
	 *
	 * Sets selected sales package as default sales package for the Send Sales Package
	 * button on the Wholesale User list actions column
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
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package');
		}
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// remove any other set as defaul package
		$DB->set('set_as_default', '0');
		$q1 = $DB->update('sales_packages');
		
		// finally, update records
		$DB->set('set_as_default', '1');
		$DB->where('sales_package_id', $id);
		$q = $DB->update('sales_packages');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
	}
	
	// ----------------------------------------------------------------------
	
}