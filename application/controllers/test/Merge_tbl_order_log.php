<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merge_tbl_order_log extends CI_Controller {

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
		// select from old table
		/* *
		//$q1 = $this->DB->get_where('tbl_order_log', array('order_log_id >'=>'10300000'));
		$q1 = $this->DB->get_where('tbl_order_log_instyle');

		$i = 1;
		foreach ($q1->result() as $r1)
		{
			//$date = strtotime(str_replace('-', '',str_replace(',',' ',$r1->date_ordered)));
			$c = $r1->store_name ? 'ws' : 'cs';

			$this->DB->set('c', $c);
			$this->DB->where('order_log_id', $r1->order_log_id);
			$this->DB->update('tbl_order_log_instyle');

			$i++;
		}

		echo 'Processed '.$i.' items.';
		echo '<br />';
		echo 'Done';
		die();
		// */

		echo '<pre>';

		// select from old table
		//$q1 = $this->DB->get('tbl_order_log_shop_temp');
		$q1 = $this->DB->get('tbl_order_log_instyle');

		$i = 1;
		foreach ($q1->result_array() as $r1)
		{
			// capture original order log id
			$orig_order_log_id = $r1['order_log_id'];

			// update order log id to be able to merge
			// tempo items maintains use of 10100000 series
			// shop7 items will use 10300000 series (+200000)
			// instyle will use 10200000 series (+100000)
			$r1['order_log_id'] = $r1['order_log_id'] + 100000;

			// mareg to table
			$this->DB->insert('tbl_order_log', $r1);

			// process order details
			//$q2 = $this->DB->get_where('tbl_order_log_details_shop_temp', array('order_log_id'=>$orig_order_log_id));
			$q2 = $this->DB->get_where('tbl_order_log_details_instyle', array('order_log_id'=>$orig_order_log_id));

			foreach ($q2->result_array() as $r2)
			{
				// update order log id as per above
				$r2['order_log_id'] = $r1['order_log_id'];

				// mareg to table
				$this->DB->insert('tbl_order_log_details', $r2);
			}

			$i++;
		}

		echo 'Processed '.$i.' items.';
		echo '<br />';
		echo 'Done';
	}
}
