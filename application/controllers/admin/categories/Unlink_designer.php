<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unlink_designer extends Admin_Controller {

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
	 * Index - UnLink a designer from the category
	 *
	 * @return	void
	 */
	public function index($category_id = '', $designer = '')
	{
		if ( ! $category_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories', 'location');
		}
		
		if ( ! $designer)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories/edit/index/'.$category_id, 'location');
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
		$this->category_details->initialize(array('category_id' => $category_id));
		$linked_designers = 
			is_array($this->category_details->linked_designers) 
			? $this->category_details->linked_designers 
			: explode(',', $this->category_details->linked_designers)
		;
		
		// check if icons images is assoc
		$is_assoc = $this->_is_assoc($linked_designers);
		
		// UN-link from linked_designers
		// since this is unlinking already, that means $linked_designer is never empty
		if ($is_assoc)
		{
			if (isset($linked_designers[$designer])) unset($linked_designers[$designer]);
		}
		else
		{
			$key = array_search($designer, $linked_designers);
			// in case linked designer is in middle of array
			// assigning blank to it is a must
			$linked_designers[$key] = '';
		}
		
		// set post_ary data before updating db
		if ($is_assoc) $post_ary['d_url_structure'] = json_encode($linked_designers);
		else $post_ary['d_url_structure'] = implode(',', $linked_designers);
		
		// unset unneeded variables
		if (isset($post_ary['link_designer'])) unset($post_ary['link_designer']);
		if (isset($post_ary['category_id'])) unset($post_ary['category_id']);
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// update records
		$DB->where('category_id', $category_id);
		$DB->update('categories', $post_ary);
		
		// set flash data
		$this->session->set_userdata('active_category_tab', 'general');
		$this->session->set_userdata('active_linked_designer_tab', 'general');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'categories/edit/index/'.$category_id, 'location');
	}
	
	// ----------------------------------------------------------------------
	
	private function _is_assoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	// ----------------------------------------------------------------------
	
}