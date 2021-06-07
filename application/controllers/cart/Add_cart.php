<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Add_cart extends Frontend_Controller
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

		// grab the post information
		// common between consumer and wholesale users
		$prod_name			= $this->input->post('prod_name');
		// cart option items
		// common between consumer and wholesale users
		$prod_no			= $this->input->post('prod_no');
		$des_id				= $this->input->post('des_id');
		$cat_id				= $this->input->post('cat_id');
		$subcat_id			= $this->input->post('subcat_id');
		$designer			= $this->input->post('label_designer');

		// check size_mode (A or 'a' or '1' default for instyle)
		// '0' for S,M,L...
		// checking is for potentially using this to other sites
		// primarily for the size array to iterate before adding to cart
		$size_mode			= $this->input->post('size_mode');

		$previous_url		= $this->input->post('current_url');
		$prod_image			= $this->input->post('prod_image');
		// new image url system
		$prod_image_url		= $this->input->post('prod_image_url');
		$custom_order		= $this->input->post('custom_order');
		$color_code			= $this->input->post('color_code');
		$color				= $this->input->post('label_color');
		$admin_stocks_only	= $this->input->post('admin_stocks_only'); // '1','0'
		$prod_sku			= $this->input->post('prod_sku');
		$price				= $this->input->post('price');
		$orig_price			= $this->input->post('orig_price');
		$availability		= $this->input->post('availability');

		$qty				= $this->input->post('qty');
		$size				= $this->input->post('size');

		// This function allows for zero integer as not empty in a variable
		// especially made for size '0' which is always mistekan as empty for isset() function
		function is_empty($var, $allow_false = false, $allow_ws = false) {
			if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {
				return true;
			} else {
				return false;
			}
		}

		if ($cat_id <> 19 && is_empty($size))
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select a product size.</div>');
			redirect($previous_url, 'location');
		}

		if ( ! $qty)
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select quantity.</div>');
			redirect($previous_url, 'location');
		}

		if ($price == '0.00')
		{
			$this->session->set_flashdata('error','no_price');
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Product has no price. Please select another product.</div>');
			redirect($previous_url, 'location');
		}

		$cart_item = array(
			'id'      => $prod_sku,
			'qty'     => $qty,
			'price'   => ($availability == 'preorder' ? $orig_price : $price),
			'name'    => $prod_name,
			'options' => array(
				'size' 				=> $size,
				'prod_no' 			=> $prod_no,
				'color_code' 		=> $color_code,
				'des_id'			=> $des_id,
				'cat_id'			=> $cat_id,
				'subcat_id'			=> $subcat_id,
				'prod_image'		=> $prod_image,
				'prod_image_url'	=> $prod_image_url, // new image url system
				'color'				=> $color,
				'designer'			=> $designer,
				'orig_price'		=> $orig_price,
				'current_url'		=> $previous_url,
				'custom_order' 		=> $custom_order,
				'availability' 		=> $availability,
				'admin_stocks_only' => $admin_stocks_only,
				'sa_item' 			=> $this->input->post('package_details')
			)
		);

		$this->cart->insert($cart_item);

		// this part of the code is an anticipation for guest cart session
		// save to cookie as memory which is part of the wholesale cart session
		// memory saving program. something is wrong with the setcookie.
		// deferring this anticipation at the moment - _rey 20200604
		// save to memory
		//$this->cart_memory->cart_mem_cookie();
		//$this->cart_memory->unset_cookie();

		// redirect user to cart basket
		redirect('cart', 'location');
	}

	// --------------------------------------------------------------------

	/**
	 * Wholesale function - recipient of post data for order inquiries made by
	 * logged in wholesale users.
	 *
	 * Example post data received:

	 Array
	 (
	     [wholesale_order] => 0
	     [package_details] => 0
	     [special_sale_prefix] => 0
	     [cat_id] => 1
	     [subcat_id] => 161
	     [des_id] => 5
	     [prod_no] => D9114L
	     [prod_name] => D9114L
	     [price] => 0
	     [label_designer] => Basix Black Label
		 [orig_price] => 0
	     [color_code] => PINK1
	     [prod_sku] => D9114L_PINK1
	     [label_color] => PINK
	     [prod_image] => https://www.shop7thavenue.com/uploads/products/2019/01/D9114L_PINK1_f1.jpg
	     [current_url] => http://localhost/~admin1/acode/shop/details/basixblacklabel/D9114L/pink/d9114l/4of5.html
	     [prod_image_url] => uploads/products/2019/01/D9114L_PINK1_f1.jpg
	     [size_mode] => 1
	     [size] => Array
	         (
	             [1] =>
	             [2] => 2
	             [3] =>
	             [4] =>
	             [5] =>
	             [6] =>
	             [7] =>
	             [8] =>
	             [9] =>
	             [10] =>
	             [11] =>
	             [12] =>
	         )

	     [qty] => Array
	         (
	             [1] => 0
	             [2] => 1
	             [3] => 0
	             [4] => 0
	             [5] => 0
	             [6] => 0
	             [7] => 0
	             [8] => 0
	             [9] => 0
	             [10] => 0
	             [11] => 0
	             [12] => 0
	         )

	 )
	 *
	 * Additional post data if from sales package details page
	 *
	 [custom_order] => 0/3/1
	 *
	 * @return	void
	 */
	function wholesale()
	{
		$this->output->enable_profiler(FALSE);

		//echo '<pre>';
		//print_r($this->input->post());
		//print_r(array_filter($this->input->post('qty')));
		//die();

		// load pertinent library/model/helpers
		$this->load->library('cart/cart_memory');

		// we need to put a check for when ordering is done via satellite site
		// only logged in wholesale users are allowed to order on satellite site
		if (
			$this->webspace_details->options['site_type'] === 'sat_site'
			&& ! $this->session->user_role == 'wholesale'
		)
		{
			// nothing more to do...
			// set flash session
			$this->session->set_flashdata('error', 'must_login');

			// redirect user
			redirect(site_url(), 'location');
		}

		// grab the post information
		$prod_name		= $this->input->post('prod_name');
		// cart option items
		$prod_no		= $this->input->post('prod_no');
		$des_id			= $this->input->post('des_id');
		$cat_id			= $this->input->post('cat_id');	// for depracation
		$subcat_id		= $this->input->post('subcat_id'); // for depracation
		$designer		= $this->input->post('label_designer');

		// check size_mode (A or 'a' or '1' default for instyle)
		// '0' for S,M,L...
		// checking is for potentially using this to other sites
		// primarily for the size array to iterate before adding to cart
		$size_mode		= $this->input->post('size_mode');

		$previous_url	= $this->input->post('current_url');
		$prod_image		= $this->input->post('prod_image');
		// new image url system
		$prod_image_url	= $this->input->post('prod_image_url');
		$custom_order	= $this->input->post('custom_order');
		$color_code		= $this->input->post('color_code');
		$color			= $this->input->post('label_color');
		$prod_sku		= $this->input->post('prod_sku');
		$price			= $this->input->post('price');
		$orig_price		= $this->input->post('orig_price');

		$qty_ary			= array_filter($this->input->post('qty'));
		$size_ary			= $this->input->post('size');

		foreach ($qty_ary as $key => $qty)
		{
			$this->data = array(
				'id'      => $prod_sku,
				'qty'     => $qty,
				'price'   => ($price != '0' ? $price : 1),
				'name'    => $prod_name,
				'options' => array(
					'size' 				=> $size_ary[$key], 
					'prod_no' 			=> $prod_no,
					'color_code' 		=> $color_code,
					'des_id'			=> $des_id,
					'cat_id'			=> $cat_id,
					'subcat_id'			=> $subcat_id,
					'prod_image'		=> $prod_image,
					'prod_image_url'	=> $prod_image_url, // new image url system
					'color'				=> $color,
					'designer'			=> $designer,
					'orig_price'		=> $orig_price,
					'current_url'		=> $previous_url,
					'custom_order' 		=> ($custom_order ?: 0),
					'admin_stocks_only' => '0',
					'sa_item' 			=> $this->input->post('package_details')
				)
			);

			// add to cart
			$this->cart->insert($this->data);

			// set user details before updating cart memory
			$this->cart_memory->user_details = array(
				'user_id' => $this->wholesale_user_details->user_id,
				'options' => $this->wholesale_user_details->options
			);
			// save to memory
			$this->cart_memory->cart_mem_ws();
		}

		// redirect user to cart basket
		if ($this->input->post('package_details') == '0') redirect('cart', 'location');
		else
		{
			echo $this->_shop_cart_toggler_update();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Shop Cart Toggler Update HTML
	 *
	 * @return	string
	 */
	private function _shop_cart_toggler_update()
	{
		?>
		<a href="javascript:;" class="dropdown-toggle shopping-bag-link" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
			<img src="<?php echo base_url(); ?>assets/images/icons/shopping-bag.png" style="width:25px;height:28px;position:relative;top:-7px;" />
			<i class="icon-bag hide"></i>
			<span class="badge badge-default badge-roundless badge-cart-top-nav" style="width:25px;text-align:center;">
				<?php echo $this->cart->total_items() ?: '0'; ?>
			</span>
		</a>
		<ul class="dropdown-menu " style="border:1px solid #ccc;">
			<li class="external" style="background:white;">
				<?php
				if ($this->cart->contents())
				{ ?>
				<h3 style="color:black;">You have
					<strong><?php echo $this->cart->total_items(); ?> Items</strong> in you cart</h3>
				<a href="<?php echo site_url('cart'); ?>" style="color:black;">view all</a>
					<?php
				}
				else
				{ ?>
					<h3 style="color:black;">You have
						<strong>0 Items</strong> in you cart</h3>
					<?php
				} ?>
			</li>
			<li class="<?php echo $this->cart->total_items() ?: 'hide_'; ?>" style="background:white;">
				<!--
				<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
				-->
				<ul class="dropdown-menu-list ">

					<?php
					if ($this->cart->contents())
					{
						$i = 1;
						foreach ($this->cart->contents() as $items)
						{
							// incorporate new image url system
							if (
								isset($items['options']['prod_image_url'])
								&& ! empty($items['options']['prod_image_url'])
							)
							{
								$href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
							}
							else
							{
								$href_text = str_replace('_2', '_3', $items['options']['prod_image']);
							} ?>

					<li>
						<a href="javascript:;" class="header-cart-button-cart-details" style="border-bottom:none !important;">
							<span class="photo">
								<img src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" class="" alt="" width="40px" style="width:40px;height:60px;border-radius:0 !important;">
							</span>
							<span class="subject">
								<span class="from" style="color:black;"> Product#: <?php echo $items['options']['prod_no']; ?> </span>
								<span class="time hide"> Just Now </span>
							</span>
							<span class="message" style="color:black;"> Color: &nbsp; <?php echo $items['options']['color']; ?>
								<br />Size: &nbsp; <?php echo $items['options']['size']; ?>
								<br /><?php echo $items['qty']; ?> pcs </span>
						</a>
					</li>

							<?php
							$i++;
							if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
							else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
							else $custom_order = FALSE;
						}
					} ?>

				</ul>
			</li>
		</ul>

		<?php
	}

	// --------------------------------------------------------------------

}
