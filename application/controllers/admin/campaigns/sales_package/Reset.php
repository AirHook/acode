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
	public function index($id = '')
	{
		// reset sessions
		unset($_SESSION['admin_sa_id']);
		unset($_SESSION['admin_sa_des_slug']);
		unset($_SESSION['admin_sa_slug_segs']);
		unset($_SESSION['admin_sa_items']);
		unset($_SESSION['admin_sa_name']);
		unset($_SESSION['admin_sa_email_subject']);
		unset($_SESSION['admin_sa_email_message']);
		unset($_SESSION['admin_sa_options']);
		// remove po mod details
		unset($_SESSION['admin_sa_mod_po_id']);
		unset($_SESSION['admin_sa_mod_items']);
		unset($_SESSION['admin_sa_mod_options']);
		unset($_SESSION['admin_sa_mod_edit_vendor_price']);

		// redirect user
		if ($id) redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/modify/index/'.$id, 'location');
		else redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/create', 'location');
	}

	// ----------------------------------------------------------------------

}
