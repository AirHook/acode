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
			// authenticate user
			if ($this->webspace_details->options['site_type'] !== 'hub_site')
			{
				if (
					! $this->wholesale_user_details->initialize(array(
						'email' => $this->input->post('email'),
						'pword' => $this->input->post('password'),
						'reference_designer' => $this->webspace_details->slug
					))
					&& ! $this->consumer_user_details->initialize(array(
						'email' => $this->input->post('email'),
						'password' => $this->input->post('password'),
						'reference_designer' => $this->webspace_details->slug
					))
					&& ! $this->sales_user_details->initialize(array(
						'admin_sales_email' => $this->input->post('email'),
						'admin_sales_password' => $this->input->post('password')
					))
					&& ! $this->vendor_user_details->initialize(array(
						'vendor_email' => $this->input->post('email'),
						'password' => $this->input->post('password')
					))
				)
				{
					// set flash notice
					$this->session->set_flashdata('error', 'invalid_credentials');

					// rediect back to sign in page
					redirect('account');
				}
			}
			else
			{
				if (
					! $this->wholesale_user_details->initialize(array(
						'email' => $this->input->post('email'),
						'pword' => $this->input->post('password')
					))
					&& ! $this->consumer_user_details->initialize(array(
						'email' => $this->input->post('email'),
						'password' => $this->input->post('password')
					))
					&& ! $this->sales_user_details->initialize(array(
						'admin_sales_email' => $this->input->post('email'),
						'admin_sales_password' => $this->input->post('password')
					))
					&& ! $this->vendor_user_details->initialize(array(
						'vendor_email' => $this->input->post('email'),
						'password' => $this->input->post('password')
					))
				)
				{
					// set flash notice
					$this->session->set_flashdata('error', 'invalid_credentials');

					// rediect back to sign in page
					redirect('account');
				}
			}
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
				redirect('account/request/activation');
			}

			// let us set sessions
			// var_dump($this->vendor_user_details->vendor_id);
			// var_dump($this->vendor_user_details->vendor_id);
			// exit;
			$this->wholesale_user_details->set_session();
			$this->consumer_user_details->set_session();
			$this->sales_user_details->set_session();
			$this->vendor_user_details->set_session();

			// record login details and notify people
			if ($this->session->user_cat == 'wholesale')
			{
				// record login which starts the login session
				$this->wholesale_user_details->record_login_detail();

				// notify sales user
				$this->wholesale_user_details->notify_sales_user_online();

				// notify admin
				$this->wholesale_user_details->notify_admin_user_online();
			}
			
			//redirect to sales user dashboard
			if($this->session->admin_sales_loggedin == 1 && $this->session->admin_sales_id) {
				redirect('my_account/sales/dashboard');
			}
			
			//redirect to vendor user dashboard
			if($this->session->vendor_loggedin == 1 && $this->session->vendor_id) {
				redirect('my_account/vendors/dashboard');
			}
			// redirect user to account page
			// since account page is under construction,
			// let's send user to reference designer categories or general womens_apparel
			$ref_designer = $this->wholesale_user_details->reference_designer;
			if ($ref_designer && $ref_designer!='shop7thavenue')
				redirect('shop/designers/'.$ref_designer);
			else redirect('shop/designers');
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
