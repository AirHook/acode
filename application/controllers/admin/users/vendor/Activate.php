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
			redirect($this->config->slash_item('admin_folder').'users/vendor');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/vendor_user_details');
		$this->load->library('odoo');
		
		// get and set item details for odoo
		$this->vendor_user_details->initialize(array('vendors.vendor_id'=>$id));
	
		// set some items for odoo
		$post_ary['vendor_id'] = $id;
		$post_ary['vendor_name'] = $this->vendor_user_details->vendor_name;
		$post_ary['status'] = '1';
		
		/***********
		 * Update ODOO
		 */
		 
		// pass data to odoo
		if (
			ENVIRONMENT !== 'development'
			&& $this->vendor_user_details->reference_designer == 'basixblacklabel'
		) 
		{
			$odoo_response = $this->odoo->post_data($post_ary, 'vendors', 'edit');
		}
		
		//echo '<pre>';
		//print_r($post_ary);
		//echo $odoo_response;
		//die('<br />Died!');
		
		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('is_active', '1');
		$DB->where('vendor_id', $id);
		$DB->update('vendors');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/vendor');
	}
	
	// ----------------------------------------------------------------------
	
}