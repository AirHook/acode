<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_shipmethod extends CI_Model {

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
	function get_shipmethod()
	{
		$this->DB->from('tbl_shipmethod');
		$q1 = $this->DB->get();
		
		if ($q1->num_rows() > 0)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

}
