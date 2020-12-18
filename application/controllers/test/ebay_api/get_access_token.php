<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_access_token extends MY_Controller {

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
		$user_token = "v%5E1.1%23i%5E1%23p%5E3%23f%5E0%23I%5E3%23r%5E1%23t%5EUl41XzExOkYwNzJBQjdEQkI0Nzk4MTdERUQyQjhBOEQ3RDEwOTgzXzFfMSNFXjI2MA%3D%3D";

		// post data
		// 'grant_type' from https://developer.ebay.com/api-docs/static/oauth-client-credentials-grant.html
		//$params['grant_type'] = 'authorization_code'; // client_credentials, authorization_code
		//$params['redirect_uri'] = 'Rey_Stephen_Mil-ReySteph-Instyl-wqvqxmhd';
		//$params['code'] = $user_token;

		$params = 'grant_type=authorization_code&redirect_uri=Rey_Stephen_Mil-ReySteph-Instyl-wqvqxmhd&code='.$user_token;

		//$url1 = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token'; // sandbox
		$url1 = 'https://api.ebay.com/identity/v1/oauth2/token';

		$csess1 = curl_init($url1);

		$headers = array(
			'Authorization: Basic '.$oauth_credentials,
			'Content-Type: application/x-www-form-urlencoded'
		);

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

		echo '<pre>';
		print_r($results1);
		//echo 'Response is: '.$response1;
		echo '<br />';
		echo '<br />';


		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
