<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Press extends Frontend_Controller {

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
		$page_details = $this->get_pages->details('press.php');
		$this->data['presses'] = $this->get_pages->press();
		
		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = 'press';
		$this->data['page_title'] = $page_details->title;
		$this->data['page_text'] = $page_details->description;
		$this->data['page_description'] = $this->webspace_details->site_description;
		
		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
}
