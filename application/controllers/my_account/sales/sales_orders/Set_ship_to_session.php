<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_ship_to_session extends MY_Controller {

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
	 * Index - Defailt Method
	 *
	 *
	 * @return	void
	 */
	public function index($ship_to = '')
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/admin_user_details');

		// get admin login details
		if ($this->session->admin_loggedin)
		{
			$this->admin_user_details->initialize(
				array(
					'admin_id' => $this->session->admin_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		// set session
		if ($ship_to == '1' OR $ship_to == '2')
		{
			// 1 - use same address, 2 - enter manual info, data fed by ajax call
			$this->session->so_ship_to = $ship_to;
			echo 'success';
		}
		else echo 'error';

		exit;
	}

	// ----------------------------------------------------------------------

}
