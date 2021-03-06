<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales Users List Class
 *
 * This class' objective is to get the sales users list based
 * on paramater input for csv purposes
 *
 * 
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Users, Sales Users
 * @author		WebGuy
 * @link		
 */
class Sales_users_list_csv
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
					if (strpos($key, 'OR ') !== FALSE)
					{
						$key = ltrim($key, 'OR ');
						$this->DB->or_where($key, $val);
					}
					else
					{
						$this->DB->where($key, $val);
					}
				}
			}
		}
		
		// selects
		$this->DB->select('tbladmin_sales.*');
		$this->DB->select('
			designer.designer,
			designer.url_structure
		');
		// order by
		$this->DB->join('designer', 'designer.url_structure = tbladmin_sales.admin_sales_designer', 'left');
		
		// order by
		$this->DB->order_by('tbladmin_sales.is_active', 'desc');
		$this->DB->order_by('admin_sales_user', 'asc');
		
		// get records
		$query = $this->DB->get('tbladmin_sales');
		
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
