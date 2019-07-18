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
			redirect($this->config->slash_item('admin_folder').'users/consumer');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/consumer_user_details');
		$this->load->library('odoo');
		
		// get and set item details for odoo and recent items
		$this->consumer_user_details->initialize(array('user_id'=>$id));
	
		// remove from sidebar recent items
		// update recent list for edited vendor users
		$this->webspace_details->update_recent_users(
			array(
				'user_type' => 'consumer_users',
				'user_id' => $id,
				'user_name' => $this->consumer_user_details->fname.' '.$this->consumer_user_details->lname
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
			&& $this->consumer_user_details->reference_designer == 'basixblacklabel'
		) 
		{
			$odoo_response = $this->odoo->post_data($post_ary, 'consumer_users', 'del');
		}
		
		//echo '<pre>';
		//print_r($post_ary);
		//echo $odoo_response;
		//die('<br />Died!');
		
		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('user_id', $id);
		$DB->delete('tbluser_data');
		
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}
	
	// ----------------------------------------------------------------------
	
}