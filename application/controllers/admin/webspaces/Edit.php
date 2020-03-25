<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

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
		$this->load->helper('state_country');
		$this->load->library('accounts/accounts_list');
		$this->load->library('webspaces/webspace_details', '', 'edit_webspace_details');
		$this->load->library('webspaces/webspaces_list');  // used for the dropdown switch buttons
		$this->load->library('designers/designers_list');  // used for the hub site primary designer drop down selection
		$this->load->library('form_validation');

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Edit Sales Package
	 *
	 * Edit selected sales pacakge or newly created sales package
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces');
		}

		// initialize certain properties
		$this->edit_webspace_details->initialize(array('webspace_id'=>$id));

		// drop down selections for account owner of site
		$this->data['accounts_list'] = $this->accounts_list->select();

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// set validation rules
		$this->form_validation->set_rules('webspace_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('domain_name', 'Domain Name', 'trim|required');
		$this->form_validation->set_rules('webspace_name', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('webspace_slug', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('info_email', 'Info Email', 'trim|required|callback_validate_email');

		if ($this->form_validation->run() == FALSE)
		{
			// get some data
			// this list is used for the hub site options when site type is set to satellite site
			$this->data['webspaces'] = $this->webspaces_list->select();
			$this->data['designers'] = $this->designers_list->select();
			$this->data['hub_sites'] = $this->webspaces_list->select(array('webspaces.webspace_options LIKE'=>'%hub_site%'));

			// set data variables...
			$this->data['file'] = 'webspaces_edit';
			$this->data['page_title'] = 'Webspace Edit';
			$this->data['page_description'] = 'Edit Webspace Details';

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
			// grab the options record and update it
			$options = $this->edit_webspace_details->options;
			foreach ($post_ary['options'] as $key => $val)
			{
				// add or update value if present
				// unset empty items
				if ($val !== '') $options[$key] = $val;
				else unset($options[$key]);
			}
			$post_ary['webspace_options'] = json_encode($options);
			// unset unneeded variables
			unset($post_ary['owner_name']);
			unset($post_ary['owner_email']);
			unset($post_ary['options']);
			unset($post_ary['options']);

			//echo '<pre>';
			//print_r($post_ary);
			//die();

			// update record
			$this->DB->where('webspace_id', $id);
			$query = $this->DB->update('webspaces', $post_ary);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Admin - enabled edit site type
	 *
	 * @return	void
	 */
	public function admin($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces');
		}

		// initialize certain properties
		$this->edit_webspace_details->initialize(array('webspace_id'=>$id));

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// set validation rules
		$this->form_validation->set_rules('webspace_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('domain_name', 'Domain Name', 'trim|required');
		$this->form_validation->set_rules('webspace_name', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('webspace_slug', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('info_email', 'Info Email', 'trim|required|callback_validate_email');

		if ($this->form_validation->run() == FALSE)
		{
			// get some data
			// this list is used for the hub site options when site type is set to satellite site
			$this->data['webspaces'] = $this->webspaces_list->select();
			$this->data['designers'] = $this->designers_list->select();
			$this->data['hub_sites'] = $this->webspaces_list->select(array('webspaces.webspace_options LIKE'=>'%hub_site%'));

			// set data variables...
			$this->data['file'] = 'webspaces_edit';
			$this->data['page_title'] = 'Webspace Edit';
			$this->data['page_description'] = 'Edit Webspace Details';
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
			// grab the options record and update it
			$options = $this->edit_webspace_details->options;
			foreach ($post_ary['options'] as $key => $val)
			{
				// add or update value if present
				// unset empty items
				if ($val !== '') $options[$key] = $val;
				else unset($options[$key]);
			}
			$post_ary['webspace_options'] = json_encode($options);
			// unset unneeded variables
			unset($post_ary['owner_name']);
			unset($post_ary['owner_email']);
			unset($post_ary['options']);
			unset($post_ary['options']);

			//echo '<pre>';
			//print_r($post_ary);
			//die();

			// update record
			$this->DB->where('webspace_id', $id);
			$query = $this->DB->update('webspaces', $post_ary);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			redirect($this->config->slash_item('admin_folder').'webspaces/edit/admin/'.$id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Admin - enabled edit site type
	 *
	 * @return	void
	 */
	public function theme_activate($id = '', $theme = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces');
		}

		// initialize certain properties
		$this->edit_webspace_details->initialize(array('webspace_id'=>$id));

		// set theme option
		$this->edit_webspace_details->options['theme'] = $theme;
		$post_ary['webspace_options'] = json_encode($this->edit_webspace_details->options);

		// update record
		$this->DB->where('webspace_id', $id);
		$query = $this->DB->update('webspaces', $post_ary);

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$id, 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-webspaces_edit.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
