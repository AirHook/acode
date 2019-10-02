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

		// set the items array
		$items_array =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;

		// set the cart items
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

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
			if (@$product->custom_order == '3')
			{
				$price =
					$this->session->admin_so_user_cat == 'ws'
					? (@$product->wholesale_price_clearance ?: 0)
					: (@$product->retail_sale_price ?: 0)
				;
			}
			else
			{
				$price =
					$this->session->admin_so_user_cat == 'ws'
					? (@$product->wholesale_price ?: 0)
					: (@$product->retail_price ?: 0)
				;
			}

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

			// set some data
			$size_names = $this->size_names->get_size_names($size_mode);

			foreach ($size_qty as $size_label => $qty)
			{
				if ($size_label == 'discount') continue;

				$this_size_qty = $qty;
				$s = $size_names[$size_label];

				// calculate stocks
				// and check for on sale items
				if ($product)
				{
					$stock_status =
						$qty <= $product->$size_label
						? 'instock'
						: 'preorder'
					;
					$onsale =
						$product->custom_order == '3'
						? 'onsale'
						: ''
					;
				}
				else
				{
					$stock_status = 'preorder'; // item not in product list
					$onsale = '';
				}

				if (
					isset($size_qty[$size_label])
					&& $s != 'XL1' && $s != 'XL2'
				)
				{
					$html.= '<tr class="summary-item-container">';

					// Quantities
					$html.= '<td class="text-center" style="vertical-align:top;">'
						.$qty
						.'<br />'
						.'<i class="fa fa-pencil small tooltips font-grey-silver modal-edit_quantity" data-original-title="Edit Qty" data-placement="bottom" data-item="'
						.$item
						.'" data-size_label="'
						.$size_label
						.'"></i>'
						.'</td>'
						.'<td class="text-center" style="vertical-align:top;">0</td>'
						.'<td class="text-center" style="vertical-align:top;">'.$qty.'</td>'
					;

					// Item Number
					$html.= '<td style="vertical-align:top;">'
						.$prod_no
						.'<br />'
						.$color_name
						.'<br />Size '.$s
						.'</td>'
					;

					// IMAGE and Descriptions
					$html.= '<td><a href="'.($img_large ?: 'javascript:;')
						.'" class="'.($img_large ? 'fancybox' : '')
						.' pull-left"><img class="" src="'
						.$img_front_new
						.'" alt="" style="width:60px;height:auto;" onerror="$(this).attr(\'src\',\''.$this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg\');" /></a>'
						.'<div class="shop-cart-item-details" style="margin-left:65px;"><h4 style="margin:0px;">'
						.$prod_no
						.'</h4><p style="margin:0px;"><span style="color:#999;">Style#:&nbsp;<?php echo $item; ?></span><br />Color: &nbsp; '
						.$color_name
						.(@$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : '')
						.(@$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : '')
						.'</p>'
					;
					if ($stock_status == 'preorder') {
						$html.= '<span class="badge badge-danger badge-roundless display-block"> Pre Order </span>';
					}
					if ($onsale == 'onsale') {
						$html.= '<span class="badge bg-red-mint badge-roundless display-block"> On Sale </span>';
					}
					$html.= '</div></td>';

					// Remove button
					$html.= '<td class="text-right"><button type="button" class="btn btn-link btn-xs summary-item-remove tooltips" data-original-title="Remove Item" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'" data-size_label="'
						.$size_label
						.'"><i class="fa fa-close"></i> <cite class="small hide">rem</cite></button>'
						.'</td>'
					;

					// Unit Price
					$html.= '<td class="text-right unit-price-wrapper 2 '
						.$item.' '.$prod_no
						.'" data-item="'
						.$item
						.'" data-prod_no="'
						.$prod_no
						.'">$ '
						.number_format($price, 2)
						.'</td>'
					;

					// Discount
					$disc = @$size_qty['discount'] ?: 0;
					$html.= '<td class="text-right discount-wrapper '
						.$item.' '.$prod_no
						.'">'
						.($disc == '0' ? '-' : $disc)
						.'<br />'
						.'<i class="fa fa-pencil small tooltips font-grey-silver modal-add_discount" data-original-title="Add Discount" data-placement="bottom" data-item="'
						.$item
						.'" data-size_label="'
						.$size_label
						.'"></i>'
						.'</td>'
					;

					// Extended
					$this_size_total = $this_size_qty * ($price - $disc);
					$html.= '<td class="text-right order-subtotal '
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

		$html.= '<input type="hidden" class="hidden-overall_qty" value="'.$overall_qty.'" />';
		$html.= '<input type="hidden" class="hidden-overall_total" value="'.$overall_total.'" />';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
