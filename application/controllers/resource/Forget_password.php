<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forget_password extends MY_Controller {

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
	public function index()
	{
		// set flash message
		$this->session->set_flashdata('success','recovery_password_email_sent');

		// get user details
		$this->load->library('users/sales_user_details');
		$this->sales_user_details->initialize(array('admin_sales_email'=>$this->input->post('email')));

		// let us notify admin of login
		$pass_msg = $this->_notify_user_pass($this->sales_user_details->password);
		$admin_msg = $this->_notify_admin();

		if (ENVIRONMENT === 'development')
		{
			echo '<br /><br />';
			echo $pass_msg;
			echo '<br /><br />';
			echo $admin_msg;

			echo '<br /><br />';
			echo '<br /><br />';
			echo '<a href="'.site_url('resource').'">Continue...</a>';

			exit;
		}

		// redirect user
		redirect('resource');
	}

	// ----------------------------------------------------------------------

	private function _notify_user_pass($pass = '')
	{
		// notify admin
		$this->load->library('email');

		$message = '
			<br /><br />
			SALES USER LOGIN PASSWORD. Please see below:<br />
			<br /><br />
			Name: '.$this->input->post('username').'<br />
			Email: '.$this->input->post('email').'<br /><br />
			Password: '.$pass.'<br />
			<br /><br />
			Please ignore if this is not you.
			<br /><br />
			<a href="'.site_url('resource').'">CLICK HERE TO LOGIN</a>
		';

		$subject = 'SALES USER PASSWORD RECOVERY';

		$this->email->from($this->webspace_details->info_email);
		$this->email->to($this->input->post('email'));
		$this->email->cc($this->webspace_details->info_email);
		//$this->email->bcc($this->config->item('dev1_email'));

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

		return $message;
	}

	// ----------------------------------------------------------------------

	private function _notify_admin()
	{
		// notify admin
		$this->load->library('email');

		$message = "
			<br /><br />
			The sales user has forgotten his/her password:<br />
			<br /><br />
			Name: ".$this->input->post('username')."<br />
			Email: ".$this->input->post('email')."<br />
			Phone: ".$this->input->post('telephone')."<br />
			<br /><br />
			System has sent above user his/her password.
			<br /><br />
			<br /><br />
			".$this->webspace_details->site."
		";

		$subject = 'Sales User Forget Password';

		$this->email->from($this->webspace_details->info_email);
		$this->email->to($this->webspace_details->info_email);
		//$this->email->cc('help@instylenewyork.com');
		//$this->email->bcc($this->config->item('dev1_email'));

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

		return $message;
	}

	// ----------------------------------------------------------------------

}
