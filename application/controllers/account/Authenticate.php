<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends Frontend_Controller {

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
		$param = $this->input->get('param');
		$user_id = $this->input->get('uid');

		// catch error
		if (
			! $param
			&& ! $user_id
		)
		{
			// set flash notice
			$this->session->set_flashdata('error', 'no_id_passed');

			// rediect back to sign in page
			redirect('account', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');

		// let us set sessions
		// and set the session lapse time if it has not been set
		// and redirect user
		$sestime = @time();
		if ($param == 'ws')
		{
			// initialize user
			$this->wholesale_user_details->initialize(array('user_id'=>$user_id));

			// set session
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

			// send user to respective page...
			// send wholesale user to reference designer categories
			if ($this->webspace_details->options['site_type'] == 'hub_site')
			{
				redirect('shop/designers/'.$this->wholesale_user_details->reference_designer, 'location');
			}
			else redirect(site_url(), 'location');
		}
		else if ($this_login == 'cs')
		{
			// initialize user
			$this->consumer_user_details->initialize(array('user_id'=>$user_id));

			$this->consumer_user_details->set_session();

			if ( ! $this->session->userdata('cs_login_time'))
			{
				$this->session->set_userdata('cs_login_time', $sestime);
			}

			//$this->consumer_user_details->notify_admin_user_online();

			redirect('my_account/consumer/dashboard', 'location');
		}
		else if ($this_login == 'sales')
		{
			// initialize user
			$this->sales_user_details->initialize(array('user_id'=>$user_id));

			$this->sales_user_details->set_session();

			if ( ! $this->session->userdata('admin_sales_login_time'))
			{
				$this->session->set_userdata('admin_sales_login_time', $sestime);
			}

			$this->sales_user_details->notify_admin_sales_is_online();

			redirect('my_account/sales/dashboard', 'location');
		}
		else if ($this_login == 'vendor')
		{
			// initialize user
			$this->vendor_user_details->initialize(array('user_id'=>$user_id));

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
			$this->sales_user_details->unset_session();
			$this->vendor_user_details->unset_session();
		}

		// set flash notice
		$this->session->set_flashdata('error', 'sa_diff_user_loggedin');

		// rediect back to sign in page
		redirect('account', 'location');
	}

	// ----------------------------------------------------------------------

}
