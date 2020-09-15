<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Consumer User Details Class
 *
 * This class' objective is to output consumers user details as properties for use in the entire
 * HTML output. This class also serves as an authentication for the consumers user login in to the
 * frontend program for consumer users by which when initialized given the parameters like email
 * and password will return as true if user is in record. A property "status" (is_active field)
 * should also help determine user state at front end and filter authentication as inactive
 * and therfore cannot be authorized. When initialized to true, properties take value of the record.
 *
 * NOTE: There are related session variables that only consumers user uses but must not be within
 * this class such as "consumer_user_login_time" which is compared to the property "session_lapse".
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Consumers User Details
 * @author		WebGuy
 * @link
 */
class Consumer_user_details
{
	/**
	 * Consumer Sales User info
	 *
	 * @var	strings
	 */
	public $user_id = '';
	public $email = '';
	public $password = '';
	public $store_name = '';		// company
	public $fname = '';
	public $lname = '';
	public $firstname = '';			// alias
	public $lastname = '';			// alias

	public $address1 = '';
	public $address2 = '';
	public $city = '';
	public $country = '';
	public $state = '';
	public $zipcode = '';
	public $telephone = '';
	public $fax = '';

	public $create_date = '';
	public $active_date = '';

	public $receive_productupd = '';
	public $product_items = '';
	public $dresssize = '';

	public $how_hear_about = '';	// info on how the user heard about the site
	public $form_site = '';			// site where user registered as wholesale

	public $admin_sales_id = '';
	public $admin_sales_email = '';
	public $admin_sales_user = '';
	public $admin_sales_lname = '';

	public $reference_designer = '';
	public $designer = '';
	public $designer_site_domain = '';
	public $designer_address1 = '';
	public $designer_address2 = '';
	public $designer_info_email = '';
	public $designer_phone = '';

	public $options = array();


	/**
	 * Is Active
	 *
	 * @var	boolean
	 */
	public $status = 0;

	/**
	 * Acces level
	 *
	 * @var	integer
	 */
	public $access_level = 0;

	/**
	 * Session Lapse
	 *
	 * Current set to 48 hours
	 *
	 * @var	int
	 */
	public $session_lapse = 172800; // (2 * 24 * 60 * 60);


	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	void
	 */
	public function __construct($param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($param);
		log_message('info', 'Page Details Class Initialized');
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
			return FALSE;
		}

		// set conditions as per $params
		$where_clause = '';
		if ( ! empty($params))
		{
			$cntr = 1;
			$where_clause = "WHERE ";
			foreach ($params as $key => $val)
			{
				if ($cntr > 1) $where_clause .= "AND ";
				$field = explode(' ', $key);
				$where_clause .= "tbluser_data.".$field[0]." ".(@$field[1] ? $field[1] : "=")." '".$val."' ";
				$cntr++;
			}
		}

		/*********
		 * Will have to use string queries due to CI inherent adding of backticks to database
		 * tables and fields which cannot be disabled when using CASE WHEN THEN ELSE END on
		 * JOIN clause. CI has the ability to disable it only on SELECT clauses only.
		 */
		$query_string = "
			SELECT
				tbluser_data.*,

				designer.designer,
				designer.designer_site_domain,
				designer.designer_address1,
				designer.designer_address2,
				designer.designer_info_email,
				designer.designer_phone,

				tbladmin_sales.admin_sales_id,
				tbladmin_sales.admin_sales_email,
				tbladmin_sales.admin_sales_user,
				tbladmin_sales.admin_sales_lname
			FROM
				tbluser_data
				LEFT JOIN designer ON (
					CASE
						WHEN tbluser_data.reference_designer = 'basixblacklabel'
						THEN designer.folder = tbluser_data.reference_designer
						ELSE designer.url_structure = tbluser_data.reference_designer
					END
				)
				LEFT JOIN tbladmin_sales ON tbladmin_sales.admin_sales_email = tbluser_data.admin_sales_email
			".$where_clause."
		";

		// get records
		$query = $this->DB->query($query_string);

		//echo $this->DB->last_query(); die();

		$row = $query->row();

		// return object or FALSE on failure
		if (isset($row))
		{
			// initialize properties
			$this->user_id = $row->user_id;
			$this->email = $row->email;
			$this->password = $row->password;
			$this->store_name = $row->company;
			$this->fname = $row->firstname;
			$this->lname = $row->lastname;
			$this->firstname = $row->firstname;
			$this->lastname = $row->lastname;

			$this->address1 = $row->address1;
			$this->address2 = $row->address2;
			$this->city = $row->city;
			$this->country = $row->country;
			$this->state = $row->state_province;
			$this->zipcode = $row->zip_postcode;
			$this->telephone = $row->telephone;
			$this->fax = $row->fax;

			$this->create_date = $row->create_date;
			$this->active_date = $row->active_date;

			$this->receive_productupd = $row->receive_productupd;
			$this->product_items = $row->product_items;
			$this->dresssize = $row->dresssize;

			$this->how_hear_about = $row->how_hear_about;
			$this->form_site = $row->site_ini;

			$this->admin_sales_id = $row->admin_sales_id;
			$this->admin_sales_email = $row->admin_sales_email;
			$this->admin_sales_user = $row->admin_sales_user;
			$this->admin_sales_lname = $row->admin_sales_lname;

			$this->reference_designer = $row->reference_designer;	// slug
			$this->designer = $row->designer;	// designer name
			$this->designer_site_domain = $row->designer_site_domain;
			$this->designer_address1 = $row->designer_address1;
			$this->designer_address2 = $row->designer_address2;
			$this->designer_info_email = $row->designer_info_email;
			$this->designer_phone = $row->designer_phone;

			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();

			$this->status = $row->is_active;
			$this->access_level = 1;

			return $this;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Forcefully activate current user
	 *
	 * A short method to force activation of a user like in a case where user
	 * is inactive and yet clicked on a sales package campaign received from
	 * his email
	 *
	 * @return	void
	 */
	public function activate_user()
	{
		$this->DB->set('is_active', '1');
		$this->DB->where('user_id', $this->user_id);
		$query = $this->DB->update('tbluser_data');

		$this->status = '1';
	}

	// --------------------------------------------------------------------

	/**
	 * Update Login Details of consumer user
	 *
	 * @return	void
	 */
	public function update_login_detail()
	{
		$data = array(
			'user_id' => $this->user_id,
			'session_id' => $this->CI->session->userdata('session_id'),
			'create_date' => @date('Y-m-d', time()),
			'create_time' => @date('H:i:s', time()),
			'email' => $this->email,
			'logindata' => ''
		);
		$this->DB->insert('tbluser_data', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * Update Options Details of consumer user
	 *
	 * $params	array(associative)
	 * @return	boolean
	 */
	public function update_options(array $params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// grab the options
		$options_ary = $this->options;

		foreach ($params as $key => $val)
		{
			// check if key exists
			if (array_key_exists($key, $options_ary))
			{
				// update variables
				if ($val != '') $options_ary[$key] = $val;
				else unset($options_ary[$key]);
			}
			else
			{
				// add item
				if ($val != '') $options_ary[$key] = $val;
			}
		}

		// update records
		$this->DB->set('options', json_encode($options_ary));
		$this->DB->where('user_id', $this->user_id);
		$query = $this->DB->update('tbluser_data');

		// re-initialize class
		$this->initialize(array('user_id'=>$this->user_id));

		return TRUE;
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify admin of user being online
	 *
	 * @return	void
	 */
	public function notify_admin_user_online()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear Admin,
			<br /><br />
			Consumer User:<br />
			'.ucfirst($this->fname.' '.$this->lname).' is now online.<br />
			<br />
			<strong>Sale User Representative:</strong> &nbsp; &nbsp; '.$this->admin_sales_user.' '.$this->admin_sales_lname.'
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>User Name: &nbsp; </td>
					<td>'.ucwords($this->fname.' '.$this->lname).'</td>
				</tr>
				<tr>
					<td>Telephone: &nbsp; </td>
					<td>'.$this->telephone.'</td>
				</tr>
				<tr>
					<td>Email: &nbsp; </td>
					<td>'.$this->email.'</td>
				</tr>
			</table>
			<br /><br />

			<br />
		';
		// *** removing below line from above bottom space while it doesn't work
		// Click <u>here</u> to chat with user. <span style="color:red">[ Not yet available. ]</span>

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';

			echo '<a href="'.site_url('shop/designers/'.$this->reference_designer).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->CI->load->library('email');

			// notify admin
			$this->CI->email->clear();

			//$this->CI->email->from($this->designer_info_email, $this->designer);
			$this->CI->email->from($this->designer_info_email, $this->designer);

			// user user email to reply to
			$this->CI->email->reply_to($this->email, ucwords($this->fname.' '.$this->lname));

			$this->CI->email->to($this->CI->webspace_details->info_email);

			$this->CI->email->bcc('help@shop7thavenue.com'); // --> for debuggin purposes

			$this->CI->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->CI->webspace_details->name));
			$this->CI->email->message($email_message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->CI->email->send();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Universally SET Consumer User only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		if ($this->user_id !== '')
		{
			if (CI_VERSION < '3')
			{
				// this is legacy method and redundancy method
				$sesdata = array(
					'user_loggedin'				=> TRUE,
					'user_id'					=> $this->user_id,
					'user_cat'					=> 'consumer', // for depracation due to conflict with 'admin'
					'user_role'					=> 'consumer',
					'user_name'					=> $this->fname,
					'cs_last_active_time'		=> time()
				);
				$this->CI->session->set_userdata($sesdata);
			}
			else
			{
				// forward compatibility
				$_SESSION['user_loggedin'] = TRUE;
				$_SESSION['user_id'] = $this->user_id;
				$_SESSION['user_cat'] = 'consumer'; // for depracation due to conflict with 'admin'
				$_SESSION['user_role'] = 'consumer';
				$_SESSION['user_name'] = $this->fname;
				$_SESSION['cs_last_active_time'] = time();
			}
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Universally Unset Admin Sales only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
		if ($this->CI->session->user_cat == 'consumer')
		{
			if (CI_VERSION < '3')
			{
				// this is here for backwards compatibility
				$sesdata = array(
					'user_loggedin'				=> FALSE,
					'user_id'					=> '',
					'user_cat'					=> '', // for depracation due to conflict with 'admin'
					'user_role'					=> '',
					'user_name'					=> '',
					'cs_last_active_time'		=> '',
					'cs_login_time'				=> ''
				);
				$this->CI->session->unset_userdata($sesdata);
			}
			else
			{
				// this is legacy method and redundancy method
				$sesdata = array(
					'user_loggedin',
					'user_id',
					'user_cat', // for depracation due to conflict with 'admin'
					'user_role',
					'user_name',
					'cs_last_active_time',
					'cs_login_time'
				);
				$this->CI->session->unset_userdata($sesdata);
			}

			// for redundancy purposes...
			if (isset($_SESSION['user_loggedin'])) unset($_SESSION['user_loggedin']);
			if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
			if (isset($_SESSION['user_cat'])) unset($_SESSION['user_cat']); // for depracation due to conflict with 'admin'
			if (isset($_SESSION['user_role'])) unset($_SESSION['user_role']);
			if (isset($_SESSION['user_name'])) unset($_SESSION['user_name']);
			if (isset($_SESSION['cs_last_active_time'])) unset($_SESSION['cs_last_active_time']);
			if (isset($_SESSION['cs_login_time'])) unset($_SESSION['cs_login_time']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function set_initial_state()
	{
		// reset variables to default
		$this->user_id = '';
		$this->email = '';
		$this->password = '';
		$this->store_name = '';
		$this->fname = '';
		$this->lname = '';
		$this->firstname = '';
		$this->lastname = '';

		$this->address1 = '';
		$this->address2 = '';
		$this->city = '';
		$this->country = '';
		$this->state = '';
		$this->zipcode = '';
		$this->telephone = '';
		$this->fax = '';

		$this->create_date = '';
		$this->active_date = '';

		$this->receive_productupd = '';
		$this->product_items = '';
		$this->dresssize = '';

		$this->how_hear_about = '';
		$this->form_site = '';

		$this->admin_sales_id = '';
		$this->admin_sales_email = '';
		$this->admin_sales_user = '';
		$this->admin_sales_lname = '';

		$this->reference_designer = '';
		$this->designer = '';
		$this->designer_site_domain = '';
		$this->designer_address1 = '';
		$this->designer_address2 = '';
		$this->designer_info_email = '';
		$this->designer_phone = '';

		$this->status = 0;
		$this->access_level = 0;
	}

	// --------------------------------------------------------------------

}
