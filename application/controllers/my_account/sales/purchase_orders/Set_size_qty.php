<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_size_qty extends MY_Controller {

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
			//echo 'false';
			//exit;
		}

		// grab the post variables
		//$item = '807M_BLAC1';
		//$size = 'size_sm';
		//$qty = '0';
		//$page = 'modify';
		$item = $this->input->post('prod_no');
		$size = $this->input->post('size');
		$qty = $this->input->post('qty');
		$page = $this->input->post('page');

		$the_po_items =
			$page == 'modify'
			? $this->session->po_mod_items
			: $this->session->po_items
		;

		// set the items array
		$items_array =
			$the_po_items
			? json_decode($the_po_items, TRUE)
			: array()
		;

		// process the item
		if ($qty == 0)
		{
			if (isset($items_array[$item][$size]))
			unset($items_array[$item][$size]);
			// check if resutling item is empty
			if (isset($items_array[$item]) && empty($items_array[$item]))
			unset($items_array[$item]);
		}
		else
		{
			$items_array[$item][$size] = $qty;
		}

		// reset session value for items array
		if ($page == 'modify')
		{
			$this->session->set_userdata('po_mod_items', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('po_items', json_encode($items_array));
		}

		// if item still exists, sum it
		if (isset($items_array[$item]))
		{
			// unset some items
			if (isset($items_array[$item]['color_name'])) unset($items_array[$item]['color_name']);
			if (isset($items_array[$item]['vendor_price'])) unset($items_array[$item]['vendor_price']);

			// get this item total qty
			$this_sum = array_sum($items_array[$item]);
		}
		else $this_sum = 0;

		// sum all other items sizes and quantities
		$sum = 0;
		foreach ($items_array as $key => $val)
		{
			// unset some items
			if (isset($items_array[$key]['color_name'])) unset($items_array[$key]['color_name']);
			if (isset($items_array[$key]['vendor_price'])) unset($items_array[$key]['vendor_price']);
			$sum += array_sum($items_array[$key]);
		}

		// echo the following
		echo json_encode(array('thisQty'=>$this_sum,'overallTotal'=>$sum));
		//echo json_encode($items_array);
	}

	// ----------------------------------------------------------------------

}
