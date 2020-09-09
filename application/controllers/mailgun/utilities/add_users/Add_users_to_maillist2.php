<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_users_to_maillist extends MY_Controller {

	/**
	 * Various
	 * NOTE: If deisnger name is 'Mixed Designers', use 'shop7thaveue' as slug
	 *
	 * @var	string
	 */
	public $designer_name = '';
	public $designer_slug = '';
	public $store_name = '';
	public $role = ''; // 'Wholesale, Consumer, Sales, Vendor'

	/**
	 * Database Table
	 * to get users from
	 * two options:
	 *		tbluser_data
	 *		tbluser_data_wholesale
	 *
	 * @var	string
	 */
	public $table = '';

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

		// set some default properties
		$this->domain = $this->config->item('mailgun_domain');
		$this->key = $this->config->item('mailgun_api');
    }

	// ----------------------------------------------------------------------

	/**
	 * Add User member to mailing list
	 *
	 * @return	void
	 */
	public function add_users()
	{
		// load pertinent library/model/helpers
		$this->load->library('mailgun/validate_email');

		// limit is needed when adding users to mailgun maillist
		// too many users can exceed script max exec time
		// 250 records at a time is just perfect, 500 is inconsitently ok/not ok
		// unfortunately, this can only be done manually
		$this->DB->limit(250, 10000); // 250, 500 ...
		$query = $this->DB->get($this->table);

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			echo 'No records found.';
			exit;
		}
		else
		{
			$undeliverable = array();
			$users_ary = array();
			foreach ($query->result() as $row)
			{
				// validate email
				$this->validate_email->initialize(array('email'=>$row->email));
				$is_valid_email = $this->validate_email->validate();

				if ($is_valid_email == 'deliverable')
				{
					// set params to pass to mailgun on export
					$user['subscribed'] = TRUE; // adding user defaults to 'subscribed'
					$user['description'] = ucfirst(strtolower($this->role)).' User'; // 'ex: Wholesae User'
					$user['address'] = $row->email;
					$user['name'] = ucwords($row->firstname.' '.$row->lastname);

					// user vars to be able to access it as %recipient.yourvars%
					//$params['vars'] = '{"designer":"Basix Black Labe",...}'
					if ($this->designer_name) $this_params['designer'] = $this->designer_name;
					if ($this->designer_slug) $this_params['designer_slug'] = $this->designer_slug;
					if ($this->store_name) $this_params['store_name'] = $this->store_name;

					// set vars per user
					$user['vars'] = json_encode($this_params);

					array_push($users_ary, $user);
				}
				else
				{
					// set undeliverable emails status to 3
					$this->DB->set('is_active', '3');
					$this->DB->where('user_id', $row->user_id);
					$this->DB->update($this->table);

					// collate undeliverable emails and their reasons
					$undeliverable[$row->email] = $this->validate_email->reason;
				}

				$this->validate_email->clear();
			}

			// set main email header params accordingly
			$params['upsert'] = TRUE;
			$params['members'] = json_encode($users_ary);

			// let do the curl
			// user API url member.json for multiple users upload
			// link: https://documentation.mailgun.com/en/latest/api-mailinglists.html#examples
			$csess = curl_init('https://api.mailgun.net/v3/lists/'.$this->list_name.'/members.json');

			// set settings
			curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
			curl_setopt($csess, CURLOPT_POST, true);
			curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
			curl_setopt($csess, CURLOPT_HEADER, false);
			//curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
			curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

			// get response
			$response = curl_exec($csess);

			// close curl
			curl_close($csess);

			// convert to array
			$results = json_decode($response, true);
		}

		echo '<pre>';
		print_r($results);
		echo '<br />';
		print_r($undeliverable);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

}
