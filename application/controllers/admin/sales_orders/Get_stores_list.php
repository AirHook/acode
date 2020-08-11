<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_stores_list extends MY_Controller {

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
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/admin_user_details');

		// get admin login details
		if ($this->session->admin_loggedin)
		{
			$this->admin_user_details->initialize(
				array(
					'admin_id' => $this->session->admin_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		// get the list
		// super admin lists all ws users
		// but we need to filter this on a per site type
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			$stores = $this->wholesale_users_list->select();
		}
		else
		{
			$stores = $this->wholesale_users_list->select(
				array(
					'tbluser_data_wholesale.reference_designer' => $this->webspace_details->slug
				)
			);
		}

		$html = '';
		if ($stores)
		{
			foreach ($stores as $user)
			{
				$checked =
					$this->session->admin_so_user_id == $user->user_id
					? 'checked="checked"'
					: ''
				;

				$html.=
					'<label class="mt-checkbox mt-checkbox-outline">'
					.ucwords($user->store_name)
					.'<br />'
					.ucwords(strtolower($user->firstname.' '.$user->lastname))
					.' <cite class="small">('
					.$user->email
					.')</cite> '
					.'<input type="checkbox" class="send_to_current_user list" name="email[]" value="'
					.$user->user_id
					.'" data-error-container="email_array_error" '
					.$checked
					.'/><span></span></label>'
				;
			}
		}

		// end
		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
