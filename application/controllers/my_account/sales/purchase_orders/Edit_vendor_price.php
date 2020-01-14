<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_vendor_price extends MY_Controller {

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
		$item = $this->input->post('prod_no'); // <prod_no>_<color_code>
		$vendor_price = $this->input->post('vendor_price');
		$page = $this->input->post('page');

		$po_items =
			$page == 'modify'
			? $this->session->po_mod_items
			: $this->session->po_items
		;

		// set the items array
		$items_array =
			$po_items
			? json_decode($po_items, TRUE)
			: array()
		;

		// process the item
		$items_array[$item]['vendor_price'] = $vendor_price;

		// reset session value for items array
		// and edit vendor price session
		if ($page == 'modify')
		{
			$this->session->set_userdata('po_mod_items', json_encode($items_array));
			$this->session->set_userdata('po_mod_edit_vendor_price', TRUE);
		}
		else
		{
			$this->session->set_userdata('po_items', json_encode($items_array));
			$this->session->set_userdata('po_edit_vendor_price', TRUE);
		}

		echo $vendor_price;
	}

	// ----------------------------------------------------------------------

}
