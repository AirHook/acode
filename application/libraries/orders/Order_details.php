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
	public $order_date = ''; // old date recording system as string
	public $status = '';
	public $remarks = ''; // 1 - return for exchange, 2 - return for store credit, 3 - return for refund, 4 - return for other reasons (comments)
	//public $comments = '';

	public $date_ordered = ''; // new date recording system as timestamp
	public $date_timestamp = ''; // alias as timestamp

	/**
	 * Status Text based on Status value
	 *
	 * @var	string/array
	 */
	public $status_text = ''; // 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit

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
	public $designers = array(); // collection of designers for mixed designers or the specific designer
	public $designer_group = ''; // "Mixed Designers" or the specific designer
	public $designer_slug = ''; // webspace slug or the specific designer slug
	public $agree_policy = '';

	/**
	 * User Details
	 *
	 * @var	string/array
	 */
	public $c = '';
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
	 * Invoice ID - invoice number
	 *
	 * @var	string
	 */
	public $invoice_id = '';


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
		// combine all designers into one propery comma separated, or just a single designer
		$this->DB->select('GROUP_CONCAT(DISTINCT CONCAT(tbl_order_log_details.designer)) AS designers');
		$this->DB->select('tbl_order_log.order_log_id AS order_id');
		$this->DB->select('tbl_order_log_details.*');
		$this->DB->select('
			(CASE
				WHEN
					(SELECT COUNT(DISTINCT tbl_order_log_details.designer)
					FROM tbl_order_log_details
					WHERE tbl_order_log_details.order_log_id = tbl_order_log.order_log_id) = "1"
				THEN tbl_order_log_details.designer
				ELSE "Mixed Designers"
			END) AS designer_group
		');
		$this->DB->select('
			(CASE
				WHEN
					(SELECT COUNT(DISTINCT tbl_order_log_details.designer)
					FROM tbl_order_log_details
					WHERE tbl_order_log_details.order_log_id = tbl_order_log.order_log_id) = "1"
					THEN designer.url_structure
				ELSE "'.$this->CI->webspace_details->slug.'"
			END) AS designer_slug
		');
		// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit,7-payment_pending
		$this->DB->select('
			(CASE
				WHEN status = "0" THEN "new_orders"
				WHEN status = "1" THEN "shipped"
				WHEN status = "2" THEN "on_hold"
				WHEN status = "3" THEN "cancelled"
				WHEN status = "4" THEN "refunded"
				WHEN status = "5" THEN "shipment_pending"
				WHEN status = "6" THEN "store_credit"
				WHEN status = "7" THEN "payment_pending"
				ELSE "new_orders"
			END) AS status_text
		');
		$this->DB->select('tbl_order_log.options AS order_options');

		// set joins
		$this->DB->join('tbl_order_log_details', 'tbl_order_log_details.order_log_id = tbl_order_log.order_log_id', 'left');
		$this->DB->join('designer', 'designer.designer = tbl_order_log_details.designer', 'left');

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

			$this->date_ordered = date('Y-m-d', $row->order_date);
			$this->date_timestamp = $row->order_date;

			$this->status = $row->status;
			$this->status_text = $row->status_text;
			$this->remarks = $row->remarks; // 1 - return for exchange, 2 - return for store credit, 3 - return for refund, 4 - return for other reasons (comments)
			//$this->comments = $row->comments;

			$this->order_amount = $row->amount ?: $row->order_amount;
			$this->order_qty = $row->order_qty;
			$this->courier = $row->courier;
			$this->shipping_fee = $row->shipping_fee;

			$this->agree_policy = $row->agree_policy; // for consumers

			$this->c = $row->c;
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

			$this->options = ($row->order_options && $row->order_options != '') ? json_decode($row->order_options , TRUE) : array();
			$this->webspace_id = $row->webspace_id;
			$this->invoice_id = $row->invoice_id;

			// get items
			$this->designers = explode(',', $row->designers);
			$this->designer_group = $row->designer_group;
			$this->designer_slug = $row->designer_slug;
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
	 * This is used for when the order has mixed designers and we need
	 * to separate each designer items, e.g., for inoicing
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

		// check if mixed designers
		$array = array();
		foreach ($this->designers as $designer)
		{
			// get record
			$this->DB->join('designer', 'designer.designer = tbl_order_log_details.designer', 'left');
			$this->DB->join('webspaces', 'webspaces.webspace_slug = designer.url_structure', 'left');
			$this->DB->where('tbl_order_log_details.order_log_id', $this->order_id);
			$this->DB->where('tbl_order_log_details.designer', $designer);
			$this->DB->group_by('order_log_detail_id');
			$this->DB->order_by('order_log_detail_id', 'asc');
			$query = $this->DB->get('tbl_order_log_details');
			$array[$designer] = $query->result();
		}

		return (object) $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Order items
	 * This is used for when the order has mixed designers and we need
	 * to separate each designer items, e.g., for inoicing
	 *
	 * @return	object/boolean false
	 */
	public function items_object()
	{
		if ( ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// check if mixed designers
		$array = array();
		foreach ($this->designers as $designer)
		{
			// get record
			$this->DB->join('designer', 'designer.designer = tbl_order_log_details.designer', 'left');
			$this->DB->join('webspaces', 'webspaces.webspace_slug = designer.url_structure', 'left');
			$this->DB->where('tbl_order_log_details.order_log_id', $this->order_id);
			$this->DB->where('tbl_order_log_details.designer', $designer);
			$this->DB->group_by('order_log_detail_id');
			$this->DB->order_by('order_log_detail_id', 'asc');
			$query = $this->DB->get('tbl_order_log_details');
			$array[$designer] = $query->result();
		}

		return (object) $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Order items
	 * This is used for when the order has mixed designers and we need
	 * to separate each designer items, e.g., for inoicing
	 *
	 * @return	array/boolean false
	 */
	public function items_array()
	{
		if ( ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// check if mixed designers
		$array = array();
		foreach ($this->designers as $designer)
		{
			// get record
			$this->DB->join('designer', 'designer.designer = tbl_order_log_details.designer', 'left');
			$this->DB->join('webspaces', 'webspaces.webspace_slug = designer.url_structure', 'left');
			$this->DB->where('tbl_order_log_details.order_log_id', $this->order_id);
			$this->DB->where('tbl_order_log_details.designer', $designer);
			$this->DB->group_by('order_log_detail_id');
			$this->DB->order_by('order_log_detail_id', 'asc');
			$query = $this->DB->get('tbl_order_log_details');
			$array[$designer] = $query->result_array();
		}

		return $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Max Invoice Id
	 *
	 * @return	object/boolean false
	 */
	public function max_invoice_id()
	{
		$this->DB->select_max('invoice_id');
		$query = $this->DB->get('tbl_order_log');
		$row = $query->row();
		if ($row) return $row->invoice_id;
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
