<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convert_serialized_to_json extends CI_Controller {

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
		echo '<pre>';
		
		// select from old table
		$this->DB->order_by('create_date', 'ASC');
		$this->DB->order_by('create_time', 'ASC');
		//$this->DB->limit(100, 3000); // count, offset
		$q1 = $this->DB->get('tbl_login_detail_wholesale_bak');
		
		$i = 0;
		foreach ($q1->result() as $row)
		{
			$i++;
		
			// get the logindata
			$logindata = $row->logindata ? unserialize($row->logindata) : '';
			
			// set data
			$data = array(
				'user_id' => $row->user_id,
				'create_date' => $row->create_date,
				'create_time' => $row->create_time,
				'email' => $row->email,
				'logindata' => ($logindata ? json_encode($logindata) : '')
			);
			
			// insert to new table
			$this->DB->insert('tbl_login_detail_wholesale', $data);
		}
		
		echo '<br />';
		echo 'Done at '.$i;
	}
}
