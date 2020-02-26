<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validate_email {

	/**
	 * Email address to validate
	 *
	 * @var	string
	 */
	public $email;

	/**
	 * (Optional) Null if nothing, however if a potential typo is made, the closest suggestion is provided
	 *
	 * @var	string
	 */
	public $did_you_mean = NULL;

	/**
	 * If the domain is in a list of disposable email addresses, this will be appropriately categorized
	 *
	 * @var	boolean
	 */
	public $is_disposable_address;

	/**
	 * Checks the mailbox portion of the email if it matches a specific role type (‘admin’, ‘sales’, ‘webmaster’)
	 *
	 * @var	boolean
	 */
	public $is_role_address;

	/**
	 * List of potential reasons why a specific validation may be unsuccessful.
	 *
	 * @var	array
	 */
	public $reason = array();

	/**
	 * Either deliverable, undeliverable or unknown status given the evaluation.
	 *
	 * @var	string
	 */
	public $result;

	/**
	 * high, medium, low, unknown or null Depending on the evaluation of all aspects of the given email.
	 *
	 * @var	string
	 */
	public $risk;


	/**
	 * Mailgun API Key
	 *
	 * @var	string
	 */
	protected $key;

    /**
	 * Mailgun API Domain
	 *
	 * @var	string
	 */
	protected $domain;


	/**
	 * CI Instance
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI = get_instance();

        // set some default properties
		$this->domain = $this->CI->config->item('mailgun_domain');
		$this->key = $this->CI->config->item('mailgun_api');

        log_message('info', 'Mailgun Class Loaded');
    }

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			// clear properties
			$this->clear();

			$this->error_message = 'Please provide email address to valdiate.';

			return FALSE;
		}

		// initialize properties
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}

		return $this;
	}

	// ----------------------------------------------------------------------

	/**
	 * Request to validate all emails of the mailing list
	 *
	 * @return	void
	 */
	public function validate()
	{
		if ( ! $this->email)
		{
			// clear properties
			$this->clear();

			$this->error_message = 'Please provide email address to valdiate.';

			return FALSE;
		}

		// set url
		$url = 'https://api.mailgun.net/v4/address/validate?address='.$this->email;

		// let do the curl
		$csess = curl_init($url);

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        //curl_setopt($csess, CURLOPT_POST, true);
        //curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, false);
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		// sample return results
		/*
		print_r($results);
		Array
		(
		    [address] => xasdfs@asdlkjsad.com
		    [is_disposable_address] =>
		    [is_role_address] =>
		    [reason] => Array
		        (
		            [0] => No MX records found for domain 'asdlkjsad.com'
		        )

		    [result] => undeliverable
		    [risk] => high
		)
		return $results['result'];
		*/

		// set properties for access where necessary
		if (@$results['did_you_mean']) $this->did_you_mean = $results['did_you_mean'];
		$this->is_disposable_address = $results['is_disposable_address'];
		$this->is_role_address = $results['is_role_address'];
		$this->reason = $results['reason'];
		$this->result = $results['result'];
		$this->risk = $results['risk'];

		return $results['result'];
	}

	// ----------------------------------------------------------------------

    public function clear()
    {
        $this->email = '';
        $this->did_you_mean = NULL;
        $this->is_disposable_address = '';
        $this->is_role_address = '';
		$this->reason = array();
        $this->result = '';
        $this->risk = '';

        return $this;
    }

	// ----------------------------------------------------------------------

}
