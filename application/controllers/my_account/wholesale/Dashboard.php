<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Wholesale_user_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * INDEX - Redirec user to wholesale user orders page
	 *
	 * @return	void
	 */
	public function index()
	{
		redirect('my_account/wholesale/orders', 'location');
	}

	// ----------------------------------------------------------------------

}
