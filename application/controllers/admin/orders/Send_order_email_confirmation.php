<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_order_email_confirmation extends Admin_Controller {

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
	 * Index - Delete Account
	 *
	 * @return	void
	 */
	public function index()
	{
		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// return and exit
			echo 'fail - no input data';
			exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('orders/order_email_confirmation');

		// let's initialize class
		$this->order_email_confirmation->initialize($this->input->post());

		// send order email confirmation
		$is_sent = $this->order_email_confirmation->send();

		echo $is_sent;

		if ( ! $is_sent)
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// return and exit
			echo 'fail - not sent';
			exit;
		}

		// set flash data
		$this->session->set_flashdata('success', 'email_confirmation_sent');

		// return and exit
		echo 'success';
		exit;
	}

	// ----------------------------------------------------------------------

}
