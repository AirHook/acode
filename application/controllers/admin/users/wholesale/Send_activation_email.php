<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_activation_email extends Admin_Controller {

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
	 * Index - Send Activation Email
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		echo 'Processing...<br />';

		if ( ! $id)
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'error_sending_activation_email');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get user details
		$this->wholesale_user_details->initialize(array('user_id' => $id));

		// load and initialize wholesale activation email sending library
		$this->load->library('users/wholesale_activation_email_sending');
		$this->wholesale_activation_email_sending->initialize(array('users'=>array($this->wholesale_user_details->email)));

		if ( ! $this->wholesale_activation_email_sending->send())
		{
			echo $this->wholesale_activation_email_sending->error;
			$this->session->set_flashdata('error', 'error_sending_activation_email');
			$this->session->set_flashdata('error_message', $this->wholesale_activation_email_sending->error);

			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// set flash data
		$this->session->set_flashdata('success', 'acivation_email_sent');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/wholesale');
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - Send Activation Email
	 *
	 * @return	void
	 */
	public function send($id = '')
	{
		echo 'Processing...<br />';

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('users/wholesale_user_details');

		if ( ! $this->input->post())
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'error_sending_activation_email');

			// redirect user
			if ($this->agent->is_referral())
			{
				redirect($this->agent->referrer(), 'location');
			}
			else redirect('admin/users/wholesale');
		}

		// get user details
		$this->wholesale_user_details->initialize(array('user_id' => $id));

		// load and initialize wholesale activation email sending library
		$this->load->library('users/wholesale_activation_email_sending');
		$this->wholesale_activation_email_sending->custom_message = $this->input->post('message');
		$this->wholesale_activation_email_sending->initialize(array('users'=>array($this->wholesale_user_details->email)));

		if ( ! $this->wholesale_activation_email_sending->send())
		{
			echo $this->wholesale_activation_email_sending->error;
			$this->session->set_flashdata('error', 'error_sending_activation_email');
			$this->session->set_flashdata('error_message', $this->wholesale_activation_email_sending->error);

			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// set flash data
		$this->session->set_flashdata('success', 'acivation_email_sent');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/wholesale');
	}

	// ----------------------------------------------------------------------

}
