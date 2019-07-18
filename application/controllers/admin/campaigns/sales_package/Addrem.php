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
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('sales_package/sales_package_details');

		// we use local variables to be able to debug
		$sales_package_id = $this->input->post('id'); // '3'
		$prod_no = $this->input->post('prod_no'); // 'SH4114'

		// initialize properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$sales_package_id));

		// get the array of items, and add the item
		$items_array = $this->sales_package_details->items;

		// process the item
		if ($this->input->post('action') == 'add_item')
		{
			if ( ! in_array($prod_no, $items_array))
			{
				array_push($items_array, $prod_no);
			}
		}
		if ($this->input->post('action') == 'rem_item')
		{
			if (($key = array_search($prod_no, $items_array)) !== false) {
				unset($items_array[$key]);
			}
			$items_array = array_values($items_array);
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// udpate the sales package items...
		$DB->set('sales_package_items', json_encode($items_array));
		$DB->set('last_modified', time());
		$DB->where('sales_package_id', $sales_package_id);
		$q = $DB->update('sales_packages');

		// RE-initialize properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$sales_package_id));

		// create and echo the html output
		foreach ($items_array as $product)
		{
			// get product details
			$this->product_details->initialize(array('tbl_product.prod_no'=>$product));

			// set image paths
			$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
			$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
			// the image filename
			$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
			// the new way relating records with media library
			$img_front_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg';
			$img_back_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_b3.jpg';
			?>

			<div class="thumb-tile package image bg-blue-hoki <?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?> <?php echo ($this->product_details->publish == '0' OR $this->product_details->publish == '3') ? 'mt-element-ribbon' : ''; ?> selected" data-sku="<?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>">

				<?php if ($this->product_details->publish == '0' OR $this->product_details->publish == '3') { ?>
				<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="top" data-container="body" data-original-title="Unpubished" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
					<i class="fa fa-ban"></i>
				</div>
				<?php } ?>
				<div class="corner"> </div>
				<div class="check"> </div>
				<div class="tile-body">
					<img class="img-b" src="<?php echo ($this->product_details->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
					<img class="img-a" src="<?php echo ($this->product_details->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
				</div>
				<div class="tile-object">
					<div class="name"> <?php echo $this->product_details->prod_no; ?> </div>
				</div>

			</div>

			<?php
		}

		echo '<input type="hidden" id="items_count" name="items_count" value="'.$this->sales_package_details->items_count.'" />';
	}

	// ----------------------------------------------------------------------

}
