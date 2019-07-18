<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clear_all_items extends MY_Controller {

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
	 * Index - default method
	 *
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		/* */
		// yes, it's as simple as destroying the session
		unset($_SESSION['sa_items']);
		unset($_SESSION['sa_options']);

		unset($_SESSION['sa_id']);
		unset($_SESSION['sa_name']);
		unset($_SESSION['sa_email_subject']);
		unset($_SESSION['sa_email_message']);
		unset($_SESSION['sa_prev_items']);
		unset($_SESSION['sa_prev_e_prices']);
		unset($_SESSION['show_prev_e_prices']);
		unset($_SESSION['show_prev_e_prices_modal']);
		unset($_SESSION['sa_preset']);
		// */

		echo 'clear';
	}

	// ----------------------------------------------------------------------

}
