<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Lookbook List Class
 *
 * This class' objective is to get the lookbook list based
 * on paramater input
 *
 * Default parameters yields the general list of products
 *
 * A config file is also available located at the
 * application/config folder (application/config/lookbook_list.php)
 * You can initialize this class using any config settings
 * available at the config while, or, you can create one
 * yourself
 *
 * Following are the initialization parameters:

	// no params needed for this list

 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Lookbook, Lookbook List
 * @author		WebGuy
 * @link
 */
class Lookbook_list
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

		log_message('info', 'Lookbook List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select($where = array())
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

		// set select items
		$this->DB->select('lookbook.*');
		$this->DB->select('tbladmin_sales.*');
		$this->DB->select('tbladmin_sales.options AS sales_user_options');

		// set joins
		$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_id = lookbook.user_id', 'left');

		// order by
		$this->DB->order_by('lookbook.date_create', 'desc');

		// get records
		$query = $this->DB->get('lookbook');

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
