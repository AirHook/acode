<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebay_user_token extends MY_Controller {

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
		$this->load->library('api/ebay/ebay_auth');

		// let us remember the page being accessed other than this ebay
		// $this->session->ebay_access_uri

		if ($this->ebay_auth->valid)
		{
			$this->data['got_user_token'] = TRUE;
		}
		else
		{
			if ($this->input->get('code'))
			{
				// sample expected query string on $_GET
				// ?code=v%5E1.1%23i%5E1%23r%5E1%23f%5E0%23p%5E3%23I%5E3%23t%5EUl41Xzc6QjUwOEJBQjYzRDY5ODczQjAxOTc0QzZFOTc2RkFEODZfMl8xI0VeMjYw&expires_in=299
				// immediately get access token and save to database config

				$access_token = $this->_get_access_token($this->input->get('code'));

				$this->data['got_user_token'] = $access_token;
			}
			else
			{
				$this->data['got_user_token'] = FALSE;
			}
		}

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'ebay';
		$this->data['page_title'] = 'eBay';
		$this->data['page_description'] = 'API program for eBay items';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Get Access Token using User Token
	 *
	 * @return	void
	 */
	private function _get_access_token($user_token)
	{
		// configure the request payload
		$params = 'grant_type=authorization_code&redirect_uri=Rey_Stephen_Mil-ReySteph-Instyl-wqvqxmhd&code='.$user_token;

		// set HTTP request headers
		$headers = array(
			'Authorization: Basic '.$this->config->item('ebay_oauth_credentials'),
			'Content-Type: application/x-www-form-urlencoded'
		);

		// do the cURL
		$csess = curl_init($this->config->item('ebay_url_endpoint'));

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

		// successful reponse with access and refresh token
		/*
		Array (
			[access_token] =>
			[expires_in] => 7200 // 2 hours
			[refresh_token] =>
			[refresh_token_expires_in] => 47304000 // about 547.5 days
			[token_type] => User Access Token
		)
		*/

		// failed access token request
		/*
		Array
		(
		    [error] => invalid_grant
		    [error_description] => the provided authorization grant code is invalid or was issued to another client
		)
		*/

		if (@$results['error'])
		{
			return FALSE;
		}

		// add actual expiration datetime
		$results['expiration'] = time() + $results['expires_in'];
		$results['refresh_token_expiration'] = time() + $results['refresh_token_expires_in'];

		$q = $this->DB->get_where('config', array('config_name' => 'ebay_access_token'));
		$r = $q->row();

		if (isset($r))
		{
			// update records
			$this->DB->set('config_value', json_encode($results));
			$this->DB->where('config_name', 'ebay_access_token');
			$this->DB->update('config');
		}
		else
		{
			// insert records
			$this->DB->set('config_value', json_encode($results));
			$this->DB->set('config_name', 'ebay_access_token');
			$this->DB->insert('config');
		}

		return TRUE;
    }

	// ----------------------------------------------------------------------

}
