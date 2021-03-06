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
		unset($_SESSION['admin_so_des_slug']);
		unset($_SESSION['admin_so_slug_segs']);
		unset($_SESSION['admin_so_dely_date']);
		unset($_SESSION['admin_so_items']);
		unset($_SESSION['admin_so_ship_to']); // 1 - use same address, 2 - enter manual info
		unset($_SESSION['admin_so_sh_store_name']);
		unset($_SESSION['admin_so_sh_fname']);
		unset($_SESSION['admin_so_sh_lname']);
		unset($_SESSION['admin_so_sh_email']);
		unset($_SESSION['admin_so_sh_address1']);
		unset($_SESSION['admin_so_sh_address2']);
		unset($_SESSION['admin_so_sh_city']);
		unset($_SESSION['admin_so_sh_state']);
		unset($_SESSION['admin_so_sh_country']);
		unset($_SESSION['admin_so_sh_zipcode']);
		unset($_SESSION['admin_so_sh_telephone']);
		// remove po mod details
		unset($_SESSION['admin_so_mod_so_id']);
		unset($_SESSION['admin_so_mod_items']);

		// redirect user
		redirect('admin/sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
