<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Lookbook Details Class
 *
 * This class' shows the details of a selected lookbook
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link
 */
class Lookbook_details
{
	/**
	 * Lookbook Id
	 *
	 * @var	string
	 */
	public $lookbook_id = '';

	/**
	 * NAME of lookbook
	 *
	 * @var	string
	 */
	public $lookbook_name = '';

	/**
	 * Author Role (admin/sales)
	 *
	 * @var	string
	 */
	public $user_role = '';

	/**
	 * Author User ID
	 *
	 * @var	string
	 */
	public $user_id = '';

	/**
	 * Author Name
	 *
	 * @var	string
	 */
	public $user_name = '';

	/**
	 * Author Email
	 *
	 * @var	string
	 */
	public $user_email = '';

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
	public $lookbook_items = '';
	public $items = array();

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
		log_message('info', 'Lookbook Details Class Initialized');
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
		$this->DB->select('lookbook.*, lookbook.options AS lb_options');
		$this->DB->select('designer.*');
		$this->DB->select('tbladmin_sales.*');
		$this->DB->join('designer', 'designer.url_structure = lookbook.designer', 'left');
		$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_id = lookbook.user_id', 'left');
		$query = $this->DB->get('lookbook');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->lookbook_id = $row->lookbook_id;
			$this->lookbook_name = $row->lookbook_name;
			$this->user_role = $row->user_role;
			$this->user_id = $row->user_id;
			$this->user_name = $row->user_name;
			$this->user_email = $row->user_email;
			$this->email_subject = $row->email_subject;
			$this->email_message = $row->email_message;
			$this->date_create = $row->date_create;
			$this->date_create_ts = $row->date_create;
			$this->last_modified = $row->last_modified;

			// designer details
			$this->designer = $row->designer;
			$this->designer_name = $row->designer;
			$this->designer_slug = $row->url_structure;
			$this->designer_logo = $row->logo; // full path and filename used in current admin add/edit designer

			// the items
			$this->lookbook_items = $row->items;
			$this->items = $row->items != '' ? json_decode($row->items , TRUE) : array();
			//$this->sales_package_prices = $row->edited_prices;
			//$this->prices = $row->edited_prices != '' ? json_decode($row->edited_prices , TRUE) : array();
			$this->items_count = count($this->items);

			$this->options = $row->lb_options != '' ? json_decode($row->lb_options , TRUE) : array();

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
			'lookbook' => TRUE,
			'lookbook_id' => $this->lookbook_id
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
			'lookbook' => FALSE,
			'lookbook_id' => '',
			'lookbook_items' => '',
			'lookbook_tc' => ''
		);
		$this->CI->session->unset_userdata($sesdata);

		if (isset($_SESSION['lookbook'])) unset($_SESSION['lookbook']);
		if (isset($_SESSION['lookbook_id'])) unset($_SESSION['lookbook_id']);
		if (isset($_SESSION['lookbook_items'])) unset($_SESSION['lookbook_items']);
		if (isset($_SESSION['lookbook_tc'])) unset($_SESSION['lookbook_tc']);
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
		$this->lookbook_id = '';
		$this->lookbook_name = '';
		$this->user_role = '';
		$this->user_id = '';
		$this->user_name = '';
		$this->user_email = '';
		$this->email_subject = '';
		$this->email_message = '';
		$this->date_create = '';
		$this->date_create_ts = '';
		$this->last_modified = '';
		$this->designer_name = '';
		$this->designer_slug = '';
		$this->designer_logo = '';

		// the items
		$this->lookbook_items = '';
		$this->items = array();
		$this->items_count = 0;
		$this->options = array();
	}

	// --------------------------------------------------------------------

}
