<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_pages extends CI_Model {

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
	 * Get meta details
	 *
	 * @params	string (pagename field)
	 * @return	object/boolean false
	 */
	function details($params = '')
	{
		if ( ! $params)
		{
			return FALSE;
		}

		$this->DB->where('pagename', $params);
		$q1 = $this->DB->get('tblmeta');

		if ($q1->num_rows() > 0)
		{
			return $q1->row();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Page Details
	 *
	 * @params	string (title_code field)
	 * @return	object/boolean false
	 */
	function page_details($params = '')
	{
		if ( ! $params)
		{
			return FALSE;
		}

		$this->DB->where('title_code', $params);
		$q1 = $this->DB->get('pages');

		if ($q1->num_rows() > 0)
		{
			return $q1->row();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Page Details
	 *
	 * @params	string (pagename field)
	 * @return	object/boolean false
	 */
	function page_details_new($params)
	{
		if (is_string($params))
		{
			if ( ! $params)
			{
				return FALSE;
			}
			else $this->DB->where('pagename', $params);
		}

		if (is_array($params))
		{
			if (empty($params))
			{
				return FALSE;
			}
			else $this->DB->where($params);
		}

		$q1 = $this->DB->get('pages_new');

		if ($q1->num_rows() > 0)
		{
			return $q1->row();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Page Details
	 *
	 * @params	string (title_code field)
	 * @return	object/boolean false
	 */
	function press()
	{
		$q1 = $this->DB->get('tbl_press');

		if ($q1->num_rows() > 0)
		{
			return $q1->result();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Page Details
	 *
	 * @params	string (title_code field)
	 * @return	object/boolean false
	 */
	function events()
	{
		$q1 = $this->DB->get('tblnews');

		if ($q1->num_rows() > 0)
		{
			return $q1->result();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
