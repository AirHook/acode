<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_item extends MY_Controller {

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

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variable
		$item = $this->input->post('prod_no');
		$page = $this->input->post('page');
		$barcode = $this->input->post('barcode');

		if ($barcode)
		{
			$st_id = ltrim($barcode[6].$barcode[7].$barcode[8].$barcode[9], '0');
		}

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// process data and set HTML
		$html = '';

		// get product details
		if ($item)
		{
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);
			$prod_no = $exp[0];
			$color_code = $exp[1];
		}
		elseif ($st_id)
		{
			$product = $this->product_details->initialize(
				array(
					'tbl_stock.st_id' => $st_id
				)
			);
			$item = $product->prod_no.'_'.$product->color_code;
			$prod_no = $product->prod_no;
			$color_code = $product->color_code;
		}

		// set dome data
		$style_no = $item;
		$temp_size_mode = 1; // default size mode

		if ($product)
		{
			$image_new = $product->media_path.$style_no.'_f.jpg';
			$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
			$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
			$size_mode = $product->size_mode;
			$color_name = $product->color_name;

			// take any existing product's size mode
			$temp_size_mode = $product->size_mode;

			// price
			$price = $product->wholesale_price;
			$sale_price = $product->wholesale_price_clearance;
			$line_thru = $product->custom_order == '3' ? 'text-decoration:line-through;' : '';
			$hide_sale_price = $product->custom_order == '3' ? '' : 'hide';
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
		// = $iodd&1 ? '' : 'odd';

		$html.= '<input type="hidden" id="size-select-prod_no" name="size-select-prod_no" value="'.$item.'" />';
		$html.= '<input type="hidden" id="size-select-page" name="size-select-page" value="'.($page ?: 'create').'" />';

		$html.= '<div class="item-container clearfix '
			//.$odd_class
			.'" style="padding:5px;"><div class="pull-right"><button type="button" class="btn btn-link btn-xs summary-item-remove-btn tooltips font-grey-cascade hide" data-original-title="Remove" data-page="create" data-item="'
			.$item
			.'"><i class="fa fa-close"></i></button></div><a href="'
			.(@$img_linesheet ?: 'javascript:;')
			.'" class="'
			.(@$img_linesheet ? 'fancybox' : '')
			.' pull-left"><img class="" src="'
			.$img_front_new
			.'" alt="" style="width:340px;height:510px;" onerror="$(this).attr(\'src\',\''
			.$this->config->item('PROD_IMG_URL')
			.'images/instylelnylogo_3.jpg\');" /></a><div class="modal-shop-cart-item-details" style="margin-left:350px;"><h4 style="margin:0px;">'
			.$item
			.'</h4><h6 style="margin:0px;"><span style="color:#999;">Product#: '
			.$prod_no
			.'</span><br />Color: &nbsp; '
			.$color_name
			.'<br style="margin-bottom:10px;" />'
			.'PRICE: $ <span style="'.$line_thru.'">'.number_format($price, 2).'</span> &nbsp; <span class="'.$hide_sale_price.' font-red-flamingo">[ON SALE] $ '.number_format($sale_price, 2).'</span>'
			.'</h6><br />'
		;

		$html.= '<div class="size-and-qty-wrapper">AVAILABLE STOCK<br />';

		//$this_size_qty = 0;
		foreach ($size_names as $size_label => $s)
		{
			// level 2 users, do not show zero stock sizes
			if ($product->$size_label === '0') continue;

			$qty = 0;
				//isset($size_qty[$size_label])
				//? $size_qty[$size_label]
				//: 0
			//;
			//$this_size_qty += $qty;

			/**********
			 * Available Qty
			 */
			if ($s != 'XL1' && $s != 'XL2')
			{
				$html.= '<div style="display:inline-block;font-size:85%;">size '
					.$s
					.' <br /><select class="stock-select" style="border:1px solid #ccc;" disabled>'
					.'<option>'
					.$product->$size_label
					.'</option></select></div>';
			}
		}

		$html.= '</div><br /><br />';

		$html.= '<div class="size-and-qty-wrapper hide">SELECT SIZES AND QUANTITIES AND ADD TO SALES ORDER<br /><cite class="small hide">NOTE: Items with no stock are PRE-ORDER and should be sent in separate orders to customer and factory.<br /><br /></cite>';

		//$this_size_qty = 0;
		foreach ($size_names as $size_label => $s)
		{
			// level 2 users, do not show zero stock sizes
			if ($product->$size_label === '0') continue;

			$qty = 0;
				//isset($size_qty[$size_label])
				//? $size_qty[$size_label]
				//: 0
			//;
			//$this_size_qty += $qty;

			/**********
			 * Select Size Qty
			 */
			if ($s != 'XL1' && $s != 'XL2')
			{
				$html.= '<div style="display:inline-block;font-size:85%;">size '
					.$s
					.' <br /><select name="'
					.$size_label
					.'" class="size-select" style="border:1px solid #'
					.($qty > 0 ? '000' : 'ccc')
					.';" data-page="create" data-item="'
					.$item
					.'">'
				;

				// level 2 users, must see max qty equivalent to availabel stock
				for ($i=0;$i<=$product->$size_label;$i++)
				{
					$html.= '<option value="'.$i.'" '.($i == $qty ? 'selected' : '').'>'.$i.'</option>';
				}

				//$html.= '<input type="hidden" class="this-total-qty '.$item.' '.$prod_no.'" value="'.$this_size_qty.'" readonly />';
				$html.= '</select></div>';
			}
		}

		$html.= '</div>';

		$html.= '</div></div>';

		if ($html) echo $html;
		else {
			echo '<p>Ooops... We are unable to find the item. Please try again. </p>';
		}
		exit;
	}

	// ----------------------------------------------------------------------

}
