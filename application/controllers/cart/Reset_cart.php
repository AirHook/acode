<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 * Cart reset controller used by the cart memory popup on
 * global to modals
 *
 */
class Reset_cart extends Frontend_Controller
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
		// load pertinent library/model/helpers
		$this->load->library('cart/cart_memory');

		// let us destroy the cart
		$this->cart->destroy();

		// remove cart memory
		if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
		{
			// set user details before updating cart memory
			$this->cart_memory->user_details = array(
				'user_id' => $this->wholesale_user_details->user_id,
				'options' => $this->wholesale_user_details->options
			);
			// remove from memory
			$this->cart_memory->unset_ws();
		}

		// set flash data
		$this->session->set_flashdata('flashRegMsg','<div class="successMsg">Cart updated.</div>');

		// redirect user to cart basket
		redirect('cart', 'location');
	}

	// --------------------------------------------------------------------

}
