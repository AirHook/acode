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
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if (strpos($this->input->post('uri_string'), 'admin/purchase_orders/create/step2') !== false)
			{
				redirect($this->iinput->post('uri_string'), 'location');
			}
			else redirect('admin/purchase_orders/create/step2', 'location');
		}

		// grab the post variable
		$item = strtoupper(trim($this->input->post('prod_no'))).'_'.$this->input->post('color_code');

		// set the items array
		$items_array =
			$this->session->admin_po_items
			? json_decode($this->session->admin_po_items, TRUE)
			: array()
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			if ( ! in_array($item, $items_array))
			{
				array_push($items_array, $item);
			}
		}
		if ($this->input->post('action') == 'rem_item')
		{
			if (($key = array_search($item, $items_array)) !== false) {
				unset($items_array[$key]);
			}
			$items_array = array_values($items_array);

			// remove item from po_size_qty if any
			/* */
			$options_array =
				$this->session->admin_po_size_qty
				? json_decode($this->session->admin_po_size_qty, TRUE)
				: array()
			;
			if (isset($options_array[$item])) unset($options_array[$item]);

			// reset session value for options array
			if ( ! empty($options_array)) $this->session->set_userdata('admin_po_size_qty', json_encode($options_array));
			// */
		}

		// reset session value for items array
		$this->session->set_userdata('admin_po_items', json_encode($items_array));

		// set flash data
		$this->session->set_flashdata('success', 'item_added');

		// redirect user
		if (strpos($this->input->post('uri_string'), 'admin/purchase_orders/create/step2') !== false)
		{
			redirect($this->iinput->post('uri_string'), 'location');
		}
		else redirect('admin/purchase_orders/create/step2', 'location');
	}

	// ----------------------------------------------------------------------

}
