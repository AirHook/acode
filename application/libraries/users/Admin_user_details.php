<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Admin User Details Class
 *
 * This class' objective is to output admin user details as properties for use in the entire
 * HTML output. This class also serves as an authentication for the admin user logging in to the
 * admin panel by which when initialized given the parameters username and password will return
 * as true if user is in record. A property "status" (is_active field) should also help determine
 * user state at admin panel and filter authentication as inactive and therfore cannot be
 * authorized.
 *
 * Properties:	username, password, fname, lname, email, status, access_level, session_lapse
 *
 * Functions/Methods
 *		initialize($params)			Initialize class and output information
 *		set_session()				Universally SET admin related session info
 *		unset_session()				Universally UNSET admin related session info
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Admin User Details
 * @author		WebGuy
 * @link
 */
class Admin_user_details
{
	/**
	 * Admin User ID
	 *
	 * @var	string
	 */
	public $admin_id = '';

	/**
	 * Admin User Name
	 *
	 * @var	string
	 */
	public $username = '';

	/**
	 * Admin User Password
	 *
	 * @var	string
	 */
	public $password = '';

	/**
	 * Admin User Email
	 *
	 * @var	string
	 */
	public $email = '';

	/**
	 * Admin First Name
	 *
	 * @var	string
	 */
	public $fname = '';

	/**
	 * Admin Last Name
	 *
	 * @var	string
	 */
	public $lname = '';

	/**
	 * Account Id
	 *
	 * @var	string/boolean
	 */
	public $account_id = '';

	/**
	 * Webspac Id
	 *
	 * @var	string/boolean
	 */
	public $webspace_id = '';

	/**
	 * Is Active
	 *
	 * @var	string/boolean
	 */
	public $status = '';

	/**
	 * Acces level
	 *
	 * @var	string
	 */
	public $access_level = '';

	/**
	 * Session Lapse
	 *
	 * Current set to 30 days
	 *
	 * @var	int
	 */
	public $session_lapse = 2592000; // 30 * 24 * 60 * 60


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
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		// get recrods
		$this->DB->where($params);
		$query = $this->DB->get('tbladmin');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->admin_id = $row->admin_id;
			$this->username = $row->admin_name;
			$this->password = $row->admin_password;
			$this->email = $row->admin_email;
			$this->fname = $row->fname;
			$this->lname = $row->lname;
			$this->account_id = $row->account_id;
			$this->status = $row->is_active;
			$this->access_level = $row->access_level;
			$this->webspace_id = $row->webspace_id;

			return $this;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Reset Password when forgotten
	 *
	 * @return	string
	 */
	public function reset_password($password = '')
	{
		if ( ! $password)
		{
			// nothing more to do...
			return FALSE;
		}

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		// get recrods
		$this->DB->set('admin_password', $password);
		$this->DB->where('admin_email', $this->email);
		$query = $this->DB->update('tbladmin');

		return $this->DB->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * Universally SET Admin Sales only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		// this is legacy method and redundancy method
		$sesdata = array(
			'admin_loggedin'			=> TRUE,
			'admin_id'					=> $this->admin_id
		);
		$this->CI->session->set_userdata($sesdata);

		// forward compatibility
		$_SESSION['admin_loggedin'] = TRUE;
		$_SESSION['admin_id'] = $this->admin_id;
	}

	// --------------------------------------------------------------------

	/**
	 * Universally Unset Admin Sales only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
		if (CI_VERSION < '3')
		{
			// this is here for backwards compatibility
			$sesdata = array(
				'admin_loggedin'			=> FALSE,
				'admin_id'					=> '',
				'admin_login_time'			=> ''		// related to session_lapse property
			);
			$this->CI->session->unset_userdata($sesdata);
		}
		else
		{
			// this is legacy method and redundancy method
			$sesdata = array(
				'admin_loggedin',
				'admin_id',
				'admin_login_time'
			);
			$this->CI->session->unset_userdata($sesdata);
		}

		// for redundancy purposes...
		// and forward compatibility
		if (isset($_SESSION['admin_loggedin'])) unset($_SESSION['admin_loggedin']);
		if (isset($_SESSION['admin_id'])) unset($_SESSION['admin_id']);
		if (isset($_SESSION['admin_login_time'])) unset($_SESSION['admin_login_time']);
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
		$this->admin_id = '';
		$this->username = '';
		$this->password = '';
		$this->email = '';
		$this->fname = '';
		$this->lname = '';
		$this->account_id = '';
		$this->status = '';
		$this->access_level = '';
		$this->webspace_id = '';
	}

	// --------------------------------------------------------------------

}
