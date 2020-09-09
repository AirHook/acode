<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales Package Details Class
 *
 * This class' shows the list of items in a created sales package
 *
 * Properties:	sales_package_id, name, items, date_create, last_modified
 *
 * Functions/Methods
 *		initialize($params)			Initialize class and output information
 *		set_session()				Universally SET admin sales related session info
 *		unset_session()				Universally UNSET admin sales related session info
 *		in_favorites($param)		Checks if a value ($param) exists in the sales user favorites
 *		update_favorites($param)	Adds a value ($param) to the sales suer favorites
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link
 */
class Sales_package_details
{
	/**
	 * Sales Package Id
	 *
	 * @var	string
	 */
	public $sales_package_id = '';

	/**
	 * NAME of sales package
	 *
	 * @var	string
	 */
	public $sales_package_name = '';

	/**
	 * Sales User Association
	 *
	 * @var	string
	 */
	public $sales_user = '';

	/**
	 * Set as Default
	 *
	 * @var	string
	 */
	public $set_as_default = '';

	/**
	 * Author
	 *
	 * @var	string
	 */
	public $author = '';

	/**
	 * Email Subject
	 *
	 * @var	string
	 */
	public $email_subject = '';

	/**
	 * Email Message
	 *
	 * @var	string
	 */
	public $email_message = '';

	/**
	 * Designer details
	 *
	 * @var	array
	 */
	public $designer_name = '';
	public $designer_slug = '';
	public $designer_logo = '';

	/**
	 * Selected items for the sales package
	 *
	 * @var	array
	 */
	public $sales_package_items = '';
	public $items = array();

	/**
	 * Edite prices for the sales package
	 *
	 * @var	array
	 */
	public $sales_package_prices = '';
	public $prices = array();

	/**
	 * Options
	 *
	 * @var	array
	 */
	public $options = array();

	/**
	 * Date Create
	 *
	 * @var	string
	 */
	public $date_create = ''; // date string
	public $date_create_ts = ''; // date timestamp

	/**
	 * Last Modified
	 *
	 * @var	string
	 */
	public $last_modified = '';

	/**
	 * Last Modified
	 *
	 * @var	string
	 */
	public $items_count = 0;

	/**
	 * Session Lapse
	 *
	 * Current set to 72 hours
	 *
	 * @var	int
	 */
	public $session_lapse = 259200; // (3 * 24 * 60 * 60);


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
	 *
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
		$this->DB->where($params);
		$this->DB->join('designer', 'designer.webspace_id = sales_packages.webspace_id', 'left');
		$query = $this->DB->get('sales_packages');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->sales_package_id = $row->sales_package_id;
			$this->sales_package_name = $row->sales_package_name;
			$this->sales_user = $row->sales_user;
			$this->set_as_default = $row->set_as_default;
			$this->author = $row->author;
			$this->email_subject = $row->email_subject;
			$this->email_message = $row->email_message;
			$this->date_create = $row->date_create;
			$this->date_create_ts = $row->date_create;
			$this->last_modified = $row->last_modified;

			// designer details
			$this->designer_name = $row->designer;
			$this->designer_slug = $row->url_structure;
			$this->designer_logo = $row->logo; // full path and filename used in current admin add/edit designer

			// the items
			$this->sales_package_items = $row->sales_package_items;
			$this->items = $row->sales_package_items != '' ? json_decode($row->sales_package_items , TRUE) : array();
			//$this->sales_package_prices = $row->edited_prices;
			//$this->prices = $row->edited_prices != '' ? json_decode($row->edited_prices , TRUE) : array();
			$this->items_count = count($this->items);

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
	 * Universally SET Admin Sales only session
	 *
	 * @return	void
	 */
	public function click_one($user_id = '', $tc = '', $id = '')
	{
		if ($user_id == '' OR $tc == '' OR $id =='')
		{
			// nothing more to do...
			return FALSE;
		}

		// update property
		$this->options[$user_id][$tc] = $id;

		// update recrods
		$this->DB->set('options', json_encode($this->options));
		$this->DB->where('sales_package_id', $this->sales_package_id);
		$this->DB->update('sales_packages');

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Universally SET Admin Sales only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		$sesdata = array(
			'sales_package' => TRUE,
			'sales_package_id' => $this->sales_package_id
		);
		$this->CI->session->set_userdata($sesdata);
	}

	// --------------------------------------------------------------------

	/**
	 * Universally Unset Admin Sales only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
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
		$this->sales_package_id = '';
		$this->sales_package_name = '';
		$this->sales_user = '';
		$this->set_as_default = '';
		$this->author = '';
		$this->email_subject = '';
		$this->email_message = '';
		$this->date_create = '';
		$this->last_modified = '';
		// the items
		$this->items = array();
		$this->items_count = 0;
		$this->options = array();
	}

	// --------------------------------------------------------------------

}
