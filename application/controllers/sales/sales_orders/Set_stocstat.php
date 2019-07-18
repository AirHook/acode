<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_stocstat extends MY_Controller {

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
	public function index($stat = 0)
	{
		$this->session->set_userdata('so_stocstat', $stat);

		// echo the following
		echo $stat;
	}

	// ----------------------------------------------------------------------

}
