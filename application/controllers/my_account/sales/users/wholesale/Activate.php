<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate extends Sales_user_Controller {

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
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index($id = '', $page = '', $activation_email = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/users/wholesale/'.$page, 'location');
		}

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('active_date', date('Y-m-d', time()));
		$DB->set('is_active', '1');
		$DB->where('user_id', $id);
		$DB->update('tbluser_data_wholesale');

		if ($activation_email)
		{
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
				redirect('my_account/sales/users/wholesale/'.$page, 'location');
			}

			// set flash data
			$this->session->set_flashdata('success', 'acivation_email_sent');
		}

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('my_account/sales/users/wholesale/'.$page, 'location');
	}

	// ----------------------------------------------------------------------

}
