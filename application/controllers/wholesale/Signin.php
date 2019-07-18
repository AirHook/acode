<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends Frontend_Controller {

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
		// wholesale sigin is now moved to acounts LOGIN
		redirect('account', 'location');

		// below is the old wholesale signin system

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');

		// set data variables...
		$this->data['file'] = 'wholesale_signin';
		$this->data['page_title'] = $this->webspace_details->name;
		$this->data['page_description'] = $this->webspace_details->site_description;

		// load views...
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific
	 * styles and scripts for each page as per selected theme
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		/****************
		 * page scripts for DEFAULT theme
		 */
		$this->data['jscript'] = '';

			// some old scripts for the pages
			//$this->data['jscript'].= '<script type="text/javascript" src="'.base_url().'assets/js/jstools.js"></script>';
			// added autocomplete.js for search queries
			//$this->data['jscript'].= $this->set->autocomplete();
			//$this->data['jscript'].= $this->set->fade_thumbs_js(); //--> commenting to turn of thumb fadehover effect due to loading issues
			// add ui scripts and some jquery dailog script
			/*
			$this->data['jscript'].= '
				<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
				<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.3.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
			';
			*/
	}

	// ----------------------------------------------------------------------

}
