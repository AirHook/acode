<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class So_items_convert extends CI_Controller {

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

		// load pertinent library/model/helpers
		$this->load->library('sales_orders/sales_order_details');

		// select from old table
		$q1 = $this->DB->get('sales_orders');

		$i = 0;
		foreach ($q1->result() as $row)
		{
			// initialize Information
			$this->sales_order_details->initialize(array('sales_order_id'=>$row->sales_order_id));

			// get the items
			$items = $this->sales_order_details->items;

			//print_r($items);
			//die();

			$items_ary = array();
			$items_new = array();
			foreach ($items as $value)
			{
				$style_no = $value['prod_no'].'_'.$value['color_code'];

				// check if item is in array
				if ( ! in_array($style_no, $items_ary))
				{
					// add item
					array_push($items_ary, $style_no);

					// set new items array
					$items_new[$style_no] = array(
						'color_name' => $value['color_name'],
						'wholesale_price' => $value['wholesale_price'],
						$value['size'] => $value['qty']
					);
				}
				else
				{
					$items_new[$style_no][$value['size']] = $value['qty'];
				}
			}

			//print_r($items_new);
			//echo '<br />';
			//if ($i == 2) die();

			// update to table
			/* */
			$this->DB->set('items', json_encode($items_new));
			$this->DB->where('sales_order_id', $this->sales_order_details->sales_order_id);
			$this->DB->update('sales_orders');
			// */

			$i++;
		}

		echo '<br />';
		echo 'Done';
	}
}
