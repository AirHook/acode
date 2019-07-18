<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Themes List Class
 *
 * This class check for available themes list them all
 *
 * 
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Themes, Themes List
 * @author		WebGuy
 * @link		
 */
class Themes_list
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
		
		// set select items
		$this->DB->select('tbl_order_log.*');
		$this->DB->select('COUNT(qty) AS number_of_orders');
		$this->DB->select('SUM(qty) AS order_qty');
		$this->DB->select('SUM(unit_price) AS order_amount');
		$this->DB->select('tbl_order_log.order_log_id AS order_id');
		$this->DB->select('tbl_order_log_details.*');
		
		// set joins
		$this->DB->join('tbl_order_log_details', 'tbl_order_log_details.order_log_id = tbl_order_log.order_log_id', 'left');
		
		// group by
		$this->DB->group_by('tbl_order_log.order_log_id');
		
		// order by
		$this->DB->order_by('tbl_order_log.status', 'asc');
		$this->DB->order_by('tbl_order_log.order_log_id', 'desc');
		
		// get records
		$query = $this->DB->get('tbl_order_log');
		
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
