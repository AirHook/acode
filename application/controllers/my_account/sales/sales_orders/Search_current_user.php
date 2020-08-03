<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_current_user extends Sales_user_Controller {

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
		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'error';
			exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');

		// set customer where clause for the search
		$custom_where = "(
			tbluser_data_wholesale.store_name LIKE '%".$this->input->post('search_string')."%'
			OR tbluser_data_wholesale.email LIKE '%".$this->input->post('search_string')."%'
		)";

		// get data
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';

		// filter for respective logged in sales user
		$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;

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
