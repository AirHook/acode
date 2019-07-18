<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Account Details Class
 *
 * This class get the account details for use on front end
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link		
 */
class Account_details
{
	/**
	 * Account Id
	 *
	 * @var	string
	 */
	public $id = '';

	/**
	 * Account Name
	 *
	 * @var	string
	 */
	public $name = '';

	/**
	 * Account Owner
	 *
	 * @var	string
	 */
	public $owner = '';

	/**
	 * Owner Email
	 *
	 * @var	string
	 */
	public $owner_email = '';

	/**
	 * Company Info
	 *
	 * @var	string
	 */
	public $address1 = '';
	public $address2 = '';
	public $city = '';
	public $state = '';
	public $country = '';
	public $zip = '';
	public $phone = '';

	/**
	 * Type of Industry
	 *
	 * @var	string
	 */
	public $industry = '';

	/**
	 * Account Status
	 *
	 * @var	string
	 */
	public $status = '';

	
	/**
	 * Date Create
	 *
	 * @var	string
	 */
	public $date_create = '';

	/**
	 * Last Modified
	 *
	 * @var	string
	 */
	public $last_modified = '';

	
	
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
	public function __construct($param = array())
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		$this->initialize($param);
		log_message('info', 'Account Details Class Initialized');
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
		
		// get recrods
		$this->DB->where($params);
		$query = $this->DB->get('accounts');
		
		$row = $query->row();
		
		if (isset($row))
		{
			// initialize properties
			$this->id = $row->account_id;
			$this->name = $row->company_name;
			$this->owner = $row->owner_name;
			$this->owner_email = $row->owner_email;
			$this->address1 = $row->address1;
			$this->address2 = $row->address2;
			$this->city = $row->city;
			$this->state = $row->state;
			$this->country = $row->country;
			$this->zip = $row->zip;
			$this->phone = $row->phone;
			$this->industry = $row->industry;
			$this->password = $row->password;
			$this->status = $row->account_status;
		
			return $this;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Universally SET Admin Sales only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		$sesdata = array(
			'account' => TRUE,
			'account_id' => $this->id
		);
		$this->CI->session->set_userdata($sesdata);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Universally Unset Admin Sales only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
		$sesdata = array(
			'account' => FALSE,
			'account_id' => ''
		);
		$this->CI->session->unset_userdata($sesdata);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function set_initial_state()
	{
		// destroy session
		$this->unset_session();

		// reset variables to default
		$this->id = '';
		$this->name = '';
		$this->owner = '';
		$this->owner_email = '';
		$this->address1 = '';
		$this->address2 = '';
		$this->city = '';
		$this->state = '';
		$this->country = '';
		$this->zip = '';
		$this->phone = '';
		$this->industry = '';
		$this->password = '';
		$this->status = '';
		
		$this->last_modified = '';
		
		return $this;
	}
	
	// --------------------------------------------------------------------

}
