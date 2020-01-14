<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Purchase Orders List Class
 *
 * This class list all the PO
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Purchase Orders, Purchase Orders List
 * @author		WebGuy
 * @link
 */
class Purchase_orders_list
{
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

		log_message('info', 'Purchase Orders List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select(array $where = array(), $limit = '')
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

		// check for limits
		// and get total rows count
		if ($limit != '')
		{
			$this->DB->limit($limit);

			// we use SQL_CALC_FOUND_ROWS to calculate for entire record set
			$this->DB->select('SQL_CALC_FOUND_ROWS purchase_orders.po_id', FALSE);
		}

		// set select items
		$this->DB->select('purchase_orders.*');
		$this->DB->select('tbluser_data_wholesale.store_name');
		$this->DB->select('designer.designer');
		$this->DB->select('vendors.vendor_name, vendors.vendor_code');

		// set joins
		$this->DB->join('designer', 'designer.des_id = purchase_orders.des_id', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = purchase_orders.vendor_id', 'left');
		$this->DB->join('tbluser_data_wholesale', 'tbluser_data_wholesale.user_id = purchase_orders.user_id', 'left');

		// order by
		$this->DB->order_by('purchase_orders.status', 'ASC');
		$this->DB->order_by('purchase_orders.po_number', 'DESC');

		// get records
		$query = $this->DB->get('purchase_orders');

		//echo $this->DB->last_query(); die('<br />DIED');

		// save last query string (with out the LIMIT portion)
		$this->last_query =
			strpos($this->DB->last_query(), 'LIMIT')
			? substr($this->DB->last_query(), 0, strpos($this->DB->last_query(), 'LIMIT'))
			: $this->DB->last_query()
		;

		if ( ! $query) return FALSE;

		// get overall total row count
		if ($limit != '')
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
			if ($limit == '') $this->count_all = $query->num_rows();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get the latest PO#
	 *
	 * @return	String
	 */
	public function max_po_number()
	{
		$this->DB->select_max('po_number');
		$query = $this->DB->get('purchase_orders');
		$row = $query->row();
		if ($row) return $row->po_number;
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
