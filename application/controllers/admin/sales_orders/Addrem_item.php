<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrem_item extends MY_Controller {

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
			echo '';
			exit;
		}

		// grab the post variables
		$item = $this->input->post('prod_no');
		$size_label = $this->input->post('size_label');
		$qty = $this->input->post('qty');
		$page = $this->input->post('page');
		$action = $this->input->post('action');

		// set the items array
		$items_array =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;

		// defatul - add item
		if ($action == 'rem_item')
		{
			unset($items_array[$item][$size_label]);
		}
		else
		{
			$items_array[$item][$size_label] = $qty;
		}

		// check if item still has options
		if (
			empty($items_array[$item])
			OR (
				count($items_array[$item]) == 1
				&& key($items_array[$item]) == 'discount'
			)
		)
		{
			unset($items_array[$item]);
			$this_item_count = 0;
		}
		else
		{
			// sort array
			ksort($items_array[$item]);
			$this_item_count = count($items_array[$item]);
		}

		ksort($items_array);

		if (empty($items_array))
		{
			// unset session value for items array
			if ($page == 'modify')
			{
				unset($_SESSION['admin_so_mod_items']);
			}
			else
			{
				unset($_SESSION['admin_so_items']);
			}
		}
		else
		{
			// reset session value for items array
			if ($page == 'modify')
			{
				$this->session->set_userdata('admin_so_mod_items', json_encode($items_array));
			}
			else
			{
				$this->session->set_userdata('admin_so_items', json_encode($items_array));
			}
		}

		// echo the following
		echo $this_item_count;
	}

	// ----------------------------------------------------------------------

}
