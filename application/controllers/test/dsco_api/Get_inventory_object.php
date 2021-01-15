<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_inventory_object extends MY_Controller {

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
	 * @return	array
	 */
	public function index($dsco_sku = '')
	{
		if ($dsco_sku == '')
		{
			// nothing more to do..
			// set return data
			$results = array(
				'status' => 'failure',
				'messages' => array(
					'code' => 'invalidParameters',
					'severity' => 'warn',
					'description' => 'no sky data provided'
				)
			);

			// return results
			return $results;
		}

		// load pertinent library/model/helpers
		$this->load->library('api/dsco/dsco_auth');

		/**
		// GET ITEM DETAILS
		*/
		// query params
		$params2 = 'itemKey=sku&value='.$dsco_sku;

		// start curl
		$url = $this->dsco_auth->url_endpoint.'/inventory?'.$params2;
		$csess = curl_init($url);

		$headers = array(
			'Authorization: bearer '.$this->dsco_auth->access_token,
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

}
