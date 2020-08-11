<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diff_ship_to extends Admin_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		/*
		Array
		(
		    [sh_email] =>
		    [sh_fname] =>
		    [sh_ltname] =>
		    [sh_store_name] => /company
		    [sh_fed_tax_id] => (not present in cs)
		    [sh_telephone] =>
		    [sh_address1] =>
		    [sh_address2] =>
		    [sh_city] =>
		    [sh_state] => /state_province
		    [sh_country] =>
		    [sh_zipcode] => /zip_postcode
		)
		*/

		// grab post data
		$post_ary = array_filter($this->input->post());

		// set session
		$this->session->set_userdata($post_ary);
		$this->session->set_userdata('admin_so_ship_to', '2');

		// return
		redirect('admin/sales_orders/create', 'location');
	}

	// ----------------------------------------------------------------------

}
