<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Consumer Special Sale Email Invite Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link		
 */
class Consumer_send_special_sale_invite
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
		$this->users = $params;
		
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
		$this->CI->load->library('users/consumer_user_details');
		
		// for each user
		foreach ($this->users as $user_id)
		{
			if ( ! $this->CI->consumer_user_details->initialize(array('user_id'=>$user_id)))
			{
				$this->error .= 'Invalid user information.<br />';
			}
			
			$this->CI->email->clear();
			
			// do the email headers
			$this->CI->email->from($this->CI->webspace_details->info_email, $this->CI->webspace_details->name);
			//$this->CI->email->cc($this->CI->config->item('info_email'));
			$this->CI->email->bcc($this->CI->webspace_details->info_email.', '.$this->CI->config->item('dev1_email'));

			// let's set some data
			$date_hash = sha1(@date('Y-m-d', @time()));
			$se = sha1($this->CI->consumer_user_details->email);
			$query_string_hash = '?ue='.$se.'&td='.$date_hash;
			$data['link'] = str_replace('https', 'http', base_url()).'special_sale/apparel.html'.$query_string_hash;
			$data['unsublink'] = str_replace('https', 'http', base_url()).'special_sale/unsubscribe.html'.$query_string_hash;
			$data['name'] = ucwords(strtolower(trim($this->CI->consumer_user_details->fname).' '.trim($this->CI->consumer_user_details->lname)));
			$data['designer'] = $this->CI->consumer_user_details->designer ?: $this->CI->webspace_details->name;
			
			// to and subject
			$this->CI->email->subject(strtoupper($data['designer']).' SPECIAL SALE');
			$this->CI->email->to($this->CI->consumer_user_details->email);
			
			// grab template and infuse data and set message
			$message = $this->CI->load->view('templates/consumer_special_sale_invite', $data, TRUE);
			$this->CI->email->message($message);
			
			// send email
			if (ENVIRONMENT === 'development') 
			{
				$params['special_sale_invite'] = time();
				$this->CI->consumer_user_details->update_options($params);
				$this->CI->session->set_flashdata('success', 'consumer_send_special_sale_invite');
				echo 'Dev <br />';
				echo $message;
				echo '<br />';
				echo '<br />';
				echo '<a href="'.site_url($this->CI->config->slash_item('admin_folder').'users/consumer').'">continue...</a>';
				echo '<br />';
				echo '<br />';
				echo '<pre>';
				print_r($data);
				die();
			}
			else
			{
				if ( ! $this->CI->email->send())
				{
					$this->error .= 'Unable to send to - "'.$email.'"<br />';
					
					return FALSE;
				}
			}
			
			$params['special_sale_invite'] = time();
			$this->CI->consumer_user_details->update_options($params);
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

}
