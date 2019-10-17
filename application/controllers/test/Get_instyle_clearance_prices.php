<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_instyle_clearance_prices extends CI_Controller {

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

		// need to connect to instyle database manually
		$db_instyle = array(
			'dsn'	=> '',
			'hostname' => 'localhost',
			'username' => (ENVIRONMENT === 'development' ? 'root' : 'verjel'),
			'password' => (ENVIRONMENT === 'development' ? 'rootpassword' : '!@R00+@dm!N'),
			'database' => 'verjel_instyle',
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
		);
		$this->DB2 = $this->load->database($db_instyle, TRUE);
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

		// get all clearance items from shop7
		$this->DB->select('*');
		$this->DB->from('tbl_product');
		$this->DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
		$this->DB->where('tbl_stock.custom_order', '3');
		$q1 = $this->DB->get();

		$i =  1;
		foreach ($q1->result() as $row)
		{
			// get the sale price of the shop7 clearance price from instyle
			$this->DB2->select('catalogue_price');
			$this->DB2->from('tbl_product');
			$this->DB2->where('prod_no', $row->prod_no);
			$q2 = $this->DB2->get();
			$r2 = $q2->row();

			if (@$r2->catalogue_price)
			{
				// update sale price at shop7
				$this->DB->set('catalogue_price', $r2->catalogue_price);
				$this->DB->where('prod_no', $row->prod_no);
				$this->DB->update('tbl_product');
			}

			$i++;
		}

		//echo $this->DB->last_query();
		echo '<br />';
		echo 'Done';
	}
}
