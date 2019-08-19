<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_store_id extends MY_Controller {

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

		if ( ! $this->input->post('store_id'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		$this->session->set_userdata('admin_so_store_id', $this->input->post('store_id'));
		exit;
	}

	// ----------------------------------------------------------------------

}
