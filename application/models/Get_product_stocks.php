<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_product_stocks extends CI_Model {

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
	function __Construct()
	{
		parent::__Construct();
		
		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get Footer Text
	 *
	 * @return	void
	 */
	function get_stocks($prod_no = '', $color_name = '')
	{
		$this->DB->from('tbl_stock');
		$this->DB->where('prod_no', $prod_no);
		$this->DB->where('color_name', $color_name);
		$q1 = $this->DB->get();
		
		if ($q1->num_rows() > 0)
		{
			return $q1->row_array();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

}
