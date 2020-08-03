<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_stocks_to_items extends CI_Controller {

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
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// ----------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo '<pre>';

		// set the query
		// 1. for tempo only (des_id = '66') tbl_stock.des_id = '66'
		// 2. get all tempo items with zero stock on S, M, L, XL
		// 3. set size_ss = '1', size_sm = '1', size_sl = '1', size_sxl = '1'
		// 4. both physical and available

		$qry1 = "
			SELECT *, tbl_stock.st_id AS the_st_id
			FROM tbl_stock
			LEFT JOIN tbl_stock_physical ON tbl_stock_physical.st_id = tbl_stock.st_id
			WHERE
				tbl_stock.size_ss = '0'
				AND tbl_stock.size_sm = '0'
				AND tbl_stock.size_sl = '0'
				AND tbl_stock.size_sxl = '0'
				AND tbl_stock.size_sxxl = '0'
				AND tbl_stock.size_sxl1 = '0'
				AND tbl_stock.size_sxl2 = '0'
				AND tbl_stock.des_id = '66'
		";

		// select from old table
		$q1 = $this->DB->query($qry1);

		$i = 1;
		foreach ($q1->result() as $row)
		{
			$qry2 = "
				UPDATE tbl_stock
				SET size_ss = '1', size_sm = '1', size_sl = '1', size_sxl = '1'
				WHERE st_id = '".$row->the_st_id."'
			";

			// update
			$q2 = $this->DB->query($qry2);

			/* */
			$qry3 = "
				UPDATE tbl_stock_physical
				SET size_ss = '1', size_sm = '1', size_sl = '1', size_sxl = '1'
				WHERE st_id = '".$row->the_st_id."'
			";

			// update
			$q3 = $this->DB->query($qry3);
			// */

			$i++;
		}

		echo '<br />';
		echo 'Done';
	}
}
