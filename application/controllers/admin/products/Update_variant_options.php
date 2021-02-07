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
		/*
		items in post data
		$_POST['st_id'] = '5907';
			$_POST['prod_id']
			$_POST['prod_no']
			$_POST['color_name']
			$_POST['color_code'] // not used here
			$_POST['new_color_publish'] // 1,0
			*/

		if ($_POST)
		{
			$post_ary = $_POST;
			unset($post_ary['color_code']);

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
				$delete_index = 0;
				if (@$post_ary['options']['post_to_goole'] == '0')
				{
					// grab image link index
					$delete_index = $options['post_to_goole'];

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

				// for OPTIONS['post_to_dsco'], new option item added 20201102
				// process items for OPTIONS['post_to_dsco']
				// ajax scripts send only 2 values - '0' or the dsco sky#, for ex, 'D9623L-BLUSH' without the suffix for the size
				if (isset($post_ary['options']['post_to_dsco']))
				{
					if ($post_ary['options']['post_to_dsco'] == '0')
					{
						// set action to DSCO
						$dsco_status = 'out-of-stock';
						$dsco_sku = trim($post_ary['options']['dsco_sku']);

						// unset both post and any previous option of the same index as well
						unset($post_ary['options']['post_to_dsco']);
						unset($options['post_to_dsco']);
					}
					else
					{
						// set action to DSCO
						$dsco_status = 'in-stock';
						$dsco_sku = trim($post_ary['options']['post_to_dsco']);
					}

					// process DSCO API
					$results = $this->_post_to_dsco($dsco_sku, $dsco_status, $r1->color_code, $post_ary['prod_no']);

					// for post to dsco, set flashdata array
					$this->session->set_flashdata('success', $results);
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
			$this->DB->update('tbl_stock');

			// some return data for when debugging script at the page
			if ( ! $this->DB->affected_rows())
			{
				echo 'Failed';
			}
			else echo 'Success';

			// process google API if any after record update
			if (@$google_action == 'UPSERT')
			{
				$post_to_goole = $this->_post_to_google($r1->prod_no, $r1->color_code);

				if ($post_to_goole === FALSE)
				{
					// unset options['post_to_goole']
					// get variant options data
					$this->DB->where('st_id', $post_ary['st_id']);
					$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name');
					$q1 = $this->DB->get('tbl_stock');
					$r1 = $q1->row();
					$options = json_decode($r1->options, TRUE);
					// unset options['post_to_goole']
					unset($options['post_to_goole']);
					$this_post_ary['options'] = json_encode($options);
					// update stock record
					$this->DB->set($this_post_ary);
					$this->DB->where('st_id', $post_ary['st_id']);
					$q = $this->DB->update('tbl_stock');
				}
			}
			if (@$google_action == 'DELETE') $this->_remove_from_google($r1->prod_no, $r1->color_code, $delete_index);
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

		// check for available stocks
		// load library and get available sizes
		$this->load->model('get_sizes_by_mode');
		$get_size = $this->get_sizes_by_mode->get_sizes($product_details->size_mode);
		$this->load->model('get_product_stocks');
		$check_stock = $this->get_product_stocks->get_stocks($product_details->prod_no, $product_details->color_name);
		$available_sizes = array();
		foreach ($get_size as $size)
		{
			// we need to set the prefix for the size lable
			if($size->size_name == 'XS' || $size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2' || $size->size_name == 'S-M' || $size->size_name == 'M-L' || $size->size_name == 'ONE-SIZE-FITS-ALL')
			{
				$size_stock = 'available_s'.strtolower($size->size_name);
				$admin_size_stock = 'admin_s'.strtolower($size->size_name);
			}
			else
			{
				$size_stock = 'available_'.$size->size_name;
				$admin_size_stock = 'admin_'.$size->size_name;
			}
			$max_available =
				(
					@$product_details->stocks_options['clearance_consumer_only'] == '1'
					OR @$product_details->stocks_options['admin_stocks_only'] == '1'
				)
				? $check_stock[$size_stock] + $check_stock[$admin_size_stock]
				: $check_stock[$size_stock]
			;

			if ($max_available > 0) array_push($available_sizes, $size->size_name);
		}
		if (empty($available_sizes))
		{
			$this->error_message = "Not enough stock quantity.";

			return FALSE;
		}

		// make sure product is public
		if (
			$product_details->publish != '1'
			OR $product_details->new_color_publish != '1'
		)
		{
			$this->error_message = "Item not PUBLIC.";

			return FALSE;
		}

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
			if (ENVIRONMENT != 'development')
			{
				$this->load->helper('create_google_images');
				if ($img_info = @GetImageSize($src_image))
				{
					$create = create_google_images(
						$img_info,
						$src_image,
						$new_image
					);
				}
			}
			// */
		}

		// load library and post to google
		if (ENVIRONMENT != 'development')
		{
			$this->load->library('api/google/upsert');
			$this->upsert->initialize(
				array(
					'prod_no' => $product_details->prod_no,
					'color_code' => $product_details->color_code
				)
			);
			$response = $this->upsert->go();
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * POST TO GOOGLE
	 *
	 * @return	void
	 */
	private function _remove_from_google($prod_no, $color_code, $delete_index)
	{
		// load library and post to google
		if (ENVIRONMENT != 'development')
		{
			$this->load->library('api/google/delete');
			$this->delete->initialize(
				array(
					'prod_no' => $prod_no,
					'color_code' => $color_code
				)
			);
			$response = $this->delete->go($delete_index);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * POST / UPDATE TO DSCO
	 *
	 * @return	void
	 */
	private function _post_to_dsco($dsco_sku, $dsco_status, $color_code, $prod_no)
	{
		// load library and post to dsco
		if (ENVIRONMENT != 'development')
		{
			// load pertinent library/model/helpers
			$this->load->library('api/dsco/dsco_item');

			// get product details
			$dsco_prod_details = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $prod_no,
					'color_code' => $color_code
				)
			);

			$ii = -1;
			for ($i = 1; $i <= 9; $i++)
			{
				// check if item exists at dsco
				$this->dsco_item->dsco_sku = $dsco_sku.'_'.$i;
				$dsco_get = $this->dsco_item->get();

				if ($dsco_get['status'] != 'failure')
				{
					$this->dsco_item->status = $dsco_status;

					if ($dsco_status == 'out-of-stock')
					{
						$this->dsco_item->qty = 0;
					}
					else
					{
						if ($dsco_prod_details->size_mode == '1') $size_label = 'available_'.($i + $ii);
						else
						{
							switch ($i)
							{
								case '1':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sxs';
									if ($dsco_prod_details->size_mode == '2') $size_label = 'available_sprepack1221';
									if ($dsco_prod_details->size_mode == '3') $size_label = 'available_ssm';
									if ($dsco_prod_details->size_mode == '4') $size_label = 'available_sonesizefitsall';
								break;
								case '2':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_ss';
									if ($dsco_prod_details->size_mode == '3') $size_label = 'available_sml';
								break;
								case '3':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sm';
								break;
								case '4':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sl';
								break;
								case '5':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sxl';
								break;
								case '6':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sxxl';
								break;
								case '7':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sxl1';
								break;
								case '8':
									if ($dsco_prod_details->size_mode == '0') $size_label = 'available_sxl2';
								break;
							}
						}

						$this->dsco_item->qty = $dsco_prod_details->$size_label;
						if ($dsco_prod_details->$size_label == 0) $this->dsco_item->status = 'out-of-stock';
					}

					$dsco_udpate = $this->dsco_item->update();
				}

				$ii++;
			}
		}
	}

	// ----------------------------------------------------------------------

}
