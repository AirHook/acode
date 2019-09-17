<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrem extends MY_Controller {

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

		if ( ! $this->input->post('prod_no'))
		{
			// nothing more to do...
			echo 'false';
			exit;
		}

		// grab the post variable
		$item = $this->input->post('prod_no');

		// set the items array
		$items_array =
			$this->session->admin_po_items
			? json_decode($this->session->admin_po_items, TRUE)
			: array()
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			if ( ! array_key_exists($item, $items_array))
			{
				// set items array with $item as key
				$items_array[$item] = array();
			}

		}
		if ($this->input->post('action') == 'rem_item')
		{
			if (array_key_exists($item, $items_array))
			{
				unset($items_array[$item]);
			}

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

		// sort array
		//array_filter($items_array);
		//sort($items_array);

		// reset session value for items array
		$this->session->set_userdata('admin_po_items', json_encode($items_array));

		// echo number of items in array
		echo count($items_array);
	}

	// ----------------------------------------------------------------------

}
