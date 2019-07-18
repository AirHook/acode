<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - Edit User
	 *
	 * Edit selected user
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
			redirect($this->config->slash_item('admin_folder').'users/vendor');
		}
		
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->helper('state_country');
		$this->load->library('designers/designers_list');
		$this->load->library('users/vendor_types_list');
		$this->load->library('users/vendor_user_details');
		$this->load->library('form_validation');
		$this->load->library('odoo');
		
		// set validation rules
		$this->form_validation->set_rules('is_active', 'Status', 'trim|required');
		$this->form_validation->set_rules('reference_designer', 'Reference Designer', 'trim|required');
		$this->form_validation->set_rules('vendor_type_id', 'Vendor Type', 'trim|required');
		
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|required');
		$this->form_validation->set_rules('vendor_email', 'Main Email', 'trim|required|callback_validate_email');
		
		$this->form_validation->set_rules('contact_1', 'Contact1', 'trim|required');
		$this->form_validation->set_rules('contact_email_1', 'Contact Email1', 'trim|required|callback_validate_email');
		if ($this->input->post('contact_email_2') !== '')
			$this->form_validation->set_rules('contact_email_2', 'Contact Email2', 'trim|callback_validate_email');
		if ($this->input->post('contact_email_3') !== '')
			$this->form_validation->set_rules('contact_email_3', 'Contact Email3', 'trim|callback_validate_email');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			// initialize properties
			if ( ! $this->vendor_user_details->initialize(array('vendor_id' => $id)))
			{
				// set flash data
				$this->session->set_flashdata('error', 'user_not_found');
				
				redirect($this->config->slash_item('admin_folder').'users/vendor');
			}
			
			// set recent items
			if ( ! $this->session->flashdata('clear_recent_vendor'))
			{
				// update recent list for admin users edited
				$this->webspace_details->update_recent_users(array(
					'user_type' => 'vendor_users',
					'user_id' => $this->vendor_user_details->vendor_id,
					'user_name' => $this->vendor_user_details->vendor_name
				));
			}
		
			// some pertinent data
			if (@$this->webspace_details->options['site_type'] != 'hub_site')
			{
				$this->data['designers'] = $this->designers_list->select(
					array(
						'designer.url_structure' => @$this->webspace_details->slug
					)
				);
			}
			else $this->data['designers'] = $this->designers_list->select();
			$this->data['vendor_types'] = $this->vendor_types_list->select();
		
			// set data variables...
			$this->data['file'] = 'users_vendor_edit';
			$this->data['page_title'] = 'Vendor User Edit';
			$this->data['page_description'] = 'Edit vendor user details';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// unset unneeded variables
			unset($post_ary['type']);
			
			// update record
			$this->DB->where('vendor_id', $id);
			$query = $this->DB->update('vendors', $post_ary);
			
			// set some items for odoo
			$post_ary['vendor_id'] = $id;
			$post_ary['designer_slug'] = $post_ary['reference_designer'];
			$post_ary['vendor_type'] = $this->input->post('type');
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			if (
				ENVIRONMENT !== 'development'
				&& $post_ary['designer_slug'] === 'basixblacklabel'
			) 
			{
				$odoo_response = $this->odoo->post_data($post_ary, 'vendors', 'edit');
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die();
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			redirect($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$id, 'location');
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
	 * Clear Recent User Edit List
	 *
	 * @return	void
	 */
	public function clear_recent()
	{
		// capture sales user options
		$options = $this->webspace_details->options;
		
		// get the array of recent users and unset it
		if (
			isset($options['recent_vendor_users'])
			&& ! empty($options['recent_vendor_users'])
		) unset($options['recent_vendor_users']);
		
		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->webspace_details->id);
		$q = $this->DB->update('webspaces');
		
		// set flash data
		$this->session->set_flashdata('clear_recent_vendor', TRUE);
		
		// reload page
		redirect($_SERVER['HTTP_REFERER'], 'location');
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Add Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_csv_file()
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		// 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, site_url('admin/users/vendors/csv/update_csv_file/csv'));
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// execute
		$response = curl_exec($ch);
		
		// for debugging purposes, check for response
		/*
		if($response === false)
		{
			//echo 'Curl error: ' . curl_error($ch);
			// set flash data
			$this->session->set_flashdata('error', 'post_data_error');
			$this->session->set_flashdata('error_value', curl_error($ch));
			
			redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
		}
		*/

		// close the connection, release resources used
		curl_close ($ch);
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
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-users_vendor_edit.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}