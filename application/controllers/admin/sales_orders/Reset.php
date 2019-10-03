<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends Admin_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// reset sessions
		unset($_SESSION['admin_so_user_id']); // store or consumer and 0 for manual input
		unset($_SESSION['admin_so_user_cat']); // ws, cs
		unset($_SESSION['admin_so_slug_segs']);
		unset($_SESSION['admin_so_dely_date']);
		unset($_SESSION['admin_so_items']);
		// remove po mod details
		unset($_SESSION['admin_so_mod_so_id']);
		unset($_SESSION['admin_so_mod_so_items']);
		unset($_SESSION['admin_so_mod_items']);

		// redirect user
		redirect($this->config->slash_item('admin_folder').'sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
