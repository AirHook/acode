<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

	/**
	 * Core Controller for Admin
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent libraries/models/helpers
		$this->load->library('users/admin_user_details');
		$this->load->library('designers/designer_details');

		/*****
		 * ...is there a session for admin already?
		 * check for admin_loggedin session
		 */
		if ( ! $this->session->userdata('admin_loggedin'))
		{
			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// set flash message
			$this->session->set_flashdata('login_info', 'You must be logged in to access page.');

			// redirect to login page
			redirect($this->config->slash_item('admin_folder').'login');
		}

		/*****
		 * ...limiting sessions to 30 days
		 * 30 days can be set at Admin User Details class - $this->admin_user_details->session_lapse
		 * or, you may use the $config['sess_expiration'] from config.php file
		 */
		if ((
				! $this->session->userdata('admin_login_time')
				OR (($this->session->userdata('admin_login_time') + $this->config->item('sess_expiration')) < time())
			)
			&& (
				$this->uri->uri_string() !== $this->config->slash_item('admin_folder').'login'
				&& $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'forget_password'
				&& $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'register_admin'
				&& $this->uri->uri_string() !== $this->config->slash_item('admin_folder').'logout'
			)
		)
		{
			// --> access not allowed when not logged in
			// destroy admin user session if any
			$this->admin_user_details->unset_session();
			$this->admin_user_details->set_initial_state();

			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// set flash message
			$this->session->set_flashdata('login_info', 'Please login again.');

			// send user back to login page
			redirect($this->config->slash_item('admin_folder').'login');
		}

		/*****
		 * ...now, since login session already exists, initialize class admin user details again
		 */
		// initialize class admin user details
		$this->admin_user_details->initialize(array(
			'admin_id' => $this->session->userdata('admin_id')
		));

		/*****
		 * some redirect functions to differentiate what is hub site admin and satellite site admin
		 * usually, hub site admin is super admin
		 */
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			if ($this->uri->segment(2) == 'webspaces') redirect('admin/settings/general');
			if ($this->uri->segment(2) == 'accounts') redirect('admin/settings/general');

			if ($this->uri->segment(3) == 'consumer') redirect('admin/dashboard');
		}
    }

	// --------------------------------------------------------------------

}
