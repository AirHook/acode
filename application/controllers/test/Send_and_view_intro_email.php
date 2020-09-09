<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 */
class Send_and_view_intro_email extends CI_Controller
{
	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		echo 'Processing...<br />';

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get user details
		$this->wholesale_user_details->initialize(array('email' => 'rsbgm@tempoparis.com'));

		$this->wholesale_user_details->send_intro_email();

		echo 'sent';
	}

	// --------------------------------------------------------------------

}
