<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_variant_options extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index()
	{
		//$_POST['options']['post_to_goole'] = '1';
		//$_POST['st_id'] = '5340'; // D9776L D9776L_BLAC1
		//$_POST['st_id'] = '3307'; // D9974L D7806L_BLACSILV1
		//$_POST['st_id'] = '5340'; // D9972A D9972A_GOLD1
		//$_POST['st_id'] = '5373'; // D9964L D9964L_SILVPINK1

		if ($_POST)
		{
			$post_ary = $_POST;

			// check for $options posted
			if (@$post_ary['options'])
			{
				// get variant options data
				//$this->DB->select('options');
				$this->DB->where('st_id', $post_ary['st_id']);
				$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name');
				$q1 = $this->DB->get('tbl_stock');
				$r1 = $q1->row();
				$options = json_decode($r1->options, TRUE);

				// for OPTIONS['post_to_goole'], new option item added 20201102
				// process items for OPTIONS['post_to_goole']
				// ajax scripts send only 2 values - '0', '1'
				$google_action = FALSE;
				if (@$post_ary['options']['post_to_goole'] == '0')
				{
					// post delete from google
					$google_action = 'DELETE';

					// unset both post and any previous option as well
					unset($post_ary['options']['post_to_goole']);
					unset($options['post_to_goole']);
				}
				elseif (@$post_ary['options']['post_to_goole'] == '1')
				{
					// check for previous record of 'post_to_goole'
					// and increment value for image link purposes
					// range starts from 1 to 5
					if (@$stocks_options['post_to_goole'])
					{
						$post_to_goole_val =
							($options['post_to_goole'] + 1) > 5
							? 1
							: $options['post_to_goole'] + 1
						;
					}
					else
					{
						$post_to_goole_val = 1;
					}

					// update set 'post_to_goole'
					$post_ary['options']['post_to_goole'] = $post_to_goole_val;

					// post insert/update to google
					$google_action = 'UPSERT';
				}

				// merge new options value
				// other options, simply carry on...
				$stocks_options = array_merge($options, $post_ary['options']);

				// set new options data in json form
				$post_ary['options'] = json_encode($stocks_options);
			}

			// update stock record
			$this->DB->set($post_ary);
			$this->DB->where('st_id', $post_ary['st_id']);
			$q = $this->DB->update('tbl_stock');

			// process google API if any after record update
			if ($google_action == 'UPSERT') $this->_post_to_google($r1->prod_no, $r1->color_code);
			if ($google_action == 'DELETE') $this->_remove_from_google($r1->prod_no, $r1->color_code);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * FACET Post
	 *
	 * @return	void
	 */
	public function facets()
	{
		if ($_POST)
		{
			// update stock record
			$this->DB->set($_POST);
			$this->DB->where('prod_id', $_POST['prod_id']);
			$q = $this->DB->update('tbl_product');

			echo 'Done';
		}
		else echo 'Uh oh...';
	}

	// ----------------------------------------------------------------------

	/**
	 * POST TO GOOGLE
	 *
	 * @return	void
	 */
	private function _post_to_google($prod_no, $color_code)
	{
		// google merchant center requires a main image link and add'l image links
		// create google image is already added to class Prod_image_upload
		// we just need to check if there are old items taht do not have the new images

		// load library and get product details
		$this->load->library('products/product_details');
		$product_details = $this->product_details->initialize(
			array(
				'tbl_product.prod_no' => $prod_no,
				'color_code' => $color_code
			)
		);

		// check images for all views
		$views = array('f', 'b', 's');
		foreach ($views as $view)
		{
			// set source image
			$src_image =
				$product_details->media_path
				.$product_details->prod_no.'_'.$product_details->color_code
				.'_'
				.$view
				.'.jpg'
			;

			// set new image
			$new_image =
				$product_details->media_path
				.$product_details->prod_no.'_'.$product_details->color_code
				.'_'
				.$view
				.'g'
				.(@$product_details->stocks_options['post_to_goole'] ?: '1')
				.'.jpg'
			;

			/* */
			$this->load->helper('create_google_images');
			if ($img_info = @GetImageSize($src_image))
			{
				$create = create_google_images(
					$img_info,
					$src_image,
					$new_image
				);
			}
			// */
		}

		// load library and post to google
		$this->load->library('api/google/upsert');
		$this->upsert->initialize(
			array(
				'prod_no' => $product_details->prod_no,
				'color_code' => $product_details->color_code
			)
		);
		$response = $this->upsert->go();
	}

	// ----------------------------------------------------------------------

	/**
	 * POST TO GOOGLE
	 *
	 * @return	void
	 */
	private function _remove_from_google($prod_no, $color_code)
	{
		// load library and post to google
		$this->load->library('api/google/delete');
		$this->delete->initialize(
			array(
				'prod_no' => $prod_no,
				'color_code' => $color_code
			)
		);
		$response = $this->delete->go();
	}

	// ----------------------------------------------------------------------

}
