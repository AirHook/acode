<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert_old_to_new_product_clicks extends MY_Controller {

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
	
	// --------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// select the items from old product clicks table
		$this->DB->select('product_clicks_old.*');
		$this->DB->select('designer.designer');
		$this->DB->join('tbl_product', 'tbl_product.prod_no = product_clicks_old.prod_no');
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer');
		$where = "date > '2017-03-31' AND date < '2017-07-01'";
		$this->DB->where($where);
		$qry1 = $this->DB->get('product_clicks_old');
		
		$string_length = 0;
		
		$i = 1;
		foreach ($qry1->result() as $row)
		{
			// check if current date exists on new product clicks table
			$qry2 = $this->DB->get_where('product_clicks', array('click_date'=>$row->date));
			$item = $qry2->row();
			
			// if existing...
			if (isset($item))
			{
				
				// get data
				$data = json_decode($item->click_data, TRUE);
				
				// update recrod
				if (isset($data[$row->prod_no]))
				{
					// adding new prod_no
					$data[$row->prod_no] = array(
						$data[$row->prod_no][0] + $row->clicks_cs,
						$data[$row->prod_no][1] + $row->clicks_ws,
						$data[$row->prod_no][2]
					);
				}
				else
				{
					// creating new prod_no
					$data[$row->prod_no] = array(
						$row->clicks_cs,
						$row->clicks_ws,
						$row->designer
					);
				}
				
				$click_data = json_encode($data);
				
				$this->DB->update('product_clicks', array('click_data'=>$click_data), array('click_id'=>$item->click_id));
			}
			else
			{
				// generate record to insert
				$data[$row->prod_no] = array(
					$row->clicks_cs,
					$row->clicks_ws,
					$row->designer
				);
				
				$click_data = json_encode($data);
				
				$insert_data = array(
					'click_date' => $row->date,
					'click_data' => $click_data
				);
				
				$this->DB->insert('product_clicks', $insert_data);
			}
			
			$click_data_length = strlen($click_data);
			$string_length = $click_data_length > $string_length ? $click_data_length : $string_length;
			
			$i++;
		}
		
		echo 'Processed data from - '.$where.'<br />';
		echo 'Total records processed - '.$i.'<br />';
		echo 'Largest number of characters in a json is - '.$string_length.'<br />';
		echo 'Done...';
	}
}
