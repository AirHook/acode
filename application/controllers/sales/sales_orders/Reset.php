<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends Sales_Controller {

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
	 * @return	void
	 */
	public function index()
	{
		// let's ensure that there are no admin session for po
		unset($_SESSION['so_items']);
		unset($_SESSION['so_size_qty']);
		unset($_SESSION['so_stocstat']);
		unset($_SESSION['so_store_id']);
		unset($_SESSION['so_mod']);

		echo 'Reset done!';
	}

	// ----------------------------------------------------------------------

}
