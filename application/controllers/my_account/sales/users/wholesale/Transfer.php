<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends Sales_user_Controller {

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
		else $redirect = 'admin/users/wholesale/'.$page;

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

		// once transferred we need to remove user from wholesale list
		$DB->where('user_id', $id);
		$DB->delete('tbluser_data_wholesale');

		// set flash data
		$this->session->set_flashdata('success', 'transfer');

		// redirect user
		redirect($redirect, 'location');
	}

	// ----------------------------------------------------------------------

}
