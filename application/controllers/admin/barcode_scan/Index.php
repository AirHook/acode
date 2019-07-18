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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($params = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// Code here...






		// redirect user
		redirect($redirect_string, 'location');
	}

	// ----------------------------------------------------------------------

}
