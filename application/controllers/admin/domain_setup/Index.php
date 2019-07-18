<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// lets check for status of webspace and account
		$this->load->library('webspaces/webspace_details');
		if ($this->webspace_details->initialize(array('domain_name'=>DOMAINNAME)))
		{
			// run domain set wizard
			redirect($this->config->slash_item('admin_folder').'login');
		}
	}
	
	// ----------------------------------------------------------------------
	
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load libraries
		$this->load->helper('state_country');
		
		// set data variables...
		$this->data['file'] = 'domain_setup';
		$this->data['page_title'] = 'Domain Setup Wizard';
		$this->data['page_description'] = '';
		
		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');
		
		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
			';
			
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
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
			';
			// jquery validation, bootstrap wizard, and additional methods
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
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
			// form wizard
			$this->data['page_level_scripts'].= '
				<script src="'.base_url('assets/custom').'/js/metronic/form-wizard.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}
