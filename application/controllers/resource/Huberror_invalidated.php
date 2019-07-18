<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Huberror_invalidated extends Frontend_Controller {

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
	 *
	 * @return	void
	 */
	public function index()
	{
		/**********
		 * This handles any error in login when at hub site already.
		 */
		// invalid credentials
		$this->session->set_flashdata('error', 'no_id_passed');
		
		// redirect user
		redirect('resource', 'location');
	}
	
	// ----------------------------------------------------------------------
	
}