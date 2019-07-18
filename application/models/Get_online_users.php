<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_online_users extends CI_Model {

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;
	
	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

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
	 * Get online users
	 *
	 * @return	object/boolean false
	 */
	public function get()
	{
		$this->DB->select('online_users.lastonline');
		$this->DB->select('tbl_login_detail_wholesale.*');
		$this->DB->select('store_name, firstname, lastname');
		$this->DB->select('tbladmin_sales.admin_sales_id');
		$this->DB->join('tbl_login_detail_wholesale', 'tbl_login_detail_wholesale.email = online_users.email', 'left');
		$this->DB->join('tbluser_data_wholesale', 'tbluser_data_wholesale.email = tbl_login_detail_wholesale.email', 'left');
		$this->DB->join('tbladmin_sales', 'tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email', 'left');
		$this->DB->where('lastonline >', strtotime('-1 day'));
		$whr = "log_id IN (SELECT MAX(log_id) FROM tbl_login_detail_wholesale GROUP BY tbl_login_detail_wholesale.email)";
		$this->DB->where($whr);
		$this->DB->order_by('lastonline', 'DESC');
		$query = $this->DB->get('online_users');
		
		//echo $this->DB->last_query(); die();
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// return the object
			return $query->result();
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update logindata
	 *
	 * @params	array
	 * @return	object/boolean false
	 */
	public function update($logindata = array())
	{
		if (empty($logindata))
		{
			// nothing more to do...
			return FALSE;
		}
		
		if (
			! isset($_SESSION['this_login_id'])
			OR (
				isset($_SESSION['this_login_id'])
				&& $_SESSION['this_login_id'] == ''
			)
		)
		{
			// nothing more to do...
			return FALSE;
		}
		
		// update records
		$this->DB->set('logindata', json_encode($logindata));
		$this->DB->where('log_id', $_SESSION['this_login_id']);
		$this->DB->update('tbl_login_detail_wholesale');
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get those who loggedin
	 *
	 * This function is used for the daily wholesale user activities report
	 * and we need to join the table with the respective assigned sales user
	 *
	 * @params	date
	 * @return	object/boolean false
	 */
	public function get_loggedin($date = '', $sales_user_email = '')
	{
		if ($sales_user_email)
		{
			$this->DB->where('tbluser_data_wholesale.admin_sales_email', $sales_user_email);
		}
		
		if ( ! $date)
		{
			// default to yesterday..
			$date = date('Y-m-d', @time()-86400);
		}
		
		// update records
		$this->DB->select('
			tbl_login_detail_wholesale.create_date AS xdate,
			tbl_login_detail_wholesale.create_time AS xtime,
			tbl_login_detail_wholesale.logindata
		');
		$this->DB->select('tbluser_data_wholesale.*');
		$this->DB->select('
			tbladmin_sales.admin_sales_user, 
			tbladmin_sales.admin_sales_lname,
			tbladmin_sales.is_active AS sales_is_active
		');
		$this->DB->select('today_visits, total_visits');
		$this->DB->where('tbl_login_detail_wholesale.create_date', $date);
		$this->DB->join(
			'tbluser_data_wholesale', 
			'tbluser_data_wholesale.email = tbl_login_detail_wholesale.email', 
			'left'
		);
		$this->DB->join(
			'tbladmin_sales', 
			'tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email', 
			'left'
		);
		$this->DB->join(
			"
				(SELECT email, COUNT(email) AS today_visits 
				FROM tbl_login_detail_wholesale
				WHERE create_date = '".$date."'
				GROUP BY email) AS ldwtv
			", 
			'ldwtv.email = tbl_login_detail_wholesale.email', 
			'left'
		);
		$this->DB->join(
			'
				(SELECT email, COUNT(email) AS total_visits 
				FROM tbl_login_detail_wholesale
				GROUP BY email) AS ldw
			', 
			'ldw.email = tbl_login_detail_wholesale.email', 
			'left'
		);
		$this->DB->order_by('tbl_login_detail_wholesale.log_id', 'DESC');
		$q1 = $this->DB->get('tbl_login_detail_wholesale');
		
		if ($q1->num_rows())
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get those who loggedin
	 *
	 * This function is used for the daily wholesale user activities report
	 * and we need to join the table with the respective assigned sales user
	 *
	 * @params	date
	 * @return	object/boolean false
	 */
	public function get_general($date = '')
	{
		if ( ! $date)
		{
			// default to yesterday..
			$date = date('Y-m-d', @time()-86400);
		}
		
		// update records
		$this->DB->select('
			tbladmin_sales.admin_sales_email as sales_email
		');
		$this->DB->select('innertable.*');
		$this->DB->select('
			tbladmin_sales.admin_sales_user, 
			tbladmin_sales.admin_sales_lname,
			tbladmin_sales.is_active AS sales_is_active
		');
		$this->DB->select('today_visits, total_visits');
		$this->DB->join(
			"
				(
				SELECT 
					tbl_login_detail_wholesale.create_date AS xdate,
					tbl_login_detail_wholesale.create_time AS xtime,
					tbl_login_detail_wholesale.logindata,
					tbluser_data_wholesale.*
				FROM tbluser_data_wholesale
				INNER JOIN tbl_login_detail_wholesale
				ON tbl_login_detail_wholesale.email = tbluser_data_wholesale.email
				WHERE tbl_login_detail_wholesale.create_date = '".$date."'
				)
				as innertable
			",
			"innertable.admin_sales_email = tbladmin_sales.admin_sales_email", 
			'left'
		);
		$this->DB->join(
			"
				(SELECT email, COUNT(email) AS today_visits 
				FROM tbl_login_detail_wholesale
				WHERE create_date = '".$date."'
				GROUP BY email) AS ldwtv
			", 
			'ldwtv.email = innertable.email', 
			'left'
		);
		$this->DB->join(
			'
				(SELECT email, COUNT(email) AS total_visits 
				FROM tbl_login_detail_wholesale
				GROUP BY email) AS ldw
			', 
			'ldw.email = innertable.email', 
			'left'
		);
		$this->DB->order_by('sales_email', 'ASC');
		$this->DB->order_by('xtime', 'DESC');
		$q1 = $this->DB->get('tbladmin_sales');
		
		//echo $this->DB->last_query(); die();
		
		if ($q1->num_rows())
		{
			return $q1->result();
		}
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

}
