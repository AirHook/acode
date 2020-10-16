<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Inventory Details
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Product, Inventory, Stocks
 * @author		WebGuy
 * @link
 */
class Product_inventory_details
{
	/**
	 * Stock ID
	 *
	 * The only parameter needed to initialize this class
	 *
	 * @var	string
	 */
	public $st_id = '';
	public $prod_no = '';
	public $color_name = '';

	/**
	 * Sizes for when product details has color as params or st_id
	 * As long as a specific variant is queried
	 *
	 * @var	int
	 */
	public $stock_id = '';
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

	// SPECIAL ADMIN STOCK
	// size mode 0
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

	// SPECIAL ADMIN ONORDER STOCK
	// size mode 0
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

	// SPECIAL ADMIN PHYSICAL STOCK
	// size mode 0
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
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($params);
		log_message('info', 'Product Inventory Details Class Initialized');
    }

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @return	object
	 */
	public function initialize(array $params)
	{
		// set properties where necessary
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = trim($val);
				}
			}
		}

		// get all stocks information
		$this->DB->select('tbl_stock.st_id as stock_id');
		$this->DB->select('
			tbl_stock.size_sxs, tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall,
			tbl_stock.options,
			tbl_stock.prod_no,
			tblcolor.color_code
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
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		if ($this->st_id) $this->DB->where('tbl_stock.st_id', $this->st_id);
		if ($this->prod_no) $this->DB->where('tbl_stock.prod_no', $this->prod_no);
		if ($this->color_name) $this->DB->where('tbl_stock.color_name', $this->color_name);
		$get = $this->DB->get();

		//echo $this->DB->last_query(); die();

		// save last query string (with out the LIMIT portion)
		$this->last_query = $this->DB->last_query();

		// get row
		$row = $get->row();

		if (isset($row))
		{
			$this->stock_id = $row->stock_id;
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

			// ADMIN AVAILABLE SIZES
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

			// ADMIN PHYSCIAL SIZES
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

			// the options
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();
			$this->stocks_options = $this->options;

			$this->prod_no = $row->prod_no;
			$this->color_code = $row->color_code;

			return $this;
		}
		else
		{
			// since there is no record, return false...
			return FALSE;
		}
	}

	// ----------------------------------------------------------------------

}
