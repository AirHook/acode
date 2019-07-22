<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Del extends Admin_Controller {

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
	public function index($user_id = '')
	{
		if ($user_id)
		{
			// update record
			$this->DB->where('user_id', $user_id);
			$this->DB->delete('tbluser_data_wholesale');
			
			echo 'Deleted';
		}
	}
	
	// ----------------------------------------------------------------------
	
}