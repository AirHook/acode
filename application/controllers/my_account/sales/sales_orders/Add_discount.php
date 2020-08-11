<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_discount extends MY_Controller {

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
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');

		// get sales user login details
		if ($this->session->admin_sales_loggedin)
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->session->admin_sales_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		if ( ! $this->input->post('prod_no'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variables
		$discount = $this->input->post('discount');
		$item = $this->input->post('prod_no');
		$size_label = $this->input->post('size_label');
		$page = $this->input->post('page');

		// set the items array
		$items_array =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

		// process and add the item to the array
		if ($discount > 0)
		{
			$items_array[$item]['discount'] = $discount;
		}
		else
		{
			unset($items_array[$item]['discount']);
		}

		// sort array
		ksort($items_array[$item]);
		ksort($items_array);

		// reset session value for items array
		if ($page == 'modify')
		{
			$this->session->set_userdata('so_mod_items', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('so_items', json_encode($items_array));
		}

		echo 'success';
	}

	// ----------------------------------------------------------------------

}
