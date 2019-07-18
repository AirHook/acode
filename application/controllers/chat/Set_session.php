<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_session extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 *
	 * @return	void
	 */
	public function index($maximize = 0)
	{
		if ($maximize > 0) $_SESSION['chat_box_maximized'] = TRUE;
		else $_SESSION['chat_box_maximized'] = FALSE;
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Unset Chat
	 *
	 * Unset the $logindata['chat_id'] in wholesale user logindetails
	 *
	 * @return	void
	 */
	public function unset_chat()
	{
		// chat_id was initialized on first hello via chat/send controller
		// lets deinitialize by setting it to zero
		// load pertinent library/model/helpers
		$this->load->model('get_wholesale_login_details');
		if ($this->get_wholesale_login_details->check_id($_SESSION['this_login_id']))
		{
			// get current logindata (@return is always an array)
			$cur_logindata = $this->get_wholesale_login_details->get();
			
			// add/edit chat_id key value
			$cur_logindata['chat_id'] = '0';
			
			$this->get_wholesale_login_details->update($cur_logindata);
		}
		
		// unset the 'chat_box_maximized' sessioni variable
		if ($_SESSION['chat_box_maximized']) unset($_SESSION['chat_box_maximized']);
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Read - supposedly for monitoring the unread message
	 *
	 * To anticipate page transfers where new messages are still not read
	 *
	 * @return	void
	 */
	public function read($read = 0)
	{
		$_SESSION['read_messages'] = $read;
	}
	
	// ----------------------------------------------------------------------
	
}
