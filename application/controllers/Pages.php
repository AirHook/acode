<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Frontend_Controller {

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
	public function index($page_param)
	{
		if ($page_param == 'index')
		{
			//redirect('contact', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->model('get_pages');

		// some default params
		$params['url_structure'] = $page_param;
		$params['webspace_id'] = $this->webspace_details->id;
		$params['user_tag'] = 'consumer';

		// variable params
		if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'wholesale')
		{
			$params['user_tag'] = 'wholesale';
		}

		// get page content
		$this->data['page_details'] = $this->get_pages->page_details_new($params);

		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = '';
		$this->data['page_title'] = @$this->data['page_details']->page_name ?: $this->webspace_details->site_title;
		$this->data['page_description'] = @$this->data['page_details']->description ?: $this->webspace_details->site_description;

		// load views...
		$this->load->view('metronic/template/template', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Remapping this controller to avoid needing to use index in the url
	 *
	 * @return	void
	 */
	public function _remap($page_param = '')
	{
		$this->index($page_param);
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
		$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';


		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
