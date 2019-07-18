<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Category Details Class
 *
 * This class get the category details for use on front end
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Sales User Details
 * @author		WebGuy
 * @link
 */
class Category_details
{
	/**
	 * Category Id
	 *
	 * @var	string
	 */
	public $category_id = '';

	/**
	 * Category Sequencing
	 *
	 * @var	string
	 */
	public $category_seque = '';

	/**
	 * Category Name
	 *
	 * @var	string
	 */
	public $category_name = '';

	/**
	 * Category Slug
	 *
	 * @var	string
	 */
	public $category_slug = '';

	/**
	 * Parent Category
	 *
	 * @var	string
	 */
	public $parent_category = '';

	/**
	 * Category Level
	 *
	 * @var	string
	 */
	public $category_level = '';

	/**
	 * With Child
	 *
	 * @var	string
	 */
	public $with_child = '';

	/**
	 * View Status
	 *
	 * @var	string
	 */
	public $status = '';

	/**
	 * Meta Info
	 *
	 * @var	string
	 */
	public $designers = array();
	public $linked_designers = array();
	public $icons = array();
	public $descriptions = array();

	public $title = array();
	public $keyword = array();
	public $alttags = array();
	public $footer = array();


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

		if (isset($params['category_id']))
		{
			$this->DB->select('*');
			$this->DB->select("
				(CASE
					WHEN EXISTS (SELECT * FROM tbl_product WHERE tbl_product.subcat_id = '".$params['category_id']."')
					THEN '1'
					ELSE '0'
				END) AS with_products
			");
			$this->DB->select("
				(SELECT COUNT(*)
					FROM categories
					WHERE parent_category = '".$params['category_id']."'
						AND category_id != '".$params['category_id']."') AS with_child
			");
		}

		// get recrods
		$this->DB->where($params);
		$query = $this->DB->get('categories');

		// for debuggin purposes
		//echo '<pre>'; print_r($params); echo $this->DB->last_query(); die();

		$row = $query->row();

		if (isset($row))
		{
			// initialize properties
			$this->category_id = $row->category_id;
			$this->category_seque = $row->category_seque;
			$this->category_name = $row->category_name;
			$this->category_slug = $row->category_slug;
			$this->parent_category = $row->parent_category;
			$this->category_level = $row->category_level;
			$this->with_child = isset($params['category_id']) ? $row->with_child : '';
			$this->status = $row->view_status;

			/*
			$this->title = $row->title;
			$this->keyword = $row->keyword;
			$this->alttags = $row->alttags;
			$this->footer = $row->footer;

			$this->designers = $row->d_url_structure;
			$this->icons = $row->icon_image;
			$this->descriptions = $row->description;
			*/

			// we need to convert each designers, icons, and meta into json encoded string
			// so we can use the simple line of code below
			//$this->designers = $row->d_url_structure != '' ? json_decode($row->d_url_structure , TRUE) : array();

			$designers = json_decode($row->d_url_structure , TRUE);
			$this->designers = json_last_error() === JSON_ERROR_NONE ? $designers : $row->d_url_structure;
			$linked_designers = json_decode($row->d_url_structure , TRUE);
			$this->linked_designers = json_last_error() === JSON_ERROR_NONE ? $linked_designers : $row->d_url_structure;

			$icons = json_decode($row->icon_image , TRUE);
			$this->icons = json_last_error() === JSON_ERROR_NONE ? $icons : $row->icon_image;
			$descriptions = json_decode($row->description , TRUE);
			$this->descriptions = json_last_error() === JSON_ERROR_NONE ? $descriptions : $row->description;

			$title = json_decode($row->title , TRUE);
			$this->title = json_last_error() === JSON_ERROR_NONE ? $title : $row->title;
			$keyword = json_decode($row->keyword , TRUE);
			$this->keyword = json_last_error() === JSON_ERROR_NONE ? $keyword : $row->keyword;
			$alttags = json_decode($row->alttags , TRUE);
			$this->alttags = json_last_error() === JSON_ERROR_NONE ? $alttags : $row->alttags;
			$footer = json_decode($row->footer , TRUE);
			$this->footer = json_last_error() === JSON_ERROR_NONE ? $footer : $row->footer;

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
			'categories' => TRUE,
			'category_id' => $this->id
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
			'categories' => FALSE,
			'category_id' => ''
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
		$this->category_id = '';
		$this->category_seque = '';
		$this->category_name = '';
		$this->category_slug = '';
		$this->parent_category = '';
		$this->category_level = '';
		$this->with_child = '';
		$this->status = '';
		$this->title = '';
		$this->keyword = '';
		$this->alttags = '';
		$this->footer = '';
		$this->designers = array();
		$this->icons = array();
		$this->descriptions = array();

		return $this;
	}

	// --------------------------------------------------------------------

}
