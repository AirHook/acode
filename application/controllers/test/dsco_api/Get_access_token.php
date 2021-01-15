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

		// get dsco OAuth authorization
		// query data
		$params = 'grant_type=client_credentials&client_id='.$this->config->item('dsco_clientId').'&client_secret='.$this->config->item('dsco_clientSecret');

		// host url
		$url_endpoint = 'https://api.dsco.io/api/v3';

		/**
		// GET ACCESS TOKEN
		*/
		// start curl
		$url = $url_endpoint.'/oauth2/token';
		$csess = curl_init($url);

		$headers = array(
			'Content-Type: application/x-www-form-urlencoded'
		);

		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

		// convert to array
        $results = json_decode($response, true);

		// NOTE:
		// Multiple access token is ok especially for multi-threaded system
		// so we can utilize a library "get access token" for each transaction with DSCO


		/**
		// TEST HELLO WORLD
		*
		// start curl
		$url = $url_endpoint.'/hello';
		$csess1 = curl_init($url);

		$headers1 = array(
			'Connection: keep-alive',
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: bearer '.$results['access_token']
		);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers1);
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);
		// */

		// TEST Hello World is done indicatng eveything is ok


		/**
		// GET ITEM DETAILS
		*/
		// query params
		//$params2 = 'itemKey=sku&value=D9623L-BLUSH_1';startDate
		$params2 = 'startDate=2021-01-05&endDate=2021-01-07';

		// start curl
		//$url = $url_endpoint.'/inventory?'.$params2;
		$url = $url_endpoint.'/inventory/log?'.$params2;
		$csess2 = curl_init($url);

		$headers2 = array(
			'Authorization: bearer '.$results['access_token'],
			'Content-Type: application/json',
		);

		curl_setopt($csess2, CURLOPT_HTTPHEADER, $headers2);
		//curl_setopt($csess2, CURLOPT_POST, true);
        //curl_setopt($csess2, CURLOPT_POSTFIELDS, $params2);
		curl_setopt($csess2, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response2 = curl_exec($csess2);

        // close curl
        curl_close($csess2);

		// convert to array
        $results2 = json_decode($response2, true);
		// */

		// TEST Hello World is done indicatng eveything is ok

		echo '<pre>';
		echo 'GET INVENTORY PER ITEM CURL Response is: '.PHP_EOL;
		print_r($results2);
		echo PHP_EOL;
		echo PHP_EOL;



		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
