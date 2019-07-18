<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Webspace Details Class
 *
 * This class get the webspace details for use on front end
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link		
 */
class Webspace_details
{
	/**
	 * Webspace Id
	 *
	 * @var	string
	 */
	public $id = '';

	/**
	 * Ordering
	 *
	 * @var	string
	 */
	public $seque = '';

	/**
	 * Webspace Name
	 *
	 * @var	string
	 */
	public $name = '';

	/**
	 * Webspace Slug
	 *
	 * @var	string
	 */
	public $slug = '';

	/**
	 * Web Site
	 *
	 * @var	string
	 */
	public $site = '';

	/**
	 * Site Meta
	 *
	 * @var	string
	 */
	public $site_title = '';
	public $site_tagline = '';
	public $site_description = '';
	public $site_keywords = '';
	public $site_alttags = '';
	public $site_footer = '';

	/**
	 * Info Email
	 *
	 * @var	string
	 */
	public $info_email = '';
	
	/**
	 * Reference Account ID
	 *
	 * @var	string
	 */
	public $account_id = '';
	
	/**
	 * Webspace Status
	 *
	 * @var	string
	 */
	public $status = '';

	/**
	 * Webspace Options
	 *
	 * @var	array
	 */
	public $options = array();


	/**
	 * Has Account
	 *
	 * @var	boolean
	 */
	public $has_account = '';

	/**
	 * Account Company Name
	 *
	 * @var	string
	 */
	public $company = '';

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
	 * Webspace Owner
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
	 * Account Status
	 *
	 * @var	string
	 */
	public $account_status = '';

	/**
	 * This Webspace
	 * Last Modified
	 *
	 * @var	string
	 */
	public $last_modified = '';

	/**
	 * Theme information
	 *
	 * @var	string
	 */
	public $theme = '';
	public $theme_id = '';
	public $theme_name = '';
	public $theme_options = '';

	
	
	/**
	 * DB Object
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
	public function __construct($param = array())
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		$this->initialize($param);
		log_message('info', 'Page Details Class Initialized');
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
		
		// selects
		$this->DB->select('webspaces.*');
		$this->DB->select('
			accounts.company_name, 
			accounts.owner_name, 
			accounts.owner_email, 
			accounts.address1, 
			accounts.address2, 
			accounts.city, 
			accounts.state, 
			accounts.country, 
			accounts.zip, 
			accounts.phone, 
			accounts.industry, 
			accounts.account_status 
		');
		$this->DB->select('
			(CASE 
				WHEN EXISTS (SELECT * FROM accounts WHERE accounts.account_id = webspaces.account_id)
				THEN "1"
				ELSE "0"
			END) AS has_account
		');
		
		// get recrods
		$this->DB->join('accounts', 'accounts.account_id = webspaces.account_id', 'left');
		$this->DB->where($params);
		$query1 = $this->DB->get('webspaces');
		
		$row = $query1->row();
		
		if (isset($row))
		{
			// initialize properties
			$this->id = $row->webspace_id;
			$this->seque = $row->seque;
			$this->name = $row->webspace_name;
			$this->slug = $row->webspace_slug;
			$this->site = $row->domain_name;
			$this->site_title = $row->site_title;
			$this->site_tagline = $row->site_tagline;
			$this->site_keywords = $row->site_keywords;
			$this->site_description = $row->site_description;
			$this->site_alttags = $row->site_alttags;
			$this->site_footer = $row->site_footer;
			$this->info_email = $row->info_email;
			$this->account_id = $row->account_id;
			$this->status = $row->webspace_status;
			$this->last_modified = @$row->last_modified;
			// the options
			$this->options = ($row->webspace_options && $row->webspace_options != '') ? json_decode($row->webspace_options , TRUE) : array();
			// joined account details
			$this->has_account = $row->has_account;
			$this->company = $row->company_name;
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
			$this->account_status = $row->account_status;
		}
		else
		{
			return FALSE;
		}
		
		// if there is a selected theme, let's get the information as well
		if (isset($this->options['theme']) && ! empty($this->options['theme']))
		{
			$this->DB->where('theme', $this->options['theme']);
			$query2 = $this->DB->get('themes');
			
			if ($query2->num_rows() > 0)
			{
				$row2 = $query2->row();
				
				$this->theme = $row2->theme;
				$this->theme_id = $row2->theme_id;
				$this->theme_name = $row2->theme_name;
				$this->theme_options = $row2->theme_options != '' ? json_decode($row->theme_options , TRUE) : array();
			}
		}
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Record Recent Users edited 
	 * for the specific webspace which is added to webspace 'options'
	 *
	 * @return	void
	 */
	public function update_recent_users($params = array(), $remove = FALSE)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}
		
		switch ($params['user_type'])
		{
			case 'admin_users':
				$key = 'recent_admin_users';
			break;

			case 'sales_users':
				$key = 'recent_sales_users';
			break;

			case 'consumer_users':
				$key = 'recent_consumer_users';
			break;

			case 'wholesale_users':
				$key = 'recent_awholesale_users';
			break;

			case 'vendor_users':
				$key = 'recent_vendor_users';
			break;
		}
		
		// capture sales user options
		$options = $this->options;
		
		// get the array of recent users, and add the user selection
		$recent_users_ary = @$options[$key] ?: array();
		
		// update recent list of users edited
		if (is_array($recent_users_ary) && array_key_exists($params['user_id'], $recent_users_ary))
		{
			if ($remove)
			{
				unset($recent_users_ary[$params['user_id']]);
			}
			else
			{
				$recent_users_ary[$params['user_id']][1] = $recent_users_ary[$params['user_id']][1] + 1;
				array_values($recent_users_ary[$params['user_id']]);
			}
		}
		else // add to recent list
		{
			$recent_users_ary[$params['user_id']] = array($params['user_name'], 1);
		}
	
		// slice array to maintain on record up to 5 items only
		$recent_users_ary = array_slice($recent_users_ary, 0, 5, TRUE);
		
		// sort arrays decending to stats
		// using custom comparison function
		if ( ! function_exists('cmpwd'))
		{
			function cmpwd($a, $b) {
				if ($a[1] == $b[1]) {
					return 0;
				}
				return ($a[1] < $b[1]) ? 1 : -1;
			}
		}
		uasort($recent_users_ary, 'cmpwd');
		
		$options[$key] = $recent_users_ary;
		
		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->id);
		$q = $this->DB->update('webspaces');
		
		// RE-initialize class
		$this->initialize(array('webspace_id'=>$this->id));
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Record Recent Sales Package Edited
	 * for the specific webspace which is added to webspace 'options'
	 *
	 * @return	void
	 */
	public function update_recent_sales_package($params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}
		
		// capture sales user options
		$options = $this->options;
		
		// get the array of recent users, and add the user selection
		$recent_sales_package = @$options['recent_sales_package'] ?: array();
		
		// update recent list of users edited
		if (is_array($recent_sales_package) && array_key_exists($params['sales_package_id'], $recent_sales_package))
		{
			$recent_sales_package[$params['sales_package_id']][1] = $recent_sales_package[$params['sales_package_id']][1] + 1;
			array_values($recent_sales_package[$params['sales_package_id']]);
		}
		else 
		{
			$recent_sales_package[$params['sales_package_id']] = array($params['sales_package_name'], 1);
		}
	
		// slice array to maintain on record up to 3 items only
		array_slice($recent_sales_package, 0, 5, TRUE);
		
		// sort arrays decending to stats
		// set comparison function
		if ( ! function_exists('cmpwd1'))
		{
			function cmpwd1($a, $b) {
				if ($a[1] == $b[1]) {
					return 0;
				}
				return ($a[1] < $b[1]) ? 1 : -1;
			}
		}
		uasort($recent_sales_package, 'cmpwd1');
		
		$options['recent_sales_package'] = $recent_sales_package;
		
		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->id);
		$q = $this->DB->update('webspaces');
		
		// RE-initialize class
		$this->initialize(array('webspace_id'=>$this->id));
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Record Recent Sales Package Edited
	 * for the specific webspace which is added to webspace 'options'
	 *
	 * @return	void
	 */
	public function update_recent_designers($params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}
		
		// capture sales user options
		$options = $this->options;
		
		// get the array of recent users, and add the user selection
		$recent_designers = @$options['recent_designers'] ?: array();
		
		// update recent list of users edited
		if (is_array($recent_designers) && array_key_exists($params['designer_id'], $recent_designers))
		{
			$recent_designers[$params['designer_id']][1] = $recent_designers[$params['designer_id']][1] + 1;
			array_values($recent_designers[$params['designer_id']]);
		}
		else 
		{
			$recent_designers[$params['designer_id']] = array($params['designer_name'], 1);
		}
	
		// slice array to maintain on record up to 3 items only
		array_slice($recent_designers, 0, 5, TRUE);
		
		// sort arrays decending to stats
		// set comparison function
		if ( ! function_exists('cmpwd2'))
		{
			function cmpwd2($a, $b) {
				if ($a[1] == $b[1]) {
					return 0;
				}
				return ($a[1] < $b[1]) ? 1 : -1;
			}
		}
		uasort($recent_designers, 'cmpwd2');
		
		$options['recent_designers'] = $recent_designers;
		
		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->id);
		$q = $this->DB->update('webspaces');
		
		// RE-initialize class
		$this->initialize(array('webspace_id'=>$this->id));
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get the size mode reference designer
	 *
	 * @return	void
	 */
	public function get_size_mode($params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}
		
		$this->DB->select('webspace_options');
		$this->DB->where($params);
		$query = $this->DB->get('webspaces');
		
		//echo $this->DB->last_query(); die('<br />DIED');
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();
			$options = json_decode($row->webspace_options, TRUE);
			
			// return the object
			return $options['size_mode'];
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Universally SET Webspace only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		$sesdata = array(
			'webspace' => TRUE,
			'webspace_id' => $this->id
		);
		$this->CI->session->set_userdata($sesdata);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Universally Unset Webspace only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
		$sesdata = array(
			'webspace' => FALSE,
			'webspace_id' => ''
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
		$this->seque = '';
		$this->name = '';
		$this->slug = '';
		$this->site = '';
		$this->site_title = '';
		$this->site_tagline = '';
		$this->site_description = '';
		$this->site_keywords = '';
		$this->site_alttags = '';
		$this->site_footer = '';
		$this->info_email = '';
		$this->account_id = '';
		$this->status = '';
		// the options
		$this->options = array();
		
		$this->has_account = '';
		$this->company = '';
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
		$this->account_status = '';
		
		$this->last_modified = '';
		
		return $this;
	}
	
	// --------------------------------------------------------------------

}
