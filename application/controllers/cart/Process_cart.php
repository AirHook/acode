<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 * 
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Process_cart extends Frontend_Controller
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
		// special sale prefix
		$special_sale_prefix = $this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '';
		
		// grab return url for as may deem necessary
		$previous_url		= $this->input->post('current_url');
		
		// just in case this controller is accessed without items on cart
		if ($this->cart->total_items() == 0)
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">There are no items in the cart! Please select items to order... [ <a href="'.str_replace('https', 'http', site_url('apparel')).'">CONTINUE SHOPPING</a>. ]</div>');
			redirect($previous_url, 'location');
		}
		
		// Setting session shipping information for if USA or other countries
		if ($this->session->userdata('user_cat') == 'wholesale')
		{
			if ($this->session->userdata('shipping_country') != 'United States')
			{
				$shipping_id		= '';
				$shipping_courier	= 'DHL for countries other than USA';
				$shipping_fee		= '';
		
				$this->session->set_userdata(
					array(
						'shipping_courier'	=> $shipping_courier,
						'shipping_fee'		=> $shipping_fee,
						'shipping_id'		=> $shipping_id
					)
				);
			}
		}
		else
		{
			if ($this->input->post('ship_country')) $this->session->set_userdata('shipping_country',$this->input->post('ship_country'));
		}
		
		// redirect user accordingly
		if ( ! $this->session->userdata('user_loggedin'))
		{
			redirect($special_sale_prefix.'cart/customer_info', 'location');
		}
		else
		{
			redirect($special_sale_prefix.'cart/confirm_order', 'location');
		}
	}
	
	// --------------------------------------------------------------------
	
}
