<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticated extends Frontend_Controller {

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
	public function index($wholesale_user_id = '')
	{
		if ( ! $wholesale_user_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		// initialize wholesale user
		$this->load->library('users/wholesale_user_details');
		if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$wholesale_user_id)))
		{
			// set flash notice
			$this->session->set_flashdata('flashMsg', 'Invalid Credentials');
			
			// redirect user
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		// set logged in session
		$this->wholesale_user_details->set_session();
		// update login details
		$this->wholesale_user_details->record_login_detail();
		
		// notify admin user is online
		$this->_notify_admin_user_online();
		
		// redirect to categories page
		if (
			$this->webspace_details->slug === 'tempoparis'
			&& (
				DOMAINNAME === 'tempoparis.com'
				OR DOMAINNAME === 'tempo-paris.com'
			)
		) 
		{
			redirect('shop/categories');
		}
		else redirect(site_url('shop/designers/'.$this->wholesale_user_details->reference_designer), 'location');
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Notify admin of user being online
	 *
	 * @return	void
	 */
	private function _notify_admin_user_online()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear '.ucwords($this->wholesale_user_details->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).' is now online.<br />
			Total logged in visits  - ( '.$this->wholesale_user_details->total_visits().' ).
			<br /><br />
			<strong>Sale User Representative:</strong> &nbsp; &nbsp; '.$this->wholesale_user_details->admin_sales_user.' '.$this->wholesale_user_details->admin_sales_lname.'
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>Store Name: &nbsp; </td>
					<td>'.$this->wholesale_user_details->store_name.'</td>
				</tr>
				<tr>
					<td>User Name: &nbsp; </td>
					<td>'.ucwords($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).'</td>
				</tr>
				<tr>
					<td>Telephone: &nbsp; </td>
					<td>'.$this->wholesale_user_details->telephone.'</td>
				</tr>
				<tr>
					<td>Email: &nbsp; </td>
					<td>'.$this->wholesale_user_details->email.'</td>
				</tr>
			</table>
			<br /><br />
			Click <u>here</u> to chat with user. <span style="color:red">[ Not yet available. ]</span>
			<br />
		';
		
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';
			
			echo '<a href="'.site_url('shop/designers/'.$this->wholesale_user_details->reference_designer).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');
			
			// notify admin
			$this->email->clear();
			
			$this->email->from($this->wholesale_user_details->designer_info_email, $this->wholesale_user_details->designer);

			$this->email->to($this->webspace_details->info_email);
			
			//$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes
			
			$this->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->webspace_details->name));
			$this->email->message($email_message);
			
			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this 
			// must resolve pending update of CI
			@$this->email->send();
		}
	}
	
	// ----------------------------------------------------------------------
	
}
