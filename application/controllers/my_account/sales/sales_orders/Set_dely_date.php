<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_dely_date extends MY_Controller {

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

		if ( ! $this->input->post('delivery_date'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		$this->session->set_userdata('so_dely_date', $this->input->post('delivery_date'));
		exit;
	}

	// ----------------------------------------------------------------------

}
