<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * eBAY API for getting User Token, Access Token, and Refresh Token
 *
 * API Docs references:
 * https://developer.ebay.com/api-docs/static/oauth-consent-request.html
 * https://developer.ebay.com/api-docs/static/oauth-auth-code-grant-request.html
 * https://developer.ebay.com/api-docs/static/oauth-refresh-token-request.html
 *
 * Link for User Token information using "Get a Token from eBay via Your Application"
 * https://developer.ebay.com/my/auth/?env=production&index=0&auth_type=oauth
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	API, Google API
 * @author		WebGuy
 * @link
 */
class Ebay_auth
{
	/**
	 * Valid
	 *
	 * @var	boolean
	 */
	public $valid = FALSE;

	/**
	 * User Token
	 *
	 * @var	string
	 */
	public $user_token = '';

	/**
	 * Access Token
	 *
	 * @var	string
	 */
	public $access_token = '';

	/**
	 * Expires In
	 *
	 * @var	int
	 */
	public $expires_in = 0;

	/**
	 * Expiration
	 *
	 * @var	int
	 */
	public $expiration = 0;

	/**
	 * Refresh Token
	 *
	 * @var	string
	 */
	public $refresh_token = '';

	/**
	 * Refresh Token Expire In
	 *
	 * @var	int
	 */
	public $refresh_token_expires_in = 0;

	/**
	 * Refresh Token Expiration
	 *
	 * @var	int
	 */
	public $refresh_token_expiration = 0;

	/**
	 * URL Host
	 *
	 * @var	int
	 */
	public $url_endpoint = '';

	/**
	 * Now
	 *
	 * @var	object
	 */
	public $now;


	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	/**
	 * DB object holder
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
		$this->CI = get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		// get access token
		$q = $this->DB->get_where('config', array('config_name' => 'ebay_access_token'));
		$r = $q->row();

		// set properties where available
		if (isset($r))
		{
			$results = json_decode($r->config_value, true);
			$this->access_token = $results['access_token'];
			$this->expires_in = $results['expires_in'];
			$this->expiration = @$results['expiration'];
			$this->refresh_token = $results['refresh_token'];
			$this->refresh_token_expires_in = $results['refresh_token_expires_in'];
			$this->refresh_token_expiration = @$results['refresh_token_expiration'];

			$this->now = time();

			if ($this->expiration < $this->now && $this->refresh_token_expiration < $this->now)
			{
				$this->valid = FALSE;
			}
			elseif ($this->expiration < $this->now && $this->refresh_token_expiration > $this->now)
			{
				$this->valid = $this->_refresh_token();
			}
			elseif ($this->expiration > $this->now && $this->refresh_token_expiration > $this->now)
			{
				$this->valid = TRUE;
			}
			else
			{
				$this->valid = FALSE;
			}
		}
		else
		{
			$this->valid = FALSE;
		}

		log_message('info', 'eBay OAuth Class loaded');
	}

	// ----------------------------------------------------------------------

	/**
	 * Refresh Access Token
	 *
	 * @return	boolean/string
	 */
	private function _refresh_token()
	{
		/* *
		if ( ! $this->valid)
		{
			// nothing more to do...
			return FALSE;
		}
		// */

		// configure the request payload
		$params = 'grant_type=refresh_token&refresh_token='.$this->refresh_token.'&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly';

		// set HTTP request headers
		$headers = array(
			'Authorization: Basic '.$this->CI->config->item('ebay_oauth_credentials'),
			'Content-Type: application/x-www-form-urlencoded'
		);

		// do the cURL
		$csess = curl_init($this->CI->config->item('ebay_url_endpoint'));

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

		// refresh token successful response
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

		if (@$results['error'])
		{
			return FALSE;
		}

		$q2 = $this->DB->get_where('config', array('config_name' => 'ebay_access_token'));
		$r2 = $q2->row();

		if (isset($r2))
		{
			// get array and update element
			$config_tokens = json_decode($r2->config_value, true);

			// update/add items
			$config_tokens['access_token'] = $results['access_token'];
			$config_tokens['expires_in'] = $results['expires_in'];
			$config_tokens['expiration'] = $results['expires_in'] + time();

			// update records
			$this->DB->set('config_value', json_encode($config_tokens));
			$this->DB->where('config_name', 'ebay_access_token');
			$this->DB->update('config');

			// update properties
			$this->access_token = $results['access_token'];
			$this->expires_in = $results['expires_in'];
			$this->expiration = $config_tokens['expiration'];

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// ----------------------------------------------------------------------

}
