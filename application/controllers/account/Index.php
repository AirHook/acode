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

			// let us set sessions
			// and set the session lapse time if it has not been set
			// and redirect user
			$sestime = @time();
			if ($this_login == 'ws')
			{
				$this->wholesale_user_details->set_session();

				if ( ! $this->session->userdata('ws_login_time'))
				{
					$this->session->set_userdata('ws_login_time', $sestime);
				}

				// record login which starts the login session
				$this->wholesale_user_details->record_login_detail();

				if (ENVIRONMENT !== 'development')
				{
					// notify sales user
					$this->wholesale_user_details->notify_sales_user_online();

					// notify admin
					$this->wholesale_user_details->notify_admin_user_online();

					// get the ws user options property
					$options = $this->wholesale_user_details->options;

					if ( ! isset($options['intro']))
					{
						// since it is the user's first time to click an activation email
						// send the 2nd email introducing JT as main contact person
						// using wholesale_user_details class
						$this->wholesale_user_details->send_intro_email();

						// set the [intro] = '1' true option indicating user now got intro letter
						$this->wholesale_user_details->intro_sent_one(
							$this->wholesale_user_details->user_id,
							$this->wholesale_user_details->options
						);

						// reload options
						$options = $this->wholesale_user_details->options;
					}
				}

				// send user to hub if not already at hub
				// send to subcat icons page of the respective designer
				// users wil now stay at respective sat and sal sites
				// at MY ACCOUNTS page
				if (
					$this->webspace_details->options['site_type'] == 'hub_site'
					OR $this->webspace_details->slug == 'tempoparis'
				)
				{
					// send user to respective page...
					// send wholesale user to reference designer categories or general womens_apparel
					$ref_designer = $this->wholesale_user_details->reference_designer;
					if ($ref_designer && $ref_designer != 'shop7thavenue')
					{
						redirect('shop/designers/'.$ref_designer, 'location');
					}
					else redirect('shop/designers', 'location');
				}
				else
				{
					// default designer subcat icons page at hub site
					//redirect('https://www.'.$this->webspace_details->parent_site().'/shop/designers/'.$this->webspace_details->slug.'.html', 'location');
					redirect('shop/designers/'.$this->wholesale_user_details->reference_designer, 'location');
					//redirect('my_account/wholesale/dashboard', 'location');
				}
			}
			else if ($this_login == 'cs')
			{
				$this->consumer_user_details->set_session();

				if ( ! $this->session->userdata('cs_login_time'))
				{
					$this->session->set_userdata('cs_login_time', $sestime);
				}
			}
			else if ($this_login == 'sales')
			{
				$this->sales_user_details->set_session();

				if ( ! $this->session->userdata('admin_sales_login_time'))
				{
					$this->session->set_userdata('admin_sales_login_time', $sestime);
				}

				redirect('my_account/sales/dashboard', 'location');
			}
			else if ($this_login == 'vendor')
			{
				$this->vendor_user_details->set_session();

				if ( ! $this->session->userdata('vendor_login_time'))
				{
					$this->session->set_userdata('vendor_login_time', $sestime);
				}

				redirect('my_account/vendors/dashboard', 'location');
			}
			else
			{
				$this->wholesale_user_details->unset_session();
				$this->consumer_user_details->unset_session();
				//$this->sales_user_details->unset_session();
				$this->vendor_user_details->unset_session();
			}

			// default process assumes user is a consumer
			if ($this->webspace_details->slug != 'tempoparis')
			{
				// let's send user to reference designer categories or general womens_apparel
				$ref_designer = $this->consumer_user_details->reference_designer;
				if ($ref_designer && $ref_designer!='shop7thavenue')
					redirect('shop/designers/'.$ref_designer);
				else redirect('shop/designers');
			}

			// set flash notice
			$this->session->set_flashdata('error', 'no_id_passed');

			// rediect back to sign in page
			redirect('account', 'location');
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
