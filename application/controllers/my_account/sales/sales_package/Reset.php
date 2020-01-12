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
	public function index($id = '')
	{
		// reset sessions
		unset($_SESSION['sa_id']);
		unset($_SESSION['sa_des_slug']);
		unset($_SESSION['sa_slug_segs']);
		unset($_SESSION['sa_items']);
		unset($_SESSION['sa_name']);
		unset($_SESSION['sa_email_subject']);
		unset($_SESSION['sa_email_message']);
		unset($_SESSION['sa_options']);
		// remove po mod details
		unset($_SESSION['sa_mod_id']);
		unset($_SESSION['sa_mod_items']);
		unset($_SESSION['sa_mod_slug_segs']);
		unset($_SESSION['sa_mod_options']);
		unset($_SESSION['sa_mod_des_slug']);

		// redirect user
		if ($id) redirect('my_account/sales/sales_package/modify/index/'.$id, 'location');
		else
		{
			redirect('my_account/sales/sales_package/create');
		}
	}

	// ----------------------------------------------------------------------

}
