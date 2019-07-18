<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optout extends Frontend_Controller {

	/**
	 * DB Reference
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
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index($encypted_email)
	{
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		
		// get all users
		$users = $this->wholesale_users_list->select();
		
		if ( ! $users)
		{
			// nothing more to do...
			exit;
		}
		
		foreach ($users as $user)
		{
			if ($encypted_email === md5($user->email))
			{
				$this->wholesale_user_details->initialize(array('email'=>$user->email));
				break;
			}
		}
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);	
		
		$this->DB->set('is_active', '0');
		$this->DB->set('comments', 'Optout');
		$this->DB->where('user_id', $this->wholesale_user_details->user_id);
		$this->DB->update('tbluser_data_wholesale');
		
		// notify admin user has optout
		$email = $this->wholesale_user_details->email;
		$name = $this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname;
		$store_name = $this->wholesale_user_details->store_name;
		$this->_notify_admin_user_online();
		
		// set data variables to pass to view file
		$this->data['file'] 						= 'wholesale_optout_successful';
		$this->data['site_title']					= @$meta_tags['title'];
		$this->data['site_keywords']				= @$meta_tags['keyword'];
		$this->data['site_description']				= @$meta_tags['description'];
		$this->data['alttags']						= @$meta_tags['alttags'];
		
		// load the view
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
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
			Dear Admin,
			<br /><br />
			The following user has opted out from receiving sales package offers:
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
			
			$this->email->subject('WHOLESALE USER OPTOUT - '.strtoupper($this->webspace_details->name));
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
