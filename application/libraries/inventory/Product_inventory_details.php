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
			tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall,
			tbl_stock.options,
			prod_no, color_code
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

			// the options
			$this->options = ($row->options && $row->options != '') ? json_decode($row->options , TRUE) : array();
			$this->stocks_options = $this->options;

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
