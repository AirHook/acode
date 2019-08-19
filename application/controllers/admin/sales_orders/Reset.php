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
		unset($_SESSION['admin_so_designer']);
		unset($_SESSION['admin_so_vendor_id']);
		unset($_SESSION['admin_so_store_id']);
		unset($_SESSION['admin_so_author']);
		unset($_SESSION['admin_so_dely_date']);
		unset($_SESSION['admin_so_items']);
		unset($_SESSION['admin_so_slug_segs']);
		// reset sessions
		unset($_SESSION['admin_so_mod_so_id']);
		unset($_SESSION['admin_so_mod_so_items']);

		// redirect user
		redirect($this->config->slash_item('admin_folder').'sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
