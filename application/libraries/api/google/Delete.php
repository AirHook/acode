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
class Delete
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

		$offerId = $product_details->prod_no.'_'.$product_details->color_code;
		$product_id = 'online:en:US:'.$offerId;

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
			.'/products/'
			.$product_id
		;
		$csess = curl_init($url);

		$headers = array(
			'Authorization: Bearer '.$access_token
		);

		//curl_setopt($csess, CURLOPT_POST, TRUE);
		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($csess, CURLOPT_CUSTOMREQUEST, "DELETE");
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
