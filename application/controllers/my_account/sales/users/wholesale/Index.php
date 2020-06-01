<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Sales_user_Controller {

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
		// send user to active list
		redirect('my_account/sales/users/wholesale/active', 'location');
	}

	// ----------------------------------------------------------------------

}
