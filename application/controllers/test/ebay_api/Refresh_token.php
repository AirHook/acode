<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh_token extends MY_Controller {

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

		// Target endpoint
		//$url1 = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token'; // sandbox
		$url1 = 'https://api.ebay.com/identity/v1/oauth2/token';

		// get ebay oauth credentials
		//$oauth_credentials = base64_encode('ReySteph-InstyleN-SBX-1f785c336-b4fb021f:SBX-f785c3366a3d-ba19-4863-ba5f-84de'); // sandbox
		$oauth_credentials = base64_encode('ReySteph-InstyleN-PRD-1f785c25d-adfce627:PRD-f785c25d85e8-71a6-480a-9f3b-0c6c');

		// refresh token
		// taken from when gettin access token
		$refresh_token = "v^1.1#i^1#I^3#p^3#f^0#r^1#t^Ul4xMF84OjhBNEQwOTA0QjBDRDZGQzc1QjYzNDIwMkY4MDI0MjhCXzFfMSNFXjI2MA==";

		// configure the request payload
		$params = 'grant_type=refresh_token&refresh_token='.$refresh_token.'&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly';


		// set HTTP request headers
		$headers = array(
			'Authorization: Basic '.$oauth_credentials,
			'Content-Type: application/x-www-form-urlencoded'
		);

		// do the cURL
		$csess1 = curl_init($url1);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess1, CURLOPT_POST, true);
        curl_setopt($csess1, CURLOPT_POSTFIELDS, $params);
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);

		// refresh token successful response
		// new access token valid for 2 hours
		/*
		Array (
			[access_token] =>
			[expires_in] => 7200
			[token_type] => User Access Token
		)
		*/

		// refresh token request fail
		/*
		Array
		(
		    [error] => invalid_grant
		    [error_description] => the provided authorization refresh token is invalid or was issued to another client
		)
		*/

		echo '<pre>';
		print_r($results1);
		//echo 'Response is: '.$response1;
		echo '<br />';
		echo '<br />';


		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
