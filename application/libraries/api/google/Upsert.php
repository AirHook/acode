<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Google API for Content Shopping - INSERT/UPDATE Product
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	API, Google API
 * @author		WebGuy
 * @link
 */
class Upsert
{
	/**
	 * Prod No
	 *
	 * @var	string
	 */
	protected $prod_no;

	/**
	 * Color Code
	 *
	 * @var	string
	 */
	protected $color_code;

	/**
	 * Error Message
	 *
	 * @var	string
	 */
	protected $error_message;


	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct(array $params = array())
	{
		$this->CI = get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Google API for Content Shopping - Insert/Update Products loaded');
    }

	// ----------------------------------------------------------------------

	/**
	 * Initialize Access Token
	 *
	 * To initialize OAuth authorization from google API
	 *
	 * @return	boolean/string
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// initialize properties
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}

		return $this;
	}

	// ----------------------------------------------------------------------

	/**
	 * INSERT/UPDATE Product to Google
	 *
	 * @return	boolean/string
	 */
	public function go()
	{
		// a primary requirement for initialization to complete
		if ( ! $this->prod_no OR ! $this->color_code)
		{
			$this->error_message = "Missing parameter.";

			return FALSE;
		}

		// load library and get product details
		$this->CI->load->library('products/product_details');
		$product_details = $this->CI->product_details->initialize(
			array(
				'tbl_product.prod_no' => $this->prod_no,
				'color_code' => $this->color_code
			)
		);
		if ( ! $product_details)
		{
			$this->error_message = "Invalid Product Number.";

			return FALSE;
		}

		// process some varaiables
		// product details link (shop details)
		$link =
			$this->CI->config->item('PROD_IMG_URL')
			.'shop/details/'
			. $product_details->d_url_structure . '/'
			. $product_details->prod_no. '/'
			. str_replace(' ','-',strtolower(trim($product_details->color_name))). '/'
			. str_replace(' ','-',strtolower(trim(($product_details->prod_name ?: $product_details->prod_no))))
			.'.html'
		;

		// front image link, and, additional image links of other views
		$imageLink =
			$this->CI->config->item('PROD_IMG_URL')
			.$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_fg'
			.$product_details->stocks_options['post_to_goole']
			.'.jpg'
		;
		$addlImageLinks[0] =
			$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_bg'
			.$product_details->stocks_options['post_to_goole']
			.'.jpg'
		;
		$addlImageLinks[1] =
			$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_sg'
			.$product_details->stocks_options['post_to_goole']
			.'.jpg'
		;
		$additionalImageLinks = array();
		foreach ($addlImageLinks as $addlImageLink)
		{
			if (file_exists($addlImageLink))
			{
				array_push($additionalImageLinks, $this->CI->config->item('PROD_IMG_URL').$addlImageLink);
			}
		}

		// get and set sales price if any...
		if (
			$product_details->custom_order === '3'
			OR @$product_details->stocks_options['clearance_consumer_only'] == '1'
			OR @$product_details->stocks_options['admin_stocks_only'] == '1'
		)
		{
			$params['salePrice'] = array(
				'value' => $product_details->retail_sale_price,
				'currency' => 'USD'
			);
		}

		// load library and get available sizes
		$this->CI->load->model('get_sizes_by_mode');
		$get_size = $this->CI->get_sizes_by_mode->get_sizes($product_details->size_mode);
		$this->CI->load->model('get_product_stocks');
		$check_stock = $this->CI->get_product_stocks->get_stocks($product_details->prod_no, $product_details->color_name);
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
		$available_sizes = implode('/', $available_sizes);

		// set api parameters
		$params['channel'] = 'online';
		$params['contentLanguage'] = 'en';
		$params['targetCountry'] = 'US';
		$params['offerId'] = $this->prod_no.'_'.$this->color_code;
		$params['kind'] = 'content#product';
		$params['title'] = $product_details->prod_name.' ('.$this->prod_no.')';
		$params['description'] = $product_details->prod_desc;
		$params['link'] = $link;
		$params['imageLink'] = $imageLink;
		$params['additionalImageLinks'] = $additionalImageLinks;
		$params['availability'] = 'In Stock';
		$params['brand'] = $product_details->designer_name;
		$params['color'] = $product_details->color_name;
		$params['price'] = array(
			'value' => $product_details->retail_price,
			'currency' => 'USD'
		);
		$params['sizes'] = [$available_sizes];	// forward slash separated sizes
		// hide this for now
		/* *
		$params['shippingWeight'] = array(
			'value' => '2',
			'unit' => 'lbs'
		);
		// */

		// get access token
		$this->CI->load->library('api/google/google_api');
		$access_token = $this->CI->google_api->initialize();

		// Google Content API v2.1 references (commands and request methods) for Products
		// https://developers.google.com/shopping-content/reference/rest/v2.1/products/list
		// query parameters
		//		maxResults (int) - The maximum number of products to return in the response, used for paging.
		//		pageToken (string) - The token returned by the previous request.
		/* */
		$url = 'https://www.googleapis.com/content/v2.1/'
			.$this->CI->config->item('google_merchant_id')
			.'/products'
		;
		$csess = curl_init($url);

		$headers = array(
			'Authorization: Bearer '.$access_token,
			'Content-Type: application/json'
		);

		curl_setopt($csess, CURLOPT_POST, TRUE);
        curl_setopt($csess, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($csess, CURLOPT_HEADER, TRUE);

		// get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

		return $response;
		// */
    }

	// ----------------------------------------------------------------------

}
