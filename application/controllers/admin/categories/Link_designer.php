<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link_designer extends Admin_Controller {

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
	 * Index - Link a new designer to the category
	 *
	 * @return	void
	 */
	public function index()
	{
		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('categories/categories');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/category_details');
		
		// lets capture the input data
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process/add some variables
		$this->category_details->initialize(array('category_id' => $post_ary['category_id']));
		$linked_designers = 
			is_array($this->category_details->linked_designers) 
			? $this->category_details->linked_designers 
			: explode(',', $this->category_details->linked_designers)
		;
		
		// check if icons images is assoc
		$is_assoc = $this->_is_assoc($linked_designers);
		
		// set linked_designers
		if (empty($linked_designers))
		{
			if ($is_assoc) $linked_designers = array($post_ary['link_designer']=>$post_ary['link_designer']);
			else $linked_designers = array($post_ary['link_designer']);
		}
		else
		{
			if ($is_assoc) $linked_designers[$post_ary['link_designer']] = $post_ary['link_designer'];
			else array_push($linked_designers, $post_ary['link_designer']);
		}
		
		// set post_ary data before updating db
		if ($is_assoc) $post_ary['d_url_structure'] = json_encode($linked_designers);
		else $post_ary['d_url_structure'] = implode(',', $linked_designers);
		
		// unset unneeded variables
		unset($post_ary['link_designer']);
		unset($post_ary['category_id']);
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// update records
		$DB->where('category_id', $this->input->post('category_id'));
		$DB->update('categories', $post_ary);
		
		// set flash data
		//$this->session->set_userdata('active_category_tab', ($this->input->post('link_designer') ?: 'general'));
		//$this->session->set_userdata('active_linked_designer_tab', ($this->input->post('link_designer') ?: 'general'));
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'categories/edit/index/'.$this->input->post('category_id'), 'location');
	}
	
	// ----------------------------------------------------------------------
	
	private function _is_assoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	// ----------------------------------------------------------------------
	
}