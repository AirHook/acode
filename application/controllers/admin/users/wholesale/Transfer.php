<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends Admin_Controller {

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
	public function index($id = '', $page = '')
	{
		echo 'Processing...';

		// load pertinent library/model/helpers
		$this->load->library('user_agent');

		// set redirect url
		if ($this->agent->is_referral())
		{
			$redirect = $this->agent->referrer();
		}
		else
		{
			$redirect = 'admin/users/wholesale'.($page != 'search' ? '/'.$page : '');
		}

		// check for params
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($redirect, 'location');
		}

		// get user details
		$this->load->library('users/wholesale_user_details');
		if ( ! $this->wholesale_user_details->initialize(array('user_id' => $id)))
		{
			// set flash data
			$this->session->set_flashdata('error', 'user_not_found');

			// redirect user
			redirect($redirect, 'location');
		}

		// let us check first if user email exists at consumer list
		$this->load->library('users/consumer_user_details');
		if (
			$this->consumer_user_details->initialize(
				array(
					'email' => $this->wholesale_user_details->email
				)
			)
		)
		{
			// set flash data
			$this->session->set_flashdata('error', 'user_already_exists');

			// redirect user
			redirect($redirect, 'location');
		}

		$data = array(
			'firstname' => $this->wholesale_user_details->fname,
			'lastname' => $this->wholesale_user_details->lname,
			'telephone' => $this->wholesale_user_details->telephone,
			'fax' => $this->wholesale_user_details->fax,
			'address1' => $this->wholesale_user_details->address1,
			'address2' => $this->wholesale_user_details->address2,
			'country' => $this->wholesale_user_details->country,
			'city' => $this->wholesale_user_details->city,
			'state_province' => $this->wholesale_user_details->state,
			'zip_postcode' => $this->wholesale_user_details->zipcode,
			'email' => $this->wholesale_user_details->email,
			'password' => $this->wholesale_user_details->password,
			'receive_productupd' => '1',
			'comment' => $this->wholesale_user_details->comments,
			'is_active' => $this->wholesale_user_details->is_active,
			'create_date' => $this->wholesale_user_details->create_date, // 'Y-m-d' format
			'active_date' => $this->wholesale_user_details->active_date, // 'Y-m-d' format
			'admin_sales_email' => $this->wholesale_user_details->admin_sales_email,
			'reference_designer' => $this->wholesale_user_details->reference_designer,
			'options' => json_encode($this->wholesale_user_details->options)
		);

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->insert('tbluser_data', $data);

		if ($data['is_active'] == '1')
		{
			// add user to mailgun list
			// no need to validate email as these are stores
			// force add users to mailgun
			$params['address'] = $data['is_active'];
			$params['fname'] = $data['is_active'];
			$params['lname'] = $data['is_active'];
			$params['description'] = 'Consumer Users';
			$params['list_name'] = 'consumers@mg.shop7thavenue.com';
			$this->load->library('mailgun/list_member_add', $params);
			$res = $this->list_member_add->add();
			$this->list_member_add->clear();
		}

		// once transferred we need to remove user from wholesale list
		$DB->where('user_id', $id);
		$DB->delete('tbluser_data_wholesale');

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
			$params['address'] = $this->wholesale_user_details->email;
			$params['list_name'] = $list_name;
			$this->load->library('mailgun/list_member_delete', $params);
			$res = $this->list_member_delete->delete();
		}

		// set flash data
		$this->session->set_flashdata('success', 'transfer');

		// redirect user
		redirect($redirect, 'location');
	}

	// ----------------------------------------------------------------------

}
