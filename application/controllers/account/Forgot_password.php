<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends Frontend_Controller {

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
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';
			
			// set data variables...
			$this->data['file'] = 'account_forgot_password';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;
			
			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			if ($this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'wholesale';
				$user_id = $this->wholesale_user_details->user_id;
				$status = $this->wholesale_user_details->status;
				$email = $this->wholesale_user_details->email;
				$password = $this->wholesale_user_details->password;

			}
			elseif ($this->consumer_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'consumer';
				$user_id = $this->consumer_user_details->user_id;
				$status = $this->consumer_user_details->status;
				$email = $this->consumer_user_details->email;
				$password = $this->consumer_user_details->password;
			}
			else
			{
				// set flash notice
				$this->session->set_flashdata('error', 'not_in_the_list');
				
				// rediect back to sign in page
				redirect('account');
			}
			
			// begin send email requet to isntyle admin
				if ($status == '1')
				{
					$email_message = '
						You have requested to retrieve your password.
						<br /><br />
						<strong>Username:</strong> '.$email.'<br />
						<strong>Password:</strong> '.$password.'<br />
						<br />
						Click on link to login: <a href="'.site_url('account').'" target="_blank">'.site_url('account').'</a>
						<br /><br />
						
						<br /><br />
						For more information or further assistance, please call us on '.$this->webspace_details->phone.' or email '.$this->webspace_details->info_email.'
					';
				}
				else
				{
					$email_message = '
						Dear Guest,
						<br /><br />
						Thank you for your interest.<br />
						Your access priviledges have been suspended due to lack on activity.
						<br /><br />
						To reactivate, you muct call client services at '.$this->webspace_details->phone.' or email '.$this->webspace_details->info_email.'
					';
				}
					
				$this->load->library('email');
				
				// send email to admin
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->to($email);
				//$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes
				
				$this->email->subject($this->webspace_details->name.' - Recover Password');
				$this->email->message($email_message);
				
				$this->email->send();
			// end send email requet to isntyle admin
			
			// set data variables...
			$this->data['view'] = 'success-notice';
			
			// set data variables...
			$this->data['file'] = 'account_forgot_password';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;
			
			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
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
		//$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);
		$assets_url = base_url('assets/metronic');
		
		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';
		
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
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
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
			// handle bootstrap select2
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'/assets/custom/js/metronic/pages/scripts/components-select2.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}
