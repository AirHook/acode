<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Carousels List Class
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
class Carousels_list
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
	 * Last DB query string
	 *
	 * @var	boolean/string
	 */
	public $last_query = FALSE;


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
				if ($key === 'condition')
				{
					if (is_array($val))
					{
						foreach ($where['condition'] as $this_where_clause)
						{
							$this->DB->where($this_where_clause);
						}
					}
					else $this->DB->where($val);
				}
				else
				{
					if ($val !== '')
					{
						// OR is usually for a simple OR conditioin
						if (strpos($key, 'OR ') !== FALSE)
						{
							$key = ltrim(trim($key), 'OR ');
							$this->DB->or_where($key, $val);
						}
						else $this->DB->where($key, $val);
					}
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
			$this->DB->select('SQL_CALC_FOUND_ROWS carousels.carousel_id', FALSE);
		}

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

		// set select items
		$this->DB->select('carousels.*');
		$this->DB->select('webspaces.domain_name, webspaces.webspace_name, webspaces.info_email');
		$this->DB->join('webspaces', 'webspaces.webspace_id = carousels.webspace_id', 'left');
		$query = $this->DB->get('carousels');

		//echo $this->DB->last_query(); die();

		// save last query string (with out the LIMIT portion)
		$this->last_query =
			strpos($this->DB->last_query(), 'LIMIT')
			? substr($this->DB->last_query(), 0, strpos($this->DB->last_query(), 'LIMIT'))
			: $this->DB->last_query()
		;

		// when pagination is used
		if ($this->pagination > 0)
		{
			// get total count without limits...
			$q = $this->DB->query('SELECT FOUND_ROWS()')->row_array();
			$this->count_all = $q['FOUND_ROWS()'];
		}

		if (@$query)
		{
			if (@$query->num_rows() > 0)
			{
				$this->row_count = $query->num_rows();

				// return the object
				return $query->result();
			}
		}
		else
		{
			// nothing more to do...
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

}
