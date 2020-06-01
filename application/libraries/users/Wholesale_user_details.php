<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Wholesale User Details Class
 *
 * This class' objective is to output wholesales user details as properties for use in the entire
 * HTML output. This class also serves as an authentication for the wholesales user loggin in to the
 * frontend program for wholessale users by which when initialized given the parameters like email
 * and password will return as true if user is in record. A property "status" (is_active field)
 * should also help determine user state at front end and filter authentication as inactive
 * and therfore cannot be authorized. When initialized to true, properties take value of the record.
 *
 * Properties (based of fields):
 *		user_id, email, pword, store_name, firstname, lastname,
 *		fed_tax_id, address1, adderss2, city, country, state, zipcode, telephone, fax,
 *		create_date, active_date, access_level, is_active, form_site,
 *		admin_sales_id, admin_sales_email, reference_designer
 *
 * Functions/Methods
 *		initialize($params)			Initialize class and output information
 *		set_session()				Universally SET admin sales related session info
 *		unset_session()				Universally UNSET admin sales related session info
 *
 * NOTE: There are related session variables that only wholesales user uses but must not be within
 * this class such as "ws_last_active_time" which is compared to the property "session_lapse".
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Wholesales User Details
 * @author		WebGuy
 * @link
 */
class Wholesale_user_details
{
	/**
	 * Wholesale Sales User info
	 *
	 * @var	strings
	 */
	public $user_id = '';
	public $email = '';
	public $email2 = '';
	public $email3 = '';
	public $email4 = '';
	public $email5 = '';
	public $email6 = '';
	public $password = '';
	public $store_name = '';
	public $website = '';
	public $fname = '';
	public $lname = '';

	public $fed_tax_id = '';

	public $address1 = '';
	public $address2 = '';
	public $city = '';
	public $country = '';
	public $state = '';
	public $zipcode = '';
	public $telephone = '';
	public $telephone2 = '';
	public $telephone3 = '';
	public $fax = '';
	public $comments = '';

	public $create_date = '';
	public $active_date = '';

	public $form_site = '';		// site where user registered as wholesale

	public $admin_sales_id = '';
	public $admin_sales_email = '';
	public $admin_sales_user = '';
	public $admin_sales_lname = '';

	public $des_id = '';
	public $reference_designer = '';
	public $designer = '';
	public $designer_site_domain = '';
	public $designer_address1 = '';
	public $designer_address2 = '';
	public $designer_info_email = '';
	public $designer_phone = '';

	public $options = array();

	/**
	 * Total Visits
	 *
	 * @var	integer
	 */
	public $total_visits = 0;
	public $visits_after_activation = 0;

	/**
	 * Login ID
	 * Reference login id for the current login session
	 * If present, same logindata field will be updated
	 * Othewise, a new login detail will be made
	 *
	 * @var	boolean
	 */
	public $this_login_id = '';

	/**
	 * Is Active
	 *
	 * @var	boolean
	 */
	public $status = 0;

	/**
	 * Acces level
	 *
	 * @var	string
	 */
	public $access_level = '';

	/**
	 * Session Lapse
	 *
	 * Currently set to 6 hours
	 * This will allow user to use same login data within session laps time
	 * Days to auto logout - 3 days
	 *
	 * @var	int
	 */
	public $session_lapse = 21600; // (6 * 60 * 60);
	public $days_lapse = 259200; // (3 * 24 * 60 * 60);

	/**
	 * Time Record - Uniform time reference as bring online
	 *
	 * @var	time
	 */
	protected $time_record;


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
	public function initialize(array $params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

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
				$where_clause .= "tbluser_data_wholesale.".$field[0]." ".(@$field[1] ? $field[1] : "=")." '".$val."' ";
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
				tbluser_data_wholesale.*,

				(SELECT COUNT(*)
					FROM tbl_login_detail_wholesale
					WHERE tbl_login_detail_wholesale.email = tbluser_data_wholesale.email
				) AS total_visits,
				(SELECT COUNT(*)
					FROM tbl_login_detail_wholesale
					WHERE tbl_login_detail_wholesale.email = tbluser_data_wholesale.email
					AND tbl_login_detail_wholesale.create_date >= tbluser_data_wholesale.active_date
				) AS visits_after_activation,

				designer.des_id,
				designer.designer,
				designer.designer_site_domain,
				designer.designer_address1,
				designer.designer_address2,
				designer.designer_info_email,
				designer.designer_phone,

				tbladmin_sales.admin_sales_id AS sales_admin_id,
				tbladmin_sales.admin_sales_user,
				tbladmin_sales.admin_sales_lname
			FROM
				tbluser_data_wholesale
				LEFT JOIN designer ON (
					CASE
						WHEN tbluser_data_wholesale.reference_designer = 'basixblacklabel'
						THEN designer.folder = tbluser_data_wholesale.reference_designer
						ELSE designer.url_structure = tbluser_data_wholesale.reference_designer
					END
				)
				LEFT JOIN tbladmin_sales ON tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email
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
			$this->password = $row->pword;

			$this->email2 = $row->email2;
			$this->email3 = $row->email3;
			$this->email4 = $row->email4;
			$this->email5 = $row->email5;
			$this->email6 = $row->email6;

			$this->store_name = $row->store_name;
			$this->website = $row->website;
			$this->fname = $row->firstname;
			$this->lname = $row->lastname;

			$this->fed_tax_id = $row->fed_tax_id;

			$this->address1 = $row->address1;
			$this->address2 = $row->address2;
			$this->city = $row->city;
			$this->country = $row->country;
			$this->state = $row->state;
			$this->zipcode = $row->zipcode;
			$this->telephone = $row->telephone;
			$this->telephone2 = $row->telephone2;
			$this->telephone3 = $row->telephone3;
			$this->fax = $row->fax;
			$this->comments = $row->comments;

			$this->create_date = $row->create_date;
			$this->active_date = $row->active_date;

			$this->form_site = $row->form_site;

			$this->admin_sales_id = $row->sales_admin_id;
			$this->admin_sales_email = $row->admin_sales_email;
			$this->admin_sales_user = $row->admin_sales_user;
			$this->admin_sales_lname = $row->admin_sales_lname;

			$this->des_id = $row->des_id;
			$this->reference_designer = $row->reference_designer;	// slug
			$this->designer = $row->designer;	// designer name
			$this->designer_site_domain = $row->designer_site_domain;
			$this->designer_address1 = $row->designer_address1;
			$this->designer_address2 = $row->designer_address2;
			$this->designer_info_email = $row->designer_info_email;
			$this->designer_phone = $row->designer_phone;

			$this->total_visits = $row->total_visits;
			$this->visits_after_activation = $row->total_visits;
			$this->status = $row->is_active;
			$this->access_level = $row->access_level;

			$this->time_record = time();

			$this->options = $row->options != '' ? json_decode($row->options , TRUE) : array();

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
		$query = $this->DB->update('tbluser_data_wholesale');

		$this->status = '1';
	}

	// --------------------------------------------------------------------

	/**
	 * Update Login Details of wholesale user
	 *
	 * Updates the logindata portion of the ws user login details records
	 * A recent login id (this_login_id) session created by method
	 * record_login_detail() must be present
	 *
	 * $logindata		array	= 	array(page, int)
	 *								array(prod_no, int)
	 *								array(time())
	 * $params			string	= 	page_visits / product_clicks / active_time
	 * @return			boolean
	 */
	public function update_login_detail($logindata = array(), $params)
	{
		if (
			empty($logindata)
			OR ! $params
		)
		{
			// nothing more to do...
			return FALSE;
		}

		if ( ! isset($_SESSION['this_login_id']))
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->model('get_wholesale_login_details');

		// check for this_login_id errors
		if ( ! $this->CI->get_wholesale_login_details->check_id($_SESSION['this_login_id']))
		{
			// nothing more to do...
			return FALSE;
		}

		// get current logindata (@return is always an array)
		$cur_logindata = $this->CI->get_wholesale_login_details->get();

		// if existing logindata
		if ($cur_logindata)
		{
			if ($params == 'active_time')
			{
				// add/update element value
				$cur_logindata[$params] = $logindata[0];
				if ($logindata[0] == 'logout') unset($cur_logindata['chat_id']);
			}
			elseif (isset($cur_logindata[$params]) && array_key_exists($logindata[0], $cur_logindata[$params]))
			{
				// just add page visit value, or product clicks value
				$cur_logindata[$params][$logindata[0]] += $logindata[1];
			}
			else
			{
				// add new key element
				$cur_logindata[$params][$logindata[0]] = $logindata[1];
			}
		}
		else
		{
			// first login details record
			// redundant... but just to be certain that an empty array escapes the if...
			// and we need to add the active_time as well
			if ($params == 'active_time')
			{
				// add/update element value
				$cur_logindata[$params] = $logindata[0];
				if ($logindata[0] == 'logout') unset($cur_logindata['chat_id']);
			}
			else $cur_logindata[$params][$logindata[0]] = $logindata[1];
		}

		$this->CI->get_wholesale_login_details->update($cur_logindata);

		// if params is 'active_time', we need to update online time record
		if ($params == 'active_time') $this->record_as_online();

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Record login detail after a wholesale user logs in
	 *
	 * This is access by Class Authenticated when the ws user is
	 * authenticated, we then create a new login detail record for the user
	 *
	 * @return	void
	 */
	public function record_login_detail()
	{
		// record login detail
		$data = array(
			'user_id' => $this->user_id,
			//'session_id' => $this->CI->session->session_id,	// no longer used on new table
			'create_date' => @date('Y-m-d', $this->time_record),
			'create_time' => @date('H:i:s', $this->time_record),
			'email' => $this->email,
			'logindata' => ''
		);
		$this->DB->insert('tbl_login_detail_wholesale', $data);

		// set session for this_login_id
		$_SESSION['this_login_id'] = $this->DB->insert_id();

		// record user as online
		$this->record_as_online();
	}

	// --------------------------------------------------------------------

	/**
	 * Record login detail after a wholesale user logs in
	 *
	 * This is access by Class Authenticated when the ws user is
	 * authenticated, we then create a new login detail record for the user
	 *
	 * @return	void
	 */
	public function record_as_online()
	{
		// record user as online
		if ( ! $this->DB->get_where(
				'online_users',
				array(
					'user_id' => $this->user_id,
					'user_cat' => 'wholesale', // take note for 'online_users' we retain user_cat
					'email' => $this->email,
				)
			)->result()
		)
		{
			$data = array(
				'user_id' => $this->user_id,
				'user_cat' => 'wholesale', // take note for 'online_users' we retain user_cat
				'email' => $this->email,
				'lastonline' => $this->time_record
			);
			$this->DB->insert('online_users', $data);
		}
		else
		{
			$this->DB->set('lastonline', $this->time_record);
			$this->DB->where('user_id', $this->user_id);
			$this->DB->where('user_cat', 'wholesale'); // take note for 'online_users' we retain user_cat
			$this->DB->where('email', $this->email);
			$this->DB->update('online_users');
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Act Click One Method
	 *
	 * @return	void
	 */
	public function act_click_one($user_id = '', $tc = '', $id = '', $options = array())
	{
		if ($user_id == '' OR $tc == '' OR $id =='')
		{
			// nothing more to do...
			return FALSE;
		}

		// update property
		if ( ! isset($options['act'][$tc])) $options['act'][$tc] = $id;

		$this->options = $options;

		// update recrods
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('user_id', $user_id);
		$this->DB->update('tbluser_data_wholesale');

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Product Clicks Click 1 Method
	 *
	 * @return	void
	 */
	public function prod_clicks_one($user_id = '', $tc = '', $session_id = '')
	{
		if ($user_id == '' OR $tc == '' OR $session_id =='')
		{
			// nothing more to do...
			return FALSE;
		}

		// update property
		$this->options['product_cliks'][$tc] = $session_id;

		// update recrods
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('user_id', $user_id);
		$this->DB->update('tbluser_data_wholesale');

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get logindata
	 *
	 * @return	object/boolean false
	 */
	public function get_logindata()
	{
		// load pertinent library/model/helpers
		$this->CI->load->model('get_wholesale_login_details');
		return $this->CI->get_wholesale_login_details->get();
	}

	// --------------------------------------------------------------------

												/**
												 * Get user number of visits
												 *
												 * @return	object/boolean false
												 */
												public function total_visits()
												{
													$this->DB->where('email', $this->email);
													$q = $this->DB->count_all_results('tbl_login_detail_wholesale');

													return $q;
												}

	// --------------------------------------------------------------------

	/**
	 * Universally SET Admin Sales only session
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
					'user_cat' 					=> 'wholesale', // for depracation due to conflict with 'admin'
					'user_role' 				=> 'wholesale',
					'user_name'					=> $this->fname,
					'ws_last_active_time'		=> time()
				);
				$this->CI->session->set_userdata($sesdata);
			}
			else
			{
				// forward compatibility
				$_SESSION['user_loggedin'] = TRUE;
				$_SESSION['user_id'] = $this->user_id;
				$_SESSION['user_cat'] = 'wholesale'; // for depracation due to conflict with 'admin'
				$_SESSION['user_role'] = 'wholesale';
				$_SESSION['user_name'] = $this->fname;
				$_SESSION['ws_last_active_time'] = time();
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
		// for redundancy purposes...
		if (isset($_SESSION['user_loggedin'])) unset($_SESSION['user_loggedin']);
		if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
		if (isset($_SESSION['user_cat'])) unset($_SESSION['user_cat']);
		if (isset($_SESSION['user_role'])) unset($_SESSION['user_role']);
		if (isset($_SESSION['user_name'])) unset($_SESSION['user_name']);
		if (isset($_SESSION['this_login_id'])) unset($_SESSION['this_login_id']);
		if (isset($_SESSION['ws_last_active_time'])) unset($_SESSION['ws_last_active_time']);
		if (isset($_SESSION['ws_login_time'])) unset($_SESSION['ws_login_time']);

		// sales packages are for wholesale users only
		// ensure that sales package session are unset during logout
		// below is the unset_session() funtion details copies as is
		$sesdata = array(
			'sales_package' => FALSE,
			'sales_package_id' => '',
			'sales_package_items' => '',
			'sales_package_tc' => '',
			'sales_package_link' => ''
		);
		$this->CI->session->unset_userdata($sesdata);

		if (isset($_SESSION['sales_package'])) unset($_SESSION['sales_package']);
		if (isset($_SESSION['sales_package_id'])) unset($_SESSION['sales_package_id']);
		if (isset($_SESSION['sales_package_items'])) unset($_SESSION['sales_package_items']);
		if (isset($_SESSION['sales_package_tc'])) unset($_SESSION['sales_package_tc']);
		if (isset($_SESSION['sales_package_link'])) unset($_SESSION['sales_package_link']);
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
			Dear '.ucwords($this->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->fname.' '.$this->lname).' is now online.<br />
			Total logged in visits  - ( '.$this->total_visits().' ).
			<br /><br />
			<strong>Sale User Representative:</strong> &nbsp; &nbsp; '.$this->admin_sales_user.' '.$this->admin_sales_lname.'
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>Store Name: &nbsp; </td>
					<td>'.$this->store_name.'</td>
				</tr>
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

			$this->CI->email->from($this->designer_info_email, $this->designer);

			$this->CI->email->to($this->CI->webspace_details->info_email);

			$this->CI->email->bcc($this->CI->config->item('dev1_email')); // --> for debuggin purposes

			$this->CI->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->CI->webspace_details->name));
			$this->CI->email->message($email_message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->CI->email->send();
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify admin of user being online
	 *
	 * @return	void
	 */
	public function notify_sales_user_online()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear '.ucwords($this->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->fname.' '.$this->lname).' is now online.<br />
			Total logged in visits  - ( '.$this->total_visits().' ).
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>Store Name: &nbsp; </td>
					<td>'.$this->store_name.'</td>
				</tr>
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

			$this->CI->email->from($this->designer_info_email, $this->designer);

			$this->CI->email->to($this->admin_sales_email);

			$this->CI->email->bcc($this->CI->config->item('dev1_email')); // --> for debuggin purposes

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
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function set_initial_state()
	{
		// destroy session
		$this->unset_session();

		// reset variables to default
		$this->user_id = '';
		$this->email = '';
		$this->password = '';

		$this->email2 = '';
		$this->email3 = '';
		$this->email4 = '';
		$this->email5 = '';
		$this->email6 = '';

		$this->store_name = '';
		$this->website = '';
		$this->fname = '';
		$this->lname = '';

		$this->fed_tax_id = '';

		$this->address1 = '';
		$this->address2 = '';
		$this->city = '';
		$this->country = '';
		$this->state = '';
		$this->zipcode = '';
		$this->telephone = '';
		$this->telephone2 = '';
		$this->telephone3 = '';
		$this->fax = '';
		$this->comments = '';

		$this->create_date = '';
		$this->active_date = '';

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

		$this->total_visits = 0;
		$this->visits_after_activation = 0;
		$this->status = 0;
		$this->access_level = '';

		$this->options = array();
	}

	// --------------------------------------------------------------------

	/**
	 * Alias of set_initial_state()
	 *
	 * @return	void
	 */
	public function deinitialize()
	{
		$this->set_initial_state();

		return $this;
	}

	// --------------------------------------------------------------------

}
