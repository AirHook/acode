<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrem extends Sales_user_Controller {

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
		$page = $this->input->post('page');
		$size_qty = $this->input->post('size_qty'); // array of size and qty

		// set the items array
		$items_array =
			$this->session->po_items
			? json_decode($this->session->po_items, TRUE)
			: array()
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			if ( ! array_key_exists($item, $items_array))
			{
				// set items array with $item as key
				// and size_qty it's array elements
				if ($size_qty)
				{
					foreach ($size_qty as $size_label => $qty)
					{
						$items_array[$item][$size_label] = $qty;
					}
				}
				else
				{
					$items_array[$item] = array();
				}
			}

		}
		if ($this->input->post('action') == 'rem_item')
		{
			if (array_key_exists($item, $items_array))
			{
				unset($items_array[$item]);
			}
		}

		// sort array
		//array_filter($items_array);
		//sort($items_array);

		// reset session value for items array
		$this->session->set_userdata('po_items', json_encode($items_array));

		// echo number of items in array
		echo count($items_array);
	}

	// ----------------------------------------------------------------------

}
