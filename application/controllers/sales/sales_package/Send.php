<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends Sales_Controller {

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
	 * Index - Send Sales Package
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_package');
		}

		if ($this->input->post())
		{
			// send the sales package
			$this->load->library('sales_package/sales_package_sending');
			$this->sales_package_sending->initialize($this->input->post());

			if ( ! $this->sales_package_sending->send())
			{
				$this->session->set_flashdata('error', 'error_sending_package');

				redirect('sales/sales_package/edit/step4/'.$id, 'location');
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'sales_package_sent');

		redirect('sales/sales_package/edit/step4/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

}
