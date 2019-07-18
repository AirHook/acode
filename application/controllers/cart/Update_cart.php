<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 * 
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Update_cart extends Frontend_Controller
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
	function index($i_no = '', $i_rowid = '')
	{
		if ($this->input->post()) $data = $this->input->post();
		else $data = array(
			'rowid' => $i_rowid,
			'qty' => 0
		);

		// update cart
		$this->cart->update($data); 
		
		// set flash data
		$this->session->set_flashdata('flashRegMsg','<div class="successMsg">Cart updated.</div>');
		
		// redirect user to cart basket
		redirect('cart', 'location');
	}
	
	// --------------------------------------------------------------------
	
}
