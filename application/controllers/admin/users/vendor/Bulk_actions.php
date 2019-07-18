<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// load pertinent library/model/helpers
		$this->load->library('users/vendor_user_details');
		$this->load->library('odoo');
		
		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$status = '1';
				$DB->set('is_active', '1');
			break;
			
			case 'su':
				$status = '0';
				$DB->set('is_active', '0');
			break;
		}
		
		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			// set database query clauses
			if ($key === 0) $DB->where('vendor_id', $id);
			else $DB->or_where('vendor_id', $id);
			
			// get and set item details for odoo and recent items
			$this->vendor_user_details->initialize(array('vendors.vendor_id'=>$id));
		
			// remove from recent items
			// update recent list for edited vendor users
			if ($this->input->post('bulk_action') === 'del')
			{
				$this->webspace_details->update_recent_users(
					array(
						'user_type' => 'vendor_users',
						'user_id' => $id,
						'user_name' => $this->vendor_user_details->vendor_name
					),
					'remove'
				);
			}
			
			// set some items for odoo
			$post_ary['vendor_id'] = $id;
			$post_ary['vendor_name'] = $this->vendor_user_details->vendor_name;
			if (@$status) $post_ary['status'] = $status;
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			// this is needed here because of the vendor_id that is needed to pass
			if (
				ENVIRONMENT !== 'development'
				&& $this->vendor_user_details->reference_designer == 'basixblacklabel'
			)
			{
				if ($this->input->post('bulk_action') === 'del')
				{
					$odoo_response = $this->odoo->post_data($post_ary, 'vendors', 'del');
				}
				else
				{
					$odoo_response = $this->odoo->post_data($post_ary, 'vendors', 'edit');
				}
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die('<br />Died!');
		}
		
		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			$DB->delete('vendors');
			
			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('vendors');
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/vendor');
	}
	
	// ----------------------------------------------------------------------
	
}