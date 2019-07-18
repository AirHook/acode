<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 * 
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Index extends Shop_Controller
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
		redirect('shop/categories');
	}
	
	// --------------------------------------------------------------------
	
}
