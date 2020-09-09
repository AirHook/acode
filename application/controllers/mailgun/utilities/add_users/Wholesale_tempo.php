<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_tempo extends MY_Controller {

	/**
	 * Role
	 *
	 * @var	string
	 */
	public $role = 'Wholesale'; // 'Wholesale, Consumer, Sales, Vendor'

	/**
	 * Database Table
	 * to get users from
	 * two options:
	 *		tbluser_data
	 *		tbluser_data_wholesale
	 *
	 * @var	string
	 */
	public $table = 'tbluser_data_wholesale';

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
	 *	consumers@mg.shop7thavenue.com
	 *	wholesale_users@mg.shop7thavenue.com
	 *	ws_tempo@mg.shop7thavenue.com
	 *
	 * Example url: https://www.shop7thavenue.com/mailgun/utilities/add_users/wholesale.html?l=100&o=0
	 *
	 * @return	void
	 */
	public function index()
	{
		echo '<pre>';

		// set some data
		$designer_slug = 'tempoparis';
		$list_name = 'ws_tempo@mg.shop7thavenue.com';

		// load pertinent library/model/helpers
		$this->load->library('mailgun/validate_email');

		$limit = $this->input->get('l');
		$offset = $this->input->get('o');

		// limit is needed when adding users to mailgun maillist
		// too many users can exceed script max exec time
		// 250 records at a time is just perfect, 500 is inconsitently ok/not ok
		// unfortunately, this can only be done manually
		$this->DB->join('designer', 'designer.url_structure = '.$this->table.'.reference_designer', 'left');
		$this->DB->where('reference_designer', $designer_slug);
		$this->DB->order_by('user_id');
		$this->DB->limit($limit, $offset); // 250, 500 ...
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
					$this_params['store_name'] = $row->store_name;
					$this_params['designer'] = $row->designer;
					$this_params['designer_slug'] = $designer_slug;

					// set vars per user
					$user['vars'] = json_encode($this_params);

					/* */
					// Something is wrong with the multiple user list adding
					// Not sure if it is the url or mailgun
					// curl seems to be working and getting a response
					// response indicate list is updated but actual list is not updated
					// adding user individually instead (as it works okay)

					// let do the curl
					// user API url member.json for multiple users upload
					// link: https://documentation.mailgun.com/en/latest/api-mailinglists.html#examples
					$csess = curl_init('https://api.mailgun.net/v3/lists/'.$list_name.'/members');

					// set settings
					curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
					curl_setopt($csess, CURLOPT_POST, true);
					curl_setopt($csess, CURLOPT_POSTFIELDS, $user);
					curl_setopt($csess, CURLOPT_HEADER, false);
					//curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
					curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
					curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

					// get response
					$response = curl_exec($csess);

					// close curl
					curl_close($csess);

					echo '<pre>';
					print_r(json_decode(@$response, TRUE));
					echo '<br />';
					// */

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

			/* *
			// set main email header params accordingly
			$params['upsert'] = TRUE;
			$params['members'] = json_encode($users_ary);

			// let do the curl
			// user API url member.json for multiple users upload
			// link: https://documentation.mailgun.com/en/latest/api-mailinglists.html#examples
			$csess = curl_init('https://api.mailgun.net/v3/lists/'.$list_name.'/members.json');

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
			// */

			// convert to array
			$results = json_decode(@$response, TRUE);
		}

		echo '<pre>';
		//print_r($results);
		echo '<br />';
		print_r($undeliverable);
		echo '<br />';
		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
