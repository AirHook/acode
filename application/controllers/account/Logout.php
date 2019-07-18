<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

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
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');

		// unset sessions
		$this->wholesale_user_details->unset_session();
		$this->consumer_user_details->unset_session();

		// deinitialize classes
		$this->wholesale_user_details->set_initial_state();
		$this->consumer_user_details->set_initial_state();

		// redirect user to account signin page
		if ($this->session->flashdata('days_lapsed'))
		{
			$this->session->set_flashdata('success', 'days_lapsed');
		}
		else $this->session->set_flashdata('success', 'logout_successful');

		// rediect back to sign in page
		redirect('account');
	}

	// ----------------------------------------------------------------------

}
