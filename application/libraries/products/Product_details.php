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
	public $vendor_price = 0;

	/**
	 * Reference Designer Association
	 *
	 * @var	string
	 */
	public $des_id = '';
	public $designer_name = '';
	public $designer_slug = '';
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
	 * Sequencing
	 *
	 * @var	string (numeric)
	 */
	public $seque = '';

	/**
	 * View Statuses
	   This status properties are for depracation
	 *
	 * @var	string/array
	 */
	public $view_status = '';				// Y, Y1 (hub), Y2 (satellite), N
	public $public = '';					// Y, N - also a check for private wholesale view in old code

	/**
	 * Clearance or Pre order status
	 *
	 * @var	string/array
	 */
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
	public $prod_date = ''; // prod_date
	public $create_date = ''; // alias to prod_date
	public $publish_date = '';
	public $last_modified = '';

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
	public $season_facets = array();

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
	public $category_slugs = array();
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
	 * Sizes for when product details has color as params or st_id
	 * As long as a specific variant is queried
	 *
	 * @var	int
	 */
	// AVAILABLE STOCK
	// size mode 0
	public $size_ss = 0;
	public $size_sm = 0;
	public $size_sl = 0;
	public $size_sxl = 0;
	public $size_sxxl = 0;
	public $size_sxl1 = 0;
	public $size_sxl2 = 0;
	// size mode 1
	public $size_0 = 0;
	public $size_2 = 0;
	public $size_4 = 0;
	public $size_6 = 0;
	public $size_8 = 0;
	public $size_10 = 0;
	public $size_12 = 0;
	public $size_14 = 0;
	public $size_16 = 0;
	public $size_18 = 0;
	public $size_20 = 0;
	public $size_22 = 0;
	// size mode 2
	public $size_sprepack1221 = 0;
	// size mode 3
	public $size_ssm = 0;
	public $size_sml = 0;
	// size mode 4
	public $size_sonesizefitsall = 0;

	// ONORDER STOCK
	// size mode 0
	public $onorder_st_id = '';
	public $onorder_ss = 0;
	public $onorder_sm = 0;
	public $onorder_sl = 0;
	public $onorder_sxl = 0;
	public $onorder_sxxl = 0;
	public $onorder_sxl1 = 0;
	public $onorder_sxl2 = 0;
	// size mode 1
	public $onorder_0 = 0;
	public $onorder_2 = 0;
	public $onorder_4 = 0;
	public $onorder_6 = 0;
	public $onorder_8 = 0;
	public $onorder_10 = 0;
	public $onorder_12 = 0;
	public $onorder_14 = 0;
	public $onorder_16 = 0;
	public $onorder_18 = 0;
	public $onorder_20 = 0;
	public $onorder_22 = 0;
	// size mode 2
	public $onorder_sprepack1221 = 0;
	// size mode 3
	public $onorder_ssm = 0;
	public $onorder_sml = 0;
	// size mode 4
	public $onorder_sonesizefitsall = 0;

	// PHYSICAL STOCK
	// size mode 0
	public $physical_st_id = '';
	public $physical_ss = 0;
	public $physical_sm = 0;
	public $physical_sl = 0;
	public $physical_sxl = 0;
	public $physical_sxxl = 0;
	public $physical_sxl1 = 0;
	public $physical_sxl2 = 0;
	// size mode 1
	public $physical_0 = 0;
	public $physical_2 = 0;
	public $physical_4 = 0;
	public $physical_6 = 0;
	public $physical_8 = 0;
	public $physical_10 = 0;
	public $physical_12 = 0;
	public $physical_14 = 0;
	public $physical_16 = 0;
	public $physical_18 = 0;
	public $physical_20 = 0;
	public $physical_22 = 0;
	// size mode 2
	public $physical_sprepack1221 = 0;
	// size mode 3
	public $physical_ssm = 0;
	public $physical_sml = 0;
	// size mode 4
	public $physical_sonesizefitsall = 0;

	/**
	 * Product Options
	 *
	 * @var	array
	 */
	public $options = array();
	public $stocks_options = array();


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
	 * Last DB query string
	 *
	 * @var	boolean/string
	 */
	public $last_query = FALSE;


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
		$this->DB->select('tbl_stock.st_id, tbl_stock.custom_order, tbl_stock.image_url_path, tbl_stock.options as stocks_options');
		$this->DB->select('media_path, media_name, upload_version');
		$this->DB->select('
			tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall
		');
		$this->DB->select('
			tso.st_id AS onorder_st_id,
			tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
			tso.size_sl AS onorder_sl, tso.size_sxl AS onorder_sxl,
			tso.size_sxxl AS onorder_sxxl, tso.size_sxl1 AS onorder_sxl1,
			tso.size_sxl2 AS onorder_sxl2,
			tso.size_0 AS onorder_0, tso.size_2 AS onorder_2,
			tso.size_4 AS onorder_4, tso.size_6 AS onorder_6,
			tso.size_8 AS onorder_8, tso.size_10 AS onorder_10,
			tso.size_12 AS onorder_12, tso.size_14 AS onorder_14,
			tso.size_16 AS onorder_16, tso.size_18 AS onorder_18,
			tso.size_20 AS onorder_20, tso.size_22 AS onorder_22,
			tso.size_sprepack1221 AS onorder_sprepack1221,
			tso.size_ssm AS onorder_ssm, tso.size_sml AS onorder_sml,
			tso.size_sonesizefitsall AS onorder_sonesizefitsall
		');
		$this->DB->select('
			tsp.st_id AS physical_st_id,
			tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
			tsp.size_sl AS physical_sl, tsp.size_sxl AS physical_sxl,
			tsp.size_sxxl AS physical_sxxl, tsp.size_sxl1 AS physical_sxl1,
			tsp.size_sxl2 AS physical_sxl2,
			tsp.size_0 AS physical_0, tsp.size_2 AS physical_2,
			tsp.size_4 AS physical_4, tsp.size_6 AS physical_6,
			tsp.size_8 AS physical_8, tsp.size_10 AS physical_10,
			tsp.size_12 AS physical_12, tsp.size_14 AS physical_14,
			tsp.size_16 AS physical_16, tsp.size_18 AS physical_18,
			tsp.size_20 AS physical_20, tsp.size_22 AS physical_22,
			tsp.size_sprepack1221 AS physical_sprepack1221,
			tsp.size_ssm AS physical_ssm, tsp.size_sml AS physical_sml,
			tsp.size_sonesizefitsall AS physical_sonesizefitsall
		');
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
		$this->DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		if (
			array_key_exists('color_code', $params)
			OR array_key_exists('tbl_stock.color_name', $params)
		)
		{
			$this->DB->join('media_library_products', 'media_library_products.media_id = tbl_stock.image_url_path', 'left');
		}
		else $this->DB->join('media_library_products', 'media_library_products.media_id = tbl_product.primary_img', 'left');
		$this->DB->where($params);
		//$this->DB->where('tbl_stock.primary_color', '1');
		$this->DB->order_by('tbl_stock.primary_color', 'DESC');
		$query = $this->DB->get('tbl_product');

		//echo '<pre>';
		//print_r($params);
		//echo '<br />';
		//echo $this->DB->last_query();
		//die();

		// save last query string (with out the LIMIT portion)
		$this->last_query = $this->DB->last_query();

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
			$this->vendor_price = $row->vendor_price ?: ceil($row->wholesale_price / 3);

			// Reference designer
			$this->des_id = $row->designer;
			$this->designer_name = $row->designer_name;
			$this->designer_slug = $row->d_url_structure;
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

			$this->prod_date = $row->prod_date;
			$this->create_date = $row->prod_date;
			$this->publish_date = $row->publish_date;
			$this->last_modified = $row->last_modified;

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
			$this->category_slugs = $this->_get_slugs($this->categories);
			// old ways
			$this->cat_id = $row->cat_id;
			$this->category_name = $row->category_name;
			$this->c_url_structure = $row->c_url_structure;
			$this->c_folder = $row->cat_folder;
			$this->subcat_id = $row->subcat_id;
			$this->subcat_name = $row->subcat_name;
			$this->sc_url_structure = $row->sc_url_structure;
			$this->sc_folder = $row->sc_folder;

			// color variant data if such
			// AVAILABLE SIZES
			$this->size_ss = $row->size_ss;
			$this->size_sm = $row->size_sm;
			$this->size_sl = $row->size_sl;
			$this->size_sxl = $row->size_sxl;
			$this->size_sxxl = $row->size_sxxl;
			$this->size_sxl1 = $row->size_sxl1;
			$this->size_sxl2 = $row->size_sxl2;
			$this->size_0 = $row->size_0;
			$this->size_2 = $row->size_2;
			$this->size_4 = $row->size_4;
			$this->size_6 = $row->size_6;
			$this->size_8 = $row->size_8;
			$this->size_10 = $row->size_10;
			$this->size_12 = $row->size_12;
			$this->size_14 = $row->size_14;
			$this->size_16 = $row->size_16;
			$this->size_18 = $row->size_18;
			$this->size_20 = $row->size_20;
			$this->size_22 = $row->size_22;
			$this->size_sprepack1221 = $row->size_sprepack1221;
			$this->size_ssm = $row->size_ssm;
			$this->size_sml = $row->size_sml;
			$this->size_sonesizefitsall = $row->size_sonesizefitsall;

			// ONORDER SIZES
			$this->onorder_st_id = $row->onorder_st_id;
			$this->onorder_ss = $row->onorder_ss;
			$this->onorder_sm = $row->onorder_sm;
			$this->onorder_sl = $row->onorder_sl;
			$this->onorder_sxl = $row->onorder_sxl;
			$this->onorder_sxxl = $row->onorder_sxxl;
			$this->onorder_sxl1 = $row->onorder_sxl1;
			$this->onorder_sxl2 = $row->onorder_sxl2;
			$this->onorder_0 = $row->onorder_0;
			$this->onorder_2 = $row->onorder_2;
			$this->onorder_4 = $row->onorder_4;
			$this->onorder_6 = $row->onorder_6;
			$this->onorder_8 = $row->onorder_8;
			$this->onorder_10 = $row->onorder_10;
			$this->onorder_12 = $row->onorder_12;
			$this->onorder_14 = $row->onorder_14;
			$this->onorder_16 = $row->onorder_16;
			$this->onorder_18 = $row->onorder_18;
			$this->onorder_20 = $row->onorder_20;
			$this->onorder_22 = $row->onorder_22;
			$this->onorder_sprepack1221 = $row->onorder_sprepack1221;
			$this->onorder_ssm = $row->onorder_ssm;
			$this->onorder_sml = $row->onorder_sml;
			$this->onorder_sonesizefitsall = $row->onorder_sonesizefitsall;

			// PHYSICAL SIZES
			$this->physical_st_id = $row->physical_st_id;
			$this->physical_ss = $row->physical_ss;
			$this->physical_sm = $row->physical_sm;
			$this->physical_sl = $row->physical_sl;
			$this->physical_sxl = $row->physical_sxl;
			$this->physical_sxxl = $row->physical_sxxl;
			$this->physical_sxl1 = $row->physical_sxl1;
			$this->physical_sxl2 = $row->physical_sxl2;
			$this->physical_0 = $row->physical_0;
			$this->physical_2 = $row->physical_2;
			$this->physical_4 = $row->physical_4;
			$this->physical_6 = $row->physical_6;
			$this->physical_8 = $row->physical_8;
			$this->physical_10 = $row->physical_10;
			$this->physical_12 = $row->physical_12;
			$this->physical_14 = $row->physical_14;
			$this->physical_16 = $row->physical_16;
			$this->physical_18 = $row->physical_18;
			$this->physical_20 = $row->physical_20;
			$this->physical_22 = $row->physical_22;
			$this->physical_sprepack1221 = $row->physical_sprepack1221;
			$this->physical_ssm = $row->physical_ssm;
			$this->physical_sml = $row->physical_sml;
			$this->physical_sonesizefitsall = $row->physical_sonesizefitsall;

			// Facets
			$this->style_facets = explode('-', $row->styles);
			$this->event_facets = explode('-', $row->events);
			$this->trend_facets = explode('-', $row->trends);
			$this->material_facets = explode('-', $row->materials);
			$this->color_facets = explode('-', $row->colors);
			$this->season_facets = explode('-', $row->seasons);

			// Variants
			$this->colors = $row->colors;

			// the options
			$this->options =
				($row->options && $row->options != '')
				? json_decode($row->options , TRUE)
				: array()
			; // tbl_product options
			$this->stocks_options =
				($row->stocks_options && $row->stocks_options != '')
				? json_decode($row->stocks_options , TRUE)
				: array()
			; // tbl_stock options

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
						tbl_stock.size_ss != "0"
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
						tbl_stock.size_0 != "0"
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
		elseif ($this->size_mode == '2')
		{
			$this->DB->select('
				(CASE
					WHEN
						tbl_stock.size_sprepack1221 != "0"
					THEN "1"
					ELSE "0"
				END) AS with_stocks
			');
		}
		elseif ($this->size_mode == '3')
		{
			$this->DB->select('
				(CASE
					WHEN
						tbl_stock.size_ssm != "0"
						OR tbl_stock.size_sml != "0"
					THEN "1"
					ELSE "0"
				END) AS with_stocks
			');
		}
		elseif ($this->size_mode == '4')
		{
			$this->DB->select('
				(CASE
					WHEN
						tbl_stock.size_sonesizefitsall != "0"
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
		$this->DB->group_by('color_name');
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
	 * Get specific variants for informational purposes
	 *
	 * @return	object/boolean false
	 */
	private function _get_slugs($categories = array())
	{
		if (empty($categories))
		{
			// nothing more to do...
			return FALSE;
		}

		$array = array();

		foreach ($categories as $category_id)
		{
			$this->DB->select('category_slug');
			$this->DB->from('categories');
			$this->DB->where('category_id', $category_id);
			$query = $this->DB->get();

			//echo '<pre>'; echo $this->DB->last_query(); die();

			$row = $query->row();

			if (isset($row))
			{
				array_push($array, $row->category_slug);
			}
		}

		return $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Get specific variants for informational purposes
	 *
	 * @return	object/boolean false
	 */
	public function get_color_name($color_code = '')
	{
		if ( ! $color_code)
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->select('color_name');
		$this->DB->from('tblcolor');
		$this->DB->where('color_code', $color_code);
		$query = $this->DB->get();

		$row = $query->row();

		if (isset($row))
		{
			return $row->color_name;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get specific variants for informational purposes
	 *
	 * @return	object/boolean false
	 */
	public function get_color_sizes($st_id = '', $param = 'physical')
	{
		if ( ! $st_id)
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->select('
			tbl_stock.st_id,
			tbl_stock.prod_no, tbl_stock.color_name, tbl_stock.color_facets,
			tbl_stock.color_publish, tbl_stock.new_color_publish,
			tbl_stock.primary_color, tbl_stock.stock_date,
			tbl_stock.custom_order, tbl_stock.image_url_path
		');
		$this->DB->select('
			tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall
		');
		$this->DB->select('
			tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
			tso.size_sl AS onorder_sl, tso.size_sxl AS onorder_sxl,
			tso.size_sxxl AS onorder_sxxl, tso.size_sxl1 AS onorder_sxl1,
			tso.size_sxl2 AS onorder_sxl2,
			tso.size_0 AS onorder_0, tso.size_2 AS onorder_2,
			tso.size_4 AS onorder_4, tso.size_6 AS onorder_6,
			tso.size_8 AS onorder_8, tso.size_10 AS onorder_10,
			tso.size_12 AS onorder_12, tso.size_14 AS onorder_14,
			tso.size_16 AS onorder_16, tso.size_18 AS onorder_18,
			tso.size_20 AS onorder_20, tso.size_22 AS onorder_22,
			tso.size_sprepack1221 AS onorder_sprepack1221,
			tso.size_ssm AS onorder_ssm, tso.size_sml AS onorder_sml,
			tso.size_sonesizefitsall AS onorder_sonesizefitsall
		');
		$this->DB->select('
			tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
			tsp.size_sl AS physical_sl, tsp.size_sxl AS physical_sxl,
			tsp.size_sxxl AS physical_sxxl, tsp.size_sxl1 AS physical_sxl1,
			tsp.size_sxl2 AS physical_sxl2,
			tsp.size_0 AS physical_0, tsp.size_2 AS physical_2,
			tsp.size_4 AS physical_4, tsp.size_6 AS physical_6,
			tsp.size_8 AS physical_8, tsp.size_10 AS physical_10,
			tsp.size_12 AS physical_12, tsp.size_14 AS physical_14,
			tsp.size_16 AS physical_16, tsp.size_18 AS physical_18,
			tsp.size_20 AS physical_20, tsp.size_22 AS physical_22,
			tsp.size_sprepack1221 AS physical_sprepack1221,
			tsp.size_ssm AS physical_ssm, tsp.size_sml AS physical_sml,
			tsp.size_sonesizefitsall AS physical_sonesizefitsall
		');
		$this->DB->from('tbl_stock');
		$this->DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$this->DB->where('tbl_stock.st_id', $st_id);
		$query = $this->DB->get();

		$row = $query->row();

		if (isset($row))
		{
			if ($param == 'available')
			{
				// size in array
				if ($this->size_mode == '0')
				{
					if ($row->size_ss > '0') $size_array['size_ss'] = $this->size_ss;
					if ($row->size_sm > '0') $size_array['size_sm'] = $this->size_sm;
					if ($row->size_sl > '0') $size_array['size_sl'] = $this->size_sl;
					if ($row->size_sxl > '0') $size_array['size_sxl'] = $this->size_sxl;
					if ($row->size_sxxl > '0') $size_array['size_sxxl'] = $this->size_sxxl;
					if ($row->size_sxl1 > '0') $size_array['size_sxl1'] = $this->size_sxl1;
					if ($row->size_sxl2 > '0') $size_array['size_sxl2'] = $this->size_sxl2;
				}
				if ($this->size_mode == '1')
				{
					if ($row->size_0 > '0') $size_array['size_0'] = $this->size_0;
					if ($row->size_2 > '0') $size_array['size_2'] = $this->size_2;
					if ($row->size_4 > '0') $size_array['size_4'] = $this->size_4;
					if ($row->size_6 > '0') $size_array['size_6'] = $this->size_6;
					if ($row->size_8 > '0') $size_array['size_8'] = $this->size_8;
					if ($row->size_10 > '0') $size_array['size_10'] = $this->size_10;
					if ($row->size_12 > '0') $size_array['size_12'] = $this->size_12;
					if ($row->size_14 > '0') $size_array['size_14'] = $this->size_14;
					if ($row->size_16 > '0') $size_array['size_16'] = $this->size_16;
					if ($row->size_18 > '0') $size_array['size_18'] = $this->size_18;
					if ($row->size_20 > '0') $size_array['size_20'] = $this->size_20;
					if ($row->size_22 > '0') $size_array['size_22'] = $this->size_22;
				}
				if ($this->size_mode == '2')
				{
					if ($row->size_sprepack1221 > '0') $size_array['size_sprepack1221'] = $this->size_sprepack1221;
				}
				if ($this->size_mode == '3')
				{
					if ($row->size_ssm > '0') $size_array['size_ssm'] = $this->size_ssm;
					if ($row->size_sml > '0') $size_array['size_sml'] = $this->size_sml;
				}
				if ($this->size_mode == '4')
				{
					if ($row->size_sonesizefitsall > '0') $size_array['size_sonesizefitsall'] = $this->size_sonesizefitsall;
				}
			}
			else if ($param == 'onorder')
			{
				// size in array
				if ($this->size_mode == '0')
				{
					if ($row->onorder_ss > '0') $size_array['onorder_ss'] = $this->onorder_ss;
					if ($row->onorder_sm > '0') $size_array['onorder_sm'] = $this->onorder_sm;
					if ($row->onorder_sl > '0') $size_array['onorder_sl'] = $this->onorder_sl;
					if ($row->onorder_sxl > '0') $size_array['onorder_sxl'] = $this->onorder_sxl;
					if ($row->onorder_sxxl > '0') $size_array['onorder_sxxl'] = $this->onorder_sxxl;
					if ($row->onorder_sxl1 > '0') $size_array['onorder_sxl1'] = $this->onorder_sxl1;
					if ($row->onorder_sxl2 > '0') $size_array['onorder_sxl2'] = $this->onorder_sxl2;
				}
				if ($this->size_mode == '1')
				{
					if ($row->onorder_0 > '0') $size_array['onorder_0'] = $this->onorder_0;
					if ($row->onorder_2 > '0') $size_array['onorder_2'] = $this->onorder_2;
					if ($row->onorder_4 > '0') $size_array['onorder_4'] = $this->onorder_4;
					if ($row->onorder_6 > '0') $size_array['onorder_6'] = $this->onorder_6;
					if ($row->onorder_8 > '0') $size_array['onorder_8'] = $this->onorder_8;
					if ($row->onorder_10 > '0') $size_array['onorder_10'] = $this->onorder_10;
					if ($row->onorder_12 > '0') $size_array['onorder_12'] = $this->onorder_12;
					if ($row->onorder_14 > '0') $size_array['onorder_14'] = $this->onorder_14;
					if ($row->onorder_16 > '0') $size_array['onorder_16'] = $this->onorder_16;
					if ($row->onorder_18 > '0') $size_array['onorder_18'] = $this->onorder_18;
					if ($row->onorder_20 > '0') $size_array['onorder_20'] = $this->onorder_20;
					if ($row->onorder_22 > '0') $size_array['onorder_22'] = $this->onorder_22;
				}
				if ($this->size_mode == '2')
				{
					if ($row->onorder_sprepack1221 > '0') $size_array['onorder_sprepack1221'] = $this->onorder_sprepack1221;
				}
				if ($this->size_mode == '3')
				{
					if ($row->onorder_ssm > '0') $size_array['onorder_ssm'] = $this->onorder_ssm;
					if ($row->onorder_sml > '0') $size_array['onorder_sml'] = $this->onorder_sml;
				}
				if ($this->size_mode == '4')
				{
					if ($row->onorder_sonesizefitsall > '0') $size_array['onorder_sonesizefitsall'] = $this->onorder_sonesizefitsall;
				}
			}
			else
			{
				// size in array
				if ($this->size_mode == '0')
				{
					if ($row->physical_ss > '0') $size_array['physical_ss'] = $this->physical_ss;
					if ($row->physical_sm > '0') $size_array['physical_sm'] = $this->physical_sm;
					if ($row->physical_sl > '0') $size_array['physical_sl'] = $this->physical_sl;
					if ($row->physical_sxl > '0') $size_array['physical_sxl'] = $this->physical_sxl;
					if ($row->physical_sxxl > '0') $size_array['physical_sxxl'] = $this->physical_sxxl;
					if ($row->physical_sxl1 > '0') $size_array['physical_sxl1'] = $this->physical_sxl1;
					if ($row->physical_sxl2 > '0') $size_array['physical_sxl2'] = $this->physical_sxl2;
				}
				if ($this->size_mode == '1')
				{
					if ($row->physical_0 > '0') $size_array['physical_0'] = $this->physical_0;
					if ($row->physical_2 > '0') $size_array['physical_2'] = $this->physical_2;
					if ($row->physical_4 > '0') $size_array['physical_4'] = $this->physical_4;
					if ($row->physical_6 > '0') $size_array['physical_6'] = $this->physical_6;
					if ($row->physical_8 > '0') $size_array['physical_8'] = $this->physical_8;
					if ($row->physical_10 > '0') $size_array['physical_10'] = $this->physical_10;
					if ($row->physical_12 > '0') $size_array['physical_12'] = $this->physical_12;
					if ($row->physical_14 > '0') $size_array['physical_14'] = $this->physical_14;
					if ($row->physical_16 > '0') $size_array['physical_16'] = $this->physical_16;
					if ($row->physical_18 > '0') $size_array['physical_18'] = $this->physical_18;
					if ($row->physical_20 > '0') $size_array['physical_20'] = $this->physical_20;
					if ($row->physical_22 > '0') $size_array['physical_22'] = $this->physical_22;
				}
				if ($this->size_mode == '2')
				{
					if ($row->physical_sprepack1221 > '0') $size_array['physical_sprepack1221'] = $this->physical_sprepack1221;
				}
				if ($this->size_mode == '3')
				{
					if ($row->physical_ssm > '0') $size_array['physical_ssm'] = $this->physical_ssm;
					if ($row->physical_sml > '0') $size_array['physical_sml'] = $this->physical_sml;
				}
				if ($this->size_mode == '4')
				{
					if ($row->physical_sonesizefitsall > '0') $size_array['physical_sonesizefitsall'] = $this->physical_sonesizefitsall;
				}
			}

			if ( ! empty($size_array)) return $size_array;
		}

		return FALSE;
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
		$this->vendor_price = 0;

		// Reference designer
		$this->des_id = '';
		$this->designer_name = '';
		$this->designer_slug = '';
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

		$this->prod_date = '';
		$this->create_date = '';
		$this->publish_date = '';
		$this->last_modified = '';

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
		$this->category_slugs = array();
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

		// sizes
		// AVAILABLE
		$this->size_0 = 0;
		$this->size_2 = 0;
		$this->size_4 = 0;
		$this->size_6 = 0;
		$this->size_8 = 0;
		$this->size_10 = 0;
		$this->size_12 = 0;
		$this->size_14 = 0;
		$this->size_16 = 0;
		$this->size_18 = 0;
		$this->size_20 = 0;
		$this->size_22 = 0;
		$this->size_ss = 0;
		$this->size_sm = 0;
		$this->size_sl = 0;
		$this->size_sxl = 0;
		$this->size_sxxl = 0;
		$this->size_sxl1 = 0;
		$this->size_sxl2 = 0;
		$this->size_sprepack1221 = 0;
		$this->size_ssm = 0;
		$this->size_sml = 0;
		$this->size_sonesizefitsall = 0;
		// ONORDER
		$this->onorder_st_id = '';
		$this->onorder_0 = 0;
		$this->onorder_2 = 0;
		$this->onorder_4 = 0;
		$this->onorder_6 = 0;
		$this->onorder_8 = 0;
		$this->onorder_10 = 0;
		$this->onorder_12 = 0;
		$this->onorder_14 = 0;
		$this->onorder_16 = 0;
		$this->onorder_18 = 0;
		$this->onorder_20 = 0;
		$this->onorder_22 = 0;
		$this->onorder_ss = 0;
		$this->onorder_sm = 0;
		$this->onorder_sl = 0;
		$this->onorder_sxl = 0;
		$this->onorder_sxxl = 0;
		$this->onorder_sxl1 = 0;
		$this->onorder_sxl2 = 0;
		$this->onorder_sprepack1221 = 0;
		$this->onorder_ssm = 0;
		$this->onorder_sml = 0;
		$this->onorder_sonesizefitsall = 0;
		// PHYSICAL
		$this->physical_st_id = '';
		$this->physical_0 = 0;
		$this->physical_2 = 0;
		$this->physical_4 = 0;
		$this->physical_6 = 0;
		$this->physical_8 = 0;
		$this->physical_10 = 0;
		$this->physical_12 = 0;
		$this->physical_14 = 0;
		$this->physical_16 = 0;
		$this->physical_18 = 0;
		$this->physical_20 = 0;
		$this->physical_22 = 0;
		$this->physical_ss = 0;
		$this->physical_sm = 0;
		$this->physical_sl = 0;
		$this->physical_sxl = 0;
		$this->physical_sxxl = 0;
		$this->physical_sxl1 = 0;
		$this->physical_sxl2 = 0;
		$this->physical_sprepack1221 = 0;
		$this->physical_ssm = 0;
		$this->physical_sml = 0;
		$this->physical_sonesizefitsall = 0;

		// Variants
		$this->colors = '';

		$this->complete_general = FALSE;
		$this->complete_colors = FALSE;

		return $this;
	}

	// --------------------------------------------------------------------

}
