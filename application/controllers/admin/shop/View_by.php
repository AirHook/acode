<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View_by extends Frontend_Controller
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
	public function index()
	{
		if ( ! $this->uri->segment(4))
		{
			// nothing more to do...
			redirect('shop/womens_apparel');
		}
		
		// set the sort by into session
		if ($this->uri->segment(4) != '99')
		{
			$this->session->view_list_number = $this->uri->segment(4);
		}
		else unset($_SESSION['view_list_number']);
		
		// redirect user
		if ( ! $this->session->flashdata('thumbs_uri_string'))
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			redirect(site_url());
		}
		else redirect(site_url($this->session->flashdata('thumbs_uri_string')), 'location');
	}
	
	// --------------------------------------------------------------------
	
}
