<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	// ----------------------------------------------------------------------

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
	 * Create a Mailing List via API
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		//$this->load->library('api/google/google_api');
		$this->load->library('api/ebay/ebay_auth');

		if ( ! $this->ebay_auth->valid)
		{
			echo 'Access token no longer valid<br />';

			// let us remember the page being accessed other than index
			if (@$_GET)
			{
				// remove empty $_GET array elements
				$_GET = array_filter($_GET, function($value) { return $value !== ''; });

				foreach ($_GET as $key => $val)
				{
					$this->filter_items_count += count(explode(',', $_GET[$key]));
				}

				$get = http_build_query($_GET);

				$this->session->set_userdata('ebay_access_uri', site_url($this->uri->uri_string()).'?'.http_build_query($_GET));
			}
			else
			{
				$this->session->set_userdata('ebay_access_uri', $this->uri->uri_string());
			}

			// redirect to login page
			//redirect('admin/api/ebay_user_token', 'location');
		}

		// let's work on D6545L NAVY (D6545L_NAVY1)
		$this->load->library('products/product_details');
		$product_details = $this->product_details->initialize(
			array(
				'tbl_product.prod_no' => 'D6545L',
				'color_code' => 'NAVY1'
			)
		);

		// front image link, and, additional image links of other views
		$addlImageLinks[0] =
			$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_f.jpg'
		;
		$addlImageLinks[1] =
			$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_b.jpg'
		;
		$addlImageLinks[2] =
			$product_details->media_path
			.$product_details->prod_no.'_'.$product_details->color_code
			.'_s.jpg'
		;
		$imageLinks = array();
		foreach ($addlImageLinks as $addlImageLink)
		{
			if (file_exists($addlImageLink))
			{
				array_push($imageLinks, $this->config->item('PROD_IMG_URL').$addlImageLink);
			}
		}

		// set SKU
		// suffix is the size with available qty
		$size = '4';
		$sku = $product_details->prod_no.'_'.$product_details->color_code.'_'.$size;
		$prod_no = $product_details->prod_no;
		$color_code = $product_details->color_code;
		$color_name = $product_details->color_name;
		$qty = 1; // of specific size (in this case, size_4)
		$brand = $product_details->designer_name;
		$desc = $product_details->prod_desc ?: $product_details->prod_name;
		$title = $product_details->prod_name;

		// set payload using product details
		//$payload = '[{"availability": {"shipToLocationAvailability": {"quantity": '.$qty.'}},"condition": "NEW","product": {"aspects": {"Size": ["'.$size.'"],"Prod No": ["'.$prod_no.'"],"Color": ["'.$color_name.'"],"Color Code": ["'.$color_code.'"]},"brand": "'.$brand.'","description": "'.$desc.'","imageUrls": ["'.implode('","', $imageLinks).'"],"title": "'.$title.'"}}]';
		$payload = '{"availability": {"shipToLocationAvailability": {"quantity": '.$qty.'}},"condition": "NEW","product": {"brand": "'.$brand.'","description": "'.$desc.'","imageUrls": ["'.implode('","', $imageLinks).'"],"title": "'.$title.'"}}';

		//echo $payload;

		// uri endpoint
		$url = 'https://api.ebay.com/sell/inventory/v1/inventory_item/'.$sku; // D6545L D6626L

		// set HTTP request headers
		$headers = array(
			'Authorization: Bearer '.$this->ebay_auth->access_token,
			'Content-Type: application/json',
			'Content-Language: en-US'
		);

		$csess = curl_init($url);

		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($csess, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

		// convert to array
        $results = json_decode($response, true);

		echo '<pre>';
		print_r($results);
		//echo '...<br />';
		//echo $response;
		echo '<br />';
		echo '<br />';

		// request successful response
		//
		/*
		Array (
			[access_token] =>
			[expires_in] => 7200
			[token_type] => User Access Token
		)
		*/

		// request fail
		/*
		Array
		(
		    [errors] => Array
		        (
		            [0] => Array
		                (
		                    [errorId] => 1003
		                    [domain] => OAuth
		                    [category] => REQUEST
		                    [message] => Token type in the Authorization header is invalid:Basic
		                    [longMessage] => Token type in the Authorization header is invalid:Basic
		                )

		        )

		)
		*/


		// now let us get inventory
		// set HTTP request headers
		$headers1 = array(
			'Authorization: Bearer '.$this->ebay_auth->access_token,
			'Content-Type: application/json'
		);

		$csess1 = curl_init($url);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers1);
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($csess1, CURLOPT_HEADER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);

		echo '<pre>';
		print_r($results1);
		//echo '...<br />';
		//echo $response1;
		//var_dump($response1);
		echo '<br />';
		echo '<br />';


		/*
		https://forums.developer.ebay.com/questions/21137/seller-hub-does-not-show-inventory-items-created-t.html
		"…that Inventory SKUs created via new API Inventory API are not currently supported in UI."
		NOTE:
		The above create/update inventory is successful and the get inventory returns what was uploaded/updated.
		Still, cannot see the items at seller hub.  Bummer.
		*/


		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
