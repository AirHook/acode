<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('webspace_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('domain_name', 'Domain Name', 'trim|required|callback_check_domain_name');
		$this->form_validation->set_rules('webspace_name', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('webspace_slug', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('info_email', 'Info Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('account_id', 'Account', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			// get some data
			$this->load->library('accounts/accounts_list');
			$this->load->library('webspaces/webspaces_list');
			
			// initializations...
			// drop down selections for account owner of site
			$this->data['accounts_list'] = $this->accounts_list->select();
			// this list is used for the hub site options when site type is set to satellite site
			$this->data['webspaces'] = $this->webspaces_list->select(array('webspaces.webspace_options LIKE'=>'%hub_site%'));
			
			// set data variables...
			$this->data['file'] = 'webspaces_add';
			$this->data['page_title'] = 'Webspaces Add';
			$this->data['page_description'] = 'Add New Webspaces';
			
			// load views...
			$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			$post_ary['webspace_options'] = json_encode($post_ary['options']);
			//$post_ary['account_status'] = '1';
			// unset unneeded variables
			unset($post_ary['options']);
			// connect to database
			//$DB = $this->load->database('instyle', TRUE);
			$query = $this->DB->insert('webspaces', $post_ary);
			
			// set flash data
			$this->session->set_flashdata('select_theme_after_add_webspace', TRUE);
			$this->session->set_flashdata('success', 'add');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$this->DB->insert_id());
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Callback function to check on submitted domain name
	 * if it exists already or not
	 *
	 * @return	boolean
	 */
	public function check_domain_name($str)
	{
		// let's check if the domain name exists already
		$query = $this->DB->get_where('webspaces', array('domain_name'=>$str));
		if ($query->num_rows() == 1)
		{
			// domain_name exists
			$this->form_validation->set_message('check_domain_name', 'The {field} field already exists.');
			return FALSE;
		}
		
		// let's validate the domain name
		$domain = $str;
		
		// remove the http protocol
		if(stripos($domain, 'http://') === 0)
		{
			$domain = str_replace('http://', '', $domain);
		}
		
		// remove the www prefix to be able to manipulate the domain name
		if(stripos($domain, 'www.') === 0)
		{
			$domain = str_replace('www.', '', $domain);
		}
		
		// Not even a single . this will eliminate things like abcd, since http://abcd is reported valid
		if( ! substr_count($domain, '.'))
		{
			// no dot at all
			$this->form_validation->set_message('check_domain_name', 'The {field} is not a domain.');
			return false;
		}
		
		// check for TLD validity
		$valid_tlds = array('com', 'net');
		$exp = explode('.', $domain);
		$tld = $exp[count($exp) - 1];
		if ( ! in_array($tld, $valid_tlds))
		{
			// not the correct tld
			$this->form_validation->set_message('check_domain_name', 'The {field} has an invalid TLD.');
			return false;
		}
		
		$again = 'http://' . $domain;
		if ( ! filter_var($again, FILTER_VALIDATE_URL))
		{
			// invalid domain
			$this->form_validation->set_message('check_domain_name', 'The {field} is invalid');
			return false;
		}
		return TRUE;
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
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
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
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
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
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>		
			';
		
		/****************
		 * page scripts inserted at <bottom>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-webspaces_add.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}