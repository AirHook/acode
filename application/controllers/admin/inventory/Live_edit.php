<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_edit extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process/add some variables
		//$post_ary['domain_name'] = $domain;
		// unset unneeded variables
		unset($post_ary['action']);

		$st_id = $post_ary['st_id'];
		unset($post_ary['st_id']);

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// get all stocks information
		$DB->select('
			tbl_stock.size_ss, tbl_stock.size_sm, tbl_stock.size_sl, tbl_stock.size_sxl,
			tbl_stock.size_sxxl, tbl_stock.size_sxl1, tbl_stock.size_sxl2,
			tbl_stock.size_0, tbl_stock.size_2, tbl_stock.size_4, tbl_stock.size_6,
			tbl_stock.size_8, tbl_stock.size_10, tbl_stock.size_12, tbl_stock.size_14,
			tbl_stock.size_16, tbl_stock.size_18, tbl_stock.size_20, tbl_stock.size_22,
			tbl_stock.size_sprepack1221,
			tbl_stock.size_ssm, tbl_stock.size_sml,
			tbl_stock.size_sonesizefitsall
		');
		$DB->select('
			tso.size_ss AS onorder_ss, tso.size_sm AS onorder_sm,
			tso.size_sl AS onorder_sl, tso.size_sxl AS onorder_sxl,
			tso.size_sxxl AS onorder_sxxl, tso.size_sxl1 AS onorder_ssl1,
			tso.size_sxl2 AS onorder_sxl2,
			tso.size_0 AS onorder_0, tso.size_2 AS onorder_2,
			tso.size_4 AS onorder_4, tso.size_6 AS onorder_6,
			tso.size_8 AS onorder_8, tso.size_10 AS onorder_10,
			tso.size_12 AS onorder_12, tso.size_14 AS onorder_14,
			tso.size_16 AS onorder_16, tso.size_18 AS onorder_18,
			tso.size_20 AS onorder_20, tso.size_22 AS onorder_22,
			tso.size_sprepack1221 AS onorder_sprepack1221,
			tso.size_ssm AS onorder_ssm, tso.size_sml AS onorder_ssm,
			tso.size_sonesizefitsall AS onorder_sonesizefitsall
		');
		$DB->select('
			tsp.size_ss AS physical_ss, tsp.size_sm AS physical_sm,
			tsp.size_sl AS physical_sl, tsp.size_sxl AS physical_sxl,
			tsp.size_sxxl AS physical_sxxl, tsp.size_sxl1 AS physical_ssl1,
			tsp.size_sxl2 AS physical_sxl2,
			tsp.size_0 AS physical_0, tsp.size_2 AS physical_2,
			tsp.size_4 AS physical_4, tsp.size_6 AS physical_6,
			tsp.size_8 AS physical_8, tsp.size_10 AS physical_10,
			tsp.size_12 AS physical_12, tsp.size_14 AS physical_14,
			tsp.size_16 AS physical_16, tsp.size_18 AS physical_18,
			tsp.size_20 AS physical_20, tsp.size_22 AS physical_22,
			tsp.size_sprepack1221 AS physical_sprepack1221,
			tsp.size_ssm AS physical_ssm, tsp.size_sml AS physical_ssm,
			tsp.size_sonesizefitsall AS physical_sonesizefitsall
		');
		$DB->from('tbl_stock');
		$DB->join('tbl_stock_onorder tso', 'tso.st_id = tbl_stock.st_id', 'left');
		$DB->join('tbl_stock_physical tsp', 'tsp.st_id = tbl_stock.st_id', 'left');
		$DB->where('tbl_stock.st_id', $st_id);
		$get = $DB->get();

		$row = $get->row_array();

		foreach ($post_ary as $size_label => $value)
		{
			$exp = explode('_', $size_label);
			$size_suffix = $exp[1];

			$new_available_stock = $value - $row['onorder_'.$size_suffix];
		}

		// set last modified time
		$last_modified = time();
		$options = json_encode(array('last_modified'=>$last_modified));

		// update physical stock
		$DB->set('options', $options);
		$DB->set($size_label, $value);
		$DB->where('st_id', $st_id);
		$query = $DB->update('tbl_stock_physical');

		// update available stock where necessary
		$DB->set($size_label, $new_available_stock);
		$DB->where('st_id', $st_id);
		$query = $DB->update('tbl_stock');

		// let's return the key=>value pair in json
		echo json_encode($post_ary);
		exit;
	}

	// ----------------------------------------------------------------------

}
