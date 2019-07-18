<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_sizes_by_mode extends CI_Model {

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
	function get_sizes($size_mode = '')
	{
		$this->DB->from('tblsize');
		$this->DB->where('size_mode', $size_mode);
		$this->DB->where('bust <>', '0');
		$this->DB->order_by('size_id');
		$q1 = $this->DB->get();
		
		if ($q1->num_rows() > 0)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

}
