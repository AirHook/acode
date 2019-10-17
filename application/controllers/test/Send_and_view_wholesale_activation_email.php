<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 */
class Send_and_view_wholesale_activation_email extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
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
			//redirect($this->config->slash_item('admin_folder').'users/wholesale');
		}

		// set flash data
		$this->session->set_flashdata('success', 'acivation_email_sent');
	}

	// --------------------------------------------------------------------

	/**
	 * View
	 *
	 * @return	void
	 */
	function view()
	{
		// set data variables...
		$this->data['file'] = 'wholesale_activate';
		$this->data['view'] = 'suspended';
		$this->data['page_title'] = $this->webspace_details->name;
		$this->data['page_description'] = $this->webspace_details->site_description;

		// load views...
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Mailgun Test
	 *
	 * @return	void
	 */
	function mgtest()
	{
		echo 'Processing...<br />';

		// load pertinent library/model/helpers
		$this->load->library('mailgun/mailgun');
		$this->mailgun->from = 'SHOP 7TH AVENUE <help@shop7thavenue.com>';
		$this->mailgun->to = 'rsbgm@rcpixel.com';
		$this->mailgun->subject = 'Test MG';
		$this->mailgun->message = 'Testing';

		if ( ! $this->mailgun->Send())
		{
			echo 'Unable to MG send to - rsbgm@rcpixel.com<br />';
			echo '-'.$this->mailgun->error_message;
		}
		else echo 'SENT';
	}

	// --------------------------------------------------------------------

}
