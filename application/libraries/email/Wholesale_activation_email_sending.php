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
class Wholesale_activation_email_sending
{
	/**
	 * Wholesale Users
	 *
	 * @var	array
	 */
	public $users = array();

	/**
	 * Error Message
	 *
	 * @var	string
	 */
	public $error = '';

	
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
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}
		
		// initialize properties
		$this->users = $params['users'];
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Send Sales Package Email
	 *
	 * @return	boolean
	 */
	public function send()
	{
		// load email library class
		$this->CI->load->library('email');
		
		// for each user
		foreach ($this->users as $email)
		{
			if ( ! $this->CI->wholesale_user_details->initialize(array('email'=>$email)))
			{
				$this->error .= 'Invalid email address - "'.$email.'"<br />';
			}
			
			$this->CI->email->clear();
			
			$this->CI->email->from($this->CI->wholesale_user_details->designer_info_email, $this->CI->wholesale_user_details->designer);
			$this->CI->email->cc($this->CI->config->item('info_email'));
			$this->CI->email->bcc($this->CI->config->item('dev1_email'));

			$this->CI->email->subject('Welcome to '.$this->CI->wholesale_user_details->designer.' Wholesale Order System');

			$this->CI->email->to($this->CI->wholesale_user_details->email);
			
			// let's set some data and get the message
			$data['username'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname)));
			$data['email'] = $this->CI->wholesale_user_details->email;
			$data['password'] = $this->CI->wholesale_user_details->password;
			$data['sales_rep'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->admin_sales_user).' '.trim($this->CI->wholesale_user_details->admin_sales_lname)));
			$data['reference_designer'] = $this->CI->wholesale_user_details->reference_designer;
			$data['designer'] = $this->CI->wholesale_user_details->designer;
			$data['designer_site_domain'] = $this->CI->wholesale_user_details->designer_site_domain;
			$data['designer_address1'] = $this->CI->wholesale_user_details->designer_address1;
			$data['designer_address2'] = $this->CI->wholesale_user_details->designer_address2;
			$data['designer_phone'] = $this->CI->wholesale_user_details->designer_phone;
			
			echo 'here';
			
			$message = $this->CI->load->view('templates/activation_email', $data, TRUE);
			$this->CI->email->message($message);
			
			if (ENVIRONMENT === 'development') 
			{
				echo 'Dev <br />';
				echo $message;
				return TRUE;
			}
			else
			{
				if ( ! $this->CI->email->send())
				{
					$this->error .= 'Unable to send to - "'.$email.'"<br />';
					
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

}
