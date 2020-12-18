<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {

	/**
	 * Google Base URL
	 *
	 * @var	string
	 */
	protected $base_url = 'https://www.googleapis.com/content/v2.1/';

	/**
	 * Google Merchant ID
	 *
	 * @var	string
	 */
	protected $merchant_id = '6568666';


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
		//$this->load->library('accounts/account_details');

		// initialize google OAuth authorization
		//$access_token = $this->google_api->initialize();

		// user token
		$access_token = "
		v^1.1#i^1#r^0#f^0#I^3#p^3#t^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

		";

		// post data
		// 'grant_type' from https://developer.ebay.com/api-docs/static/oauth-client-credentials-grant.html
		//$params['grant_type'] = 'authorization_code'; // client_credentials, authorization_code
		//$params['code'] = $user_token;
		//$params['scope'] = urlencode('https://api.ebay.com/oauth/api_scope');
		//$params['redirect_uri'] = 'Rey_Stephen_Mil-ReySteph-Instyl-wqvqxmhd';

		// Google Content API v2.1 references (commands and request methods) for Products
		// https://developers.google.com/shopping-content/reference/rest/v2.1/products/list
		// query parameters
		//		maxResults (int) - The maximum number of products to return in the response, used for paging.
		//		pageToken (string) - The token returned by the previous request.
		/* *
		$url1 = 'https://www.googleapis.com/content/v2.1/'
			.$this->merchant_id
			.'/products?maxResults=100'
		;
		// */
		//$url1 = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token'; // sandbox
		//$url1 = 'https://api.ebay.com/identity/v1/oauth2/token';
		$url1 = 'https://api.ebay.com/sell/inventory/v1/inventory_item/D6545L';
		//$url1 = 'https://api.ebay.com/sell/inventory/v1/inventory_item';
		//$url1 = 'https://api.ebay.com/sell/inventory/v1/inventory_item/T5448_GUNM1';

		$csess1 = curl_init($url1);

		$headers = array(
			'Authorization: Bearer '.$access_token
		);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($csess1, CURLOPT_POST, true);
        //curl_setopt($csess1, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);

		echo '<pre>';
		print_r($results1);
		//echo $response1;
		echo '<br />';
		echo '<br />';


		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
