<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oauth extends MY_Controller {

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

		// get ebay oauth credentials
		//$oauth_credentials = base64_encode('ReySteph-InstyleN-SBX-1f785c336-b4fb021f:SBX-f785c3366a3d-ba19-4863-ba5f-84de'); // sandbox
		$oauth_credentials = base64_encode('ReySteph-InstyleN-PRD-1f785c25d-adfce627:PRD-f785c25d85e8-71a6-480a-9f3b-0c6c');

		// user token
		$user_token = "
		v^1.1#i^1#p^3#r^0#I^3#f^0#t^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
		";

		// post data
		// 'grant_type' from https://developer.ebay.com/api-docs/static/oauth-client-credentials-grant.html
		$params['grant_type'] = 'client_credentials'; // client_credentials, authorization_code
		//$params['code'] = $user_token;
		$params['scope'] = urlencode('https://api.ebay.com/oauth/api_scope/sell.inventory');
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
		$url1 = 'https://api.ebay.com/identity/v1/oauth2/token';

		$csess1 = curl_init($url1);

		$headers = array(
			'Authorization: Basic '.$oauth_credentials,
			'Content-Type: application/x-www-form-urlencoded'
		);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($csess1, CURLOPT_POST, true);
        //curl_setopt($csess1, CURLOPT_POSTFIELDS, $params);
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);

		echo '<pre>';
		//print_r($results1);
		echo 'Response is: '.$response1;
		echo '<br />';
		echo '<br />';


		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
