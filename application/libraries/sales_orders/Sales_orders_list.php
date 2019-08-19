<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales Orders List Class
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
class Sales_orders_list
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

		// check for limits
		if ($limit != '')
		{
			$this->DB->limit($limit);
		}

		// set select items
		$this->DB->select('sales_orders.*');
		/* *
		$this->DB->select('
			tbladmin_sales.admin_sales_user,
			tbladmin_sales.admin_sales_lname,
			tbladmin_sales.admin_sales_email
		');
		// */
		$this->DB->select('
			designer.designer,
			designer.url_structure
		');
		$this->DB->select('
			tbluser_data_wholesale.firstname,
			tbluser_data_wholesale.lastname,
			tbluser_data_wholesale.email,
			tbluser_data_wholesale.telephone
		');
		$this->DB->select('
			vendors.vendor_name,
			vendors.vendor_code
		');
		$this->DB->select('
			tbl_shipmethod.courier,
			tbl_shipmethod.fix_fee
		');

		// set joins
		//$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_id = sales_orders.admin_sales_id', 'left');
		$this->DB->join('designer', 'designer.des_id = sales_orders.des_id', 'left');
		$this->DB->join('tbluser_data_wholesale', 'tbluser_data_wholesale.user_id = sales_orders.user_id', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = sales_orders.vendor_id', 'left');
		$this->DB->join('tbl_shipmethod', 'tbl_shipmethod.ship_id = sales_orders.ship_id', 'left');

		// order by
		$this->DB->order_by('sales_orders.status', 'DESC');
		$this->DB->order_by('sales_orders.sales_order_id', 'DESC');

		// get records
		$query = $this->DB->get('sales_orders');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ( ! $query) return FALSE;

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

	//Select Max 10 for dashboard
	public function select_(array $where = array())
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

		// set select items
		$this->DB->select('sales_orders.*');
		/* *
		$this->DB->select('
			tbladmin_sales.admin_sales_user,
			tbladmin_sales.admin_sales_lname,
			tbladmin_sales.admin_sales_email
		');
		// */
		$this->DB->select('
			designer.designer,
			designer.url_structure
		');
		$this->DB->select('
			tbluser_data_wholesale.store_name,
			tbluser_data_wholesale.firstname,
			tbluser_data_wholesale.lastname,
			tbluser_data_wholesale.email,
			tbluser_data_wholesale.telephone
		');
		$this->DB->select('
			vendors.vendor_name,
			vendors.vendor_code
		');
		$this->DB->select('
			tbl_shipmethod.courier,
			tbl_shipmethod.fix_fee
		');

		// set joins
		//$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_id = sales_orders.admin_sales_id', 'left');
		$this->DB->join('designer', 'designer.des_id = sales_orders.des_id', 'left');
		$this->DB->join('tbluser_data_wholesale', 'tbluser_data_wholesale.user_id = sales_orders.user_id', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = sales_orders.vendor_id', 'left');
		$this->DB->join('tbl_shipmethod', 'tbl_shipmethod.ship_id = sales_orders.ship_id', 'left');

		// order by
		$this->DB->order_by('sales_orders.status', 'DESC');
		$this->DB->order_by('sales_orders.sales_order_id', 'DESC');
		$this->DB->limit(10);

		// get records
		$query = $this->DB->get('sales_orders');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ( ! $query) return FALSE;

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
	 * Get the latest PO#
	 *
	 * @return	String
	 */
	public function max_so_number()
	{
		$this->DB->select_max('sales_order_number');
		$query = $this->DB->get('sales_orders');
		$row = $query->row();
		if ($row) return $row->sales_order_number;
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
