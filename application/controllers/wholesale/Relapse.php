<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relapse extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';
		
		// reset ws last active time to now
		$_SESSION['ws_last_active_time'] = time();
		
		// redirect to access uri
		if ($this->session->access_uri) redirect($this->session->access_uri, 'location');
		else redirect(site_url(), 'location');
	}
	
	// ----------------------------------------------------------------------
	
}
