<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Frontend_Controller {

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
		// load pertinent library/model/helpers
		$this->load->model('get_pages');
		$this->data['view_events'] = $this->get_pages->events();
		
		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = 'events';	// set to empty for pages
		$this->data['page_title'] = '';
		$this->data['page_text'] = '';
		$this->data['page_description'] = $this->webspace_details->site_description;
		
		// load views...
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
}
