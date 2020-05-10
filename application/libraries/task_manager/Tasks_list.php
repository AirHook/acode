<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Task Manager Project Task List Class
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
class Tasks_list
{
	/**
	 * Current num_row count of object
	 * With or without limits
	 *
	 * @var	integer
	 */
	public $row_count = 0;

	/**
	 * Count of open task
	 * Based on input params
	 *
	 * @var	integer
	 */
	public $open_tasks = 0;


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
	public function __construct()
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Product List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	object List or FALSE on failure
	 */
	public function select(array $where = array())
	{
		// set $where custom conditions
		if ( ! empty($where))
		{
			foreach ($where as $key => $val)
			{
				if ($val !== '')
				{
					$this->DB->where($key, $val);
				}
			}
		}

		// selects
		$this->DB->select('tm_tasks.*, tm_users.*');
		$this->DB->select('
			(CASE
				WHEN tm_tasks.status = "0" THEN "0"
				WHEN tm_tasks.status = "1" THEN "0"
				WHEN tm_tasks.status = "3" THEN "0"
				ELSE "1"
			END) AS status_complete
		');
		$this->DB->select('
			(SELECT COUNT(*) FROM tm_tasks WHERE tm_tasks.status = "0" OR tm_tasks.status = "1" OR tm_tasks.status = "3") AS remaining_tasks
		');

		// join
		$this->DB->join('tm_users', 'tm_users.id = tm_tasks.user_id', 'left');

		// order by
		$this->DB->order_by('status_complete', 'asc');
		$this->DB->order_by('seque', 'asc');
		$this->DB->order_by('date_end_complete', 'desc');
		$this->DB->order_by('date_end_target', 'asc');

		// get records
		$query = $this->DB->get('tm_tasks');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();

			// let's get the open tasks
			$this->DB->select('COUNT(*) AS count');
			if ( ! empty($where))
			{
				foreach ($where as $key => $val)
				{
					if ($val !== '')
					{
						$this->DB->where($key, $val);
					}
				}
			}
			$this->DB->where('(tm_tasks.status = "0" OR tm_tasks.status = "1" OR tm_tasks.status = "3")');
			$q2 = $this->DB->get('tm_tasks');
			$r2	= $q2->row();
			$this->open_tasks = $r2->count;

			//echo $this->DB->last_query(); die();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	object List or FALSE on failure
	 */
	public function max_seque($project_id = '')
	{
		if ( ! $project_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// select
		$this->DB->select_max('seque', 'max_seque');
		$this->DB->where('project_id', $project_id);
		$query = $this->DB->get('tm_tasks');

		$row = $query->row();

		if (isset($row))
		{
			return $row->max_seque;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

}
