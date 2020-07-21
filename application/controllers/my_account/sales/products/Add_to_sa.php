<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_to_sa extends Sales_user_Controller {

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
		$size = $this->input->post('size');

		// set the items array
		$items_array =
			$this->session->sa_items
			? json_decode($this->session->sa_items, TRUE)
			: array()
		;

		// push item into array
		if (($key = array_search($item, $items_array)) === FALSE)
		{
			// push item into array
			array_push($items_array, $item);
		}

		// sort array
		array_filter($items_array);
		sort($items_array);

		if (empty($items_array))
		{
			// return user to page...
			$this->session->set_flashdata('error', 'no_id_passed');

			redirect(site_url($this->input->post('uri_string')), 'location');
		}

		// set session data for sa create
		$this->session->set_userdata('sa_items', json_encode($items_array));

		// echo number of items in array
		redirect('my_account/sales/sales_package/create', 'location');
	}

	// ----------------------------------------------------------------------

}
