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
		$prod_no = $this->input->post('prod_no');
		$item = $this->input->post('style_no');
		$page = $this->input->post('page');
		$color_name = $this->input->post('color_name');
		$category = $this->input->post('category');

		// set the items array
		$items_array =
			$page == 'create'
			? (
				$this->session->lb_items
				? json_decode($this->session->lb_items, TRUE)
				: array()
			)
			: (
				$this->session->lb_mod_items
				? json_decode($this->session->lb_mod_items, TRUE)
				: array()
			)
		;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			// simply add item... overwrite where existing
			$items_array[$item] = array($color_name, $category); // $color_name, $category, $price
		}
		if ($this->input->post('action') == 'rem_item')
		{
			// simply unset the array item
			if (isset($items_array[$item])) unset($items_array[$item]);
		}

		// reset session value for items array
		if ($this->input->post('page') == 'create')
		{
			$this->session->set_userdata('lb_items', json_encode($items_array));
		}
		if ($this->input->post('page') == 'modify')
		{
			$this->session->set_userdata('lb_mod_items', json_encode($items_array));
		}

		// echo number of items in array
		echo count($items_array);
	}

	// ----------------------------------------------------------------------

}
