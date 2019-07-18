<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Admin_Controller {

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
	 * Index - Delete Account
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
			redirect($this->config->slash_item('admin_folder').'users/sales');
		}
		
		if ($id === '1')
		{
			// cannot delete super sales
			// set flash data
			$this->session->set_flashdata('error', 'del_super_sales_not_allowed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/sales');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');
		$this->load->library('odoo');
		
		// get and set item details for odoo and recent items
		$this->sales_user_details->initialize(array('tbladmin_sales.admin_sales_id'=>$id));
	
		// remove from sidebar recent items
		// update recent list for edited vendor users
		$this->webspace_details->update_recent_users(
			array(
				'user_type' => 'sales_users',
				'user_id' => $id,
				'user_name' => $this->sales_user_details->fname.' '.$this->sales_user_details->lname
			),
			'remove'
		);
	
		// set some items for odoo
		$post_ary['user_id'] = $id;
		
		/***********
		 * Update ODOO
		 */
		 
		// pass data to odoo
		if (
			ENVIRONMENT !== 'development'
			&& $this->sales_user_details->designer == 'basixblacklabel'
		) 
		{
			$odoo_response = $this->odoo->post_data($post_ary, 'sales_users', 'del');
		}
		
		//echo '<pre>';
		//print_r($post_ary);
		//echo $odoo_response;
		//die('<br />Died!');
		
		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('admin_sales_id', $id);
		$DB->delete('tbladmin_sales');
		
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/sales');
	}
	
	// ----------------------------------------------------------------------
	
}