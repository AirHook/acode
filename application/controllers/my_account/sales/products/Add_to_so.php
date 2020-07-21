<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_to_so extends Sales_user_Controller {

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

		// grab the post variable
		$item = $this->input->post('prod_no');
		$page = $this->input->post('page');
		$size_qty = $this->input->post('size');

		// set the items array
		$items_array =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

		// check and set size qty array
		foreach ($size_qty as $size_label => $qty)
		{
			if ($qty > 0)
			{
				$items_array[$item][$size_label] = array($qty,0,$qty); // qty,shpd,reqd
			}
		}

		if (empty($items_array))
		{
			// return user to page...
			$this->session->set_flashdata('error', 'no_id_passed');

			redirect(site_url($this->input->post('uri_string')), 'location');
		}

		// sort array
		ksort($items_array[$item]);

		// set session data for sa create
		$this->session->set_userdata('so_items', json_encode($items_array));

		// echo number of items in array
		redirect('my_account/sales/sales_orders/new_order', 'location');
	}

	// ----------------------------------------------------------------------

}
