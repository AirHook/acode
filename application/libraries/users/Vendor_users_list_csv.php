<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Vendor Users List Class
 *
 * This class' objective is to get the vendor user list based
 * on paramater input
 *
 * 
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Users, Vendor Users List
 * @author		WebGuy
 * @link		
 */
class Vendor_users_list_csv
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
	public function __construct(array $params = array())
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
		// set custom where conditions
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
		$this->DB->select('vendors.*');
		$this->DB->select('
			designer.designer,
			designer.url_structure
		');
		$this->DB->select('vendor_types.id, vendor_types.type, vendor_types.slug');
		
		// joins
		$this->DB->join('designer', 'designer.folder = vendors.reference_designer', 'left');
		$this->DB->join('vendor_types', 'vendor_types.id = vendors.vendor_type_id', 'left');
		
		// order by
		$this->DB->order_by('vendors.vendor_id', 'ASC');
		
		// get records
		$query = $this->DB->get('vendors');
		
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
