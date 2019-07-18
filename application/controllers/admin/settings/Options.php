<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends Admin_Controller {

	/**
	 * database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// load pertinent library/model/helpers
		$this->load->library('webspaces/webspaces_list');  	// used on hub site drop down
		$this->load->library('designers/designers_list');	// used for the hub site primary designer drop down selection
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		if ( ! $this->input->post())
		{
			// get some data
			$this->data['designers'] = $this->designers_list->select();
			$this->data['hub_sites'] = $this->webspaces_list->select(array('webspaces.webspace_options LIKE'=>'%hub_site%'));
			
			// set data variables...
			$this->data['file'] = 'settings_options';
			$this->data['page_title'] = 'Option Settings';
			$this->data['page_description'] = 'For '.$this->webspace_details->name;
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process some variables
			// grab the options record
			$options = $this->webspace_details->options;
			foreach ($post_ary['options'] as $key => $val)
			{
				// add or update value if present
				// unset empty items
				if ($val !== '') $options[$key] = $val;
				else unset($options[$key]);
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//die();
			
			// update record
			$this->DB->set('webspace_options', json_encode($options));
			$this->DB->where('webspace_id', $this->webspace_details->id);
			$query = $this->DB->update('webspaces');
			
			// re-initialize certain properties
			$this->webspace_details->initialize(array('webspace_slug'=>SITESLUG));
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			redirect($this->config->slash_item('admin_folder').'settings/options', 'location');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Admin - enabled edit site type
	 *
	 * Super admin facilities
	 *
	 * @return	void
	 */
	public function admin()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		if ( ! $this->input->post())
		{
			// get some data
			$this->data['designers'] = $this->designers_list->select();
			$this->data['hub_sites'] = $this->webspaces_list->select(array('webspaces.webspace_options LIKE'=>'%hub_site%'));
			
			// set data variables...
			$this->data['file'] = 'settings_options';
			$this->data['page_title'] = 'Option Settings';
			$this->data['page_description'] = 'For '.$this->webspace_details->name;
			$this->data['admin'] = 'admin';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process some variables
			// grab the options record
			$options = $this->webspace_details->options;
			foreach ($post_ary['options'] as $key => $val)
			{
				// add or update value if present
				// unset empty items
				if ($val !== '') $options[$key] = $val;
				else unset($options[$key]);
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//die();
			
			// update record
			$this->DB->set('webspace_options', json_encode($options));
			$this->DB->where('webspace_id', $this->webspace_details->id);
			$query = $this->DB->update('webspaces');
			
			// re-initialize certain properties
			$this->webspace_details->initialize(array('webspace_slug'=>SITESLUG));
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			redirect($this->config->slash_item('admin_folder').'settings/options/admin', 'location');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
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
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
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
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>		
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
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-settings_options.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}