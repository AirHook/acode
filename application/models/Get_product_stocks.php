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
		$this->DB->join('tbl_stock_admin tsa', 'tsa.st_id = tbl_stock.st_id', 'left');
		$this->DB->join('tbl_stock_admin_physical tsap', 'tsa.st_id = tbl_stock.st_id', 'left');
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
