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
		$page = $this->input->post('page');

		// set the items array and options array
		if ($page == 'create')
		{
			$items_array =
				$this->session->sa_pp_items
				? json_decode($this->session->sa_pp_items, TRUE)
				: array()
			;
			$options_array =
				$this->session->sa_pp_options
				? json_decode($this->session->sa_pp_options, TRUE)
				: array()
			;
		}
		else
		{
			$items_array =
				$this->session->sa_pp_mod_items
				? json_decode($this->session->sa_pp_mod_items, TRUE)
				: array()
			;
			$options_array =
				$this->session->sa_pp_mod_options
				? json_decode($this->session->sa_pp_mod_options, TRUE)
				: array()
			;
		}

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

			// remove reference to item from sa_options if any
			if (isset($options_array['e_prices'][$item])) unset($options_array['e_prices'][$item]);

			// reset session value for options array
			if ( ! empty($options_array))
			{
				if ($page == 'create')
				{
					$this->session->set_userdata('sa_pp_options', json_encode($options_array));
				}
				else
				{
					$this->session->set_userdata('sa_pp_mod_options', json_encode($options_array));
				}
			}
			// */
		}

		// sort array
		array_filter($items_array);
		sort($items_array);

		// reset session value for items array
		if ($page == 'create')
		{
			$this->session->set_userdata('sa_pp_items', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('sa_pp_mod_items', json_encode($items_array));
		}

		// echo number of items in array
		echo count($items_array);
	}

	// ----------------------------------------------------------------------

}
