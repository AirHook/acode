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
class Purchase_order_details
{
	/**
	 * ID's
	 * Etc...
	 *
	 * @var	string
	 */
	public $po_id = '';
	public $des_code = '';
	public $po_number = '';
	public $rev = '';

	/**
	 * Order Statuses
	 *
	 * @var	string/array
	 */
	public $po_date = '';
	public $delivery_date = '';
	public $status = ''; // status - 1 - complete, 2 - hold, 0 - pending

	/**
	 * Other details
	 *
	 * @var	string/array
	 */
	public $author = ''; // user details reference id
	public $author_name = '';
	public $author_email = '';
	public $c = ''; // 1-admin, 2-sales
	public $des_id = '';
	public $designer = '';
	public $vendor_id = '';
	public $vendor_name = '';
	public $vendor_code = '';
	public $email = '';

	// supposedly for store user details but it is now stored at options
	// as $options['po_store_id']
	public $user_id = '';
	public $store_name = '';

	/**
	 * Order Details - the items
	 *
	 * @var	string/array
	 */
	public $items = array();

	/**
	 * Order Options Values
	 *
	 * @var	string/array
	 */
	public $options = array();

	/**
	 * Remarks and instructions
	 *
	 * @var	string
	 */
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
					$this->DB->where($key, $val);
				}
			}
		}

		// set select items
		$this->DB->select('purchase_orders.*');
		$this->DB->select('designer.designer, designer.des_id');
		$this->DB->select('vendors.vendor_name, vendors.vendor_code');
		$this->DB->select('tbluser_data_wholesale.store_name');
		$this->DB->select('tbluser_data_wholesale.email');

		$this->DB->select('tbladmin_sales.admin_sales_user, tbladmin_sales.admin_sales_lname, tbladmin_sales.admin_sales_email');

		// set joins
		$this->DB->join('designer', 'designer.des_id = purchase_orders.des_id', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = purchase_orders.vendor_id', 'left');
		$this->DB->join('tbluser_data_wholesale', 'tbluser_data_wholesale.user_id = purchase_orders.user_id', 'left');

		$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_id = purchase_orders.author', 'left');

		// order by
		$this->DB->order_by('purchase_orders.delivery_date', 'DESC');

		// get records
		$query = $this->DB->get('purchase_orders');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->po_id = $row->po_id;
			$this->des_code = $row->des_code;
			$this->po_number = $row->po_number;
			$this->rev = $row->rev;
			$this->remarks = $row->remarks;

			$this->po_date = @date('Y-m-d', $row->po_date);
			$this->delivery_date = @date('Y-m-d', $row->delivery_date);
			$this->status = $row->status; // 0 - pending, 1 - complete, 2 - hold

			$this->author = $row->author;
			$this->c = $row->c; // 1-admin, 2-sales

			$this->des_id = $row->des_id;
			$this->designer = $row->designer;
			$this->vendor_id = $row->vendor_id;
			$this->vendor_name = $row->vendor_name;
			$this->vendor_code = $row->vendor_code;
			$this->user_id = $row->user_id;
			$this->store_name = $row->store_name;
			$this->email = $row->email;

			// the items
			$this->items = ($row->items && $row->items != '') ? json_decode($row->items , TRUE) : array();

			// the options
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();

			$this->_get_author();

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
	private function _get_author()
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('users/sales_user_details');
		$this->CI->load->library('users/admin_user_details');

		switch ($this->c)
		{
			case '2': //sales
				$author = $this->CI->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->author
					)
				);
			break;
			case '1': //admin
			default:
				$author = $this->CI->admin_user_details->initialize(
					array(
						'admin_id' => ($this->author ?: '1')
					)
				);
		}

		$this->author_name = $author->fname ? $author->fname.' '.$author->lname : 'Admin';
		$this->author_email = $author->email;

		return;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function deinitialize()
	{
		// initialize properties
		$this->po_id = '';
		$this->des_code = '';
		$this->po_number = '';
		$this->rev = '';
		$this->remarks = '';

		$this->po_date = '';
		$this->delivery_date = '';
		$this->status = ''; // 0 - pending, 1 - complete, 2 - hold

		$this->author = '';
		$this->author_name = '';
		$this->author_email = '';
		$this->c = '';
		$this->des_id = '';
		$this->designer = '';
		$this->vendor_id = '';
		$this->vendor_name = '';
		$this->vendor_code = '';
		$this->user_id = '';
		$this->store_name = '';
		$this->email = '';

		// the items
		$this->items = array();

		return $this;
	}

	// --------------------------------------------------------------------

}
