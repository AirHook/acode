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
		// load pertinent library/model/helpers
		$this->load->library('cart/cart_memory');

		if ($this->input->post()) $data = $this->input->post();
		else $data = array(
			'rowid' => $i_rowid,
			'qty' => 0
		);

		// update cart
		$this->cart->update($data);

		if ( ! $this->cart->contents())
		{
			// set addresses session data
			$data = array(
				'ny_tax' 		=> '',
				'shipmethod'	=> '',
				'courier'		=> '',
				'fix_fee'		=> ''
			);
			$this->session->unset_userdata($data);

			if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
			{
				// if cart return empty after update, no more items in cart
				// set user details before updating cart memory
				$this->cart_memory->user_details = array(
					'user_id' => $this->wholesale_user_details->user_id,
					'options' => $this->wholesale_user_details->options
				);
				// remove from memory
				$this->cart_memory->unset_ws();
			}
			else
			{
				// this part of the code is an anticipation for guest cart session
				// save to cookie as memory which is part of the wholesale cart session
				// memory saving program. something is wrong with the setcookie.
				// deferring this anticipation at the moment - _rey 20200604
				// remove from memory
				//$this->cart_memory->unset_cookie();
			}
		}
		else
		{
			if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
			{
				// set user details before updating cart memory
				$this->cart_memory->user_details = array(
					'user_id' => $this->wholesale_user_details->user_id,
					'options' => $this->wholesale_user_details->options
				);
				// save to memory
				$this->cart_memory->cart_mem_ws();
			}
			else
			{
				// this part of the code is an anticipation for guest cart session
				// save to cookie as memory which is part of the wholesale cart session
				// memory saving program. something is wrong with the setcookie.
				// deferring this anticipation at the moment - _rey 20200604
				// save to memory
				//$this->cart_memory->cart_mem_cookie();
			}
		}

		// set flash data
		$this->session->set_flashdata('flashRegMsg','<div class="successMsg">Cart updated.</div>');

		// redirect user to cart basket
		redirect('cart', 'location');
	}

	// --------------------------------------------------------------------

}
