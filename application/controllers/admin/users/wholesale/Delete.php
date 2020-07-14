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
			redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get and set item details for odoo and recent items
		$this->wholesale_user_details->initialize(array('user_id'=>$id));

		// remove from sidebar recent items
		// update recent list for edited vendor users
		$this->webspace_details->update_recent_users(
			array(
				'user_type' => 'wholesale_users',
				'user_id' => $id,
				'user_name' => $this->wholesale_user_details->store_name
			),
			'remove'
		);

		// remove user from mailgun list
		$params['address'] = $this->wholesale_user_details->email;
		$params['list_name'] = 'wholesale_users@mg.shop7thavenue.com';
		$this->load->library('mailgun/list_member_delete', $params);
		$res = $this->list_member_delete->delete();

		// note in comments
		$comments = 'Previously associated with '
			.$this->wholesale_user_details->designer
			.' under sales agent '
			.$this->wholesale_user_details->admin_sales_email
			.'<br />'
		;

		// delete item from records
		$DB = $this->load->database('instyle', TRUE);

		if (
			$this->admin_user_detail->acess_level === '0'
			OR $this->admin_user_detail->acess_level === '1'
			OR $this->admin_user_detail->acess_level === '2'
		)
		{
			// designer levels cannot delete users
			// instead, remove designer association from user
			$DB->set('admin_sales_id', NULL);
			$DB->set('admin_sales_email', NULL);
			$DB->set('reference_designer', NULL);
			$DB->set('is_active', '0');
			$DB->set('comments', $comments);
			$DB->where('user_id', $id);
			$DB->update('tbluser_data_wholesale');
		}
		else
		{
			$DB->where('user_id', $id);
			$DB->delete('tbluser_data_wholesale');
		}

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/wholesale');
	}

	// ----------------------------------------------------------------------

}
