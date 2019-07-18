<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
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
		
		// load pertinent library/model/helpers
		$this->load->helper('state_country');
		$this->load->library('accounts/accounts_list');
		$this->load->library('webspaces/webspace_details');
		$this->load->library('form_validation');
		
		// initialize certain properties
		$this->webspace_details->initialize(array('webspace_slug'=>SITESLUG));
	
		// set validation rules
		$this->form_validation->set_rules('domain_name', 'Domain Name', 'trim|required');
		$this->form_validation->set_rules('webspace_name', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('webspace_slug', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('info_email', 'Info Email', 'trim|required|callback_validate_email');
		
		$this->form_validation->set_rules('address1', 'Status', 'trim|required');
		$this->form_validation->set_rules('city', 'Domain Name', 'trim|required');
		$this->form_validation->set_rules('state', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('country', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('zip', 'Status', 'trim|required');
		$this->form_validation->set_rules('phone', 'Domain Name', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			// drop down selections for account owner of site
			$this->data['accounts_list'] = $this->accounts_list->select();
			
			// set data variables...
			$this->data['file'] = 'settings_general';
			$this->data['page_title'] = 'General Settings';
			$this->data['page_description'] = 'General information of the webspace';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// update record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process some variables
			//if ($post_ary['password'] == '') unset($post_ary['password']);
			// unset unneeded variables
			unset($post_ary['owner_name']);
			unset($post_ary['owner_email']);
			unset($post_ary['options']);
			unset($post_ary['address1']);
			unset($post_ary['address2']);
			unset($post_ary['city']);
			unset($post_ary['state']);
			unset($post_ary['country']);
			unset($post_ary['zip']);
			unset($post_ary['phone']);
			
			//echo '<pre>';
			//print_r($post_ary);
			//die();
			
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$DB->where('webspace_id', $this->webspace_details->id);
			$query = $DB->update('webspaces', $post_ary);
			
			// update record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process some variables
			//if ($post_ary['password'] == '') unset($post_ary['password']);
			// unset unneeded variables
			unset($post_ary['webspace_name']);
			unset($post_ary['domain_name']);
			unset($post_ary['webspace_slug']);
			unset($post_ary['info_email']);
			
			$DB->where('account_id', $this->webspace_details->account_id);
			$query = $DB->update('accounts', $post_ary);
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			redirect($this->config->slash_item('admin_folder').'settings/general', 'location');
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-settings_general.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}