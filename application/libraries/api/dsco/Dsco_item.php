<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DSCO API for getting individual item info
 * and updating small barch items
 *
 * API V3 referecne:
 * https://api.dsco.io/doc/v3/reference/
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	API, Google API
 * @author		WebGuy
 * @link
 */
class Dsco_item {

	/**
	 * DSCO SKU#
	 *
	 * @var	string
	 */
	public $dsco_sku = '';

	/**
	 * DSCO SKU#
	 *
	 * @var	string
	 */
	public $qty = 1;

	/**
	 * DSCO SKU#
	 *
	 * @var	string
	 */
	public $status = 'in-stock';


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
	public function __construct()
	{
		$this->CI =& get_instance();

		// load pertinent library/model/helpers
		$this->CI->load->library('api/dsco/dsco_auth');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Create a Mailing List via API
	 *
	 * @return	array
	 */
	public function get()
	{
		if ($this->dsco_sku == '')
		{
			// nothing more to do..
			// set return data
			$results = array(
				'status' => 'failure',
				'messages' => array(
					'description' => 'No sku data provided'
				)
			);

			// return results
			return $results;
		}

		/**
		// GET ITEM DETAILS
		*/
		// query params
		$params2 = 'itemKey=sku&value='.$this->dsco_sku;

		// start curl
		$url = $this->CI->dsco_auth->url_endpoint.'/inventory?'.$params2;
		$csess = curl_init($url);

		$headers = array(
			'Authorization: bearer '.$this->CI->dsco_auth->access_token,
			'Content-Type: application/json',
		);

		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

		// convert to array
        $results = json_decode($response, true);

		// return results
		return $results;
		// */

		/* *
		echo '<pre>';
		echo 'GET INVENTORY OBJECT cURL Response is: '.PHP_EOL;
		print_r(@$results);
		echo PHP_EOL;
		echo PHP_EOL;
		/* *
		Return Results:
		For existing items:
		Array
		(
		    [quantityAvailable] => 1
		    [sku] => D9623L-BLUSH_1
		    [status] => in-stock
		    [upc] => 710780079706
		    [warehouses] => Array
		        (
		            [0] => Array
		                (
		                    [code] => 230
		                    [quantity] => 1
		                    [dscoId] => w5d2ddb3c432c2098749248
		                    [status] => active
		                )

		        )

		    [dscoCreateDate] => 2020-03-08T13:52:06+00:00
		    [dscoLastUpdateDate] => 2021-01-07T18:14:21+00:00
		    [dscoItemId] => 1048983906
		    [dscoLastCostUpdateDate] => 2021-01-07T18:14:21+00:00
		    [dscoLastQuantityUpdateDate] => 2021-01-07T18:14:21+00:00
		    [dscoSupplierId] => 1000010891
		    [cost] => 0
		    [dscoSupplierName] => Basix
		)
		For non-existing items:
		Array
		(
		    [status] => failure
		    [requestId] => ecfcafff-aabf-40bf-9193-33f47f22ff08
		    [eventDate] => 2021-01-11T15:59:39.781Z
		    [messages] => Array
		        (
		            [0] => Array
		                (
		                    [code] => notFound
		                    [severity] => warn
		                    [description] => sku D9623L-BLUSH_1_3 not found
		                )

		        )

		)
		// */
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Update inventory and status of product at DSCO
	 *
	 * @return	void
	 */
	public function update()
	{
		if ($this->dsco_sku == '')
		{
			// nothing more to do..
			// set return data
			$results = array(
				'status' => 'failure',
				'messages' => array(
					'description' => 'No sku data provided'
				)
			);

			// return results
			return $results;
		}

		/**
		// GET ITEM DETAILS
		*/
		// post params
		// need to manually write the json object data as php json encode only does json arrays
		$params = '[ { "sku": "'.$this->dsco_sku.'", "quantityAvailable": '.$this->qty.', "status": "'.$this->status.'", "warehouses": [ { "code": "'.$this->CI->dsco_auth->warehouse_code.'", "quantity": '.$this->qty.', "status": "'.$this->status.'" } ] } ]';

		// start curl
		$url = $this->CI->dsco_auth->url_endpoint.'/inventory/batch/small';
		$csess = curl_init($url);

		$headers = array(
			'Authorization: bearer '.$this->CI->dsco_auth->access_token,
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

		// return results
		return $results;
		// */

		/* *
		Response Sample:
		{
		  "status": "success",	//  Enum: "success" "failure" "pending"
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

		Payload
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
	}

	// ----------------------------------------------------------------------

}
