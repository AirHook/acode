<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_of_use extends Frontend_Controller {

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

		// some default params
		$params['url_structure'] = 'terms_of_use';
		$params['webspace_id'] = $this->webspace_details->id;
		$params['user_tag'] = 'consumer';

		// variable params
		if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'wholesale')
		{
			$params['user_tag'] = 'wholesale';
		}

		// get page content
		if ($this->get_pages->page_details_new($params))
		{
			redirect('pages/terms_of_use', 'location');
		}

		$page_details = $this->get_pages->page_details_new(array('pagename'=>'terms_of_use.php'));

		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = '';	// set to empty for pages
		$this->data['page_title'] = $page_details->title;
		$this->data['page_text'] = @$page_details->content;
		$this->data['page_description'] = $this->webspace_details->site_description;

		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

}
