<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Sales_user_Controller {

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
	 * Index - Delete Sales Package
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/sales_package', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');

		// initialize certain properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		if ($this->sales_package_details->author === 'system')
		{
			// cannot delete super sales
			// set flash data
			$this->session->set_flashdata('error', 'del_system_sales_package');

			// redirect user
			redirect('my_account/sales/sales_package', 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// delete item from records
		$DB->where('sales_package_id', $id);
		$q = $DB->delete('sales_packages');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('my_account/sales/sales_package', 'location');
	}

	// ----------------------------------------------------------------------

}
