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
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/size_names');
		$this->CI->load->library('designers/designer_details');

		// initialize user
		if ($this->user_cat == 'ws')
		{
			$this->data['user_details'] = $this->CI->wholesale_user_details->initialize(array('user_id'=>$this->user_id));
		}
		else
		{
			$this->data['user_details'] = $this->CI->consumer_user_details->initialize(array('user_id'=>$this->user_id));
		}

		// catch error for FALSE resulting user details (no user is found on list)
		// cases where a ws user id is used on retail order or vice versa
		if ( ! @$this->data['user_details']->user_id)
		{
			// set error message
			$this->error = 'Unable to find user from list - "'.$this->user_id.' ('.$this->user_cat.')"<br />';

			return FALSE;
		}

		// get order details
		$this->data['order_details'] = $this->CI->order_details->initialize(array('tbl_order_log.order_log_id'=>$this->order_id));

		// set company details via order designer
		$designer_group = $this->data['order_details']->designer_group;
		$designer_slug = $this->data['order_details']->designer_slug;
		if ($designer_group == 'Mixed Designers')
		{
			$this->data['company_name'] = $this->CI->webspace_details->name;
			$this->data['company_address1'] = $this->CI->webspace_details->address1;
			$this->data['company_address2'] = $this->CI->webspace_details->address2;
			$this->data['company_city'] = $this->CI->webspace_details->city;
			$this->data['company_state'] = $this->CI->webspace_details->state;
			$this->data['company_zipcode'] = $this->CI->webspace_details->zipcode;
			$this->data['company_country'] = $this->CI->webspace_details->country;
			$this->data['company_telephone'] = $this->CI->webspace_details->phone;
			$info_email = $this->CI->webspace_details->info_email;
			$this->data['logo'] =
				@$this->CI->webspace_details->options['logo']
				? $this->CI->config->item('PROD_IMG_URL').$this->CI->webspace_details->options['logo']
				: $this->CI->config->item('PROD_IMG_URL').'assets/images/logo/logo-shop7thavenue.png'
			;
		}
		else
		{
			// initialize class
			$this->CI->designer_details->initialize(
				array(
					'designer.url_structure' => $designer_slug
				)
			);

			$this->data['company_name'] = $this->CI->webspace_details->name.' / '.$this->CI->designer_details->designer;
			$this->data['company_address1'] = @$this->CI->designer_details->address1;
			$this->data['company_address2'] = @$this->CI->designer_details->address2;
			$this->data['company_city'] = @$this->CI->designer_details->city;
			$this->data['company_state'] = @$this->CI->designer_details->state;
			$this->data['company_zipcode'] = @$this->CI->designer_details->zipcode;
			$this->data['company_country'] = @$this->CI->designer_details->country;
			$this->data['company_telephone'] = @$this->CI->designer_details->phone;
			$info_email = @$this->CI->designer_details->info_email;
			$this->data['logo'] = $this->CI->config->item('PROD_IMG_URL').@$this->CI->designer_details->logo;
		}

		// let start composing the email
		$email_subject = $this->CI->webspace_details->name.' Product Order'.($this->user_cat == 'ws' ? ' - Wholesale' : '');

		$message = $this->CI->load->view('templates/order_confirmation_new', $this->data, TRUE);

		$this->CI->email->from($this->CI->webspace_details->info_email, $this->CI->webspace_details->name);

		$this->CI->email->to($this->data['user_details']->email);
		//$this->CI->email->to('help@shop7thavenue.com');
		//$this->CI->email->cc('rsbgm@rcpixel.com');
		//$this->CI->email->bcc('rsbgm@rcpixel.com');
		//$this->CI->email->to('rsbgm@instylenewyork.com');

		$this->CI->email->subject($email_subject);
		$this->CI->email->message($message);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $message;
			echo '<br /><br />';
			exit;
		}
		else
		{
			if ( ! $this->CI->email->send())
			{
				// set error message
				$this->error = 'Unable to CI send to - "'.$user_details->email.'"<br />';

				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

}
