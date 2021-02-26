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
		// redirect user
		if ($id)
		{
			unset($_SESSION['sa_mod_id']);
			unset($_SESSION['sa_mod_items']);
			unset($_SESSION['sa_mod_slug_segs']);
			unset($_SESSION['sa_mod_options']);
			unset($_SESSION['sa_mod_des_slug']); // session for designer drop down for hub sites
			unset($_SESSION['sa_mod_designers']); // hub site mixed designer case

			redirect('my_account/sales/sales_package/modify/index/'.$id, 'location');
		}
		else
		{
			unset($_SESSION['sa_id']);
			unset($_SESSION['sa_des_slug']); // session for designer drop down for hub sites
			unset($_SESSION['sa_designers']); // hub site mixed designer case
			unset($_SESSION['sa_slug_segs']);
			unset($_SESSION['sa_items']);
			unset($_SESSION['sa_name']); // used at view
			unset($_SESSION['sa_email_subject']); // used at view
			unset($_SESSION['sa_email_message']); // used at view
			unset($_SESSION['sa_options']);

			redirect('my_account/sales/sales_package/create');
		}
	}

	// ----------------------------------------------------------------------

}
