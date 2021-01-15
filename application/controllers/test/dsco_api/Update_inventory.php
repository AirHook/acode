<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_inventory extends MY_Controller {

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
	 * Update inventory and status of product at DSCO
	 *
	 * @return	void
	 */
	public function index($dsco_sku = 'D9484AD-IVORY_2', $qty = 2, $status = 'in-stock')
	{
		if ($dsco_sku == '' OR $qty == 0)
		{
			// nothing more to do..
			// set flashdata
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			//redirect('admin/marketing/carousel/carousels', 'location');
			exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('api/dsco/dsco_auth');

		/**
		// GET ITEM DETAILS
		*/
		// post params
		// need to manually write the json object data as php json encode only does json arrays
		$params = '[ { "sku": "'.$dsco_sku.'", "quantityAvailable": '.$qty.', "status": "'.$status.'", "warehouses": [ { "code": "'.$this->dsco_auth->warehouse_code.'", "quantity": '.$qty.', "status": "'.$status.'" } ] } ]';

		// start curl
		$url = $this->dsco_auth->url_endpoint.'/inventory/batch/small';
		$csess = curl_init($url);

		$headers = array(
			'Authorization: bearer '.$this->dsco_auth->access_token,
			'Content-Type: application/json',
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
		// */

		if (@$results['status'] != 'pending')
		{
			// set flashdata
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			//redirect('admin/marketing/carousel/carousels', 'location');
			echo 'Uh oh...'.PHP_EOL;
			echo '<pre>';
			echo 'UPDATE SMALL BATCH cURL Response is: '.PHP_EOL;
			print_r(@$results);
			exit;
		}

		echo '<pre>';
		echo 'UPDATE SMALL BATCH cURL Response is: '.PHP_EOL;
		print_r(@$results);
		echo PHP_EOL;
		echo PHP_EOL;
		/* *
		Response Sample:
		{
		  "status": "success",
		  "requestId": "string",
		  "eventDate": "2019-08-24T14:15:22Z",
		  "messages": [
		    {
		      "code": "string",
		      "severity": "info",
		      "description": "string"
		    }
		  ]
		}

		[
		  {
		    "sku": "string",
		    "dscoItemId": "string",
		    "upc": "string",
		    "ean": "string",
		    "mpn": "string",
		    "isbn": "string",
		    "gtin": "string",
		    "partnerSku": "string",
		    "partnerSkuMap": [
		      {
		        "partnerSku": "string",
		        "dscoRetailerId": "string",
		        "dscoTradingPartnerId": "string"
		      }
		    ],
		    "warehouses": [
		      {
		        "code": "string",
		        "dscoId": "string",
		        "retailerCode": "string",
		        "quantity": 0,
		        "cost": 0,
		        "status": "string"
		      }
		    ],
		    "quantityAvailable": 0,
		    "cost": 0,
		    "status": "in-stock",
		    "estimatedAvailabilityDate": "2019-08-24T14:15:22Z",
		    "quantityOnOrder": 0,
		    "currencyCode": "string",
		    "dscoSupplierId": "string",
		    "dscoSupplierName": "string",
		    "dscoTradingPartnerId": "string",
		    "dscoTradingPartnerName": "string",
		    "dscoCreateDate": "2019-08-24T14:15:22Z",
		    "dscoLastQuantityUpdateDate": "2019-08-24T14:15:22Z",
		    "dscoLastCostUpdateDate": "2019-08-24T14:15:22Z",
		    "dscoLastUpdateDate": "2019-08-24T14:15:22Z"
		  }
		]
		// */

		/**
		// GET CHANGE LOG
		*/
		/* *
		// Developers should use the streams API to retrieve InventoryChangeLog data
		// to determine what happened by using the requestId returned from this API
		// as each corresponding entry in the change log will include the requestId.

		// query params
		//$params2 = 'itemKey=sku&value=D9623L-BLUSH_1';startDate
		//$params2 = 'startDate=2021-01-05&endDate=2021-01-08';
		$params2 = 'requestId='.$results['requestId'];
		//$params2 = 'ea7b892b-0e03-48c3-bdbc-b091993960fd';

		// start curl
		$url = $this->dsco_auth->url_endpoint.'/inventory/log?'.$params2;
		$csess2 = curl_init($url);

		$headers2 = array(
			'Authorization: bearer '.$this->dsco_auth->access_token,
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

		echo '<pre>';
		echo 'GET CHANGE LOG cURL Response is: '.PHP_EOL;
		print_r($results2);
		echo PHP_EOL;
		echo PHP_EOL;
		// */
	}

	// ----------------------------------------------------------------------

}
