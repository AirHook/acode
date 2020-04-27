<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Task Manager Task Details Class
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Users, User List, Task Manager
 * @author		WebGuy
 * @link
 */
class Project_task_details
{
	/**
	 * Task ID
	 *
	 * @var	numeric
	 */
	public $task_id = '';

	/**
	 * Seque
	 *
	 * @var	numeric
	 */
	public $seque = '';

	/**
	 * Task Title
	 *
	 * @var	string
	 */
	public $title = '';

	/**
	 * Task Description
	 *
	 * @var	string
	 */
	public $description = '';

	/**
	 * Project Details
	 *
	 * @var	string
	 */
	public $project_id = '';
	public $project_name = '';
	public $project_description = '';

	/**
	 * User Details
	 *
	 * @var	string
	 */
	public $user_id = '';
	public $fname = '';
	public $lname = '';
	public $email = '';

	/**
	 * Dates
	 *
	 * @var	string
	 */
	public $date_start = '';
	public $date_end_target = '';
	public $date_end_complete = '';
	public $last_modified = '';

	/**
	 * Status
	 *
	 * @var	string
	 */
	public $status = '';
	public $urgent = '';

	/**
	 * Options
	 *
	 * @var	numeric
	 */
	public $options = array();


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
		log_message('info', 'Task Details Class Loaded and Initialized');
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

		// set selects
		$this->DB->select('tm_tasks.*');
		$this->DB->select('tm_tasks.status as task_status');
		$this->DB->select('tm_tasks.date_start AS task_date_start');
		$this->DB->select('tm_tasks.last_modified AS task_last_modified');
		$this->DB->select('tm_tasks.options AS task_options');
		$this->DB->select('tm_projects.*');
		$this->DB->select('tm_projects.description AS project_description');
		$this->DB->select('tm_users.*');

		// join
		$this->DB->join('tm_projects', 'tm_projects.project_id = tm_tasks.project_id', 'left');
		$this->DB->join('tm_users', 'tm_users.id = tm_tasks.user_id', 'left');

		// order by
		//$this->DB->order_by('admin_name', 'asc');

		// get records
		$this->DB->where($params);
		$query = $this->DB->get('tm_tasks');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->task_id = $row->task_id;
			$this->seque = $row->seque;
			$this->title = $row->title;
			$this->description = $row->description;
			$this->project_id = $row->project_id;
			$this->project_name = $row->name;
			$this->project_description = $row->project_description;
			$this->user_id= $row->id;
			$this->email = $row->email;
			$this->fname = $row->fname;
			$this->lname = $row->lname;
			$this->date_start = $row->task_date_start;
			$this->date_end_target = $row->date_end_target;
			$this->date_end_complete = $row->date_end_complete;
			$this->last_modified = $row->task_last_modified;
			$this->status = $row->task_status;
			$this->urgent = $row->urgent;
			$this->options = $row->task_options != '' ? json_decode($row->task_options , TRUE) : array();
			$this->attachments = $row->attachments != '' ? json_decode($row->attachments , TRUE) : array();

			return $this;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Task Attachments
	 *
	 * @return	object
	 */
	public function attachments()
	{
		if (empty($this->attachments))
		{
			return FALSE;
		}

		foreach ($this->attachments as $media_id)
		{
			$this->DB->or_where('media_id', $media_id);
		}

		// get records
		$query = $this->DB->get('media_library');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

}
