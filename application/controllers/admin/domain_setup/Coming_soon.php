<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coming_soon extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		if (@$this->webspace_details->options['theme']) redirect(site_url());
	}
	
	// ----------------------------------------------------------------------
	
	public function index()
	{
		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'coming_soon');
	}
	
	// ----------------------------------------------------------------------
	
}
