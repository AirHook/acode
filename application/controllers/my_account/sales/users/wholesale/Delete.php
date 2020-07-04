<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Sales_user_Controller {

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
	 * Index - Delete Account
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		/**
		Internally, when sales user deletes an associated wholesale user,
		the system does not delete the user, but, instead, nullifies
		the associated sales user as well as the reference designers
		 */

		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/users/wholesale', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get and set item details for odoo and recent items
		$this->wholesale_user_details->initialize(array('user_id'=>$id));

		// remove from sidebar recent items
		// update recent list for edited vendor users
		$this->webspace_details->update_recent_users(
			array(
				'user_type' => 'wholesale_users',
				'user_id' => $id,
				'user_name' => $this->wholesale_user_details->store_name
			),
			'remove'
		);

		// note in comments
		$comments = 'Previously associated with '
			.$this->wholesale_user_details->designer
			.' under sales agent '
			.$this->wholesale_user_details->admin_sales_email
			.'<br />'
		;

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// all sales user cannot delete users
		// instead, remove sales user association with user
		$DB->set('admin_sales_id', NULL);
		$DB->set('admin_sales_email', NULL);
		$DB->set('reference_designer', NULL);
		$DB->set('is_active', '0');
		$DB->set('comments', $comments);
		$DB->where('user_id', $id);
		$DB->update('tbluser_data_wholesale');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('my_account/sales/users/wholesale', 'location');
	}

	// ----------------------------------------------------------------------

}
