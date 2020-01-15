<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rem_items extends MY_Controller {

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
			echo 'false';
			exit;
		}

		// grab the post variables
		$item = $this->input->post('prod_no');
		$size = $this->input->post('size');
		$page = $this->input->post('page');

		// set the items array
		$items_array =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

		// process the item
		unset($items_array[$item][$size]);
		if (empty($items_array[$item])) unset($items_array[$item]);

		// reset session value for items array
		if ($page == 'modify')
		{
			$this->session->set_userdata('so_mod_items', json_encode($items_array));
		}
		else
		{
			$this->session->set_userdata('so_items', json_encode($items_array));
		}

		// set the cart items
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

		if (empty($items_array))
		{
			echo '<cite style="margin:30px 15px 0;display:block;">Items should show in here as soon as selected, or, searched and then selected, or, added as new item, or, after barcode scan...</cite><span class="span-items_count hide">0</span>';
		}
		else
		{
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

				$this_size_qty = 0;
				foreach ($size_qty as $size_label => $qty)
				{
					$this_size_qty += $qty;
					$s = $size_names[$size_label];

					if (
						isset($items_array[$item][$size_label])
						&& $s != 'XXL' && $s != 'XL1' && $s != 'XL2' && $s != '22'
					)
					{

						$html.= '<div class="item-container clearfix '
							.$odd_class
							.'" style="padding:5px;"><div class="pull-right"><button type="button" class="btn btn-link btn-xs summary-item-remove-btn tooltips font-grey-cascade" data-original-title="Remove" data-page="create" data-item="'
							.$item
							.'" data-size_label="'
							.$size_label
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
							.'<br />'
							.(@$product->category_names ? '<cite class="small">('.end($product->category_names).')</cite>' : '')
							.'</h6><div class="size-and-qty-wrapper margin-top-10" style="font-size:0.8em;">'
							.'size '
							.$s
							.' '
						;

						$html.= '<div style="display:inline-block;;">'
							.'<input type="text" class="size_select" data-page="create" style="border:1px solid #ccc;width:30px;margin-left:10px;text-align:right;padding:5px" data-item="'
							.$item
							.'" value="'
							.$qty
							.'" />'
						;
						$html.= '<input type="hidden" class="this-total-qty '.$item.' '.$prod_no.'" value="'.$this_size_qty.'" readonly />';
						$html.= '</div>';

						$html.= '</div></div></div>';
					}
				}

				$iodd++;
				$overall_qty += $this_size_qty;
			}

			$html.= '<input type="hidden" class="span-items_count" name="span-items_count" value="'.$iodd.'" />';
			$html.= '<input type="hidden" class="overall-qty" name="overall-qty" value="'.$overall_qty.'" />';

			if ($html) echo $html;
			else {
				echo '<cite style="margin:30px 15px 0;display:block;">Items should show in here as soon as selected, or, searched and then selected, or, added as new item, or, after barcode scan...</cite><span class="span-items_count hide">0</span>';
			}
		}
	}

	// ----------------------------------------------------------------------

}
