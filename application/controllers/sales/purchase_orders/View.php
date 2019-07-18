<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends MY_Controller {

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
	public function index($po_id = '')
	{
		if ( ! $po_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/purchase_orders', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');

		// initialize purchase order properties and items
		$this->data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// get po items and other array stuff
		$this->data['po_number'] = $this->purchase_order_details->po_number;
		$this->data['po_items'] = $this->purchase_order_details->items;
		$this->data['po_options'] = $this->purchase_order_details->options;

		// get vendor details
		$this->data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->purchase_order_details->vendor_id
			)
		);

		// get author details
		$this->data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_id' => $this->purchase_order_details->author
			)
		);

		// get ship to details
		if (isset($this->data['po_options']['po_store_id']))
		{
			$this->data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $this->data['po_options']['po_store_id']
				)
			);
		}
		else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'po_view';
		$this->data['page_title'] = 'Purchase Order';
		$this->data['page_description'] = 'Send Purchase Order';

		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

}
