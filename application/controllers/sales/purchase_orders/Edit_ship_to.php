<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_ship_to extends Sales_Controller {

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
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		/***********
		 * Process Users
		 */
		if ($this->input->post('send_to') === 'new_user')
		{
			// add user to wholesale list and set user array
			$post_user = array(
				'email' => $this->input->post('email'),
				'pword' => 'instyle2019', // set default
				'store_name' => $this->input->post('store_name'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'fed_tax_id' => $this->input->post('fed_tax_id'),
				'telephone' => $this->input->post('telephone'),
				'address1' => $this->input->post('address1'),
				'address2' => $this->input->post('address2'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country'),
				'zipcode' => $this->input->post('zipcode'),
				'create_date' => date('Y-m-d', time()),
				'admin_sales_id' => $this->input->post('email'),
				'admin_sales_email' => $this->input->post('email'),
				'reference_designer' => $this->input->post('email')
			);
			$this->DB->insert('tbluser_data_wholesale', $post_user);

			$email = array($this->input->post('email'));
		}
		else
		{
			$users = $this->input->post('email');
			$email = $users['0'];
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$user_details = $this->wholesale_user_details->initialize(array('email'=>$email));

		$this->session->set_userdata('po_store_id', $user_details->user_id);

		redirect('sales/purchase_orders/create/step3', 'location');
	}

	// ----------------------------------------------------------------------

}
