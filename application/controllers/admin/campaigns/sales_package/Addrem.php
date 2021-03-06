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
			$this->session->admin_sa_items
			? json_decode($this->session->admin_sa_items, TRUE)
			: (
				$this->session->admin_sa_mod_items
				? json_decode($this->session->admin_sa_mod_items, TRUE)
				: array()
			)
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			if (($key = array_search($item, $items_array)) === FALSE)
			{
				// push item into array
				array_push($items_array, $item);
			}

		}
		if ($this->input->post('action') == 'rem_item')
		{
			if (($key = array_search($item, $items_array)) !== FALSE)
			{
				// remove item
				unset($items_array[$key]);
			}

			// remove item from sa_options if any
			/* */
			$options_array =
				$this->session->admin_sa_options
				? json_decode($this->session->admin_sa_options, TRUE)
				: (
					$this->session->admin_sa_mod_options
					? json_decode($this->session->admin_sa_mod_options, TRUE)
					: array()
				)
			;
			if (isset($options_array['e_prices'][$item])) unset($options_array['e_prices'][$item]);

			// reset session value for options array
			if ( ! empty($options_array))
			{
				if ($this->session->admin_sa_items)
				{
					$this->session->set_userdata('admin_sa_options', json_encode($options_array));
				}

				if ($this->session->admin_sa_mod_items)
				{
					$this->session->set_userdata('admin_sa_mod_options', json_encode($options_array));
				}
			}
			// */
		}

		// sort array
		array_filter($items_array);
		sort($items_array);

		// reset session value for items array
		if ($this->input->post('page') == 'create')
		{
			$this->session->set_userdata('admin_sa_items', json_encode($items_array));
		}
		if ($this->input->post('page') == 'modify')
		{
			$this->session->set_userdata('admin_sa_mod_items', json_encode($items_array));
		}

		// echo number of items in array
		echo count($items_array);
	}

	// ----------------------------------------------------------------------

}
