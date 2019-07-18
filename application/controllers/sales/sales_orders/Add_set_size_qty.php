<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_set_size_qty extends MY_Controller {

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

		if ( ! $this->input->post('style_no'))
		{
			// nothing more to do...
			echo 'false';
		}

		// grab the post variables
		$item = $this->input->post('style_no');
		$page = $this->input->post('page'); // if from modify

		// set the items array
		$items_array =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

		// process the item
		foreach ($this->input->post() as $size_label => $qty)
		{
			if ($size_label != 'style_no')
			{
				if ($qty == 0)
				{
					unset($items_array[$item][$size_label]);
				}
				else
				{
					$items_array[$item][$size_label] = $qty;
				}
			}
		}

		if ( ! empty($items_array))
		{
			// get this item total qty
			$this_sum = @array_sum($items_array[$item]);

			// sum all sizes
			$sum = 0;
			foreach ($items_array as $key => $val)
			{
				$sum += @array_sum($val);
			}
		}
		else
		{
			$this_sum = 0;
			$sum = 0;
		}

		// reset session value for items array
		/* *
		if ($page == 'modify')
		{
			$this->session->set_userdata('so_mod_size_qty', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('so_size_qty', json_encode($items_array));
		}
		// */

		// reset session value for items array
		$this->session->set_userdata('so_items', json_encode($items_array));

		// echo the following
		//echo json_encode($items_array);
		echo json_encode(array('thisQty'=>$this_sum,'overallTotal'=>$sum));
	}

	// ----------------------------------------------------------------------

}
