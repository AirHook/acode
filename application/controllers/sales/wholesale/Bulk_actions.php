<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Sales_Controller {

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

		//echo '<pre>';
		//print_r($this->input->post());
		//die();

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('odoo');

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$status = '1';
				$DB->set('active_date', date('Y-m-d', time()));
				$DB->set('is_active', '1');
			break;

			case 'su':
				$status = '0';
				$DB->set('active_date', '');
				$DB->set('is_active', '0');
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

			// set some items for odoo
			$post_ary['user_id'] = $id;
			$post_ary['store_name'] = $this->wholesale_user_details->store_name;
			if (@$status) $post_ary['status'] = $status;

			/***********
			 * Update ODOO
			 */

			// pass data to odoo
			// this is needed here because of the vendor_id that is needed to pass
			if (
				ENVIRONMENT !== 'development'
				&& $this->wholesale_user_details->reference_designer == 'basixblacklabel'
			)
			{
				if ($this->input->post('bulk_action') === 'del')
				{
					$odoo_response = $this->odoo->post_data($post_ary, 'wholesale_users', 'del');
				}
				else
				{
					$odoo_response = $this->odoo->post_data($post_ary, 'wholesale_users', 'edit');
				}
			}

			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die('<br />Died!');
		}

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			$DB->delete('tbluser_data_wholesale');

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('tbluser_data_wholesale');

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// redirect user
		redirect('sales/wholesale');
	}

	// ----------------------------------------------------------------------

}
