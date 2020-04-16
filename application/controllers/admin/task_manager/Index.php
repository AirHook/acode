<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

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
	 * Index Page for this controller.
	 */
	public function index()
	{
		// just a redirect
		redirect('admin/task_manager/projects', 'location');
	}

	// ----------------------------------------------------------------------

}
