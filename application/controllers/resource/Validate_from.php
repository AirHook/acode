<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validate_from extends Frontend_Controller {

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
	public function index($admin_sales_id = '', $token = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');
	
		// check for ott (one time token) and sales user credentials
		if (
			$token === ''
			OR (! $this->sales_user_details->initialize(array(
				'admin_sales_id' => $admin_sales_id 
				))
				&& ! $this->sales_user_details->validate_ott($token)
			)
		)
		{
			// send back to referrer
			if (ENVIRONMENT === 'development')
			{
				echo 'Returning to reference satellite designer site.<br />';
				echo '<a href="'.rtrim($_SERVER['HTTP_REFERER'], '.html').'/huberror_invalidated.html">Continue</a>...';
				
				// de-initialize library class
				$this->sales_user_details->set_initial_state();
				$this->sales_user_details->unset_session();
			}
			else 
			{
				// de-initialize library class
				$this->sales_user_details->set_initial_state();
				
				header('Location: '.rtrim($_SERVER['HTTP_REFERER'], '.html').'/huberror_invalidated.html');
			}
			
			exit;
		}
		
		// set session data
		// new feature using Sales User Details class
		$this->sales_user_details->set_session();
		
		// set the session lapse time if it has not been set
		if ( ! $this->session->userdata('admin_sales_login_time'))
		{
			$this->session->set_userdata('admin_sales_login_time', time());
		}
		
		// let us notify admin of login
		if (ENVIRONMENT !== 'development') $this->_notify_admin();
		
		// all good, send user to apparels page
		//redirect('sa'.($this->sales_user_details->access_level == '2' ? '/dashboard': ''));
		redirect('sales/dashboard');
	}
	
	// ----------------------------------------------------------------------
	
	private function _notify_admin()
	{
		// notify admin
		$this->load->library('email');
		
		$message = "
			".$this->sales_user_details->email."<br />
			Access Level - ".$this->sales_user_details->access_level."<br />
			<br /><br />
			Just logged in - ".@date('Y-m-d H:i:sa', @time()).".<br />
		";
		
		$subject = 'Sales User Logged In';
		
		$this->email->from($this->webspace_details->info_email);
		$this->email->to($this->webspace_details->info_email);
		$this->email->cc('help@instylenewyork.com');
		$this->email->bcc($this->config->item('dev1_email'));
		
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->email->send();
	}
	
	// ----------------------------------------------------------------------
	
}