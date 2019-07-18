<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends MY_Controller {

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
	public function index($po_id = '', $action = '')
	{
		if ($po_id == '')
		{
			// nothing more to do
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($action === 'send') redirect('admin/purchase_orders/create/step1', 'location');
			else redirect('admin/purchase_orders/details/index/'.$po_id, 'location');
		}

		// send PO
		$this->load->library('purchase_orders/purchase_order_sending');
		$this->purchase_order_sending->send($po_id);

		// set flash data
		$this->session->set_flashdata('success', 'add');

		if ($action === 'send')
		{
			// redirect user on step4
			redirect('admin/purchase_orders/create/step4/'.$po_id, 'location');
		}
		else
		{
			// redirect user
			redirect('admin/purchase_orders/details/index/'.$po_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

}
