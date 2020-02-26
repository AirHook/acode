<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_member_add {

	/**
	 * Email address
	 *
	 * @var	string
	 */
	public $address = '';

	/**
	 * First Name
	 *
	 * @var	string
	 */
	public $fname = '';

	/**
	 * Last Name
	 *
	 * @var	string
	 */
	public $lname = '';

	/**
	 * Description
	 *
	 * @var	string
	 */
	public $description = '';

	/**
	 * User Variables
	 *
	 * @var	json
	 */
	public $vars = '';

	/**
	 * Mailgun List Name
	 *
	 * @var	string
	 */
	public $list_name = '';

	/**
	 * Error Message
	 *
	 * @var	string
	 */
	public $error_message = '';


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
	public function __construct(array $params = array())
	{
		$this->CI = get_instance();

        // set some default properties
		$this->domain = $this->CI->config->item('mailgun_domain');
		$this->key = $this->CI->config->item('mailgun_api');

		$this->initialize($params);
        log_message('info', 'Mailgun Add List Member Class Loaded');
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

			$this->error_message = 'Please provide paramaters to work on with.';

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
	public function add()
	{
		if ( ! $this->list_name)
		{
			// nothing more to do...
			// clear properties
			$this->clear();

			$this->error_message = 'Invalid List Name.';

			return FALSE;
		}

		if ( ! $this->address)
		{
			// nothing more to do...
			// clear properties
			$this->clear();

			$this->error_message = 'Invalid Email Address.';

			return FALSE;
		}

		// check name
		$name = ($this->fname OR $this->lname) ? trim($this->fname.' '.$this->lname) : 'Guest';

		// set main email header params accordingly
		$params['upsert'] = TRUE;
		$params['subscribed'] = TRUE;
		$params['description'] = $this->description;
		$params['address'] = $this->address;
		$params['name'] = $name;

		// set vars per user to be able to access it as %recipient.yourvars%
		//$params['vars'] = '{"designer":"Basix Black Labe",...}'
		if ($this->vars)
		{
			$params['vars'] = $this->vars;
		}

		// let do the curl
        $csess = curl_init('https://api.mailgun.net/v3/lists/'.$this->list_name.'/members');

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, false);
        curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		if ($results['message'] == 'Mailing list member has been created')
		{
			return $results['message'];
		}
		else
		{
			$this->error_message = $results['message'];
			$this->clear();
			return FALSE;
		}
	}

	// ----------------------------------------------------------------------

    public function clear()
    {
        $this->email = '';
        $this->fname = '';
		$this->lname = '';
		$this->description = '';
		$this->vars = '';

        return $this;
    }

	// ----------------------------------------------------------------------

}
