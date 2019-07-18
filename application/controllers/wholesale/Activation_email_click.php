<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Activation_email_click extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// let's process the 'this_get' item
		$get = json_decode($this->session->flashdata('this_get'), TRUE);

		/* */
		if ( ! @$get['act'] OR ! @$get['ws'])
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('account');
		}
		// */

		// set variables
		$wholesale_user_id = $get['ws'];
		$tc = $get['act'];

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		/****************
		 * Lets get the wholesale user details
		 */
		// check for logged in users and verify link user id
		if ($this->session->user_loggedin && $this->session->user_cat === 'wholesale')
		{
			if ($this->session->user_id != $wholesale_user_id)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'sa_diff_user_loggedin');

				// nothing more to do...
				redirect('account');
			}
			// logged in user and sa user id is valid, hence we already have
			// wholesale user details
		}
		else
		{
			if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$wholesale_user_id)))
			{
				// set flash notice
				$this->session->set_flashdata('error', 'invalid_credentials');

				// nothing more to do...
				redirect('account');
			}
		}

		// auto sign in user is not already signed in
		// set a boolean param for new or exisiting login
		$new_login = FALSE;
		if ( ! $this->session->this_login_id)
		{
			// auto activate user if he clicks on the sales package
			if ($this->wholesale_user_details->status != '1') $this->wholesale_user_details->activate_user();
			// set wholesale user session
			$this->wholesale_user_details->set_session();

			// new login
			$new_login = TRUE;
		}

		/****************
		 * Lets check for 1 click session
		 */
		// get the ws user options property
		$options = $this->wholesale_user_details->options;

		if ( ! isset($options['act'][$tc]))
		{
			// this only means it's the user's firt time to click the link
			// set the [act] = login_id option indicating user now clicked on the link
			$this->wholesale_user_details->act_click_one(
				$wholesale_user_id,
				$tc,
				$this->session->this_login_id,
				$this->wholesale_user_details->options
			);

			// reload options
			$options = $this->wholesale_user_details->options;
		}

		if (@$options['act'][$tc] !== $this->session->this_login_id)
		{
			if ($new_login === TRUE)
			{
				// de-initialize wholesale user and unset session
				//$this->load->library('users/wholesale_user_details');
				$this->wholesale_user_details->update_login_detail(array('logout'), 'active_time');
				$this->wholesale_user_details->set_initial_state();
			}

			// set flash notice
			$this->session->set_flashdata('error', 'click_one_error');

			// nothing more to do...
			redirect('account', 'location');
		}

		if ($new_login === TRUE)
		{
			// record login details
			$this->wholesale_user_details->record_login_detail();

			// do notifications where necessary
			// notify sales user
			$this->wholesale_user_details->notify_sales_user_online();
			// notify admin user is online
			$this->wholesale_user_details->notify_admin_user_online();
		}

		// everthing seems to be in order reaching to this point
		// let us now redirect user to respective access uri
		unset($get['act']);
		unset($get['ws']);

		$segment_ary = json_decode($this->session->flashdata('segment_array'), TRUE);
		$segment_str = implode('/', $segment_ary);
		redirect(site_url($segment_str).'?'.http_build_query($get));
	}

	// --------------------------------------------------------------------

}
