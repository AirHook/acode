<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_product_inventory extends CI_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
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
		echo 'Processing...<br />';

		// the params
		$des_id = '5'; // basixblacklabel
		//$category_id = '195'; // evening_dreses

		// get the data
		$this->DB->select('st_id');
		$this->DB->select('tbl_product.prod_id');
		$this->DB->join('tbl_stock', 'tbl_stock.prod_id = tbl_product.prod_id');
		$this->DB->where('designer', $des_id);
		$q1 = $this->DB->get('tbl_product');

		//echo $this->DB->last_query(); die();

		foreach ($q1->result() as $r1)
		{
			$data = array(
				'size_0' => '0',
				'size_2' => '0',
				'size_4' => '0',
				'size_6' => '0',
				'size_8' => '0',
				'size_10' => '0',
				'size_12' => '0',
				'size_14' => '0',
				'size_16' => '0',
				'size_18' => '0',
				'size_20' => '0',
				'size_22' => '0',

			);
			$this->DB->where('st_id', $r1->st_id);
			$this->DB->update('tbl_stock');

			$data = array(
				'size_0' => '0',
				'size_2' => '0',
				'size_4' => '0',
				'size_6' => '0',
				'size_8' => '0',
				'size_10' => '0',
				'size_12' => '0',
				'size_14' => '0',
				'size_16' => '0',
				'size_18' => '0',
				'size_20' => '0',
				'size_22' => '0'
			);
			$this->DB->set($data);
			$this->DB->where('st_id', $r1->st_id);
			$this->DB->update('tbl_stock_physical');

			$this->DB->set('view_status', 'N');
			$this->DB->set('public', 'N');
			$this->DB->set('publish', '2');
			$this->DB->where('prod_id', $r1->prod_id);
			$this->DB->update('tbl_product');
		}

		echo '<br />';
		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
