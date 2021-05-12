<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Frontend_Controller {

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
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['file'] = 'account_signin';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;
			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// set params
			$params = array(
				'email' => $this->input->post('email'), // ws,cs,sales,vendor
				'password' => $this->input->post('password'), // ws,cs,sales,vendor
				'reference_designer' => $this->webspace_details->slug, // ws,cs,sales,vendor
			);

			// authenticate user
			$this_login = FALSE;
			$this_user_id = '';
			if ($this->webspace_details->options['site_type'] !== 'hub_site')
			{
				// check wholesale user
				if (
					$this->wholesale_user_details->initialize(array(
						'email' => $params['email'],
						'pword' => $params['password'],
						'reference_designer' => $params['reference_designer']
					))
				)
				{
					$this_login = 'ws';
					$this_user_id = $this->wholesale_user_details->user_id;
				}

				// check consumer user
				if (
					$this->consumer_user_details->initialize(array(
						'email' => $params['email'],
						'password' => $params['password'],
						'reference_designer' => $params['reference_designer']
					))
				)
				{
					$this_login = 'cs';
					$this_user_id = $this->consumer_user_details->user_id;
				}

				// check sales user
				if (
					$this->sales_user_details->initialize(array(
						'admin_sales_email' => $params['email'],
						'admin_sales_password' => $params['password'],
						'admin_sales_designer' => $params['reference_designer']
					))
				)
				{
					$this_login = 'sales';
					$this_user_id = $this->sales_user_details->admin_sales_id;
				}

				// check vendor user
				if (
					$this->vendor_user_details->initialize(array(
						'vendor_email' => $params['email'],
						'password' => $params['password'],
						'reference_designer' => $params['reference_designer']
					))
				)
				{
					$this_login = 'vendor';
					$this_user_id = $this->vendor_user_details->vendor_id;
				}
			}
			else
			{
				// check wholesale user
				if (
					$this->wholesale_user_details->initialize(array(
						'email' => $params['email'],
						'pword' => $params['password']
					))
				)
				{
					$this_login = 'ws';
					$this_user_id = $this->wholesale_user_details->user_id;
				}

				// check consumer user
				if (
					$this->consumer_user_details->initialize(array(
						'email' => $params['email'],
						'password' => $params['password']
					))
				)
				{
					$this_login = 'cs';
					$this_user_id = $this->consumer_user_details->user_id;
				}

				// check sales user
				if (
					$this->sales_user_details->initialize(array(
						'admin_sales_email' => $params['email'],
						'admin_sales_password' => $params['password']
					))
				)
				{
					$this_login = 'sales';
					$this_user_id = $this->sales_user_details->admin_sales_id;
				}

				// check vendor user
				if (
					$this->vendor_user_details->initialize(array(
						'vendor_email' => $params['email'],
						'password' => $params['password']
					))
				)
				{
					$this_login = 'vendor';
					$this_user_id = $this->vendor_user_details->vendor_id;
				}
			}

			// if login is invalid on any user
			if ($this_login === FALSE)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'invalid_credentials');

				// rediect back to sign in page
				redirect('account', 'location');
			}

			// user is now authenticated

			// if user is inactive or suspended...
			if (
				$this->wholesale_user_details->status === '2'
				OR $this->wholesale_user_details->status === '0'
				OR $this->consumer_user_details->status === '0'
				OR $this->sales_user_details->status === '0'
				OR $this->vendor_user_details->status === '0'
			)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'status_inactive');

				// send to request for activation page
				redirect('account/request/activation', 'location');
			}

			// authenticate and set sessions
			redirect(site_url('account/authenticate').'?param='.$this_login.'&uid='.$this_user_id, 'location');
			/* *
			// NOTE:
			// we need to redirect user first before setting sessions
			// send user to hub if not already at hub
			if (
				$this->webspace_details->options['site_type'] == 'hub_site'
				OR $this->webspace_details->slug == 'tempoparis'
			)
			{
				redirect(site_url('account/authenticate').'?param='.$this_login.'&uid='.$this_user_id, 'location');
			}
			else
			{
				redirect('https://www.'.$this->webspace_details->parent_site().'/account/authenticate.html?param='.$this_login.'&uid='.$this_user_id, 'location');
			}
			// */
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

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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

			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select2
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'/assets/custom/js/metronic/pages/scripts/components-select2.js" type="text/javascript"></script>
			';
	}
	// ----------------------------------------------------------------------
}
