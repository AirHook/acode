<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_items extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('users/sales_user_details');

		// get sales user login details
		if ($this->session->admin_sales_loggedin)
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->session->admin_sales_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		// set the items array
		$items_array =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

		// set the cart items
		// iterate through the $items_array and generate HTML
		$html = '';
		$overall_qty = 0;
		$overall_total = 0;
		$i = 1;
		foreach ($items_array as $item => $size_qty)
		{
			// just a catch all error suppression
			if ( ! $item) continue;

			// get product details
			// NOTE: some items may not be in product list
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			// set image paths
			// the new way relating records with media library
			$style_no = $item;
			$prod_no = $exp[0];
			$color_code = $exp[1];
			$temp_size_mode = 1; // default size mode

			// price can be...
			// onsale price (retail_sale_price or wholesale_price_clearance)
			// regular price (retail_price or wholesale_price)
			// this is sales user account mainly for wholesale users only
			if (@$product->custom_order == '3')
			{
				$price = @$product->wholesale_price_clearance ?: 0;
			}
			else
			{
				$price = @$product->wholesale_price ?: 0;
			}
			// new pricing scheme
			// we are in sales user, hence, this is only for wholesale users
			$orig_price = @$product->wholesale_price ?: 0;
			$price =
				@$product->custom_order == '3'
				? (@$product->wholesale_price_clearance ?: 0)
				: $orig_price
			;

			if ($product)
			{
				$image_new = $product->media_path.$style_no.'_f3.jpg';
				$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
				$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
				$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
				$size_mode = $product->size_mode;
				$color_name = $product->color_name;

				// take any existing product's size mode
				$temp_size_mode = $product->size_mode;
			}
			else
			{
				$image_new = 'images/instylelnylogo_3.jpg';
				$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
				$img_linesheet = '';
				$img_large = '';
				$size_mode = @$this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
				$color_name = $this->product_details->get_color_name($color_code);
			}

			// get size names
			$size_names = $this->size_names->get_size_names($size_mode);
			foreach ($size_qty as $size_label => $qty)
			{
				if ($size_label == 'discount') continue;

				$this_size_qty = $qty[0];
				$s = $size_names[$size_label];

				// calculate stocks
				// and check for on sale items
				if ($product)
				{
					if ($product->$size_label == '0') // -> no stock, PREORDER
					{
						$preorder = TRUE;
						$partial_stock = FALSE;
					}
					elseif ($qty[0] <= $product->$size_label) // -> INSTOCK
					{
						$preorder = FALSE;
						$partial_stock = FALSE;
					}
					elseif ($qty[0] > $product->$size_label) // -> partial stock
					{
						$preorder = TRUE;
						$partial_stock = TRUE;
					}
					else
					{
						$preorder = FALSE;
						$partial_stock = FALSE;
					}
					$onsale =
						$product->custom_order == '3'
						? TRUE
						: FALSE
					;
				}
				else
				{
					// item not in product list
					$preorder = FALSE;
					$partial_stock = FALSE;
					$onsale = FALSE;
				}

				if (
					isset($size_qty[$size_label])
					&& $s != 'XL1' && $s != 'XL2'
				)
				{
					$html.= '<tr class="summary-item-container" '
						.$item.' '.$size_label
						.'" data-item="'
						.$item
						.'" data-size_label="'
						.$size_label
						.'">'
					;

					/**********
					 * Quantities
					 *
					$html.= '<td class="text-center" style="vertical-align:top;">'
						.$qty[0]
						.'<br />'
						.'<i class="fa fa-pencil small tooltips font-grey-silver modal-edit_quantity" data-original-title="Edit Qty" data-placement="bottom" data-item="'
						.$item
						.'" data-size_label="'
						.$size_label
						.'"></i>'
						.'</td>'
						.'<td class="text-center" style="vertical-align:top;">'.$qty[1].'</td>'
						.'<td class="text-center" style="vertical-align:top;">'.$qty[2].'</td>'
					;
					// */

					/**********
					 * Items' IMAGE and Descriptions
					 */
					$html.= '<td style="vertical-align:top;"><a href="'.($img_large ?: 'javascript:;')
						.'" class="'.($img_large ? 'fancybox' : '')
						.'"><img class="" src="'
						.$img_front_new
						.'" alt="" style="width:60px;height:auto;" onerror="$(this).attr(\'src\',\''.$this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg\');" /></a>'
						.'<button type="button" class="btn btn-link btn-xs summary-item-remove tooltips pull-right" data-original-title="Remove Item" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'" data-size_label="'
						.$size_label
						.'" style="margin-right:0px;position:relative;top:-5px;"><i class="fa fa-close" style="color:#8896a0;"></i> <cite class="small hide">rem</cite></button>'
						.'<div class="shop-cart-item-details hide" style="margin-left:65px;">'
						.'<h4 style="margin:0px;">'
						.'<button type="button" class="btn btn-link btn-xs summary-item-remove tooltips pull-right" data-original-title="Remove Item" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'" data-size_label="'
						.$size_label
						.'" style="margin-right:0px;position:relative;top:-5px;"><i class="fa fa-close" style="color:#8896a0;"></i> <cite class="small hide">rem</cite></button>'
						.$prod_no
						.'</h4><p style="margin:0px;"><span style="color:#999;">Style#:&nbsp;<?php echo $item; ?></span><br />Color: &nbsp; '
						.$color_name
						.(@$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : '')
						.(@$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : '')
						.'</p>'
					;
					if ($onsale) {
						$html.= '<span class="badge bg-red-mint badge-roundless display-block"> On Sale </span>';
					}
					if ($preorder) {
						$html.= '<span class="badge badge-danger badge-roundless display-block"> Pre Order </span>';
					}
					if ($partial_stock) {
						$html.= '<span class="badge badge-warning badge-roundless display-block"> Parial Stock </span>';
					}
					$html.= '</div></td>';

					/**********
					 * Prod No
					 */
					$html.= '<td style="vertical-align:top;">'
						.$prod_no
						.'</td>'
					;

					/**********
					 * Size
					 */
					$html.= '<td style="vertical-align:top;text-align:center;">'
						.$s
						.'</td>'
					;

					/**********
					 * Coor
					 */
					$html.= '<td style="vertical-align:top;">'
						.$color_name
						.'</td>'
					;

					/**********
					 * Qty
					 */
					$html.= '<td style="vertical-align:top;text-align:center;">'
						.($qty[0] ?: $qty)
						.'</td>'
					;

					/**********
					 * Reg Price
					 */
					$html.= '<td style="vertical-align:top;'
						.($orig_price == $price ?: 'text-decoration:line-through;')
						.'" class="text-right unit-price-wrapper '
						.$item.' '.$prod_no
						.'" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'">$ '
						.number_format($orig_price, 2)
						.'</td>'
					;

					/**********
					 * Discount - onsale/clearance
					 */
					$html.= '<td style="vertical-align:top;'
						.($orig_price == $price ?: 'color:red;')
						.'" class="text-right unit-price-wrapper '
						.$item.' '.$prod_no
						.'" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'">'
						.($orig_price == $price ? '--' : '$ '.number_format($price, 2))
						.'</td>'
					;

					// Discount
					/* */
					// the $disc ($options['discount']) was inteded for putting discounts
					// on prices which is currently hidden as price is now using direct discounted amounts
					// like the retail onsale price and wholesale clearance price
					// keeping it here as discounts may be used again...
					$disc = @$size_qty['discount'] ?: 0;
					$html.= '<td style="vertical-align:top;" class="text-right discount-wrapper '
						.$item.' '.$prod_no
						.' hide">'
						.($disc == '0' ? '---' : $disc)
						.'<br />'
						.'<i class="fa fa-pencil small tooltips font-grey-silver modal-add_discount" data-original-title="Add Discount" data-placement="bottom" data-item="'
						.$item
						.'" data-size_label="'
						.$size_label
						.'"></i>'
						.'</td>'
					;
					// */

					/**********
					 * Extended
					 */
					$this_size_total = $this_size_qty * ($price - $disc);
					$html.= '<td style="vertical-align:top;" class="text-right order-subtotal '
						.$item.' '.$prod_no
						.'">$ '
						.number_format($this_size_total, 2)
						.'</td>'
					;

					// Clsoing </td>
					$html.= '<input type="hidden" class="input-order-subtotal '
						.$item.' '.$prod_no
						.'" name="subtotal" value="'
						.$this_size_total
						.'" /></tr>'
					;
				}

				$overall_qty += $this_size_qty;
				$overall_total += $this_size_total;
			}

			$i++;
		}

		$html.= '<input type="hidden" class="hidden-overall_qty" name="overall_qty" value="'.$overall_qty.'" />';
		$html.= '<input type="hidden" class="hidden-overall_total" name="overall_total" value="'.$overall_total.'" />';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
