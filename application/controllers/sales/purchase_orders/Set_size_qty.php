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
			echo 'false';
		}

		// grab the post variables
		$item = $this->input->post('prod_no');
		$size = $this->input->post('size');
		$qty = $this->input->post('qty');
		$page = $this->input->post('page');

		$po_size_qty =
			$page == 'modify'
			? $this->session->po_mod_size_qty
			: $this->session->po_size_qty
		;

		// set the items array
		$items_array =
			$po_size_qty
			? json_decode($po_size_qty, TRUE)
			: array()
		;

		// process the item
		if ($qty == 0)
		{
			unset($items_array[$item][$size]);
		}
		else
		{
			$items_array[$item][$size] = $qty;
		}

		// reset session value for items array
		if ($page == 'modify')
		{
			$this->session->set_userdata('po_mod_size_qty', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('po_size_qty', json_encode($items_array));
		}

		// unset some items
		unset($items_array[$item]['color_name']);
		unset($items_array[$item]['vendor_price']);

		// get this item total qty
		$this_sum = array_sum($items_array[$item]);

		// sum all sizes
		$sum = 0;
		foreach ($items_array as $key => $val)
		{
			$sum += array_sum($val);
		}

		// echo the following
		echo json_encode(array('thisQty'=>$this_sum,'overallTotal'=>$sum));
	}

	// ----------------------------------------------------------------------

}
