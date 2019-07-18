<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends Frontend_Controller {

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
		//echo 'Authenticating...';
		
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('form_validation');

		$email							= $this->input->post('username');
		$password						= $this->input->post('password');
		$this->data['site_referrer']	= $this->input->post('site_referrer'); // ---> for access from satellite site
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		// if validation errors...
		if ($this->form_validation->run() == FALSE)
		{
			// set flash notice
			$this->session->set_flashdata('flashMsg', 'There is an error in the form.<br />Please try agan.');
			
			// rediect back to sign in page
			redirect('wholesale/signin');
		}
		
		// authenticate user
		if ( ! $this->wholesale_user_details->initialize(array('email'=>$email, 'pword'=>$password)))
		{
			// set flash notice
			$this->session->set_flashdata('flashMsg', 'Invalid Credentials');
			
			// rediect back to sign in page
			redirect('wholesale/signin');
		}
		
		// if user is inactive or suspended
		if (
			$this->wholesale_user_details->status == 2
			OR $this->wholesale_user_details->status == 0
		)
		{
			if ($this->wholesale_user_details->status == 2) $this->data['view'] = 'suspended';
			if ($this->wholesale_user_details->status == 0) $this->data['view'] = 'inactive';
			
			// set data variables...
			$this->data['file'] = 'wholesale_activate';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;
			
			// load views...
			$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		}
		else
		{
			// once user is authenticated, redirect to respective hub site
			if (ENVIRONMENT === 'development')
			{
				redirect('wholesale/authenticated/index/'.$this->wholesale_user_details->user_id);
			}
			else
			{
				if (
					$this->webspace_details->slug === 'tempoparis'
					&& (
						DOMAINNAME === 'tempoparis.com'
						OR DOMAINNAME === 'tempo-paris.com'
					)
				) 
				{
					redirect(base_url().'wholesale/authenticated/index/'.$this->wholesale_user_details->user_id.'.html');
				}
				else redirect($this->config->item('PROD_IMG_URL').'wholesale/authenticated/index/'.$this->wholesale_user_details->user_id.'.html');
			}
		}
	}
	
	// ----------------------------------------------------------------------
	
}
