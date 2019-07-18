<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * We shall be extending Frontend_Controller to reuse some methods
 * that are readily available. We only need to change the way thumbs
 * are presented such that we avoid too many HTTP requests that leads
 * to request time outs and 504 Bad Gateway errors (nginx)
 *
 * We are now able to show "all products" as new requirement by joe
 * 20170927. This gives us now the ability to create a proper controller
 * for all products per category
 */
class Designers extends Shop_Controller
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
	 * This controller renders designer categories thumbs page
	 * This page replaces the old $this->show_designers2();
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		
		// set data variables...
		$this->data['file'] = 'product_designers';
		$this->data['page_title'] = $this->webspace_details->name;
		$this->data['page_description'] = $this->webspace_details->site_description;
		
		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
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
		//$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);
		$assets_url = base_url('assets/metronic');
		
		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';
		
			// cubeportfolio - styles plugin library
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';
		
			// cubeportfolio - metronic customized styles
			$this->data['page_level_styles'].= '
				<link href="'.$assets_url.'/assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';
		
			// cubeportfolio - jquery plugin library
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
			';
		
		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';
		
			// hanlde home categories cubeportfolio
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/componente-frontend-portfolio-3.js" type="text/javascript"></script>
			';
	}
	
	// --------------------------------------------------------------------
	
}
