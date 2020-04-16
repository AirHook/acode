<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Task Manager Projects List Class
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
class Projects_list
{
	/**
	 * Current num_row count of object
	 * With or without limits
	 *
	 * @var	integer
	 */
	public $row_count = 0;

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

		// join
		//$this->DB->join('tm_users', 'webspaces.webspace_id = tbladmin.webspace_id', 'left');

		// order by
		$this->DB->order_by('date_end', 'asc');
		$this->DB->order_by('date_start', 'desc');

		// get records
		$query = $this->DB->get('tm_projects');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

}
