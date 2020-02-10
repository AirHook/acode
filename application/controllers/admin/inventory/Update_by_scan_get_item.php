<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_by_scan_get_item extends Admin_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			//redirect($this->config->slash_item('admin_folder').'sales_orders');
		}

		// generate the plugin scripts and css
		//$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('barcodes/upc_barcodes');

		$item = $this->input->post('item');
		$size_label = $this->input->post('size_label');
		$st_id = $this->input->post('st_id');

		// put all items in an array and save to session
		// scan_count_items data structure is as follows
		// $array[0] = array(<prod_no>, <size_lable>, <st_id>)
		$scan_count_items =
			$this->session->scan_count_items
			? json_decode($this->session->scan_count_items, TRUE)
			: array();
		;
		array_push($scan_count_items, array($item, $size_label, $st_id));
		$this->session->scan_count_items = json_encode($scan_count_items);

		// get product details
		$exp = explode('_', $item);
		$product = $this->product_details->initialize(
			array(
				'tbl_product.prod_no' => $exp[0],
				'color_code' => $exp[1]
			)
		);

		// set some data
		$style_no = $item;
		$prod_no = $exp[0];
		$color_code = $exp[1];

		// get size mode - '1' for default size mode
		$temp_size_mode = '1';

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
			$size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
			$color_name = $this->product_details->get_color_name($color_code);
		}

		// get size names
		$size_names = $this->size_names->get_size_names($size_mode);
		?>

		<tr class="summary-item-container <?php echo $item.' '.$size_label; ?>" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>" style="height:110px;">

			<?php
			/**********
			 * Checkbox
			 */
			?>
			<td class="text-center" style="vertical-align:top;">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $item.'|'.$size_label.'|'.$st_id; ?>" />
					<span></span>
				</label>
			</td>

			<?php
			/**********
			 * Item/Description
			 * Item IMAGE and Details
			 * Image links to product details page
			 */
			?>
			<td style="vertical-align:top;">
				<a href="<?php echo $img_linesheet; ?>" class="fancybox pull-left">
					<img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;">
				</a>
				<div class="shop-cart-item-details" style="margin-left:80px;" data-st_id="<?php echo @$product->st_id; ?>">
					<h5 style="margin:0px;">
						<?php echo $prod_no; ?>
					</h5>
					<p style="margin:0px;">
						<span style="color:#999;">Style#: <?php echo $item; ?></span><br />
						Color: &nbsp; <?php echo $color_name; ?><br />
						<?php echo 'Size '.$size_names[$size_label]; ?>
						<?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
						<?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
					</p>
				</div>
			</td>

			<?php
			/**********
			 * Scan Count
			 */
			?>
			<td class="text-center scan-count" style="vertical-align:top;">
				1
			</td>

		</tr>

		<?php
	}

	// ----------------------------------------------------------------------

	/**
	 * Remove - remove an item from list
	 *
	 * @return	void
	 */
	public function remove()
	{
		$this->output->enable_profiler(FALSE);

		$scan_count_items =
			$this->session->scan_count_items
			? json_decode($this->session->scan_count_items, TRUE)
			: array();
		;

		$item = $this->input->post('item');
		$exp = explode('|', $item);
		$key = array_search($exp, $scan_count_items);
		unset($scan_count_items[$key]);
		$final_scan_count_items = array_values($scan_count_items);

		$this->session->scan_count_items = json_encode($final_scan_count_items);

		// set flash data
		$this->session->set_flashdata('item_removed', TRUE);

		// redirect
		redirect('admin/inventory/update_by_scan', 'location');
	}

	// ----------------------------------------------------------------------

}
