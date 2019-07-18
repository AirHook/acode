<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends Sales_Controller {

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
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_package', 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');

		// initialize certain properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		// capture existing items and option and set flags to indicate
		// coming from existing sales package
		$this->session->set_userdata('sa_items', json_encode($this->sales_package_details->items));
		$this->session->set_userdata('sa_prev_items', json_encode($this->sales_package_details->items));
		$this->session->set_userdata('sa_name', $this->sales_package_details->sales_package_name);
		$this->session->set_userdata('sa_email_subject', $this->sales_package_details->email_subject);
		$this->session->set_userdata('sa_email_message', $this->sales_package_details->email_message);

		// flags
		$this->session->set_userdata('sa_id', $this->sales_package_details->sales_package_id);

		// previously edite prices
		if ($this->sales_package_details->options['e_prices'])
		{
			$options_array['e_prices'] = $this->sales_package_details->options['e_prices'];
			$this->session->set_userdata('sa_options', json_encode($options_array));
			$this->session->set_userdata('show_prev_e_prices_modal', '1');
		}

		// redirect user
		redirect('sales/create/step2', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Prev E Prices
	 *
	 * @return	void
	 */
	public function prev_e_prices()
	{
		// set to false to indicate that the modal notice has been viwed and clicked ok
		unset($_SESSION['show_prev_e_prices_modal']);
		//$this->session->set_userdata('show_prev_e_prices_modal', TRUE);
	}

	// ----------------------------------------------------------------------

}
