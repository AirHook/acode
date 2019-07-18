<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales User Details Class
 *
 * This class' objective is to output sales user details as properties for use in the entire
 * HTML output. This class also serves as an authentication for the sales user loggin in to the
 * sales frontend program by which when initialized given the parameters like email and password
 * will return as true if user is in record. A property "status" (is_active field) should also
 * help determine user state at front end and filter authentication as inactive and therfore
 * cannot be authorized.
 *
 * Properties:	email, password, fname, lname, designer, status, access_level, favorites,
 *				session_lapse
 *
 * Functions/Methods
 *		initialize($params)			Initialize class and output information
 *		set_session()				Universally SET admin sales related session info
 *		unset_session()				Universally UNSET admin sales related session info
 *		in_favorites($param)		Checks if a value ($param) exists in the sales user favorites
 *		update_favorites($param)	Adds a value ($param) to the sales suer favorites
 *
 * NOTE: There are related session variables that only sales user uses but must not be within
 * this class such as "admin_sales_login_time" which is compared to the property "session_lapse".
 *
 * NOTE: A couple of session variables "d_url_structure" and "c_url_structure" are used here but
 * has a generice name and may eventually have conflict with other session related variables of
 * the type. These are only related session variables but must be address to avoid name convention
 * conflicts.
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link
 */
class Sales_user_details
{
	/**
	 * Admin Sales User id
	 *
	 * @var	string
	 */
	public $admin_sales_id = '';

	/**
	 * Admin Sales Email
	 *
	 * @var	string
	 */
	public $email = '';

	/**
	 * Admin Sales Password
	 *
	 * @var	string
	 */
	public $password = '';

	/**
	 * Admin Sales User first name
	 *
	 * @var	string
	 */
	public $fname = '';

	/**
	 * Admin Sales Lname
	 *
	 * @var	string
	 */
	public $lname = '';

	/**
	 * Sales user reference designer
	 *
	 * @var	string
	 */
	public $des_id = '';
	public $designer = '';
	public $designer_name = '';

	/**
	 * Is Active
	 *
	 * @var	boolean
	 */
	public $status = '';

	/**
	 * Acces level
	 *
	 * @var	string
	 */
	public $access_level = '';

	/**
	 * Favorites
	 *
	 * @var	string
	 */
	public $favorites = array();

	/**
	 * Options
	 *
	 * Included in this options field are:
	 *		ott - one time tracking time() in md5 hash
	 *		preset 	- an array of preset sales package it
	 *				$presets = array(
	 *					'preorder' = $id,
	 *					'instock' = $id,
	 *					'onsale' = $id,
	 *					'bestseller' = $id
	 *				)
	 *
	 * @var	string
	 */
	public $options = array();

	/**
	 * Session Lapse
	 *
	 * Current set to 48 hours
	 *
	 * @var	int
	 */
	public $session_lapse = 172800; // (2 * 24 * 60 * 60);


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

		// get recrods
		$this->DB->select('tbladmin_sales.*');
		$this->DB->select('designer.designer, designer.des_id');
		$this->DB->join('designer', 'designer.url_structure = tbladmin_sales.admin_sales_designer', 'left');
		$this->DB->where($params);
		$query = $this->DB->get('tbladmin_sales');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->admin_sales_id = $row->admin_sales_id;
			$this->email = $row->admin_sales_email;
			$this->password = $row->admin_sales_password;
			$this->fname = $row->admin_sales_user;
			$this->lname = $row->admin_sales_lname;
			$this->des_id = $row->des_id;
			$this->designer = $row->admin_sales_designer;
			$this->designer_name = $row->designer;
			$this->status = $row->is_active;
			$this->access_level = $row->access_level;
			$this->favorites = ($row->favorites && $row->favorites != '') ? json_decode($row->favorites, TRUE) : array();
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();

			return $this;
		}
		else
		{
			// return variables to initial states
			$this->set_initial_state();

			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Update Sales User Details Options
	 *
	 * @return	this
	 */
	public function update_options($options = array())
	{
		if (empty($options))
		{
			// nothing more to do...
			return FALSE;
		}

		$this->options = $options;

		// update recrods
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('admin_sales_id', $this->admin_sales_id);
		$this->DB->update('tbladmin_sales');

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Is Item in Favorites
	 *
	 * Checks if an item is already in the favorites
	 *
	 * @param	String
	 * @return	Boolean TRUE/FALSE
	 */
	public function in_favorites($params = '')
	{
		if ( ! $params OR empty($this->favorites))
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// we know that potential favorites array max level is 2 deep only
			foreach ($this->favorites as $val)
			{
				if ($params === $val OR (is_array($val) && in_array($params, $val)))
				{
					return TRUE;
				}
			}

			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Update Favorites
	 *
	 * Update the favorites
	 *
	 * @params	array
	 * @return	Boolean True on Success / False on failure
	 */
	public function update_favorites(array $params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// update record
		$this->DB->set('favorites', json_encode($params));
		$this->DB->where('admin_sales_id', $this->admin_sales_id);
		$query = $this->DB->update('tbladmin_sales');

		// re-initialize class
		$this->initialize(array('admin_sales_email' => $this->email));

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Set OTT
	 *
	 * Set OTT (One Time Token) for hub and satellite site authentication
	 *
	 * @return	sting
	 */
	public function set_ott()
	{
		//Generate a random string.
		$token = openssl_random_pseudo_bytes(16);

		//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);

		// add to options
		$this->options['ott'] = $token;

		// update record
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('admin_sales_id', $this->admin_sales_id);
		$query = $this->DB->update('tbladmin_sales');

		// re-initialize class
		$this->initialize(array('admin_sales_id' => $this->admin_sales_id));

		return $token;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate OTT
	 *
	 * Validate OTT (One Time Token) for hub and satellite site authentication
	 *
	 * @return	Boolean True on Success / False on failure
	 */
	public function validate_ott($ott = '')
	{
		if (empty($ott))
		{
			// nothing more to do...
			return FALSE;
		}

		if (isset($this->options['ott']) && $this->options['ott'] === $ott)
		{
			// unset ott to avoid re-use
			unset($this->options['ott']);

			//return TRUE;
		}
		else return FALSE;

		// update record
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('admin_sales_id', $this->admin_sales_id);
		$query = $this->DB->update('tbladmin_sales');

		// re-initialize class
		$this->initialize(array('admin_sales_email' => $this->email));

		return TRUE;
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
			'admin_sales_loggedin'		=> TRUE,
			'admin_sales_id'			=> $this->admin_sales_id
		);
		$this->CI->session->set_userdata($sesdata);

		// forward compatibility
		$_SESSION['admin_sales_loggedin'] = TRUE;
		$_SESSION['admin_sales_id'] = $this->admin_sales_id;
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
				'admin_sales_loggedin'		=> FALSE,
				'admin_sales_id'			=> '',
				'admin_sales_login_time'	=> ''		// related to session_lapse property
			);
			$this->CI->session->unset_userdata($sesdata);
		}
		else
		{
			// this is legacy method and redundancy method
			$sesdata = array(
				'admin_sales_loggedin',
				'admin_sales_id',
				'admin_sales_login_time'				// related to session_lapse property
			);
			$this->CI->session->unset_userdata($sesdata);
		}

		// for redundancy purposes...
		if (isset($_SESSION['admin_sales_loggedin'])) unset($_SESSION['admin_sales_loggedin']);
		if (isset($_SESSION['admin_sales_id'])) unset($_SESSION['admin_sales_id']);
		if (isset($_SESSION['admin_sales_login_time'])) unset($_SESSION['admin_sales_login_time']);
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
		$this->admin_sales_id = '';
		$this->email = '';
		$this->password = '';
		$this->fname = '';
		$this->lname = '';
		$this->des_id = '';
		$this->designer = '';
		$this->designer_name = '';
		$this->status = '';
		$this->access_level = '';
		$this->favorites = '';
		$this->options = '';
	}

	// --------------------------------------------------------------------

}
