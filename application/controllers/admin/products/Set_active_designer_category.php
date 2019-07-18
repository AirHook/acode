<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_active_designer_category extends Admin_Controller {

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
	 * Index - Primary function of the class
	 *
	 * @return	void
	 */
	public function index()
	{
		// set flash data
		if ($this->input->post('designer')) 
			$this->session->set_userdata('active_designer', $this->input->post('designer'));
		if ($this->input->post('category')) 
			$this->session->set_userdata('active_category', $this->input->post('category'));
		if ($this->input->post('categories[]')) 
			$this->session->set_userdata('active_category', $this->input->post('categories[]'));
		if ($this->input->post('order_by')) 
			$this->session->set_userdata('order_by', $this->input->post('order_by'));
		if ($this->input->post('view_as')) 
			$this->session->set_userdata('view_as', $this->input->post('view_as'));
		
		// redirect user
		if ($this->input->post('set-from') === 'product_csv')
		{
			if ($this->input->post('uri_string')) 
				redirect($this->input->post('uri_string'), 'location');
			else redirect($this->config->slash_item('admin_folder').'products/csv', 'location');
		}
		else 
		{
			if ($this->input->post('uri_string')) redirect($this->input->post('uri_string'), 'location');
			redirect($this->config->slash_item('admin_folder').'products', 'location');
		}
	}
	
	// ----------------------------------------------------------------------
	
}