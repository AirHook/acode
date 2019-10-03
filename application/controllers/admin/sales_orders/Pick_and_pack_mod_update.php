<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pick_and_pack_mod_update extends MY_Controller {

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

		if ( ! $this->input->post('so_id'))
		{
			// nothing more to do...
			echo 'no post';
			exit;
		}

		// grab the post variables
		$so_id = $this->input->post('so_id');

		// set the items array
		$items_array =
			$this->session->admin_so_mod_items
			? json_decode($this->session->admin_so_mod_items, TRUE)
			: array()
		;

		if (empty($items_array))
		{
			// nothing more to do...
			echo 'empty items';
			exit;
		}

		/***********
		 * Update database
		 */
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('items', json_encode($items_array));
		$DB->where('sales_order_id', $so_id);
		$query = $DB->update('sales_orders');

		echo 'success';
		exit;
	}

	// ----------------------------------------------------------------------

}
