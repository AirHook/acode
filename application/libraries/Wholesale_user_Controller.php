<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_user_Controller extends Frontend_Controller {

	/**
	 * Core Controller for Admin
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent libraries/models/helpers
		$this->load->library('users/wholesale_user_details');

		/*****
		 * ...is there a session for admin already?
		 * check for admin_loggedin session
		 */
		if(
			! $this->session->userdata('user_loggedin')
			OR $this->session->userdata('user_role') != 'wholesale'
		)
		{
			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// remove any previous session
			$this->wholesale_user_details->initialize();
			$this->wholesale_user_details->unset_session();

			// destroy any cart items
			$this->cart->destroy();

			// set flash message
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect to login page
			redirect('account', 'location');
		}

		/*****
		 * ...limiting sessions to 30 days
		 * 30 days can be set at Admin User Details class - $this->admin_user_details->session_lapse
		 * or, you may use the $config['sess_expiration'] from config.php file
		 */
		if ((
				! $this->session->userdata('ws_last_active_time')
				OR (($this->session->userdata('ws_last_active_time') + $this->config->item('sess_expiration')) < time())
			)
			// && (
				// $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'login'
				// && $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'forget_password'
				// && $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'register_admin'
				// && $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'logout'
			// )
		)
		{
			// --> access not allowed when not logged in
			// destroy admin user session if any
			$this->wholesale_user_details->unset_session();
			$this->wholesale_user_details->set_initial_state();

			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// set flash message
			$this->session->set_flashdata('login_info', 'Please login again.');

			// send user back to login page
			redirect('account', 'location');
		}

		/*****
		 * ...now, since login session already exists, initialize class admin user details again
		 */
		// initialize class admin user details
		$this->wholesale_user_details->initialize(array(
			'user_id' => $this->session->user_id
		));
    }

	// --------------------------------------------------------------------

}
