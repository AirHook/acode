<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_current_user extends MY_Controller {

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

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'error';
			exit;
		}

		// set customer where clause for the search
		$custom_where = "(
			tbluser_data_wholesale.store_name LIKE '%".$this->input->post('search_string')."%'
			OR tbluser_data_wholesale.email LIKE '%".$this->input->post('search_string')."%'
		)";

		// get data
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';

		// but we need to filter this on a per site type
		if ($this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbluser_data_wholesale.reference_designer'] = $this->webspace_details->slug;
		}

		$users = $this->wholesale_users_list->select(
			$where, // where
			array( // order by
				'tbluser_data_wholesale.store_name' => 'asc'
			),
			array(), // limit
			$custom_where // custom where
		);

		$html = '';
		if ($users)
		{
			foreach ($users as $user)
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
		else
		{
			$html.=
				'<label class="mt-checkbox mt-checkbox-outline">'
				.'No records found.'
				.'</label>'
			;
		}

		// end
		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
