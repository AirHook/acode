<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrem_excluded extends Admin_Controller {

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
		if (
			! $this->input->post('prod_no')
			OR ! $this->input->post('color_code')
			OR ! $this->input->post('color_name')
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/sales_orders/create', 'location');
		}

		// grab the post variable
		$item = strtoupper(trim($this->input->post('prod_no'))).'_'.$this->input->post('color_code');

		// set the items array
		$items_array =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			$items_array[$item]['color_name'] = $this->input->post('color_name');
		}

		// reset session value for items array
		$this->session->set_userdata('admin_so_items', json_encode($items_array));

		// set flash data
		$this->session->set_flashdata('success', 'add');

		// redirect user
		redirect('admin/sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
