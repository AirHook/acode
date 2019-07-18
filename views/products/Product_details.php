<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Product Details Class
 *
 * This class' objective is to output product details as properties for use in the entire
 * HTML output. This class also serves as an authentication for the admin user logging in to the
 * admin panel by which when initialized given the parameters username and password will return
 * as true if user is in record. A property "status" (is_active field) should also help determine
 * user state at admin panel and filter authentication as inactive and therfore cannot be 
 * authorized.
 *
 * Properties:	username, password, fname, lname, email, status, access_level, session_lapse
 *
 * Functions/Methods
 *		initialize($params)			Initialize class and output information
 *		set_session()				Universally SET admin related session info
 *		unset_session()				Universally UNSET admin related session info
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Admin User Details
 * @author		WebGuy
 * @link		
 */
class Product_details
{
	/**
	 * Product Info
	 *
	 * @var	string
	 */
	public $prod_id = '';
	public $prod_no = '';
	public $prod_name = '';
	public $prod_desc = '';
	
	/**
	 * Price
	 *
	 * Retail Price - currently used by db as less_discount
	 * Wholesale Price - by default is usually 50% of retail price
	 * Retail Sale Price - currently used by db as catalogue_price
	 * Wholesale Sale Price - wholesale_price_clearance
	 *
	 * @var	float
	 */
	public $retail_price = 0;		
	public $wholesale_price = 0;
	public $retail_sale_price = 0;		
	public $wholesale_price_clearance = 0;

	/**
	 * Reference Designer Association
	 *
	 * @var	string
	 */
	public $des_id = '';
	public $designer_name = '';
	public $d_url_structure = '';
	public $d_folder = '';
	
	/**
	 * Reference Vendor Association
	 *
	 * @var	string
	 */
	public $vendor_id = '';
	public $vendor_name = '';
	public $vendor_code = '';
	
	/**
	 * View Statuses
	 *
	 * @var	string/array
	 */
	public $seque = '';
	public $view_status = '';				// Y, Y1 (hub), Y2 (satellite), N
	public $public = '';					// Y, N - also a check for private wholesale view in old code
	public $custom_order = '';

	/**
	 * Publish
	 *
	 * New general product publish status:
	 * 0-unpublish, 1-publish (11-hub, 12-satellite), 2-private, 3-pending
	 * with the pending as basis for scheduled publishing
	 * ... same for per variant publish status
	 *
	 * @var	string/array
	 */
	public $publish = '';

	/**
	 * Pending - if publish date is in future
	 *
	 * @var	boolean
	 */
	public $pending = 0;

	/**
	 * Dates
	 *
	 * Product Date - date product is created (prod_date)
	 * Publish Date - date product is published (changeable) - new
	 *
	 * @var	date/array of dates
	 */
	public $create_date = '';
	public $publish_date = '';

	/**
	 * Auto Sequence
	 *
	 * @var	int
	 */
	public $auto_seque = '';

	/**
	 * Size Mode
	 *
	 * @var	int
	 */
	public $size_mode = '';
	public $size_chart = '';

	/**
	 * Clearance (entire product with colors)
	 *
	 * @var	int
	 */
	public $clearance = '';

	/**
	 * Primary Image
	 *
	 * Primary Image - primary color (color_code)
	 * Colors - hyphenated color variants e.g. BLACK-NAVY-WHITE
	 *
	 * @var	string
	 */
	public $st_id = '';
	public $primary_img = '';
	public $primary_img_id = '';
	public $primary_color = '';
	public $variant_image = '';
	public $color_name = '';
	public $color_code = '';
	
	/**
	 * Reference Images
	 *
	 * Gallery images for product item referred to media library
	 *
	 * @var	string
	 */
	public $media_path = '';
	public $media_name = '';
	public $upload_version = '';
		
	/**
	 * Facets
	 *
	 * Styles, Events (Occassions), Trends, Meterials, Colors
	 * Hyphenated at db record
	 *
	 * Will need to include Size but as method because of database setup on this product property
	 *
	 * @var	array
	 */
	public $style_facets = array();
	public $event_facets = array();
	public $trend_facets = array();
	public $material_facets = array();
	public $color_facets = array();

	/**
	 * Variants
	 *
	 * Colors - hyphenated color variants e.g. BLACK-NAVY-WHITE
	 * Each color publish status (new_color_publish):
	 * 		0-unpublish, 1-publish (11-hub, 12-satellite), 2-private, 3-pending
	 * 		with the pending as basis for scheduled publishing
	 * Publish date of color - currently used by db as stock_date
	 *
	 * color_publish, new_color_publish, color_publish_date
	 * 		we will create a method instead
	 *
	 * @var	string
	 */
	public $colors = '';
	
	
	//public $size_facets = array();	.. will need to make a method for this instead
	//public $color_publish = array();		// Y, N - view status per color variant (old code)
	//public $new_color_publish = array();
	//public $color_publish_date = array();	// per variant basis
	
	/**
	 * Categorization
	 *
	 * @var	int
	 */
	// new ways
	public $categories = array();
	public $category_names = array();
	// old ways
	public $cat_id = '';
	public $category_name = '';
	public $c_url_structure = '';
	public $c_folder = '';
	public $subcat_id = '';
	public $subcat_name = '';
	public $sc_url_structure = '';
	public $sc_folder = '';

	/**
	 * Info Status
	 *
	 * This indicates the status of information for the product is complete such as
	 * images, and mostly required fields... 
	 *
	 * @var	boolean
	 */
	public $complete_general = FALSE;
	public $complete_colors = FALSE;

	
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
	 * @params	array	$params	Initialization parameter - the item id
	 *					where prod_id = $params
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		$this->initialize($params);
		log_message('info', 'Product Details Class Initialized');
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
		$this->DB->select('tbl_product.*');
		$this->DB->select('designer.designer AS designer_name, designer.url_structure AS d_url_structure, designer.size_chart');
		$this->DB->select('tblcolor.color_name, tblcolor.color_code');
		$this->DB->select('vendors.vendor_id, vendors.vendor_name, vendors.vendor_code');
		$this->DB->select('tbl_stock.st_id, tbl_stock.custom_order, tbl_stock.image_url_path');
		$this->DB->select('media_path, media_name, upload_version');
		$this->DB->select('
			(CASE 
				WHEN designer.url_structure = "basix-black-label" THEN "basixblacklabel"
				ELSE designer.url_structure
			END) AS d_folder
		');
		$this->DB->select('categories.category_name AS category_name, categories.category_slug AS c_url_structure');
		$this->DB->select('
			(CASE 
				WHEN categories.category_slug = "apparel" THEN "WMANSAPREL"
				ELSE categories.category_slug 
			END) AS cat_folder
		');
		$this->DB->select('c2.category_name AS subcat_name');
		$this->DB->select('
			(CASE 
				WHEN c2.category_slug = "cocktail-dresses" THEN "cocktail"
				WHEN c2.category_slug = "evening-dresses" THEN "evening"
				ELSE c2.category_slug 
			END) AS sc_url_structure
		');
		$this->DB->select('
			(CASE 
				WHEN c2.category_slug = "cocktail-dresses" THEN "cocktail"
				WHEN c2.category_slug = "evening-dresses" THEN "evening"
				ELSE c2.category_slug 
			END) AS subcat_folder
		');
		$this->DB->select('
			(CASE 
				WHEN 
					tbl_product.prod_no != ""
					AND tbl_product.prod_name != ""
					AND tbl_product.cat_id != ""
					AND tbl_product.subcat_id != ""
					AND tbl_product.less_discount != ""
					AND tbl_product.wholesale_price != ""
				THEN "0"
				ELSE "1"
			END) AS complete_general
		');
		$this->DB->select('
			(CASE 
				WHEN 
					tbl_product.primary_img_id != ""
					AND tbl_product.colors != ""
				THEN "0"
				ELSE "1"
			END) AS complete_colors
		');
		$today = @date('Y-m-d', time());
		$this->DB->select('
			(CASE 
				WHEN 
					tbl_product.publish_date > "'.$today.'"
				THEN "1"
				ELSE "0"
			END) AS pending
		');
		$this->DB->select('tblsubcat.folder AS sc_folder');
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = tbl_product.vendor_id', 'left');
		$this->DB->join('categories', 'categories.category_id = tbl_product.cat_id', 'left');
		$this->DB->join('categories AS c2', 'c2.category_id = tbl_product.subcat_id', 'left');
		$this->DB->join('tblsubcat', 'tblsubcat.subcat_id = c2.category_id', 'left');
		$this->DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		if (array_key_exists('color_code', $params))
		{
			$this->DB->join('media_library_products', 'media_library_products.media_id = tbl_stock.image_url_path', 'left');
		}
		else $this->DB->join('media_library_products', 'media_library_products.media_id = tbl_product.primary_img', 'left');
		$this->DB->where($params);
		//$this->DB->where('tbl_stock.primary_color', '1');
		$this->DB->order_by('tbl_stock.primary_color', 'DESC'); 
		$query = $this->DB->get('tbl_product');
		
		//echo $this->DB->last_query(); die();
		
		$row = $query->row();
		
		if (isset($row))
		{
			// initialize properties
			// product info
			$this->prod_id = $row->prod_id;
			$this->prod_no = $row->prod_no;
			$this->prod_name = $row->prod_name;
			$this->prod_desc = $row->prod_desc;
			
			// pricing
			$this->retail_price = $row->less_discount;
			$this->wholesale_price = $row->wholesale_price;
			$this->retail_sale_price = $row->catalogue_price;
			$this->wholesale_price_clearance = $row->wholesale_price_clearance;
			
			// Reference designer
			$this->des_id = $row->designer;
			$this->designer_name = $row->designer_name;
			$this->d_url_structure = $row->d_url_structure; // special case used for categories
			$this->d_folder = $row->d_folder; // special case used for categories
			
			// Reference vendor
			$this->vendor_id = $row->vendor_id;
			$this->vendor_name = $row->vendor_name;
			$this->vendor_code = $row->vendor_code;
			
			$this->seque = $row->seque;
			$this->view_status = $row->view_status;
			$this->public = $row->public;
			$this->custom_order = $row->custom_order;
			
			// 0-unpublish, 1-publish (11-hub, 12-satellite), 2-private
			$this->publish = $row->publish;
			
			$this->pending = $row->pending;
			
			$this->create_date = $row->prod_date;
			$this->publish_date = $row->publish_date;
			
			$this->auto_seque = $row->auto_seque;
			$this->size_mode = $row->size_mode;
			$this->size_chart = $row->size_chart;
			$this->clearance = $row->clearance;
			
			// primary image data
			$this->primary_img = $row->primary_img; // primary media id
			$this->primary_img_id = $row->primary_img_id; // primary color code
			$this->primary_color = $row->color_name; // avoid using
			
			// color variant data if such
			$this->st_id = $row->st_id;
			$this->variant_image = $row->image_url_path; // variant media id
			$this->color_name = $row->color_name;
			$this->color_code = $row->color_code;
			
			// reference images
			$this->media_path = $row->media_path;
			$this->media_name = $row->media_name;
			$this->upload_version = $row->upload_version;
			
			// Categories
			// new ways
			$this->categories = ($row->categories && $row->categories != '') ? json_decode($row->categories, TRUE) : array();
			$this->category_names = $this->_get_names($this->categories);
			// old ways
			$this->cat_id = $row->cat_id;
			$this->category_name = $row->category_name;
			$this->c_url_structure = $row->c_url_structure;
			$this->c_folder = $row->cat_folder;
			$this->subcat_id = $row->subcat_id;
			$this->subcat_name = $row->subcat_name;
			$this->sc_url_structure = $row->sc_url_structure;
			$this->sc_folder = $row->sc_folder;
			
			// Facets
			$this->style_facets = explode('-', $row->styles);
			$this->event_facets = explode('-', $row->events);
			$this->trend_facets = explode('-', $row->trends);
			$this->material_facets = explode('-', $row->materials);
			$this->color_facets = explode('-', $row->colors);
			
			// Variants
			$this->colors = $row->colors;
		
			return $this;
		}
		else
		{
			// since there is no record, return false...
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get specific variants for informational purposes
	 *
	 * @return	object/boolean false
	 */
	public function variant_id($color_code = '')
	{
		if ( ! $color_code)
		{
			// nothing more to do...
			return FALSE;
		}
		
		$this->DB->select('tbl_stock.st_id');
		$this->DB->from('tbl_stock');
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		$this->DB->where('prod_no', $this->prod_no);
		$this->DB->where('color_code', $color_code);
		$query = $this->DB->get();
		
		//echo '<pre>'; echo $this->DB->last_query(); die();
		
		$row = $query->row();
		
		if (isset($row))
		{
			return $row->st_id;
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Check and Process Publish Date
	 *
	 * @return	date string/boolean false
	 */
	public function time_to_publish($prod_id = '')
	{
		if ( ! $prod_id)
		{
			// nothing more to do...
			return FALSE;
		}
		
		// let's get 'publish_date' field
		$this->DB->select('publish_date');
		$q = $this->DB->get_where('tbl_product', array('prod_id'=>$prod_id))->row();
		
		if (strtotime($q->publish_date) > strtotime('now'))
		{
			// nothing to do...
			return FALSE;
		}
		
		// publish item
		$this->DB->set('publish', '1');
		$this->DB->set('public', 'Y');
		$this->DB->set('view_status', 'Y');
		$this->DB->update('tbl_product');
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Available Colors
	 * Checks all available colors
	 * And, can get a specific availabe color provided $params
	 *
	 $ @params	array
	 * @return	object/boolean false
	 */
	public function available_colors($params = array(), $return_ary = FALSE)
	{
		if ( ! empty($params))
		{
			$this->DB->where($params);
		}
		
		// get recrods
		$this->DB->select('tbl_stock.*');
		$this->DB->select('tblcolor.color_code AS color_code');
		$this->DB->select('media_path, media_name, upload_version');
		if ($this->size_mode == '0')
		{
			$this->DB->select('
				(CASE 
					WHEN 
						tbl_stock.size_ss != ""
						OR tbl_stock.size_sm != "0"
						OR tbl_stock.size_sl != "0"
						OR tbl_stock.size_sxl != "0"
						OR tbl_stock.size_sxxl != "0"
					THEN "1"
					ELSE "0"
				END) AS with_stocks
			');
		}
		elseif ($this->size_mode == '1')
		{
			$this->DB->select('
				(CASE 
					WHEN 
						tbl_stock.size_0 != ""
						OR tbl_stock.size_2 != "0"
						OR tbl_stock.size_4 != "0"
						OR tbl_stock.size_6 != "0"
						OR tbl_stock.size_8 != "0"
						OR tbl_stock.size_10 != "0"
						OR tbl_stock.size_12 != "0"
						OR tbl_stock.size_14 != "0"
						OR tbl_stock.size_16 != "0"
						OR tbl_stock.size_18 != "0"
						OR tbl_stock.size_20 != "0"
						OR tbl_stock.size_22 != "0"
					THEN "1"
					ELSE "0"
				END) AS with_stocks
			');
		}
		$today = @date('Y-m-d', time());
		$this->DB->select('
			(CASE 
				WHEN 
					tbl_stock.stock_date > "'.$today.'"
				THEN "1"
				ELSE "0"
			END) AS color_pending
		');
		$this->DB->where('prod_no', $this->prod_no);
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		$this->DB->join('media_library_products', 'media_library_products.media_id = tbl_stock.image_url_path', 'left');
		$this->DB->order_by('primary_color', 'desc');
		$query = $this->DB->get('tbl_stock');
		
		//echo '<pre>'; echo $this->DB->last_query(); die();
		
		if ($query->num_rows() == 0)
		{
			// since there is no record, return false...
			return FALSE;
		}
		else
		{
			// multiple row result
			if ($return_ary)
			{
				foreach ($query->result() as $row)
				{
					$array[$row->color_code] = $row->color_name;
				}
				
				return $array;
			}
			else
			{
				return $query->result();
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get specific variants for informational purposes
	 *
	 * @return	object/boolean false
	 */
	private function _get_names($categories = array())
	{
		if (empty($categories))
		{
			// nothing more to do...
			return FALSE;
		}
		
		$array = array();
		
		foreach ($categories as $category_id)
		{
			$this->DB->select('category_name');
			$this->DB->from('categories');
			$this->DB->where('category_id', $category_id);
			$query = $this->DB->get();
			
			//echo '<pre>'; echo $this->DB->last_query(); die();
			
			$row = $query->row();
			
			if (isset($row))
			{
				array_push($array, $row->category_name);
			}
		}
		
		return $array;
	}
	
	// --------------------------------------------------------------------

	/**
	 * De-Initialize Class
	 *
	 * @return	object
	 */
	public function deinitialize()
	{
		// product info
		$this->prod_id = '';
		$this->prod_no = '';
		$this->prod_name = '';
		$this->prod_desc = '';
		
		// pricing
		$this->retail_price = 0;
		$this->wholesale_price = 0;
		$this->retail_sale_price = 0;
		$this->wholesale_price_clearance = 0;
		
		// Reference designer
		$this->des_id = '';
		$this->designer_name = '';
		$this->d_url_structure = '';
		$this->d_folder = '';
		
		// Reference vendor
		$this->vendor_id = '';
		$this->vendor_name = '';
		$this->vendor_code = '';
		
		$this->seque = '';
		$this->view_status = '';
		$this->public = '';
		$this->custom_order = '';
		
		// 0-unpublish, 1-publish (11-hub, 12-satellite), 2-private
		$this->publish = '';
		
		$this->pending = 0;
		
		$this->create_date = '';
		$this->publish_date = '';
		
		$this->auto_seque = '';
		$this->size_mode = '';
		$this->size_chart = '';
		$this->clearance = '';
		
		$this->st_id = '';
		$this->primary_img = '';
		$this->primary_img_id = '';
		$this->primary_color = '';
		$this->color_name = '';
		$this->color_code = '';
		
		// reference images
		$this->media_path = '';
		$this->media_name = '';
		$this->upload_version = '';
		
		// Categories
		// new ways
		$this->categories = array();
		$this->category_names = array();
		// old ways
		$this->cat_id = '';
		$this->category_name = '';
		$this->c_url_structure = '';
		$this->c_folder = '';
		$this->subcat_id = '';
		$this->subcat_name = '';
		$this->sc_url_structure = '';
		$this->sc_folder = '';
		
		// Facets
		$this->style_facets = array();
		$this->event_facets = array();
		$this->trend_facets = array();
		$this->material_facets = array();
		$this->color_facets = array();
		
		// Variants
		$this->colors = '';
	
		$this->complete_general = FALSE;
		$this->complete_colors = FALSE;
	
		return $this;
	}
	
	// --------------------------------------------------------------------

}
