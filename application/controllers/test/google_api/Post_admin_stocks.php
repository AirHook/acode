<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_admin_stocks extends MY_Controller {

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
		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');

		// set some variables
		$page = 1;
		$limit = 200;
		$offset = $page == '' ? 0 : ($page * 100) - 100;

		$where['tbl_product.publish'] = '1';
		$where['tbl_stock.options LIKE'] = '"admin_stocks_only":"1"';
		$where['tbl_stock.new_color_publish'] = '1';

		// get the products list and total count
		$params['with_stocks'] = FALSE; // Show all with and without stocks
		$params['group_products'] = FALSE; // group per product number or per variant (on this set)
		$params['special_sale'] = FALSE; // special sale items only
		$params['pagination'] = $page; // get all in one query
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			// where conditions
			$where,
			// sorting conditions
			array(
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			// limits
			$limit
		);
		$count_all = $this->products_list->count_all;
		$products_count = $this->products_list->row_count;

		echo '<pre>'; // ------------------------>

		$i = 1;
		foreach ($products as $product)
		{
			$existing = array(
				'D9974L', 'D7473L', 'D9755L', 'D8953L', 'D6045L', 'D8334L',
				'D9894L', 'D8980L', 'D9862L', 'D9173L', 'D6083L', 'D8667L',
				'D9841L', 'D8589L', 'D9944L', 'D9242L', 'D6588L', 'D8673L',
				'D9534L', 'D9123L', 'D7807L', 'D9267L', 'D7079L', 'D8680L',
				'D7138L', 'D9319L', 'D8514L', '0395', 'D7319L', 'D8770L',
				'D9117L', 'D9554L', 'D8666L', 'D6025L', 'D7361A', 'D8819L',
				'D8996L', 'D9098L', 'D9107L', 'D9189L', 'D9236L', 'D9266L',
				'D9305L', 'D9372L', 'D9418L', 'D9463L', 'D9533L', 'D9552L',
				'D9575L', 'D9587L', 'D9611L', 'D9620L', 'D9655L', 'D9660L',
				'D9738L', 'D9761A', 'D9763A', 'D9776A',
				'D9776L'
			);

			if (in_array($product->prod_no, $existing))
			{
				continue;
			}

			echo $i.'. '.$product->prod_no.'<br />'; // ------------------------>

			$product_details = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $product->prod_no,
					'color_code' => $product->color_code
				)
			);

			// grab stocks options
			$stocks_options = $product_details->stocks_options;

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
				// nothing more to do...
				continue;
			}

			// set post_to_goole option
			$stocks_options['post_to_goole'] = '2';

			// check and create images for all views
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
					.$stocks_options['post_to_goole']
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

			// encode data
			$post_ary['options'] = json_encode($stocks_options);

			/* */
			// update stock record
			$this->DB->set($post_ary);
			$this->DB->where('st_id', $product_details->st_id);
			$this->DB->update('tbl_stock');
			// */

			/* */
			// load library and post to google
			$this->load->library('api/google/upsert');
			$this->upsert->initialize(
				array(
					'prod_no' => $product_details->prod_no,
					'color_code' => $product_details->color_code
				)
			);
			$response = $this->upsert->go();
			// */

			echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.$product_details->color_name.' - '; // ------------------------>
			echo implode('/', $available_sizes).'<br />'; // ------------------------>
			echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; IMAGES and $stocks_options["post_to_goole"] set<br />'; // ------------------------>
			echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.@$response.'<br />'; // ------------------------>

			$i++;
		}

		echo '<br />Done';
	}

	// ----------------------------------------------------------------------

}
