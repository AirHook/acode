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

		/*
		if ( ! $this->input->post('prod_no'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variables
		//$item = '192H_GREE1';
		$item = $this->input->post('prod_no');
		$page = $this->input->post('page');
		*/

		// get the items array
		$items_array =
			$this->session->admin_po_items
			? json_decode($this->session->admin_po_items, TRUE)
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
		foreach ($items_array as $item => $options)
		{
			// get product details
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
			$vendor_price =
				isset($options['vendor_price'])
				? $options['vendor_price']
				: (@$product->vendor_price ?: 0)
			;
			$temp_size_mode = 1; // default size mode

			if ($product)
			{
				$image_new = $product->media_path.$style_no.'_f3.jpg';
				$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
				$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
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
				$size_mode = @$this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
				$color_name = $this->product_details->get_color_name($color_code);
			}

			// set some data
			$size_names = $this->size_names->get_size_names($size_mode);

			// table row
			$html.= '<tr class="summary-item-container">';

			// table col - Item IMAGE and Details
			$html.= '<td>'
				.'<a href="'
				.($img_linesheet ?: 'javascript:;')
				.'" class="'
				.($img_linesheet ? 'fancybox' : '')
				.' pull-left">'
				.'<img class="" src="'
				.$img_front_new
				.'" alt="" style="width:60px;height:auto;" onerror="$(this).attr(\'src\',\''
				.$this->config->item('PROD_IMG_URL')
				.'images/instylelnylogo_3.jpg\');" />'
				.'</a>'
				.'<div class="shop-cart-item-details" style="margin-left:65px;">'
				.'<h4 style="margin:0px;">'
				.$item
				.'</h4>'
				.'<p style="margin:0px;">'
				.'<span style="color:#999;">Style#: '
				.$item
				.'</span><br />'
				.'Color: &nbsp; '
				.$color_name
				.'</p></div></td>'
			;

			// table col - Size and Qty
			$html.= '<td class="size-and-qty-wrapper">';

			$this_size_qty = 0;
			foreach ($size_names as $size_label => $s)
			{
				$size_qty =
					! empty($options) && isset($options[$size_label])
					? $options[$size_label]
					: 0
				;
				$this_size_qty += $size_qty;

				$html.= '
					<div class="sizes" style="display:inline-block;">'
					.$s
					.'<br />'
					.'<select name="'
					.$size_label
					.'" class="size-select" style="border:1px solid #'
					.($size_qty > 0 ? '000' : 'ccc')
					.';" data-page="create" data-prod_no="'
					.$item
					.'" data-vendor_price="'
					.$vendor_price
					.'">'
				;

				for ($i=0;$i<31;$i++)
				{
					$html.= '<option value="'.$i.'" '.($i == $size_qty ? 'selected' : '').'>'.$i.'</option>';
				}

				$html.= '</select></div>';
			}

			$html.= '
				=
				<div class="sizes" style="display:inline-block;">'
				.'Total <br />'
				.'<input tpye="text" class="this-total-qty '
				.$item
				.' '
				.$prod_no
				.'" style="border:1px solid #ccc;width:30px;padding-left:5px;background-color:white;" value="'
				.$this_size_qty
				.'" readonly />'
				.'</div></td>'
			;

			// table col - Remove button
			$html.= '<td class="text-right">'
				.'<button type="button" class="btn btn-link btn-xs summary-item-checkbox tooltips" data-original-title="Remove Item" data-prod_no="'
				.$item
				.'"><i class="fa fa-close"></i> <cite class="small">rem</cite>'
				.'</button></td>'
			;

			if ($this->session->admin_po_edit_vendor_price === TRUE)
			{
				$v_price = @$options['vendor_price'] ?: $vendor_price;
			}
			else $v_price = 0;

			// table col - Unit Vendor Price
			$html.= '<td class="unit-vendor-price-wrapper" data-item="'
				.$item
				.'" data-prod_no="'
				.$prod_no
				.'" data-vendor_price="'
				.($this->session->admin_po_edit_vendor_price ?: 0)
				.'">'
				.'<div class="edit_off" style="'
				.($this->session->admin_po_edit_vendor_price === TRUE ? 'display:none;' : '')
				.'"><div class="zero-unit-vendor-price '
				.$prod_no
				.' pull-right">$ '
				.number_format($v_price, 2)
				.'</div></div>'
				.'<div class="edit_on" style="'
				.($this->session->admin_po_edit_vendor_price === TRUE ? '' : 'display:none;')
				.'"><div class="clearfix">'
				.'<div class="unit-vendor-price '
				.$prod_no
				.' pull-right" style="height:27px;width:40px;border:1px solid #ccc;padding-top:4px;padding-right:4px;text-align:right;">'
				.$v_price
				.'</div></div><div class="text-right">'
				.'<button type="button" data-prod_no="'
				.$item
				.'" class="btn btn-link btn-xs btn-edit_vendor_price" style="padding-right:0;margin-right:0;"><i class="fa fa-pencil"></i> Edit</button>'
				.'</div></div></td>'
			;

			$this_size_total =
				$this->session->admin_po_edit_vendor_price === TRUE
				? $this_size_qty * $v_price
				: 0
			;

			// table col - Subtotal
			$html.= '<td class="text-right order-subtotal '
				.$item.' '.$prod_no
				.'">$ '
				.number_format($this_size_total, 2)
				.'</td>'
				.'<input type="hidden" class="input-order-subtotal '
				.$item.' '.$prod_no
				.'" name="subtotal" value="'
				.$this_size_total
				.'" />'
			;

			// close the table row
			$html.= '</tr>';

			$i++;
			$overall_qty += $this_size_qty;
			$overall_total += $this_size_total;
		}

		$html.= '<input type="hidden" class="hidden-overall_qty" value="'
			.$overall_qty
			.'" /><input type="hidden" class="hidden-overall_total" value="'
			.$overall_total
			.'" />
		';

		if ($html) echo $html;
		else {
			echo '';
			exit;
		}
	}

	// ----------------------------------------------------------------------

}
