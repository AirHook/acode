<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addrem extends Admin_Controller {

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

		if ( ! $this->input->post('prod_no'))
		{
			// nothing more to do...
			echo '';
			//exit;
		}

		// grab the post variable
		$item = $this->input->post('prod_no');

		// set the items array
		$items_array =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get product details
		$exp = explode('_', $item);
		$this_product = $this->product_details->initialize(
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

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			$items_array[$item]['color_name'] = $this_product->color_name;
		}
		if ($this->input->post('action') == 'rem_item')
		{
			unset($items_array[$item]);
		}

		// reset session value for items array
		$this->session->set_userdata('admin_so_items', json_encode($items_array));

		// iterate through the $items_array and generate HTML
		$html = '';
		$iodd = 0;
		$overall_qty = 0;
		foreach ($items_array as $item => $size_qty)
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
			$odd_class = $iodd&1 ? '' : 'odd';

			$html.= '<div class="item-container clearfix '
				.$odd_class
				.'" style="padding:5px;"><div class="pull-right"><button type="button" class="btn btn-link btn-xs summary-item-remove-btn tooltips font-grey-cascade" data-original-title="Remove" data-item="'
				.$item
				.'"><i class="fa fa-close"></i></button></div><a href="'
				.(@$img_linesheet ?: 'javascript:;')
				.'" class="'
				.(@$img_linesheet ? 'fancybox' : '')
				.' pull-left"><img class="" src="'
				.$img_front_new
				.'" alt="" style="width:70px;height:auto;" onerror="$(this).attr(\'src\',\''
				.$this->config->item('PROD_IMG_URL')
				.'images/instylelnylogo_3.jpg\');" /></a><div class="shop-cart-item-details" style="margin-left:80px;"><h5 style="margin:0px;">'
				.$item
				.'</h5><h6 style="margin:0px;"><span style="color:#999;">Product#: '
				.$prod_no
				.'</span><br />Color: &nbsp; '
				.$color_name
				.'</h6><div class="size-and-qty-wrapper">'
			;

			$this_size_qty = 0;
			foreach ($size_names as $size_label => $s)
			{
				$qty =
					isset($size_qty[$size_label])
					? $size_qty[$size_label]
					: 0
				;
				$this_size_qty += $qty;

				if ($s != 'XXL' && $s != 'XL1' && $s != 'XL2')
				{
					$html.= '<div style="display:inline-block;font-size:0.6em;">size '
						.$s
						.' <br /><select name="size_'
						.$s
						.'" class="size-select" style="border:1px solid #'
						.($qty > 0 ? '000' : 'ccc')
						.';" data-page="create" data-item="'
						.$item
						.'">'
					;

					for ($i=0;$i<31;$i++)
					{
						$html.= '<option value="'.$i.'" '.($i == $qty ? 'selected' : '').'>'.$i.'</option>';
					}

					$html.= '<input type="hidden" class="this-total-qty '.$item.' '.$prod_no.'" value="'.$this_size_qty.'" readonly />';
					$html.= '</select></div>';
				}
			}

			$html.= '</div></div></div>';

			$iodd++;
			$overall_qty += $this_size_qty;
		}

		$html.= '<input type="hidden" class="span-items_count" name="span-items_count" value="'.$iodd.'" />';
		$html.= '<input type="hidden" class="overall-qty" name="overall-qty" value="'.$overall_qty.'" />';

		if ($html) echo $html;
		else {
			echo '<cite style="margin:30px 15px 0;display:block;">Items should show in here as soon as selected, or, searched and then selected, or, added as new item, or, after barcode scan...</cite><span class="span-items_count hide">0</span>';
		}
		exit;
	}

	// ----------------------------------------------------------------------

}
