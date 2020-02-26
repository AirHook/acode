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

		// get and set user details
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

		// delete item from records
		$DB = $this->load->database('instyle', TRUE);
		$DB->where('user_id', $id);
		$DB->delete('tbluser_data');

		// delete user from mailgun list
		// only basix for now
		if ($this->consumer_user_details->reference_designer == 'basixblacklabel')
		{
			$params['address'] = $this->consumer_user_details->email;
			$params['list_name'] = 'consumers@mg.shop7thavenue.com';
			$this->load->library('mailgun/list_member_delete', $params);
			$res = $this->list_member_delete->delete();
		}

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}

	// ----------------------------------------------------------------------

}
