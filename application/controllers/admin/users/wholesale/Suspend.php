<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suspend extends Admin_Controller {

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
	 * Index - Suspend/Deactivate Account
	 *
	 * @return	void
	 */
	public function index($id = '', $page = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/users/wholesale'.($page != 'search' ? '/'.$page : ''), 'location');
		}

		// get and set item details for odoo and recent items
		$this->load->library('users/wholesale_user_details');
		$this->wholesale_user_details->initialize(array('user_id'=>$id));

		// get list name for mailgun udpate on all status
		switch ($this->wholesale_user_details->reference_designer)
		{
			case 'tempoparis':
				$list_name = 'ws_tempo@mg.shop7thavenue.com';
			break;
			case 'basixblacklabel':
				$list_name = 'wholesale_users@mg.shop7thavenue.com';
			break;
			default:
				$list_name = '';
		}

		if ($list_name)
		{
			// remove user from mailgun list
			// only basix for now
			$params['address'] = $this->wholesale_user_details->email;
			$params['list_name'] = $list_name;
			$this->load->library('mailgun/list_member_delete', $params);
			$res = $this->list_member_delete->delete();
		}

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('active_date', '');
		$DB->set('is_active', '2');
		$DB->where('user_id', $id);
		$DB->update('tbluser_data_wholesale');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/users/wholesale'.($page != 'search' ? '/'.$page : ''), 'location');
	}

	// ----------------------------------------------------------------------

}
