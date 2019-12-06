<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Orders List Class
 *
 * This class list all the account for a specific hub site
 *
 * Following are the initialization parameters:

	// no params needed for this list

 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Product, Product List
 * @author		WebGuy
 * @link
 */
class Orders_list
{
	/**
	 * Pagination Parameter
	 *
	 * Used to be able to get the total number of records while getting only
	 * the number of items as per pagination limmits
	 *
	 * @var	boolean
	 */
	public $pagination = 0;

	/**
	 * Records count returned without the limit
	 * SQL FOUND_ROWS() or simply the general count
	 *
	 * @var	integer
	 */
	public $count_all = 0;

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
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Orders List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select(
		$where = array(),
		$order_by = array(),
		$limit = array(), // array('100, 100') (<limit>, <offset>)
		$having_des_group = FALSE, // string boolean
		$_search = NULL
	)
	{
		// set $where custom conditions
		if ( ! empty($where))
		{
			foreach ($where as $key => $val)
			{
				if ($val !== '')
				{
					// OR is usually for a simple OR conditioin
					if (strpos($key, 'OR ') !== FALSE)
					{
						$key = ltrim($key, 'OR ');
						$this->DB->or_where($key, $val);
					}
					else $this->DB->where($key, $val);
				}
			}
		}

		// limit (<limit>) only, or, (<limit>, <offset>)
		if ( ! empty($limit))
		{
			if (count($limit) > 1) $this->DB->limit($limit[0], $limit[1]);
			else $this->DB->limit($limit[0]);
		}

		// set limits if pagination is used
		// set SQL_CALC_FOUND_ROWS
		// $this->pagination is the page 1, 2, etc...
		if ($this->pagination > 0)
		{
			// we use SQL_CALC_FOUND_ROWS to calculate for entire record set
			$this->DB->select('SQL_CALC_FOUND_ROWS tbl_order_log.order_log_id', FALSE);
		}

		// set select items
		$this->DB->select('tbl_order_log.*');
		$this->DB->select('COUNT(qty) AS number_of_orders');
		$this->DB->select('SUM(qty) AS order_qty');
		$this->DB->select('SUM(unit_price) AS order_amount');
		$this->DB->select('tbl_order_log.order_log_id AS order_id');
		$this->DB->select('
			(CASE
				WHEN tbl_order_log.status = "1" THEN "1"
				ELSE tbl_order_log.status
			END) AS order_status
		');
		$this->DB->select('tbl_order_log_details.*');
		$this->DB->select('
			(CASE
				WHEN
					(SELECT COUNT(DISTINCT tbl_order_log_details.designer)
					FROM tbl_order_log_details
					WHERE tbl_order_log_details.order_log_id = tbl_order_log.order_log_id) = "1"
					THEN tbl_order_log_details.designer
				ELSE "Mixed Designers"
			END) AS designer_group
		');

		// set joins
		$this->DB->join('tbl_order_log_details', 'tbl_order_log_details.order_log_id = tbl_order_log.order_log_id', 'left');

		if ($having_des_group)
		{
			$this->DB->or_having('designer_group', $having_des_group);
		}

		// group by
		$this->DB->group_by('tbl_order_log.order_log_id');

		// set $order_by custom conditions
		if ( ! empty($order_by))
		{
			foreach ($order_by as $key => $val)
			{
				if ($val !== '')
				{
					$this->DB->order_by($key, $val);
				}
			}
		}

		// end with default order by
		$this->DB->order_by('order_status', 'asc');
		$this->DB->order_by('tbl_order_log.order_date', 'desc');
		$this->DB->order_by('tbl_order_log.order_log_id', 'desc');

		// get records
		$query = $this->DB->get('tbl_order_log');

		//echo $this->DB->last_query(); die();

		// when pagination is used
		if ($this->pagination > 0)
		{
			// get total count without limits...
			$q = $this->DB->query('SELECT FOUND_ROWS()')->row_array();
			$this->count_all = $q['FOUND_ROWS()'];
		}

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
