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
			redirect('my_account/sales/lookbook');
		}

		// load pertinent library/model/helpers
		$this->load->library('lookbook/lookbook_details');

		// initialize certain properties
		$this->lookbook_details->initialize(array('lookbook_id'=>$id));

		if ($this->lookbook_details->author === 'system')
		{
			// cannot delete super sales
			// set flash data
			$this->session->set_flashdata('error', 'del_system_sales_package');

			// redirect user
			redirect('my_account/sales/lookbook/');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// delete item from records
		$DB->where('lookbook_id', $id);
		$q = $DB->delete('lookbook');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('my_account/sales/lookbook/');
	}

	// ----------------------------------------------------------------------

}
