<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_test extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// results of a session variable that has not been set at all
		//echo $_SESSION['a_variable_that_has_not_been_set_at_all'];
		// resulting to:
		//	Severity: Notice
		//	Message: Undefined index: a_variable_that_has_not_been_set_at_all
		
		// ergo, we have to check if index is existing or not
		/*
		if (isset($_SESSION['a_variable_that_has_not_been_set_at_all']))
		{
			echo 'Session variable is set.';
		}
		else echo 'Session variable is not set.';
		*/
		
		// lets use the magic getter
		//echo '<pre>';
		//print_r($_SESSION);
		
		// test email sending
		$message = '
			This is a test email sending using cronjobs from shop7thavenue.<br />
			Straigth from DO server.<br />
			If you receive this message. Please ignore.<br />
			<br />
			<br />
			<br />
			Let me know if you receive this email at your 12mn time.
		';
		
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $message;
			echo '<br /><br />';
			
			echo '<a href="javascrtip:;">Done...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');
			
			// notify admin
			//$this->email->clear();
			
			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			$this->email->to($this->webspace_details->info_email);
			
			$this->email->cc($this->config->item('dev1_email'));
			
			$this->email->subject($this->webspace_details->name.' - Test Email Sending');
			$this->email->message($message);
			
			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			@$this->email->send(FALSE);

			echo $this->email->print_debugger();
			echo '<br /><br />';
			echo '<a href="javascrtip:;">Done...</a>';
			echo '<br /><br />';
			exit;
		}
	
		
	}
}
