<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_item_new_price extends MY_Controller {

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
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		$item = $this->input->post('item');
		$price = $this->input->post('price');
		$page = $this->input->post('page');

		// set the items array
		$items_array =
			$page == 'create'
			? (
				$this->session->admin_lb_items
				? json_decode($this->session->admin_lb_items, TRUE)
				: array()
			)
			: (
				$this->session->admin_lb_mod_items
				? json_decode($this->session->admin_lb_mod_items, TRUE)
				: array()
			)
		;

		// grab item details
		$color_name = $items_array[$item][0];
		$category = $items_array[$item][1];
		$new_price = isset($price) ? $price : @$items_array[$item][2];
		// update item element
		$items_array[$item] = array($color_name, $category, $price);

		// reset session value for items array
		if ($page == 'create')
		{
			$this->session->set_userdata('admin_lb_items', json_encode($items_array));
		}
		if ($page == 'modify')
		{
			$this->session->set_userdata('admin_lb_mod_items', json_encode($items_array));
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
