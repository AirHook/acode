<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index($id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('users/sales_user_details');

		// this class is always used by a referring satellite site
		// to automatically authenticate a logged in user from the
		// satellite site
		// the if condition is just a precuation for now
		$return_url = $this->agent->is_referral() ? $this->agent->referrer() : 'account';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($return_url, 'location');
		}

		// re-authenticate user for local session
		if (
			! $this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $id
				)
			)
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'invalid');

			// redirect user
			redirect($return_url, 'location');
		}

		// let us set sessions
		// returns FALSE if not initialized
		$this->sales_user_details->set_session();

		// redirect user to sales dashboard
		redirect('my_account/sales/dashboard', 'location');
	}
}
