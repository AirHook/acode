<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_product_item_invite extends Admin_Controller {

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
	 * Index - Send Product Item Invite
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...<br />';
		
		if ( ! $this->input->post())
		{
			// return with no id error
		}
		
		// load classes - library/helpers/models
		$this->load->helpers('product_link');
		$this->load->library('email');
		$this->load->library('users/consumer_user_details');
		
		// initialize user details
		if ( ! $this->consumer_user_details->initialize(array('user_id'=>$this->input->post('user_id'))))
		{
			// invalid user information
		}
		
		$this->email->clear();
		
		// do the email headers
		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
		//$this->email->cc($this->config->item('info_email'));
		$this->email->bcc($this->webspace_details->info_email.', '.$this->config->item('dev1_email'));

		// create a simepl HTML message
		$message = 'Dear '.$this->input->post('username');
		$message .= '<br /><br />';
		$message .= $this->input->post('message');
		$message .= '<br /><br />';
		$message .= '<a href="'.str_replace('https', 'http', site_url(link_to_product_details($this->input->post('style_no')))).'">';
		$message .= '<img src="'.src_to_thumbs($this->input->post('style_no'), '1').'" />';
		$message .= '</a>';
		$message .= '<br />';
		$message .= 'LINK:';
		$message .= '<br />';
		$message .= str_replace('https', 'http', site_url(link_to_product_details($this->input->post('style_no'))));
		$message .= '<br /><br />';
		$message .= '<br /><br />';
		$message .= $this->consumer_user_details->designer.'<br />';
		$message .= '230 West 38th Street<br />';
		$message .= 'New York, NY 10018<br />';
		$message .= '1-212-840-0846<br />';

		// to and subject
		$this->email->subject('PRODUCT ITEM INVITE');
		$this->email->to($this->consumer_user_details->email);
		
		// message
		$this->email->message($message);
		
		// send email
		if (ENVIRONMENT === 'development') 
		{
			$params['product_item_invite'] = time();
			$this->consumer_user_details->update_options($params);
			$this->session->set_flashdata('success', 'send_product_item_invite');
			echo 'Dev <br />';
			echo $message;
			echo '<br />';
			echo '<br />';
			echo '<a href="'.site_url($this->config->slash_item('admin_folder').'users/consumer').'">continue...</a>';
			echo '<br />';
			echo '<br />';
			echo '<pre>';
			//print_r($data);
			die();
		}
		else
		{
			if ( ! $this->email->send())
			{
				$this->error .= 'Unable to send to - "'.$email.'"<br />';
				
				return FALSE;
			}
		}
		
		$params['product_item_invite'] = time();
		$this->consumer_user_details->update_options($params);
		
		// set flash data
		$this->session->set_flashdata('success', 'send_product_item_invite');
		
		// redirect user
		redirect($this->input->post('return_uri'), 'location');
	}
	
	// ----------------------------------------------------------------------
	
}