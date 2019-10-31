<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_date_ordered_to_timestamp extends CI_Controller {

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
