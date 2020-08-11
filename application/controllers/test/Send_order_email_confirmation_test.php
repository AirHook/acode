<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_order_email_confirmation_test extends MY_Controller {

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
	public function index($order_id)
	{
		/* *
		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// return and exit
			echo 'fail - no input data';
			exit;
		}
		// */

		// load pertinent library/model/helpers
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('orders/order_email_confirmation');
		$this->load->library('orders/order_details');

		// let's initialize class
		//$this->order_email_confirmation->initialize($this->input->post());

		// NOTE:
		// we use the order id from the url to process data
		// the true controller receives an input post data from an ajax call
		// we circumvent it here to test using the order email confirmation
		// sending by email by viewing it on browser for development debugging
		// purposes

		$order_details =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;
		$user_cat = $order_details->c;
		$user_id = $order_details->user_id;

		// initialize class
		$params = array(
			'user_id' => $user_id,
			'user_cat' => $user_cat,
			'order_id' => $order_id
		);
		$this->order_email_confirmation->initialize($params);

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
