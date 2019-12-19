<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Wholesale Activation Email Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link
 */
class Order_email_confirmation
{
	/**
	 * Wholesale User ID
	 *
	 * @var	string
	 */
	public $user_id = '';

	/**
	 * User Category (consumer/wholesale)
	 *
	 * @var	string
	 */
	public $user_cat = '';

	/**
	 * Order ID
	 *
	 * @var	string
	 */
	public $order_id = '';

	/**
	 * Error Message
	 *
	 * @var	string
	 */
	public $error = '';


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
	 * @param	array	$param	Initialization parametera
	 *
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Wholesale Activation Email Sending Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameters
	 *
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		// initialize properties
		if ( ! empty($params))
		{
			foreach ($params as $key => $val)
			{
				if ($val !== '')
				{
					$this->$key = $val;
				}
			}
		}
		else
		{
			// nothing more to do...
			return FALSE;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Wholesale User Activation Email
	 *
	 * @return	boolean
	 */
	public function send()
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('email');
		$this->CI->load->library('users/wholesale_user_details');
		$this->CI->load->library('users/consumer_user_details');
		$this->CI->load->library('orders/order_details');

		// initialize user
		if ($this->user_cat == 'ws')
		{
			$user_details = $this->CI->wholesale_user_details->initialize(array('user_id'=>$this->user_id));
		}
		else
		{
			$user_details = $this->CI->consumer_user_details->initialize(array('user_id'=>$this->user_id));
		}

		// catch error for FALSE resulting user details (no user is found on list)
		// cases where a ws user id is used on retail order or vice versa
		if ( ! @$user_details->user_id)
		{
			// set error message
			$this->error = 'Unable to find user from list - "'.$this->user_id.' ('.$this->user_cat.')"<br />';

			return FALSE;
		}

		// get order details
		$order_details = $this->CI->order_details->initialize(array('tbl_order_log.order_log_id'=>$this->order_id));

		// let start composing the email
		$email_subject = $this->CI->webspace_details->name.' Product Order'.($this->user_cat == 'ws' ? ' - Wholesale' : '');

		$message = $this->CI->load->view('templates/order_confirmation', $order_details, TRUE);

		$this->CI->email->from($this->CI->webspace_details->info_email, $this->CI->webspace_details->name);

		$this->CI->email->to($user_details->email);

		$this->CI->email->subject($email_subject);
		$this->CI->email->message($message);

		if ( ! $this->CI->email->send())
		{
			// set error message
			$this->error = 'Unable to CI send to - "'.$user_details->email.'"<br />';

			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

}
