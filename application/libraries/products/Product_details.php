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
	public $new_color_publish = '';

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
	public $with_stocks = '';
	// PHYSICAL STOCK
	// size mode 0
	public $size_sxs = 0;
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

	// AVAILABLE STOCK
	// size mode 0
	public $available_st_id = '';
	public $available_sxs = 0;
	public $available_ss = 0;
	public $available_sm = 0;
	public $available_sl = 0;
	public $available_sxl = 0;
	public $available_sxxl = 0;
	public $available_sxl1 = 0;
	public $available_sxl2 = 0;
	// size mode 1
	public $available_0 = 0;
	public $available_2 = 0;
	public $available_4 = 0;
	public $available_6 = 0;
	public $available_8 = 0;
	public $available_10 = 0;
	public $available_12 = 0;
	public $available_14 = 0;
	public $available_16 = 0;
	public $available_18 = 0;
	public $available_20 = 0;
	public $available_22 = 0;
	// size mode 2
	public $available_sprepack1221 = 0;
	// size mode 3
	public $available_ssm = 0;
	public $available_sml = 0;
	// size mode 4
	public $available_sonesizefitsall = 0;

	// ONORDER STOCK
	// size mode 0
	public $onorder_st_id = '';
	public $onorder_sxs = 0;
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
	public $physical_sxs = 0;
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

	// ADMIN AVAILABLE STOCK
	// size mode 0
	public $admin_st_id = '';
	public $admin_sxs = 0;
	public $admin_ss = 0;
	public $admin_sm = 0;
	public $admin_sl = 0;
	public $admin_sxl = 0;
	public $admin_sxxl = 0;
	public $admin_sxl1 = 0;
	public $admin_sxl2 = 0;
	// size mode 1
	public $admin_0 = 0;
	public $admin_2 = 0;
	public $admin_4 = 0;
	public $admin_6 = 0;
	public $admin_8 = 0;
	public $admin_10 = 0;
	public $admin_12 = 0;
	public $admin_14 = 0;
	public $admin_16 = 0;
	public $admin_18 = 0;
	public $admin_20 = 0;
	public $admin_22 = 0;
	// size mode 2
	public $admin_sprepack1221 = 0;
	// size mode 3
	public $admin_ssm = 0;
	public $admin_sml = 0;
	// size mode 4
	public $admin_sonesizefitsall = 0;

	// ADMIN ONORDER STOCK
	// size mode 0
	public $admin_onorder_st_id = '';
	public $admin_onorder_sxs = 0;
	public $admin_onorder_ss = 0;
	public $admin_onorder_sm = 0;
	public $admin_onorder_sl = 0;
	public $admin_onorder_sxl = 0;
	public $admin_onorder_sxxl = 0;
	public $admin_onorder_sxl1 = 0;
	public $admin_onorder_sxl2 = 0;
	// size mode 1
	public $admin_onorder_0 = 0;
	public $admin_onorder_2 = 0;
	public $admin_onorder_4 = 0;
	public $admin_onorder_6 = 0;
	public $admin_onorder_8 = 0;
	public $admin_onorder_10 = 0;
	public $admin_onorder_12 = 0;
	public $admin_onorder_14 = 0;
	public $admin_onorder_16 = 0;
	public $admin_onorder_18 = 0;
	public $admin_onorder_20 = 0;
	public $admin_onorder_22 = 0;
	// size mode 2
	public $admin_onorder_sprepack1221 = 0;
	// size mode 3
	public $admin_onorder_ssm = 0;
	public $admin_onorder_sml = 0;
	// size mode 4
	public $admin_onorder_sonesizefitsall = 0;

	// ADMIN PHYSICAL STOCK
	// size mode 0
	public $admin_physical_st_id = '';
	public $admin_physical_sxs = 0;
	public $admin_physical_ss = 0;
	public $admin_physical_sm = 0;
	public $admin_physical_sl = 0;
	public $admin_physical_sxl = 0;
	public $admin_physical_sxxl = 0;
	public $admin_physical_sxl1 = 0;
	public $admin_physical_sxl2 = 0;
	// size mode 1
	public $admin_physical_0 = 0;
	public $admin_physical_2 = 0;
	public $admin_physical_4 = 0;
	public $admin_physical_6 = 0;
	public $admin_physical_8 = 0;
	public $admin_physical_10 = 0;
	public $admin_physical_12 = 0;
	public $admin_physical_14 = 0;
	public $admin_physical_16 = 0;
	public $admin_physical_18 = 0;
	public $admin_physical_20 = 0;
	public $admin_physical_22 = 0;
	// size mode 2
	public $admin_physical_sprepack1221 = 0;
	// size mode 3
	public $admin_physical_ssm = 0;
	public $admin_physical_sml = 0;
	// size mode 4
	public $admin_physical_sonesizefitsall = 0;

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
		$this->DB->select(
			'tbl_stock.st_id, tbl_stock.custom_order, tbl_stock.image_url_path,
			tbl_stock.options as stocks_options, tbl_stock.new_color_publish'
		);
		$this->DB->select('media_path, media_name, upload_version');
		$this->DB->select('
			tbl_stock.size_sxs, tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall
		');
		$this->DB->select('
			tsav.st_id AS available_st_id,
			tsav.size_sxs AS available_sxs, tsav.size_ss AS available_ss, tsav.size_sm AS available_sm,
			tsav.size_sl AS available_sl, tsav.size_sxl AS available_sxl,
			tsav.size_sxxl AS available_sxxl, tsav.size_sxl1 AS available_sxl1,
			tsav.size_sxl2 AS available_sxl2,
			tsav.size_0 AS available_0, tsav.size_2 AS available_2,
			tsav.size_4 AS available_4, tsav.size_6 AS available_6,
			tsav.size_8 AS available_8, tsav.size_10 AS available_10,
			tsav.size_12 AS available_12, tsav.size_14 AS available_14,
			tsav.size_16 AS available_16, tsav.size_18 AS available_18,
			tsav.size_20 AS available_20, tsav.size_22 AS available_22,
			tsav.size_sprepack1221 AS available_sprepack1221,
			tsav.size_ssm AS available_ssm, tsav.size_sml AS available_sml,
			tsav.size_sonesizefitsall AS available_sonesizefitsall
		');
		$this->DB->select('
			tso.st_id AS onorder_st_id,
			tso.size_sxs AS onorder_sxs, tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
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
		/*
		$this->DB->select('
			tsp.st_id AS physical_st_id,
			tsp.size_sxs AS physical_sxs, tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
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
		*/
		$this->DB->select('
			tsa.st_id AS admin_st_id,
			tsa.size_sxs AS admin_sxs, tsa.size_ss AS admin_ss, tsa.size_sm AS admin_sm,
			tsa.size_sl AS admin_sl, tsa.size_sxl AS admin_sxl,
			tsa.size_sxxl AS admin_sxxl, tsa.size_sxl1 AS admin_sxl1,
			tsa.size_sxl2 AS admin_sxl2,
			tsa.size_0 AS admin_0, tsa.size_2 AS admin_2,
			tsa.size_4 AS admin_4, tsa.size_6 AS admin_6,
			tsa.size_8 AS admin_8, tsa.size_10 AS admin_10,
			tsa.size_12 AS admin_12, tsa.size_14 AS admin_14,
			tsa.size_16 AS admin_16, tsa.size_18 AS admin_18,
			tsa.size_20 AS admin_20, tsa.size_22 AS admin_22,
			tsa.size_sprepack1221 AS admin_sprepack1221,
			tsa.size_ssm AS admin_ssm, tsa.size_sml AS admin_sml,
			tsa.size_sonesizefitsall AS admin_sonesizefitsall
		');
		$this->DB->select('
			tsao.st_id AS admin_onorder_st_id,
			tsao.size_sxs AS admin_onorder_sxs, tsao.size_ss AS admin_onorder_ss, tsao.size_sm AS admin_onorder_sm,
			tsao.size_sl AS admin_onorder_sl, tsao.size_sxl AS admin_onorder_sxl,
			tsao.size_sxxl AS admin_onorder_sxxl, tsao.size_sxl1 AS admin_onorder_sxl1,
			tsao.size_sxl2 AS admin_onorder_sxl2,
			tsao.size_0 AS admin_onorder_0, tsao.size_2 AS admin_onorder_2,
			tsao.size_4 AS admin_onorder_4, tsao.size_6 AS admin_onorder_6,
			tsao.size_8 AS admin_onorder_8, tsao.size_10 AS admin_onorder_10,
			tsao.size_12 AS admin_onorder_12, tsao.size_14 AS admin_onorder_14,
			tsao.size_16 AS admin_onorder_16, tsao.size_18 AS admin_onorder_18,
			tsao.size_20 AS admin_onorder_20, tsao.size_22 AS admin_onorder_22,
			tsao.size_sprepack1221 AS admin_onorder_sprepack1221,
			tsao.size_ssm AS admin_onorder_ssm, tsao.size_sml AS admin_onorder_sml,
			tsao.size_sonesizefitsall AS admin_onorder_sonesizefitsall
		');
		$this->DB->select('
			tsap.st_id AS admin_physical_st_id,
			tsap.size_sxs AS admin_physical_sxs, tsap.size_ss AS admin_physical_ss, tsap.size_sm AS admin_physical_sm,
			tsap.size_sl AS admin_physical_sl, tsap.size_sxl AS admin_physical_sxl,
			tsap.size_sxxl AS admin_physical_sxxl, tsap.size_sxl1 AS admin_physical_sxl1,
			tsap.size_sxl2 AS admin_physical_sxl2,
			tsap.size_0 AS admin_physical_0, tsap.size_2 AS admin_physical_2,
			tsap.size_4 AS admin_physical_4, tsap.size_6 AS admin_physical_6,
			tsap.size_8 AS admin_physical_8, tsap.size_10 AS admin_physical_10,
			tsap.size_12 AS admin_physical_12, tsap.size_14 AS admin_physical_14,
			tsap.size_16 AS admin_physical_16, tsap.size_18 AS admin_physical_18,
			tsap.size_20 AS admin_physical_20, tsap.size_22 AS admin_physical_22,
			tsap.size_sprepack1221 AS admin_physical_sprepack1221,
			tsap.size_ssm AS admin_physical_ssm, tsap.size_sml AS admin_physical_sml,
			tsap.size_sonesizefitsall AS admin_physical_sonesizefitsall
		');
		// with_stocks alias
		$this->DB->select("
			(CASE
				WHEN tbl_product.size_mode =  '0'
				THEN (CASE
						WHEN
							tsav.size_sxs != '0'
							OR tsav.size_ss != '0'
							OR tsav.size_sm != '0'
							OR tsav.size_sl != '0'
							OR tsav.size_sxl != '0'
							OR tsav.size_sxxl != '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '1'
				THEN (CASE
						WHEN
							tsav.size_0 > '0'
							OR tsav.size_2 > '0'
							OR tsav.size_4 > '0'
							OR tsav.size_6 > '0'
							OR tsav.size_8 > '0'
							OR tsav.size_10 > '0'
							OR tsav.size_12 > '0'
							OR tsav.size_14 > '0'
							OR tsav.size_16 > '0'
							OR tsav.size_18 > '0'
							OR tsav.size_20 > '0'
							OR tsav.size_22 > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '2'
				THEN (CASE
						WHEN
							tsav.size_sprepack1221 > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '3'
				THEN (CASE
						WHEN
							tsav.size_ssm > '0'
							OR tsav.size_sml > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '4'
				THEN (CASE
						WHEN
							tsav.size_sonesizefitsall > '0'
						THEN '1'
						ELSE '0'
					END)
				ELSE '0'
			END) AS with_stocks
		");
		$this->DB->select("
			(CASE
				WHEN tbl_product.size_mode =  '0'
				THEN (CASE
						WHEN
							tsap.size_sxs != '0'
							OR tsap.size_ss != '0'
							OR tsap.size_sm != '0'
							OR tsap.size_sl != '0'
							OR tsap.size_sxl != '0'
							OR tsap.size_sxxl != '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '1'
				THEN (CASE
						WHEN
							tsap.size_0 > '0'
							OR tsap.size_2 > '0'
							OR tsap.size_4 > '0'
							OR tsap.size_6 > '0'
							OR tsap.size_8 > '0'
							OR tsap.size_10 > '0'
							OR tsap.size_12 > '0'
							OR tsap.size_14 > '0'
							OR tsap.size_16 > '0'
							OR tsap.size_18 > '0'
							OR tsap.size_20 > '0'
							OR tsap.size_22 > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '2'
				THEN (CASE
						WHEN
							tsap.size_sprepack1221 > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '3'
				THEN (CASE
						WHEN
							tsap.size_ssm > '0'
							OR tsap.size_sml > '0'
						THEN '1'
						ELSE '0'
					END)
				WHEN tbl_product.size_mode =  '4'
				THEN (CASE
						WHEN
							tsap.size_sonesizefitsall > '0'
						THEN '1'
						ELSE '0'
					END)
				ELSE '0'
			END) AS with_admin_stocks
		");
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
		$this->DB->join('tbl_stock_available tsav', 'tsav.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		//$this->DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin tsa', 'tsa.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_onorder tsao', 'tsao.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_physical tsap', 'tsap.st_id = tbl_stock.st_id', 'left');
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
			$this->new_color_publish = $row->new_color_publish;

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

			$this->with_stocks = $row->with_stocks;

			// color variant data if such
			// PHYSICAL SIZES
			$this->size_sxs = $row->size_sxs;
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

			// AVAILABLE SIZES
			$this->available_st_id = $row->available_st_id;
			$this->available_sxs = $row->available_sxs;
			$this->available_ss = $row->available_ss;
			$this->available_sm = $row->available_sm;
			$this->available_sl = $row->available_sl;
			$this->available_sxl = $row->available_sxl;
			$this->available_sxxl = $row->available_sxxl;
			$this->available_sxl1 = $row->available_sxl1;
			$this->available_sxl2 = $row->available_sxl2;
			$this->available_0 = $row->available_0;
			$this->available_2 = $row->available_2;
			$this->available_4 = $row->available_4;
			$this->available_6 = $row->available_6;
			$this->available_8 = $row->available_8;
			$this->available_10 = $row->available_10;
			$this->available_12 = $row->available_12;
			$this->available_14 = $row->available_14;
			$this->available_16 = $row->available_16;
			$this->available_18 = $row->available_18;
			$this->available_20 = $row->available_20;
			$this->available_22 = $row->available_22;
			$this->available_sprepack1221 = $row->available_sprepack1221;
			$this->available_ssm = $row->available_ssm;
			$this->available_sml = $row->available_sml;
			$this->available_sonesizefitsall = $row->available_sonesizefitsall;

			// ONORDER SIZES
			$this->onorder_st_id = $row->onorder_st_id;
			$this->onorder_sxs = $row->onorder_sxs;
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
			/*
			$this->physical_st_id = $row->physical_st_id;
			$this->physical_sxs = $row->physical_sxs;
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
			*/

			// ADMIN AVAILABLE SIZES
			$this->admin_st_id = $row->admin_st_id;
			$this->admin_sxs = $row->admin_sxs;
			$this->admin_ss = $row->admin_ss;
			$this->admin_sm = $row->admin_sm;
			$this->admin_sl = $row->admin_sl;
			$this->admin_sxl = $row->admin_sxl;
			$this->admin_sxxl = $row->admin_sxxl;
			$this->admin_sxl1 = $row->admin_sxl1;
			$this->admin_sxl2 = $row->admin_sxl2;
			$this->admin_0 = $row->admin_0;
			$this->admin_2 = $row->admin_2;
			$this->admin_4 = $row->admin_4;
			$this->admin_6 = $row->admin_6;
			$this->admin_8 = $row->admin_8;
			$this->admin_10 = $row->admin_10;
			$this->admin_12 = $row->admin_12;
			$this->admin_14 = $row->admin_14;
			$this->admin_16 = $row->admin_16;
			$this->admin_18 = $row->admin_18;
			$this->admin_20 = $row->admin_20;
			$this->admin_22 = $row->admin_22;
			$this->admin_sprepack1221 = $row->admin_sprepack1221;
			$this->admin_ssm = $row->admin_ssm;
			$this->admin_sml = $row->admin_sml;
			$this->admin_sonesizefitsall = $row->admin_sonesizefitsall;

			// ADMIN ONORDER SIZES
			$this->admin_onorder_st_id = $row->admin_onorder_st_id;
			$this->admin_onorder_sxs = $row->admin_onorder_sxs;
			$this->admin_onorder_ss = $row->admin_onorder_ss;
			$this->admin_onorder_sm = $row->admin_onorder_sm;
			$this->admin_onorder_sl = $row->admin_onorder_sl;
			$this->admin_onorder_sxl = $row->admin_onorder_sxl;
			$this->admin_onorder_sxxl = $row->admin_onorder_sxxl;
			$this->admin_onorder_sxl1 = $row->admin_onorder_sxl1;
			$this->admin_onorder_sxl2 = $row->admin_onorder_sxl2;
			$this->admin_onorder_0 = $row->admin_onorder_0;
			$this->admin_onorder_2 = $row->admin_onorder_2;
			$this->admin_onorder_4 = $row->admin_onorder_4;
			$this->admin_onorder_6 = $row->admin_onorder_6;
			$this->admin_onorder_8 = $row->admin_onorder_8;
			$this->admin_onorder_10 = $row->admin_onorder_10;
			$this->admin_onorder_12 = $row->admin_onorder_12;
			$this->admin_onorder_14 = $row->admin_onorder_14;
			$this->admin_onorder_16 = $row->admin_onorder_16;
			$this->admin_onorder_18 = $row->admin_onorder_18;
			$this->admin_onorder_20 = $row->admin_onorder_20;
			$this->admin_onorder_22 = $row->admin_onorder_22;
			$this->admin_onorder_sprepack1221 = $row->admin_onorder_sprepack1221;
			$this->admin_onorder_ssm = $row->admin_onorder_ssm;
			$this->admin_onorder_sml = $row->admin_onorder_sml;
			$this->admin_onorder_sonesizefitsall = $row->admin_onorder_sonesizefitsall;

			// ADMIN PHYSICAL SIZES
			$this->admin_physical_st_id = $row->admin_physical_st_id;
			$this->admin_physical_sxs = $row->admin_physical_sxs;
			$this->admin_physical_ss = $row->admin_physical_ss;
			$this->admin_physical_sm = $row->admin_physical_sm;
			$this->admin_physical_sl = $row->admin_physical_sl;
			$this->admin_physical_sxl = $row->admin_physical_sxl;
			$this->admin_physical_sxxl = $row->admin_physical_sxxl;
			$this->admin_physical_sxl1 = $row->admin_physical_sxl1;
			$this->admin_physical_sxl2 = $row->admin_physical_sxl2;
			$this->admin_physical_0 = $row->admin_physical_0;
			$this->admin_physical_2 = $row->admin_physical_2;
			$this->admin_physical_4 = $row->admin_physical_4;
			$this->admin_physical_6 = $row->admin_physical_6;
			$this->admin_physical_8 = $row->admin_physical_8;
			$this->admin_physical_10 = $row->admin_physical_10;
			$this->admin_physical_12 = $row->admin_physical_12;
			$this->admin_physical_14 = $row->admin_physical_14;
			$this->admin_physical_16 = $row->admin_physical_16;
			$this->admin_physical_18 = $row->admin_physical_18;
			$this->admin_physical_20 = $row->admin_physical_20;
			$this->admin_physical_22 = $row->admin_physical_22;
			$this->admin_physical_sprepack1221 = $row->admin_physical_sprepack1221;
			$this->admin_physical_ssm = $row->admin_physical_ssm;
			$this->admin_physical_sml = $row->admin_physical_sml;
			$this->admin_physical_sonesizefitsall = $row->admin_physical_sonesizefitsall;

			// Facets
			$this->style_facets = explode('-', $row->styles);
			$this->event_facets = explode('-', $row->events);
			$this->trend_facets = explode('-', $row->trends);
			$this->material_facets = explode('-', $row->materials);
			$this->color_facets = explode('-', $row->colors);
			$this->season_facets = explode('-', $row->seasons);

			// Variants
			$this->colors = $row->colors;

			// the main product options
			$this->options =
				($row->options && $row->options != '')
				? json_decode($row->options , TRUE)
				: array()
			; // tbl_stock options
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
		// designer stocks
		if ($this->size_mode == '0')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsav.size_sxs != "0"
						OR tsav.size_ss != "0"
						OR tsav.size_sm != "0"
						OR tsav.size_sl != "0"
						OR tsav.size_sxl != "0"
						OR tsav.size_sxxl != "0"
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
						tsav.size_0 != "0"
						OR tsav.size_2 != "0"
						OR tsav.size_4 != "0"
						OR tsav.size_6 != "0"
						OR tsav.size_8 != "0"
						OR tsav.size_10 != "0"
						OR tsav.size_12 != "0"
						OR tsav.size_14 != "0"
						OR tsav.size_16 != "0"
						OR tsav.size_18 != "0"
						OR tsav.size_20 != "0"
						OR tsav.size_22 != "0"
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
						tsav.size_sprepack1221 != "0"
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
						tsav.size_ssm != "0"
						OR tsav.size_sml != "0"
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
						tsav.size_sonesizefitsall != "0"
					THEN "1"
					ELSE "0"
				END) AS with_stocks
			');
		}
		// admin stocks
		if ($this->size_mode == '0')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsap.size_sxs != "0"
						OR tsap.size_ss != "0"
						OR tsap.size_sm != "0"
						OR tsap.size_sl != "0"
						OR tsap.size_sxl != "0"
						OR tsap.size_sxxl != "0"
					THEN "1"
					ELSE "0"
				END) AS with_admin_stocks
			');
		}
		elseif ($this->size_mode == '1')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsap.size_0 != "0"
						OR tsap.size_2 != "0"
						OR tsap.size_4 != "0"
						OR tsap.size_6 != "0"
						OR tsap.size_8 != "0"
						OR tsap.size_10 != "0"
						OR tsap.size_12 != "0"
						OR tsap.size_14 != "0"
						OR tsap.size_16 != "0"
						OR tsap.size_18 != "0"
						OR tsap.size_20 != "0"
						OR tsap.size_22 != "0"
					THEN "1"
					ELSE "0"
				END) AS with_admin_stocks
			');
		}
		elseif ($this->size_mode == '2')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsap.size_sprepack1221 != "0"
					THEN "1"
					ELSE "0"
				END) AS with_admin_stocks
			');
		}
		elseif ($this->size_mode == '3')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsap.size_ssm != "0"
						OR tsap.size_sml != "0"
					THEN "1"
					ELSE "0"
				END) AS with_admin_stocks
			');
		}
		elseif ($this->size_mode == '4')
		{
			$this->DB->select('
				(CASE
					WHEN
						tsap.size_sonesizefitsall != "0"
					THEN "1"
					ELSE "0"
				END) AS with_admin_stocks
			');
		}
		$this->DB->select('
			tsav.st_id AS available_st_id,
			tsav.size_sxs AS available_sxs, tsav.size_ss AS available_ss, tsav.size_sm AS available_sm,
			tsav.size_sl AS available_sl, tsav.size_sxl AS available_sxl,
			tsav.size_sxxl AS available_sxxl, tsav.size_sxl1 AS available_sxl1,
			tsav.size_sxl2 AS available_sxl2,
			tsav.size_0 AS available_0, tsav.size_2 AS available_2,
			tsav.size_4 AS available_4, tsav.size_6 AS available_6,
			tsav.size_8 AS available_8, tsav.size_10 AS available_10,
			tsav.size_12 AS available_12, tsav.size_14 AS available_14,
			tsav.size_16 AS available_16, tsav.size_18 AS available_18,
			tsav.size_20 AS available_20, tsav.size_22 AS available_22,
			tsav.size_sprepack1221 AS available_sprepack1221,
			tsav.size_ssm AS available_ssm, tsav.size_sml AS available_sml,
			tsav.size_sonesizefitsall AS available_sonesizefitsall
		');
		$this->DB->select('
			tso.st_id AS onorder_st_id,
			tso.size_sxs AS onorder_sxs, tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
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
			tsp.size_sxs AS physical_sxs, tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
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
			tsa.st_id AS admin_st_id,
			tsa.size_sxs AS admin_sxs, tsa.size_ss AS admin_ss, tsa.size_sm AS admin_sm,
			tsa.size_sl AS admin_sl, tsa.size_sxl AS admin_sxl,
			tsa.size_sxxl AS admin_sxxl, tsa.size_sxl1 AS admin_sxl1,
			tsa.size_sxl2 AS admin_sxl2,
			tsa.size_0 AS admin_0, tsa.size_2 AS admin_2,
			tsa.size_4 AS admin_4, tsa.size_6 AS admin_6,
			tsa.size_8 AS admin_8, tsa.size_10 AS admin_10,
			tsa.size_12 AS admin_12, tsa.size_14 AS admin_14,
			tsa.size_16 AS admin_16, tsa.size_18 AS admin_18,
			tsa.size_20 AS admin_20, tsa.size_22 AS admin_22,
			tsa.size_sprepack1221 AS admin_sprepack1221,
			tsa.size_ssm AS admin_ssm, tsa.size_sml AS admin_sml,
			tsa.size_sonesizefitsall AS admin_sonesizefitsall
		');
		$this->DB->select('
			tsao.st_id AS admin_onorder_st_id,
			tsao.size_sxs AS admin_onorder_sxs, tsao.size_ss AS admin_onorder_ss, tsao.size_sm AS admin_onorder_sm,
			tsao.size_sl AS admin_onorder_sl, tsao.size_sxl AS admin_onorder_sxl,
			tsao.size_sxxl AS admin_onorder_sxxl, tsao.size_sxl1 AS admin_onorder_sxl1,
			tsao.size_sxl2 AS admin_onorder_sxl2,
			tsao.size_0 AS admin_onorder_0, tsao.size_2 AS admin_onorder_2,
			tsao.size_4 AS admin_onorder_4, tsao.size_6 AS admin_onorder_6,
			tsao.size_8 AS admin_onorder_8, tsao.size_10 AS admin_onorder_10,
			tsao.size_12 AS admin_onorder_12, tsao.size_14 AS admin_onorder_14,
			tsao.size_16 AS admin_onorder_16, tsao.size_18 AS admin_onorder_18,
			tsao.size_20 AS admin_onorder_20, tsao.size_22 AS admin_onorder_22,
			tsao.size_sprepack1221 AS admin_onorder_sprepack1221,
			tsao.size_ssm AS admin_onorder_ssm, tsao.size_sml AS admin_onorder_sml,
			tsao.size_sonesizefitsall AS admin_onorder_sonesizefitsall
		');
		$this->DB->select('
			tsap.size_sxs AS admin_physical_sxs, tsap.size_ss AS admin_physical_ss, tsap.size_sm AS admin_physical_sm,
			tsap.size_sl AS admin_physical_sl, tsap.size_sxl AS admin_physical_sxl,
			tsap.size_sxxl AS admin_physical_sxxl, tsap.size_sxl1 AS admin_physical_sxl1,
			tsap.size_sxl2 AS admin_physical_sxl2,
			tsap.size_0 AS admin_physical_0, tsap.size_2 AS admin_physical_2,
			tsap.size_4 AS admin_physical_4, tsap.size_6 AS admin_physical_6,
			tsap.size_8 AS admin_physical_8, tsap.size_10 AS admin_physical_10,
			tsap.size_12 AS admin_physical_12, tsap.size_14 AS admin_physical_14,
			tsap.size_16 AS admin_physical_16, tsap.size_18 AS admin_physical_18,
			tsap.size_20 AS admin_physical_20, tsap.size_22 AS admin_physical_22,
			tsap.size_sprepack1221 AS admin_physical_sprepack1221,
			tsap.size_ssm AS admin_physical_ssm, tsap.size_sml AS admin_physical_sml,
			tsap.size_sonesizefitsall AS admin_physical_sonesizefitsall
		');
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
		$this->DB->join('tbl_stock_available tsav', 'tsav.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin tsa', 'tsa.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_onorder tsao', 'tsao.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_physical tsap', 'tsap.st_id = tbl_stock.st_id', 'left');
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
			tbl_stock.size_sxs, tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall
		');
		$this->DB->select('
			tsav.size_sxs AS available_sxs, tsav.size_ss AS available_ss, tsav.size_sm AS available_sm,
			tsav.size_sl AS available_sl, tsav.size_sxl AS available_sxl,
			tsav.size_sxxl AS available_sxxl, tsav.size_sxl1 AS available_sxl1,
			tsav.size_sxl2 AS available_sxl2,
			tsav.size_0 AS available_0, tsav.size_2 AS available_2,
			tsav.size_4 AS available_4, tsav.size_6 AS available_6,
			tsav.size_8 AS available_8, tsav.size_10 AS available_10,
			tsav.size_12 AS available_12, tsav.size_14 AS available_14,
			tsav.size_16 AS available_16, tsav.size_18 AS available_18,
			tsav.size_20 AS available_20, tsav.size_22 AS available_22,
			tsav.size_sprepack1221 AS available_sprepack1221,
			tsav.size_ssm AS available_ssm, tsav.size_sml AS available_sml,
			tsav.size_sonesizefitsall AS available_sonesizefitsall
		');
		$this->DB->select('
			tso.size_sxs AS onorder_sxs, tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
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
			tsp.size_sxs AS physical_sxs, tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
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
			tsa.size_sxs AS admin_sxs, tsa.size_ss AS admin_ss, tsa.size_sm AS admin_sm,
			tsa.size_sl AS admin_sl, tsa.size_sxl AS admin_sxl,
			tsa.size_sxxl AS admin_sxxl, tsa.size_sxl1 AS admin_sxl1,
			tsa.size_sxl2 AS admin_sxl2,
			tsa.size_0 AS admin_0, tsa.size_2 AS admin_2,
			tsa.size_4 AS admin_4, tsa.size_6 AS admin_6,
			tsa.size_8 AS admin_8, tsa.size_10 AS admin_10,
			tsa.size_12 AS admin_12, tsa.size_14 AS admin_14,
			tsa.size_16 AS admin_16, tsa.size_18 AS admin_18,
			tsa.size_20 AS admin_20, tsa.size_22 AS admin_22,
			tsa.size_sprepack1221 AS admin_sprepack1221,
			tsa.size_ssm AS admin_ssm, tsa.size_sml AS admin_sml,
			tsa.size_sonesizefitsall AS admin_sonesizefitsall
		');
		$this->DB->select('
			tsao.size_sxs AS admin_onorder_sxs, tsao.size_ss AS admin_onorder_ss, tsao.size_sm AS admin_onorder_sm,
			tsao.size_sl AS admin_onorder_sl, tsao.size_sxl AS admin_onorder_sxl,
			tsao.size_sxxl AS admin_onorder_sxxl, tsao.size_sxl1 AS admin_onorder_sxl1,
			tsao.size_sxl2 AS admin_onorder_sxl2,
			tsao.size_0 AS admin_onorder_0, tsao.size_2 AS admin_onorder_2,
			tsao.size_4 AS admin_onorder_4, tsao.size_6 AS admin_onorder_6,
			tsao.size_8 AS admin_onorder_8, tsao.size_10 AS admin_onorder_10,
			tsao.size_12 AS admin_onorder_12, tsao.size_14 AS admin_onorder_14,
			tsao.size_16 AS admin_onorder_16, tsao.size_18 AS admin_onorder_18,
			tsao.size_20 AS admin_onorder_20, tsao.size_22 AS admin_onorder_22,
			tsao.size_sprepack1221 AS admin_onorder_sprepack1221,
			tsao.size_ssm AS admin_onorder_ssm, tsao.size_sml AS admin_onorder_sml,
			tsao.size_sonesizefitsall AS admin_onorder_sonesizefitsall
		');
		$this->DB->select('
			tsap.size_sxs AS admin_physical_sxs, tsap.size_ss AS admin_physical_ss, tsap.size_sm AS admin_physical_sm,
			tsap.size_sl AS admin_physical_sl, tsap.size_sxl AS admin_physical_sxl,
			tsap.size_sxxl AS admin_physical_sxxl, tsap.size_sxl1 AS admin_physical_sxl1,
			tsap.size_sxl2 AS admin_physical_sxl2,
			tsap.size_0 AS admin_physical_0, tsap.size_2 AS admin_physical_2,
			tsap.size_4 AS admin_physical_4, tsap.size_6 AS admin_physical_6,
			tsap.size_8 AS admin_physical_8, tsap.size_10 AS admin_physical_10,
			tsap.size_12 AS admin_physical_12, tsap.size_14 AS admin_physical_14,
			tsap.size_16 AS admin_physical_16, tsap.size_18 AS admin_physical_18,
			tsap.size_20 AS admin_physical_20, tsap.size_22 AS admin_physical_22,
			tsap.size_sprepack1221 AS admin_physical_sprepack1221,
			tsap.size_ssm AS admin_physical_ssm, tsap.size_sml AS admin_physical_sml,
			tsap.size_sonesizefitsall AS admin_physical_sonesizefitsall
		');
		$this->DB->from('tbl_stock');
		$this->DB->join('tbl_stock_available tsav', 'tsav.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin tsa', 'tsa.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_onorder tsao', 'tsao.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_physical tsap', 'tsap.st_id = tbl_stock.st_id', 'left');
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
					if ($row->available_sxs > '0') $size_array['available_sxs'] = $this->available_sxs;
					if ($row->available_ss > '0') $size_array['available_ss'] = $this->available_ss;
					if ($row->available_sm > '0') $size_array['available_sm'] = $this->available_sm;
					if ($row->available_sl > '0') $size_array['available_sl'] = $this->available_sl;
					if ($row->available_sxl > '0') $size_array['available_sxl'] = $this->available_sxl;
					if ($row->available_sxxl > '0') $size_array['available_sxxl'] = $this->available_sxxl;
					if ($row->available_sxl1 > '0') $size_array['available_sxl1'] = $this->available_sxl1;
					if ($row->available_sxl2 > '0') $size_array['available_sxl2'] = $this->available_sxl2;
				}
				if ($this->size_mode == '1')
				{
					if ($row->available_0 > '0') $size_array['available_0'] = $this->available_0;
					if ($row->available_2 > '0') $size_array['available_2'] = $this->available_2;
					if ($row->available_4 > '0') $size_array['available_4'] = $this->available_4;
					if ($row->available_6 > '0') $size_array['available_6'] = $this->available_6;
					if ($row->available_8 > '0') $size_array['available_8'] = $this->available_8;
					if ($row->available_10 > '0') $size_array['available_10'] = $this->available_10;
					if ($row->available_12 > '0') $size_array['available_12'] = $this->available_12;
					if ($row->available_14 > '0') $size_array['available_14'] = $this->available_14;
					if ($row->available_16 > '0') $size_array['available_16'] = $this->available_16;
					if ($row->available_18 > '0') $size_array['available_18'] = $this->available_18;
					if ($row->available_20 > '0') $size_array['available_20'] = $this->available_20;
					if ($row->available_22 > '0') $size_array['available_22'] = $this->size_22;
				}
				if ($this->size_mode == '2')
				{
					if ($row->available_sprepack1221 > '0') $size_array['available_sprepack1221'] = $this->available_sprepack1221;
				}
				if ($this->size_mode == '3')
				{
					if ($row->available_ssm > '0') $size_array['available_ssm'] = $this->available_ssm;
					if ($row->available_sml > '0') $size_array['available_sml'] = $this->available_sml;
				}
				if ($this->size_mode == '4')
				{
					if ($row->available_sonesizefitsall > '0') $size_array['available_sonesizefitsall'] = $this->available_sonesizefitsall;
				}
			}
			else if ($param == 'onorder')
			{
				// size in array
				if ($this->size_mode == '0')
				{
					if ($row->onorder_sxs > '0') $size_array['onorder_sxs'] = $this->onorder_sxs;
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
					if ($row->physical_sxs > '0') $size_array['physical_sxs'] = $this->physical_sxs;
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
		// PHYSICAL
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
		$this->size_sxs = 0;
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
		// AVAILABLE
		$this->available_st_id = '';
		$this->available_0 = 0;
		$this->available_2 = 0;
		$this->available_4 = 0;
		$this->available_6 = 0;
		$this->available_8 = 0;
		$this->available_10 = 0;
		$this->available_12 = 0;
		$this->available_14 = 0;
		$this->available_16 = 0;
		$this->available_18 = 0;
		$this->available_20 = 0;
		$this->available_22 = 0;
		$this->available_sxs = 0;
		$this->available_ss = 0;
		$this->available_sm = 0;
		$this->available_sl = 0;
		$this->available_sxl = 0;
		$this->available_sxxl = 0;
		$this->available_sxl1 = 0;
		$this->available_sxl2 = 0;
		$this->available_sprepack1221 = 0;
		$this->available_ssm = 0;
		$this->available_sml = 0;
		$this->available_sonesizefitsall = 0;
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
		$this->onorder_sxs = 0;
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
		$this->physical_sxs = 0;
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

		// ADMIN AVAILABLE
		$this->admin_st_id = '';
		$this->admin_0 = 0;
		$this->admin_2 = 0;
		$this->admin_4 = 0;
		$this->admin_6 = 0;
		$this->admin_8 = 0;
		$this->admin_10 = 0;
		$this->admin_12 = 0;
		$this->admin_14 = 0;
		$this->admin_16 = 0;
		$this->admin_18 = 0;
		$this->admin_20 = 0;
		$this->admin_22 = 0;
		$this->admin_sxs = 0;
		$this->admin_ss = 0;
		$this->admin_sm = 0;
		$this->admin_sl = 0;
		$this->admin_sxl = 0;
		$this->admin_sxxl = 0;
		$this->admin_sxl1 = 0;
		$this->admin_sxl2 = 0;
		$this->admin_sprepack1221 = 0;
		$this->admin_ssm = 0;
		$this->admin_sml = 0;
		$this->admin_sonesizefitsall = 0;
		// ADMIN ONORDER
		$this->admin_onorder_st_id = '';
		$this->admin_onorder_0 = 0;
		$this->admin_onorder_2 = 0;
		$this->admin_onorder_4 = 0;
		$this->admin_onorder_6 = 0;
		$this->admin_onorder_8 = 0;
		$this->admin_onorder_10 = 0;
		$this->admin_onorder_12 = 0;
		$this->admin_onorder_14 = 0;
		$this->admin_onorder_16 = 0;
		$this->admin_onorder_18 = 0;
		$this->admin_onorder_20 = 0;
		$this->admin_onorder_22 = 0;
		$this->admin_onorder_sxs = 0;
		$this->admin_onorder_ss = 0;
		$this->admin_onorder_sm = 0;
		$this->admin_onorder_sl = 0;
		$this->admin_onorder_sxl = 0;
		$this->admin_onorder_sxxl = 0;
		$this->admin_onorder_sxl1 = 0;
		$this->admin_onorder_sxl2 = 0;
		$this->admin_onorder_sprepack1221 = 0;
		$this->admin_onorder_ssm = 0;
		$this->admin_onorder_sml = 0;
		$this->admin_onorder_sonesizefitsall = 0;
		// ADMIN PHYSICAL
		$this->admin_physical_st_id = '';
		$this->admin_physical_0 = 0;
		$this->admin_physical_2 = 0;
		$this->admin_physical_4 = 0;
		$this->admin_physical_6 = 0;
		$this->admin_physical_8 = 0;
		$this->admin_physical_10 = 0;
		$this->admin_physical_12 = 0;
		$this->admin_physical_14 = 0;
		$this->admin_physical_16 = 0;
		$this->admin_physical_18 = 0;
		$this->admin_physical_20 = 0;
		$this->admin_physical_22 = 0;
		$this->admin_physical_sxs = 0;
		$this->admin_physical_ss = 0;
		$this->admin_physical_sm = 0;
		$this->admin_physical_sl = 0;
		$this->admin_physical_sxl = 0;
		$this->admin_physical_sxxl = 0;
		$this->admin_physical_sxl1 = 0;
		$this->admin_physical_sxl2 = 0;
		$this->admin_physical_sprepack1221 = 0;
		$this->admin_physical_ssm = 0;
		$this->admin_physical_sml = 0;
		$this->admin_physical_sonesizefitsall = 0;

		// Variants
		$this->colors = '';

		$this->complete_general = FALSE;
		$this->complete_colors = FALSE;

		return $this;
	}

	// --------------------------------------------------------------------

}
