<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends Frontend_Controller {

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
		//$this->load->library('users/wholesale_details');
		
		// set data variables to pass to view file
		$this->data['file'] 						= 'wholesale_details';
		$this->data['site_title']					= @$meta_tags['title'];
		$this->data['site_keywords']				= @$meta_tags['keyword'];
		$this->data['site_description']				= @$meta_tags['description'];
		$this->data['alttags']						= @$meta_tags['alttags'];
		
		// load the view
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
}
