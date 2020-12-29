<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Carousel Details Class
 *
 * This class' objective is to output order details as properties for use in the entire
 * HTML output.
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Orders
 * @author		WebGuy
 * @link
 */
class Carousel_details
{
	/**
	 * Item ID's
	 * Etc...
	 *
	 * @var	string
	 */
	public $id = '';
	public $carousel_id = ''; // alias

	/**
	 * Type
	 *
	 * @var	string
	 */
	public $type = '';
	public $carousel_type = ''; // alias

	/**
	 * Layout
	 *
	 * @var	string
	 */
	public $layout = '';
	public $carousel_layout = ''; // alias

	/**
	 * Name - a name for the carousel used as a friendly indentification for the carousel
	 *
	 * @var	string
	 */
	public $name = '';
	public $carousel_name = ''; // alias

	/**
	 * Users
	 *
	 * @var	string
	 */
	public $users = '';

	/**
	 * Other items
	 *
	 * @var	string
	 */
	public $designer = array();
	public $stock_condition = '';

	/**
	 * Subjects and Messages - email content
	 *
	 * @var	array
	 */
	public $subject = array();
	public $message = array();

	/**
	 * Subjects and Messages - email content
	 *
	 * @var	int (timestamp)
	 */
	public $date_created = '';
	public $last_modified = '';

	/**
	 * Status
	 *
	 * @var	boolean/int
	 */
	public $status = ''; // 0-inactive,1-active

	/**
	 * Schedule
	 *
	 * @var	int (timestamp)
	 */
	public $schedule = '';

	/**
	 * Cron Data
	 *
	 * @var	array
	 */
	public $cron_data = array();

	/**
	 * Thumbs Sent
	 *
	 * @var	array
	 */
	public $thumbs_sent = array();

	/**
	 * Options
	 *
	 * @var	array
	 */
	public $options = array();

	/**
	 * Webspace ID - where carousel is made
	 *
	 * @var	string/array
	 */
	public $webspace_id = '';


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
	 * @params	array	$params	Initialization parameter - the item id
	 *					where prod_id = $params
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Page Details Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @return	Order_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// carry on
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				$this->DB->where($key, $val);
			}
		}

		// set select item
		$this->DB->select('carousels.*');
		$this->DB->select('webspaces.domain_name, webspaces.webspace_name, webspaces.info_email');
		$this->DB->join('webspaces', 'webspaces.webspace_id = carousels.webspace_id', 'left');
		$query = $this->DB->get('carousels');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->id = $row->carousel_id;
			$this->carousel_id = $row->carousel_id;

			$this->type = $row->type;
			$this->carousel_type = $row->type;

			$this->layout = $row->layout;
			$this->carousel_layout = $row->layout;

			$this->name = $row->name;
			$this->carousel_name = $row->name;

			$this->users = $row->users;
			$this->designer = ($row->designer && $row->designer != '') ? json_decode($row->designer , TRUE) : array();
			$this->stock_condition = $row->stock_condition;

			$this->subject = ($row->subject && $row->subject != '') ? json_decode($row->subject , TRUE) : array();
			$this->message = ($row->message && $row->message != '') ? json_decode($row->message , TRUE) : array();

			$this->date_created = $row->date_created;
			$this->last_modified = $row->last_modified;

			$this->status = $row->status;

			$this->schedule = $row->schedule;
			$this->cron_data = ($row->cron_data && $row->cron_data != '') ? json_decode($row->cron_data , TRUE) : array();

			$this->thumbs_sent = ($row->thumbs_sent && $row->thumbs_sent != '') ? json_decode($row->thumbs_sent , TRUE) : array();
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();

			$this->webspace_id = $row->webspace_id;

			return $this;
		}
		else
		{
			// since there is no record, return false...
			$this->order_id = '';
			return FALSE;
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
		$this->id = '';
		$this->carousel_id = '';
		$this->type = '';
		$this->carousel_type = '';
		$this->layout = '';
		$this->carousel_layout = '';
		$this->name = '';
		$this->carousel_name = '';
		$this->users = '';
		$this->designer = array();
		$this->stock_condition = '';
		$this->date_created = '';
		$this->last_modified = '';
		$this->status = '';
		$this->schedule = '';
		$this->cron_data = array();
		$this->subject = array();
		$this->message = array();
		$this->thumbs_sent = array();
		$this->options = array();
		$this->webspace_id = '';

		return $this;
	}

	// --------------------------------------------------------------------

}
