<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// redirect users
		redirect('admin/inventory/physical', 'location');
	}
}
