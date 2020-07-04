<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Sales_user_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('users/wholesale_user_details');

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$status = '1';
				$DB->set('active_date', date('Y-m-d', time()));
				$DB->set('is_active', '1');
			break;

			case 'deac':
				$status = '0';
				$DB->set('active_date', '');
				$DB->set('is_active', '0');
			break;

			case 'su':
				$status = '2';
				$DB->set('active_date', '');
				$DB->set('is_active', '2');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			// set database query clauses
			if ($key === 0) $DB->where('user_id', $id);
			else $DB->or_where('user_id', $id);

			// get and set item details for odoo and recent items
			$this->wholesale_user_details->initialize(array('user_id'=>$id));

			// remove from recent items
			// update recent list for edited vendor users
			if ($this->input->post('bulk_action') === 'del')
			{
				$this->webspace_details->update_recent_users(
					array(
						'user_type' => 'wholesale_users',
						'user_id' => $id,
						'user_name' => $this->wholesale_user_details->store_name
					),
					'remove'
				);
			}
		}

		// note in comments
		$comments = 'Previously associated with '
			.$this->sales_user_details->designer
			.' under sales agent '
			.$this->sales_user_details->email
			.'<br />'
		;

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			// all sales user cannot delete users
			// instead, remove sales user association with user
			$DB->set('admin_sales_id', NULL);
			$DB->set('admin_sales_email', NULL);
			$DB->set('reference_designer', NULL);
			$DB->set('is_active', '0');
			$DB->set('comments', $comments);

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// update records
		$DB->update('tbluser_data_wholesale');

		// redirect user
		if ($this->agent->is_referral())
		{
			redirect($this->agent->referrer(), 'location');
		}
		else redirect('my_account/sales/users/wholesale', 'location');
	}

	// ----------------------------------------------------------------------

}
