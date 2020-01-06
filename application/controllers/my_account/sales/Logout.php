<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// lets check for status of webspace and account
		$this->load->library('users/sales_user_details');

		// destroy sales user session if any and reset class to initial state
		$this->sales_user_details->unset_session();
		$this->sales_user_details->set_initial_state();

		// set flash message
		$this->session->set_flashdata('success', 'logout_successful');

		// redirect user back to login page
		redirect('account', 'location');
	}
}
