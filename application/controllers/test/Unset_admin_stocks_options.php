<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unset_admin_stocks_options extends CI_Controller {

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

		$qry1 = "
			SELECT *
			FROM tbl_stock
			LEFT JOIN tbl_stock_physical ON tbl_stock_physical.st_id = tbl_stock.st_id
			WHERE options LIKE '%\"admin_stocks_only\":\"1\"%'
		";
		$q1 = $this->DB->query($qry1);

		$i = 1;
		foreach ($q1->result() as $row)
		{
			$options = json_decode($row->options, TRUE);

			echo $i.' - '.$row->st_id.'<br />';
			//print_r($row);

			unset($options['admin_stocks_only']);

			//echo '<br />';

			$qry2 = "
				UPDATE tbl_stock
				SET options = '".json_encode($options)."'
				WHERE st_id = '".$row->st_id."'
			";

			$q2 = $this->DB->query($qry2);

			$i++;
		}

		echo '<br />';
		echo 'Done';
	}
}
