<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales Package Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link		
 */
class Linesheet_sending
{
	/**
	 * Linesheet items
	 *
	 * @var	string
	 */
	public $linesheet_items = '';

	/**
	 * Other pertinent items
	 *
	 * @var	string
	 */
	public $w_prices = 'Y';
	public $w_images = 'N';
	public $linesheets_only = 'N';

	/**
	 * Wholesale Users
	 *
	 * @var	array
	 */
	public $users = array();

	/**
	 * Send From - which part of the program is executing this sending
	 *
	 * @var	array
	 */
	public $send_from = 'admin';

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
	 * @param	array	$param	Initialization parameter - the item id
	 * 
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		$this->initialize($params);
		log_message('info', 'Sales Package Sending Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
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
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}
		
		//$this->linesheet_items = $this->CI->sales_user_details->options['selected'];
		
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
		// load user details class 
		// used during $users iteration
		// to get user details
		$this->CI->load->library('users/wholesale_user_details');
		
		// load product details class 
		// used during getting product info to attach to email
		$this->CI->load->library('products/product_details');
		
		// get linesheet items
		$linesheet_items = $this->CI->sales_user_details->options['selected'];
		
		// load email library class
		$this->CI->load->library('email');
		
		// for each user
		foreach ($this->users as $email)
		{
			if ( ! $this->CI->wholesale_user_details->initialize(array('email'=>$email)))
			{
				$this->error .= 'Invalid email address - "'.$email.'"<br />';
			}
			
			// set some data to pass to the email template
			$data['username'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname)));
			$data['email'] = $email;
			$data['sales_username'] = ucwords(strtolower(trim($this->CI->sales_user_details->fname).' '.trim($this->CI->sales_user_details->lname)));
			$data['sales_ref_designer'] = $this->CI->sales_user_details->designer_name;
			
			$this->CI->email->clear(TRUE);
			
			$this->CI->email->from($this->CI->sales_user_details->email, $this->CI->sales_user_details->designer_name);
			$this->CI->email->reply_to($this->CI->sales_user_details->email);
			//$this->CI->email->cc($this->CI->webspace_details->info_email);
			$this->CI->email->bcc($this->CI->config->item('info_email').', '.$this->CI->config->item('dev1_email'));

			$this->CI->email->subject($this->CI->sales_user_details->designer_name.' Products');

			$this->CI->email->to($this->CI->wholesale_user_details->email);
			
			// let's get the email template
			$message = $this->CI->load->view('templates/linesheet', $data, TRUE);
			$this->CI->email->message($message);
			
			// attachment
			foreach ($linesheet_items as $product)
			{
				// get product details
				$this->CI->product_details->initialize(array('prod_no'=>$product));
				
				// set image paths
				$img_pre = 'product_assets/WMANSAPREL/'.$this->CI->product_details->d_folder.'/'.$this->CI->product_details->sc_folder.'/product_linesheet/';
				// the image filename (using 1 - 140x210)
				$image = $this->CI->product_details->prod_no.'_'.$this->CI->product_details->primary_img_id.'.jpg';
				
				$this->CI->email->attach($img_pre.$image);
			}
			
			if (ENVIRONMENT === 'development') 
			{
				$this->CI->session->set_flashdata('success', 'linesheet_sent');
				echo 'Email:<br />';
				echo '<br />';
				echo $message;
				echo '<br />';
				echo '<br />';
				if ($this->send_from == 'front_end')
				{
					// let's update user linesheet history
					// get the options and grab ['linesheet_history']
					// add new history info, check for count and retain 10 records
					$sales_user_options = $this->CI->sales_user_details->options;
					$sales_user_options['linesheet_history'][time()] = array(
						'items' => implode(', ', $this->CI->sales_user_details->options['selected']),
						'name' => ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname))),
						'email' => $this->CI->wholesale_user_details->email,
						'store_name'=> $this->CI->wholesale_user_details->store_name
					);
					krsort($sales_user_options['linesheet_history']);
					array_slice($sales_user_options['linesheet_history'], 0, 10);
						// clear out user selection
						unset($sales_user_options['selected']);
						unset($sales_user_options['edited_prices']);
					$this->DB->set('options', json_encode($sales_user_options));
					$this->DB->where('admin_sales_id', $this->CI->sales_user_details->admin_sales_id);
					$query = $this->DB->update('tbladmin_sales');
			
					if ($this->CI->data['sales_theme'] == 'roden2') echo '<a href="'.site_url('sales/linesheet').'">continue...</a>';
					if ($this->CI->data['sales_theme'] == 'default') echo '<a href="'.site_url('sales/sent').'">continue...</a>';
				}
				else echo '<a href="'.site_url($this->CI->config->slash_item('admin_folder').'users/wholesale').'">continue...</a>';
				echo '<br />';
				echo '<br />';
				die();
			}
			else
			{
				if ( ! $this->CI->email->send())
				{
					$this->error .= 'Unable to send to - "'.$email.'"<br />';
				}
			}
			
			// let's update user linesheet history
			// get the options and grab ['linesheet_history']
			// add new history info, check for count and retain 10 records
			$sales_user_options = $this->CI->sales_user_details->options;
			$sales_user_options['linesheet_history'][time()] = array(
				'items' => implode(', ', $this->CI->sales_user_details->options['selected']),
				'name' => ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname))),
				'email' => $this->CI->wholesale_user_details->email,
				'store_name'=> $this->CI->wholesale_user_details->store_name
			);
			krsort($sales_user_options['linesheet_history']);
			array_slice($sales_user_options['linesheet_history'], 0, 10);
				// clear out user selection
				unset($sales_user_options['selected']);
				unset($sales_user_options['edited_prices']);
			$this->DB->set('options', json_encode($sales_user_options));
			$this->DB->where('admin_sales_id', $this->CI->sales_user_details->admin_sales_id);
			$query = $this->DB->update('tbladmin_sales');
	
			$this->CI->email->clear(TRUE);
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

}
