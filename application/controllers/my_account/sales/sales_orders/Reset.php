<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends Sales_user_Controller {

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
		unset($_SESSION['so_user_id']); // store or consumer and 0 for manual input
		unset($_SESSION['so_user_cat']); // ws, cs
		unset($_SESSION['so_des_slug']);
		unset($_SESSION['so_slug_segs']);
		unset($_SESSION['so_dely_date']);
		unset($_SESSION['so_items']);
		unset($_SESSION['so_ship_to']); // 1 - use same address, 2 - enter manual info
		unset($_SESSION['so_sh_store_name']);
		unset($_SESSION['so_sh_fname']);
		unset($_SESSION['so_sh_lname']);
		unset($_SESSION['so_sh_email']);
		unset($_SESSION['so_sh_address1']);
		unset($_SESSION['so_sh_address2']);
		unset($_SESSION['so_sh_city']);
		unset($_SESSION['so_sh_state']);
		unset($_SESSION['so_sh_country']);
		unset($_SESSION['so_sh_zipcode']);
		unset($_SESSION['so_sh_telephone']);
		// remove po mod details
		unset($_SESSION['so_mod_so_id']);
		unset($_SESSION['so_mod_items']);

		// redirect user
		redirect('my_account/sales/sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
