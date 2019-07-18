<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 * 
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Edit_customer_info extends Frontend_Controller
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
		// let's unset 'confirm_order' sesssion to be able to access the page
		$this->session->unset_userdata('confirm_order');
		
		// redirect user
		redirect('cart/customer_info', 'location');
	}
	
	// --------------------------------------------------------------------
	
}
