<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class View_email_purchase_order extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('products/product_details');

		$this->data['test'] = TRUE;

		$this->data['po_details'] = $this->purchase_order_details->initialize(array('po_id'=>'2'));

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

		// load the view
		$message = $this->load->view('templates/purchase_order', $this->data, TRUE);

		echo $message;
	}

	// --------------------------------------------------------------------

}
