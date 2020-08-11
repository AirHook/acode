<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class View_email_order_confirmation extends Frontend_Controller
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
		$this->load->library('orders/order_details');

		$this->data['test'] = TRUE;

		$email_data = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>'10102001'));

		// load the view
		$message = $this->load->view('templates/order_confirmation', $email_data, TRUE);

		echo $message;
	}

	// --------------------------------------------------------------------

}
