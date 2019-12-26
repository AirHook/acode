<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Consumer_user_Controller {
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
	 * This method simply shows user profile
	 *
	 * @return	void
	 */
	public function index()
	{
		$id = $this->session->userdata['user_id'];
		
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->helper('state_country');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list');
		$this->load->library('form_validation');
		$this->load->library('odoo');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state_province', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('zip_postcode', 'Zip Code', 'trim|required');
		
		$this->form_validation->set_rules('password', 'Password', 'trim');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|matches[password]');
		
		if ($this->form_validation->run() == FALSE)
		{
			// initialize properties
			if ( ! $this->consumer_user_details->initialize(array('user_id' => $id)))
			{
				// set flash data
				$this->session->set_flashdata('error', 'user_not_found');
				
				redirect('my_account/consumer/profile');
			}
			
			if ( ! $this->session->flashdata('clear_recent_consumer'))
			{
				// update recent list for admin users edited
				$this->webspace_details->update_recent_users(array(
					'user_type' => 'consumer_users',
					'user_id' => $this->consumer_user_details->user_id,
					'user_name' => $this->consumer_user_details->fname.' '.$this->consumer_user_details->lname
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
				$this->data['sales'] = $this->sales_users_list->select(
					array(
						'tbladmin_sales.admin_sales_designer' => @$this->webspace_details->slug
					)
				);
			}
			else 
			{
				$this->data['designers'] = $this->designers_list->select();
				$this->data['sales'] = $this->sales_users_list->select();
			}
		
			// set data variables...
			$this->data['role'] = 'consumer'; //userrole will be used for IF statements in template files
			$this->data['file'] = '../my_account/profile_consumer';
			$this->data['page_title'] = 'Consumer User Edit';
			$this->data['page_description'] = 'Edit Consumer User Details';
			
			// load views...
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// print_r($post_ary);exit;
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process/add some variables
			if ($post_ary['password'] == '') unset($post_ary['password']);
			// unset unneeded variables
			unset($post_ary['passconf']);
			
			// update record
			$this->DB = $this->load->database('instyle', TRUE);
			$this->DB->where('user_id', $id);
			$query = $this->DB->update('tbluser_data', $post_ary);
			
			// set some items for odoo
			$post_ary['user_id'] = $id;
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			if (
				ENVIRONMENT !== 'development'
				&& @$post_ary['reference_designer'] === 'basixblacklabel'
			) 
			{
				$odoo_response = $this->odoo->post_data($post_ary, 'consumer_users', 'edit');
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die();
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			redirect('my_account/consumer/profile', 'location');
		}
	}
	public function index_()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->helper('state_country');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('form_validation');
	
		
		$this->form_validation->set_rules('address1', 'Status', 'trim|required');
		$this->form_validation->set_rules('city', 'Domain Name', 'trim|required');
		$this->form_validation->set_rules('state', 'Webspace Name', 'trim|required');
		$this->form_validation->set_rules('country', 'Webspace Slug', 'trim|required');
		$this->form_validation->set_rules('zip', 'Status', 'trim|required');
		$this->form_validation->set_rules('phone', 'Domain Name', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$account_list = $this->wholesale_users_list->select(
				array(
					'user_id' => $this->session->userdata['user_id']
				)
			);
			$this->data['profiledata'] = $account_list[0];
			
			// set data variables...
			$this->data['role'] = 'consumer'; //userrole will be used for IF statements in template files
			$this->data['file'] = '../my_account/profile_consumer'; // profile page
			$this->data['page_title'] = 'My Info';
			$this->data['page_description'] = 'General information of user';
			
			// load views...
			$this->load->view('metronic/template/template', $this->data);
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
			
			$this->load->view('metronic/template/template', $this->data);
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

			// dashboard counter up boxes
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
		        <script src="'.$assets_url.'/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle dashboard
			// $this->data['page_level_scripts'].= '
				// <script src="'.$assets_url.'/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
			// ';
	}
	// ----------------------------------------------------------------------
}