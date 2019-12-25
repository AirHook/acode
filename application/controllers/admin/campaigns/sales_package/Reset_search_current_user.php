<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_search_current_user extends Admin_Controller {

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

		// get data
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';
		if ($this->session->admin_sales_loggedin)
		{
			$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		}
		$users = $this->wholesale_users_list->select(
			$where, // where
			array( // order by
				'tbluser_data_wholesale.store_name' => 'asc'
			),
			array($this->input->post('reset')) // limit
		);

		$html = '';
		foreach ($users as $user)
		{
			$html.=
				'<label class="mt-checkbox mt-checkbox-outline" style="font-size:0.8em;">'
				.ucwords($user->store_name)
				.' - '
				.ucwords(strtolower($user->firstname.' '.$user->lastname))
				.' <cite class="small">('
				.$user->email
				.')</cite> '
				.'<input type="checkbox" class="send_to_current_user list" name="" value="'
				.$user->email
				.'" data-error-container="email_array_error" data-store_name="'
				.$user->store_name
				.'" data-firstname="'
				.$user->firstname
				.'" data-lastname="'
				.$user->lastname
				.'" /><span></span></label>'
			;
		}

		// end
		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
