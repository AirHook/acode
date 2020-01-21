<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_package extends Sales_user_Controller {

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
	 * Index - Send Activation Email
	 *
	 * @return	void
	 */
	public function index($user_id = '')
	{
		echo 'Processing...<br />';

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('sales_package/sales_package_sending');
		$this->load->library('sales_package/update_sales_package');

		// get user details given $user_id
		$this->wholesale_user_details->initialize(array('user_id' => $user_id));

		// if user reference designer is not hub site
		if (
			$this->wholesale_user_details->reference_designer != 'instylenewyork'
			&& $this->wholesale_user_details->reference_designer != 'shop7thavenue'
		)
		{
			// to ensure that correct designer products are sent,
			// we update the DESIGNER RECENT ITEMS sales package given user reference_designer info
			if ( ! $this->update_sales_package->update_designer_recent_items($this->wholesale_user_details->des_id))
			{
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				if ($this->session->flashdata('uri_referrer'))
				{
					redirect($this->session->flashdata('uri_referrer'), 'location');
				}
				else redirect('my_account/sales/users/wholesale', 'location');
			}

			// initialize sales package
			$this->sales_package_details->initialize(array('sales_package_id'=>'2'));
		}
		else
		{
			// initialize sales package
			$this->sales_package_details->initialize(array('sales_package_id'=>'1'));
		}

		// check if the sales package has contents, otherwise, send user
		// back to wholesale list with notification
		if (empty($this->sales_package_details->items))
		{
			// set flash data
			$this->session->set_flashdata('error', 'recent_item_needs_updating');

			// redirect user
			if ($this->session->flashdata('uri_referrer'))
			{
				redirect($this->session->flashdata('uri_referrer'), 'location');
			}
			else redirect('my_account/sales/users/wholesale', 'location');
		}

		// send the sales package
		$this->sales_package_sending->initialize(
			array(
				'sales_package_id' => $this->sales_package_details->sales_package_id,
				'users' => array($this->wholesale_user_details->email)
			)
		);

		if ( ! $this->sales_package_sending->send())
		{
			$this->session->set_flashdata('error', 'error_sending_package');

			if ($this->session->flashdata('uri_referrer'))
			{
				redirect($this->session->flashdata('uri_referrer'), 'location');
			}
			else redirect('my_account/sales/users/wholesale', 'location');
		}

		// set flash data
		$this->session->set_flashdata('success', 'pacakge_sent');

		// redirect user
		if ($this->session->flashdata('uri_referrer'))
		{
			redirect($this->session->flashdata('uri_referrer'), 'location');
		}
		else redirect('my_account/sales/users/wholesale', 'location');
	}

	// ----------------------------------------------------------------------

}
