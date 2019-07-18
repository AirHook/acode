<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_options extends MY_Controller {

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

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'false';
		}

		// set the items array
		$options_array =
			$this->session->sa_options
			? json_decode($this->session->sa_options, TRUE)
			: array()
		;

		// process the item
		foreach ($this->input->post() as $key => $val)
		{
			$options_array[$key] = $val;
		}

		// reset session value
		$this->session->set_userdata('sa_options', json_encode($options_array));

		// echo number of items in array
		//echo $this->input->post('price');
	}

	// ----------------------------------------------------------------------

}
