<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Frontend_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// de-initialize wholesale user and unset session
		//$this->load->library('users/wholesale_user_details');
		$this->wholesale_user_details->update_login_detail(array('logout'), 'active_time');
		$this->wholesale_user_details->initialize();
		$this->wholesale_user_details->unset_session();
		
		// we reset chat if user was in chat
		if (isset($_SESSION['chat_id'])) unset($_SESSION['chat_id']);
		if (isset($_SESSION['chat_box_maximized'])) unset($_SESSION['chat_box_maximized']);
		
		// destroy any cart items
		$this->cart->destroy();
		
		// set flash data
		$this->session->set_flashdata('flashMsg', 'Logout successful!');
		
		// redirect to categories page
		redirect(site_url('wholesale/signin'), 'location');
	}
	
	// ----------------------------------------------------------------------
	
}
