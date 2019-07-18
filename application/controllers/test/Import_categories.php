<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_categories extends CI_Controller {

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
		echo 'Importing...<br />';
		
		// get the records
		$q1 = $this->DB->get('tbl_product');
		
		foreach ($q1->result() as $r1)
		{
			$categories = array();
			array_push($categories, $r1->cat_id);
			array_push($categories, $r1->subcat_id);
			
			$this->DB->set('categories', json_encode($categories));
			$this->DB->where('prod_id', $r1->prod_id);
			$q2 = $this->DB->update('tbl_product');
		}
		
		echo '<br />';
		echo 'Done';
	}
	
	// ----------------------------------------------------------------------
	
}
