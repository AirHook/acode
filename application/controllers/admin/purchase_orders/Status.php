<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
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
		if ( ! $this->input->post())
		{
			echo 'Fail!';
			exit;
		}

		// update stocks for completed PO
		if ($this->input->post('status') == '5')
		{
			$this->_update_stocks($this->input->post('po_id'));
		}

		// update recors
		$this->DB->set('status', $this->input->post('status'));
		$this->DB->where('po_id', $this->input->post('po_id'));
		$this->DB->update('purchase_orders');

		echo 'Success';
		exit;
	}

	// ----------------------------------------------------------------------

	/**
	 * Update
	 *
	 * @return	void
	 */
	public function update($po_id = '', $status = '')
	{
		if ($po_id == '' OR $status == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'purchase_orders');
		}

		// update stocks for completed PO
		if ($status == '5')
		{
			$this->_update_stocks($po_id);
		}

		// update records
		$this->DB->set('status', $status);
		$this->DB->where('po_id', $po_id);
		$this->DB->update('purchase_orders');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'purchase_orders', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Stocks
	 *
	 * @return	void
	 */
	private function _update_stocks($po_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('inventory/update_stocks');
		$this->update_stocks->po_completed($po_id);
	}

	// ----------------------------------------------------------------------

}
