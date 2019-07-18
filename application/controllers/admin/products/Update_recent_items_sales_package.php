<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_recent_items_sales_package extends Admin_Controller {

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
	public function index()
	{
		echo 'Updating...<br />';
		
		// update Recent Items sales package with new items
		$this->load->library('sales_package/update_sales_package');
		if ( ! $this->update_sales_package->update_recent_items())
		{
			// set flash data
			$this->session->set_flashdata('error', 'recent_items_udpate');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/1');
		}
		
		// set flash data
		$this->session->set_flashdata('success', 'recent_items_udpate');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/1');
	}
	
	// ----------------------------------------------------------------------
	
}
