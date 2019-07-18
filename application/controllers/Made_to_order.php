<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Made_to_order extends Frontend_Controller {
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	function index()
	{
		// load pertinent library/model/helpers
		$this->load->model('get_pages');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address 1', 'trim|required|callback_valid_email');
		$this->form_validation->set_rules('email2', 'Email Address 2', 'trim|required|callback_valid_email');
		$this->form_validation->set_rules('opt_item', 'Select Option', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			/*
			| ------------------------------------------------------------------------------
			| Get meta data from tblmeta 
			*/
			if ($this->webspace_details->slug === 'junnieleigh')
			{
				//$q_meta = $this->query_page->get_page('made_to_order');
				$this->data['made_to_order'] = $this->get_pages->details('made_to_order.php');
			}
			else
			{
				//$q_meta = $this->query_page->get_page_meta('made_to_order');
				$page_details = $this->get_pages->page_details('made_to_order');
			}
			//$meta_row = $q_meta->row();
		
			if ($this->webspace_details->slug === 'instylenewyork')
			{
				$this->data['page'] = 'made_to_order_instylenewyork';
			}
			elseif ($this->webspace_details->slug === 'tempoparis')
			{
				$this->data['page'] = 'made_to_order_tempoparis';
			}
			else
			{
				$this->data['page'] = 'made_to_order';
			}
			
			if ($this->webspace_details->slug === 'junnieleigh')
			{
				$this->data['page_text'] = @$page_details->text;
			}

			// set data variables...
			$this->data['file'] = 'page';
			$this->data['page_title'] = @$page_details->title ?: 'Made To Order';
			$this->data['page_description'] = $this->webspace_details->site_description;
			
			// load views...
			$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		}
		else
		{
			// create message
			$message = '
				<br /><br />
				Dear Team,
				<br /><br />
				<br /><br />
				A '.$this->webspace_details->name.' "Made To Order" inquiry from this link:<br />'.site_url('made_to_order').'
				<br /><br />
				<strong>Name:</strong> '.$this->input->post('name').'<br />
				<strong>Primary Email:</strong> '.$this->input->post('email').'<br />
				<strong>Secondary Email:</strong> '.$this->input->post('email2').'<br />
				<br /><br />
				<strong>Message:</strong><br />'.$this->input->post('opt_item').'<br />
				<br /><br />
				<strong>NOTES (if any):</strong><br />'.$this->input->post('comments').'<br />
				<br /><br />
				<br /><br />
				Thank you very much!
			';
			
			if (ENVIRONMENT == 'development') // ---> used for development purposes
			{
				// we are unable to send out email in our dev environment
				// so we check on the email template instead.
				// just don't forget to comment these accordingly
				echo $message;
				echo '<br /><br />';
				
				$_SESSION['made_to_order_send_success'] = TRUE;
				$this->session->mark_as_flash('made_to_order_send_success');
				
				echo '<a href="'.site_url('made_to_order').'">Continue...</a>';
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
				
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($this->webspace_details->info_email);
				
				$this->email->subject($this->webspace_details->name.' - Made To Order Inquiry');
				$this->email->message($message);
				
				$this->email->send();
				
				// set flash notice
				$_SESSION['made_to_order_send_success'] = TRUE;
				$this->session->mark_as_flash('made_to_order_send_success');
				
				// redirect user
				redirect('made_to_order', 'location');
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
	
}