<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sort_by extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * Sort By Function
	 *
	 * return void
	 */
	function index()
	{
		// set the sort by into session
		if ($this->input->post('sort_by') !== 'default')
		{
			$this->session->set_userdata('sort_by', $this->input->post('sort_by'));
		}
		else unset($_SESSION['sort_by']);
		
		// redirect user
		redirect($this->input->post('uri_string'));
	}
	
	// --------------------------------------------------------------------
	
}
