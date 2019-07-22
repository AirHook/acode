<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// ser posts params
		$post_ary = $this->input->post();
		unset($post_ary['user_id']);
		
		if ($this->input->post('user_id'))
		{
			// update record
			$this->DB->where('user_id', $this->input->post('user_id'));
			$this->DB->update('tbluser_data_wholesale', $post_ary);
		}
		else
		{
			// insert record
			$this->DB->set($post_ary);
			$this->DB->insert('tbluser_data_wholesale');
			echo $this->DB->insert_id();
		}
	}
	
	// ----------------------------------------------------------------------
	
}