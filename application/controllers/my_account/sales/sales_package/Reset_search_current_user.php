<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_search_current_user extends MY_Controller {

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

		// get data
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';
		$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		$where['tbluser_data_wholesale.reference_designer'] = $this->sales_user_details->designer;
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
