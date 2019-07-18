<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Vendor Types List Class
 *
 * This class list all the vendor types that differentiate
 * vendors amongst each other
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	User, Vendors, Vendor Types List
 * @author		WebGuy
 * @link		
 */
class Vendor_types_list
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
		
		log_message('info', 'Vendor Types List Class Loaded');
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
		
		// order by
		$this->DB->order_by('slug', 'asc');
		
		// get records
		$query = $this->DB->get('vendor_types');
		
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

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function get_vendor_id($slug = '')
	{
		// set $where custom conditions
		if ($slug == '')
		{
			return FALSE;
		}
		
		$this->DB->select('id');
		$this->DB->where('slug', $slug);
		$query = $this->DB->get('vendor_types');
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// return the value
			return $query->row()->id;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function get_vendor_slug($id = '')
	{
		// set $where custom conditions
		if ($id == '')
		{
			return FALSE;
		}
		
		$this->DB->select('slug');
		$this->DB->where('id', $id);
		$query = $this->DB->get('vendor_types');
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// return the value
			return $query->row()->slug;
		}
	}
	
	// --------------------------------------------------------------------

}
