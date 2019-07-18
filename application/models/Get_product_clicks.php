<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_product_clicks extends CI_Model {

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
	 * Daily
	 *
	 * @params	date	in 'Y-m-d' format
	 * @return	object/boolean false
	 */
	public function daily($day = '')
	{
		$this->DB->where('click_date', ($day ?: @date('Y-m-d', time())));
		$q1 = $this->DB->get('product_clicks');
		
		//echo $this->DB->last_query(); die();
		
		if ($q1)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Weekly
	 *
	 * @params	date	in 'Y-u' format (u is week number 00 to 53 where monday
	 *					is beginning of week)
	 * @return	object/boolean false
	 */
	public function weekly($week = '')
	{
		$where = "DATE_FORMAT(click_date, '%Y-%u') >= '".($week ?: @date('Y-u', time()))."'";
		$this->DB->where($where);
		
		$this->DB->where('click_date >=', $week_start);
		$q1 = $this->DB->get('product_clicks');
		
		if ($q1)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Monthly
	 *
	 * @params	date	in 'Y-m' format
	 * @return	object/boolean false
	 */
	public function mothly($month = '')
	{
		$where = "DATE_FORMAT(click_date, '%Y-%m') = '".($month ?: @date('Y-m', time()))."'";
		$this->DB->where($where);
		$q1 = $this->DB->get('product_clicks');
		
		if ($q1)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Yearly
	 *
	 * @params	date	in 'Y' format
	 * @return	object/boolean false
	 */
	public function yearly($year = '')
	{
		$where = "DATE_FORMAT(click_date, '%Y') = '".($year ?: @date('Y', time()))."'";
		$this->DB->where($where);
		$q1 = $this->DB->get('product_clicks');
		
		if ($q1)
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update - today's clicks
	 *
	 * @params	array
	 * @return	object/boolean false
	 */
	public function update($clicks = array())
	{
		if (empty($clicks))
		{
			// nothing more to do...
			return FALSE;
		}
		
		// let's first check if there is already some clicks today
		$q1 = $this->DB->get_where('product_clicks', array('click_date'=>@date('Y-m-d', time())));
		$r1 = $q1->row();
		
		// update or insert accordingly
		if (isset($r1))
		{
			$this->DB->set('click_data', json_encode($clicks));
			$this->DB->where('click_id', $r1->click_id);
			$q2 = $this->DB->update('product_clicks');
		}
		else
		{
			$this->DB->set('click_data', json_encode($clicks));
			$this->DB->set('click_date', date('Y-m-d', time()));
			$q2 = $this->DB->insert('product_clicks');
		}
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

}
