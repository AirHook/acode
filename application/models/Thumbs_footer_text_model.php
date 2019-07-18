<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thumbs_footer_text_model extends CI_Model {

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
	function get_footer_text($uri = '', $sc_url_structure = '', $d_url_structure = '')
	{
		if ($uri != '')
		{
			$this->DB->from('thumbs_footer_seo');
			$this->DB->where('url', $uri);
			$q = $this->DB->get();
			
			if ($q->num_rows() > 0)
			{
				$row = $q->row_array();
				return $row['text'];
			}
		}
		
		if ($sc_url_structure != '' && $d_url_structure != '')
		{
			$this->DB->from('thumbs_footer_seo');
			$this->DB->where('designer', $d_url_structure);
			$this->DB->where('url', 'apparel/'.$sc_url_structure);
			$q1 = $this->DB->get();
			
			if ($q1->num_rows() > 0)
			{
				$row1 = $q1->row_array();
				return $row1['text'];
			}
		}
		
		if ($sc_url_structure != '')
		{
			$this->DB->from('thumbs_footer_seo');
			$this->DB->where('url', 'apparel/'.$sc_url_structure);
			$q2 = $this->DB->get();
			
			if ($q2->num_rows() > 0)
			{
				$row2 = $q2->row_array();
				return $row2['text'];
			}
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------

}
