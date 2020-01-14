<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clear_items extends Sales_user_Controller {

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
		unset($_SESSION['po_vendor_id']);
		unset($_SESSION['po_des_url_structure']);
		unset($_SESSION['po_items']);
		unset($_SESSION['po_size_qty']);
		unset($_SESSION['po_store_id']);
		unset($_SESSION['po_edit_vendor_price']);
		unset($_SESSION['po_slug_segs']);
		// remove po mod details
		unset($_SESSION['po_mod_po_id']);
		unset($_SESSION['po_mod_items']);
		unset($_SESSION['po_mod_size_qty']);
		unset($_SESSION['po_mod_edit_vendor_price']);
	}

	// ----------------------------------------------------------------------

}
