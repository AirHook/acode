<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Search By Style Number
 *
 * This class get the webspace details for use on front end
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link		
 */
class Style_number
{
	/**
	 * Product Number
	 *
	 * @var	string
	 */
	public $prod_no = '';

	
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
	public function __construct($prod_no = '')
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
	public function initialize($params = '')
	{
		if ($params == '')
		{
			// nothing more to do...
			return FALSE;
		}
		
		$where_private = "(tbl_product.public = 'Y' OR tbl_product.public = 'N')";
		$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1')";
		
		// get recrods
		$this->DB->distinct('prod_no');
		$this->DB->like($params);
		$this->DB->where($where_private);
		$this->DB->where($where_view_status);
		$this->DB->group_by('tbl_product.prod_no');
		$query = $this->DB->get('tbl_product');
		
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			$row = $query->row();
			
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
			$this->options = $row->webspace_options != '' ? json_decode($row->webspace_options , TRUE) : array();
			// joined account details
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
		
		return $this;
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
			'webspace' => TRUE,
			'webspace_id' => $this->id
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
