<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_google_image extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index Page for this controller.
	 *
	 * @return string
	 */
	public function index()
	{
		$DB = $this->load->database('instyle', TRUE);

		$post_ary['options']['post_to_goole'] = '1';

		// get variant options data
		//$DB->select('options');
		$DB->where('st_id', '15');
		$q1 = $DB->get('tbl_stock');
		$r1 = $q1->row();
		$options = json_decode($r1->options, TRUE);

		// merge new options value
		$stocks_options = array_merge($options, $post_ary['options']);

		// set new options data
		$post_ary['options'] = json_encode($stocks_options);

		$this->load->library('products/product_details');
		$product_details = $this->product_details->initialize(
			array(
				'tbl_product.prod_id' => $r1->prod_id
			)
		);
		$fimage =
			.$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_f.jpg'
		;
		if ( ! file_exists($fimage))
		{
			echo 'not there';
		}
		else echo 'there';

		echo '<pre>';
		echo $fimage;
		die();

		$prod_no = 'D7806L';
		$img_name = 'D7806L_BLACSILV1';
		$img_path = 'uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/';
		$src_image = $img_path.$img_name.'_f.jpg';

				/* *
				// let's resize the product image first
				$this->load->library('image_lib');
				$config['image_library']	= 'gd2';
				$config['quality']			= '100%';
				$config['source_image'] 	= $src_image;
				$config['new_image'] 		= $img_path.$img_name.'_fg_temp.jpg';
				$config['maintain_ratio'] 	= TRUE;
				$config['width']         	= 160;
				$config['height']       	= 240;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				// */

		$new_image = $img_path.$img_name.'_fg_02.jpg';
		$prod_image = $src_image;

		// create linesheet
		/* */
		$this->load->helper('create_google_images');
		if ($img_info = GetImageSize($src_image))
		{
			$create = create_google_images(
				$img_info,
				$src_image,
				$new_image
			);
		}
		// */
	}
}
