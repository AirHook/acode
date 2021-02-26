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
			unset($_SESSION['sa_pp_mod_id']);
			unset($_SESSION['sa_pp_mod_items']);
			unset($_SESSION['sa_pp_mod_slug_segs']);
			unset($_SESSION['sa_pp_mod_options']);
			unset($_SESSION['sa_pp_mod_des_slug']); // session for designer drop down for hub sites
			unset($_SESSION['sa_pp_mod_designers']); // hub site mixed designer case

			redirect('my_account/sales/photo_package/modify/index/'.$id, 'location');
		}
		else
		{
			unset($_SESSION['sa_pp_id']);
			unset($_SESSION['sa_pp_des_slug']); // session for designer drop down for hub sites
			unset($_SESSION['sa_pp_designers']); // hub site mixed designer case
			unset($_SESSION['sa_pp_slug_segs']);
			unset($_SESSION['sa_pp_items']);
			unset($_SESSION['sa_pp_name']); // used at view
			unset($_SESSION['sa_pp_email_subject']); // used at view
			unset($_SESSION['sa_pp_email_message']); // used at view
			unset($_SESSION['sa_pp_options']);

			redirect('my_account/sales/photo_package/create');
		}
	}

	// ----------------------------------------------------------------------

}
