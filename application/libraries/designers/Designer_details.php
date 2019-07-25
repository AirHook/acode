<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Designer Details Class
 *
 * This class' objective is to get the designer details that will
 * be used to output info
 *
 * Such information are the following (but not limited to)
 *
 *		des_id
 *		designer
 *		size_chart, icon_img, logo_image
 *		view_status (Y/N)
 *		meta info
 *		folder, url_structure
 *		domain_name, designer_site_domain
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Designer, Designer Details
 * @author		WebGuy
 * @link
 */
class Designer_details
{
	/**
	 * Designer id
	 *
	 * @var	string
	 */
	public $des_id = '';

	/**
	 * Designer Name
	 *
	 * @var	string
	 */
	public $name = '';
	public $designer = '';

	/**
	 * Designer Code
	 *
	 * @var	string
	 */
	public $des_code = '';

	/**
	 * Designer Logo
	 *
	 * @var	string
	 */
	public $logo = ''; // default
	public $logo_image = ''; // (using this for logo light)
	public $logo_dark = ''; // dark logo for light background (default)
	public $logo_light = ''; // light logo for dark background

	/**
	 * Designer Icon
	 *
	 * @var	string
	 */
	public $icon = '';
	public $icon_img = ''; // (for depracation)

	/**
	 * Designer Size Chart
	 *
	 * @var	string
	 */
	public $size_chart = '';

	/**
	 * Designer Meta Information
	 *
	 * @var	string
	 */
	public $title = '';
	public $description = '';
	public $keyword = '';
	public $alttags = '';
	public $footer = '';
	public $url_structure = '';

	/**
	 * Designer Slug (folder/url_structure/domain_name)
	 *
	 * @var	string
	 */
	public $slug = '';

	/**
	 * Designer webspace domain (ex., domain.com)
	 *
	 * @var	string
	 */
	public $site_domain = '';

	/**
	 * View Status
	 *
	 * @var	string
	 */
	public $view_status = '';

	/**
	 * With Products Status
	 *
	 * @var	string
	 */
	public $with_products = '';

	/**
	 * Designer Information
	 *
	 * @var	string
	 */
	public $address1 = '';
	public $address2 = '';
	public $city = '';
	public $state = '';
	public $zipcode = '';
	public $country = '';
	public $phone = '';
	public $info_email = '';

	/**
	 * Designer Webspace Options
	 *
	 * @var	string
	 */
	public $webspace_options = array();

	/**
	 * Webspace ID
	 *
	 * @var	string
	 */
	public $webspace_id = '';

	/**
	 * Account Owner Company Name
	 *
	 * @var	string
	 */
	public $company_name = '';
	public $company = ''; // alias of $company_name
	public $owner = '';

	/**
	 * Info Status
	 *
	 * This indicates the status of information for the designer is complete such as
	 * images, address, phone, and info email are complete
	 *
	 * @var	boolean
	 */
	public $complete_info_status = FALSE;


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
	 * @param	array	$param	Initialization parameter
	 *
	 * @return	void
	 */
	public function __construct($param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($param);
		log_message('info', 'Designer Details Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter
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

		// get recrods
		$this->DB->select('*');
		$this->DB->select('
			(CASE
				WHEN EXISTS (SELECT * FROM tbl_product WHERE tbl_product.designer = designer.des_id)
				THEN "1"
				ELSE "0"
			END) AS with_products
		');
		$this->DB->join('webspaces', 'webspaces.webspace_id = designer.webspace_id', 'left');
		$this->DB->join('accounts', 'accounts.account_id = webspaces.account_id', 'left');
		$this->DB->where($params);
		$query = $this->DB->get('designer');

		//echo '<pre>'; echo $this->DB->last_query(); die();

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->des_id = $row->des_id;
			$this->name = $row->designer;
			$this->designer = $row->designer;
			$this->des_code = $row->des_code;
			$this->slug = $row->url_structure == 'basix-black-label' ? 'basixblacklabel' : $row->url_structure;

			$this->logo = $row->logo; // full path and filename used in current admin add/edit designer
			$this->logo_image = $row->logo_image; // filename (for depracation)
			$this->logo_dark = $row->logo;
			$this->logo_light = $row->logo_image;

			$this->icon = $row->icon; // full path
			$this->icon_img = $row->icon_img; // (for depracation)

			$this->size_chart = $row->size_chart;
			$this->title = $row->title;
			$this->description = $row->description;
			$this->keyword = $row->keyword;
			$this->alttags = $row->alttags;
			$this->footer = $row->footer;
			$this->url_structure = $row->url_structure == 'basix-black-label' ? 'basixblacklabel' : $row->url_structure;
			$this->site_domain = $row->domain_name;
			$this->view_status = $row->view_status;
			$this->with_products = $row->with_products;

			// using designer info or account info
			$this->address1 = $row->address1;
			$this->address2 = $row->address2;
			$this->city = $row->city;
			$this->state = $row->state;
			$this->zipcode = $row->zip;
			$this->country = $row->country;
			$this->phone = $row->phone;
			$this->info_email = $row->info_email; // webspace info

			// webspace options
			//$this->options = $row->designer_options != '' ? json_decode($row->designer_options , TRUE) : array();
			$this->webspace_options = $row->webspace_options != '' ? json_decode($row->webspace_options , TRUE) : array();

			$this->webspace_id = $row->webspace_id;
			$this->company_name = $row->company_name;
			$this->company = $row->company_name;
			$this->owner = $row->owner_name;
		}
		else
		{
			return FALSE;
		}

		if (
			$this->logo
			&& $this->icon
			&& $this->address1
			&& $this->phone
			&& $this->info_email
			&& $this->webspace_id
		)
		{
			$this->complete_info_status = TRUE;
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
			'designer' => TRUE,
			'des_id' => $this->des_id
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
			'designer' => FALSE,
			'des_id' => ''
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
		$this->des_id = '';
		$this->name = '';
		$this->designer = '';
		$this->des_code = '';
		$this->slug = '';
		$this->logo = '';
		$this->logo_image = '';
		$this->icon = '';
		$this->icon_img = '';
		$this->size_chart = '';
		$this->title = '';
		$this->description = '';
		$this->keyword = '';
		$this->alttags = '';
		$this->footer = '';
		$this->url_structure = '';
		$this->site_domain = '';
		$this->view_status = '';

		$this->address1 = '';
		$this->address2 = '';
		$this->city = '';
		$this->state = '';
		$this->zipcode = '';
		$this->country = '';
		$this->phone = '';
		$this->info_email = '';

		$this->webspace_options = array();

		$this->webspace_id = '';
		$this->company_name = '';
		$this->company = '';
		$this->owner = '';

		$this->complete_info_status = FALSE;

		return $this;
	}

	// --------------------------------------------------------------------

}
