<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pick_and_pack_update extends MY_Controller {

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

		if ( ! $this->input->post('item'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variables
		$item = $this->input->post('item');
		$size_label = $this->input->post('size_label');
		$qty = $this->input->post('qty');
		$shipd = $this->input->post('shipd');
		$bo = $this->input->post('bo');

		// set the items array
		$items_array =
			$this->session->admin_so_mod_items
			? json_decode($this->session->admin_so_mod_items, TRUE)
			: array()
		;

		// defatul - update item
		$items_array[$item][$size_label] = array($qty,$shipd,$bo);

		// sort array
		ksort($items_array[$item]);
		ksort($items_array);

		// reset session value for items array
		$this->session->set_userdata('admin_so_mod_items', json_encode($items_array));

		echo json_encode($items_array);
	}

	// ----------------------------------------------------------------------

}
