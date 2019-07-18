<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordering extends Frontend_Controller {

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
		if (isset($_SESSION['user_cat']) && $_SESSION['user_cat'] == 'wholesale')
		{
			$page_details = $this->get_pages->page_details('wholesale_ordering');
		}
		else
		{
			$page_details = $this->get_pages->page_details('ordering');
		}
		
		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = '';	// set to empty for pages
		$this->data['page_title'] = $page_details->title;
		$this->data['page_text'] = $page_details->text;
		$this->data['page_description'] = $this->webspace_details->site_description;
		
		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
}
