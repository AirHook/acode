<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// lets check for status of webspace and account
		$this->load->library('users/admin_user_details');
		if (
			$this->session->userdata('admin_loggedin')
			&& $this->admin_user_details->initialize(array('admin_id'=>$this->session->userdata('admin_id')))
		)
		{
			// run domain set wizard
			redirect($this->config->slash_item('admin_folder').'dashboard');
		}
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// let us remember the page being accessed other than index
		if ($this->session->flashdata('access_uri')) $this->session->set_flashdata('access_uri', $this->session->flashdata('access_uri'));

		// load pertinent library/helper/model
		$this->load->helper('state_country');

		// load login page
		$this->load->view(($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'login_01'));
	}

	// ----------------------------------------------------------------------

}
