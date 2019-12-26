<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Consumer_user_Controller {
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------Redirect to Consumer Orders Page------------------------------------------

	public function index()
	{
		redirect('/my_account/consumer/orders');
	}
}