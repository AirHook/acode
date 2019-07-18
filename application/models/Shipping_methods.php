<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_methods extends CI_Model {

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
	 * Get
	 *
	 * @return	void
	 */
	function get_methods()
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

	function get_method($ship_id) 
	{
		$this->DB->where('ship_id', $ship_id);
		$this->DB->from('tbl_shipmethod');
		$q1 = $this->DB->get();
		
		if ($q1->num_rows() > 0)
		{
			return $q1->row();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

}
