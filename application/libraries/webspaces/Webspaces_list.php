<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Webspace List Class
 *
 * This class list all the webspaces for a specific hub site
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
class Webspaces_list
{
	/**
	 * Frist row of any current query
	 *
	 * @var	object
	 */
	public $first_row = 0;
	
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
					$this->DB->where($key, $val);
				}
			}
		}
		
		// selects
		$this->DB->select('*');
		$this->DB->select('
			(CASE 
				WHEN webspaces.webspace_options LIKE "%hub_site%"
				THEN "hub_site"
				ELSE ""
			END) AS site_type
		');
		
		// set joins
		$this->DB->join('accounts', 'accounts.account_id = webspaces.account_id', 'left');
		
		// order by
		$this->DB->order_by('seque', 'asc');
		$this->DB->order_by('webspace_slug', 'asc');
		
		// get records
		$query = $this->DB->get('webspaces');
		
		//echo $this->DB->last_query(); die();
		
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
