<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Sales_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');

		// unset sessions through library
		$this->sales_user_details->set_initial_state();

		/* */
		// yes, it's as simple as destroying the sessions
		unset($_SESSION['sa_items']);
		unset($_SESSION['sa_options']);

		unset($_SESSION['sa_id']);
		unset($_SESSION['sa_name']);
		unset($_SESSION['sa_email_subject']);
		unset($_SESSION['sa_email_message']);
		unset($_SESSION['sa_prev_items']);
		unset($_SESSION['sa_prev_e_prices']);
		unset($_SESSION['show_prev_e_prices']);
		unset($_SESSION['show_prev_e_prices_modal']);
		unset($_SESSION['sa_preset']);
		// */

		$re_url = site_url('resource');

		redirect($re_url, 'location');
	}

	// --------------------------------------------------------------------

}
