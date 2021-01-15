<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DSCO API for getting Access Token
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
class Dsco_auth
{

	/**
	 * Access Token
	 *
	 * @var	string
	 */
	public $access_token = '';

	/**
	 * Expiration
	 *
	 * @var	int
	 */
	public $expires_in = 0;

	/**
	 * URL Host
	 *
	 * @var	int
	 */
	public $url_endpoint = 'https://api.dsco.io/api/v3';

	/**
	 * Warehouse Code
	 * Currently using only 1 warehouse at DSCO whose code is 230
	 * Can be multiple warehouses at DSCO depending on setup
	 *
	 * @var	int
	 */
	public $warehouse_code = '230';


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
		$this->CI = get_instance();

		// get dsco OAuth authorization
		// query data
		$params = 'grant_type=client_credentials&client_id='.$this->CI->config->item('dsco_clientId').'&client_secret='.$this->CI->config->item('dsco_clientSecret');

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

		// successful return result
		/*
		{
 			"access_token":"eyJz9sdfsdfsdfsd",
  			"token_type":"Bearer",
  			"expires_in":3600
		}
		// */

		$this->access_token = @$results['access_token'] ?: '';
		$this->expires_in = @$results['expires_in'] ?: 0;
	}

	// ----------------------------------------------------------------------

}
