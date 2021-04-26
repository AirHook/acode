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
	 * This method simply lists all lookbooks
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ($id)
		{
			// remove po mod details
			unset($_SESSION['lb_mod_id']);
			unset($_SESSION['lb_mod_items']);
			unset($_SESSION['lb_mod_slug_segs']);
			unset($_SESSION['lb_mod_options']);
			unset($_SESSION['lb_mod_des_slug']);

			redirect('my_account/sales/lookbook/modify/index/'.$id, 'location');
		}
		else
		{
			// reset sessions
			unset($_SESSION['lb_id']);
			unset($_SESSION['lb_des_slug']);
			unset($_SESSION['lb_slug_segs']);
			unset($_SESSION['lb_items']);
			unset($_SESSION['lb_name']);
			unset($_SESSION['lb_email_subject']);
			unset($_SESSION['lb_email_message']);
			unset($_SESSION['lb_options']);

			redirect('my_account/sales/lookbook/create', 'location');
		}
	}

	// ----------------------------------------------------------------------

}
