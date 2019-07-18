<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Admin_Controller {

	/**
	 * database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Linkme - Link a select account to webspace
	 *
	 * @return	void
	 */
	public function linkme($id = '')
	{
		echo 'Processing...';
		
		if ( ! $id OR ! $this->input->post('account_id'))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces');
		}
		
		// assign new account to webspace
		$this->DB->set('account_id', $this->input->post('account_id'));
		$this->DB->where('webspace_id', $id);
		$udpate = $this->DB->update('webspaces');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		if ($this->input->post('account_add_from') === 'webspace_edit')
		{
			redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$id);
		}
		else
		{
			redirect($this->config->slash_item('admin_folder').'settings/general');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Add - Add New Account and link to webspace
	 *
	 * @return	void
	 */
	public function add($id = '')
	{
		echo 'Processing...';
		
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'webspaces');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('account_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Account/Company Name', 'trim|required');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'trim|required');
		$this->form_validation->set_rules('owner_email', 'Owner Email', 'trim|required|callback_validate_email');
		
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('zip', 'Zip Code', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			// set flash data
			$this->session->set_flashdata('error', 'webspace_account_add');
			
			// redirect user
			if ($this->input->post('account_add_from') === 'webspace_edit')
			{
				redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$id);
			}
			else
			{
				redirect($this->config->slash_item('admin_folder').'settings/general');
			}
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// unset unneeded variables
			unset($post_ary['passconf']);
			unset($post_ary['account_add_from']);
			// process database
			$query = $this->DB->insert('accounts', $post_ary);
			$insert_id = $this->DB->insert_id();
			
			// assign new account to webspace
			$this->DB->set('account_id', $insert_id);
			$this->DB->where('webspace_id', $id);
			$udpate = $this->DB->update('webspaces');
			
			// set flash data
			$this->session->set_flashdata('success', 'edit');
			
			// redirect user
			if ($this->input->post('account_add_from') === 'webspace_edit')
			{
				redirect($this->config->slash_item('admin_folder').'webspaces/edit/index/'.$id);
			}
			else
			{
				redirect($this->config->slash_item('admin_folder').'settings/general');
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
	
}