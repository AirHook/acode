<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Make_99_unpublish extends CI_Controller {

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
		// 1. for basix only (des_id = '5') tbl_product.designer = '5'
		// 2. all seque no 10 & 11 tbl_product.seque != '10' AND tbl_product.seque != '11'
		// 3. set UNPUBLISH - SET publish = '0', view_status = 'N'
		// 4. set seque = '99'
		// 5. zero the stocks

		$query = "
			UPDATE tbl_stock
			JOIN tbl_product ON tbl_product.prod_no = tbl_stock.prod_no
			SET size_0 = '0', size_2 = '0', size_4 = '0', size_6 = '0', size_8 = '0', size_10 = '0', size_12 = '0', size_14 = '0', size_16 = '0', size_18 = '0', size_20 = '0', size_22 = '0'
			WHERE tbl_product.designer = '5' AND tbl_product.seque != '10' AND tbl_product.seque != '11'
		";

		// select from old table
		$q1 = $this->DB->get('tbl_order_log');

		$i = 0;
		foreach ($q1->result() as $row)
		{
			$date = str_replace('-', '',str_replace(',',' ',$row->date_ordered));
			$date = @strtotime($date);
			echo $i.' '.$row->date_ordered.' => '.$date.' || '.@date('Y-m-d',$date).' to '.$row->order_log_id.'<br />';

			// update to table
			/* */
			$this->DB->set('order_date', $date);
			$this->DB->where('order_log_id', $row->order_log_id);
			$this->DB->update('tbl_order_log');
			// */

			$i++;
		}

		echo '<br />';
		echo 'Done';
	}
}
