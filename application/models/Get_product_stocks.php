<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_product_stocks extends CI_Model {

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Get Footer Text
	 *
	 * @return	void
	 */
	function get_stocks($prod_no = '', $color_name = '')
	{
		$this->DB->select('tbl_stock.*');
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
		$this->DB->from('tbl_stock');
		$this->DB->join('tbl_stock_admin_physical tsa', 'tsa.st_id = tbl_stock.st_id', 'left');
		$this->DB->where('prod_no', $prod_no);
		$this->DB->where('color_name', $color_name);
		$q1 = $this->DB->get();

		if ($q1->num_rows() > 0)
		{
			return $q1->row_array();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
