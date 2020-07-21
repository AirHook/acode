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

		// unset sessions used by sales user
		// sale package create
		unset($_SESSION['sa_id']);
		unset($_SESSION['sa_des_slug']);
		unset($_SESSION['sa_slug_segs']);
		unset($_SESSION['sa_items']);
		unset($_SESSION['sa_name']); // used at view
		unset($_SESSION['sa_email_subject']); // used at view
		unset($_SESSION['sa_email_message']); // used at view
		unset($_SESSION['sa_options']);
		// sales package modify
		unset($_SESSION['sa_mod_id']);
		unset($_SESSION['sa_mod_items']);
		unset($_SESSION['sa_mod_slug_segs']);
		unset($_SESSION['sa_mod_options']);
		unset($_SESSION['sa_mod_des_slug']);
		// sales order create
		unset($_SESSION['so_user_id']);
		unset($_SESSION['so_des_slug']);
		unset($_SESSION['so_items']);

		// set flash message
		$this->session->set_flashdata('success', 'logout_successful');

		// redirect user back to login page
		redirect('account', 'location');
	}
}
