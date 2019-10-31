<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Order Details Class
 *
 * This class' objective is to output order details as properties for use in the entire
 * HTML output.
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Orders
 * @author		WebGuy
 * @link
 */
class Order_details
{
	/**
	 * ID's
	 * Etc...
	 *
	 * @var	string
	 */
	public $order_id = '';
	public $transaction_no = '';

	/**
	 * Order Statuses
	 *
	 * @var	string/array
	 */
	public $order_date = '';
	public $status = '';
	public $remarks = ''; // 1 - return for exchange, 2 - return for store credit, 3 - return for refund, 4 - return for other reasons (comments)
	//public $comments = '';

	/**
	 * Order Summary
	 *
	 * @var	string/array
	 */
	public $order_amount = '';
	public $order_qty = '';
	public $courier = '';
	public $shipping_fee = '';

	/**
	 * Other Details
	 *
	 * @var	string/array
	 */
	public $designers = '';
	public $agree_policy = '';

	/**
	 * User Details
	 *
	 * @var	string/array
	 */
	public $user_id = '';
	public $email = '';
	public $firstname = '';
	public $lastname = '';
	public $telephone = '';
	public $store_name = ''; // store name
	public $ship_address1 = '';
	public $ship_address2 = '';
	public $ship_city = '';
	public $ship_state = '';
	public $ship_country = '';
	public $ship_zipcode = '';

	/**
	 * Order Items
	 *
	 * @var	object
	 */
	public $order_items = FALSE;

	/**
	 * Options
	 *
	 * @var	string/array
	 */
	public $options = array();

	/**
	 * Webspace ID - where order is taken
	 *
	 * @var	string/array
	 */
	public $webspace_id = '';


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
		log_message('info', 'Page Details Class Initialized');
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
			$this->order_id = '';
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
		$this->DB->select('tbl_order_log.*');
		$this->DB->select('COUNT(qty) AS number_of_orders');
		$this->DB->select('SUM(qty) AS order_qty');
		$this->DB->select('SUM(subtotal) AS order_amount');
		$this->DB->select('GROUP_CONCAT(DISTINCT CONCAT(designer)) AS designers');
		$this->DB->select('tbl_order_log.order_log_id AS order_id');
		$this->DB->select('tbl_order_log_details.*');

		// set joins
		$this->DB->join('tbl_order_log_details', 'tbl_order_log_details.order_log_id = tbl_order_log.order_log_id', 'left');

		// group by
		$this->DB->group_by('tbl_order_log.order_log_id');

		// order by
		$this->DB->order_by('status', 'asc');
		$this->DB->order_by('tbl_order_log.order_log_id', 'desc');

		// get records
		$query = $this->DB->get('tbl_order_log');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->order_id = $row->order_id;
			$this->transaction_no = $row->transaction_code;

			$date = str_replace('-', '',str_replace(',',' ',$row->date_ordered));
			$date = @strtotime($date);
			$this->order_date = @date('M d, Y H:i A', $date);;

			$this->status = $row->status;
			$this->remarks = $row->remarks; // 1 - return for exchange, 2 - return for store credit, 3 - return for refund, 4 - return for other reasons (comments)
			//$this->comments = $row->comments;

			$this->order_amount = $row->amount ?: $row->order_amount;
			$this->order_qty = $row->order_qty;
			$this->courier = $row->courier;
			$this->shipping_fee = $row->shipping_fee;

			$this->agree_policy = $row->agree_policy; // for consumers

			$this->user_id = $row->user_id;
			$this->email = $row->email;
			$this->firstname = $row->firstname;
			$this->lastname = $row->lastname;
			$this->telephone = $row->telephone;
			$this->store_name = $row->store_name; // store_name
			$this->ship_address1 = $row->ship_address1;
			$this->ship_address2 = $row->ship_address2;
			$this->ship_city = $row->ship_city;
			$this->ship_state = $row->ship_state;
			$this->ship_country = $row->ship_country;
			$this->ship_zipcode = $row->ship_zipcode;

			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();
			$this->webspace_id = $row->webspace_id;

			// get items
			$this->designers = $row->designers;
			$qry2 = $this->DB->get_where('tbl_order_log_details', array('order_log_id'=>$row->order_id));
			$this->order_items = $qry2->result();

			return $this;
		}
		else
		{
			// since there is no record, return false...
			$this->order_id = '';
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Order items
	 *
	 * @return	object/boolean false
	 */
	public function items()
	{
		if ( ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// get record
		$this->DB->order_by('order_log_detail_id', 'asc');
		$this->DB->where('tbl_order_log_details.order_log_id', $this->order_id);
		$query = $this->DB->get('tbl_order_log_details');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// since there is no record, return false...
			return FALSE;
		}
		else
		{
			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

}
