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

		$admin_po_size_qty =
			$page == 'modify'
			? $this->session->admin_po_mod_size_qty
			: $this->session->admin_po_size_qty
		;

		// set the items array
		$items_array =
			$admin_po_size_qty
			? json_decode($admin_po_size_qty, TRUE)
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

		// get this item total qty
		$this_sum = array_sum($items_array[$item]);

		// sum all sizes
		$sum = 0;
		foreach ($items_array as $key => $val)
		{
			$sum += array_sum($val);
		}

		// reset session value for items array
		if ($page == 'modify')
		{
			$this->session->set_userdata('admin_po_mod_size_qty', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('admin_po_size_qty', json_encode($items_array));
		}

		// echo the following
		echo json_encode(array('thisQty'=>$this_sum,'overallTotal'=>$sum));
	}

	// ----------------------------------------------------------------------

}
