<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relapse extends MY_Controller {

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
		//$this->session->set_userdata('ws_last_active_time', time());

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');

		// we re-login user being as a new day after lapse
		$user_id = $this->session->user_id;

		// deinitialize any previouse sessions
		$this->wholesale_user_details->initialize();
		$this->wholesale_user_details->unset_session();

		// initialize wholesale_user_details
		if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$user_id)))
		{
			// in case something went wrong...
			// set flash data
			$this->session->set_flashdata('flashMsg', 'Something went wrong with your connection. Please login again');

			// redirect to categories page
			redirect(site_url('account'), 'location');
		}

		// if user is inactive or suspended
		if (
			$this->wholesale_user_details->status === '2'
			OR $this->wholesale_user_details->status === '0'
			OR $this->consumer_user_details->status === '0'
		)
		{
			// set flash notice
			$this->session->set_flashdata('error', 'status_inactive');

			// send to request for activation page
			redirect('account/request/activation');
		}

		// let us set sessions
		$this->wholesale_user_details->set_session();
		$this->consumer_user_details->set_session();

		if ($this->session->user_cat == 'wholesale')
		{
			// record login which starts the login session
			$this->wholesale_user_details->record_login_detail();

			// notify admin
			$this->wholesale_user_details->notify_admin_user_online();
		}

		// rediect back to sign in page
		redirect($this->session->flashdata('access_uri'));
	}

	// ----------------------------------------------------------------------

}
