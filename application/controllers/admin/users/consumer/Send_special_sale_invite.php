<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_special_sale_invite extends Admin_Controller {

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
	public function index($user_id = '')
	{
		echo 'Processing...<br />';

		// send the sales package
		$this->load->library('users/consumer_send_special_sale_invite');
		$this->consumer_send_special_sale_invite->initialize(array($user_id));

		if ( ! $this->consumer_send_special_sale_invite->send())
		{
			$this->session->set_flashdata('error', 'error_sending_package');

			redirect($this->config->slash_item('admin_folder').'users/consumer');
		}

		// set flash data
		$this->session->set_flashdata('success', 'pacakge_sent');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - Send Activation Email
	 *
	 * @return	void
	 */
	public function view()
	{
		// send the sales package
		$this->load->library('users/consumer_send_special_sale_invite');
		$this->consumer_send_special_sale_invite->initialize(array('75926'));

		if ( ! $this->consumer_send_special_sale_invite->send())
		{
			$this->session->set_flashdata('error', 'error_sending_package');

			redirect($this->config->slash_item('admin_folder').'users/consumer');
		}

		echo 'Done';
		exit;

		// set flash data
		$this->session->set_flashdata('success', 'pacakge_sent');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/consumer');
	}

	// ----------------------------------------------------------------------

}
