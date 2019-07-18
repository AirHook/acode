<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

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
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/***********
		 * Roden old template index page requires access to db due to
		 * sliders/graphics accessed on homepage options for the template
		 * We put the DB object in a variable.
		 *
		 * We will need to remove DB accesses on view files
		 *
		 * For the time being, while update to theme options are ongoing,
		 * we will revert to categories page as home page
		 */
		// connect to db for roden2
		$this->data['db'] = $this->load->database('instyle', TRUE);
		
			/**********
			 * Adding this db query for the home page options
			 *
			if ($this->config->item('template') == 'roden')
			{
				$q_options = $this->data['db']->get_where('homepage_options',array('domain_slug'=>$this->config->item('site_slug'), 'template'=>$this->config->item('template')))->row_array();
				
				$this->data['homepage_options'] = @$q_options['options'] != '' ? json_decode($q_options['options'], TRUE) : array();
			}
		/***************/
		
		/**********
		 * Right now, we are defaulting the home page to the categories
		 * page and we will deal with coding the home page options for
		 * roden template later on...
		 */
		redirect('shop/categories');
		
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('categories/categories');
		$this->load->library('designers/designers_list');
		
		// get data
		// used for header designer logo slider and others
		$this->data['designers'] = $this->designers_list->select();
		// used for main menu and others
		$this->data['categories'] = $this->categories->treelist(array('d_url_structure'=>(@$this->sales_user_details->designer == 'basixblacklabel' ? 'basix-black-label' : @$this->sales_user_details->designer),'with_products'=>TRUE));
		
		// set data variables...
		$this->data['file'] = 'index';
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
		
			if (@$this->webspace_details->options['theme'] == 'roden2______')
			{
				// home image boxes for roden2 theme
				$this->data['page_level_styles_plugins'].= '
					<script src="'.$assets_url.'/css/home_image_boxes_styles.css" type="text/javascript"></script>
				';
			}
		
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
