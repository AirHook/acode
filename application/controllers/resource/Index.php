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
		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');
		//$this->load->model('old/set');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username/Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// if user is here, that means he has been logged out
			// or session has expired... but just so to be sure,
			// we unset all possible sales session here too...
			/* */
			// yes, it's as simple as destroying the sessions
			unset($_SESSION['sa_items']);
			unset($_SESSION['sa_options']);

			unset($_SESSION['sa_id']);
			unset($_SESSION['sa_name']);
			unset($_SESSION['sa_email_subject']);
			unset($_SESSION['sa_email_message']);
			unset($_SESSION['sa_prev_items']);
			unset($_SESSION['sa_prev_e_prices']);
			unset($_SESSION['show_prev_e_prices']);
			unset($_SESSION['show_prev_e_prices_modal']);
			unset($_SESSION['sa_preset']);
			// */
			
			// keep access uri if any...
			if ($this->session->flashdata('access_uri'))
			$this->session->keep_flashdata('access_uri');

			// set data variables...
			$this->data['file'] = 'resource_sign_in';
			$this->data['page_title'] = 'Sales Program';
			$this->data['page_description'] = 'Sales user tools for sending sales package';

			/***********
			 * sale program theme
			 * will need to make this editable via admin
			 * temporarily this is here only because this sales theme is still independent of webspace theme
			 * need to add an options['sales_theme'] to webspace details to take care of this.
			 * meantime, we set a default sales them variable such that in the process where no
			 * options['sales_theme'] is already available, we don't need to edit as much on all
			 * controller and view files
			 *
			 */
			// current options:
			//$this->data['sales_theme'] = $this->webspace_details->options['sales_theme']; // not yet available
			$this->data['sales_theme'] = 'metronic'; // 'metronic', 'default'
			//$this->data['sales_theme'] = $this->webspace_details->options['theme'];

			// load view files
			//$this->load->view($theme.'/template', $this->data);
			$this->load->view($this->data['sales_theme'].'/resource_sign_in', $this->data);
		}
		else
		{
			// validate user
			if ( ! $this->sales_user_details->initialize(
				array(
					'admin_sales_email'=>$this->input->post('username'),
					'admin_sales_password'=>$this->input->post('password')
				)
			))
			{
				// invalid credentials
				$this->session->set_flashdata('error', 'invalid_credentials');

				// redirect user
				redirect('resource', 'location');
			}

			// if not at hub site
			if (
				$this->webspace_details->options['site_type'] !== 'hub_site'
				&& ! $this->config->item('hub_site') // backwards compatibility
			)
			{
				// check if sales user is logging in from the correct site
				if (
					$this->webspace_details->slug !== $this->sales_user_details->designer
					&& $this->config->item('site_slug') !== (
						$this->sales_user_details->designer == 'basixblacklabel'
						? 'basix-black-label'
						: $this->sales_user_details->designer
					)
				)
				{
					// de-initialize library class
					$this->sales_user_details->set_initial_state();
					$this->sales_user_details->unset_session();

					// set flash message
					$this->session->set_flashdata('error', 'incorrect_site');

					// redirect user back to login page
					redirect('resource', 'location');
				}

				// set ott (one time token)
				$token = $this->sales_user_details->set_ott();
				// set user id
				$admin_sales_id = $this->sales_user_details->admin_sales_id;

				// for development purposes only
				if (ENVIRONMENT === 'development')
				{
					// redirect to hub site
					echo 'Please change index SITESLUG to hub site of '.$this->sales_user_details->designer.'<br />';
					echo '<a href="'.rtrim($_SERVER['HTTP_REFERER'], '.html').'/validate_from/index/'.$admin_sales_id.'/'.$token.'.html">Continue</a>...';

					// de-initialize library class
					$this->sales_user_details->set_initial_state();
					$this->sales_user_details->unset_session();

					exit;
				}

				// de-initialize library class
				$this->sales_user_details->set_initial_state();
				$this->sales_user_details->unset_session();

				// redirect to hub site
				header(
					'Location: '.$this->config->item('PROD_IMG_URL')
					.'resource/validate_from/index/'
					.$admin_sales_id.'/'
					.$token.'.html'
				);

				exit;
			}

			// set sessions
			$this->sales_user_details->set_session();

			// set the session lapse time if it has not been set
			if ( ! $this->session->userdata('admin_sales_login_time'))
			{
				$this->session->set_userdata('admin_sales_login_time', time());
			}

			// let us notify admin of login
			if (ENVIRONMENT !== 'development') $this->_notify_admin();

			// redirect users to sales program
			redirect('sales/dashboard');
		}
	}

	// ----------------------------------------------------------------------

	private function _notify_admin()
	{
		// notify admin
		$this->load->library('email');

		$message = "
			".$this->sales_user_details->email."<br />
			Access Level - ".$this->sales_user_details->access_level."<br />
			<br /><br />
			Just logged in - ".@date('Y-m-d H:i:sa', @time()).".<br />
		";

		$subject = 'Sales User Logged In';

		$this->email->from($this->webspace_details->info_email);
		$this->email->to($this->webspace_details->info_email);
		$this->email->cc('help@instylenewyork.com');
		$this->email->bcc($this->config->item('dev1_email'));

		$this->email->subject($subject);
		$this->email->message($message);

		// email class has a security error
		// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
		// using the '@' sign to supress this
		// must resolve pending update of CI
		@$this->email->send();
	}

	// ----------------------------------------------------------------------

}
