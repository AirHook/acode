<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Task Manager Project Details Class
 *
 * Following are the initialization parameters:

	// write params here where necessary...

 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Users, User List, Task Manager
 * @author		WebGuy
 * @link
 */
class Project_details
{
	/**
	 * Project ID
	 *
	 * @var	numeric
	 */
	public $project_id = '';

	/**
	 * Project Name and aliases
	 *
	 * @var	string
	 */
	public $project_name = '';
	public $name = ''; // alias

	/**
	 * Project Description
	 *
	 * @var	string
	 */
	public $project_description = '';
	public $description = '';  // alias

	/**
	 * Dates
	 *
	 * @var	string
	 */
	public $date_start = '';
	public $date_end = '';
	public $last_modified = '';

	/**
	 * Status
	 *
	 * @var	numeric
	 */
	public $status = '';

	/**
	 * Options
	 *
	 * @var	numeric
	 */
	public $options = array();

	/**
	 * Webspace Details
	 *
	 * @var	string
	 */
	public $webspace_id = '';
	public $webspace_name = '';
	public $webspace_slug = '';
	public $domain_name = '';

	/**
	 * Platform Details
	 *
	 * @var	string
	 */
	public $platform = '';
	public $platform_name = '';


	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';

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
		log_message('info', 'Product List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	object
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// selects
		$this->DB->select('tm_projects.*');
		$this->DB->select('webspaces.*');
		$this->DB->select('platform.webspace_name as platform_name');

		// joins
		$this->DB->join('webspaces', 'webspaces.webspace_id = tm_projects.webspace_id', 'left');
		$this->DB->join('webspaces platform', 'platform.webspace_slug = tm_projects.platform', 'left');

		// order by
		//$this->DB->order_by('admin_name', 'asc');

		// get records
		$this->DB->where($params);
		$query = $this->DB->get('tm_projects');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->project_id = $row->project_id;
			$this->project_name = $row->name;
			$this->name = $row->name;
			$this->project_description = $row->description;
			$this->description = $row->description;
			$this->date_start = $row->date_start;
			$this->date_end = $row->date_end;
			$this->last_modified = $row->last_modified;
			$this->status = $row->status;
			$this->options = $row->options != '' ? json_decode($row->options , TRUE) : array();

			$this->webspace_id = $row->webspace_id;
			$this->webspace_name = $row->webspace_name;
			$this->webspace_slug = $row->webspace_slug;
			$this->domain_name = $row->domain_name;

			$this->platform = $row->platform;
			$this->platform_name = $row->platform_name;

			return $this;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

}
