<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 * 
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Order_sent extends Frontend_Controller
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
	function index($order_log_id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('orders/order_details');
		
		// initialize data
		$this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_log_id));
		
		// set data variables to pass to view file
		$this->data['file'] 						= 'order_sent';
		//$this->data['order_log'] 					= $order_log_id;
		//$this->data['order_log_details'] 			= $this->order_details->initialize(array('order_log_id'=>$order_log_id));
		$this->data['site_title']					= @$meta_tags['title'];
		$this->data['site_keywords']				= @$meta_tags['keyword'];
		$this->data['site_description']				= @$meta_tags['description'];
		$this->data['alttags']						= @$meta_tags['alttags'];
		
		// load the view
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}
	
	// --------------------------------------------------------------------
	
}
