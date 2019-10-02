<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Purchase Order Details Class
 *
 * This class' objective is to output purchase order details as properties
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Purchase Orders
 * @author		WebGuy
 * @link
 */
class Sales_order_details
{
	/**
	 * ID's
	 * Etc...
	 *
	 * @var	int
	 */
	public $sales_order_id = '';
	public $so_id = ''; // alias
	public $sales_order_number = '';
	public $so_number = ''; // alias
	public $rev = '';
	public $amount = '';
	public $so_amount = '';

	/**
	 * Order Date (timestamp)
	 *
	 * @var	int
	 */
	public $sales_order_date = '';
	public $so_date = ''; // alias

	/**
	 * Ship By Date (timestamp)
	 *
	 * @var	int
	 */
	public $delivery_date = '';
	public $due_date = ''; // alias

	/**
	 * Sales User Details --> author can either be a sales or admin user so we cannot do this
	 *
	 * @var	int
	 *
	public $admin_sales_id = '';
	public $admin_sales_user = '';
	public $admin_sales_lname = '';
	public $admin_sales_email = '';
	// */

	/**
	 * Author
	 *
	 * @var	int
	 */
	public $author = '';
	public $c = '';	// 1-admin,2-sales

	/**
	 * Designer Details
	 *
	 * @var	int
	 */
	public $des_id = '';
	public $designer = '';
	public $designer_slug = '';

	/**
	 * Store Details
	 *
	 * @var	int
	 */
	public $user_id = '';
	public $user_cat = '';
	public $store_name = '';
	public $firstname = '';
	public $lastname = '';
	public $email = '';
	public $telephone = '';

	/**
	 * Vendor Details
	 *
	 * @var	int
	 */
	public $vendor_id = '';
	public $vendor_name = '';
	public $vendor_code = '';

	/**
	 * Order Statuses
	 *
	 * @var	string/array
	 */
	public $status = ''; // 1 - complete, 2 - hold, 3 - return, 4 - pending
	public $return_remarks = ''; // 1 - for exchange, 2 - for store credit, 3 - for refund, 4 - others
	public $comments = '';

	/**
	 * Order Logistics
	 *
	 * @var	string/array
	 */
	public $ship_id = '';
	public $courier = '';
	public $shipping_fee = '';

	/**
	 * Ship and Bill to addresses
	 *
	 * @var	string/array
	 */
	public $ship_address1 = '';
	public $ship_address2 = '';
	public $ship_city = '';
	public $ship_state = '';
	public $ship_country = '';
	public $ship_zipcode = '';
	public $bill_address1 = '';
	public $bill_address2 = '';
	public $bill_city = '';
	public $bill_state = '';
	public $bill_country = '';
	public $bill_zipcode = '';

	/**
	 * Order Details
	 *
	 * @var	string/array
	 */
	public $items = array();
	public $options = array();
	public $remarks = '';


	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

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
	 * @params	array	$params	Initialization parameter - the item id
	 *					where prod_id = $params
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Purchase Order Details Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @return	Order_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			$this->deinitialize();
			return FALSE;
		}

		// set $where custom conditions
		if ( ! empty($params))
		{
			foreach ($params as $key => $val)
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

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->sales_order_id = $row->sales_order_id;
			$this->sales_order_number = $row->sales_order_number;
			$this->rev = $row->rev;
			$this->sales_order_date = @date('Y-m-d', $row->sales_order_date);
			$this->amount = $row->amount;

			// aliases
			$this->so_id = $row->sales_order_id;
			$this->so_number = $row->sales_order_number;
			$this->so_date = @date('Y-m-d', $row->sales_order_date);
			$this->so_amount = $row->amount;

			$this->delivery_date = @date('Y-m-d', $row->due_date);
			$this->due_date = @date('Y-m-d', $row->due_date);

			/* *
			$this->admin_sales_id = $row->admin_sales_id;
			$this->admin_sales_user = $row->admin_sales_user;
			$this->admin_sales_lname = $row->admin_sales_lname;
			$this->admin_sales_email = $row->admin_sales_email;
			// */

			$this->author = $row->author;
			$this->c = $row->c; // 1-admin,2-sales

			$this->des_id = $row->des_id;
			$this->designer = $row->designer;
			$this->designer_slug = $row->url_structure;

			$this->user_id = $row->user_id;
			$this->user_cat = $row->user_cat;

			$this->store_name = $row->store_name;
			$this->firstname = $row->firstname;
			$this->lastname = $row->lastname;
			$this->email = $row->email;
			$this->telephone = $row->telephone;

			$this->vendor_id = $row->vendor_id;
			$this->vendor_name = $row->vendor_name;
			$this->vendor_code = $row->vendor_code;

			$this->status = $row->status; // 1 - complete, 2 - hold, 3 - return, 4 - pending
			$this->return_remarks = $row->return_remarks; // 1 - for exchange, 2 - for store credit, 3 - for refund, 4 - others
			//$this->comments = $row->comments;

			$this->ship_id = $row->ship_id;
			$this->courier = $row->courier;
			$this->shipping_fee = $row->fix_fee;

			$this->ship_address1 = $row->ship_address1;
			$this->ship_address2 = $row->ship_address2;
			$this->ship_city = $row->ship_city;
			$this->ship_state = $row->ship_state;
			$this->ship_country = $row->ship_country;
			$this->ship_zipcode = $row->ship_zipcode;
			$this->bill_address1 = $row->bill_address1;
			$this->bill_address2 = $row->bill_address2;
			$this->bill_city = $row->bill_city;
			$this->bill_state = $row->bill_state;
			$this->bill_country = $row->bill_country;
			$this->bill_zipcode = $row->bill_zipcode;

			// the items
			$this->items = ($row->items && $row->items != '') ? json_decode($row->items , TRUE) : array();
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();
			$this->remarks = $row->remarks;

			return $this;
		}
		else
		{
			// since there is no record, return false...
			$this->deinitialize();
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function deinitialize()
	{
		// de-initialize properties
		$this->sales_order_id = '';
		$this->sales_order_number = '';
		$this->rev = '';
		$this->sales_order_date = '';
		$this->amount = '';

		$this->so_id = '';
		$this->so_number = '';
		$this->so_date = '';
		$this->so_amount = '';

		$this->delivery_date = '';
		$this->due_date = '';

		/* *
		$this->admin_sales_id = '';
		$this->admin_sales_user = '';
		$this->admin_sales_lname = '';
		$this->admin_sales_email = '';
		// */

		$this->author = '';
		$this->c = '';

		$this->des_id = '';
		$this->designer = '';
		$this->designer_slug = '';

		$this->user_id = '';
		$this->user_cat = '';
		
		$this->store_name = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';

		$this->vendor_id = '';
		$this->vendor_name = '';
		$this->vendor_code = '';

		$this->status = ''; // 1 - complete, 2 - hold, 3 - return, 4 - pending
		$this->return_remarks = ''; // 1 - for exchange, 2 - for store credit, 3 - for refund, 4 - others
		$this->comments = '';

		$this->ship_id = '';
		$this->courier = '';
		$this->shipping_fee = '';

		$this->ship_address1 = '';
		$this->ship_address2 = '';
		$this->ship_city = '';
		$this->ship_state = '';
		$this->ship_country = '';
		$this->ship_zipcode = '';
		$this->bill_address1 = '';
		$this->bill_address2 = '';
		$this->bill_city = '';
		$this->bill_state = '';
		$this->bill_country = '';
		$this->bill_zipcode = '';

		// the items
		$this->items = array();
		$this->options = array();
		$this->remarks = '';

		return $this;
	}

	// --------------------------------------------------------------------

}
