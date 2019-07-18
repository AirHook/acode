<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_details extends CI_Model {

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
	 * Update Login Details
	 *
	 * @return	void
	 */
	function update($user_id, $param)
	{
		if ($param == 'consumer') $q = $this->DB->get_where('tbluser_data',array('user_id'=>$user_id));
		if ($param == 'wholesale') $q = $this->DB->get_where('tbluser_data_wholesale',array('user_id'=>$user_id));
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			if ($param == 'consumer') $email = $row->email;
			if ($param == 'wholesale') $email = $row->email;
			$data = array(
				'user_id' => $user_id,
				'session_id' => $this->session->userdata('session_id') ?: '',
				'create_date' => date('Y-m-d', time()),
				'create_time' => date('H:i:s', time()),
				'email' => $email,
				'logindata' => ''
			);
			if ($param == 'consumer') $this->DB->insert('tbl_login_detail',$data);
			if ($param == 'wholesale') $this->DB->insert('tbl_login_detail_wholesale',$data);
		}
	}
	
	// --------------------------------------------------------------------

}
