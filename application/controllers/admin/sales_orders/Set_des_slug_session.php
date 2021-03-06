<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_des_slug_session extends MY_Controller {

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
	 * Index - Set As Default
	 *
	 * Sets selected sales package as default sales package for the Send Sales Package
	 * button on the Wholesale User list actions column
	 *
	 * @return	void
	 */
	public function index($slug = '')
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

		if ( ! $slug)
		{
			// nothing more to do...
			echo 'error';
			exit;
		}

		// set session
		$this->session->admin_so_des_slug = $slug;

		// return
		echo 'success';
		exit;
	}

	// ----------------------------------------------------------------------

}
