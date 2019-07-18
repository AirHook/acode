<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends MY_Controller {

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
		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			// set flash notice
			$this->session->set_flashdata('flashMsg', 'Please enter your email address.');
			
			// redirect user
			redirect('wholesale/signin', 'location');
		}
		else
		{
			// load pertinent library/model/helpers
			$this->load->library('users/wholesale_user_details');
			
			// check user details
			if ( ! $this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				// add flash notice
				$_SESSION['flashMsg-forgot_password'] = 'The email address you entered is invalid.';
				$this->session->mark_as_flash('flashMsg-forgot_password');
				
				// redirect user
				redirect('wholesale/signin', 'location');
			}
			
			// if active
			if ($this->wholesale_user_details->status == '1')
			{
				// create message
				$message = '
					You have requested to retrieve your password.
					<br /><br />
					<strong>Username:</strong> '.$this->input->post('email').'<br />
					<strong>Password:</strong> '.$this->wholesale_user_details->password.'<br />
					<br />
					Click on link to login: <a href="http://'.$this->input->post('site_referrer').'/wholesale/signin.html" target="_blank">http://'.$this->input->post('site_referrer').'/wholesale/signin.html</a>
					<br /><br />
					To change password, click <a href="http://'.$this->input->post('site_referrer').'/wholesale/change_password.html" target="_blank">here.</a>
					<br /><br />
					For more information or further assistance, please call us on '.$this->webspace_details->phone.' or email us at <a href="mailto:'.$this->webspace_details->info_email.'">'.$this->webspace_details->info_email.'</a>
				';
				
				$message_to_admin = '
					<strong>Username:</strong> '.$this->input->post('email').'<br />
					<strong>Password:</strong> '.$this->wholesale_user_details->password.'<br />
					<br /><br />
					Above wholesale user has requested to retrieve his password.
				';
			}
			else
			{
				// create message
				$message = '
					Dear Wholesale Buyer,
					<br /><br />
					Thank you for your interest.<br />
					Your access privileges have been suspended due to lack on activity.
					<br /><br />
					To reactivate, you must call client services at '.$this->webspace_details->phone.' or email us at <a href="mailto:'.$this->webspace_details->info_email.'">'.$this->webspace_details->info_email.'</a>
				';
				
				$message_to_admin = '
					<strong>Username:</strong> '.$this->input->post('email').'<br />
					<br /><br />
					Above wholesale user has requested to retrieve his password.<br />
					However, user is currently SUSPENDED/INACTIVE.
				';
			}
			
			if (ENVIRONMENT == 'development') // ---> used for development purposes
			{
				// we are unable to send out email in our dev environment
				// so we check on the email template instead.
				// just don't forget to comment these accordingly
				echo $message;
				echo '<br /><br />';
				echo 'NOTIFY ADMIN...<br />';
				echo $message_to_admin;
				echo '<br /><br />';
				
				// add flash notice
				$_SESSION['flashMsg-forgot_password'] = 'Recovery Password email sent.';
				$this->session->mark_as_flash('flashMsg-forgot_password');
				
				echo '<a href="'.site_url('wholesale/signin').'">Continue...</a>';
				echo '<br /><br />';
				exit;
			}
			else
			{
				// let's send the email
				// load email library
				$this->load->library('email');
				
				// send to user
				$this->email->clear();
				
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($this->input->post('email'));
				
				$this->email->subject($this->webspace_details->name.' - Recover Password');
				$this->email->message($message);
				
				$this->email->send();
				
				// notify admin
				$this->email->clear();
				
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($this->webspace_details->info_email);
				
				$this->email->subject($this->webspace_details->name.' - Recover Password Notification');
				$this->email->message($message_to_admin);
				
				$this->email->send();
				
				// add flash notice
				$_SESSION['flashMsg-forgot_password'] = 'Recovery Password email sent.';
				$this->session->mark_as_flash('flashMsg-forgot_password');
				
				// redirect user
				redirect('wholesale/signin', 'location');
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific 
	 * styles and scripts for each page as per selected theme
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);
		
		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';
		
			if (@$this->webspace_details->options['theme'] == 'roden2______')
			{
				// home image boxes for roden2 theme
				$this->data['page_level_styles_plugins'].= '
					<script src="'.$assets_url.'/css/home_image_boxes_styles.css" type="text/javascript"></script>
				';
			}
		
		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
		
		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';
		
			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}
