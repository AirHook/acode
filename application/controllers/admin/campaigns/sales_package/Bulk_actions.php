<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');

		foreach ($this->input->post('checkbox') as $id)
		{
			if ($this->input->post('bulk_action') == 'del')
			{
				// initialize certain properties
				$this->sales_package_details->initialize(array('sales_package_id'=>$id));

				if ($this->sales_package_details->author === 'system')
				{
					// cannot delete super sales
					// set flash data
					$this->session->set_flashdata('error', 'del_system_sales_package');

					// redirect user
					redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
				}

				// delete item from records
				$DB->where('sales_package_id', $id);
				$q = $DB->delete('sales_packages');
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/campaigns/sales_package');
	}

	// ----------------------------------------------------------------------

}
